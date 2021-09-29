@if (count($findProducts) > 0)
    @foreach ($findProducts as $findProduct)
      <div class="col-lg-4 col-md-5 col-sm-6 col-10">
        <div class="catsItem">
          @if ($findProduct->mainImage()->first())
              <img id="prOneBig1" src="{{ asset('images/products/og/'.$findProduct->mainImage()->first()->src ) }}">
          @else
              <img src="{{ asset('fronts/img/products/noimage.png') }}" alt="img-advice">
          @endif
          <div class="catsTitle"><span>{{$findProduct->translationByLanguage($lang->id)->first()->name}}</span></div>
          <div class="btnGreen">
            <div class="btnGreenHover">
              <a href="{{ url($lang->lang.'/catalog/'.getParentCategory($findProduct->category_id, $lang->id).'/'.$findProduct->alias ) }}">{{trans('front.product.viewProduct')}}</a>
            </div>
          </div>
        </div>
      </div>
    @endforeach
@else
  <div class="col-lg-4 col-md-5 col-sm-6 col-10">
    <div class="catsTitle">
      <span>{{trans('front.product.noProduct')}}</span>
    </div>
  </div>
@endif
