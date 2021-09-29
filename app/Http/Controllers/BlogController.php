<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lang;
use App\Models\Post;
use App\Models\PostTranslation;
use App\Models\Category;

class BlogController extends Controller
{
    public function index() {
      $blogs = Post::orderBy('created_at', 'desc')->take(6)->get();
      $blogCategories = Category::where('parent_id', 0)->get();

      return view('front.blogs.all-items', compact('blogs', 'blogCategories'));
    }

    public function getBlog($slug)
    {
        $blogCategories = Category::all();
        $recentPosts = Post::orderBy('created_at', 'desc')->limit(3)->get();
        $randomPosts = Post::inRandomOrder()->limit(12)->get();
        $blog = PostTranslation::where('url', $slug)->first();

        if (is_null($blog)) {
            return redirect()->route('404');
        }

        $blog = $blog->post;

        return view('front.blogs.one-item', compact('blog', 'blogCategories', 'recentPosts', 'randomPosts'));
    }

    public function filterBlogs() {
        $blogs = Post::orderBy('created_at', 'desc')->where('category_id', request('categoryId'))->take(6)->get();
        $data['blogs'] = view('front.blogs.items', compact('blogs'))->render();
        return json_encode($data);
    }

    public function addMoreBlogs() {
        if(request('categoryId') > 0) {
          $blogs = Post::orderBy('created_at', 'desc')->where('category_id', request('categoryId'))->take(request('count') + 6)->get();
        } else {
          $blogs = Post::orderBy('created_at', 'desc')->take(request('count') + 6)->get();
        }
        $data['blogs'] = view('front.blogs.items', compact('blogs'))->render();
        return json_encode($data);
    }

    // get SEO data for a page
    private function getSeo($page){
        $seo['seo_title'] = $page->translationByLanguage($this->lang->id)->first()->meta_title;
        $seo['seo_keywords'] = $page->translationByLanguage($this->lang->id)->first()->meta_keywords;
        $seo['seo_description'] = $page->translationByLanguage($this->lang->id)->first()->meta_description;

        return $seo;
    }

}
