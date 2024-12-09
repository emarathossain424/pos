<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use App\Models\GeneralSettings;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class SettingsController extends Controller
{

    /**
     * Displays the general settings view.
     *
     * @return \Illuminate\Http\Response
     */
    public function generalSettings(Request $request)
    {
        $data             = [];
        $general_settings = GeneralSettings::all();

        foreach ($general_settings as $general_setting) {
            $key_name        = $general_setting->key_name;
            $key_value       = $general_setting->key_value;
            $data[$key_name] = $key_value;
        }

        return view('settings.general', compact('data'));
    }

    /**
     * Update the currency settings.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function manageCurrency(Request $request)
    {
        $request->validate([
            'default_currency'    => 'required',
            'currency_position'   => 'required',
            'thousands_separator' => 'required',
            'decimal_separator'   => 'required',
            'decimal_position'    => 'required',
        ]);

        GeneralSettings::updateOrInsert(
            ['key_name' => 'default_currency'],
            ['key_value' => $request->default_currency]
        );

        GeneralSettings::updateOrInsert(
            ['key_name' => 'currency_position'],
            ['key_value' => $request->currency_position]
        );

        GeneralSettings::updateOrInsert(
            ['key_name' => 'thousands_separator'],
            ['key_value' => $request->thousands_separator]
        );

        GeneralSettings::updateOrInsert(
            ['key_name' => 'decimal_separator'],
            ['key_value' => $request->decimal_separator]
        );

        GeneralSettings::updateOrInsert(
            ['key_name' => 'decimal_position'],
            ['key_value' => $request->decimal_position]
        );

        Toastr::success('Settings updated successfully', 'Success');
        return back();
    }

    /**
     * Update the default language.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function setDefaultLanguage(Request $request)
    {
        $request->validate([
            'default_lang' => 'required',
        ]);

        GeneralSettings::updateOrInsert(
            ['key_name' => 'default_lang'],
            ['key_value' => $request['default_lang']]
        );

        Toastr::success('Settings updated successfully', 'Success');
        return back();
    }

    /**
     * Handle the incoming request for setting the placeholder image.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function setPlaceholderImage(Request $request)
    {
        $request->validate([
            'placeholder_image' => 'required',
        ]);

        GeneralSettings::updateOrInsert(
            ['key_name' => 'placeholder_image'],
            ['key_value' => $request['placeholder_image']]
        );

        Toastr::success('Settings updated successfully', 'Success');
        return back();
    }
}
