<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><img src="{{ asset('fronts/img/icons/closeModalMenu.png') }}" alt=""></button>
        </div>
        <div class="modal-body invalid-feedback text-center" style="display: block;">
            @if (count($cartProductsErrors) > 0)
                @foreach ($cartProductsErrors as $key => $cartItem)

                    @if ($cartItem->subproduct_id == 0)
                        @if ($cartItem->product->stock == 0)
                            Cu parere de rau articolul <b>{{ $cartItem->product->translationByLanguage($lang->id)->first()->name }} (#{{ $cartItem->product->code }})</b> este deja vandut. <br>Checkout-ul va fi continuat fara el.
                        @else
                            <p>
                                Cantitatea selectata pentru articolul({{ $cartItem->qty }}) <b>{{ $cartItem->product->translationByLanguage($lang->id)->first()->name }} (#{{ $cartItem->product->code }})</b> e mai mare decat detinem la moment
                            </p>
                            <p>
                                <small class="text-primary">sunt disponibile doar {{ $cartItem->product->stock }} de unitati</small>
                            </p>
                        @endif
                    @else
                        @if ($cartItem->subproduct->stock == 0)
                            Cu parere de rau articolul <b>{{ $cartItem->product->translationByLanguage($lang->id)->first()->name }} (#{{ $cartItem->subproduct->code }})</b>  este deja vandut. <br>Checkout-ul va fi continuat fara el.
                        @else
                            <p>
                                Cantitatea selectata pentru articolul({{ $cartItem->qty }}) <b>{{ $cartItem->product->translationByLanguage($lang->id)->first()->name }} (#{{ $cartItem->subproduct->code }})</b> e mai mare decat detinem la moment
                            </p>
                            <p>
                                <small class="text-primary">sunt disponibile doar {{ $cartItem->subproduct->stock }} de unitati</small>
                            </p>
                        @endif
                    @endif
                    <hr>
                @endforeach
            @endif
        </div>
        <div class="modal-footer">
            <span class="btnDark"><input type="button" class="forceSubmit" value="Confirma comanda"></span>
            <span class="btnDark"><input type="button" data-dismiss="modal" value="Inchide"></span>
        </div>
    </div>
</div>
