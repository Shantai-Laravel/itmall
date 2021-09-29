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
               <li><a href="{{url($lang->lang.'/blogs')}}">{{trans('front.header.blog')}}</a></li>
             </ul>
          </div>
       </div>
       <div class="row blogImg">
         <div class="col-12"> <img src="{{asset('fronts/img/icons/blogOneItem.png')}}" alt="" style="width: 100%; margin: 10px 0; margin-bottom: 20px;"></div>
       </div>
       <div class="row justify-content-center">
         <div class="col-12">
           <div class="row justify-content-center">
             <div class="col-auto blog">
               <h3>{{trans('front.article')}}</h3>
             </div>
           </div>
         </div>
         <div class="col-auto blOptions">
           <div class="btnBlog">
             {{trans('front.categoryChoose')}}
           </div>
            <div class="blogOptions">
              @if (count($blogCategories) > 0)
                @foreach ($blogCategories as $category)
                  <div class="option1 filterBlogs" data-id="{{$category->id}}">{{$category->translationByLanguage($lang->id)->first()->name}}</div>
                @endforeach
              @endif
           </div>
         </div>
       </div>
       <div class="row justify-content-center">
         <div class="blogs row justify-content-center">
           @include('front.blogs.items')
         </div>
         <div class="col-lg-4">
           <a href="#" class="btnBlog2" id="addMoreBlogs" data-id="0">{{trans('front.moreArticles')}}</a>
         </div>
       </div>
     </div>
  </div>
</div>
@include('front.inc.footer')
@stop
