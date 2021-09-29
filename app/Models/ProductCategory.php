<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    protected $table = 'product_categories';

    protected $fillable = ['parent_id', 'alias', 'level', 'position', 'img', 'group_id'];

    public function translations() {
        return $this->hasMany(ProductCategoryTranslation::class);
    }

    public function translation()
    {
        $lang = Lang::where('lang', session('applocale'))->first()->id ?? Lang::first()->id;

        return $this->hasMany(ProductCategoryTranslation::class)->where('lang_id', $lang);
    }

    public function translationByLanguage($lang)
    {
        return $this->hasMany(ProductCategoryTranslation::class)->where('lang_id', $lang);
    }

    public function translationByLang($lang)
    {
        return $this->hasOne(ProductCategoryTranslation::class)->where('lang_id', $lang);
    }

    public function properties() {
        return $this->hasMany(SubProductProperty::class, 'product_category_id', 'id')->where('show_property', 1);
    }

    public function subcategories() {
      return $this->hasMany(ProductCategory::class, 'parent_id', 'id');
    }

    public function products() {
        return $this->hasMany(Product::class, 'category_id', 'id');
    }
}
