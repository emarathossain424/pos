@php
$order_types = getOrderTypes();
$order_status = getOrderStatus();
@endphp
@if($ordered_items)
<table class="table table-sm">
    <thead>
        <tr>
            <td><strong>{{translate('Order Details')}}<strong></td>
            <td class="text-right"><button type="button" class="btn btn-sm btn-danger" id="clear-cart">{{translate('Clear Cart')}}</button></td>
        </tr>
    </thead>
    <tbody>
        @foreach($ordered_items as $key=>$item)
        @php
        $subtotal = $item['price'];
        $total = $subtotal;
        $total_without_discount = $subtotal;
        @endphp
        <tr>
            <td>
                <strong>
                    {{$item['name']}}
                    <a href="#" class="ordered-item-remove" data-index="{{$key}}">
                        <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="#EA3323">
                            <path d="m339-288 141-141 141 141 51-51-141-141 141-141-51-51-141 141-141-141-51 51 141 141-141 141 51 51ZM480-96q-79 0-149-30t-122.5-82.5Q156-261 126-331T96-480q0-80 30-149.5t82.5-122Q261-804 331-834t149-30q80 0 149.5 30t122 82.5Q804-699 834-629.5T864-480q0 79-30 149t-82.5 122.5Q699-156 629.5-126T480-96Zm0-72q130 0 221-91t91-221q0-130-91-221t-221-91q-130 0-221 91t-91 221q0 130 91 221t221 91Zm0-312Z" />
                        </svg>
                    </a>
                </strong>
                <div class="small">
                    @if(isset($item['variant']))
                    <div>
                        <a href="#" class="change-variant" data-index="{{$key}}" data-toggle="modal" data-target="#item-variant">
                            {{translate('Change Variant')}}
                        </a>
                    </div>
                    @foreach($item['variant']['combo'] as $combo)
                    <div>{{$combo['variant']['name']}}: {{$combo['options']['name']}}</div>
                    @endforeach
                    @endif
                    <div>
                        {{translate('Amount:')}}
                        <button class="btn btn-sm ordered-item-amount-decrement" data-index="{{ $key }}">-</button>
                        <span id="amount">{{ $item['quantity'] }}</span>
                        <button class="btn btn-sm ordered-item-amount-increment" data-index="{{ $key }}">+</button>
                    </div>
                    <div>
                        {{translate('Price:')}}
                        <span>{{ $item['quantity']}} x {{setPriceFormat($item['unit_price'])}} = {{ setPriceFormat($item['quantity'] * $item['unit_price']) }}</span>
                    </div>
                    <div><a href="#" class="change-properties" data-index="{{$key}}" data-toggle="modal" data-target="#item-properties">{{translate('Add Properties')}}</a></div>
                    @if(!empty($item['properties']))
                    @foreach($item['properties'] as $property)
                    <div>{{getFoodPropertyName($property['property_group_id'])}}: {{$property['item_name']}} ({{$property['quantity']}} x {{setPriceFormat($property['price'])}} = {{setPriceFormat($property['quantity']*$property['price'])}})</div>
                    @endforeach
                    @else
                    <div>{{translate('No properties')}}</div>
                    @endif
                </div>
            </td>
            <td class="text-right">{{setPriceFormat($item['price'])}}</td>
        </tr>
        @endforeach
        <tr>
            <td><strong>{{translate('Subtotal')}}</strong></td>
            <td class="text-right">
                <input type="hidden" id="subtotal" name="subtotal" value="{{$total}}">
                {{setPriceFormat($total)}}
            </td>
        </tr>
        <tr>
            @php
            $discount_type = !empty($order_discount) ? $order_discount['discount_type'] : 'amount';
            $discount = !empty($order_discount) ? $order_discount['discount_amount'] : 0;

            if($discount_type == 'percent'){
            $discount_amount = $total * $discount / 100;
            }
            else{
            $discount_amount = $discount;
            }
            $total = $total-$discount_amount;
            @endphp
            <td>
                <strong>{{translate('Discount')}}</strong>
                <div class="small">
                    <a href="#" id="add-discount" data-toggle="modal" data-target="#order-discount">
                        {{translate('Add Discount')}}
                    </a>
                </div>
            </td>
            <td class="text-right">- {{setPriceFormat($discount_amount)}}</td>
        </tr>

        @if(!empty($taxes))
        @foreach($taxes as $tax)
        @php
        $tax_amount = $total_without_discount * $tax['tax_rate'] / 100;
        $total = $total - $tax_amount;
        @endphp
        <tr>
            <td>
                <div>
                    <strong>{{$tax['tax_name']}} ({{$tax['tax_rate'].'%'}})</strong>
                </div>
                @if($loop->last)
                <div class="small">
                    <a href="#" id="add-tax" data-toggle="modal" data-target="#order-Tax">
                        {{translate('Add Tax')}}
                    </a>
                </div>
                @endif
            </td>
            <td class="text-right">
                -{{setPriceFormat($tax_amount)}}
            </td>
        </tr>
        @endforeach
        @else
        <tr>
            <td>
                <strong>{{translate('Tax: (0%)')}}</strong>
                <div class="small">
                    <a href="#" id="add-tax" data-toggle="modal" data-target="#order-Tax">
                        {{translate('Add Tax')}}
                    </a>
                </div>
            </td>

            <td class="text-right">
                -{{setPriceFormat(0)}}
            </td>
        </tr>
        @endif

        <tr>
            <td><strong>{{translate('Grand Total')}}</strong></td>
            <td class="text-right">
                <input type="hidden" id="total" name="total" value="{{$total}}">
                <span class="fs-5"><strong>{{setPriceFormat($total)}}</strong></span>
            </td>
        </tr>
        <tr>
            <td>
                <strong>{{translate('Assigned Table')}}</strong>
                <div class="small">
                    <a href="#" id="select-table" data-toggle="modal" data-target="#order-table">{{translate('Select Table')}}</a>
                </div>
            </td>
            <td class="text-right">
                <div id="all-selected-table">
                    <i class="fa fa-ban"></i>
                </div>
            </td>
        </tr>
        <tr>
            <td><strong>{{translate('Customer Name')}}</strong></td>
            <td class="text-right">
                <button type="button" class="btn btn-outline-primary btn-sm" id="select-customer" data-toggle="modal" data-target="#order-customer">
                    <span id="selected-customer">{{translate('Walk-in')}}</span>
                    <i class="fa fa-angle-down"></i>
                </button>
            </td>
        </tr>
        <tr>
            <td><strong>{{translate('Order Type')}}</strong></td>
            <td class="text-right">
                <select name="order_type" id="order_type" class="form-control form-control-sm">
                    @foreach( $order_types as $order_type )
                    <option value="{{$order_type->id}}">{{$order_type->name}}</option>
                    @endforeach
                </select>
            </td>
        </tr>
        <tr>
            <td>
                <strong>{{translate('Payment Type')}}</strong>
            </td>
            <td class="text-right">
                <select name="payment_method" id="payment_method" class="form-control form-control-sm">
                    <option value="cash">{{translate('Cash')}}</option>
                    <option value="card">{{translate('Card')}}</option>
                    <option value="mobile_banking">{{translate('Mobile Banking')}}</option>
                </select>
            </td>
        </tr>
        <tr>
            <td><strong>{{translate('Order Status')}}</strong></td>
            <td class="text-right">
                <select name="order_status" id="order_status" class="form-control form-control-sm">
                    @foreach( $order_status as $order_status )
                    <option value="{{$order_status->id}}">{{$order_status->name}}</option>
                    @endforeach
                </select>
            </td>
        </tr>
        <tr>
            <td colspan="2" class="text-center">
                <button type="button" class="btn btn-success btn-block mt-3 ml-1 w-100" id="process-transaction">{{translate('Process Transaction')}}</button>
                <div class="justify-content-between d-none" id="order-buttons">
                    <button type="button" class="btn btn-success btn-block mt-3 ml-1 w-100">{{translate('Take New Order')}}</button>
                    <button type="button" class="btn bg-pink btn-block mt-3 ml-1 w-100">{{translate('Print Receipt')}}</button>
                </div>
            </td>
        </tr>
    </tbody>
</table>
@else
<h5 class="text-center mt-3">
    {{translate('No ordered items found')}}
</h5>
@endif