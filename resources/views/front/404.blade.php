@extends('front.app')
@section('content')
@include('front.inc.header')
<div id="cover">
  <div class="four">
    <div class="container">
      <div class="row">
        <div class="col-lg-8 col-md-10 col-12">
          <img src="{{asset('fronts/img/icons/four.png')}}" alt="">
          <p>
            We looked far and wide for that page and couldn't find it. Try one of these links to get back on track:
          </p>
          <div class="row">
            <div class="col-sm-6 col-8">
              <div class="buttCart">
                <a href="{{url($lang->lang)}}">go to home</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@include('front.inc.footer')
@stop
