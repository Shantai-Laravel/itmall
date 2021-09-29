<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lang;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductImage;
use App\Models\Cart;
use App\Models\WishList;
use App\Models\Promocode;
use App\Models\FrontUser;
use App\Models\SubProduct;
use App\Models\UserField;
use App\Models\General;
use Session;


class CartController extends Controller
{
    public function index() {
        $userCart = $this->checkIfLogged();

        $cartProducts = Cart::where('user_id', $userCart['user_id'])->get();

        $userdata = FrontUser::where('id', auth('persons')->id())->first();

        $userfields = UserField::where('in_cart', 1)->get();

        $loginFields = UserField::where('in_auth', 1)->get();

        $generalFields = General::all();

        unset($_COOKIE['promocode']);
        setcookie("promocode", "", time()-3600);

        if (!@$_COOKIE['promocode']) {
            setcookie('promocode', "", time() + 10000000, '/');
        }

        session()->forget('promocode');

        $promocode = Promocode::where('id', @$_COOKIE['promocode'])
                                ->where(function($query){
                                    $query->where('status', 'valid');
                                    $query->orWhere('status', 'partially');
                                })
                                ->first();


        if (view()->exists('front/orders/cart')) {
            return view('front.orders.cart', compact('cartProducts', 'generalFields', 'userdata', 'userfields', 'loginFields', 'promocode'));
        }else{
            echo "view for cart is not found";
        }
    }

    public function changeQtyPlus(Request $request) {
        $userCart = $this->checkIfLogged();
        $cartItem = Cart::where('user_id', $userCart['user_id'])->where('product_id', $request->get('id'))->first();

        if (!is_null($cartItem)) {
            Cart::where('id', $cartItem->id)->update([
                'qty' => $cartItem->qty + 1,
            ]);
        }

        $cartProducts = Cart::where('user_id', $userCart['user_id'])->get();
        $cartCount = count($cartProducts);

        $data['cartBlock'] = view('front.inc.cartBlock', compact('cartProducts'))->render();
        $data['cartBox'] = view('front.inc.cartBox', compact('cartProducts'))->render();
        $data['cartCount'] = view('front.inc.cartCount', compact('cartCount'))->render();

        return json_encode($data);
    }

    public function changeQtyMinus(Request $request) {
        $userCart = $this->checkIfLogged();
        $cartItem = Cart::where('user_id', $userCart['user_id'])->where('product_id', $request->get('id'))->first();

        if (!is_null($cartItem)) {
            Cart::where('id', $cartItem->id)->update([
                'qty' => $cartItem->qty >= 2 ? $cartItem->qty - 1 : 1,
            ]);
        }

        $cartProducts = Cart::where('user_id', $userCart['user_id'])->get();
        $cartCount = count($cartProducts);

        $data['cartBlock'] = view('front.inc.cartBlock', compact('cartProducts'))->render();
        $data['cartBox'] = view('front.inc.cartBox', compact('cartProducts'))->render();
        $data['cartCount'] = view('front.inc.cartCount', compact('cartCount'))->render();

        return json_encode($data);
    }

    public function removeItemCart(Request $request) {
        $userCart = $this->checkIfLogged();
        $cartItem = Cart::where('user_id', $userCart['user_id'])->where('id', $request->get('id'))->first();

        if (!is_null($cartItem)) {
            Cart::where('id', $cartItem->id)->delete();
        }

        $cartProducts = Cart::where('user_id', $userCart['user_id'])->get();

        $promocode = Promocode::where('id', @$_COOKIE['promocode'])
                                ->where(function($query){
                                    $query->where('status', 'valid');
                                    $query->orWhere('status', 'partially');
                                })->first();

        $cartProducts = Cart::where('user_id', $userCart['user_id'])->get();
        $cartCount = count($cartProducts);

        $data['cartBlock'] = view('front.inc.cartBlock', compact('cartProducts'))->render();
        $data['cartBox'] = view('front.inc.cartBox', compact('cartProducts'))->render();
        $data['cartCount'] = view('front.inc.cartCount', compact('cartCount'))->render();

        return json_encode($data);
    }

    public function addToCart(Request $request)
    {
        $user_id =  $this->checkIfLogged();

        $product = Product::find($request->get('id'));

        if(count($product) > 0 && $product->stock > 0) {
            $cart = Cart::where('user_id', $user_id['user_id'])->where('product_id', $request->get('id'))->first();

            if (is_null($cart)) {
                Cart::create([
                    'product_id' => $product->id,
                    'subproduct_id' => 0,
                    'user_id' => $user_id['user_id'],
                    'qty' => $request->get('qty') ?? 1,
                    'is_logged' => $user_id['is_logged']
                ]);
            } else {
              $cart->qty += 1;
              $cart->save();
            }
        } else {
          return response()->json(array(
                'code'      =>  400,
                'message'   =>  'This product is not in stock'
            ), 400);
        }

        $cartProducts = Cart::where('user_id', $user_id['user_id'])->get();
        $cartCount = count($cartProducts);

        $data['cartBlock'] = view('front.inc.cartBlock', compact('cartProducts'))->render();
        $data['cartBox'] = view('front.inc.cartBox', compact('cartProducts'))->render();
        $data['cartCount'] = view('front.inc.cartCount', compact('cartCount'))->render();

        return json_encode($data);
    }

    public function setPromocode(Request $request)
    {
        $userCart =  $this->checkIfLogged();

        $promocode = Promocode::where('name', $request->get('promocode'))
                                ->whereRaw('to_use < times')
                                ->where(function($query){
                                    $query->where('status', 'valid');
                                    $query->orWhere('status', 'partially');
                                })->first();

        if (!is_null($promocode)) {
            $promocodeId = $promocode->id;
        }else{
            $promocodeId = null;
        }

        setcookie('promocode', $promocodeId, time() + 10000000, '/');

        $cartProducts = Cart::where('user_id', $userCart['user_id'])->get();

        Session::flash('promocode', $request->get('promocode'));

        $userdata = FrontUser::where('id', auth('persons')->id())->first();

        $data['cartBlock'] = view('front.inc.cartBlock', compact('cartProducts', 'promocode', 'userdata'))->render();

        return json_encode($data);
    }

    public function moveFromCartToWishList(Request $request)
    {
        $userCart = $this->checkIfLogged();

        $cartProduct = Cart::where('user_id', $userCart['user_id'])->where('product_id', $request->get('product_id'))->where('subproduct_id', $request->get('subproduct_id'))->first();

        if (!is_null($cartProduct)) {
            WishList::create([
                'product_id' => $cartProduct->product_id,
                'subproduct_id' => $cartProduct->subproduct_id,
                'user_id' => $userCart['user_id'],
                'is_logged' => $userCart['is_logged']
            ]);

            $cartProduct->delete();
        }

        $cartProducts = Cart::where('user_id', $userCart['user_id'])->get();

        $data['block'] = view('front.inc.cartBlock', compact('cartProducts'))->render();
        $data['summary'] = view('front.inc.cartSummary', compact('cartProducts'))->render();
        $data['cartBox'] = view('front.inc.cartBox', compact('cartProducts'))->render();
        $data['cartCount'] = count($cartProducts);

        return json_encode($data);
    }

    private function checkIfLogged() {
        if(auth('persons')->guest()) {
          return array('is_logged' => 0, 'user_id' => @$_COOKIE['user_id']);
        } else {
          return array('is_logged' => 1, 'user_id' => auth('persons')->id());
        }
    }

    public function validateProducts()
    {
        $userCart = $this->checkIfLogged();
        $cartProducts = Cart::where('user_id', $userCart['user_id'])->get();
        $errorProducts = [];

        if (count($cartProducts) > 0) {
            foreach ($cartProducts as $key => $cartProduct) {
                if ($cartProduct->subproduct_id > 0) {
                    if ($cartProduct->subproduct->stock < $cartProduct->qty) {
                        $errorProducts[] = $cartProduct->id;
                    }
                }else{
                    if ($cartProduct->product->stock < $cartProduct->qty) {
                        $errorProducts[] = $cartProduct->id;
                    }
                }
            }
        }

        $cartProductsErrors = Cart::where('user_id', $userCart['user_id'])->whereIn('id', $errorProducts)->get();

        if (count($cartProductsErrors) > 0) {
            return json_encode(view('front.modals.modalValidateProducts', compact('cartProductsErrors'))->render());
        }else{
            return "false";
        }
    }
}
