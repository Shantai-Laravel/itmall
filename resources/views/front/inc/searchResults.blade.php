@if (!empty($findProducts) && count($findProducts) > 0)
    @foreach ($findProducts as $key => $product)
        <div class="col-12 hui">
          <div class="row cartMenuItem">
            <div class="col-4">
              @if ($product->mainImage()->first())
                  <img id="prOneBig1" src="{{ asset('images/products/og/'.$product->mainImage()->first()->src ) }}">
              @else
                  <img src="{{ asset('fronts/img/products/noimage.png') }}" alt="img-advice">
              @endif
            </div>
            <div class="col-6 descrItem">
              <div>
                <a href="{{ url($lang->lang.'/catalog/'.getParentCategory($product->category_id, $lang->id).'/'.$product->alias ) }}">
                  {!! str_ireplace($search, '<i>'.$search.'</i>', $product->translationByLanguage($lang->id)->first()->name) !!}
                </a>
              </div>
            </div>
            <div class="col-12">
              <div class="totalCart"></div>
            </div>
          </div>
        </div>
    @endforeach
@endif
