<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lang;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductImage;
use App\Models\Promocode;
use App\Models\FrontUser;
use App\Models\SubProduct;
use App\Models\WishList;
use App\Models\Cart;
use Session;


class WishListController extends Controller
{
    public function index() {
        $userdata = $this->checkIfLogged();
        $wishListProducts = WishList::where('user_id', $userdata['user_id'])->get();

        if (view()->exists('front/orders/wishList')) {
            return view('front.orders.wishList', compact('wishListProducts'));
        }else{
            echo "view for cart is not found";
        }
    }

    public function addToWishList(Request $request)
    {
        $userdata = $this->checkIfLogged();

        $product = Product::find($request->get('id'));

        if (!is_null($product)) {
            $wishlist = WishList::where('user_id', $userdata['user_id'])->where('product_id', $product->id)->first();
            if (is_null($wishlist)) {
                WishList::create([
                    'product_id' => $product->id,
                    'subproduct_id' => 0,
                    'user_id' => $userdata['user_id'],
                    'is_logged' => $userdata['is_logged']
                ]);
            } else {
              $wishlist->delete();
            }
        }

        $wishlistProducts = WishList::where('user_id', $userdata['user_id'])->get();
        $wishListCount = count($wishlistProducts);

        $data['wishListBlock'] = view('front.inc.wishListBlock', compact('wishListProducts'))->render();
        $data['wishListBox'] = view('front.inc.wishListBox', compact('wishListProducts'))->render();
        $data['wishListCount'] = view('front.inc.wishListCount', compact('wishListCount'))->render();

        return json_encode($data);
    }

    public function removeItemWishList(Request $request) {
        $userdata = $this->checkIfLogged();
        $wishlistItem = WishList::where('user_id', $userdata['user_id'])->where('id', $request->get('id'))->first();

        if (!is_null($wishlistItem)) {
            WishList::where('id', $wishlistItem->id)->delete();
        }

        $wishListProducts = WishList::where('user_id', $userdata['user_id'])->get();

        $data['wishListBlock'] = view('front.inc.wishListBlock', compact('wishListProducts'))->render();
        $data['wishListBox'] = view('front.inc.wishListBox', compact('wishListProducts'))->render();
        $data['wishListCount'] = view('front.inc.wishListCount', compact('wishListCount'))->render();

        return json_encode($data);
    }

    public function moveFromWishListToCart(Request $request)
    {
        $userdata = $this->checkIfLogged();

        $product = Product::find($request->get('id'));

        $wishlistProduct = WishList::where('user_id', $userdata['user_id'])->where('product_id', $request->get('id'))->first();
        $cartProduct = Cart::where('user_id', $userdata['user_id'])->where('product_id', $request->get('id'))->first();

        if (!is_null($wishlistProduct) && is_null($cartProduct) && $product->stock > 0) {
            Cart::create([
                'product_id' => $wishlistProduct->product_id,
                'subproduct_id' => 0,
                'user_id' => $userdata['user_id'],
                'qty' => 1,
                'is_logged' => $userdata['is_logged']
            ]);

            $wishlistProduct->delete();
        } else {
          return response()->json(array(
                'code'      =>  400,
                'message'   =>  'This product is not in stock'
            ), 400);
        }

        $wishListProducts = WishList::where('user_id', $userdata['user_id'])->get();
        $wishListCount = count($wishListProducts);

        $cartProducts = Cart::where('user_id', $userdata['user_id'])->get();
        $cartCount = count($cartProducts);

        $data['wishListBlock'] = view('front.inc.wishListBlock', compact('wishListProducts'))->render();
        $data['wishListBox'] = view('front.inc.wishListBox', compact('wishListProducts'))->render();
        $data['wishListCount'] = view('front.inc.wishListCount', compact('wishListCount'))->render();
        $data['cartBox'] = view('front.inc.cartBox', compact('cartProducts'))->render();
        $data['cartCount'] = view('front.inc.cartCount', compact('cartCount'))->render();

        return json_encode($data);
    }

    private function checkIfLogged() {
        if(auth('persons')->guest()) {
          return array('is_logged' => 0, 'user_id' => $_COOKIE['user_id']);
        } else {
          return array('is_logged' => 1, 'user_id' => auth('persons')->id());
        }
    }
}
