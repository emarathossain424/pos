<?php

namespace Plugin\Pos\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Plugin\Food\Models\FoodCategory;
use Plugin\Food\Models\FoodItem;

class PosController extends Controller {

    public function index( Request $request ) {
        $categories = FoodCategory::all();

        $match_case = [
            ['status', 1],
        ];

        if ( !empty( $request->input( 'category' ) ) ) {
            $match_case[] = ['category', '=', $request->input( 'category' )];
        }

        $food_items = FoodItem::with( 'foodCategory' )->where( $match_case );

        // Check if branch is provided
        if ( !empty( $request->input( 'branch' ) ) ) {
            $branch_id = $request->input( 'branch' );

            // Filter by branch_id using whereHas to query the related branches
            $food_items = $food_items->whereHas( 'branches', function ( $query ) use ( $branch_id ) {
                $query->where( 'core_branches.id', $branch_id );
            } );
        }

        // Apply search by part of word on 'name' column if search term is provided
        if ( !empty( $request->input( 'search' ) ) ) {
            $searchTerm = $request->input( 'search' );
            $food_items = $food_items->where( 'name', 'LIKE', "%{$searchTerm}%" );
        }

        $food_items = $food_items->paginate( 9 );

        // dd( $food_items );

        return view( 'pos::admin.pos.index', compact( 'categories', 'food_items' ) );
    }
}