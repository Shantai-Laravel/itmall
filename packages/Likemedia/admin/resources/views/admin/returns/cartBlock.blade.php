<?php
      $amount = 0;
      $descountTotal = 0;
?>

@if (!empty($return))
    @foreach ($return->returnProducts()->get() as $key => $returnProduct)

        @if ($returnProduct->product)
        <?php $price = $returnProduct->product->price - ($returnProduct->product->price * $returnProduct->product->discount / 100); ?>

            @if ($price)
                <?php
                    $amount +=  $price * $returnProduct->qty;
                    $descountTotal += ($returnProduct->product->price -  ($returnProduct->product->price - ($returnProduct->product->price * $returnProduct->product->discount / 100))) * $returnProduct->qty;
                ?>
            @endif

        @endif

    @endforeach
@endif

@if(!empty($return))
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
        @foreach ($return->returnProducts()->get() as $key => $returnProduct)
            @if ($returnProduct->subproduct)
                <div class="row cartOneItem">
                  <div class="col-md-1">
                    <img src="{{asset('fronts/img/icons/trashIcon.png')}}" data-return_id="{{$returnProduct->return_id}}" data-order_product_id="{{$returnProduct->orderProduct_id}}" data-product_id="{{$returnProduct->product_id}}" data-subproduct_id="{{$returnProduct->subproduct_id}}" class="buttonRemoveReturn removeItem"  style="width: 40px; height: 40px; cursor: pointer;">
                  </div>
                  <div class="col-lg-3 col-md-12">
                    <div class="imgCartItem">
                      @if (getMainSubProductImage($returnProduct->subproduct_id))
                       @php $image = getMainSubProductImage($returnProduct->subproduct_id) @endphp
                       <img src="{{ asset('images/subproducts/'.$image->image) }}" >
                      @else
                       <img src="{{ asset('fronts/img/icons/noimage.jpg') }}">
                      @endif
                    </div>
                    <div class="cartDescr">
                      <p>{{$returnProduct->product->translationByLanguage($lang->id)->first()->name}}</p>
                      <?php $subproduct = $returnProduct->subproduct;?>
                      <div style="margin-left: 80px;">
                          @foreach (json_decode($subproduct->combination) as $key => $combination)
                              @if ($key != 0)
                                <p>{{getParamById($key, $lang->id)->name}}: <span>{{getParamValueById($combination, $lang->id)->value}}</span></p>
                              @endif
                          @endforeach
                      </div>
                    </div>
                  </div>
                  <div class="col-md-2">
                    {{$returnProduct->subproduct->price}}
                  </div>
                  <div class="col-lg-2 col-6 justify-content-center ngh">
                    <div class="plusminus" style="width: 100%;">
                      <div class="minus" data-return_id="{{$returnProduct->return_id}}" data-order_product_id="{{$returnProduct->orderProduct_id}}" data-product_id="{{ $returnProduct->product_id }}" data-subproduct_id="{{$returnProduct->subproduct_id}}">-</div>
                      <input type="text" class="form-control" id="niti" name="number" value="{{ $returnProduct->qty }}" >
                      <div class="plus" data-return_id="{{$returnProduct->return_id}}" data-order_product_id="{{$returnProduct->orderProduct_id}}" data-product_id="{{ $returnProduct->product_id }}" data-subproduct_id="{{$returnProduct->subproduct_id}}">+</div>
                    </div>
                  </div>
                  <div class="col-md-1 colRed">
                    {{$returnProduct->subproduct->discount}}
                  </div>

                  <div class="col-md-1 col-6">
                    {{ $returnProduct->subproduct->price * $returnProduct->qty}}
                  </div>
                  <div class="col-md-2">
                    {{ ($returnProduct->subproduct->price - ($returnProduct->subproduct->price * $returnProduct->subproduct->discount / 100)) * $returnProduct->qty}}
                  </div>
                </div>
            @else
                <div class="row cartOneItem">
                  <div class="col-md-1">
                    <img src="{{asset('fronts/img/icons/trashIcon.png')}}" data-return_id="{{$returnProduct->return_id}}" data-order_product_id="{{$returnProduct->orderProduct_id}}" data-product_id="{{$returnProduct->product_id}}" data-subproduct_id="0" class="buttonRemoveReturn removeItem"  style="width: 40px; height: 40px; cursor: pointer;">
                  </div>
                  <div class="col-lg-3 col-md-12">
                    <div class="imgCartItem">
                      @if (getMainProductImage($returnProduct->product_id, $lang->id))
                       @php $image = getMainProductImage($returnProduct->product_id, $lang->id) @endphp
                       <img src="{{ asset('images/products/sm/'.$image->src) }}" alt="{{$image->alt}}" title="{{$image->title}}" >
                      @else
                       <img src="{{ asset('fronts/img/icons/noimage.jpg') }}" alt="">
                      @endif
                    </div>
                    <div class="cartDescr">
                      <p>{{$returnProduct->product->translationByLanguage($lang->id)->first()->name}}</p>
                    </div>
                  </div>
                  <div class="col-md-2">
                    {{$returnProduct->product->price}}
                  </div>
                  <div class="col-lg-2 col-6 justify-content-center ngh">
                    <div class="plusminus" style="width: 100%;">
                      <div class="minus" data-return_id="{{$returnProduct->return_id}}" data-order_product_id="{{$returnProduct->orderProduct_id}}" data-product_id="{{ $returnProduct->product_id }}" data-subproduct_id="0">-</div>
                      <input type="text" class="form-control" id="niti" name="number" value="{{ $returnProduct->qty }}" >
                      <div class="plus" data-return_id="{{$returnProduct->return_id}}" data-order_product_id="{{$returnProduct->orderProduct_id}}" data-product_id="{{ $returnProduct->product_id }}" data-subproduct_id="0">+</div>
                    </div>
                  </div>
                  <div class="col-md-1 colRed">
                    {{$returnProduct->product->discount}}
                  </div>

                  <div class="col-md-1 col-6">
                    {{ $returnProduct->product->price * $returnProduct->qty}}
                  </div>
                  <div class="col-md-2">
                    {{ ($returnProduct->product->price - ($returnProduct->product->price * $returnProduct->product->discount / 100)) * $returnProduct->qty}}
                  </div>
                </div>
            @endif
        @endforeach
    {{trans('front.cart.totalDiscount')}} {{$descountTotal}}
    <div class="col totalsBtn">
      <input type="button" id="removeAllItemsReturn" data-return_id="{{$return->id}}" name="remAllItems" value="{{trans('front.cart.deleteAllBtn')}}">
    </div>
    Total : {{$amount}}
</div>
@else
<div class="empty-response">{{trans('variables.list_is_empty')}}</div>
@endif
