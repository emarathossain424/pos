<?php

namespace Plugin\Food\Controllers;

use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Plugin\Food\Models\FoodCategory;

class CategoryController extends Controller
{
    /**
     * Will redirect to food category page
     *
     * @return void
     */
    public function categories(){
        return view('food::admin.category.index');
    }

    /**
     * Will redirect to category ceation page
     *
     * @return void
     */
    public function addCategory() {
        return view('food::admin.category.create');
    }
    
    /**
     * will store food category
     *
     * @return void
     */
    public function storeCategory(Request $request) {
        $request->validate([
            'category_name'=>'required|unique:food_categories,name',
            'category_image'=>'required'
        ]);

        try {
            $category = new FoodCategory();
            $category->name = $request['category_name'];
            $category->parent = $request['parent_category'];
            $category->image = $request['category_image'];
            $category->status = $request['status']=='on'?1:0;
            $category->featured_status = $request['featured_status']=='on'?1:0;
            $category->meta_title = $request['meta_title'];
            $category->meta_description = $request['meta_description'];
            $category->meta_image = $request['meta_image'];
            $category->saveOrFail();

            Toastr::success('Food category created successfully', 'Success');
            return back();
        } catch (\Exception $ex) {
            Toastr::error('Unable to create food category', 'Error');
            return back();
        }
    }
}