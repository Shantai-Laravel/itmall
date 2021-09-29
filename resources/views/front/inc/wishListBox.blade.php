@if (count($wishListProducts) > 0)
    @foreach ($wishListProducts as $wishListProduct)
        <div class="row cartMenuItem">
          <div class="col-4">
            @if ($wishListProduct->product->mainImage()->first())
                <img id="prOneBig1" src="{{ asset('images/products/og/'.$wishListProduct->product->mainImage()->first()->src ) }}">
            @else
                <img src="{{ asset('fronts/img/products/noimage.png') }}" alt="img-advice">
            @endif
          </div>
          <div class="col-6 descrItem">
            <div>
              <a href="{{ url($lang->lang.'/catalog/'.getParentCategory($wishListProduct->product->category_id, $lang->id).'/'.$wishListProduct->product->alias ) }}">{{$wishListProduct->product->translationByLanguage($lang->id)->first()->name}}</a>
            </div>
            <div>1 x {{$wishListProduct->product->price}} {{trans('front.cart.currency')}}</div>
          </div>
          <div class="col-2">
            <div class="deleteItem deleteFromWishList" data-product_id="{{$wishListProduct->product->id}}" data-id="{{$wishListProduct->id}}">

            </div>
          </div>
        </div>
    @endforeach
@else
<div class="emptyCart">
  {{trans('front.cart.notAdded')}}
</div>
@endif
