<?php

namespace App\Http\Controllers;

use App\Models\Lang;
use App\Models\Page;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Post;

class PagesController extends Controller
{
    public function index() {
        $page = Page::where('alias', 'home')->first();
        if (is_null($page)) {
            return redirect()->route('404');
        }

        $onlineStores = Product::where('category_id', 17)->get();

        $products = Product::whereIn('id', [22, 20, 3, 18])->get();

        $googleCategory = ProductCategory::where('id', 28)->first();

        $smmCategory = ProductCategory::where('id', 24)->first();

        $seoData = $this->getSeo($page);
        return view('front.pages.home', compact('seoData', 'page', 'onlineStores', 'googleCategory', 'smmCategory', 'products'));
    }

    public function getPages($slug)
    {
        $page = Page::where('alias', $slug)->first();
        if (is_null($page)) {
            return redirect()->route('404');
        }

        if (view()->exists('front/pages/'.$slug)) {
            $seoData = $this->getSeo($page);
            return view('front.pages.'.$slug, compact('seoData', 'page'));
        }else{
            $seoData = $this->getSeo($page);
            return view('front.pages.default', compact('seoData', 'page'));
        }
    }

    // get SEO data for a page
    private function getSeo($page){
        $seo['seo_title'] = $page->translationByLanguage($this->lang->id)->first()->meta_title;
        $seo['seo_keywords'] = $page->translationByLanguage($this->lang->id)->first()->meta_keywords;
        $seo['seo_description'] = $page->translationByLanguage($this->lang->id)->first()->meta_description;

        return $seo;
    }

    public function get404()
    {
        return view('front.404');
    }

}
