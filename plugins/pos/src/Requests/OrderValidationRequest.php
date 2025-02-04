<?php

namespace Plugin\Pos\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderValidationRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'customer_details.customer_id' => [
                'nullable',
                'exists:core_customers,id'
            ],
            'customer_details.mobile' => [
                'required_with:customer_details.customer_id',
            ],
            'customer_details.name' => [
                'required_with:customer_details.customer_id',
            ],
            'ordered_items' => 'required|array|min:1',
            'ordered_items.*.id' => [
                'required',
                'exists:food_items,id'
            ],

            // Validate variants if exists
            'ordered_items.*.variant.combo' => 'nullable|array',
            'ordered_items.*.variant.combo.*.variant.id' => 'required_with:ordered_items.*.variant.combo|exists:food_variants,id',
            'ordered_items.*.variant.combo.*.options.id' => 'required_with:ordered_items.*.variant.combo|exists:food_variant_options,id',

            // Validate properties
            'ordered_items.*.properties' => 'nullable|array',
            'ordered_items.*.properties.*.id' => 'exists:food_property_group_items,id',

            // Validate order discount
            'order_discount.discount_type' => 'required|in:percent,fixed',
            'order_discount.discount_amount' => 'required|numeric|min:0|max:100',

            // Validate tax details
            'tax_details' => 'required|array|min:1',
            'tax_details.*.tax_id' => 'required|exists:core_taxes,id',

            // Validate tables
            'checked_tables' => 'nullable|array',
            'checked_tables.*.hall_id' => 'exists:halls,id',
            'checked_tables.*.table_id' => 'exists:tables,id',

            'order_type' => 'required|exists:core_order_types,id',
            'payment_type' => 'required|in:cash,card,mobile_banking',
            'order_status' => 'required|exists:core_order_status,id',

            'subtotal' => 'required',
            'total' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'customer_details.customer_id.exists' => 'The selected customer does not exist.',
            'ordered_items.*.id.exists' => 'One or more food items are invalid.',
            'ordered_items.*.variant.combo.*.variant.id.exists' => 'Invalid variant selected.',
            'ordered_items.*.variant.combo.*.options.id.exists' => 'Invalid variant option selected.',
            'tax_details.*.tax_id.exists' => 'Invalid tax ID provided.',
        ];
    }
}
