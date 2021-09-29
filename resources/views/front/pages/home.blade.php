@extends('front.app')
@section('content')
@include('front.inc.header')
<?php
    $pinterest = getContactInfo('pinterest')->translationByLanguage()->first()->value;
    $facebook = getContactInfo('facebook')->translationByLanguage()->first()->value;
    $instagram = getContactInfo('instagram')->translationByLanguage()->first()->value;
    $linkedin = getContactInfo('linkedin')->translationByLanguage()->first()->value;
    $twitter = getContactInfo('twitter')->translationByLanguage()->first()->value;
    $youtube = getContactInfo('youtube')->translationByLanguage()->first()->value;
?>
<div id="cover">
  <div class="retAbsolute">
    <div class="retNav">
      <ul>
        <li><a href="{{$pinterest}}"></a></li>
        <li><a href="{{$facebook}}"></a></li>
        <li><a href="{{$instagram}}"></a></li>
        <li><a href="{{$linkedin}}"></a></li>
        <li><a href="{{$twitter}}"></a></li>
        <li><a href="{{$youtube}}"></a></li>
      </ul>
    </div>
  </div>
  <div class="headerBanner">
        <div class="digitallMallBanner">
          <div style="height: 100%;" class="row justify-content-start">
            <div class="col-md-auto col-12">
              <div class="titlePresentationBanner">{!!trans('front.banner.title')!!}</div>
              <p>{!!trans('front.banner.description')!!}</p>
              <p class="projectBy">{{trans('front.banner.by')}}</p>
              <div class="btnGreen">
                <div class="btnGreenHover">
                  <a href="{{url($lang->lang.'/presentation')}}">{{trans('front.banner.btn')}}</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      <div class="row banners align-items-end">
        <div class="col-md-3 col-sm-12 bannerBlock">
          <a href="{{ url($lang->lang.'/catalog/smm-advertising/facebook-adveritising/fb-trendy') }}">
            <div class="titleBlock">{{trans('front.home.titleBlock')}}</div>
            <p>{{trans('front.home.blockDescr')}}</p>
          </a>
        </div>
        <div class="col-md-3 col-sm-12 bannerBlock bannerBlockLight">
          <a href="{{ url($lang->lang.'/catalog/websites-e-commerce-development/corporate-websites') }}">
            <div class="titleBlock">{{trans('front.home.titleBlock2')}}</div>
            <p>{{trans('front.home.blockDescr2')}}</p>
          </a>
        </div>
        <div class="col-md-3 col-sm-12 slides">
          @if (count($onlineStores) > 0)
              <div class="slideMain">
                @foreach ($onlineStores as $onlineStore)
                    @if ($onlineStore->mainImage()->first())
                      <img id="prOneBig1" src="{{ asset('images/products/og/'.$onlineStore->mainImage()->first()->src ) }}">
                    @else
                     <img src="{{ asset('fronts/img/products/noimage.png') }}" alt="img-advice">
                    @endif
                @endforeach
              </div>
          @endif
        </div>
        <div class="col-md-3 col-sm-12 slides slides2">
          @if (count($onlineStores) > 0)
            <div class="slideNav">
              @foreach ($onlineStores as $onlineStore)
                  <div class="slideItem">
                    <div class="nameSlide">{{$onlineStore->translationByLanguage($lang->id)->first()->name}}</div>
                    <p>{!!$onlineStore->translationByLanguage($lang->id)->first()->description !!}</p>
                    <div class="row">
                      <div class="col-auto">
                        <a href="{{ url($lang->lang.'/catalog/'.getParentCategory($onlineStore->category_id, $lang->id).'/'.$onlineStore->alias)}}">{{trans('front.product.viewProduct')}}</a>
                      </div>
                    </div>
                  </div>
              @endforeach
            </div>
          @endif
        </div>
      </div>
  </div>
  <div class="sectionContent">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <div class="titleBlock">{{trans('front.home.mostPopular')}}</div>
        </div>
        <div class="col-md-6 col-sm-12">
          <div class="sectionBlock">
            <div class="sectionBlockIcon">

            </div>
            <p>{{trans('front.home.eCommerce')}}</p>
            <div class="btnGreen">
              <div class="btnGreenHover">
                <a href="{{ url($lang->lang.'/catalog/websites-e-commerce-development/online-stores') }}">{{trans('front.product.viewProduct')}}</a>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-sm-12">
          <div class="row">
            @if (count($products) > 0)
                @foreach ($products as $product)
                  <div class="col-md-6 col-sm-12 miniIcon">
                    <div class="sectionMiniBlock">
                      <div class="miniBlockIcon"></div>
                      <a href="{{ url($lang->lang.'/catalog/'.getParentCategory($product->category_id, $lang->id).'/'.$product->alias ) }}">
                        {{$product->translationByLanguage($lang->id)->first()->name}}
                      </a>
                      <div class="priced">{{$product->price}} {{trans('front.cart.currency')}}</div>
                      <div class="hoverButtons">
                        <div class="btnm">
                          <div class="btnCart {{$product->inCart ? 'buttonMenuCartElements' : ''}} modalToCart" data-id="{{$product->id}}" data-toggle="modal" data-target="#modalAddCartProduct{{ $product->id }}">
                            <div class="btnBcg"></div>
                          </div>
                        </div>
                        <div class="btnm">
                          <div class="btnWish {{$product->inWishList ? 'buttonMenuWishElements' : ''}} addToWishList" data-id="{{$product->id}}">
                            <div class="btnBcg"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                @endforeach
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="sectionContentBcg">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-6 col-sm-12">
          <div class="faceBlock">
            <p class="pBlock">{{trans('front.home.facebook')}}</p>
            <div class="btnGreen">
              <div class="btnGreenHover">
                <a href="{{ url($lang->lang.'/catalog/smm-advertising/facebook-adveritising') }}">{{trans('front.product.viewProduct')}}</a>
              </div>
            </div>
            <div class="btnm">
              <div class="facebookIcon">
                <div class="btnBcg"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="sectionVideo">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <div class="titleBlock">{{trans('front.home.recommend')}}</div>
        </div>
        <div class="col-md-6 col-sm-12">
          <div class="blockVideo">
            <video autoplay loop muted>
              <source src="{{asset('fronts/video/pantera.mp4')}}" type="video/mp4">
              Your browser does not support the video tag.
            </video>
            <div class="subBlockVideo">
              <div class="dmmn">
                <div class="titleBlock">{{$googleCategory->translationByLanguage($lang->id)->first()->name}}</div>
                <p>
                  @if (count($googleCategory->subcategories()->get()) > 0)
                      @foreach ($googleCategory->subcategories()->get() as $googleSubCategory)
                          <a href="{{ url($lang->lang.'/catalog/'.$googleCategory->alias.'/'.$googleSubCategory->alias)}}">{{$googleSubCategory->translationByLanguage($lang->id)->first()->name}}</a>
                      @endforeach
                  @endif
                </p>
              </div>
              <div class="btnGreen">
                <div class="btnGreenHover">
                  <a href="{{ url($lang->lang.'/catalog/'.$googleCategory->alias)}}">{{trans('front.product.viewProduct')}}</a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-sm-12">
          <div class="blockVideo">
            <video autoplay loop muted>
              <source src="{{asset('fronts/video/pantera2.mp4')}}" type="video/mp4">
              Your browser does not support the video tag.
            </video>
            <div class="subBlockVideo">
              <div class="dmmn"><div class="titleBlock">{{$smmCategory->translationByLanguage($lang->id)->first()->name}}</div>
              @if (count($smmCategory->subcategories()->get()) > 0)
                  @foreach ($smmCategory->subcategories()->get() as $smmSubCategory)
                      <a href="{{ url($lang->lang.'/catalog/'.$smmCategory->alias.'/'.$smmSubCategory->alias)}}">{{$smmSubCategory->translationByLanguage($lang->id)->first()->name}}</a>

                  @endforeach
              @endif
              </div>
              <div class="btnGreen">
                <div class="btnGreenHover">
                  <a href="{{ url($lang->lang.'/catalog/'.$smmCategory->alias)}}">{{trans('front.product.viewProduct')}}</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="sectionContentBcg bcg2">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-6 col-sm-12 ">
          <div class="faceBlock">
            <p class="pBlock">{{trans('front.home.landing1')}} <br>{{trans('front.home.landing2')}}</p>
            <div class="btnGreen">
              <div class="btnGreenHover">
                <a href="{{url($lang->lang.'/catalog/websites-e-commerce-development/landing-pages')}}">{{trans('front.product.viewProduct')}}</a>
              </div>
            </div>
            <div class="btnm">
              <div class="facebookIcon">
                <div class="btnBcg"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  @if (session()->has('success'))
    <script type="text/javascript">
        $(window).on('load', function() {
            $('#modalSuccess .message').html('{{trans('front.thankYou')}}');
            $('#modalSuccess').modal();

            @php
              session()->forget('success');
            @endphp
        });
    </script>
  @endif
</div>

<div class="modal" id="modalSuccess">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><img src="{{ asset('fronts/img/icons/close.svg') }}" alt=""></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-12 text-center" style="margin-top: 20px;">
              <div class="btnDark message " data-dismiss="modal">

              </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@include('front.modals.messagesModal')
@include('front.inc.footer')
@stop
