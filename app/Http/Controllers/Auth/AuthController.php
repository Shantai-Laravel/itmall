<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\WishList;
use App\Models\FrontUser;
use Socialite;
use Session;
use App\Models\UserField;
use App\Models\Lang;

class AuthController extends Controller
{
  public function create()
  {
      $userfields = UserField::where('in_auth', 1)->get();

      return view('auth.front.login', compact('userfields'));
  }

  public function store()
  {
      $toValidate = [];

      $uniquefields = UserField::where('in_auth', 1)->get();

      if(count($uniquefields) > 0) {
          foreach ($uniquefields as $uniquefield) {
              if($uniquefield->field == 'email') {
                  $toValidate[$uniquefield->field] = 'required|email';
              } else {
                  $toValidate[$uniquefield->field] = 'required';
              }
          }
      }

      $toValidate['password'] = 'required';

      $validator = $this->validate(request(), $toValidate);

      if (Auth::guard('persons')->attempt(request()->except('_token', 'prev'))) {
          $this->checkWishList(Auth::guard('persons')->id());
          $this->checkCart(Auth::guard('persons')->id());
          $this->checkStockOfCart(Auth::guard('persons')->id());

          return redirect()->route('home');
      }
      else {
          return redirect()->back()->withErrors(['authErr' => [trans('auth.email')]]);
      }
  }

  public function logout()
  {
      Auth::guard('persons')->logout();

      return redirect()->route('home');
  }

  public function redirectToProvider($provider)
  {
        return Socialite::driver($provider)->redirect();
  }

  public function handleProviderCallback($provider)
  {
        $user = Socialite::driver($provider)->user();
        $authUser = FrontUser::where('email', $user->getEmail())->first();

        if (count($authUser) > 0) {
            $this->checkCart($authUser->id);
            $this->checkWishList($authUser->id);
        } else {
            $username = explode(' ', $user->getName());

            $authUser = FrontUser::create([
                'lang' => 1,
                'name' => count($username) > 0 ? $username[0] : $user->getName(),
                'surname' => count($username) > 1 ? $username[1] : '',
                'email' => $user->getEmail(),
                'remember_token' => $user->token
            ]);

            $to = $user->getEmail();

            $subject = trans('auth.register.subject');

            session()->put(['token' => str_random(60), 'user_id' => $authUser->id]);

            $message = 'digitalmall.md/'.request()->segment(1).'/register/authorizeUser/'.session('token');
            $headers  = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text; charset=utf-8' . "\r\n";

            mail($to, $subject, $message, $headers);
        }

        Auth::guard('persons')->login($authUser);

        return redirect()->route('home');
  }

  private function checkCart($user_id) {
      $products = Cart::where('user_id', @$_COOKIE['user_id'])->get();
      $products_id = Cart::where('user_id', $user_id)->pluck('product_id')->toArray();

      if(count($products) > 0) {
          Session::flash('message', 'Nu uita că ai articole suplimentare în coș dintr-o vizită anterioară pe site.');
          foreach ($products as $key => $product) {
              if(in_array($product->product_id, $products_id)) {

                  Cart::where('id', $product->id)->delete();
                  Cart::where('user_id', $user_id)->where('product_id', $product->product_id)->increment('qty', $product->qty);

              } else {
                  Cart::where('id', $product->id)->update([
                        'is_logged' => 1,
                        'user_id' => $user_id
                  ]);
              }
          }
      }
  }

  public function checkStockOfCart($user_id){
      $cartProducts = Cart::where('user_id', $user_id)->get();
      $message = "Unul sau mai multe dintre articolele din coșul dvs. de cumpărături sunt vândute. Mutați-le la favoritele dvs. pentru a le putea urmări, ar putea să revină în stoc.";
      if (count($cartProducts) > 0) {
          foreach ($cartProducts as $key => $cartProduct) {
              if (is_null($cartProduct->product)) {
                  if ($cartProduct->product->stock == 0) {
                      Session::flash('messageStok', $message);
                      return flase;
                  }
              }
          }
      }

      return true;
  }

  private function checkWishList($user_id) {
      $products = WishList::where('user_id', @$_COOKIE['user_id'])->get();
      if(count($products) > 0) {
          foreach ($products as $key => $product) {
              WishList::where('id', $product->id)->update([
                    'is_logged' => 1,
                    'user_id' => $user_id
              ]);
          }
      }
  }

}
