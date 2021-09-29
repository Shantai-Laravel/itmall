@extends('front.app')
@section('content')
@include('front.inc.header')
<div id="cover">
  <div class="registration about">
     <div class="container">
       <div class="row crumbs">
          <div class="col-auto">
             <ul>
                <li><a href="{{ url($lang->lang)}}">{{trans('front.homeText')}}</a>/</li>
                <li><a href="{{url($lang->lang.'/contacts')}}">{{trans('front.header.contacts')}}</a></li>
             </ul>
          </div>
       </div>
       <div class="row justify-content-center">
          <div class="col-12">
             <h4>{{trans('front.footer.contactUs')}}</h4>
          </div>
          <div class="col-12">
            <div class="contactBlock fwb">{{trans('front.contact.work')}}</div>
            <div class="contactBlock">{{trans('front.contact.moond')}}: <span class="fwb">{{getContactInfo('workWeekdays')->translationByLanguage()->first()->value}}</span></div>
            <div class="contactBlock">{{trans('front.contact.saturd')}}: <span class="fwb">{{getContactInfo('workWeekends')->translationByLanguage()->first()->value}}</span></div>
            <div class="contactBlock">{{trans('front.contact.sunday')}}: <span class="fwb">{{getContactInfo('weekend')->translationByLanguage($lang->id)->first()->value}}</span></div>
          </div>
          <div class="col-lg-8 col-md-10">
            <div style="width: 100%">
              <!-- <iframe width="100%" height="600" src="https://maps.google.com/maps?width=100%&amp;height=600&amp;hl=en&amp;q={{getContactInfo('address')->translationByLanguage($lang->id)->first()->value}}+(My%20Business%20Name)&amp;ie=UTF8&amp;t=&amp;z=16&amp;iwloc=B&amp;output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"><a href="https://www.maps.ie/create-google-map/">Embed Google Map</a></iframe> -->
<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d680.0017168952819!2d28.826278411454727!3d47.02047021297768!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x40c97c2d803158bb%3A0x1a848a438c5e5965!2zU3RyYWRhIEFsZXhlaSDFnmNpdXNldiA3MywgQ2hpyJlpbsSDdSwg0JzQvtC70LTQsNCy0LjRjw!5e0!3m2!1sru!2s!4v1551802661431" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>              </div><br />
          </div>
          <div class="col-lg-4 col-md-10">
            <div class="contactForm">
              <form action="{{ url($lang->lang.'/contacts') }}" method="post">
                {{ csrf_field() }}

                @if (Session::has('success'))
                    <div class="row">
                       <div class="col-12">
                          <div class="errorPassword">
                             <p>{{ Session::get('success') }}</p>
                          </div>
                       </div>
                    </div>
                @endif

                <div class="row">
                  <div class="col-12">
                    <div class="contactTitle">{{getContactInfo('site')->translationByLanguage()->first()->value}}</div>
                  </div>
                  <div class="col-12">{{getContactInfo('address')->translationByLanguage($lang->id)->first()->value}}</div>
                  <div class="col-12">
                    @if (count(getContactInfo('phone')) > 0)
                        @foreach (getContactInfo('phone')->translationByLanguage()->get() as $contact)
                            <a href="tel:{{$contact->value}}">Tel.: {{$contact->value}}</a>
                        @endforeach
                    @endif
                  </div>
                  <div class="col-12">
                    <div class="form-group">
                      <label for="usr">{{trans('front.cart.name')}}<b>*</b></label>
                      <input type="text" name="fullname" class="form-control" id="usr">
                      @if ($errors->has('fullname'))
                         <div class="invalid-feedback" style="display: block">
                           {!!$errors->first('fullname')!!}
                         </div>
                      @endif
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="form-group">
                      <label for="email">{{trans('front.cart.email')}}<b>*</b></label>
                      <input type="email" name="email" class="form-control" id="email">
                      @if ($errors->has('email'))
                         <div class="invalid-feedback" style="display: block">
                           {!!$errors->first('email')!!}
                         </div>
                      @endif
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="form-group">
                      <label for="tel">{{trans('front.cart.phone')}}<b>*</b></label>
                      <input type="text" name="phone" class="form-control" id="tel">
                      @if ($errors->has('phone'))
                         <div class="invalid-feedback" style="display: block">
                           {!!$errors->first('phone')!!}
                         </div>
                      @endif
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="form-group">
                      <label for="tel">{{trans('front.cart.message')}}<b>*</b></label>
                      <input type="text" name="phone" class="form-control" id="tel">
                      @if ($errors->has('message'))
                         <div class="invalid-feedback" style="display: block">
                           {!!$errors->first('message')!!}
                         </div>
                      @endif
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="buttCart">
                      <input type="submit" value="{{trans('front.cart.send')}}">
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
       </div>
     </div>
  </div>
</div>
@include('front.inc.footer')
@stop
