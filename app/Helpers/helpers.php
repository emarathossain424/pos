<?php

use App\Models\Language;
use App\Models\Upload;
use Illuminate\Support\Facades\DB;

if (!function_exists('translate')) {
    /**
     * Will return translated text
     *
     * @param String $text
     * @return void
     */
    function translate($text, $lang = null)
    {
        if (empty($lang)) {
            $translations = json_decode(file_get_contents(resource_path('lang/en.json')), true);
            if (!array_key_exists($text, $translations)) {
                $translations[$text] = $text;
                file_put_contents(resource_path('lang/en.json'), json_encode($translations, JSON_PRETTY_PRINT));
            }
            return __($text);
        } else {
            $translations = json_decode(file_get_contents(resource_path('lang/' . $lang . '.json')), true);
            if (!array_key_exists($text, $translations)) {
                $translations[$text] = $text;
                file_put_contents(resource_path('lang/' . $lang . '.json'), json_encode($translations, JSON_PRETTY_PRINT));
            }
            return $translations[$text];
        }
    }
}

if (!function_exists('getAdminPrefix')) {
    /**
     * Will return admin prefix
     *
     * @param String $text
     * @return void
     */
    function getAdminPrefix()
    {
        return '/admin';
    }
}


if (!function_exists('getPlaceholderImagePath')) {
    /**
     * Will return placeholder image path
     *
     * @param String $text
     * @return void
     */
    function getPlaceholderImagePath()
    {
        $placeholder_image_file_id = getGeneralSettingsValue('placeholder_image');
        $image_path = getFilePath($placeholder_image_file_id);
        return $image_path;
    }
}

if (!function_exists('getFilePath')) {
    /**
     * get requested file path
     *
     * @param String $text
     * @return void
     */
    function getFilePath($file_id)
    {
        $file = Upload::find($file_id);
        return $file->file_location;
    }
}


if (!function_exists('getGeneralSettingsValue')) {
    /**
     * will return general settings value
     */
    function getGeneralSettingsValue($setings_name)
    {
        $settings = DB::table('general_settings')
        ->where('key_name','=',$setings_name)
        ->first('key_value');

        return $settings->key_value;
    }
}

if (!function_exists('getAllLanguages')) {
    /**
     * will return all languages
     */
    function getAllLanguages()
    {
        $langs = Language::all(); 
        return $langs;
    }
}