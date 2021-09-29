<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\Cart;
use App\Models\Contact;
use App\Models\FrontUser;
use App\Models\UserField;
use App\Models\Promocode;
use App\Models\PromocodeType;
use PDF;
use Session;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $toValidate = [];

        $uniquefields = UserField::where('in_cart', 1)->where('unique_field', 1)->get();

        $requiredfields = UserField::where('in_cart', 1)->where('required_field', 1)->get();

        if(count($requiredfields) > 0) {
            foreach ($requiredfields as $requiredfield) {
                if($requiredfield->field == 'name' || $requiredfield->field == 'surname') {
                    $toValidate[$requiredfield->field] = 'required|min:3';
                } else {
                    $toValidate[$requiredfield->field] = 'required';
                }
            }
        }

        $toValidate['payment'] = 'required';

        if(Auth::guard('persons')->guest()) {
            $client = new Client;
            // $response = $client->request('POST', 'https://www.google.com/recaptcha/api/siteverify', [
            //         'form_params' => [
            //             'secret' => env('RE_CAP_SECRET'),
            //             'response' => request('g-recaptcha-response'),
            //             'remoteip' => request()->ip()
            //         ]
            // ]);

            // if(!json_decode($response->getBody())->success) {
                // $toValidate['captcha'] = 'required';
            // }

            if(count($uniquefields) > 0) {
                foreach ($uniquefields as $uniquefield) {
                    if($uniquefield->field == 'email') {
                        $toValidate[$uniquefield->field] = 'required|unique:front_users|email';
                    } else {
                        $toValidate[$uniquefield->field] = 'required|unique:front_users';
                    }
                }
            }

            $cartProducts = $this->getCartProducts($_COOKIE['user_id']);
        } else {
            $user = FrontUser::find(Auth::guard('persons')->id());
            unset($toValidate['terms_agreement']);
            if(count($uniquefields) > 0) {
                foreach ($uniquefields as $uniquefield) {
                    if($uniquefield->field == 'email') {
                        $toValidate[$uniquefield->field] = 'required|email';
                    } else {
                        $toValidate[$uniquefield->field] = 'required';
                    }
                }
            }
            $cartProducts = $this->getCartProducts($user->id);
        }

        if(count($cartProducts) == 0) {
          $toValidate['emptyCart'] = 'required';
        }

        $checkStock = $this->checkStock($cartProducts);
        if($checkStock) {
          return redirect()->back()->withInput();
        }

        $validator = $this->validate(request(), $toValidate);

        $order = $this->orderProducts($request->all(), $cartProducts);

        return redirect()->route('home')->withSuccess('success');
    }

    private function createClient($password) {
        $user = FrontUser::create([
            'is_authorized' => 0,
            'lang' => 1,
            'name' => request('name') ? request('name') : '',
            'surname' => request('surname') ? request('surname') : '',
            'email' => request('email') ? request('email') : '',
            'phone' => request('phone') ? request('phone') : '',
            'password' => bcrypt($password),
            'terms_agreement' => request('terms_agreement') ? 1 : 0,
            'promo_agreement' => request('promo_agreement') ? 1 : 0,
            'personaldata_agreement' => request('personaldata_agreement') ? 1 : 0,
            'remember_token' => request('_token')
        ]);

        return $user;
    }

    private function createPromocode($promoType, $userId) {
        $promocode = Promocode::create([
          'name' => 'repeated'.'repeated'.str_random(5),
          'type_id' => $promoType->id,
          'discount' => $promoType->discount,
          'valid_from' => date('Y-m-d'),
          'valid_to' => date('Y-m-d', strtotime(' + '.$promoType->period.' days')),
          'period' => $promoType->period,
          'treshold' => $promoType->treshold,
          'to_use' => 0,
          'times' => $promoType->times,
          'status' => 'valid',
          'user_id' => $userId
        ]);

        return $promocode;
    }

    private function createOrder($userId, $amount, $promocode, $cartProducts) {
        $order = Order::create([
            'user_id' => $userId,
            'address_id' => 0,
            'is_logged' => 1,
            'amount' => $amount,
            'status' => 'pending',
            'secondarystatus' => 'confirmed',
            'paymentstatus' => 'notpayed',
            'payment' => request('payment'),
            'promocode_id' => count($promocode) > 0 ? $promocode->id : 0
        ]);

        foreach ($cartProducts as $key => $cartProduct):
             $order->orderProducts()->create([
               'product_id' => $cartProduct->product_id,
               'subproduct_id' => $cartProduct->subproduct_id,
               'qty' => $cartProduct->qty
             ]);
        endforeach;

        return $order;
    }

    private function sendMessage($user, $promocode, $password) {
        $to = request('email');

        $subject = trans('auth.register.subject');

        if(Auth::guard('persons')->check()) {
            $message = '
              <p>Buna ziua,'.$user->name.' '.$user->surname.'</p>,
              <p>Dvs. v-ati inregistrat pe site-ul '.getContactInfo('site')->translationByLanguage()->first()->value.'</p>.
              <p>In curind va contactam pentru a procesa comanda Dvs.</p>

              <p>Pentru a vedea statutul comenzii, invoice-ul generat, detaliile serviciului comandat si alte detalii, va invitam sa intrati in Client Area:</p>

              <p><a href="http://itmall.land/platform/clientarea.php">GO TO CLIENT AREA</a></p>

              <p>Enter coupon code '.$promocode->name.', when you make your next purchase of '.$promocode->treshold.' euro or more before '.$promocode->valid_to.' and enjoy '.$promocode->discount.'% off.

              <p>Va multumim!</p>

              <p>'.getContactInfo('adminname')->translationByLanguage()->first()->value.'</p>
              <p>'.getContactInfo('emailadmin')->translationByLanguage()->first()->value.'</p>
              <p>Tel: '.getContactInfo('phone')->translationByLanguage()->first()->value.'</p>
              <p>Facebook: '.getContactInfo('facebook')->translationByLanguage()->first()->value.'</p>
            ';

            $data['user']  = $user;
            $data['promocode']  = $promocode;

            Mail::send('front.emails.sendMessageAuth', $data, function($message)
            {
                $message->to('iovitatudor@gmail.com', 'digitalmall.md')->from('admin@digitalmall.md')->subject(trans('auth.register.subject'));
            });
        } else {
          $message = '
              <p>Buna ziua,'.$user->name.' '.$user->surname.'</p>,
              <p>Dvs. v-ati inregistrat pe site-ul '.getContactInfo('site')->translationByLanguage()->first()->value.'</p>.
              <p>In curind va contactam pentru a procesa comanda Dvs.</p>

              <p>Cu aceeasi ocazie va informam, ca vi s-a creat cont la noi pe site. Avind cont personal, va puteti loga in cabinetul Dvs. personal si beneficia de mai multe optiuni:</p>
              <p>1. Redactarea datelor personale</p>
              <p>2. Vizualizarea istoriei de comenzi (inclusiv de a vedea la care etapa de procesare este comanda curenta)</p>
              <p>3. Vizualiazarea produselor din Wishlist</p>
              <p>4. Solicitarea returului pe produse comandate</p>

              <p>Mai jos sunt datele de acces:</p>

              <p>Login: '.$user->email.'</p>
              <p>Parola: '.$password.'</p>

              <p>Daca doriti sa schimbati parola, apasati pe urmatorul <a href=digitalmall.md/'.request()->segment(1)."/register/changePass/".session('token').'>link</a></p>

              <p>Enter coupon code '.$promocode->name.', when you make your next purchase of '.$promocode->treshold.' euro or more before '.$promocode->valid_to.' and enjoy '.$promocode->discount.'% off.

              <p>Va multumim!</p>

              <p>'.getContactInfo('adminname')->translationByLanguage()->first()->value.'</p>
              <p>'.getContactInfo('emailadmin')->translationByLanguage()->first()->value.'</p>
              <p>Tel: '.getContactInfo('phone')->translationByLanguage()->first()->value.'</p>
              <p>Facebook: '.getContactInfo('facebook')->translationByLanguage()->first()->value.'</p>
          ';
        }

        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";

        mail($to, $subject, $message, $headers);


        // $data['user']  = $user;
        // $data['password']  = $password;
        // $data['promocode']  = $promocode;
        //
        // Mail::send('front.emails.sendMessageGuest', $data, function($message)
        // {
        //     $message->to('iovitatudor@gmail.com', 'digitalmall.md')->from('admin@digitalmall.md')->subject(trans('auth.register.subject'));
        // });

    }

    private function sendMessageToAdmin($order) {
        // $to = 'likemediamd10@gmail.com';
        // $to = 'digitalmallmd@gmail.com';
        // $to = 'iovitatudor@gmail.com';

        $subject = trans('auth.register.subject');

        foreach ($order->orderProducts as $orderProduct) {
          $products[] = $orderProduct->product->translationByLanguage($this->lang->id)->first()->name;
        }

        // $message = '
        //   <p>Email to admin New order</p>
        //   <p>New order from '.getContactInfo('site')->translationByLanguage()->first()->value.'</p>
        //
        //   <p>Hello, '.getContactInfo('adminname')->translationByLanguage()->first()->value.'</p>
        //   <p>New order details:</p>
        //   <p>Products: '.implode(',', $products).'</p>
        //
        //   <p>Date: '.date('d m Y H:i:s', strtotime($order->created_at)).'</p>
        //   <p>Order amount: '.$order->amount.' lei</p>
        //   <p>Client email: '.$order->userLogged->first()->email.'</p>
        //
        //   <p>Success!</p>
        // ';
        //
        // $headers  = 'MIME-Version: 1.0' . "\r\n";
        // $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
        //
        // mail($to, $subject, $message, $headers);

        $data['order']      = $order;
        $data['products']   = $products;
        $data['order']      = $order;

        $status = Mail::send('front.emails.sendMessageToAdmin', $data, function($message)
        {
            $message->to('digitalmallmd@gmail.com', 'digitalmall.md')->from('admin@digitalmall.md')->subject(trans('auth.register.subject'));
        });

    }

    private function updateClient() {
        $user = FrontUser::find(Auth::guard('persons')->id());
        $user->name = request('name');
        $user->surname = request('surname');
        $user->email = request('email');
        $user->phone = request('phone');

        $user->save();

        return $user;
    }

    private function checkStock($cartProducts){

        if (count($cartProducts) > 0) {

            foreach ($cartProducts as $key => $cartProduct) {

                if (!is_null($cartProduct->product)) {
                    if ($cartProduct->product->stock == 0) {
                        return [
                            'type' => 'produs',
                            'name' => $cartProduct->product->translationByLanguage($this->lang->id)->first()->name,
                            'id' => $cartProduct->product->id,
                        ];
                    }
                }
            }
        }

        return false;
    }

    private function checkPromo($amount) {
      $promocode = Promocode::where('id', @$_COOKIE['promocode'])
                              ->where('treshold', '<', $amount)
                              ->whereRaw('to_use < times')
                              ->where(function($query) {
                                  $query->where('status', 'valid');
                                  $query->orWhere('status', 'partially');
                              })
                              ->first();
      if(count($promocode) > 0) {
          if($promocode->user_id !== 0) {
              if(Auth::guard('persons')->guest()) {
                  return false;
              } else if(Auth::guard('persons')->check() && $promocode->user_id !== Auth::guard('persons')->id()) {
                  return false;
              }
          }
          $amount = $amount - ($amount * $promocode->discount / 100);
          $promocode->to_use += 1;
          $promocode->save();
      }

      return $amount;
    }

    private function orderProducts($request, $cartProducts) {
        $amountWithOutPromo = $this->getAmount($cartProducts);

        if (!$this->checkPromo($amountWithOutPromo)) {
          $amount = $amountWithOutPromo;
        } else {
          $amount = $this->checkPromo($amountWithOutPromo);
        }

        $promoType = PromocodeType::find(4);

        if(Auth::guard('persons')->check()) {
            $user = $this->updateClient();

            $promocode = $this->createPromocode($promoType, $user->id);

            $order = $this->createOrder($user->id, $amount, $promocode, $cartProducts);

            Cart::where('user_id', Auth::guard('persons')->id())->delete();

            $this->sendMessage($user, $promocode, '');

        } else {
            $password = str_random(12);

            $user = $this->createClient($password);

            $promocode = $this->createPromocode($promoType, $user->id);

            $order = $this->createOrder($user->id, $amount, $promocode, $cartProducts);

            session()->put(['token' => str_random(60), 'user_id' => $user->id]);

            Cart::where('user_id', @$_COOKIE['user_id'])->delete();

            $this->sendMessage($user, $promocode, $password);

            Auth::guard('persons')->login($user);
        }

        $this->sendMessageToAdmin($order);

        return $order;
    }

    private function getAmount($cartProducts) {
        $amount = 0;
        foreach ($cartProducts as $key => $cartProduct):
          $price = $cartProduct->product->price - ($cartProduct->product->price * $cartProduct->product->discount / 100);

          if($price) {
            $amount +=  $price * $cartProduct->qty;
          }
        endforeach;

        return $amount;
    }

    private function getCartProducts($id) {
       $rows = Cart::where('user_id', $id)->get();
       return $rows;
    }

}
