<?php
      $amount = 0;
      $descountTotal = 0;
?>
@if (!empty($cartProducts))
    @foreach ($cartProducts as $key => $cartProduct)
        @if ($cartProduct->product)
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
<div class="col-12">
    <p>{{trans('front.cart.paymentText')}}</p>
</div>
<div class="col-12">
    <div class="row resum">
        <div class="col-auto"> {{trans('front.cart.productSum')}}</div>
        <div class="col line"></div>
        <div class="col-3">
            {{ $amount }} {{trans('front.cart.currency')}}
        </div>
    </div>
    <div class="row resum">
        <div class="col-auto">{{trans('front.cart.delivery')}}</div>
        <div class="col line"></div>
        <div class="col-3">
            25,00 {{trans('front.cart.currency')}}
        </div>
    </div>
</div>
<div class="col-12">
    <div class="row totalToPay justify-content-end">
        <div class="col-auto" style="padding-right: 20px;">
            {{trans('front.cart.totalPay')}}:
        </div>
        <div class="col-3">
            {{ $amount + 25 }} {{trans('front.cart.currency')}}
        </div>
    </div>
</div>
