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
  <div class="search">
    <div class="container">
      <div class="row crumbs">
         <div class="col-auto">
            <ul>
               <li><a href="{{url($lang->lang)}}">{{trans('front.homeText')}}</a>/</li>
               <li><a href="{{url($lang->lang.'/search')}}">{{trans('front.search.search')}}</a></li>
            </ul>
         </div>
      </div>
      <div class="row">
        <div class="col-12">
          <h3>{{trans('front.search.result')}} {{$search}}</h3>
        </div>
      </div>
      <div class="row searchInputs justify-content-center">
        <div class="col-12">
          <form action="{{url($lang->lang.'/search')}}" method="get">
            <div class="row justify-content-center">
              <div class="col-8">
                <input type="text" name="value" value="{{$search}}" placeholder="search...">
              </div>
              <div class="col-sm-4 col-8">
                <div class="buttCart">
                  <input type="submit" value="search">
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
      <div class="sort">
        <div class="row justify-content-center">
          <div class="col-auto nameRadio">{{trans('front.product.sort')}}:</div>
          <div class="col-auto contRadio1">
            <label class="containerSearch">
              <input type="radio" name="radio1">
              <span class="checkSearch sortByHighPrice">{{trans('front.product.desc')}}</span>
            </label>
          </div>
          <div class="col-auto contRadio2">
            <label class="containerSearch">
              <input type="radio" name="radio1">
              <span class="checkSearch sortByLowPrice">{{trans('front.product.asc')}}</span>
            </label>
          </div>
        </div>
      </div>
      <div class="row justify-content-center searchBox">
        @include('front.inc.searchBox')
      </div>
    </div>
  </div>
</div>
@include('front.inc.footer')
@stop
