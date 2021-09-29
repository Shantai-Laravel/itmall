@php
      $amount = 0;
@endphp
@if (!empty($cartProducts))
    @foreach ($cartProducts as $key => $cartProduct)

      @php $price = $cartProduct->product->price - ($cartProduct->product->price * $cartProduct->product->discount / 100); @endphp
      @if ($price && ($cartProduct->product->stock > 0))
          @php
              $amount +=  $price * $cartProduct->qty;
          @endphp
      @endif

    @endforeach

@endif

@if (count($cartProducts) > 0)
    @foreach ($cartProducts as $cartProduct)
        <div class="col-12">
          <div class="row cartMenuItem">
            <div class="col-4">
              @if ($cartProduct->product->mainImage()->first())
                  <img id="prOneBig1" src="{{ asset('images/products/og/'.$cartProduct->product->mainImage()->first()->src ) }}">
              @else
                  <img src="{{ asset('fronts/img/products/noimage.png') }}" alt="img-advice">
              @endif
            </div>
            <div class="col-6 descrItem">
              <div>
                <a href="{{ url($lang->lang.'/catalog/'.getParentCategory($cartProduct->product->category_id, $lang->id).'/'.$cartProduct->product->alias ) }}">{{$cartProduct->product->translationByLanguage($lang->id)->first()->name}}</a>
              </div>
              <div>{{$cartProduct->qty}} x {{$cartProduct->product->price}} {{trans('front.cart.currency')}}</div>
            </div>
            <div class="col-2">
              <div class="deleteItem deleteItemFromCart" data-product_id="{{$cartProduct->product->id}}" data-id="{{$cartProduct->id}}">

              </div>
            </div>
            <div class="col-12">
              <div class="totalCart"></div>
            </div>
          </div>
        </div>
    @endforeach
    <div class="col-12">
      <div class="row justify-content-between totalShrift">
        <div class="col-auto">{{trans('front.cart.totalCommand')}}</div>
        <div class="col-auto">
          {{$amount}} {{trans('front.cart.currency')}}
        </div>
      </div>
    </div>
@else
<div class="emptyCart">
  {{trans('front.cart.notAdded')}}
</div>
@endif
