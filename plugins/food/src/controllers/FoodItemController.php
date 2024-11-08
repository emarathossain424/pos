<?php

namespace Plugin\Food\Controllers;

use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Plugin\Food\Models\FoodItem;
use Plugin\Food\Models\FoodItemBranches;
use Plugin\Food\Models\FoodItemProperty;
use Plugin\Food\Models\FoodItemVariant;
use Plugin\Food\Models\FoodItemVariantOption;
use Plugin\Food\Models\FoodVariant;
use Plugin\Food\Models\TranslateFoodItem;

class FoodItemController extends Controller {
    /**
     * Will redirect to food items list page
     *
     * @return void
     */
    public function foodItems( Request $request ) {
        $match_case = [];

        if ( !empty( $request->input( 'category' ) ) ) {
            $match_case[] = ['category', $request->input( 'category' )];
        }
        if ( !empty( $request->input( 'food_type' ) ) ) {
            $match_case[] = ['food_type', $request->input( 'food_type' )];
        }
        if ( !empty( $request->input( 'item_status' ) ) ) {
            $match_case[] = ['status', $request->input( 'item_status' )];
        }

        $food_items = FoodItem::with( 'foodItemVariant', 'foodCategory' )
            ->where( $match_case );

        // Check if branch is provided
        if ( !empty( $request->input( 'branch' ) ) ) {
            $branch_id = $request->input( 'branch' );

            // Filter by branch_id using whereHas to query the related branches
            $food_items = $food_items->whereHas( 'branches', function ( $query ) use ( $branch_id ) {
                $query->where( 'core_branches.id', $branch_id );
            } );
        }

        $food_items = $food_items->get();

        return view( 'food::admin.foods.index', compact( 'food_items' ) );
    }

    /**
     * Will redirect to food item adding page
     */
    public function addFoodItems() {
        $variants = FoodVariant::with( 'options' )->get();
        return view( 'food::admin.foods.create', compact( 'variants' ) );
    }

    /**
     * Will store food items
     */
    public function storeFoodItems( Request $request ) {
        $request->validate( [
            'name'        => 'required',
            'category'    => 'required|exists:food_categories,id',
            'details'     => 'required',
            'image'       => 'required|exists:uploads,id',
            'status'      => 'required',
            'price'       => 'required',
            'offer_price' => 'required',
            'food_type'   => 'required',
            'food_type'   => 'required',
            'branch'      => 'required',
        ] );

        try {
            DB::beginTransaction();
            $food_item                   = new FoodItem();
            $food_item->name             = $request['name'];
            $food_item->category         = $request['category'];
            $food_item->details          = $request['details'];
            $food_item->image            = $request['image'];
            $food_item->status           = $request['status'] == 'on' ? 1 : 0;
            $food_item->price            = $request['price'];
            $food_item->offer_price      = $request['offer_price'];
            $food_item->meta_title       = $request['meta_title'];
            $food_item->meta_image       = $request['meta_image'];
            $food_item->meta_description = $request['meta_description'];
            $food_item->food_type        = $request['food_type'];
            $food_item->saveOrFail();

            if ( $request['food_type'] == 'variant' ) {
                $this->storeFoodItemVariantOptions( $request['variant_combo'], $food_item->id );
            }

            if ( !empty( $request['properties'] ) ) {
                $this->storeFoodItemProperties( $request['properties'], $food_item->id );
            }

            $this->storeBranchForEachFoodItem( $request['branch'], $food_item );

            DB::commit();
            return response()->json( [
                'success' => 1,
                'message' => translate( 'Food item stored successfully' ),
            ] );
        } catch ( \Exception $ex ) {
            DB::rollBack();
            return response()->json( [
                'success' => 0,
                'message' => translate( 'Unable to store food item' ),
            ], 500 );
        }
    }

    /**
     * Stores branches for each food item
     *
     * @param array $branches List of branch IDs
     * @param FoodItem $food_item The food item object
     * @return void
     */
    public function storeBranchForEachFoodItem( $branches, $food_item ) {
        $data = [];
        foreach ( $branches as $branch ) {
            $data[] = [
                'branch_id'    => $branch,
                'food_item_id' => $food_item->id,
            ];
        }

        FoodItemBranches::where( 'food_item_id', $food_item->id )->delete();
        FoodItemBranches::insert( $data );
    }

    /**
     * Updates a food item in the database.
     *
     * @param Request $request The HTTP request object containing the data to update the food item.
     *                        The request should have the following parameters:
     *                        - id: The ID of the food item to update (required and must exist in the food_items table).
     *                        - name: The name of the food item (required).
     *                        - category: The ID of the category the food item belongs to (required and must exist in the food_categories table).
     *                        - details: The details of the food item (required).
     *                        - image: The ID of the image associated with the food item (required and must exist in the uploads table).
     *                        - status: The status of the food item (required).
     *                        - price: The price of the food item (required).
     *                        - offer_price: The offer price of the food item (required).
     *                        - food_type: The type of the food item (required).
     * @throws \Exception If an error occurs while updating the food item.
     * @return \Illuminate\Http\JsonResponse The JSON response indicating the success or failure of the update operation.
     *                                       If successful, the response will have the following structure:
     *                                       {
     *                                           "success": 1,
     *                                           "message": "Food item stored successfully"
     *                                       }
     *                                       If unsuccessful, the response will have the following structure:
     *                                       {
     *                                           "success": <exception object>,
     *                                           "message": "Unable to store food item"
     *                                       }
     */
    public function updateFoodItems( Request $request ) {
        $request->validate( [
            'id'          => 'required|exists:food_items,id',
            'name'        => 'required',
            'category'    => 'required|exists:food_categories,id',
            'details'     => 'required',
            'image'       => 'required|exists:uploads,id',
            'status'      => 'required',
            'price'       => 'required',
            'offer_price' => 'required',
            'food_type'   => 'required',
            'branch'      => 'required',
        ] );

        try {
            DB::beginTransaction();

            $default_lang   = getGeneralSettingsValue( 'default_lang' );
            $translate_into = $request['translate_into'];
            if ( $translate_into == $default_lang ) {
                $food_item                   = FoodItem::find( $request['id'] );
                $food_item->name             = $request['name'];
                $food_item->category         = $request['category'];
                $food_item->details          = $request['details'];
                $food_item->image            = $request['image'];
                $food_item->status           = $request['status'] == 'on' ? 1 : 0;
                $food_item->price            = $request['price'];
                $food_item->offer_price      = $request['offer_price'];
                $food_item->meta_title       = $request['meta_title'];
                $food_item->meta_image       = $request['meta_image'];
                $food_item->meta_description = $request['meta_description'];
                $food_item->food_type        = $request['food_type'];
                $food_item->saveOrFail();

                if ( $request['food_type'] == 'variant' ) {
                    $this->storeFoodItemVariantOptions( $request['variant_combo'], $food_item->id, true );
                } else {
                    FoodItemVariant::where( 'item_id', $food_item->id )->delete();
                }

                if ( !empty( $request['properties'] ) ) {
                    $this->storeFoodItemProperties( $request['properties'], $food_item->id );
                }

                $this->storeBranchForEachFoodItem( $request['branch'], $food_item );

            } else {
                $this->setFoodItemTranslation( $request );
            }

            DB::commit();
            return response()->json( [
                'success' => 1,
                'message' => translate( 'Food item updated successfully' ),
            ] );
        } catch ( \Exception $ex ) {
            DB::rollBack();
            dd( $ex );
            return response()->json( [
                'success' => 0,
                'message' => translate( 'Unable to store food item' ),
            ], 500 );
        }
    }

    /**
     * Sets the translation for a food item.
     *
     * @param array $request The request data containing the item ID, translation language, and translation details.
     *                      - 'id' (int): The ID of the food item.
     *                      - 'translate_into' (int): The ID of the language to translate into.
     *                      - 'name' (string): The translated name of the food item.
     *                      - 'details' (string): The translated details of the food item.
     *                      - 'meta_title' (string): The translated meta title of the food item.
     *                      - 'meta_description' (string): The translated meta description of the food item.
     * @return void
     */
    public function setFoodItemTranslation( $request ) {
        $item_id        = $request['id'];
        $translate_into = $request['translate_into'];

        $has_previous_trans = TranslateFoodItem::where( 'item_id', $item_id )
            ->where( 'lang_id', $translate_into );

        if ( $has_previous_trans->exists() ) {
            $trans_row_id                 = $has_previous_trans->first()->id;
            $item_trans                   = TranslateFoodItem::find( $trans_row_id );
            $item_trans->name             = $request['name'];
            $item_trans->details          = $request['details'];
            $item_trans->meta_title       = $request['meta_title'];
            $item_trans->meta_description = $request['meta_title'];
            $item_trans->meta_description = $request['meta_description'];
            $item_trans->update();
        } else {
            $item_trans                   = new TranslateFoodItem();
            $item_trans->item_id          = $item_id;
            $item_trans->lang_id          = $translate_into;
            $item_trans->name             = $request['name'];
            $item_trans->details          = $request['details'];
            $item_trans->meta_title       = $request['meta_title'];
            $item_trans->meta_description = $request['meta_description'];
            $item_trans->saveOrFail();
        }
    }

    /**
     * Store food item variant options.
     *
     * @param array $variations An array of variations containing the following keys:
     *                          - combo: An array of combinations containing the following keys:
     *                            - variant: An array containing the following keys:
     *                              - id: The ID of the variant.
     *                            - options: An array containing the following keys:
     *                              - id: The ID of the option.
     * @param int $food_item_id The ID of the food item.
     * @param bool $is_for_update (optional) Whether to delete existing food item variants before storing new ones. Default is false.
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException If the food item variant or variant option is not found.
     * @throws \Illuminate\Database\Eloquent\MassAssignmentException If mass assignment is not allowed for the model.
     * @throws \Illuminate\Database\QueryException If there is a database error while saving the model.
     * @return void
     */
    public function storeFoodItemVariantOptions( $variations, $food_item_id, $is_for_update = false ) {
        if ( $is_for_update ) {
            FoodItemVariant::where( 'item_id', $food_item_id )->delete();
        }

        foreach ( $variations as $variation ) {
            $combinations = $variation['combo'];

            $food_item_variant                = new FoodItemVariant();
            $food_item_variant->item_id       = $food_item_id;
            $food_item_variant->price         = $variation['price'];
            $food_item_variant->special_price = $variation['special_price'];
            $food_item_variant->availability  = $variation['availability'];
            $food_item_variant->saveOrFail();

            foreach ( $combinations as $combo ) {
                $food_item_variant_option                       = new FoodItemVariantOption();
                $food_item_variant_option->food_item_variant_id = $food_item_variant->id;
                $food_item_variant_option->variant_id           = $combo['variant']['id'];
                $food_item_variant_option->option_id            = $combo['options']['id'];
                $food_item_variant_option->saveOrFail();
            }
        }
    }

    /**
     * Stores food item properties associated with a given food item ID.
     *
     * @param array $properties An associative array where keys are property IDs and values are arrays of item IDs.
     * @param int $food_item_id The ID of the food item to associate with the properties.
     * @throws \Illuminate\Database\Eloquent\MassAssignmentException If mass assignment is not allowed for the model.
     * @throws \Illuminate\Database\QueryException If there is a database error while saving the model.
     * @return void
     */
    public function storeFoodItemProperties( $properties, $food_item_id ) {
        FoodItemProperty::where( 'food_item_id', $food_item_id )->delete();
        foreach ( $properties as $property => $items ) {
            foreach ( $items as $item ) {
                $food_item_property                   = new FoodItemProperty();
                $food_item_property->food_item_id     = $food_item_id;
                $food_item_property->property_id      = str_replace( 'property_', '', $property );
                $food_item_property->property_item_id = $item;
                $food_item_property->saveOrFail();
            }
        }
    }

    /**
     * Edit a food item by its ID.
     *
     * @param int $id The ID of the food item to edit.
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View The view for editing the food item.
     */
    public function editFoodItems( $id ) {
        $variants             = FoodVariant::with( 'options' )->get();
        $food_item            = FoodItem::find( $id );
        $food_item_branches   = $food_item->branches->pluck( 'id' )->toArray();
        $food_item_properties = FoodItemProperty::where( 'food_item_id', $id )->get();
        $property_ids         = [];
        $property_item_ids    = [];

        foreach ( $food_item_properties as $property ) {
            $property_ids[]      = $property->property_id;
            $property_item_ids[] = $property->property_item_id;
        }

        $default_lang = getGeneralSettingsValue( 'default_lang' );
        if ( isset( request()->lang ) && ( request()->lang != $default_lang ) ) {
            $food_item = $food_item->translateInto( request()->lang )->first();
        }

        $food_item_variations = FoodItem::with( 'foodItemVariant.foodItemVariantOption.variant', 'foodItemVariant.foodItemVariantOption.option' )
            ->find( $id );

        $variant_option_array = [];
        $variant_ids          = [];
        $variant_option_ids   = [];

        foreach ( $food_item_variations->foodItemVariant as $item ) {
            $data  = [];
            $combo = [];
            foreach ( $item->foodItemVariantOption as $foodItemVariantOption ) {
                $variant_name = $foodItemVariantOption->variant->name;
                $variant_id   = $foodItemVariantOption->variant->id;

                $option_name = $foodItemVariantOption->option->option_name;
                $option_id   = $foodItemVariantOption->option->id;

                $combo[] = [
                    'variant' => [
                        'name' => $variant_name,
                        'id'   => $variant_id,
                    ],
                    'options' => [
                        'name' => $option_name,
                        'id'   => $option_id,
                    ],
                ];

                if ( !in_array( $variant_id, $variant_ids ) ) {
                    array_push( $variant_ids, $variant_id );
                }

                if ( !$this->comboExists( $variant_option_ids, $variant_id, $option_id ) ) {
                    $variant_option_ids[] = [
                        'variant_id' => $variant_id,
                        'option_id'  => $option_id,
                    ];
                }
            }
            $data['combo']          = $combo;
            $data['price']          = $item->price;
            $data['special_price']  = $item->special_price;
            $data['availability']   = $item->availability;
            $variant_option_array[] = $data;
        }

        // dd($variant_option_array, $variant_ids, $variant_option_ids,$variants,$food_item);
        // dd( $variant_option_array );

        return view( 'food::admin.foods.edit', compact( 'variants', 'food_item', 'variant_ids', 'variant_option_ids', 'variant_option_array', 'food_item_branches', 'property_ids', 'property_item_ids' ) );
    }

    /**
     * Checks if a combination of variant and option exists in the variant_option_ids array.
     *
     * @param array $variant_option_ids An array of variant-option combinations.
     * @param int $variant_id The id of the variant to check.
     * @param int $option_id The id of the option to check.
     * @return bool Returns true if the variant-option combination exists, false otherwise.
     */
    function comboExists( $variant_option_ids, $variant_id, $option_id ) {
        // Iterate over each item in the variant_option_ids array.
        foreach ( $variant_option_ids as $item ) {
            // Check if the variant_id and option_id of the current item
            // match the provided variant_id and option_id.
            if ( $item["variant_id"] == $variant_id && $item["option_id"] == $option_id ) {
                // If there is a match, return true.
                return true;
            }
        }
        // If no match is found, return false.
        return false;
    }

    /**
     * Deletes a food item.
     *
     * @param Request $request The HTTP request object containing the food item ID.
     * @throws \Exception If an error occurs while deleting the food item.
     * @return \Illuminate\Http\JsonResponse The JSON response indicating the success or failure of the deletion.
     */
    public function deleteFoodItem( Request $request ) {
        try {
            $food_item = FoodItem::find( (int) $request['id'] );
            $food_item->delete();

            Toastr::success( 'Food item deleted successfully', 'Success' );
            return back();
        } catch ( \Throwable $ex ) {
            Toastr::error( 'Unable to delete food item', 'Error' );
            return back();
        }
    }

    /**
     * Toggles the status of a food item.
     *
     * @param Request $request The HTTP request object containing the food item ID.
     * @throws \Exception If an error occurs while updating the food item status.
     * @return \Illuminate\Http\JsonResponse The JSON response indicating the success or failure of the status update.
     */
    public function updateItemStatus( Request $request ) {
        try {
            $item = FoodItem::find( $request['id'] );
            if ( $item->status == 1 ) {
                $item->status = 0;
            } else {
                $item->status = 1;
            }

            $item->update();
            return response()->json( [
                'success' => true,
                'message' => translate( 'Food item status updated successfully' ),
            ] );
        } catch ( \Exception $ex ) {
            return response()->json( [
                'success' => false,
                'message' => translate( 'Unable to change status' ),
            ] );
        }
    }
}
