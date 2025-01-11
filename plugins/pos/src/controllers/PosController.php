<?php

namespace Plugin\Pos\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Plugin\Food\Models\FoodCategory;
use Plugin\Food\Models\FoodItem;

class PosController extends Controller
{

    /**
     * Display a listing of food items with filtering and pagination.
     *
     * This method fetches all available categories and filters food items
     * based on the provided request parameters including category, branch,
     * and search term. It paginates the results and returns a view with
     * the relevant data.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $categories = FoodCategory::all();

        $match_case = [
            ['status', 1],
        ];

        if (!empty($request->input('category'))) {
            $match_case[] = ['category', '=', $request->input('category')];
        }

        $food_items = FoodItem::with('foodCategory', 'foodItemVariant.foodItemVariantOption.variant', 'foodItemVariant.foodItemVariantOption.option',)->where($match_case);

        // Check if branch is provided
        if (!empty($request->input('branch'))) {
            $branch_id = $request->input('branch');

            // Filter by branch_id using whereHas to query the related branches
            $food_items = $food_items->whereHas('branches', function ($query) use ($branch_id) {
                $query->where('core_branches.id', $branch_id);
            });
        }

        // Apply search by part of word on 'name' column if search term is provided
        if (!empty($request->input('search'))) {
            $searchTerm = $request->input('search');
            $food_items = $food_items->where('name', 'LIKE', "%{$searchTerm}%");
        }

        $food_items = $food_items->paginate(2);

        if ($request->ajax()) {
            return response()->json([
                'data'       => view('pos::admin.pos.partial.food_items', compact('food_items'))->render(),
                'pagination' => (string) $food_items->links('pagination::bootstrap-5'),
            ]);
        }

        return view('pos::admin.pos.index', compact('categories', 'food_items'));
    }

    /**
     * Will return a rendered partial view of the ordered items
     * given the ordered items data from the request.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function posAddToCart(Request $request)
    {
        $order_discount = $request['order_discount'] ?? [];
        $taxes          = $request['taxes'] ?? [];

        $ordered_items = $request['ordered_items'] ?? [];

        return view('pos::admin.pos.partial.ordered_items', compact('ordered_items', 'order_discount', 'taxes'));
    }

    /**
     * Will return a rendered partial view of the ordered items
     * given the ordered items data from the request.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function itemSearch(Request $request)
    {
        $searchTerm = $request->input('query');
        $food_items = FoodItem::where('name', 'LIKE', "%{$searchTerm}%")->get();
        foreach ($food_items as $item) {
            $item->image = getFilePath($item->image);
        }
        return response()->json($food_items);
    }
}
