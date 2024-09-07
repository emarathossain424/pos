<?php

namespace Plugin\Food\Controllers;

use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Plugin\Food\Models\FoodCategory;
use Plugin\Food\Models\TranslateFoodCategory;

class CategoryController extends Controller {
    /**
     * Will redirect to food category page
     *
     * @return void
     */
    public function categories() {
        $categories = FoodCategory::with( 'parentCategory' )->get();
        return view( 'food::admin.category.index', compact( 'categories' ) );
    }

    /**
     * Will redirect to category ceation page
     *
     * @return void
     */
    public function addCategory() {
        return view( 'food::admin.category.create' );
    }

    /**
     * will store food category
     *
     * @return void
     */
    public function storeCategory( Request $request ) {
        $request->validate( [
            'category_name'  => 'required|unique:food_categories,name',
            'category_image' => 'required',
        ] );

        try {
            $category                   = new FoodCategory();
            $category->name             = $request['category_name'];
            $category->parent           = $request['parent_category'];
            $category->image            = $request['category_image'];
            $category->status           = $request['status'] == 'on' ? 1 : 0;
            $category->featured_status  = $request['featured_status'] == 'on' ? 1 : 0;
            $category->meta_title       = $request['meta_title'];
            $category->meta_description = $request['meta_description'];
            $category->meta_image       = $request['meta_image'];
            $category->saveOrFail();

            Toastr::success( 'Food category created successfully', 'Success' );
            return back();
        } catch ( \Exception $ex ) {
            Toastr::error( 'Unable to create food category', 'Error' );
            return back();
        }
    }

    /**
     * Will redirect to category editing page
     */
    public function editCategory( $id ) {
        $e_category = FoodCategory::find( $id );

        $default_lang = getGeneralSettingsValue( 'default_lang' );
        if ( isset( request()->lang ) && ( request()->lang != $default_lang ) ) {
            $e_category = $e_category->translateInto( request()->lang )->first();
        }
        return view( 'food::admin.category.edit', compact( 'e_category' ) );
    }

    /**
     * Will update requested food category
     */
    public function updateCategory( Request $request ) {
        $default_lang   = getGeneralSettingsValue( 'default_lang' );
        $translate_into = $request['translate_into'];
        try {
            if ( $default_lang == $translate_into ) {
                $category_id = $request['id'];
                $request->validate( [
                    'category_name'  => 'required|unique:food_categories,name,' . $category_id,
                    'category_image' => 'required',
                ] );

                $category                   = FoodCategory::find( (int) $category_id );
                $category->name             = $request['category_name'];
                $category->parent           = $request['parent_category'];
                $category->image            = $request['category_image'];
                $category->status           = $request['status'] == 'on' ? 1 : 0;
                $category->featured_status  = $request['featured_status'] == 'on' ? 1 : 0;
                $category->meta_title       = $request['meta_title'];
                $category->meta_description = $request['meta_description'];
                $category->meta_image       = $request['meta_image'];
                $category->update();
            } else {
                $this->setCategoryTranslation( $request );
            }

            Toastr::success( 'Food category updated successfully', 'Success' );
            return back();
        } catch ( \Exception $ex ) {
            Toastr::error( 'Unable to update food category', 'Error' );
            return back();
        }
    }

    /**
     * Translate category in
     */
    public function setCategoryTranslation( $request ) {
        $category_id    = $request['id'];
        $translate_into = $request['translate_into'];

        $has_previous_trans = TranslateFoodCategory::where( 'category_id', $category_id )
            ->where( 'lang_id', $translate_into );

        if ( $has_previous_trans->exists() ) {
            $trans_row_id                     = $has_previous_trans->first()->id;
            $category_trans                   = TranslateFoodCategory::find( $trans_row_id );
            $category_trans->category_id      = $category_id;
            $category_trans->lang_id          = $translate_into;
            $category_trans->name             = $request['category_name'];
            $category_trans->meta_title       = $request['meta_title'];
            $category_trans->meta_description = $request['meta_description'];
            $category_trans->update();
        } else {
            $category_trans                   = new TranslateFoodCategory();
            $category_trans->category_id      = $category_id;
            $category_trans->lang_id          = $translate_into;
            $category_trans->name             = $request['category_name'];
            $category_trans->meta_title       = $request['meta_title'];
            $category_trans->meta_description = $request['meta_description'];
            $category_trans->saveOrFail();
        }
    }

    /**
     * Update category status
     */
    public function updateCategoryStatus( Request $request ) {
        try {
            $category = FoodCategory::find( $request['id'] );
            if ( $request['type'] == 'featured' ) {
                if ( $category->featured_status == 1 ) {
                    $category->featured_status = 0;
                } else {
                    $category->featured_status = 1;
                }
            }
            if ( $request['type'] == 'general' ) {
                if ( $category->status == 1 ) {
                    $category->status = 0;
                } else {
                    $category->status = 1;
                }
            }

            $category->update();
            return response()->json( [
                'success' => true,
                'message' => translate( 'Category status updated successfully' ),
            ] );
        } catch ( \Exception $ex ) {
            return response()->json( [
                'success' => false,
                'message' => translate( 'Unable to change status' ),
            ] );
        }
    }

    /**
     * Delete requested category
     */
    public function deleteCategory( Request $request ) {
        try {
            $category = FoodCategory::find( (int) $request['id'] );
            $category->delete();
            Toastr::success( 'Category deleted successfully', 'Success' );
            return back();
        } catch ( \Throwable $ex ) {
            Toastr::error( 'Unable to delete category', 'Error' );
            return back();
        }
    }
}
