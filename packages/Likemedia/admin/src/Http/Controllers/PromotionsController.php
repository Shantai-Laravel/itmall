<?php

namespace Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Promotion;
use App\Models\Traduction;
use App\Models\Product;
use App\Models\TraductionTranslation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;


class PromotionsController extends Controller
{
    public function index()
    {
        $promotions = Promotion::with('translation')->orderBy('position', 'asc')->get();

        return view('admin::admin.promotions.index', compact('promotions'));
    }

    public function create()
    {
        return view('admin::admin.promotions.create');
    }

    public function store(Request $request)
    {
        $toValidate = [];
        foreach ($this->langs as $lang){
            $toValidate['title_'.$lang->lang] = 'required|max:255';
        }
        $validator = $this->validate($request, $toValidate);

        if ($request->banner_1) {
            $banner1 = time() . '-' . $request->banner_1->getClientOriginalName();
            $request->banner_1->move('images/promotions', $banner1);
        }else{
            $banner1 = $request->get('old_banner_1');
        }

        if ($request->banner_2) {
            $banner2 = time() . '-' . $request->banner_2->getClientOriginalName();
            $request->banner_2->move('images/promotions', $banner2);
        }else{
            $banner2 = $request->get('old_banner_2');
        }

        $promotion = new Promotion();
        $promotion->alias = str_slug(request('title_ro'));
        $promotion->active = 1;
        $promotion->position = 1;
        $promotion->banner_1 = $banner1;
        $promotion->banner_2 = $banner2;
        $promotion->discount  = $request->discount;
        $promotion->save();

        foreach ($this->langs as $lang):
            $promotion->translations()->create([
                'lang_id' => $lang->id,
                'name' => request('title_' . $lang->lang),
                'description' => request('description_' . $lang->lang),
                'body' => request('body_' . $lang->lang),
                'field_1' => request('field_1' . $lang->lang),
                'field_2' => request('field_2' . $lang->lang),
                'field_3' => request('field_3' . $lang->lang),
                'field_4' => request('field_4' . $lang->lang),
                'field_5' => request('field_5' . $lang->lang),
                'seo_text' => request('seo_text_' . $lang->lang),
                'seo_title' => request('seo_title_' . $lang->lang),
                'seo_description' => request('seo_descr_' . $lang->lang),
                'seo_keywords' => request('seo_keywords_' . $lang->lang)
            ]);
        endforeach;

        Session::flash('message', 'New item has been created!');

        return redirect()->route('promotions.index');
    }

    public function show($id)
    {
        return redirect()->route('promotions.index');
    }

    public function edit($id)
    {
        $promotion = Promotion::with('translations')->findOrFail($id);

        return view('admin::admin.promotions.edit', compact('promotion', 'translations'));
    }

    public function update(Request $request, $id)
    {
        $toValidate = [];
        foreach ($this->langs as $lang){
            $toValidate['title_'.$lang->lang] = 'required|max:255';
        }

        $validator = $this->validate($request, $toValidate);

        $banner1 = $request->old_banner_1;
        $banner2 = $request->old_banner_2;

        if ($request->banner_1) {
            $banner1 = time() . '-' . $request->banner_1->getClientOriginalName();
            $request->banner_1->move('images/promotions', $banner1);
        }

        if ($request->banner_2) {
            $banner2 = time() . '-' . $request->banner_2->getClientOriginalName();
            $request->banner_2->move('images/promotions', $banner2);
        }

        $promotion = Promotion::findOrFail($id);
        $promotion->banner_1 = $banner1;
        $promotion->banner_2 = $banner2;
        $promotion->save();

        $promotion->translations()->delete();

        foreach ($this->langs as $lang):
            $promotion->translations()->create([
                'lang_id' => $lang->id,
                'name' => request('title_' . $lang->lang),
                'description' => request('description_' . $lang->lang),
                'body' => request('body_' . $lang->lang),
                'field_1' => request('field_1' . $lang->lang),
                'field_2' => request('field_2' . $lang->lang),
                'field_3' => request('field_3' . $lang->lang),
                'field_4' => request('field_4' . $lang->lang),
                'field_5' => request('field_5' . $lang->lang),
                'seo_text' => request('seo_text_' . $lang->lang),
                'seo_title' => request('seo_title_' . $lang->lang),
                'seo_description' => request('seo_descr_' . $lang->lang),
                'seo_keywords' => request('seo_keywords_' . $lang->lang)
            ]);
        endforeach;

        return redirect()->back();
    }


    public function changePosition()
    {
        $neworder = Input::get('neworder');
        $i = 1;
        $neworder = explode("&", $neworder);

        foreach ($neworder as $k => $v) {
            $id = str_replace("tablelistsorter[]=", "", $v);
            if (!empty($id)) {
                Promotion::where('id', $id)->update(['position' => $i]);
                $i++;
            }
        }
    }

    public function status($id)
    {
        $promotion = Promotion::findOrFail($id);

        if ($promotion->active == 1) {
            $promotion->active = 0;
        } else {
            $promotion->active = 1;
        }

        $promotion->save();

        return redirect()->route('promotions.index');
    }


    public function destroy($id)
    {
        $promotion = Promotion::findOrFail($id);

        foreach ($promotion->translations()->get() as $promotion_translation) {
            if ($promotion_translation->banner != '' && file_exists(public_path('images/promotions/'.$promotion_translation->banner))) {
                unlink(public_path('images/promotions/'.$promotion_translation->banner));
            }
            if ($promotion_translation->banner_mob != '' && file_exists(public_path('images/promotions/'.$promotion_translation->banner_mob))) {
                unlink(public_path('images/promotions/'.$promotion_translation->banner_mob));
            }
        }

        $promotion->delete();
        $promotion->translations()->delete();

        session()->flash('message', 'Item has been deleted!');

        return redirect()->route('promotions.index');
    }



}
