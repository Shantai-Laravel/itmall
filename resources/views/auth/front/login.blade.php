@extends('front.app')
@section('content')
@include('front.inc.header')
<div id="cover">
  <div class="registration">
     <div class="container">
        <div class="row">
           <div class="col-12 titleNone">
              <h3>{{trans('front.login.login')}}</h3>
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
              <div class="logSocio">
                <ul>
                  <li><div class="buttCart" style="display: none">
                    <a href="{{ url($lang->lang.'/login/facebook') }}">{{trans('front.register.registerFacebook')}}</a>
                  </div></li>
                  <li><div class="buttCart">
                    <a href="{{ url($lang->lang.'/login/google') }}">{{trans('front.register.registerGoogle')}}</a>
                  </div></li>
                </ul>
              </div>
           </div>
           <div class="col-lg-6 col-sm-12 col-12">
              <div class="regBox">
                 <div class="row">
                    <div class="col-12">
                       <h4 class="flexh4">{{trans('front.login.login')}}</h4>
                    </div>
                 </div>
                 <div class="row justify-content-center">
                   <div class="col-8">
                     <div class="logSocio logSocioMobile">
                       <ul>
                         <li><div class="buttCart" style="display: none">
                           <a href="{{ url($lang->lang.'/login/facebook') }}">{{trans('front.register.registerFacebook')}}</a>
                         </div></li>
                         <li><div class="buttCart">
                           <a href="{{ url($lang->lang.'/login/google') }}">{{trans('front.register.registerGoogle')}}</a>
                         </div></li>
                       </ul>
                     </div>
                   </div>
                 </div>
                 <form action="{{ url($lang->lang.'/login') }}" method="post">
                   {{ csrf_field() }}

                    @if ($errors->has('authErr'))
                        <div class="row">
                           <div class="col-12">
                              <div class="errorPassword">
                                  <p><strong>{{trans('front.error')}}</strong></p>
                                 <p>{!!$errors->first('authErr')!!}</p>
                              </div>
                           </div>
                        </div>
                    @endif

                    @if (Session::has('success'))
                        <div class="row">
                           <div class="col-12">
                              <div class="errorPassword">
                                 <p>{{ Session::get('success') }}</p>
                              </div>
                           </div>
                        </div>
                    @endif

                    @if (count($userfields) > 0)
                        @foreach ($userfields as $key => $userfield)
                            <div class="form-group">
                              <label for="{{$userfield->field}}">{{trans('front.register.'.$userfield->field)}}</label>
                              <input type="text" class="form-control" name="{{$userfield->field}}" id="{{$userfield->field}}" value="{{ old($userfield->field) }}">
                              @if ($errors->has($userfield->field))
                                 <div class="invalid-feedback" style="display: block">
                                   {!!$errors->first($userfield->field)!!}
                                 </div>
                              @endif
                            </div>
                        @endforeach
                    @endif
                    <div class="form-group">
                      <label for="pwdLog" style="float:left;">{{trans('front.login.pass')}}</label><span class="pwdForg"><a href="{{route('password.email')}}">{{trans('front.login.forgotPass')}}</a></span>
                      <input type="password" class="form-control" name="password" id="pwdLog">
                      @if ($errors->has('password'))
                         <div class="invalid-feedback" style="display: block">
                           {!!$errors->first('password')!!}
                         </div>
                      @endif
                    </div>
                    <div class="row justify-content-center">
                       <div class="col-md-4 col-sm-5 col-10">
                          <div class="buttCart">
                               <input type="submit" value="{{trans('front.login.login')}}">
                          </div>
                       </div>
                    </div>
                 </form>
              </div>
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
