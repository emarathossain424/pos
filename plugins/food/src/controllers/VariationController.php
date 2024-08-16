<?php

namespace Plugin\Food\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Plugin\Food\Models\FoodVariant;
use Brian2694\Toastr\Facades\Toastr;
use Plugin\Food\Models\FoodItemVariantOption;
use Plugin\Food\Models\FoodVariantOption;

class VariationController extends Controller
{
    public function variations()
    {
        $variants = FoodVariant::with('options')->get();
        return view('food::admin.variation.index', compact('variants'));
    }

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

    public function updateVariant(Request $request)
    {

        $request->validate([
            'variant_name' => 'required|unique:food_variants,name,' . $request['id'],
        ]);
        try {
            $variant = FoodVariant::find((int)$request['id']);
            $variant->name = $request['variant_name'];
            $variant->update();
            Toastr::success('Food variant updated successfully', 'Success');
            return back();
        } catch (\Exception $ex) {
            Toastr::error('Unable to update food category', 'Error');
            return back();
        }
    }

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
        } catch (\Throwable $ex) {
            Toastr::error('Unable to delete food variant', 'Error');
            return back();
        }
    }

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

    public function updateOption(Request $request)
    {
        $request->validate([
            'option_name' => 'required|unique:food_variant_options,option_name,' . $request['id'],
        ]);
        try {
            $option = FoodVariantOption::find((int)$request['id']);
            $option->option_name = $request['option_name'];
            $option->update();
            Toastr::success('Food variant option updated successfully', 'Success');
            return back();
        } catch (\Exception $ex) {
            Toastr::error('Unable to update food category', 'Error');
            return back();
        }
    }

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
        } catch (\Throwable $ex) {
            Toastr::error('Unable to delete food variant-option', 'Error');
            return back();
        }
    }
}
