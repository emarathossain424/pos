<?php

namespace Plugin\Food\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Plugin\Food\Models\FoodVariant;
use Brian2694\Toastr\Facades\Toastr;
use Plugin\Food\Models\FoodItemVariantOption;
use Plugin\Food\Models\FoodVariantOption;
use Plugin\Food\Models\TranslateFoodVariant;
use Plugin\Food\Models\TranslateFoodVariantOption;

class VariationController extends Controller
{
    /**
     * Returns a view with a list of food variants and their options.
     *
     * @return \Illuminate\View\View
     */
    public function variations()
    {
        $variants = FoodVariant::with('options')->get();
        return view('food::admin.variation.index', compact('variants'));
    }

    /**
     * Creates a new food variant based on the provided request data.
     *
     * @param Request $request The HTTP request containing the variant data.
     * @throws \Exception If the variant cannot be saved.
     * @return \Illuminate\Http\RedirectResponse A redirect response back to the previous page.
     */
    public function createVariant(Request $request)
    {
        $request->validate([
            'variant_name' => 'required|unique:food_variants,name',
        ]);
        try {
            $variant = new FoodVariant();
            $variant->name = $request['variant_name'];
            $variant->saveOrFail();

            Toastr::success('Food variant created successfully', 'Success');
            return back();
        } catch (\Exception $ex) {
            Toastr::error('Unable to store food category', 'Error');
            return back();
        }
    }

    /**
     * Updates a food variant based on the provided request data.
     *
     * @param Request $request The HTTP request containing the variant data.
     * @throws \Exception If the variant cannot be updated.
     * @return \Illuminate\Http\RedirectResponse A redirect response back to the previous page.
     */
    public function updateVariant(Request $request)
    {
        $request->validate([
            'variant_name' => 'required|unique:food_variants,name,' . $request['id'],
        ]);
        $default_lang = getGeneralSettingsValue('default_lang');
        $translate_into = $request['translate_into'];
        try {
            if ($default_lang == $translate_into) {
                $variant = FoodVariant::find((int)$request['id']);
                $variant->name = $request['variant_name'];
                $variant->update();
            } else {
                $variant_id = $request['id'];
                $translate_into = $request['translate_into'];

                $has_previous_trans = TranslateFoodVariant::where('variant_id', $variant_id)
                    ->where('lang_id', $translate_into);

                if ($has_previous_trans->exists()) {
                    $trans_row_id = $has_previous_trans->first()->id;
                    $variant_trans = TranslateFoodVariant::find($trans_row_id);
                    $variant_trans->variant_id = $variant_id;
                    $variant_trans->lang_id = $translate_into;
                    $variant_trans->name = $request['variant_name'];
                    $variant_trans->update();
                } else {
                    $variant_trans = new TranslateFoodVariant();
                    $variant_trans->variant_id = $variant_id;
                    $variant_trans->lang_id = $translate_into;
                    $variant_trans->name = $request['variant_name'];
                    $variant_trans->saveOrFail();
                }
            }
            Toastr::success('Food variant updated successfully', 'Success');
            return back();
        } catch (\Exception $ex) {
            Toastr::error('Unable to update food category', 'Error');
            return back();
        }
    }


    /**
     * Deletes a food variant based on the provided request data.
     *
     * @param Request $request The HTTP request containing the variant ID.
     * @throws \Throwable If the variant cannot be deleted.
     * @return \Illuminate\Http\RedirectResponse A redirect response back to the previous page.
     */
    public function deleteVariant(Request $request)
    {
        try {
            $is_already_in_use = FoodItemVariantOption::where('variant_id', $request['id'])->exists();
            if ($is_already_in_use) {
                Toastr::error('You cannot delete this variant as it is already used in some food items', 'Warning');
                return back();
            }
            $variant = FoodVariant::find((int)$request['id']);
            $variant->delete();
            Toastr::success('Food variant deleted successfully', 'Success');
            return back();
        } catch (\Exception $ex) {
            Toastr::error('Unable to delete food variant', 'Error');
            return back();
        }
    }

    /**
     * Adds a new food variant option.
     *
     * @param Request $request The HTTP request containing the variant ID and option name.
     * @throws \Exception If the option cannot be stored.
     * @return \Illuminate\Http\RedirectResponse A redirect response back to the previous page.
     */
    public function addOption(Request $request)
    {
        $request->validate([
            'variant_id' => 'required|exists:food_variants,id',
            'option_name' => 'required|unique:food_variant_options,option_name',
        ]);
        try {
            $option = new FoodVariantOption();
            $option->variant_id = $request['variant_id'];
            $option->option_name = $request['option_name'];
            $option->saveOrFail();
            Toastr::success('Food variant option created successfully', 'Success');
            return back();
        } catch (\Exception $ex) {
            Toastr::error('Unable to store food category', 'Error');
            return back();
        }
    }

    /**
     * Updates a food variant option based on the provided request data.
     *
     * @param Request $request The HTTP request containing the option ID and new option name.
     * @throws \Exception If the option cannot be updated.
     * @return \Illuminate\Http\RedirectResponse A redirect response back to the previous page.
     */
    public function updateOption(Request $request)
    {
        $request->validate([
            'option_name' => 'required|unique:food_variant_options,option_name,' . $request['id'],
        ]);
        $default_lang = getGeneralSettingsValue('default_lang');
        $translate_into = $request['translate_into'];

        try {
            if ($default_lang == $translate_into) {
                $option = FoodVariantOption::find((int)$request['id']);
                $option->option_name = $request['option_name'];
                $option->update();
            } else {
                $option_id = $request['id'];
                $translate_into = $request['translate_into'];

                $has_previous_trans = TranslateFoodVariantOption::where('option_id', $option_id)
                    ->where('lang_id', $translate_into);

                if ($has_previous_trans->exists()) {
                    $trans_row_id = $has_previous_trans->first()->id;
                    $option_trans = TranslateFoodVariantOption::find($trans_row_id);
                    $option_trans->option_id = $option_id;
                    $option_trans->lang_id = $translate_into;
                    $option_trans->option_name = $request['option_name'];
                    $option_trans->update();
                } else {
                    $option_trans = new TranslateFoodVariantOption();
                    $option_trans->option_id = $option_id;
                    $option_trans->lang_id = $translate_into;
                    $option_trans->option_name = $request['option_name'];
                    $option_trans->saveOrFail();
                }
            }
            Toastr::success('Food variant option updated successfully', 'Success');
            return back();
        } catch (\Exception $ex) {
            dd($ex);
            Toastr::error('Unable to update food variant option', 'Error');
            return back();
        }
    }

    /**
     * Deletes a food variant option based on the provided request data.
     *
     * @param Request $request The HTTP request containing the option ID.
     * @throws \Exception If the option cannot be deleted.
     * @return \Illuminate\Http\RedirectResponse A redirect response back to the previous page.
     */
    public function deleteOption(Request $request)
    {
        try {
            $is_already_in_use = FoodItemVariantOption::where('option_id', $request['id'])->exists();
            if ($is_already_in_use) {
                Toastr::error('You cannot delete this variant-option as it is already used in some food items', 'Warning');
                return back();
            }
            $variant = FoodVariantOption::find((int)$request['id']);
            $variant->delete();
            Toastr::success('Food variant-option deleted successfully', 'Success');
            return back();
        } catch (\Exception $ex) {
            Toastr::error('Unable to delete food variant-option', 'Error');
            return back();
        }
    }

    /**
     * Retrieves the translation of a food variant based on the provided language ID.
     *
     * @param Request $request The incoming HTTP request containing the language ID and variant ID.
     * @return \Illuminate\Http\JsonResponse A JSON response containing the translated variant name or an error message.
     */
    public function getVariantTranslation(Request $request)
    {
        $lang_id = $request['lang_id'];
        $variant_id = $request['id'];

        $translated_variant = TranslateFoodVariant::where('variant_id', $variant_id)
            ->where('lang_id', $lang_id)->first();

        if ($translated_variant) {
            return response()->json([
                'success' => 1,
                'data' => [
                    'name' => $translated_variant->name
                ],
                'message' => translate('Translated variant name')
            ]);
        } else {
            return response()->json([
                'success' => 0,
                'data' => [],
                'message' => translate('No translation found')
            ]);
        }
    }

    /**
     * Retrieves the translation of a food variant option based on the provided language ID.
     *
     * @param Request $request The incoming HTTP request containing the language ID and option ID.
     * @return \Illuminate\Http\JsonResponse A JSON response containing the translated option name or an error message.
     */
    public function getOptionTranslation(Request $request)
    {
        $lang_id = $request['lang_id'];
        $option_id = $request['id'];

        $translated_option = TranslateFoodVariantOption::where('option_id', $option_id)
            ->where('lang_id', $lang_id)->first();

        if ($translated_option) {
            return response()->json([
                'success' => 1,
                'data' => [
                    'name' => $translated_option->option_name
                ],
                'message' => translate('Translated option name')
            ]);
        } else {
            return response()->json([
                'success' => 0,
                'data' => [],
                'message' => translate('No translation found')
            ]);
        }
    }
}
