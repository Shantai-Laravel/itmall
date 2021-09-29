<?php

namespace Admin\Http\Controllers;

use App\Models\Lang;
use App\Models\PropertyMultiData;
use App\Models\PropertyMultiDataTranslation;
use App\Models\ProductProperty;
use App\Models\ProductPropertyTranslation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LanguagesController extends Controller
{

    public function index()
    {
        $languages = Lang::all();

        return view('admin::admin.languages.index', compact('languages'));
    }

    public function create()
    {
        return view('admin::admin.languages.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|size:2|alpha',
            'description' => 'required|alpha'
        ]);

        $language = new Lang();
        $language->lang = $request->name;
        $language->description = $request->description;
        $language->active = 1;
        $language->save();

        $propertiesMultidatas = PropertyMultiData::get();
        if (count($propertiesMultidatas) > 0) {
            foreach ($propertiesMultidatas as $key => $propertiesMultidata) {
                PropertyMultiDataTranslation::create([
                    'property_multidata_id' => $propertiesMultidata->id,
                    'lang_id' => $language->id,
                    'name' => $propertiesMultidata->translationByLanguage($this->lang->id)->first()->name,
                    'value' => $propertiesMultidata->translationByLanguage($this->lang->id)->first()->value,
                ]);
            }
        }

        $properties = ProductProperty::get();
        if (count($properties) > 0) {
            foreach ($properties as $key => $property) {
                ProductPropertyTranslation::create([
                    'property_id' => $property->id,
                    'lang_id' => $language->id,
                    'name' => $property->translationByLanguage($this->lang->id)->first()->name,
                    'value' => $property->translationByLanguage($this->lang->id)->first()->value,
                    'multi_data' => $property->translationByLanguage($this->lang->id)->first()->multi_data,
                    'unit' => $property->translationByLanguage($this->lang->id)->first()->unit,
                ]);
            }
        }


        return redirect()->route('languages.index');
    }

    public function destroy($id)
    {
        $lang = Lang::findOrFail($id);

        // PropertyMultiDataTranslation::where('lang_id', $lang->id)->delete();

        if ($lang->default == 1) {
            session('flash', "Can't delete default language");

            return back();
        }
        $lang->delete();

        return back();
    }

    public function setDefault($id)
    {
        $current = Lang::where('default', '1')->first();
        $current->default = 0;
        $current->save();

        $new = Lang::findOrFail($id);
        $new->default = 1;
        $new->save();

        return back();
    }

}
