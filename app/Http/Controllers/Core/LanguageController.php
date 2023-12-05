<?php

namespace App\Http\Controllers\Core;

use Exception;
use App\Models\Language;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use App\Http\Requests\StoreLanguageRequest;

class LanguageController extends Controller
{
    /**
     * Will redirect to language list
     *
     * @return void
     */
    function index()
    {
        $languages = Language::all();
        return view('language.index', compact('languages'));
    }

    /**
     * Will create new language
     */
    public function store(StoreLanguageRequest $request)
    {
        try {
            Language::create([
                'name' => $request['name'],
                'code' => $request['code']
            ]);

            Toastr::success('Language created successfully', 'Success');
            return back();
        } catch (\Exception $ex) {
            Toastr::error('Unable to create language', 'Error');
            return back();
        }
    }

    /**
     * Will update requested language
     */
    public function update(StoreLanguageRequest $request)
    {
        try {
            $language = Language::find($request['id']);
            $language->name = $request['name'];
            $language->code = $request['code'];
            $language->update();

            Toastr::success('Language updated successfully', 'Success');
            return back();
        } catch (\Exception $ex) {
            Toastr::error('Unable to update language', 'Error');
            return back();
        }
    }

    /**
     * will delete language
     *
     * @param  mixed $request
     */
    public function delete(Request $request)
    {
        try {
            $language = Language::find((int)$request['id']);
            $language->delete();
            Toastr::success('Language deleted successfully', 'Success');
            return back();
        } catch (\Throwable $ex) {
            Toastr::error('Unable to delete language', 'Error');
            return back();
        }
    }

    /**
     * Will redirect to translation page
     *
     */
    public function translate($code)
    {
        $translations = json_decode(file_get_contents(resource_path('lang/en.json')), true);
        if (!file_exists(resource_path('lang/' . $code . '.json'))) {
            file_put_contents(resource_path('lang/' . $code . '.json'), json_encode($translations, JSON_PRETTY_PRINT));
        }
        return view('language.translate', compact('code', 'translations'));
    }

    /**
     * Update transletions
     *
     * @param Request $request
     * @return void
     */
    public function updateTranslations(Request $request)
    {
        $request->validate([
            'code' => 'required',
            'key' => 'required',
            'value' => 'required',
        ]);

        try {
            $translations = json_decode(file_get_contents(resource_path('lang/' . $request['code'] . '.json')), true);
            $translations[$request['key']] = $request['value'];
            file_put_contents(resource_path('lang/' . $request['code'] . '.json'), json_encode($translations, JSON_PRETTY_PRINT));
            Toastr::success('Translation successfull', 'Success');
            return back();
        } catch (Exception $ex) {
            Toastr::success('Unable to translate', 'Success');
            return back();
        }
    }

    /** */
    public function updateLanguageRtlStatus(Request $request)
    {
        try {
            $language = Language::find($request['id']);
            if ($language->is_rtl == 1) {
                $language->is_rtl = 0;
            } else {
                $language->is_rtl = 1;
            }
            $language->update();
            return response()->json([
                'success' => true,
                'message' => translate('RTL status updated successfully')
            ]);            
        } catch (Exception $ex) {
            return response()->json([
                'success' => false,
                'message' => translate('Unable to change status')
            ]);            
        }
    }
}
