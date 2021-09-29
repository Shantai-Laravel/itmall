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
  <div class="bannerProduct">
    <img src="img/icons/bcgProduct.png" alt="">
  </div>
  <div class="catsProduct cats">
    <div class="container">
      <div class="row crumbs">
         <div class="col-auto">
            <ul>
               <li><a href="#">{{trans('front.homeText')}}</a>/</li>
               @if (isset($subcategory))
                  <li><a href="{{ url($lang->lang.'/catalog/'.$category->alias)}}">{{$category->translationByLanguage($lang->id)->first()->name}}</a>/</li>
                  <li><a href="{{ url($lang->lang.'/catalog/'.$category->alias.'/'.$subcategory->alias)}}">{{$subcategory->translationByLanguage($lang->id)->first()->name}}</a></li>
               @else
                  <li><a href="{{ url($lang->lang.'/catalog/'.$category->alias)}}">{{$category->translationByLanguage($lang->id)->first()->name}}</a></li>
               @endif
            </ul>
         </div>
      </div>
      <div class="row justify-content-center">
        <div class="col-10">
          @if (isset($subcategory))
            <h3>{{trans('front.pricingPlans')}} {{$subcategory->translationByLanguage($lang->id)->first()->name}}</h3>
            <p>{{$subcategory->translationByLanguage($lang->id)->first()->body}}</p>

          @else
            <h3>{{trans('front.pricingPlans')}} {{$category->translationByLanguage($lang->id)->first()->name}}</h3>
            <p>{{$category->translationByLanguage($lang->id)->first()->body}}</p>

          @endif
        </div>
      </div>
      <div class="row justify-content-center">
      @if (count($products) > 0)
          @foreach ($products as $product)
            <div class="col-lg-4 col-md-4 col-sm-8 col-12">
              <div class="catsProductItem {{ $product->price !== $products->min('price') && $product->price !== $products->max('price') ? 'mostPopular': '' }}">
                @if ($product->price !== $products->min('price') && $product->price !== $products->max('price'))
                  <div class="itemBanner">{{trans('front.popular')}}</div>
                @endif
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

                  <div>
                    <p>{!!$product->translationByLanguage($lang->id)->first()->description!!}</p>
                  </div>

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

                  <div class="btnProductMobile">
                    {{trans('front.cart.addToCart')}}
                  </div>
                  @if (isset($subcategory))
                    @if ($product->price !== $products->min('price') && $product->price !== $products->max('price'))
                      <div class="btnGreen">
                        <div class="btnGreenHover">
                          <a href="{{url($lang->lang.'/catalog/'.$category->alias.'/'.$subcategory->alias.'/'.$product->alias)}}">{{trans('front.product.viewProduct')}}</a>
                        </div>
                      </div>
                    @else
                      <div class="btnBlue">
                        <div class="btnBlueHover">
                          <a href="{{url($lang->lang.'/catalog/'.$category->alias.'/'.$subcategory->alias.'/'.$product->alias)}}">{{trans('front.product.viewProduct')}}</a>
                        </div>
                      </div>
                    @endif
                  @else
                    @if ($product->price !== $products->min('price') && $product->price !== $products->max('price'))
                      <div class="btnGreen">
                        <div class="btnGreenHover">
                          <a href="{{url($lang->lang.'/catalog/'.$category->alias.'/'.$product->alias)}}">{{trans('front.product.viewProduct')}}</a>
                        </div>
                      </div>
                    @else
                      <div class="btnBlue">
                        <div class="btnBlueHover">
                          <a href="{{url($lang->lang.'/catalog/'.$category->alias.'/'.$product->alias)}}">{{trans('front.product.viewProduct')}}</a>
                        </div>
                      </div>
                    @endif
                  @endif
                  <div class="btnView">
                  {{trans('front.product.viewDetails')}}
                  </div>
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
                                    @else
                                      <li style="text-decoration: line-through; color: #cccccc">{{$property->translationByLanguage($lang->id)->first()->name}}</li>
                                    @endif
                                  @endif
                              @endforeach
                            </ul>
                          </div>
                      @endforeach
                  @endif
                  <div class="btnItem modalToCart" data-id="{{$product->id}}" data-toggle="modal" data-target="#modalAddCartProduct{{ $product->id }}">
                    {{trans('front.cart.addToCart')}}
                  </div>
                </div>

              </div>
            </div>
          @endforeach
      @endif
      </div>
    </div>
<div class="row txtCats">
  <div class="container">
      <div class="row justify-content-center">
        <div class="col-8">
          <h2>{{trans('front.titles.createShopp')}}</h2>
        </div>
        <div class="col-11">
          <p>
              @if (isset($subcategory))
                  {{ $subcategory->translationByLanguage($lang->id)->first()->seo_text }}
              @else
                  {{ $category->translationByLanguage($lang->id)->first()->seo_text }}
              @endif
          </p>
        </div>
      </div>
  </div>
</div>
</div>
</div>
@include('front.modals.messagesModal')
@include('front.inc.footer')
@stop
