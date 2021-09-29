@if (!empty($orders))
  <label>Выберите товар из доступных заказов</label>

  <select class="form-control" name="orderProducts_return" data-return_id="{{!empty($return) ? $return->id : '0'}}" onfocus="this.setAttribute('PrvSelectedValue',this.value);">
    <option value="" disabled selected>Выберите товар из доступных заказов</option>
      @foreach ($orders as $order)
          @foreach ($order->orderProducts()->get() as $orderProduct)
            @if (!in_array($orderProduct->id, $orders_id))
                @if ($orderProduct->subproduct)
                    <option data-subproduct_id="{{$orderProduct->subproduct_id}}" data-product_id="{{$orderProduct->product_id}}" value="{{$orderProduct->id}}">{{$orderProduct->product->translationByLanguage($lang->id)->first()->name }} - {{ $orderProduct->qty }} items</option>
                @else
                    <option data-subproduct_id="0" data-product_id="{{$orderProduct->product_id}}" value="{{$orderProduct->id}}">{{$orderProduct->product->translationByLanguage($lang->id)->first()->name }} - {{ $orderProduct->qty }} items</option>
                @endif
            @endif
          @endforeach
      @endforeach
  </select>
@else
  <label>У этого пользователя нет завершенных заказов</label>
@endif
