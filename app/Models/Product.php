<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['category_id', 'brand_id', 'promotion_id', 'alias', 'position', 'price', 'actual_price', 'discount', 'hit', 'recomended', 'instock', 'qty'];

    public function translations()
    {
        return $this->hasMany(ProductTranslation::class);
    }

    public function category()
    {
        return $this->hasOne(ProductCategory::class, 'id', 'category_id');
    }

    public function translation()
    {
        $lang = Lang::where('lang', session('applocale'))->first()->id ?? Lang::first()->id;

        return $this->hasMany(ProductTranslation::class)->where('lang_id', $lang);
    }

    public function translationByLanguage($lang = 1)
    {
        return $this->hasOne(ProductTranslation::class)->where('lang_id', $lang);
    }

    public function brand()
    {
        return $this->hasOne(Brand::class, 'id', 'brand_id');
    }

    public function mainImage()
    {
        $photo = $this->hasOne(ProductImage::class, 'product_id')->where('main', 1);

        if (!is_null($photo)) {
            $photo = $this->hasOne(ProductImage::class, 'product_id');
        }
        return $photo;
    }

    public function inCart()
    {
        $user_id = auth('persons')->id() ? auth('persons')->id() : @$_COOKIE['user_id'];
        return $this->hasOne(Cart::class, 'product_id')->where('user_id', $user_id);
    }

    public function inWishList()
    {
        $user_id = auth('persons')->id() ? auth('persons')->id() : @$_COOKIE['user_id'];
        return $this->hasOne(WishList::class, 'product_id')->where('user_id', $user_id);
    }

    public function similar()
    {
      return $this->hasMany(ProductSimilar::class);
    }

    public function subproducts()
    {
      return $this->hasMany(SubProduct::class);
    }

    public function subproductById($id)
    {
      return $this->hasOne(SubProduct::class)->where('id', $id);
    }

    public function property()
    {
      return $this->hasMany(SubProductProperty::class, 'product_category_id', 'category_id');
    }

    public function cart()
    {
      return $this->hasOne(Cart::class, 'product_id', 'id');
    }
}
