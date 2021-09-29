@extends('front.app')
@section('content')
@include('front.inc.header')
<div id="cover">
  <div class="cart">
     <div class="container">
        <div class="row crumbs">
          <div class="col-12">
             <ul>
                <li><a href="{{ url($lang->lang) }}">{{trans('front.homeText')}}</a>/</li>
                <li><a href="{{ url($lang->lang.'/cart') }}">{{trans('front.cart.cart')}}</a></li>
             </ul>
          </div>
         </div>
        <div class="row justify-content-center comandSucces">
               <div class="col-auto">
                  <h3>{{trans('front.cart.page')}}</h3>
               </div>
        </div>
        <div class="productsList">
               <div class="row prodheader">
                  <div class="col-md-5">
                     {{trans('front.cart.product')}}
                  </div>
                  <div class="col-md-2 text-center">
                     {{trans('front.cart.price')}}
                  </div>
                  <div class="col-md-3 text-center">
                     {{trans('front.cart.cant')}}
                  </div>
                  <div class="col-md-2">
                     {{trans('front.cart.finalSum')}}
                  </div>
               </div>
               <div class="cartTitleMobile">
                  <div class="row">
                     <div class="col-auto">
                         {{trans('front.cart.product')}}
                     </div>
                  </div>
               </div>

               <div class="cartBlock">
                 @include('front.inc.cartBlock')
               </div>
        </div>
        <div class="deliveryCart">
               <div class="row">
                 @if (count($generalFields) > 0)
                    @foreach ($generalFields as $generalField)
                        @if ($generalField->name === 'order')
                          <div class="col-md-3 col-sm-6 col-12">
                             <div class="deliveryItem">
                                <div class="deliveryTitle">
                                   {{$generalField->translationByLanguage($lang->id)->first()->name}}
                                </div>
                                <p>{{$generalField->translationByLanguage($lang->id)->first()->body}}</p>
                             </div>
                          </div>
                        @endif
                    @endforeach
                 @endif
               </div>
            </div>
        <div class="deliveryDetail">
           <form action="{{ url($lang->lang.'/order') }}" method="post" class="orderForm">
             {{ csrf_field() }}
              <div class="row parentCart">
                   <div class="col-12">
                      <div class="row">
                         <div class="col-12">
                            <h4>{{trans('front.cart.details')}}</h4>
                         </div>
                         <div class="col-12">
                            <p>{{trans('front.cart.fillDelivery')}} </p>
                         </div>
                         <div class="col-12">
                            <div class="row">
                              @if(Auth::guard('persons')->check())
                                @if (count($userfields) > 0)
                                <div class="col-12">
                                    <div class="row">
                                      @foreach ($userfields as $key => $userfield)
                                        @if ($userfield->field_group == 'personaldata' && $userfield->type != 'checkbox')
                                        <?php $field = $userfield->field; ?>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="usr">{{trans('front.cart.'.$field)}}<b>*</b></label>
                                                <input type="hidden" name="userfield_id[]" value="{{$userfield->id}}">
                                                <input type="text" name="{{$field}}" class="form-control" id="usr" value="{{$userdata->$field}}">
                                                @if ($errors->has($userfield->field))
                                                <div class="invalid-feedback" style="display: block">
                                                    {!!$errors->first($userfield->field)!!}
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                        @endif
                                      @endforeach
                                    </div>
                                </div>
                                @endif
                                <div class="col-12">
                                 <h4>{{trans('front.cart.payWith')}}</h4>
                                </div>
                                <div class="col-12">
                                 <div class="row">
                                   <div class="col-lg-5 col-md-6 col-10 radioBoxColumn">
                                     <input type="hidden" name="payment" value="">
                                     <label class="container1">{{trans('front.cart.paymentcard')}}
                                       <input type="radio" name="payment" value="card">
                                       <span class="checkmark1"></span>
                                     </label>
                                     <label class="container1">{{trans('front.cart.paymentpaypal')}}
                                       <input type="radio" name="payment" value="paypal">
                                       <span class="checkmark1"></span>
                                     </label>
                                     <label class="container1">{{trans('front.cart.paymentmoney')}}
                                       <input type="radio" name="payment" checked value="banktransfer">
                                       <span class="checkmark1"></span>
                                     </label>
                                     @if ($errors->has('payment'))
                                     <div class="invalid-feedback" style="display: block">
                                         {!!$errors->first('payment')!!}
                                     </div>
                                     @endif
                                   </div>
                                 </div>
                                </div>
                              @else
                                  <div class="col-12 borderRadio">
                                     <div class="row">
                                       <div class="col-lg-5 col-md-8 col-10 radioBox">
                                          <label class="container1">{{trans('front.cart.newClient')}}
                                            <input type="radio" name="radio" checked>
                                            <span class="checkmark1"></span>
                                          </label>
                                          <label class="container1" >
                                            {{trans('front.cart.oldClient')}}
                                             <input type="radio" name="radio" data-toggle="modal" data-target="#modLog">
                                             <span class="checkmark1"></span>
                                          </label>
                                       </div>
                                     </div>
                                   </div>
                                   @if (count($userfields) > 0)
                                   <div class="col-12">
                                       <div class="row">
                                         @foreach ($userfields as $key => $userfield)
                                           @if ($userfield->field_group == 'personaldata' && $userfield->type != 'checkbox')
                                           <?php $field = $userfield->field; ?>
                                           <div class="col-md-4">
                                               <div class="form-group">
                                                   <label for="usr">{{trans('front.cart.'.$field)}}<b>*</b></label>
                                                   <input type="hidden" name="userfield_id[]" value="{{$userfield->id}}">
                                                   <input type="text" name="{{$field}}" class="form-control" id="usr" value="{{old($field)}}">
                                                   @if ($errors->has($userfield->field))
                                                   <div class="invalid-feedback" style="display: block">
                                                       {!!$errors->first($userfield->field)!!}
                                                   </div>
                                                   @endif
                                               </div>
                                           </div>
                                           @endif
                                         @endforeach
                                       </div>
                                   </div>
                                   @endif
                                  <div class="col-12">
                                    <h4>{{trans('front.cart.payWith')}}</h4>
                                  </div>
                                  <div class="col-12">
                                    <div class="row">
                                      <div class="col-lg-5 col-md-6 col-10 radioBoxColumn">
                                        <input type="hidden" name="payment" value="">
                                        <label class="container1">{{trans('front.cart.paymentcard')}}
                                          <input type="radio" name="payment" value="card">
                                          <span class="checkmark1"></span>
                                        </label>
                                        <label class="container1">{{trans('front.cart.paymentpaypal')}}
                                          <input type="radio" name="payment" value="paypal">
                                          <span class="checkmark1"></span>
                                        </label>
                                        <label class="container1">{{trans('front.cart.paymentmoney')}}
                                          <input type="radio" name="payment" checked value="banktransfer">
                                          <span class="checkmark1"></span>
                                        </label>
                                        @if ($errors->has('payment'))
                                        <div class="invalid-feedback" style="display: block">
                                            {!!$errors->first('payment')!!}
                                        </div>
                                        @endif
                                      </div>
                                    </div>
                                  </div>
                                  @if (count($userfields) > 0)
                                    @foreach ($userfields as $key => $userfield)
                                        @if ($userfield->type == 'checkbox')
                                        <div class="col-12 police">
                                          <h4>{{trans('front.register.'.$userfield->field.'_question')}}</h4>
                                          <p>{{trans('front.register.'.$userfield->field.'_p')}}</p>
                                          <div class="row">
                                            <div class="col-12">
                                              <label class="containerCheck">{!!trans('front.register.'.$userfield->field.'_checkbox')!!}
                                                <input type="checkbox" name="{{$userfield->field}}">
                                                <span class="checkmarkCheck"></span>
                                                @if ($errors->has($userfield->field))
                                                   <div class="invalid-feedback" style="display: block">
                                                     {!!$errors->first($userfield->field)!!}
                                                   </div>
                                                @endif
                                              </label>
                                            </div>
                                          </div>
                                        </div>
                                        @endif
                                    @endforeach
                                  @endif
                                  <!--<div class="col-12 recaptha">-->
                                  <!--  <span class="msg-error error"></span>-->
                                  <!--  <div id="recaptcha" class="g-recaptcha " data-sitekey="{{ env('RE_CAP_SITE') }}"></div>-->
                                  <!--  @if ($errors->has('captcha'))-->
                                  <!--     <div class="invalid-feedback" style="display: block">-->
                                  <!--       {!!$errors->first('captcha')!!}-->
                                  <!--     </div>-->
                                  <!--  @endif-->
                                  <!--</div>-->
                              @endif
                             </div>
                         </div>
                         <div class="col-md-4 col-sm-5 col-6">
                           <div class="buttCart">
                             <input type="submit" value="{{trans('front.cart.command')}}">
                           </div>
                         </div>
                      </div>
                    </div>
               </div>
           </form>
        </div>
    </div>
  </div>
</div>

<div class="modal" id="modLog">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title">Autentificare</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
         </div>
         <div class="modal-body">
           <form action="{{ url($lang->lang.'/login') }}" method="post">
             {{ csrf_field() }}

             @if (count($loginFields) > 0)
                 <div class="row justify-content-center">
                   @foreach ($loginFields as $key => $userfield)
                     <div class="col-12">
                       <div class="form-group">
                         <label for="{{$userfield->field}}">{{trans('front.register.'.$userfield->field)}}</label>
                         <input type="text" class="form-control" name="{{$userfield->field}}" id="{{$userfield->field}}" value="{{ old($userfield->field) }}">
                         @if ($errors->has($userfield->field))
                            <div class="invalid-feedback" style="display: block">
                              {!!$errors->first($userfield->field)!!}
                            </div>
                         @endif
                       </div>
                     </div>
                   @endforeach
                   <div class="col-12">
                     <div class="form-group">
                       <label for="usr">Parola<b>*</b></label>
                       <input type="password" class="form-control" name="password" id="pwdLog">
                       @if ($errors->has('password'))
                          <div class="invalid-feedback" style="display: block">
                            {!!$errors->first('password')!!}
                          </div>
                       @endif
                     </div>
                   </div>
                 </div>
             @endif

             <div class="row justify-content-center">
               <div class="col-12">
                 <div class="row justify-content-center" style="margin-bottom: 15px;">
                   <!-- <div class="col-2">
                     <a href="{{ url($lang->lang.'/login/facebook') }}"><img src="{{asset('fronts/img/icons/fLog.svg')}}" alt=""></a>
                   </div> -->
                   <div class="col-2">
                     <a href="{{ url($lang->lang.'/login/google') }}"><img src="{{asset('fronts/img/icons/gLog.svg')}}" alt=""></a>
                   </div>
                 </div>
               </div>
               <div class="col-12">
                 <div class="buttCart">
                   <input type="submit" name="" value="Autentificate">
                 </div>
               </div>
               <div class="col-12"><a href="{{route('password.email')}}">Ai uitat parola?</a></div>
             </div>
           </form>
         </div>
       </div>
    </div>
 </div>

@include('front.inc.footer')
@stop
