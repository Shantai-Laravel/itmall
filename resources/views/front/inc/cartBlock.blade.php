@php
$amount = 0;
$notInStock = false;
$promocodeDiscount = 0;
@endphp

@if (!empty($cartProducts))
@foreach ($cartProducts as $key => $cartProduct)
    @php $price = $cartProduct->product->price - ($cartProduct->product->price * $cartProduct->product->discount / 100); @endphp
    @if ($price  && ($cartProduct->product->stock > 0))
        @php
        $amount +=  $price * $cartProduct->qty;
        @endphp
    @else
         @php $notInStock = $cartProduct->product->stock > 0 ? false : true; @endphp
    @endif
@endforeach
@endif

@if ($errors->has('emptyCart'))
  <div class="col-12">
     <div class="errorPassword">
         <p><strong>{{trans('front.cart.simpleError')}}</strong></p>
        <p>{!!$errors->first('emptyCart')!!}</p>
     </div>
  </div>
@endif

@if ($notInStock)
  <div class="col-12">
     <div class="errorPassword">
         <p><strong>{{trans('front.cart.simpleError')}}</strong></p>
        <p>{{trans('front.cart.productNotExist')}}</p>
     </div>
  </div>
@endif

@if (count($cartProducts) > 0)
    @foreach ($cartProducts as $cartProduct)
        <div class="row cartUserItem">
           <div class="col-md-5 col-12">
              <div class="row">
                 <div class="col-md-4 col-6 cartImg">
                   @if ($cartProduct->product->mainImage()->first())
                       <img id="prOneBig1" src="{{ asset('images/products/og/'.$cartProduct->product->mainImage()->first()->src ) }}">
                   @else
                       <img src="{{ asset('fronts/img/products/noimage.png') }}" alt="img-advice">
                   @endif
                 </div>
                 <div class="col-md-8 col-6 namProduct">
                    <div>{{$cartProduct->product->translationByLanguage($lang->id)->first()->name}}</div>
                    <div>
                       <div>{{$cartProduct->product->price}} euro</div>
                       <?php
                         $propertyValueID = getPropertiesData($cartProduct->product->id, ParameterId('billed'));
                       ?>
                       @if (!is_null($propertyValueID))
                         <?php $propertyValue = getMultiDataList($propertyValueID, $lang->id)->value; ?>
                         <div>{{GetParameter('billed', $lang->id)}}: {{$propertyValue}}</div>
                       @endif
                    </div>
                    <div class="countMobile">
                      <div class="plusminus">
                         <input type="text" id="niti" name="number" value="{{$cartProduct->qty}}">
                         <div class="minus" data-id="{{$cartProduct->product_id}}"></div>
                         <div class="plus" data-id="{{$cartProduct->product_id}}"></div>
                      </div>
                    </div>
                    <div class="posaMobile posAbsoluteX">
                      <div class="deletItem deleteItemFromCart" data-id="{{$cartProduct->id}}">
                      </div>
                    </div>
                 </div>
              </div>
           </div>
           <div class="col-md-7 col-12">
              <div class="row detitemMobile">
                 <div class="col-md-3 col-9 text-right marginMinus">
                    {{$cartProduct->product->price}} {{trans('front.cart.currency')}}
                 </div>
                 <div class="offset-md-2 offset-0 col-md-3 offset-5 col-6 text-center">
                    <div class="plusminus">
                       <input type="text" id="niti" name="number" value="{{$cartProduct->qty}}">
                       <div class="minus" data-id="{{$cartProduct->product_id}}"></div>
                       <div class="plus" data-id="{{$cartProduct->product_id}}"></div>
                    </div>
                 </div>
                 <div class="col-md-3 col-9 text-center mobileCart">
                    {{ ($cartProduct->product->price - ($cartProduct->product->price * $cartProduct->product->discount / 100)) * $cartProduct->qty}} {{trans('front.cart.currency')}}
                 </div>
                 <div class="col-md-1 col-sm-2 col-2 posAbsoluteX">
                    <div class="deletItem deleteItemFromCart" data-id="{{$cartProduct->id}}">
                    </div>
                 </div>
              </div>
           </div>
        </div>
    @endforeach
@else
    <div class="emptyCart">
      {{trans('front.cart.empty')}}
    </div>
@endif

<div class="row promo1CodCart align-items-center justify-content-center">
   <div class="col-12">
     <div class="row">
       <div class="col-md-9 col-6 txt">
         {{trans('front.cart.promoQuestion')}}
       </div>
       <div class="col-md-3 col-6 text-right">
         {{trans('front.cart.promo')}}:
       </div>
     </div>
   </div>
   <div class="col-md-9 col-12">
      <input type="text" id="codPromo" class="codPromo" name="codPromo" placeholder="Adauga Voucher">
   </div>
   @if ($promocode != null)
       @if ($promocode->user_id !== 0)
          @if (empty($userdata))
            <div class="invalid-feedback text-center"  style="display: block">
                {{trans('front.cart.loginUsePromo')}}
            </div>
          @elseif((!empty($userdata)) && ($promocode->user_id !== $userdata->id))
            <div class="invalid-feedback text-center"  style="display: block">
                {{trans('front.cart.anotherPromo')}}
            </div>
          @elseif ($promocode->treshold <= $amount)
              <div class="invalid-feedback text-center"  style="display: block">
                  - {{ $promocode->discount }}% {{trans('front.cart.withPromo')}}
                  <?php $promocodeDiscount = $promocode->discount?>
              </div>
          @else
              <div class="invalid-feedback text-center"  style="display: block">
                  {{trans('front.cart.promoCommand')}} > {{ $promocode->treshold }} {{trans('front.cart.currency')}}.
              </div>
          @endif
      @elseif ($promocode->treshold <= $amount)
          <div class="invalid-feedback text-center"  style="display: block">
              - {{ $promocode->discount }}% {{trans('front.cart.withPromo')}}
                <?php $promocodeDiscount = $promocode->discount?>
          </div>
      @else
          <div class="invalid-feedback text-center"  style="display: block">
              {{trans('front.cart.promoCommand')}} {{ $promocode->treshold }} {{trans('front.cart.currency')}}.
          </div>
       @endif
   @else
       @if (Session::get('promocode'))
           <div class="invalid-feedback text-center"  style="display: block">
               {{trans('front.cart.promoError')}}
           </div>
       @endif
   @endif
   <div class="col-md-3 col-12">
      <div class="buttCart promocodeAction">
         {{trans('front.cart.promoAply')}}
      </div>
   </div>
   <div class="col-12">
      <div class="row ">
        <div class="col-md-9 col-8 text-right fwb">{{trans('front.cart.total')}}:</div>
          @if (!is_null($promocode))
              @if ($promocode->treshold <= $amount)
                  <div class="col-md-9 col-8 text-right fwb"><span>{{ ($amount - ($amount * $promocodeDiscount / 100)) }} {{trans('front.cart.currency')}}</span></div>
              @else
                  <div class="col-md-9 col-8 text-right fwb"><span>{{ $amount }} {{trans('front.cart.currency')}}</span></div>
              @endif
          @else
              <div class="col-md-9 col-8 text-right fwb"><span>{{ $amount }} {{trans('front.cart.currency')}}</span></div>
          @endif
      </div>
   </div>
</div>
