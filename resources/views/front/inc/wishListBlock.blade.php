@if (count($wishListProducts) > 0)
    <div class="col-12">
       {{count($wishListProducts)}} {{trans('front.header.products')}}
    </div>
    @foreach ($wishListProducts as $wishListProduct)
        <div class="col-12">
           <div class="wishItem">
              <div class="row">
                 <div class="col-md-3 col-sm-4 col-5">
                     @if ($wishListProduct->product->mainImage()->first())
                         <img id="prOneBig1" src="{{ asset('images/products/og/'.$wishListProduct->product->mainImage()->first()->src ) }}">
                     @else
                         <img src="{{ asset('fronts/img/products/noimage.png') }}" alt="img-advice">
                     @endif
                 </div>
                 <div class="col-lg-2 col-md-3 col-sm-4 col-7">
                    <div class="denWish">{{$wishListProduct->product->translationByLanguage($lang->id)->first()->name}}</div>
                    <div class="txtWish">{{$wishListProduct->product->price}} euro <br> <span>{{trans('front.cart.billed')}}: {{trans('front.cart.monthly')}}</span></div>
                 </div>
                 <div class="offset-lg-1 offset-mg-0 col-md-5 col-sm-4 col-12">
                   <div class="buttCart">
                     <a class="moveFromWishListToCart" data-id="{{$wishListProduct->product_id}}">{{trans('front.cart.addToCart')}}</a>
                   </div>
                 </div>
                 <div class="col-md-1 col-12 posAbsoluteX">
                    <div class="deletItem deleteFromWishList" data-id="{{$wishListProduct->id}}"></div>
                 </div>
              </div>
           </div>
        </div>
    @endforeach
@else
    <div class="emptyCart">
      {{trans('front.cart.notAdded')}}
    </div>
@endif
