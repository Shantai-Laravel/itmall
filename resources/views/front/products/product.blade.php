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
<div id="some">
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
  <div class="product">
    <div class="container">
      <div class="row crumbs">
         <div class="col-auto">
            <ul>
               <li><a href="#">{{trans('front.homeText')}}</a>/</li>
               <li><a href="{{ url($lang->lang.'/catalog/'.$category->alias)}}">{{$category->translationByLanguage($lang->id)->first()->name}}</a>/</li>
               @if (isset($subcategory))
                  <li><a href="{{ url($lang->lang.'/catalog/'.$category->alias.'/'.$subcategory->alias)}}">{{$subcategory->translationByLanguage($lang->id)->first()->name}}</a>/</li>
                  <li><a href="{{ url($lang->lang.'/catalog/'.$category->alias.'/'.$subcategory->alias.'/'.$product->alias)}}">{{$product->translationByLanguage($lang->id)->first()->name}}</a></li>
               @else
                  <li><a href="{{ url($lang->lang.'/catalog/'.$category->alias.'/'.$product->alias)}}">{{$product->translationByLanguage($lang->id)->first()->name}}</a></li>
               @endif
            </ul>
         </div>
      </div>
      <div class="row">
        <div class="col-md-8">
          <div class="imgProduct">
            @if ($product->mainImage()->first())
                <img id="prOneBig1" src="{{ asset('images/products/og/'.$product->mainImage()->first()->src ) }}">
            @else
                <img src="{{ asset('fronts/img/products/noimage.png') }}" alt="img-advice">
            @endif
          </div>
          <div class="contentItem">
            @if (count($propertyGroups) > 0 && count($properties) > 0)
                @foreach ($propertyGroups as $propertyGroup)
                    <div class="nameSection">
                      {{$propertyGroup->translationByLanguage($lang->id)->first()->name}}
                    </div>
                    <div class="itemSection">
                      <ul>
                        @foreach ($properties as $property)
                          @if ($property->group_id === $propertyGroup->id)
                            <?php $propertyValueID = getPropertiesData($product->id, $property->id); ?>
                            @if (!is_null($propertyValueID) && $propertyValueID !== 0)
                              <?php $propertyValue = getMultiDataList($propertyValueID, $lang->id); ?>
                              @if (!is_null($propertyValue))
                                @if ($propertyValue->value != '')
                                  <li>{{$property->translationByLanguage($lang->id)->first()->name}}: {{$propertyValue->value}}</li>
                                @else
                                  <li>{{$property->translationByLanguage($lang->id)->first()->name}}</li>
                                @endif
                              @endif
                            @endif
                          @endif
                        @endforeach
                      </ul>
                    </div>
                @endforeach
            @endif
          </div>
        </div>
        <div class="col-4 parent">
          <div class="superParent">
            <div class="headerItem">
              <div class="titleItem">{{$product->translationByLanguage($lang->id)->first()->name}}</div>
              <div class="priceItem">{{$product->price}} <span>euro</span></div>

              <?php
                $propertyValueID = getPropertiesData($product->id, ParameterId('billed'));
              ?>
              @if (!is_null($propertyValueID))
                <?php $propertyValue = getMultiDataList($propertyValueID, $lang->id)->value; ?>
                <div class="billed">{{GetParameter('billed', $lang->id)}}: {{$propertyValue}}</div>
              @endif

              <p>{!!$product->translationByLanguage($lang->id)->first()->description!!}</p>

              <?php
                $propertyValueID = getPropertiesData($product->id, ParameterId('qty-products'));
              ?>
              @if (!is_null($propertyValueID))
                <?php $propertyValue = getMultiDataList($propertyValueID, $lang->id)->value; ?>
                <div class="nrProducts">{{GetParameter('qty-products', $lang->id)}}: {{$propertyValue}}</div>
              @endif

              <?php
                $propertyValueID = getPropertiesData($product->id, ParameterId('included-time'));
              ?>
              @if (!is_null($propertyValueID))
                <?php $propertyValue = getMultiDataList($propertyValueID, $lang->id)->value; ?>
                <div class="nrProducts">{{GetParameter('included-time', $lang->id)}}: {{$propertyValue}}</div>
              @endif

              <div class="btnProduct modalToCart" data-id="{{$product->id}}" data-toggle="modal" data-target="#modalAddCartProduct{{ $product->id }}">
                {{trans('front.cart.addToCart')}}
              </div>
              <div class="btnItem addToWishList" data-id="{{$product->id}}">
                {{trans('front.wishList.addToWishList')}}
              </div>
            </div>
            <div class="imgItMall">
              <div class="img1 it1 t1"><img src="{{asset('fronts/img/icons/iL.png')}}" alt=""></div>

              <div class="img1 it2 t2"><img src="{{asset('fronts/img/icons/iL.png')}}" alt=""></div>
              <div class="img2 it3 t2"><img src="{{asset('fronts/img/icons/tL.png')}}" alt=""></div>

              <div class="img1 it4 t3"><img src="{{asset('fronts/img/icons/iL.png')}}" alt=""></div>
              <div class="img2 it5 t3"><img src="{{asset('fronts/img/icons/tL.png')}}" alt=""></div>
              <div class="img3 it6 t3"><img src="{{asset('fronts/img/icons/mL.png')}}" alt=""></div>

              <div class="img1 it7 t4"><img src="{{asset('fronts/img/icons/iL.png')}}" alt=""></div>
              <div class="img2 it8 t4"><img src="{{asset('fronts/img/icons/tL.png')}}" alt=""></div>
              <div class="img3 it9 t4"><img src="{{asset('fronts/img/icons/mL.png')}}" alt=""></div>
              <div class="img4 it10 t4"><img src="{{asset('fronts/img/icons/aL.png')}}" alt=""></div>



              <div class="img1 it11 t5"><img src="{{asset('fronts/img/icons/iL.png')}}" alt=""></div>
              <div class="img2 it12 t5"><img src="{{asset('fronts/img/icons/tL.png')}}" alt=""></div>
              <div class="img3 it13 t5"><img src="{{asset('fronts/img/icons/mL.png')}}" alt=""></div>
              <div class="img4 it14 t5"><img src="{{asset('fronts/img/icons/aL.png')}}" alt=""></div>
              <div class="img5 it15 t5"><img src="{{asset('fronts/img/icons/lL.png')}}" alt=""></div>

              <div class="img1 it16 t6"><img src="{{asset('fronts/img/icons/iL.png')}}" alt=""></div>
              <div class="img2 it17 t6"><img src="{{asset('fronts/img/icons/tL.png')}}" alt=""></div>
              <div class="img3 it18 t6"><img src="{{asset('fronts/img/icons/mL.png')}}" alt=""></div>
              <div class="img4 it19 t6"><img src="{{asset('fronts/img/icons/aL.png')}}" alt=""></div>
              <div class="img5 it20 t6"><img src="{{asset('fronts/img/icons/lL.png')}}" alt=""></div>
              <div class="img6 it21 t6"><img src="{{asset('fronts/img/icons/lL.png')}}" alt=""></div>

            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="mobileProduct">
      <div class="container">
        <div class="strUp"></div>
        <div class="headerItem">
          <div class="row">
            <div class="col-6"><div class="titleItem">{{$product->translationByLanguage($lang->id)->first()->name}}</div></div>
            <div class="col-6"><div class="priceItem">{{$product->price}} <span>euro</span></div></div>
          </div>
          <div class="productNone">
            <div class="billed">Billed: once</div>
            <p>{!!$product->translationByLanguage($lang->id)->first()->description!!}</p>
            <div class="nrProducts">{{$product->stock}} {{trans('front.footer.catalog')}}</div>
          </div>
          <div class="row btns">
            <div class="col-6">
              <div class="btnProduct modalToCart" data-id="{{$product->id}}" data-toggle="modal" data-target="#modalAddCartProduct{{ $product->id }}">
                {{trans('front.cart.addToCart')}}
              </div>
            </div>
            <div class="col-6">
                <div class="btnItem addToWishList" data-id="{{$product->id}}">
                  {{trans('front.wishList.addToWishList')}}
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row slideProduct">
      <div class="container">
        <div class="row">
          <div class="col-12">
            <h3>{{trans('front.product.ordered2')}}</h3>
          </div>
          <div class="col-12">
            @if (count($randomProducts) > 0)
              <div class="slideOneProduct">
                @foreach ($randomProducts as $randomProduct)
                    <div class="itSlide">
                      <a href="{{ url($lang->lang.'/catalog/'.getParentCategory($randomProduct->category_id, $lang->id).'/'.$randomProduct->alias ) }}">
                        @if ($randomProduct->mainImage()->first())
                            <img id="prOneBig1" src="{{ asset('images/products/og/'.$randomProduct->mainImage()->first()->src ) }}">
                        @else
                            <img src="{{ asset('fronts/img/products/noimage.png') }}" alt="img-advice">
                        @endif
                        <div class="nameSlide">{{$randomProduct->translationByLanguage($lang->id)->first()->name}}</div>
                      </a>
                    </div>
                @endforeach
              </div>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@include('front.modals.messagesModal')
@include('front.inc.footer')
@stop
