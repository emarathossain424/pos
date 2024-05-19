<?php

namespace Plugin\Food\Controllers;

use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Plugin\Food\Models\FoodItem;

class FoodItemController extends Controller
{
    /**
     * Will redirect to food itmes list page
     *
     * @return void
     */
    public function foodItmes()
    {
        return view('food::admin.foods.index');
    }

    /**
     * Will redirect to food item adding page
     */
    public function addFoodItmes()
    {
        return view('food::admin.foods.create');
    }

    /**
     * Will store food itmes
     */
    public function storeFoodItmes(Request $request)
    {
        // $request->validate([
        //     'name' => 'required',
        //     'category' => 'required|exists:food_categories,id',
        //     'details' => 'required',
        //     'image' => 'required|exists:uploads,id',
        //     'status' => 'required',
        //     'price' => 'required',
        //     'offer_price' => 'required',
        //     'food_type' => 'required',
        // ]);

        try {
            $food_item = new FoodItem();
            $food_item->name = $request['name'];
            $food_item->category = $request['category'];
            $food_item->details = $request['details'];
            $food_item->image = $request['image'];
            $food_item->status = $request['status'] == 'on' ? 1 : 0;
            $food_item->price = $request['price'];
            $food_item->offer_price = $request['offer_price'];
            $food_item->meta_title = $request['meta_title'];
            $food_item->meta_image = $request['meta_image'];
            $food_item->food_variation = json_encode($request['food_variation']);
            $food_item->saveOrFail();

            return response()->json([
                'success' => 1,
                'message' => translate('Food item stored successfully')
            ]);
        } catch (\Exception $ex) {
            return response()->json([
                'success' => 0,
                'message' => translate('Unable to store food item')
            ],500);
        }
    }
}
