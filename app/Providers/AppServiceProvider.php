<?php

namespace App\Providers;

use App\Models\Lang;
use App\Models\Module;
use App\Models\Cart;
use App\Models\WishList;
use App\Models\Promocode;
use App\Models\ProductCategory;
use App\Models\Contact;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // TEMP:
        session(['applocale' => Lang::where('default', 1)->first()->lang]);

        $currentLang = Lang::where('lang', \Request::segment(1))->first()->lang ?? session('applocale');

        session(['applocale' => $currentLang]);

         \App::setLocale($currentLang);

        // ENDTEMP

        View::share('langs', Lang::all());

        View::share('lang', Lang::where('lang', session('applocale') ?? Lang::first()->lang)->first());

        View::share('menu', Module::where('parent_id', 0)->orderBy('position')->get());

        $langForURL = '';
        if ($currentLang != 'ro') {
            $langForURL = $currentLang;
        }
        View::share('urlLang', $langForURL);

        $seoData['seo_title'] = trans('front.seo.title');
        $seoData['seo_description'] = trans('front.seo.description');
        $seoData['seo_keywords'] = trans('front.seo.keywords');

        View::share('seoData', $seoData);

        $this->getUserId();

        View::composer('*', function ($view)
        {
            if(auth('persons')->guest() && isset($_COOKIE['user_id'])) {
              $cartProducts = Cart::where('user_id', $_COOKIE['user_id'])->orderBy('id', 'desc')->get();
              $wishListProducts = WishList::where('user_id', $_COOKIE['user_id'])->orderBy('id', 'desc')->get();
            } else {
              $cartProducts = Cart::where('user_id', auth('persons')->id())->orderBy('id', 'desc')->get();
              $wishListProducts = WishList::where('user_id', auth('persons')->id())->orderBy('id', 'desc')->get();
            }

            $promocode = Promocode::where('id', @$_COOKIE['promocode'])
                                    ->where(function($query){
                                        $query->where('status', 'valid');
                                        $query->orWhere('status', 'partially');
                                    })->first();

            $categories = ProductCategory::where('parent_id', 0)->get();

            $contacts = Contact::all();

            View::share('contacts', $contacts);
            View::share('categories', $categories);
            View::share('promocode', $promocode);
            View::share('wishListProducts', $wishListProducts);
            View::share('cartProducts', $cartProducts);
        });

        View::share('pureAlias', false);
        View::share('prefix', '');

        \URL::forceScheme('https');
    }


    public function getUserId()
    {
        $user_id = md5(rand(0, 9999999).date('Ysmsd'));

        if (\Cookie::has('user_id')) {
            $value = \Cookie::get('user_id');
        }else{
            setcookie('user_id', $user_id, time() + 10000000, '/');
            $value = \Cookie::get('user_id');
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
