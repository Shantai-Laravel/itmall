@php $filterSubproduct = []; @endphp
@if (count($dependebleProps) > 0)
    @foreach ($dependebleProps as $key => $prop)
        @php
            $filterSubproduct[$key] = @$filter[$product->id.$key]
        @endphp
    @endforeach
@endif

<div class="item-body">
    @if ($product->mainImage()->first())
    <img src="{{ asset('/images/products/og/'.$product->mainImage()->first()->src ) }}">
    @else
    <img src="{{ asset('/upfiles/no-image.png') }}">
    @endif

    <div class="buyDet">
        <p class="alert"><small> alegeti toate optiunile </small></p>

        <div class="row">
                @if (count($dependebleProps) > 0)
                    @foreach ($dependebleProps as $key => $prop)
                    <div class="col-md-6 prop-items">
                        <label for="">
                            {{ $prop->property->translationByLanguage($lang->id)->first()->name }}:
                        </label>
                        <select class="subproductSelect">
                            <option value="">Alege {{ $prop->property->translationByLanguage($lang->id)->first()->name }}</option>
                            @if (count($prop->property->multidata) > 0)
                                @foreach ($prop->property->multidata as $keyItem => $item)
                                    <?php $check = chechSubproductVals($filterSubproduct, $currentVal, $product->id, $item->id) ?>
                                    @if ($item->id != $currentVal)
                                        <option value="{{ $item->id }}" {{ $check ? 'disabled' : '' }} data="{{ $product->id }}" data-key="{{ $key }}" data-name="{{ $prop->id }}" {{ @$filter[$product->id.$key]['valueId'] == $item->id ? 'selected' : '' }}>
                                            {{ $item->translationByLanguage($lang->id)->first()->name }}
                                        </option>
                                    @else
                                        <option value="{{ $item->id }}" data="{{ $product->id }}" data-key="{{ $key }}" data-name="{{ $prop->id }}" {{ @$filter[$product->id.$key]['valueId'] == $item->id ? 'selected' : '' }}>
                                            {{ $item->translationByLanguage($lang->id)->first()->name }}
                                        </option>
                                    @endif
                                @endforeach
                            @endif
                        </select>
                    </div>
                  @endforeach
              @endif

              <div class="col-6">
                  <div class="btnLight" data-toggle="modal" data-target="#modalStopAdd">In one click</div>
              </div>
              <div class="col-6">
                  <div class="btnDark" class="btnLight modalToCart" data-toggle="modal" data-target="#modalStopAdd"> Add to Card </div>
              </div>

            <div class="col-12">
                <div class="btnWhite">
                    <a href="{{ url($lang->lang.'/catalog/'.getProductLink($product->category_id).$product->alias) }}" class="buy-btn">Vezi detalii</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="item-footer">
    @if ($product->brand()->first())
    <h4>{{ $product->brand()->translationByLanguage($lang->id)->first()->name }}</h4>
    @endif
    <p>{{ $product->translationByLanguage($lang->id)->first()->name }}</p>
    <div class="price">
        <span>{{ $product->price }} lei</span>
        <span>{{ $product->price - ($product->price * $product->discount / 100) }} lei</span>
    </div>
</div>

{{-- @include('front.modals.modalSubproduct') --}}
