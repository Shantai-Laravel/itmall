@extends('front.app')
@section('content')
@include('front.inc.header')
<div id="cover">
  <div class="registration">
     <div class="container">

        <div class="row">
           <div class="col-12 titleNone">
              <h3>{{trans('front.resetPass.name')}}</h3>
           </div>
           <div class="col-lg-3 col-md-6 col-sm-8 col-12 aboutEstel">
             <h4>{{trans('front.register.question')}}</h4>
             <div>{{trans('front.register.motive')}}</div>
              <ol>
                <li>{{trans('front.register.motive1')}}</li>
                <li>{{trans('front.register.motive2')}}</li>
                <li>{{trans('front.register.motive3')}}</li>
                <li>{{trans('front.register.motive4')}}</li>
              </ol>
           </div>
           <div class="col-lg-6 col-sm-12 col-12 regBoxBorder">
              <div class="regBox">
                 <div class="row">
                    <div class="col-12">
                       <h4 class="flexh4">{{trans('front.forgotPass.name')}}</h4>
                    </div>
                 </div>

                 <form action="{{ url()->current() }}" method="post">

                   {{ csrf_field() }}

                    <input type="hidden" name="prev" value="{{url()->previous()}}">

                    @if (Session::has('success'))
                        <div class="row">
                           <div class="col-12">
                              <div class="errorPassword">
                                 <p>{{ Session::get('success') }}</p>
                              </div>
                           </div>
                        </div>
                    @endif

                    <div class="form-group">
                      <label for="pwd">{{trans('front.register.pass')}}<b>*</b></label>
                      <input type="password" class="form-control" name="password" id="pwd" >
                      @if ($errors->has('password'))
                         <div class="invalid-feedback" style="display: block">
                           {!!$errors->first('password')!!}
                         </div>
                      @endif
                    </div>
                    <div class="form-group">
                      <label for="confpwd">{{trans('front.register.repeatPass')}}<b>*</b></label>
                      <input type="password" class="form-control" name="passwordRepeat" id="confpwd" >
                      @if ($errors->has('passwordRepeat'))
                         <div class="invalid-feedback" style="display: block">
                           {!!$errors->first('passwordRepeat')!!}
                         </div>
                      @endif
                    </div>
              </div>
                <div class="row justify-content-start">
                  <div class="col-md-5 col-sm-8 col-8">
                     <div class="buttCart">
                        <input type="submit" value="{{trans('front.resetPass.btnText')}}">
                     </div>
                  </div>
                </div>
              </form>
           </div>
           <div class="col-lg-3 col-md-6 col-sm-8 col-12 aboutEstel">
             <div class="row">
               <div class="col-12"><h4>{{trans('front.about.main')}}</h4></div>
             </div>
             <ul>
               <li><a href="{{ url($lang->lang.'/about')}}">{{trans('front.about.about')}}</a></li>
               <li><a href="{{ url($lang->lang.'/condition')}}">{{trans('front.about.condition')}}</a></li>
               <li><a href="{{ url($lang->lang.'/cookie')}}">{{trans('front.about.cookie')}}</a></li>
               <li><a href="{{ url($lang->lang.'/privatePolicy')}}">{{trans('front.about.privacy')}}</a></li>
               <li><a href="{{ url($lang->lang.'/refundPolicy')}}">{{trans('front.about.refundPrivacy')}}</a></li>
             </ul>
           </div>
        </div>
     </div>
  </div>
</div>
@include('front.inc.footer')
@stop
