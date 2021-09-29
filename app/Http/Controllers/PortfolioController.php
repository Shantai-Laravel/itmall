<?php

namespace App\Http\Controllers;

use App\Models\Lang;
use App\Models\Page;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Promotion;
use App\Models\Post;

class PortfolioController extends Controller
{
    public function index() {
        $page = Page::where('alias', 'portfolio')->first();
        if (is_null($page)) {
            return redirect()->route('404');
        }

        $items = Promotion::orderBy('position', 'asc')->where('active', 1)->get();

        $seoData = $this->getSeo($page);

        return view('front.portfolio.list', compact('seoData', 'page', 'items'));
    }

    public function singlePortfolio($alias)
    {
        $portfolio = Promotion::where('alias', $alias)->first();

        if (is_null($portfolio)) {
            return redirect()->route('404');
        }

        $seoData = $this->getSeo($portfolio);

        return view('front.portfolio.single', compact('seoData', 'page', 'portfolio'));
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
