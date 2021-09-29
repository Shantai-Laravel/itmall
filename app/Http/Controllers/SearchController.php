<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lang;
use App\Models\Product;
use App\Models\ProductTranslation;


class SearchController extends Controller
{
    public function index(Request $request) {
        $searchResult = ProductTranslation::where('name', 'like',  '%'.$request->get('value').'%')
                                    ->orWhere('body', 'like',  '%'.$request->get('value').'%')
                                    ->pluck('product_id')->toArray();

        $findProducts = Product::whereIn('id', $searchResult)->limit(5)->get();

        $search = $request->get('value');

        $data = view('front.inc.searchResults', compact('findProducts', 'search'))->render();

        return json_encode($data);
    }

    public function search(Request $request) {
        $search = '';
        $findProducts = [];

        if($request->value != '') {
            $searchResult = ProductTranslation::where('name', 'like',  '%'.$request->get('value').'%')
                                        ->orWhere('body', 'like',  '%'.$request->get('value').'%')
                                        ->pluck('product_id')->toArray();

            $findProducts = Product::whereIn('id', $searchResult)->get();

            $search = $request->get('value');

            return view('front.products.search', compact('search', 'findProducts'));
        } else {
          return view('front.products.search', compact('search', 'findProducts'));
        }
    }

    public function sortByHighPrice(Request $request) {
        $search = '';
        $findProducts = [];
        if($request->get('value') != '') {
          $searchResult = ProductTranslation::where('name', 'like',  '%'.$request->get('value').'%')
                                      ->orWhere('body', 'like',  '%'.$request->get('value').'%')
                                      ->pluck('product_id')->toArray();
          $findProducts = Product::whereIn('id', $searchResult)->orderBy('price', 'desc')->get();

          $data['searchResults'] = view('front.inc.searchBox', compact('findProducts'))->render();

          return json_encode($data);
        } else {
          $data['searchResults'] = view('front.inc.searchBox', compact('findProducts'))->render();

          return json_encode($data);
        }
    }

    public function sortByLowPrice(Request $request) {
        $search = '';
        $findProducts = [];
        if($request->get('value') != '') {
          $searchResult = ProductTranslation::where('name', 'like',  '%'.$request->get('value').'%')
                                      ->orWhere('body', 'like',  '%'.$request->get('value').'%')
                                      ->pluck('product_id')->toArray();

          $findProducts = Product::whereIn('id', $searchResult)->orderBy('price', 'asc')->get();

          $data['searchResults'] = view('front.inc.searchBox', compact('findProducts'))->render();

          return json_encode($data);
        } else {
          $data['searchResults'] = view('front.inc.searchBox', compact('findProducts'))->render();

          return json_encode($data);
        }
    }
}
