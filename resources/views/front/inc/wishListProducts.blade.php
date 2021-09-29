@php $filterSubproduct = []; @endphp
@if (count($dependebleProps) > 0)
    @foreach ($dependebleProps as $key => $prop)
        @php
            $filterSubproduct[$key] = @$filter[$product->id.$key]
        @endphp
    @endforeach
@endif

<div class="col-3 text-center">
  @if (getMainProductImage($product->id, $lang->id))
   @php $image = getMainProductImage($product->id, $lang->id) @endphp
   <img src="{{ asset('images/products/og/'.$image->src) }}" alt="{{$image->alt}}" title="{{$image->title}}" class="itemImg">
  @else
      <img src="{{ asset('/upfiles/no-image.png') }}">
  @endif
</div>
<div class="col-8">
<div class="denWish">{{$product->translationByLanguage($lang->id)->first()->name}}</div>
<div class="txtWish">{{trans('front.wishList.stock')}}
  <span>
    @if ($product->stock > 0)
      {{trans('front.wishList.stockYes')}}
      {{$product->stock}}
    @else
        {{trans('front.cart.productNotExist')}}
      {{-- {{trans('front.wishList.stockNo')}} --}}
    @endif
  </span>
</div>
<div class="txtWish">{{trans('front.wishList.cod')}} <strong>{{$product->code}}</strong></div>
<div class="colorWish">
  {{-- Black --}}
</div>
<div class="row">
  <div class="col-5 bm">
    <div class="selWish">
        @if (count($product->category->properties) > 0)
            @foreach ($product->category->properties as $key => $prop)
            <div class="col-md-6 prop-items">
                <label for="">
                    {{ $prop->property->translationByLanguage($lang->id)->first()->name }}:
                </label>
                <select class="subproductSelectWishList">
                    <option value="">Alege {{ $prop->property->translationByLanguage($lang->id)->first()->name }}</option>
                    @if (count($prop->property->multidata) > 0)
                        @foreach ($prop->property->multidata as $keyItem => $item)
                            <?php $check = chechSubproductVals($filterSubproduct, $currentVal, $product->id, $item->id) ?>
                            @if ($item->id != $currentVal)
                                <option value="{{ $item->id }}" {{ $check ? 'disabled' : '' }} data="{{ $product->id }}" data-key="{{ $key }}" data-name="{{ $prop->id }}" {{ @$filter[$product->id.$key]['valueId'] == $item->id ? 'selected' : '' }}>
                                    {{ $item->translationByLanguage($lang->id)->first()->name }}
                                </option>
                            @else
                                <option value="{{ $item->id }}" data="{{ $product->id }}" data-key="{{ $key }}" data-name="{{ $prop->id }}" {{ @$filter[$product->id.$key]['valueId'] == $item->id ? 'selected' : '' }}>
                                    {{ $item->translationByLanguage($lang->id)->first()->name }}
                                </option>
                            @endif
                        @endforeach
                    @endif
                </select>
            </div>
          @endforeach
      @endif
    </div>
    <p><small class="text-danger"> {{trans('front.wishList.chooseSubproduct')}}</small></p>
  </div>
  <div class="col-7 bm1">
      @if (count($product->subproducts))
         <div class="btnDark">
             <del>{{trans('front.wishList.addToCart')}}</del>
         </div>
       @else
         <div class="btnDark moveFromWishListToCart" data-subproduct_id="0" data-product_id="{{ $product->id }}">
           {{trans('front.wishList.addToCart')}}
         </div>
       @endif
  </div>
</div>
</div>
<div class="col-1">
    <div class="delWish removeItemWishList" data-id="{{ $product->id }}"></div>
</div>
