<div class="header">
  <div class="menuOpenBurger">
    <div class="navBurger">
         <ul>
           <li class="navItem navItemFill"><a href="{{url($lang->lang.'/catalog')}}">{{trans('front.header.catalog')}}</a></li>
           @if (count($categories) > 0)
               @foreach ($categories as $category)
                 <li class="navItem navItemFill">
                      <a href="{{ url($lang->lang.'/catalog/'.$category->alias) }}">{{$category->translationByLanguage($lang->id)->first()->name}}</a>

                      @if (count($category->subcategories()->get()) > 0)
                          <div class="navItemOpen">
                            <div class="subSection">
                              <div class="row">
                                  @foreach ($category->subcategories()->get() as $subcategory)

                                    <div class="col-12">
                                      <a href="{{ url($lang->lang.'/catalog/'.$category->alias.'/'.$subcategory->alias) }}" class="denSubSection">
                                        {{$subcategory->translationByLanguage($lang->id)->first()->name}}
                                      </a>
                                    </div>

                                    @foreach ($subcategory->products()->get() as $product)
                                      <div class="col-md-4 col-sm-12">
                                        <div class="subSectionItem">
                                          <a href="{{ url($lang->lang.'/catalog/'.$category->alias.'/'.$subcategory->alias.'/'.$product->alias) }}">
                                            @if ($product->mainImage()->first())
                                                <img id="prOneBig1" src="{{ asset('images/products/og/'.$product->mainImage()->first()->src ) }}">
                                            @else
                                                <img src="{{ asset('fronts/img/products/noimage.png') }}" alt="img-advice">
                                            @endif
                                            <span class="denSubSectionItem">
                                              {{$product->translationByLanguage($lang->id)->first()->name}}
                                            </span>
                                          </a>
                                        </div>
                                      </div>
                                    @endforeach

                                  @endforeach
                              </div>
                            </div>
                          </div>
                      @else
                          <div class="navItemOpen">
                            <div class="subSection">
                              <div class="row">
                                @if (count($category->products()->get()) > 0)
                                  @foreach ($category->products()->get() as $product)
                                    <div class="col-md-4 col-sm-12">
                                      <div class="subSectionItem">
                                        <a href="{{ url($lang->lang.'/catalog/'.$category->alias.'/'.$product->alias) }}">
                                          @if ($product->mainImage()->first())
                                              <img id="prOneBig1" src="{{ asset('images/products/og/'.$product->mainImage()->first()->src ) }}">
                                          @else
                                              <img src="{{ asset('fronts/img/products/noimage.png') }}" alt="img-advice">
                                          @endif
                                          <span class="denSubSectionItem">
                                            {{$product->translationByLanguage($lang->id)->first()->name}}
                                          </span>
                                        </a>
                                      </div>
                                    </div>
                                  @endforeach
                                @endif
                              </div>
                            </div>
                          </div>
                      @endif
                 </li>
               @endforeach
           @endif

         </ul>
    </div>
  </div>
  <div class="menuOpenBurgerMobile">
    <div class="navBurger">
      <ul>
        @if (count($categories) > 0)
            @foreach ($categories as $category)
                @if (count($category->subcategories()->get()) > 0)
                  <li class="navItemMob" onclick="openNav(event)">{{$category->translationByLanguage($lang->id)->first()->name}}
                    <div class="navItemOpenMob">
                      <ul>
                        @foreach ($category->subcategories()->get() as $subcategory)
                            <li><a href="{{ url($lang->lang.'/catalog/'.$category->alias.'/'.$subcategory->alias) }}">{{$subcategory->translationByLanguage($lang->id)->first()->name}}</a></li>
                        @endforeach
                      </ul>
                    </div>
                  </li>
                @else
                  <li><a href="{{ url($lang->lang.'/catalog/'.$category->alias) }}">{{$category->translationByLanguage($lang->id)->first()->name}}</a></li>
                @endif
            @endforeach
        @endif
        <li><a href="{{url($lang->lang.'/catalog')}}">{{trans('front.header.catalog')}}</a></li>
        <li><a href="{{url($lang->lang.'/about')}}">{{trans('front.about.about')}}</a></li>
        <li><a href="{{url($lang->lang.'/portfolio')}}">{{trans('front.header.portfolio')}}</a></li>
        {{-- <li><a href="{{url($lang->lang.'/presentation')}}">{{trans('front.header.offer')}}</a></li> --}}
        <li><a href="{{url($lang->lang.'/contacts')}}">{{trans('front.header.contacts')}}</a></li>
      </ul>
    </div>
  </div>
  <div class="row">
    <div class="col-md-3 col-sm-4 col-4 d-flex align-items-center">
      <div class="btnm">
        <div class="burger">
          <div class="btnBcg"></div>
        </div>
      </div>
      <a href="{{ url($lang->lang) }}" class="logo"></a>
    </div>
    <div class="menuUl offset-xl-1 offset-lg-0 offset-md-0 col-xl-5 col-lg-6 col-md-5 col-4">
      <div class="menuList">
        <ul>
          <li><a href="{{url($lang->lang.'/about')}}">{{trans('front.about.about')}}</a></li>
          <li><a href="{{url($lang->lang.'/catalog')}}">{{trans('front.header.catalog')}}</a></li>
          <li><a href="{{url($lang->lang.'/portfolio')}}">{{trans('front.header.portfolio')}}</a></li>
          {{-- <li><a href="{{url($lang->lang.'/presentation')}}">{{trans('front.header.offer')}}</a></li> --}}
          <li><a href="{{url($lang->lang.'/contacts')}}">{{trans('front.header.contacts')}}</a></li>
          {{-- <li>
            <div class="buttonMenuProfile">
              {{trans('front.account')}}
            </div>
          </li> --}}
        </ul>
      </div>
    </div>
    <div class="col-xl-3 col-lg-3 col-md-4 offset-md-0 offset-sm-1 offset-0 col-sm-7 col-8 d-flex">
      <div class="menuOpenSearch menuOpen">
       <div class="row justify-content-end">
         <div class="col-md-2 col-3">
           <div class="closeMenu"></div>
         </div>
       </div>
       <div class="row justify-content-between heightMenuOpen">
         <div class="col-lg-9 col-md-10 col-sm-10 col-9">
           <div class="row justify-content-center">
             <form class="col-12" action="{{url($lang->lang.'/search')}}" method="get">
               <div class="col-12">
                 <div class="inputOpen">
                   <input type="text" name="value" value="" class="search-field" placeholder="Cauta produs...">
                 </div>
               </div>
               <div class="searchResult col-12">
                 @include('front.inc.searchResults')
               </div>
               <div class="col-md-6 col-sm-10">
                 <div class="inputSearch">
                   <input type="submit" value="{{trans('front.header.search')}}">
                 </div>
               </div>
             </form>
           </div>
         </div>
         <div class="col-sm-2 col-3">
         </div>
       </div>
      </div>
      <div class="menuOpenProfile menuOpen">
       <div class="row justify-content-end">
         <div class="col-md-2 col-3">
           <div class="closeMenu"></div>
         </div>
       </div>
       @if(Auth::guard('persons')->check())
         <div class="row justify-content-between">
           <div class="col-lg-9 col-md-10 col-sm-10 col-9">
             <div class="row justify-content-center">
               <div class="col-12">
                 <div class="nameUser">{{trans('front.header.salutare')}}{{Auth::guard('persons')->user()->name}} {{Auth::guard('persons')->user()->surname}}</div>
               </div>
               <div class="col-md-8 col-sm-10">
                 <div class="buttonCart">
                   <a href="https://itmall.land/platform/clientarea.php">{{trans('front.header.clientAreaButton')}}</a>
                 </div>
                 <div class="buttonCart">
                   <a href="{{ url($lang->lang.'/logout')}}">{{trans('front.header.logout')}}</a>
                 </div>
               </div>
             </div>
           </div>
           <div class="col-sm-2 col-3">
           </div>
         </div>
       @else
         <div class="row justify-content-between heightMenuOpen">
           <div class="col-lg-9 col-md-10 col-sm-10 col-9">
             <div class="row justify-content-center unloggedUser">
               <div class="col-12">
                 <div class="nameUser">{{trans('front.account')}}</div>
               </div>
               <div class="col-12"><p>{{trans('front.header.welcome')}}</p></div>
               <div class="col-md-6 col-sm-10">
                 <div class="buttonCart">
                   <a href="{{url($lang->lang.'/login')}}">{{trans('front.header.login')}}</a>
                 </div>
               </div>
               <div class="col-12">
                 <div class="logRet">{{trans('front.header.loginWith')}}
                   <!-- <a href="{{ url($lang->lang.'/login/facebook') }}"><img src="{{asset('fronts/img/icons/fLog.svg') }}" alt=""></a> -->
                   <a href="{{ url($lang->lang.'/login/google') }}"><img src="{{asset('fronts/img/icons/gLog.svg') }}" alt=""></a>
                 </div>
               </div>
               <div class="col-12"><p>{{trans('front.header.new')}}</p></div>
               <div class="col-md-6 col-sm-10">
                 <div class="buttonCart">
                   <a href="{{url($lang->lang.'/register')}}">{{trans('front.header.register')}}</a>
                 </div>
               </div>
             </div>
           </div>
           <div class="col-sm-2 col-3">

           </div>
         </div>
       @endif
      </div>
      <div class="menuOpenCart menuOpen">
       <div class="row justify-content-end">
         <div class="col-md-2 col-3">
           <div class="closeMenu"></div>
         </div>
       </div>
       <div class="row justify-content-between heightMenuOpen">
         <div class="col-lg-9 col-md-10 col-sm-10 col-9">
           <div class="row justify-content-center">
             <div class="col-12">
               <div class="nameUser">{{trans('front.cart.page')}}</div>
             </div>
             <div class="col-12 cartBox">
               @include('front.inc.cartBox')
             </div>
             <div class="col-md-6 col-sm-10">
               <div class="buttonCart">
                 <a href="{{ url($lang->lang.'/cart') }}">{{trans('front.header.cart')}}</a>
               </div>
             </div>
           </div>
         </div>
         <div class="col-sm-2 col-3">
         </div>
       </div>
      </div>
      <div class="menuOpenWish menuOpen">
       <div class="row justify-content-end">
         <div class="col-md-2 col-3">
           <div class="closeMenu"></div>
         </div>
       </div>
       <div class="row justify-content-between heightMenuOpen">
         <div class="col-lg-9 col-md-10 col-sm-10 col-9">
           <div class="row justify-content-center">
             <div class="col-12">
               <div class="nameUser">{{trans('front.wishList.page')}}</div>
             </div>
             <div class="col-12 wishListBox">
                @include('front.inc.wishListBox')
             </div>
             <div class="col-md-6 col-sm-10">
               <div class="buttonCart">
                 <a href="{{ url($lang->lang.'/wishList') }}">{{trans('front.header.goToFavorit')}}</a>
               </div>
             </div>
           </div>
         </div>
         <div class="col-sm-2 col-3">
         </div>
       </div>
      </div>
      <div class="menuOpenLang menuOpen">
       <div class="row justify-content-between heightMenuOpen">
         <div class="col-lg-9 col-md-10 col-sm-10 col-9">
           <?php $pathWithoutLang = pathWithoutLang(Request::path(), $langs);?>

           @if (!empty($langs))
               @foreach ($langs as $key => $oneLang)
                   <a class="langOption" href="{{ url($oneLang->lang.'/'.$pathWithoutLang) }}">{{ $oneLang->lang }}</a>
               @endforeach
           @endif
         </div>
         <div class="col-sm-2 col-3">
         </div>
       </div>
      </div>
      <ul class="menu">
          <li class="btnm">
            <div class="buttonMenuSearch">
              <div class="btnBcg"></div>
            </div>
          </li>
          <li class="btnm cartCount">
            @include('front.inc.cartCount')
          </li>
          {{-- <li class="btnm btnMobile">
            <div class="buttonMenuProfile buttonMenuProfileElements">
              <div class="btnBcg"></div>
            </div>
          </li> --}}
          <li class="btnm wishListCount">
            @include('front.inc.wishListCount')
          </li>
          <li class="btnm buttLang">
            <div class="buttonMenuLang">
              @if (Request::segment(1))
                {{Request::segment(1)}}
              @else
                {{$langs[0]->lang}}
              @endif
              <div class="btnBcg"></div>
            </div>
          </li>
        </ul>
    </div>
  </div>
</div>
