@extends('front.app')
@section('content')
@include('front.inc.header')
<div id="cover">
  <div class="registration blog">
     <div class="container">
       <div class="row crumbs">
          <div class="col-auto">
             <ul>
                <li><a href="{{url($lang->lang)}}">{{trans('front.homeText')}}</a>/</li>
                <li><a href="{{url($lang->lang.'/blogs')}}">{{trans('front.header.blog')}}</a>/</li>
                <li><a href="{{url($lang->lang.'/blogs/'.$blog->translationByLanguage($lang->id)->first()->url) }}">{{$blog->translationByLanguage($lang->id)->first()->title}}</a></li>
             </ul>
          </div>
       </div>
       <div class="row">
         <div class="col-lg-9 col-md-12">
           <div class="row justify-content-center">
             <div class="col-auto blog">
               <h3>{{$blog->translationByLanguage($lang->id)->first()->title}}</h3>
             </div>
           </div>
         </div>
         <div class="col-lg-9 col-md-12">
           @if ($blog->translationByLanguage($lang->id)->first()->image)
            <img src="{{ asset('images/posts/'.$blog->translationByLanguage($lang->id)->first()->image) }}" alt="{{$blog->translationByLanguage($lang->id)->first()->image_alt}}" title="{{$blog->translationByLanguage($lang->id)->first()->image_title}}" class="itemImg">
           @else
            <img src="{{ asset('fronts/img/products/noimage.png') }}" alt="img-advice">
           @endif
           <p>{!!$blog->translationByLanguage($lang->id)->first()->body!!}</p>
         </div>
         <div class="col-3 articles">
           <div class="artRecente">
             <h5>Articole recente</h5>
             @if (count($recentPosts) > 0)
                <ul class="d-flex flex-column">
                    @foreach ($recentPosts as $recentPost)
                        <a href="{{ url($lang->lang.'/blogs/'.$recentPost->translationByLanguage($lang->id)->first()->url) }}">{{$recentPost->translationByLanguage($lang->id)->first()->title}}</a>
                    @endforeach
                </ul>
             @endif
           </div>
           <div class="chooseCatArt">
             <h5>Alege categoria</h5>
             @if (count($blogCategories) > 0)
               @foreach ($blogCategories as $category)
                 <div class="option1">{{$category->translationByLanguage($lang->id)->first()->name}}</div>
               @endforeach
             @endif
           </div>
         </div>
       </div>
       <div class="articlesMobile">
         <div class="container">
           <div class="row">
             <div class="col-6">
               <div class="chooseCatMobile">
                 <div class="chCat">
                      {{trans('front.categoryChoose')}}
                 </div>
                 <div class="chooseCatOpenMob dspNone">
                   <div class="row justify-content-end" style="padding: 0 25px;">
                     <div class="closeModalMenu"><img src="{{asset('fronts/img/icons/closeModal.png')}}" alt=""></div>
                   </div>
                   @if (count($blogCategories) > 0)
                     @foreach ($blogCategories as $category)
                       <div class="option1 bcgDropBlog">{{$category->translationByLanguage($lang->id)->first()->name}}</div>
                     @endforeach
                   @endif
                 </div>
               </div>
             </div>
             <div class="col-6">
               <div class="artRecenteMobile">
                 <div class="chCat2">
                   {{trans('front.inspiration')}}
                 </div>
                 <div class="chooseCatOpenMob2 dspNone">
                   <div class="row justify-content-end" style="padding: 0 25px;">
                     <div class="closeModalMenu"><img src="{{asset('fronts/img/icons/closeModal.png')}}" alt=""></div>
                   </div>
                   @if (count($recentPosts) > 0)
                      <ul class="d-flex flex-column">
                          @foreach ($recentPosts as $recentPost)
                              <a href="{{ url($lang->lang.'/blogs/'.$recentPost->translationByLanguage($lang->id)->first()->url) }}">{{$recentPost->translationByLanguage($lang->id)->first()->title}}</a>
                          @endforeach
                      </ul>
                   @endif
                 </div>
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
             <h3>{{trans('front.home.mostPopular')}}</h3>
           </div>
           <div class="col-12">
             @if (count($randomPosts) > 0)
               <div class="slideOneProduct">
                 @foreach ($randomPosts as $randomPost)
                   <div class="itemBlog">
                     @if ($randomPost->translationByLanguage($lang->id)->first()->image)
                      <img src="{{ asset('images/posts/'.$randomPost->translationByLanguage($lang->id)->first()->image) }}" alt="{{$randomPost->translationByLanguage($lang->id)->first()->image_alt}}" title="{{$randomPost->translationByLanguage($lang->id)->first()->image_title}}" class="itemImg">
                     @else
                      <img src="{{ asset('fronts/img/products/noimage.png') }}" alt="img-advice">
                     @endif
                     <div class="bannerBlock">
                       <a href="{{ url($lang->lang.'/blogs/'.$randomPost->translationByLanguage($lang->id)->first()->url) }}">
                         <div class="titleBlock">{{$randomPost->translationByLanguage($lang->id)->first()->title}}</div>
                         <p>{!!substr($randomPost->translationByLanguage($lang->id)->first()->body, 0, 100) . '...'!!}</p>
                       </a>
                     </div>
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
@include('front.inc.footer')
@stop
