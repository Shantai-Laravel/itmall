@if (!is_null($product))
<div class="modal" id="modalStopAdd">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Adaugare in cos</h4>
                <button type="button" class="close" data-dismiss="modal"><img src="{{ asset('fronts/img/icons/closeModalMenu.png') }}" alt=""></button>
            </div>
            <div class="modal-body">
                <p class="text-center">Produsul poate fi adaugat in cos sau cumparat intr-un click, doar dupa selectarea parametrilor</p>
            </div>
        </div>
    </div>
</div>
@endif

@if (!is_null($products))
        <div class="modal" id="modalAddCartProduct{{ $product->id }}">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Adăugat în coș</h4>
                        <button type="button" class="close" data-dismiss="modal"><img src="{{ asset('fronts/img/icons/closeModalMenu.png') }}" alt=""></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-3 modal-image">
                                @if ($product->mainImage()->first())
                                <img src="{{ asset('images/products/og/'.$product->mainImage()->first()->src ) }}">
                                @else
                                <img src="{{ asset('/upfiles/no-image.png') }}">
                                @endif
                            </div>
                            <div class="col-7">
                                <div class="row">
                                    <div class="col-12">
                                        {{ $product->translationByLanguage($lang->id)->first()->name }}
                                    </div>
                                    <div class="col-8">
                                        {{-- <div class="plusminus">
                                            <input type="text" id="niti" name="number" value="{{ $product->cart ? $product->cart->qty : '1' }}">
                                            <div class="minus" data-subprod="0" data-prod="{{ $product->id }}"></div>
                                            <div class="plus" data-subprod="0" data-prod="{{ $product->id }}"></div>
                                        </div> --}}
                                        @if ($product->stock > 0)
                                            <select class="changeQtyProduct" data-subprod="0" data-prod="{{ $product->id }}">
                                                @for ($i = 1; $i <= $product->stock; $i++)
                                                    <option value="{{ $i }}">{{ $i }}</option>
                                                @endfor
                                            </select>
                                        @endif
                                    </div>
                                    <div class="col-12">
                                        <div class="price">
                                            <span>{{ $product->price - ($product->price * $product->discount / 100) }} lei</span>
                                            <span>{{ $product->price }} lei</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6" style="margin-top: 20px;">
                                <div class="btnDark" data-dismiss="modal">
                                    Continue shopping
                                </div>
                            </div>
                            <div class="col-6" style="margin-top: 20px;">
                                <div class="btnLight">
                                    <a href="{{ url($lang->lang.'/cart') }}">View Cart</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endif
