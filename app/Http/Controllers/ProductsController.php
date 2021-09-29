<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lang;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductImage;
use App\Models\PropertyCategory;
use App\Models\ProductProperty;
use App\Models\Brand;
use App\Models\PropertyValue;
use App\Models\PropertyGroup;
use App\Models\SubProductProperty;
use App\Models\SubproductCombination;
use App\Models\SubProduct;
use App\Models\UserField;
use App\Models\Country;
use App\Models\Region;
use App\Models\City;
use App\Models\FrontUser;

class ProductsController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index($product) {}

    /**
     *  Single Product page
     */
    public function getProducts($slug, $subcategory, $productSlug)
    {
        $category = ProductCategory::where('alias', $slug)->first();
        $this->_ifExists($category);

        $subcategory = ProductCategory::where('alias', $subcategory)->where('parent_id', $category->id)->first();
        $this->_ifExists($subcategory);

        $product = Product::where('alias', $productSlug)->first();
        $this->_ifExists($product);

        if (view()->exists('front/products/product')) {
            $properties = $this->getProperties($subcategory->id);
            $randomProducts = Product::inRandomOrder()->limit(12)->get();
            $propertyGroups = PropertyGroup::where('id', '!=', 1)->orderBy('position', 'asc')->get();
            $seoData = $this->_getSeo($product);

            return view('front.products.product', compact('seoData', 'category', 'subcategory', 'product', 'randomProducts', 'properties', 'propertyGroups'));
        }else{
            echo "view for ". $category->translationByLanguage($this->lang->id)->first()->name ." is not found";
        }
    }

    /**
     * Subcategory page, second level
     */
    public function getProductsCategoriesSubcategories(Request $request, $slug, $subcategory)
    {
        $category = ProductCategory::where('alias', $slug)->where('parent_id', 0)->first();
        $this->_ifExists($category);

        if(count($category->subcategories()->get()) > 0) {
            $subcategory = ProductCategory::where('alias', $subcategory)->where('parent_id', $category->id)->first();
            $this->_ifExists($subcategory);

            if (view()->exists('front/products/subcategoriesList')) {
                $products = Product::where('category_id', $subcategory->id)->orderBy('position', 'asc')->get();
                $properties = $this->getProperties($subcategory->id);
                $propertyGroups = PropertyGroup::where('id', '!=', 1)->orderBy('position', 'asc')->get();
                $seoData = $this->_getSeo($subcategory);

                return view('front.products.subcategoriesList', compact('seoData', 'category', 'subcategory', 'products', 'properties', 'propertyGroups'));
            } else{
                echo "view for ". $category->translationByLanguage($this->lang->id)->first()->name ." is not found";
            }
        } else {
            $product = Product::where('alias', $subcategory)->first();
            $this->_ifExists($product);

            if (view()->exists('front/products/product')) {
                $properties = $this->getProperties($category->id);
                $randomProducts = Product::inRandomOrder()->limit(12)->get();
                $propertyGroups = PropertyGroup::where('id', '!=', 1)->orderBy('position', 'asc')->get();
                $seoData = $this->_getSeo($product);

                return view('front.products.product', compact('seoData', 'category', 'product', 'randomProducts', 'properties', 'propertyGroups'));
            } else{
                echo "view for ". $category->translationByLanguage($this->lang->id)->first()->name ." is not found";
            }
        }
    }

    /**
     * Category page, first level
     */
    public function getProductsCategories(Request $request, $slug)
    {
        $category = ProductCategory::where('alias', $slug)->where('parent_id', 0)->first();
        $this->_ifExists($category);

        if (view()->exists('front/products/categoriesList')) {
            $subcategories = ProductCategory::where('parent_id', $category->id)->get();
            $seoData = $this->_getSeo($category);

            if (count($subcategories) > 0) {
                return view('front.products.categoriesList', compact('seoData', 'subcategories', 'category'));
            } else {
                $products = Product::where('category_id', $category->id)->orderBy('position', 'asc')->get();
                $properties = $this->getProperties($category->id);
                $propertyGroups = PropertyGroup::where('id', '!=', 1)->orderBy('position', 'asc')->get();

                return view('front.products.subcategoriesList', compact('seoData', 'category', 'products', 'properties', 'propertyGroups'));
            }
        }else{
            echo "view for ". $category->translationByLanguage($this->lang->id)->first()->name ." is not found";
        }
    }

    public function getAllCategories(Request $request)
    {
        $categories = ProductCategory::where('parent_id', 0)->get();

        if (view()->exists('front/products/categoriesList')) {
            return view('front.products.categoriesAll', compact('categories'));
        }else{
            echo "view for ". $category->translationByLanguage($this->lang->id)->first()->name ." is not found";
        }
    }

    // get SEO data for a page
    private function _getSeo($page){
        $seo['seo_title'] = $page->translationByLanguage($this->lang->id)->first()->seo_title;
        $seo['seo_keywords'] = $page->translationByLanguage($this->lang->id)->first()->seo_keywords;
        $seo['seo_description'] = $page->translationByLanguage($this->lang->id)->first()->seo_description;

        return $seo;
    }

    public function getProperties($category_id)
    {
        $properties = [];
        $category = ProductCategory::where('id', $category_id)->first();
        if (!is_null($category)) {
            $properties = array_merge($properties, $this->getPropertiesList($category->id));
            $category1 = ProductCategory::where('id', $category->id)->first();
            if (!is_null($category1)) {
                $properties = array_merge($properties, $this->getPropertiesList($category1->id));
                $category2 = ProductCategory::where('id', $category1->id)->first();
                if (!is_null($category2)) {
                    $properties = array_merge($properties, $this->getPropertiesList($category2->id));
                    $category3 = ProductCategory::where('id', $category2->id)->first();
                    if (!is_null($category3)) {
                        $properties = array_merge($properties, $this->getPropertiesList($category3->id));
                    }
                }
            }
        }

        $properties = array_unique($properties);

        return ProductProperty::with('translationByLanguage')
                            ->with('multidata')
                            ->whereIn('id', $properties)
                            ->where('group_id', '!=', 1)
                            ->get();
    }

    public function getPropertiesList($categoryId)
    {
        $propertiesArr = [];
        $properties = PropertyCategory::where('category_id', $categoryId)->get();
        if (!empty($properties)) {
            foreach ($properties as $key => $property) {
                $propertiesArr[] = $property->property_id;
            }
        }

        return $propertiesArr;
    }

    private function _ifExists($object){
        if (is_null($object)) {
            return redirect()->route('404')->send();
        }
    }
}
