<?php

namespace Plugin\Pos\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Plugin\Food\Models\FoodCategory;
use Plugin\Food\Models\FoodItem;
use Plugin\Pos\Models\Order;
use Plugin\Pos\Models\OrderedItem;
use Plugin\Pos\Requests\OrderValidationRequest;

class PosController extends Controller {

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
    public function index( Request $request ) {
        $categories = FoodCategory::all();

        $match_case = [
            ['status', 1],
        ];

        if ( !empty( $request->input( 'category' ) ) ) {
            $match_case[] = ['category', '=', $request->input( 'category' )];
        }

        $food_items = FoodItem::with( 'foodCategory', 'foodItemVariant.foodItemVariantOption.variant', 'foodItemVariant.foodItemVariantOption.option', )->where( $match_case );

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

        $food_items = $food_items->paginate( 2 );

        if ( $request->ajax() ) {
            return response()->json( [
                'data'       => view( 'Pos::admin.pos.partial.food_items', compact( 'food_items' ) )->render(),
                'pagination' => (string) $food_items->links( 'pagination::bootstrap-5' ),
            ] );
        }

        return view( 'Pos::admin.pos.index', compact( 'categories', 'food_items' ) );
    }

    /**
     * Will return a rendered partial view of the ordered items
     * given the ordered items data from the request.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function posAddToCart( Request $request ) {
        $order_discount = $request['order_discount'] ?? [];
        $taxes          = $request['taxes'] ?? [];

        $ordered_items = $request['ordered_items'] ?? [];

        return view( 'Pos::admin.pos.partial.ordered_items', compact( 'ordered_items', 'order_discount', 'taxes' ) );
    }

    /**
     * Will return a rendered partial view of the ordered items
     * given the ordered items data from the request.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function itemSearch( Request $request ) {
        $searchTerm = $request->input( 'query' );
        $food_items = FoodItem::where( 'name', 'LIKE', "%{$searchTerm}%" )->get();
        foreach ( $food_items as $item ) {
            $item->image = getFilePath( $item->image );
        }
        return response()->json( $food_items );
    }

    public function placeOrder( OrderValidationRequest $request ) {
        // dd($request->all());
        try {
            DB::beginTransaction();
            $customer_details = $request['customer_details'];
            $ordered_items    = $request['ordered_items'];

            $customer_id = $customer_details['customer_id'];
            if ( empty( $customer_id ) ) {
                $customer_id = $this->register_customers( $customer_details );
            }

            $order_id = $this->createOrder( $request, $customer_id );
            $this->storeOrderedItems( $ordered_items, $order_id );

            DB::commit();
            return response()->json( [
                'success'  => 1,
                'message'  => 'Order placed successfully',
                'order_id' => $order_id, // Send order ID for invoice printing
            ] );
        } catch ( \Exception $ex ) {
            DB::rollback();
            return response()->json( [
                'success' => 0,
                'message' => 'Unable to place order',
            ] );
        }
    }

    public function register_customers( $customer_details ) {
        $name    = !empty( $customer_details['customer_name'] ) ? $customer_details['customer_name'] : '';
        $mobile  = !empty( $customer_details['customer_mobile'] ) ? $customer_details['customer_mobile'] : '';
        $email   = !empty( $customer_details['customer_email'] ) ? $customer_details['customer_email'] : '';
        $address = !empty( $customer_details['customer_address'] ) ? $customer_details['customer_address'] : '';

        $customer          = new Customer();
        $customer->name    = $name;
        $customer->mobile  = $mobile;
        $customer->email   = $email;
        $customer->address = $address;
        $customer->save();

        return $customer->id;
    }

    public function createOrder( $request, $customer_id ) {
        $checked_tables = $request['checked_tables'];
        $order_discount = $request['order_discount'];
        $tax_details    = $request['tax_details'];
        $checked_tables = $request['checked_tables'];
        $order_type     = $request['order_type'];
        $payment_type   = $request['payment_type'];
        $order_status   = $request['order_status'];
        $total          = $request['total'];
        $subtotal       = $request['subtotal'];
        $order_date     = date( 'YmdHis' );
        $token          = "C" . $customer_id . "D" . $order_date;

        $order                        = new Order();
        $order->token                 = $token;
        $order->customer_id           = $customer_id;
        $order->order_discount_type   = $order_discount['discount_type'];
        $order->order_discount_amount = $order_discount['discount_amount'];
        $order->order_type            = $order_type;
        $order->payment_type          = $payment_type;
        $order->order_status          = $order_status;
        $order->selected_tables       = json_encode( $checked_tables );
        $order->tax_details           = json_encode( $tax_details );
        $order->subtotal              = $subtotal;
        $order->total                 = $total;
        $order->save();

        return $order->id;
    }

    public function storeOrderedItems( $ordered_items, $order_id ) {
        foreach ( $ordered_items as $value ) {
            $variant = !empty( $value['variant'] ) && is_array( $value['variant'] ) ? $value['variant'] : [];

            $properties = !empty( $value['properties'] ) && is_array( $value['properties'] ) ? $value['properties'] : [];

            $ordered_item                       = new OrderedItem();
            $ordered_item->order_id             = $order_id;
            $ordered_item->item_id              = $value['id'];
            $ordered_item->is_variant           = !empty( $variant ) ? 1 : 0;
            $ordered_item->variant_with_options = json_encode( $variant );
            $ordered_item->has_property         = !empty( $properties ) ? 1 : 0;
            $ordered_item->properties           = json_encode( $properties );
            $ordered_item->quantity             = $value['quantity'];
            $ordered_item->unit_price           = $value['unit_price'];
            $ordered_item->price                = $value['price'];
            $ordered_item->save();
        }
    }

    public function printInvoice( $order_id ) {
        $order = Order::where( 'id', $order_id )->with( ['customer', 'orderedItems'] )->firstOrFail();

        // Decode taxes JSON field
        $taxes = collect( json_decode( $order->taxes, true ) )->map( function ( $tax ) use ( $order ) {
            $tax_amount = ( $order->subtotal * $tax['tax_rate'] ) / 100;
            return [
                'name'   => $tax['tax_name'],
                'rate'   => $tax['tax_rate'],
                'amount' => $tax_amount,
            ];
        } );

        // Prepare items data with propertiess
        $items = $order->orderedItems->map( function ( $item ) {
            $properties = collect( json_decode( $item->properties, true ) )->map( function ( $property ) {
                return [
                    'name'  => $property['item_name'],
                    'price' => $property['price'],
                ];
            } );

            $property_total = $properties->sum( 'price' );

            return [
                'name'        => $item->foodItem->name ?? $item->name, // Item name
                'quantity'    => $item->quantity, // Quantity ordered
                'base_price'  => $item->price, // Base price of the item
                'properties'  => $properties, // Properties with prices
                'total_price' => ( $item->price + $property_total ) * $item->quantity, // Total price with properties
            ];
        } );

        // Prepare the data for the invoice
        $data = [
            'date'          => now()->format( 'd/m/Y, h:i A' ),
            'bill_no'       => $order->id,
            'payment_mode'  => ucfirst( $order->payment_type ),
            'dr_ref'        => $order->dr_ref ?? '-',
            'items'         => $items,
            'subtotal'      => $order->subtotal,
            'discount'      => $order->discount,
            'taxes'         => $taxes,
            'total'         => $order->total,
            'cash'          => $order->total,
            'cash_tendered' => $order->cash_tendered ?? $order->total,
        ];

        return view( 'Pos::admin.pos.invoice.invoice', $data );
    }
}
