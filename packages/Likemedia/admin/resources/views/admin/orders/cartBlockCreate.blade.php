<?php
      $amount = 0;
      $descountTotal = 0;
?>

@if (!empty($cartProducts))
    @foreach ($cartProducts as $key => $cartProduct)

        @if ($cartProduct->subproduct)
            <?php $price = $cartProduct->subproduct->price - ($cartProduct->subproduct->price * $cartProduct->subproduct->discount / 100); ?>

            @if ($price)
                <?php
                    $amount +=  $price * $cartProduct->qty;
                    $descountTotal += ($cartProduct->subproduct->price -  ($cartProduct->subproduct->price - ($cartProduct->subproduct->price * $cartProduct->subproduct->discount / 100))) * $cartProduct->qty;
                ?>
            @endif
        @else
            <?php $price = $cartProduct->product->price - ($cartProduct->product->price * $cartProduct->product->discount / 100); ?>

            @if ($price)
                <?php
                    $amount +=  $price * $cartProduct->qty;
                    $descountTotal += ($cartProduct->product->price -  ($cartProduct->product->price - ($cartProduct->product->price * $cartProduct->product->discount / 100))) * $cartProduct->qty;
                ?>
            @endif
        @endif

    @endforeach
@endif

@if(isset($cartProducts) && count($cartProducts) > 0)
<div class="cartItems">
        <div class="row headCart">
          <div class="col-md-1">
          </div>
          <div class="col-md-3">
            Produs
          </div>
          <div class="col-md-2">
            Price lei
          </div>
          <div class="col-md-2">
            Cantitate
          </div>
          <div class="col-md-1">
            Reducere %
          </div>
          <div class="col-md-1">
            Total lei
          </div>
          <div class="col-md-2">
            Total %
          </div>
        </div>
        @foreach ($cartProducts as $key => $cartProduct)
            @if ($cartProduct->subproduct)
                <div class="row cartOneItem">
                  <div class="col-md-1">
                    <img src="{{asset('fronts/img/icons/trashIcon.png')}}" data-product_id="{{$cartProduct->product_id}}" data-subproduct_id="{{$cartProduct->subproduct_id}}" class="buttonRemove removeItem"  style="width: 40px; height: 40px; cursor: pointer;">
                  </div>
                  <div class="col-lg-3 col-md-12">
                    <div class="imgCartItem">
                      @if (getMainSubProductImage($cartProduct->subproduct_id))
                       @php $image = getMainSubProductImage($cartProduct->subproduct_id) @endphp
                       <img src="{{ asset('images/subproducts/'.$image->image) }}" >
                      @else
                       <img src="{{ asset('fronts/img/icons/noimage.jpg') }}">
                      @endif
                    </div>
                    <div class="cartDescr">
                      <p>{{$cartProduct->product->translationByLanguage($lang->id)->first()->name}}</p>
                      <?php $subproduct = $cartProduct->subproduct;?>
                      <div style="margin-left: 80px;">
                          @foreach (json_decode($subproduct->combination) as $key => $combination)
                              @if ($key != 0)
                                <p>{{getParamById($key, $lang->id)->name}}: <span>{{getParamValueById($combination, $lang->id)->value}}</span></p>
                              @endif
                          @endforeach
                      </div>
                      <p>In stock: {{$cartProduct->subproduct->stock}}</p>
                    </div>
                  </div>
                  <div class="col-md-2">
                    <input style="height: 39px; width: 100%" type="text" name="productPrice" data-id="{{$cartProduct->subproduct_id}}" value="{{$cartProduct->subproduct->price}}">
                  </div>
                  <div class="col-lg-2 col-6 justify-content-center ngh">
                    <div class="plusminus" style="width: 100%;">
                      <div class="minus" data-product_id="{{ $cartProduct->product_id }}" data-subproduct_id="{{$cartProduct->subproduct_id}}">-</div>
                      <input type="text" class="form-control" id="niti" name="number" value="{{ $cartProduct->qty }}" >
                      <div class="plus" data-product_id="{{ $cartProduct->product_id }}" data-subproduct_id="{{$cartProduct->subproduct_id}}">+</div>
                    </div>
                  </div>
                  <div class="col-md-1 colRed">
                    <input style="width: 100%; height: 39px;" type="text" data-id="{{$cartProduct->subproduct_id}}" name="productDiscount" value="{{$cartProduct->subproduct->discount}}">
                  </div>

                  <div class="col-md-1 col-6">
                    {{ $cartProduct->subproduct->price * $cartProduct->qty}}
                  </div>
                  <div class="col-md-2">
                    {{ ($cartProduct->subproduct->price - ($cartProduct->subproduct->price * $cartProduct->subproduct->discount / 100)) * $cartProduct->qty}}
                  </div>
                </div>
            @else
                <div class="row cartOneItem">
                  <div class="col-md-1">
                    <img src="{{asset('fronts/img/icons/trashIcon.png')}}" data-product_id="{{$cartProduct->product_id}}" data-subproduct_id="0" class="buttonRemove removeItem"  style="width: 40px; height: 40px; cursor: pointer;">
                  </div>
                  <div class="col-lg-3 col-md-12">
                    <div class="imgCartItem">
                      @if (getMainProductImage($cartProduct->product_id, $lang->id))
                       @php $image = getMainProductImage($cartProduct->product_id, $lang->id) @endphp
                       <img src="{{ asset('images/products/sm/'.$image->src) }}" alt="{{$image->alt}}" title="{{$image->title}}" >
                      @else
                       <img src="{{ asset('fronts/img/icons/noimage.jpg') }}" alt="">
                      @endif
                    </div>
                    <div class="cartDescr">
                      <p>{{$cartProduct->product->translationByLanguage($lang->id)->first()->name}}</p>
                      <p>In stock: {{$cartProduct->product->stock}}</p>
                    </div>
                  </div>
                  <div class="col-md-2">
                    <input style="height: 39px; width: 100%" type="text" name="productPrice" data-id="{{$cartProduct->product_id}}" value="{{$cartProduct->product->price}}">
                  </div>
                  <div class="col-lg-2 col-6 justify-content-center ngh">
                    <div class="plusminus" style="width: 100%;">
                      <div class="minus" data-product_id="{{ $cartProduct->product_id }}" data-subproduct_id="0">-</div>
                      <input type="text" class="form-control" id="niti" name="number" value="{{ $cartProduct->qty }}" >
                      <div class="plus" data-product_id="{{ $cartProduct->product_id }}" data-subproduct_id="0">+</div>
                    </div>
                  </div>
                  <div class="col-md-1 colRed">
                    <input style="width: 100%; height: 39px;" type="text" data-id="{{$cartProduct->product_id}}" name="productDiscount" value="{{$cartProduct->product->discount}}">
                  </div>

                  <div class="col-md-1 col-6">
                    {{ $cartProduct->product->price * $cartProduct->qty}}
                  </div>
                  <div class="col-md-2">
                    {{ ($cartProduct->product->price - ($cartProduct->product->price * $cartProduct->product->discount / 100)) * $cartProduct->qty}}
                  </div>
                </div>
            @endif
        @endforeach

    {{trans('front.cart.totalDiscount')}} {{$descountTotal}}
    <div class="col totalsBtn">
      <input type="button" id="removeAllItems" name="remAllItems" value="{{trans('front.cart.deleteAllBtn')}}">
    </div>

    <div class="col-md-3 col-6">{{trans('front.cart.promo')}}</div>
    <div class="col-md-3 col-6">
      <input type="text" id="codPromo" class="codPromo" name="codPromo" value="{{ !is_null($promocode) ? $promocode->name : Session::get('promocode') }}">
    </div>

    <div class="col-md-2 col-6">
      <div class="btnDark promocodeAction">
        {{trans('front.cart.applyBtn')}}
      </div>
    </div>

    @if (!is_null($promocode))
        @if ($promocode->treshold <= $amount)
            <span class="amount">Total: {{ ($amount - ($amount * $promocode->discount / 100)) }} lei</span>
        @else
            <span class="amount">Total: {{ $amount }} lei</span>
        @endif
    @else
        <span class="amount">Total: {{ $amount }} lei</span>
    @endif

    <br><br>
    <div class="col">
      @if (!is_null($promocode))
          @if ($promocode->treshold <= $amount)
              <div class="text-center"  style="display: block; color: red;">
                  - {{ $promocode->discount }}% with promocode
              </div>
          @else
              <div class="text-center"  style="display: block; color: red;">
                  Acest promocode poate fi utilizat pentru comenzi > {{ $promocode->treshold }} lei.
              </div>
          @endif
      @else
          @if (Session::get('promocode'))
              <div class="text-center"  style="display: block; color: red;">
                  Acest promocode nu exista sau nu este valabil.
              </div>
          @endif
      @endif
    </div>
</div>
@else
<div class="empty-response">{{trans('variables.list_is_empty')}}</div>
@endif
