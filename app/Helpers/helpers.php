<?php

if (!function_exists('translate')) {
    /**
     * Will return translated text
     *
     * @param String $text
     * @return void
     */
    function translate($text)
    {
        $translations = json_decode(file_get_contents(resource_path('lang/en.json')), true);
        if (!array_key_exists($text, $translations)){
            $translations[$text] = $text;
            file_put_contents(resource_path('lang/en.json'), json_encode($translations, JSON_PRETTY_PRINT));
        }
        return __($text);
    }
}
