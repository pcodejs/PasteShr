<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Language;
use Datatables;
use Illuminate\Http\Request;
use Validator;

class LanguageController extends Controller
{
    public function index()
    {
        return view('admin.language.index')->with('page_title', 'Site Languages');
    }

    public function create()
    {
        return view('admin.language.create')->with('page_title', 'Site Languages');
    }

    public function edit($id)
    {
        $language = Language::findOrfail($id);
        return view('admin.language.edit', compact('language'))->with('page_title', 'Site Languages');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:2|max:30|eco_string|unique:languages,name',
            'code' => 'required|min:2|max:3|alpha|unique:languages,code',
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        } else {
            $language       = new Language();
            $language->name = $request->name;
            $language->code = $request->code;
            $language->save();

            return redirect()->back()->withSuccess('Successfully added.');
        }
    }

    public function update($id, Request $request)
    {
        $language  = Language::findOrfail($id);
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:2|max:30|eco_string|unique:languages,name,' . $language->id,
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        } else {
            $language->name = $request->name;
            $language->save();

            return redirect()->back()->withSuccess('Successfully updated.');
        }
    }

    public function get(Request $request)
    {
        if ($request->ajax()) {
            $languages = Language::select(['id', 'name', 'code']);
            return Datatables::of($languages)
                ->addColumn('action', function ($language) {
                    return '<a class="btn btn-sm btn-default" href="' . url('admin/site-languages/' . $language->id . '/translations') . '"><i class="fa fa-language"></i> Translations</a> <a class="btn btn-sm btn-default" href="' . url('admin/site-languages/' . $language->id . '/edit') . '"><i class="fa fa-edit"></i> Edit</a> <a class="btn btn-sm btn-danger" href="' . url('admin/site-languages/' . $language->id . '/delete') . '"><i class="fa fa-trash"></i> Delete</a> ';
                })
                ->make(true);
        }
    }

    public function destroy($id)
    {
        Language::where('code','!=','en')->where('id', $id)->delete();
        return redirect()->back()->withSuccess('Successfully deleted.');
    }

    public function translationsEdit($id)
    {
        $language     = Language::findOrfail($id);
        $default_data = file_get_contents('resources/lang/en.json');
        if (file_exists('resources/lang/' . $language->code . '.json')) {
            $data = file_get_contents('resources/lang/' . $language->code . '.json');
        } else {
            $data = file_get_contents('resources/lang/en.json');
        }
        $default_words = json_decode($default_data);
        $words         = json_decode($data);
        return view('admin.language.translation', compact('language', 'default_words', 'words'))->with('page_title', 'Site Languages');
    }

    public function translationsUpdate($id, Request $request)
    {
        $language = Language::findOrfail($id);
        $array    = [];
        foreach ($request->all() as $key => $value) {
            if ($key == '_token') {
                continue;
            }

            $key         = str_replace('_', ' ', $key);
            $key         = trim($key);
            $array[$key] = $value;
        }
        $translations = json_encode($array, JSON_UNESCAPED_UNICODE);

        @chmod('resources/lang/', 0775);
        @file_put_contents('resources/lang/' . $language->code . '.json', $translations);
        return redirect()->back()->withSuccess('Translations successfully updated.');
    }
}
