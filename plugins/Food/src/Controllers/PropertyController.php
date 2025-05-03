<?php

namespace Plugin\Food\Controllers;

use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Plugin\Food\Models\FoodItemProperty;
use Plugin\Food\Models\FoodPropertyGroupItems;
use Plugin\Food\Models\FoodPropertyGroups;
use Plugin\Food\Models\TranslateFoodPropertyGroupItems;
use Plugin\Food\Models\TranslateFoodPropertyGroups;

class PropertyController extends Controller
{

    /**
     * Retrieves and displays a list of food property groups along with their associated items.
     *
     * @return \Illuminate\Http\Response The rendered view containing the list of food property groups.
     */
    public function properties()
    {
        $properties = FoodPropertyGroups::with('items')->get();
        return view('Food::admin.property.index', compact('properties'));
    }

    /**
     * Creates a new food property group based on the provided request data.
     *
     * @param Request $request The incoming request containing the property data.
     * @throws \Exception If an error occurs while storing the property group.
     * @return \Illuminate\Http\RedirectResponse Redirects back to the previous page.
     */
    public function createProperty(Request $request)
    {
        $request->validate([
            'property_name' => 'required|unique:food_property_groups,name',
        ]);
        try {
            $property         = new FoodPropertyGroups();
            $property->name   = $request['property_name'];
            $property->status = $request['property_status'];
            $property->saveOrFail();

            Toastr::success('Property group created successfully', 'Success');
            return back();
        } catch (\Exception $ex) {
            Toastr::error('Unable to create property group', 'Error');
            return back();
        }
    }

    /**
     * Updates an existing food property group.
     *
     * @param Request $request The incoming request containing the property data.
     * @throws \Exception If an error occurs while updating the property group.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateProperty(Request $request)
    {
        $request->validate([
            'property_name' => 'required|unique:food_property_groups,name,' . $request['id'],
        ]);
        $default_lang   = getGeneralSettingsValue('default_lang');
        $translate_into = $request['translate_into'];
        try {
            if ($default_lang == $translate_into) {
                $property         = FoodPropertyGroups::find((int) $request['id']);
                $property->name   = $request['property_name'];
                $property->status = $request['property_status'];
                $property->update();
            } else {
                $property_id    = $request['id'];
                $translate_into = $request['translate_into'];

                $has_previous_trans = TranslateFoodPropertyGroups::where('property_group_id', $property_id)
                    ->where('lang_id', $translate_into);

                if ($has_previous_trans->exists()) {
                    $trans_row_id                      = $has_previous_trans->first()->id;
                    $property_trans                    = TranslateFoodPropertyGroups::find($trans_row_id);
                    $property_trans->property_group_id = $property_id;
                    $property_trans->lang_id           = $translate_into;
                    $property_trans->name              = $request['property_name'];
                    $property_trans->update();
                } else {
                    $property_trans                    = new TranslateFoodPropertyGroups();
                    $property_trans->property_group_id = $property_id;
                    $property_trans->lang_id           = $translate_into;
                    $property_trans->name              = $request['property_name'];
                    $property_trans->saveOrFail();
                }
            }
            Toastr::success('Food property group updated successfully', 'Success');
            return back();
        } catch (\Exception $ex) {
            Toastr::error('Unable to update food property group', 'Error');
            return back();
        }
    }

    /**
     * Deletes a food property group by its ID.
     *
     * @param Request $request The HTTP request containing the ID of the food property group to delete.
     * @throws \Exception If an error occurs during the deletion process.
     * @return \Illuminate\Http\RedirectResponse Redirects back to the previous page.
     */
    public function deleteProperty(Request $request)
    {
        try {
            $property = FoodPropertyGroups::find((int) $request['id']);
            $property->delete();
            Toastr::success('Food property group deleted successfully', 'Success');
            return back();
        } catch (\Exception $ex) {
            Toastr::error('Unable to delete food property group', 'Error');
            return back();
        }
    }

    /**
     * Creates a new food property item based on the provided request data.
     *
     * @param Request $request The incoming request containing the item data.
     * @throws \Exception If an error occurs while storing the food property item.
     * @return \Illuminate\Http\RedirectResponse Redirects back to the previous page.
     */
    public function addItem(Request $request)
    {
        $request->validate([
            'property_id' => 'required|exists:food_property_groups,id',
            'item_name'   => 'required|unique:food_property_group_items,item_name',
        ]);
        try {
            $item                    = new FoodPropertyGroupItems();
            $item->property_group_id = $request['property_id'];
            $item->item_name         = $request['item_name'];
            $item->price             = $request['item_price'];
            $item->status            = $request['item_status'];
            $item->saveOrFail();
            Toastr::success('Food property item created successfully', 'Success');
            return back();
        } catch (\Exception $ex) {
            Toastr::error('Unable to store food property item', 'Error');
            return back();
        }
    }

    /**
     * Updates an existing food property item.
     *
     * @param Request $request The incoming request containing the item data.
     * @throws \Exception If an error occurs while updating the item.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateItem(Request $request)
    {
        $request->validate([
            'item_name' => 'required|unique:food_property_group_items,item_name,' . $request['id'],
        ]);
        $default_lang   = getGeneralSettingsValue('default_lang');
        $translate_into = $request['translate_into'];

        try {
            if ($default_lang == $translate_into) {
                $item            = FoodPropertyGroupItems::find((int) $request['id']);
                $item->item_name = $request['item_name'];
                $item->price     = $request['item_price'];
                $item->status    = $request['item_status'];
                $item->update();
            } else {
                $item_id        = $request['id'];
                $translate_into = $request['translate_into'];

                $has_previous_trans = TranslateFoodPropertyGroupItems::where('item_id', $item_id)
                    ->where('lang_id', $translate_into);

                if ($has_previous_trans->exists()) {
                    $trans_row_id          = $has_previous_trans->first()->id;
                    $item_trans            = TranslateFoodPropertyGroupItems::find($trans_row_id);
                    $item_trans->item_id   = $item_id;
                    $item_trans->lang_id   = $translate_into;
                    $item_trans->item_name = $request['item_name'];
                    $item_trans->update();
                } else {
                    $item_trans            = new TranslateFoodPropertyGroupItems();
                    $item_trans->item_id   = $item_id;
                    $item_trans->lang_id   = $translate_into;
                    $item_trans->item_name = $request['item_name'];
                    $item_trans->saveOrFail();
                }
            }
            Toastr::success('Food property item updated successfully', 'Success');
            return back();
        } catch (\Exception $ex) {
            Toastr::error('Unable to update food property item', 'Error');
            return back();
        }
    }

    /**
     * Deletes a food property item by its ID.
     *
     * @param Request $request The HTTP request containing the ID of the item to delete.
     * @throws \Exception If an error occurs during the deletion process.
     * @return \Illuminate\Http\RedirectResponse Redirects back to the previous page.
     */
    public function deleteItem(Request $request)
    {
        try {
            $item = FoodPropertyGroupItems::find((int) $request['id']);
            $item->delete();
            Toastr::success('Food property item deleted successfully', 'Success');
            return back();
        } catch (\Exception $ex) {
            Toastr::error('Unable to delete food property item', 'Error');
            return back();
        }
    }

    /**
     * Retrieves the translation of a food property group.
     *
     * @param Request $request The HTTP request object.
     *                         The request should have the following parameters:
     *                         - lang_id: The ID of the language to retrieve the translation for.
     *                         - id: The ID of the food property group to retrieve the translation for.
     * @return \Illuminate\Http\JsonResponse The JSON response containing the translation of the food property group.
     *                                       If successful, the response will have the following structure:
     *                                       {
     *                                           "success": 1,
     *                                           "data": {
     *                                               "name": "Translated group name"
     *                                           },
     *                                           "message": "Translated group name"
     *                                       }
     *                                       If unsuccessful, the response will have the following structure:
     *                                       {
     *                                           "success": 0,
     *                                           "data": [],
     *                                           "message": "No translation found"
     *                                       }
     */
    public function getPropertyTranslation(Request $request)
    {
        $lang_id           = $request['lang_id'];
        $property_group_id = $request['id'];

        $translated_property = TranslateFoodPropertyGroups::where('property_group_id', $property_group_id)
            ->where('lang_id', $lang_id)->first();

        if ($translated_property) {
            return response()->json([
                'success' => 1,
                'data'    => [
                    'name' => $translated_property->name,
                ],
                'message' => translate('Translated property group name'),
            ]);
        } else {
            return response()->json([
                'success' => 0,
                'data'    => [],
                'message' => translate('No translation found'),
            ]);
        }
    }

    /**
     * Retrieves the translation of a food property item.
     *
     * @param Request $request The HTTP request object.
     *                        The request should have the following parameters:
     *                        - lang_id: The ID of the language to retrieve the translation for.
     *                        - id: The ID of the food property item to retrieve the translation for.
     * @return \Illuminate\Http\JsonResponse The JSON response containing the translation of the food property item.
     *                                       If successful, the response will have the following structure:
     *                                       {
     *                                           "success": 1,
     *                                           "data": {
     *                                               "name": "Translated item name"
     *                                           },
     *                                           "message": "Translated item name"
     *                                       }
     *                                       If unsuccessful, the response will have the following structure:
     *                                       {
     *                                           "success": 0,
     *                                           "data": [],
     *                                           "message": "No translation found"
     *                                       }
     */
    public function getItemTranslation(Request $request)
    {
        $lang_id = $request['lang_id'];
        $item_id = $request['id'];

        $translated_item = TranslateFoodPropertyGroupItems::where('item_id', $item_id)
            ->where('lang_id', $lang_id)->first();

        if ($translated_item) {
            return response()->json([
                'success' => 1,
                'data'    => [
                    'name' => $translated_item->item_name,
                ],
                'message' => translate('Translated item name'),
            ]);
        } else {
            return response()->json([
                'success' => 0,
                'data'    => [],
                'message' => translate('No translation found'),
            ]);
        }
    }

    /**
     * Retrieves a list of food property items based on the provided request data.
     *
     * @param Request $request The HTTP request object containing the selected property items and properties.
     *                        The request should have the following parameters:
     *                        - selected_property_items: An array of IDs of the selected property items.
     *                        - properties: An array of IDs of the food property groups associated with the selected property items.
     * @return \Illuminate\Http\Response The rendered view containing the list of food property items.
     */
    public function getPropertyItems(Request $request)
    {
        $property_item_ids = $request['selected_property_items'] ?? [];
        $property_ids      = $request['properties'];
        $properties        = FoodPropertyGroups::whereIn('id', $property_ids)
            ->with('items')
            ->get();

        return view('Food::admin.foods.partial.property_items', compact('properties', 'property_item_ids'));
    }

    /**
     * Retrieves a list of food property items associated with a single food item, given by its ID.
     *
     * @param Request $request The HTTP request object containing the food item ID.
     *                        The request should have the following parameter:
     *                        - item_id: The ID of the food item to retrieve the associated property items for.
     * @return \Illuminate\Http\Response The rendered view containing the list of food property items associated with the food item.
     */
    public function getSingleItemProperties(Request $request)
    {
        $order_index          = $request['index'];
        $id                   = $request['item_id'];
        $selected_properties  = $request['properties'] ?? [];
        $property_ids         = [];
        $food_item_properties = FoodItemProperty::where('food_item_id', $id)->get();

        foreach ($food_item_properties as $property) {
            $property_ids[]      = $property->property_id;
        }

        $properties = FoodPropertyGroups::whereIn('id', $property_ids)
            ->where('status', 1)
            ->with('items')
            ->get();


        return view('Food::admin.foods.partial.property_items_for_orders', compact('properties', 'order_index', 'selected_properties'));
    }
}
