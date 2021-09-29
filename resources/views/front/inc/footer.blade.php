<?php
    $emails = getContactInfo('emailfront')->translationByLanguage()->get();
    $viber = getContactInfo('viber')->translationByLanguage()->first()->value;
    $whatsapp = getContactInfo('whatsapp')->translationByLanguage()->first()->value;

    $footerText = getContactInfo('footertext')->translationByLanguage($lang->id)->first()->value;

    $pinterest = getContactInfo('pinterest')->translationByLanguage()->first()->value;
    $facebook = getContactInfo('facebook')->translationByLanguage()->first()->value;
    $instagram = getContactInfo('instagram')->translationByLanguage()->first()->value;
    $linkedin = getContactInfo('linkedin')->translationByLanguage()->first()->value;
    $twitter = getContactInfo('twitter')->translationByLanguage()->first()->value;
    $youtube = getContactInfo('youtube')->translationByLanguage()->first()->value;
?>
<div class="foter">
   <div class="container">
     <div class="row">
       <div class="col-12">
         <div class="navBurger">
           <ul>
             <li class="navItemMob" onclick="openNav(event)">{{trans('front.about.main')}}
               <div class="navItemOpenMob">
                 <ul>
                   <li><a href="{{ url($lang->lang.'/about') }}">{{trans('front.about.about')}}</a></li>
                   {{-- <li><a href="{{ url($lang->lang.'/blogs') }}">{{trans('front.header.blog')}}</a></li> --}}
                   <li><a href="{{url($lang->lang.'/contacts')}}">{{trans('front.header.contacts')}}</a></li>
                   <li><a href="{{ url($lang->lang.'/payOnline') }}">{{trans('front.header.payOnline')}}</a></li>
                 </ul>
               </div>
             </li>
             <li class="navItemMob" onclick="openNav(event)">{{trans('front.footer.itProducts')}}
                 @if (count($categories) > 0)
                    <div class="navItemOpenMob">
                      <ul>
                       @foreach ($categories as $key => $category)
                          @if ($key === 3)
                            @break
                          @endif
                          <li><a href="{{ url($lang->lang.'/catalog/'.$category->alias) }}">{{$category->translationByLanguage($lang->id)->first()->name}}</a></li>
                       @endforeach
                      </ul>
                    </div>
                @endif
             </li>
             <li class="navItemMob" onclick="openNav(event)">{{trans('front.footer.marketingProducts')}}
               @if (count($categories) > 0)
                  <div class="navItemOpenMob">
                    <ul>
                     @foreach ($categories as $key => $category)
                        @if ($key >= 3)
                          <li><a href="{{ url($lang->lang.'/catalog/'.$category->alias) }}">{{$category->translationByLanguage($lang->id)->first()->name}}</a></li>
                        @endif
                     @endforeach
                    </ul>
                  </div>
                @endif
             </li>
             <li class="navItemMob" onclick="openNav(event)">{{trans('front.footer.ourSupport')}}
               <div class="navItemOpenMob">
                 <ul>
                   <li><a href="{{ url($lang->lang.'/condition') }}">{{trans('front.about.condition')}}</a></li>
                   <li><a href="{{ url($lang->lang.'/privatePolicy') }}">{{trans('front.about.privacy')}}</a></li>
                   <li><a href="{{ url($lang->lang.'/cookie') }}">{{trans('front.about.cookie')}}</a></li>
                 </ul>
               </div>
             </li>
           </ul>
         </div>
       </div>
       <div class="col-md-3 col-12 dac">
         <h6>{{trans('front.about.main')}}</h6>
         <ul>
           <li><a href="{{ url($lang->lang.'/about') }}">{{trans('front.about.about')}}</a></li>
           {{-- <li><a href="{{ url($lang->lang.'/blogs') }}">{{trans('front.header.blog')}}</a></li> --}}
           <li><a href="{{url($lang->lang.'/contacts')}}">{{trans('front.header.contacts')}}</a></li>
           <li><a href="{{ url($lang->lang.'/payOnline') }}">{{trans('front.header.payOnline')}}</a></li>
         </ul>
       </div>
       <div class="col-md-3 col-12 dac">
         <h6>{{trans('front.footer.itProducts')}}</h6>
         @if (count($categories) > 0)
            <ul>
             @foreach ($categories as $key => $category)
                @if ($key === 3)
                  @break
                @endif
                <li><a href="{{ url($lang->lang.'/catalog/'.$category->alias) }}">{{$category->translationByLanguage($lang->id)->first()->name}}</a></li>
             @endforeach
            </ul>
        @endif
       </div>
       <div class="col-md-3 col-12 dac">
         <h6>{{trans('front.footer.marketingProducts')}}</h6>
         @if (count($categories) > 0)
            <ul>
             @foreach ($categories as $key => $category)
                @if ($key >= 3)
                  <li><a href="{{ url($lang->lang.'/catalog/'.$category->alias) }}">{{$category->translationByLanguage($lang->id)->first()->name}}</a></li>
                @endif
             @endforeach
            </ul>
        @endif
       </div>
       <div class="col-md-3 col-12 dac">
         <h6>{{trans('front.footer.ourSupport')}}</h6>
         <ul>
           <li><a href="{{ url($lang->lang.'/condition') }}">{{trans('front.about.condition')}}</a></li>
           <li><a href="{{ url($lang->lang.'/privatePolicy') }}">{{trans('front.about.privacy')}}</a></li>
           <li><a href="{{ url($lang->lang.'/cookie') }}">{{trans('front.about.cookie')}}</a></li>
         </ul>
       </div>
     </div>
     <div class="row justify-content-center contacts">
       <div class="col-auto">
         <ul>
           <li><a class="contFooter viberFooter" href="#">Viber: {{$viber}}</a></li>
           @if (count($emails) > 0)
             @foreach ($emails as $email)
               <li><a class="contFooter mailFooter" href="mailto:{{$email->value}}">Mail: {{$email->value}}</a></li>
             @endforeach
           @endif
           <li><a class="contFooter whatsappFooter" href="#">Whatsapp: {{$whatsapp}}</a></li>
        </ul>
       </div>
     </div>
     <div class="row justify-content-center ftRet">
       <div class="col-auto">
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
     <div class="row justify-content-center">
       <div class="col-lg-6 col-md-10">
         <p>{{$footerText}}</p>
       </div>
     </div>
     <div class="row justify-content-center">
       <div class="col-auto">
         <a href="#"><img style="width: 250px;" src="{{asset('fronts/img/logo.png')}}" alt=""></a>
       </div>
     </div>
     <div class="row justify-content-center">
       <div class="col-auto">
         <p>©{{date('Y')}}{{trans('front.footer.copyright')}}</p>
       </div>
     </div>
   </div>
</div>

@include('front.inc.scripts')
