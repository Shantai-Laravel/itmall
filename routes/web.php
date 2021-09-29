<?php

$prefix = session('applocale');
$lang = App\Models\Lang::where('default', 1)->first();

Route::get('/', 'PagesController@index')->name('home');

Route::get('/sitemap.xml', 'SitemapController@xml')->name('sitemap.xml');

Route::group(['prefix' => $prefix], function() {

    Route::get('/404', 'PagesController@get404')->name('404');

    Route::get('/sitemap', 'SitemapController@html')->name('sitemap.html');

    Route::post('/changeLang', 'LanguagesController@changeLang');

    Route::get('/register', 'Auth\RegistrationController@create');
    Route::post('/register', 'Auth\RegistrationController@store');
    Route::get('/register/authorizeUser/{user}', 'Auth\RegistrationController@authorizeUser');
    Route::get('/register/changePass/{user}', 'Auth\RegistrationController@changePass');

    Route::get('/login', 'Auth\AuthController@create')->name('front.login');
    Route::post('/login', 'Auth\AuthController@store');
    Route::get('/logout', 'Auth\AuthController@logout');

    Route::get('/login/{provider}', 'Auth\AuthController@redirectToProvider');
    Route::get('/login/{provider}/callback', 'Auth\AuthController@handleProviderCallback');

    Route::get('/password/email', 'Auth\ForgotPasswordController@getEmail')->name('password.email');
    Route::post('/password/email', 'Auth\ForgotPasswordController@postEmail');

    Route::get('/password/code', 'Auth\ForgotPasswordController@getCode')->name('password.code');
    Route::post('/password/code', 'Auth\ForgotPasswordController@postCode');

    Route::get('/password/reset', 'Auth\ForgotPasswordController@getReset')->name('password.reset');
    Route::post('/password/reset', 'Auth\ForgotPasswordController@postReset');

    Route::get('/blogs', 'BlogController@index')->name('blogs');
    Route::get('/blogs/{blog}', 'BlogController@getBlog');
    Route::post('/blogs/addMoreBlogs', 'BlogController@addMoreBlogs');
    Route::post('/blogs/filterBlogs', 'BlogController@filterBlogs');

    // Ajax request
    Route::post('/addToCart', 'CartController@addToCart');
    Route::post('/cartQty/minus', 'CartController@changeQtyMinus');
    Route::post('/cartQty/plus', 'CartController@changeQtyPlus');
    Route::post('/cart/set/promocode', 'CartController@setPromocode');
    Route::post('/cart/validateProducts', 'CartController@validateProducts');
    Route::post('/removeItemCart', 'CartController@removeItemCart');
    Route::post('/moveFromCartToWishList', 'CartController@moveFromCartToWishList');

    Route::post('/search/autocomplete', 'SearchController@index');
    Route::get('/search', 'SearchController@search');
    Route::post('/search/sort/highPrice', 'SearchController@sortByHighPrice');
    Route::post('/search/sort/lowPrice', 'SearchController@sortByLowPrice');

    Route::get('/', 'PagesController@index')->name('home');

    Route::get('/cart', 'CartController@index')->name('cart');

    Route::get('/wishList', 'WishListController@index')->name('wishList');
    Route::post('/addToWishList', 'WishListController@addToWishList');
    Route::post('/moveFromWishListToCart', 'WishListController@moveFromWishListToCart');
    Route::post('/removeItemWishList', 'WishListController@removeItemWishList');

    Route::post('/order', 'OrderController@index');

    Route::get('/catalog', 'ProductsController@getAllCategories')->name('all-product-categories');
    Route::get('/catalog/{category}', 'ProductsController@getProductsCategories')->name('products-categories');
    Route::get('/catalog/{category}/{subcategory}', 'ProductsController@getProductsCategoriesSubcategories')->name('products-categories-subctegories');
    Route::get('/catalog/{category}/{subcategory}/{product}', 'ProductsController@getProducts')->name('products');

    Route::get('/contacts', 'ContactController@index');
    Route::post('/contacts', 'ContactController@feedBack');
    Route::post('/contacts/feedBackPopup', 'ContactController@feedBackPopup');

    Route::get('/portfolio/{alias}', 'PortfolioController@singlePortfolio')->name('portfolio-single');
    Route::get('/portfolio', 'PortfolioController@index')->name('portfolio');
    Route::get('/{pages}', 'PagesController@getPages')->name('pages');
});
