@extends('front.app')
@section('content')
<div class="header">
    @include('front.inc.header')
</div>
<!-- GLAVNII SLAIDER -->
<div class="container_banner Slide"></div>
<img src="{{ asset('fronts/img/foto.png') }}" alt="">
<!-- GLAVNII SLAIDER END -->
<div class="container">
    <div class="row">
        <div class="container">
            <div class="col-auto crumbs">
                <a class="et1" href="{{ url($lang->lang) }}"> Home </a>
                <img class="strel" src="{{ asset('fronts/img/icons/strel.png') }}" alt="strelocka">
                <a class="et1" href="{{ url($lang->lang.'/solution/'.$solution->alias) }}">
                    {{ $solution->translationByLanguage($lang->id)->first()->name }}
                </a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="container text-center">
            <div class="title">{{ $solution->translationByLanguage($lang->id)->first()->name }}</div>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        @if (count($products) > 0)
            <div class="col-md-9">
                <div class="itemEst col-lg-4 col-md-6 col-sm-12">
                    @foreach ($products as $key => $product)
                        <div class="inside-item">
                            <div class="item-body">
                                @if ($product->brand())
                                    <h4>{{ $product->brand()->translationByLanguage($lang->id)->first()->name }}</h4>
                                @endif
                                <p>{{ $product->translationByLanguage($lang->id)->first()->name }}</p>
                                @if ($product->mainImage()->first())
                                    <img src="{{ asset('upfiles/products/og/'.$product->mainImage()->first()->src ) }}">
                                @else
                                    <img src="{{ asset('upfiles/no-image.png') }}">
                                @endif
                                <div class="price">
                                    <span>{{ $product->price }} lei</span>
                                    <span><b>Preț nou </b>{{ $product->price - ($product->price * $product->discount / 100) }} lei</span>
                                </div>
                                <div class="product-btns">
                                    <a href="{{ url($lang->lang.'/catalog/'.getProductLink($product->category_id).$product->alias) }}" class="buy-btn">Vezi detalii</a>
                                    <div data-toggle="modal" class="modalClick" data-target="#modalClick{{ $product->id }}">Comanda intr-un click</div>
                                </div>
                            </div>
                            <div class="item-footer">
                                <div data-toggle="modal" class="modalToCart" data-id="{{ $product->id }}" data-target="#modalToCart{{ $product->id }}">Adaugă în coș</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="cat_with_products">
                @include('front.inc.modals', ['toCartProducts' => $products, 'oneClickProducts' => $products])
            </div>
        @else
            <div class="col-md-12"><hr>
                <p class="text-center">Acesta solutie cheie nu are produse</p>
            </div>
        @endif
    </div>
</div>
<!-- PREFOOTER -->
<div class="row">
    <div class="container_banner1"><img src="{{ asset('fronts/img/foto1.png') }}" alt=""></div>
</div>
<div class="fon_prefooter">
    <div class="row">
        <div class="container text-center prefooter text-padding">
            <div class="title text-bold">vreai sa cunosti cum se utilizeaza aceste produse?</div>
            <button class="aflati1 text-center"> Aflati mai mult</button>
        </div>
    </div>
</div>
<!-- PREFOOTER END -->
</div>
@include('front.inc.footer')
{{-- </div> --}}
@include('front.inc.sideBlocks')
@stop
