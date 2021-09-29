@extends('front.app')
@section('content')
@include('front.inc.header')
    <div id="cover">
      <div class="payOnline blog">
          <div class="container">
              <div class="row crumbs">
                <div class="col-auto">
                   <ul>
                      <li><a href="{{ url($lang->lang)}}">{{trans('front.homeText')}}</a>/</li>
                      <li><a href="{{ url($lang->lang.'/payOnline')}}">{{ucfirst($page->translations()->first()->title)}}</a></li>
                   </ul>
                </div>
              </div>
              {!!$page->translationByLanguage($lang->id)->first()->body!!}
          </div>
      </div>
    </div>
@include('front.inc.footer')
@stop
