@php
$languages = getAllLanguages();
$default_lang = getGeneralSettingsValue('default_lang');
$translatedLang = isset(request()->lang)?request()->lang:$default_lang;

$all_branches = getBranches();
$taxes = getAllActiveTaxes();
$customers = getAllCustomers();

$hall_and_tables = getAllHallAndTables();
@endphp
@extends('layouts.master')
@section('title') {{translate('Halls')}} @endsection
@push('css')
<link rel="stylesheet" href="{{asset('pos/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('pos/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('pos/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('pos/plugins/select2/css/select2.min.css')}}">
<link rel="stylesheet" href="{{asset('pos/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">

<style>
    .fixed-image {
        height: 150px;
        /* Set the fixed height */
        background-color: #f5f5f5;
        /* Optional background color */
    }

    .fixed-image img {
        object-fit: cover;
        /* Ensure the image covers the container */
        width: 100%;
        /* Fill the container width */
        height: 100%;
        /* Fill the container height */
    }

    .quantity-selector {
        display: flex;
        align-items: center;
    }

    .quantity-selector .btn-decrement,
    .quantity-selector .btn-increment {
        border: none;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
    }

    .quantity-selector .btn-decrement {
        border-color: #e43d89;
        color: #e43d89;
        border: 1px solid #e43d89;
    }

    .quantity-selector .btn-increment {
        color: #e43d89;
        border: 1px solid #e43d89;
    }

    .quantity-selector .quantity-input {
        width: 40px;
        text-align: center;
        border: none;
        font-weight: bold;
        margin: 0 8px;
    }

    /* Place Order Button Styling */
    .place-order-btn {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background-color: #007bff;
        color: #fff;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
    }

    .btn-outline-pink {
        color: #e43d89;
        border-color: #e43d89;
    }

    .btn-pink {
        color: #fff;
        background-color: #e43d89;
        border-color: #e43d89;
        box-shadow: none;
    }

    .btn-pink:hover,
    .btn-pink:focus,
    .btn-pink:active {
        color: #fff;
        background-color: #e43d89;
        border-color: #e43d89;
        box-shadow: none;
    }

    .btn-outline-pink:hover,
    .btn-outline-pink:focus,
    .btn-outline-pink:active {
        color: #fff;
        background-color: #e43d89;
        border-color: #e43d89;
        box-shadow: none;
    }

    .card {
        box-shadow: 0 0 0px rgba(0, 0, 0, 0.1);
        border-radius: 0rem;
    }


    /* Full-page overlay */
    #loader-overlay {
        position: fixed;
        /* Covers the entire viewport */
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        /* Semi-transparent background */
        display: flex;
        /* Flexbox to center the spinner */
        align-items: center;
        /* Center vertically */
        justify-content: center;
        /* Center horizontally */
        z-index: 9999;
        /* Ensure it appears on top */
    }

    .spinner {
        width: 30px;
        aspect-ratio: 1;
        --_c: no-repeat radial-gradient(farthest-side, rgb(226, 45, 130) 92%, #0000);
        background:
            var(--_c) top,
            var(--_c) left,
            var(--_c) right,
            var(--_c) bottom;
        background-size: 8px 8px;
        animation: l7 1s infinite;
    }

    #suggestions {
        position: absolute;
        /* Ensures the dropdown is positioned relative to the input */
        z-index: 1000;
        /* Places the dropdown above other elements */
        background-color: #fff;
        border: 1px solid #ddd;
        max-height: 200px;
        /* Adjust max height as needed */
        overflow-y: auto;
        width: 96%;
        /* Matches the width of the parent container */
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        /* Optional: Adds a shadow for better visibility */
        display: none;
        /* Initially hidden */
    }


    /* Spinner animation */
    @keyframes l7 {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }
</style>

@endpush

@section('content')
<div class="bg-white">
    <div class="container-fluid">
        <x-alert column="col-md-12" alert_type="alert-warning" />
        <div class="row">
            <div class="col-sm-8">
                <div class="card border-0">
                    <div class="card-body">
                        <!-- food item filtering options -->
                        <!-- <form action="{{route('pos')}}" method="get" id="filterForm"> -->
                        <div class="row d-flex">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <select class="form-control select2 w-100" name="branch" id="branchSelect">
                                        <option value="">{{translate('All Branches')}}</option>
                                        @foreach($all_branches as $branch)
                                        <option value="{{$branch->id}}" {{ request()->get('branch') == $branch->id ? 'selected' : '' }}>{{$branch->branch_name}}</option>
                                        @endforeach
                                    </select>
                                    <input type="hidden" name="category" value="" id="categorySelect">
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="search" name="search" placeholder="{{translate('Search')}}" value="{{ request()->get('search') }}">
                                    <div id="suggestions"></div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <button class="btn btn-pink rounded-pill btn-sm px-3" id="filter-btn">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#FFFFFF">
                                        <path d="M784-120 532-372q-30 24-69 38t-83 14q-109 0-184.5-75.5T120-580q0-109 75.5-184.5T380-840q109 0 184.5 75.5T640-580q0 44-14 83t-38 69l252 252-56 56ZM380-400q75 0 127.5-52.5T560-580q0-75-52.5-127.5T380-760q-75 0-127.5 52.5T200-580q0 75 52.5 127.5T380-400Z" />
                                    </svg>
                                </button>
                                <a href="{{route('pos')}}" class="btn btn-pink rounded-pill btn-sm px-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#FFFFFF">
                                        <path d="m336-280 144-144 144 144 56-56-144-144 144-144-56-56-144 144-144-144-56 56 144 144-144 144 56 56ZM480-80q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-320Z" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                        <!-- </form> -->
                        <!-- /food item filtering options -->
                        <hr>

                        <!-- Categories Section -->
                        <div class="row">
                            <div class="col-md-12 d-flex justify-content-center">
                                <button class="btn {{ empty(request()->get('category')) ? 'btn-pink' : 'btn-outline-pink'}} btn-sm rounded-pill mr-2 mb-2 selectedCategory px-3" data-id="">{{translate('All Categories')}}</button>
                                @foreach($categories as $category)
                                <button class="btn {{ request()->get('category') == $category->id ? 'btn-pink' : 'btn-outline-pink'}} btn-sm rounded-pill mr-2 mb-2 selectedCategory px-3" data-id="{{$category->id}}">{{$category->name}}</button>
                                @endforeach
                            </div>
                        </div>
                        <!-- /Categories Section -->

                        <div id="data-container">
                            @include('pos::admin.pos.partial.food_items', ['food_items' => $food_items])
                        </div>

                        <div id="pagination-links">
                            {{ $food_items->links('pagination::bootstrap-5') }}
                        </div>
                        <!-- /Food Items Section -->
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <!-- Order Summary Section -->
                <div class="card border-left">
                    <div class="card-body p-0" id="order-summary">

                    </div>
                </div>
                <!-- /Order Summary Section -->
            </div>
        </div>
    </div>

    <!-- Variant Modal -->
    <div class="modal fade" id="item-variant">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{translate('Select Variant')}}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="variant-list">

                </div>
            </div>
        </div>
    </div>
    <!-- /Variant Modal -->

    <!-- Properties Modal -->
    <div class="modal fade" id="item-properties">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{translate('Select Property')}}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="property-list">

                    </div>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /Properties Modal -->

    <!-- Add Discount -->
    <div class="modal fade" id="order-discount">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-body">
                    <label for="discount_type">{{translate('Discount Type')}}</label>
                    <select name="discount_type" id="discount_type" class="form-control">
                        <option value="percent">{{translate('Percent (%)')}}</option>
                        <option value="amount">{{translate('Fixed Amount')}}</option>
                    </select>

                    <label for="discount">{{translate('Discount Amount')}}</label>
                    <input type="number" class="form-control" name="discount" id="discount">
                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">{{translate('Close')}}</button>
                    <button type="button" class="btn btn-primary btn-sm" id="apply-discount" data-dismiss="modal">{{translate('Apply Discount')}}</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /Add Discount -->

    <!-- Select Tax -->
    <div class="modal fade" id="order-Tax">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-body">
                    <label for="tax_percentage">{{translate('Select Applicable Taxes')}}</label>
                    <select name="tax_percentage" id="tax_percentage" class="form-control select2" multiple>
                        @foreach($taxes as $tax)
                        <option value="{{$tax->tax_name .'~'. $tax->id . '~'. $tax->tax_rate}}">{{$tax->tax_name}} ({{$tax->tax_rate}}%)</option>
                        @endforeach
                    </select>
                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">{{translate('Close')}}</button>
                    <button type="button" class="btn btn-primary btn-sm" id="apply-tax" data-dismiss="modal">{{translate('Apply Tax')}}</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /Select Tax -->

    <!-- Select Customer -->
    <div class="modal fade" id="order-customer">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{translate('Select / Add Customer')}}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <label for="order_customer">{{translate('Select Customer')}}</label>
                    <select name="order_customer" id="order_customer" class="form-control select2">
                        <option value="walk_in" data-name="Walk-in">{{translate('Walk-in')}}</option>

                        @foreach($customers as $customer)
                        <option value="{{$customer->id}}" data-name="{{$customer->name}}">{{$customer->name}} {{ $customer->mobile ? '('. $customer->mobile .')' : ''}}</option>
                        @endforeach
                        <option value="add_customer" data-name="Add Customer">{{translate('Add Customer')}}</option>
                    </select>

                    <div id="new-customer-form">
                        <hr>

                        <label for="order_customer_name">{{translate('Customer Name')}}</label>
                        <input type="text" class="form-control" name="customer_name" id="order_customer_name" placeholder="Enter customer name">

                        <label for="order_customer_mobile">{{translate('Customer Mobile')}}</label>
                        <input type="text" class="form-control" name="customer_mobile" id="order_customer_mobile" placeholder="Enter customer mobile">

                        <label for="order_customer_email">{{translate('Customer Email')}}</label>
                        <input type="text" class="form-control" name="customer_email" id="order_customer_email" placeholder="Enter customer email">

                        <label for="order_customer_address">{{translate('Customer Address')}}</label>
                        <input type="text" class="form-control" name="customer_address" id="order_customer_address" placeholder="Enter customer address">
                    </div>

                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">{{translate('Close')}}</button>
                    <button type="button" class="btn btn-primary btn-sm" id="select-customer" data-dismiss="modal">{{translate('Select Customer')}}</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /Select Customer -->

    <!-- Select Tables -->
    <div class="modal fade" id="order-table">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{translate('Select Table')}}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @foreach($hall_and_tables as $hall)
                    <!-- @if($hall['tables']->count() > 0) -->
                    <div id="accordion">
                        <div class="card">
                            <div class="card-header p-0" id="heading-{{$hall['id']}}">
                                <h5 class="mb-0">
                                    <button class="btn btn-link text-left btn-block" data-toggle="collapse" data-target="#collapse-{{$hall['id']}}" aria-expanded="true" aria-controls="collapse-{{$hall['id']}}">
                                        <h5>
                                            {{ $hall['name'] }} <i class="icon-toggle fa fa-chevron-down float-right"></i>
                                        </h5>
                                    </button>
                                </h5>
                            </div>

                            <div id="collapse-{{$hall['id']}}" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                                <div class="card-body">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>{{ translate('Select') }}</th>
                                                <th>{{ translate('Table No.') }}</th>
                                                <th>{{ translate('Table Type') }}</th>
                                                <th>{{ translate('Table Shape') }}</th>
                                                <th>{{ translate('Capacity') }}</th>
                                                <th>{{ translate('Status') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($hall['tables'] as $table)
                                            @php
                                            $table_types = getAllTableTypes();
                                            $table_status = getAllTableStatus();
                                            $table_shapes = getAllTableShapes();
                                            @endphp
                                            <tr>
                                                <td>
                                                    <input type="checkbox" name="tables" class="selected-tables" id="table-{{ $table->id }}" value="{{ json_encode($table) }}" data-hall="{{json_encode($hall)}}" />
                                                </td>
                                                <td>{{ $table->table_number }}</td>
                                                <td>{{ $table_types[$table->type] }}</td>
                                                <td>{{ $table_shapes[$table->shape] }}</td>
                                                <td>{{ $table->chair_limit }}</td>
                                                <td>{{ $table_status[$table->status] }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- @endif -->
                    @endforeach
                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">{{translate('Close')}}</button>
                    <button type="button" class="btn btn-primary btn-sm" id="select-table" data-dismiss="modal">{{translate('Select Table')}}</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /Select Tables -->
</div>

<div id="loader-overlay" style="display: none;">
    <div class="spinner"></div>
</div>

@endsection

@push('script')
<script src="{{asset('pos/plugins/select2/js/select2.full.min.js')}}"></script>
<script>
    $(function() {
        'use strict'

        let ordered_items = JSON.parse(localStorage.getItem("ordered_items")) ?? [];
        let tax_details = JSON.parse(localStorage.getItem('tax_details')) ?? [];
        let order_discount = JSON.parse(localStorage.getItem('order_discount')) ?? [];
        let customer_details = JSON.parse(localStorage.getItem('customer_details')) ?? [];
        let checked_tables = JSON.parse(localStorage.getItem('checked_tables')) ?? [];

        let category_id_to_filter = '';

        $(document).ready(function() {
            addToCart();
            makeTaxPercentageSelected();
            makeDiscountSelected();
            makeTablesSelected();
        })

        $('body').addClass('sidebar-collapse');

        $('#new-customer-form').hide();

        $('#tax_percentage').select2({
            theme: 'bootstrap4',
            width: '100%'
        })

        $('#order_customer').select2({
            theme: 'bootstrap4',
            width: '100%'
        })

        $('#branchSelect').select2({
            theme: 'bootstrap4',
            width: '100%'
        })

        /**
         * Pagination
         */
        $(document).on('click', '.page-link', function(e) {
            e.preventDefault();
            console.log('Pagination link clicked'); // Debugging log
            let url = $(this).attr('href');
            fetchPage(url);
        });

        /**
         * Select Customer
         */
        $('#order_customer').change(function() {
            let selected_customer = $('#order_customer').val();
            if (selected_customer == 'add_customer') {
                $('#new-customer-form').show();
            } else {
                $('#new-customer-form').hide();
            }
        });

        /**
         * Apply Tax
         */
        $('#apply-tax').click(function() {
            let taxes = $('#tax_percentage').val();
            tax_details = [];
            taxes.forEach(tax => {
                let tax_name = tax.split('~')[0];
                let tax_id = tax.split('~')[1];
                let tax_rate = tax.split('~')[2];
                tax_details.push({
                    tax_name: tax_name,
                    tax_id: tax_id,
                    tax_rate: tax_rate
                });
            });

            localStorage.setItem('tax_details', JSON.stringify(tax_details));
            addToCart();
        });

        /**
         * Apply Discount
         */
        $('#apply-discount').click(function() {
            let discount_type = $('#discount_type').val();
            let discount_amount = $('#discount').val();
            order_discount = {
                discount_type: discount_type,
                discount_amount: discount_amount
            };
            localStorage.setItem('order_discount', JSON.stringify(order_discount));
            addToCart();
        });

        /**
         * Select Customer
         */
        $('#select-customer').click(function() {
            let selected_customer = $('#order_customer').val();
            if (selected_customer == 'add_customer') {
                let customer_name = $('#order_customer_name').val();
                let customer_mobile = $('#order_customer_mobile').val();
                let customer_email = $('#order_customer_email').val();
                let customer_address = $('#order_customer_address').val();

                if (customer_name != '' && customer_mobile != '') {
                    $('#selected-customer').text(customer_name);

                    let customer_details = {
                        customer_id: '-1',
                        customer_name: customer_name,
                        customer_mobile: customer_mobile,
                        customer_email: customer_email,
                        customer_address: customer_address
                    };

                    localStorage.setItem('customer_details', JSON.stringify(customer_details));
                } else {
                    toastr.error("{{translate('Name and mobile are required for new customer')}}", 'error');
                }
            } else {
                let selected_customer_name = $('#order_customer option:selected').data('name');
                $('#selected-customer').text(selected_customer_name);

                let customer_details = {
                    customer_id: selected_customer,
                    customer_name: selected_customer_name
                };
                localStorage.setItem('customer_details', JSON.stringify(customer_details));
            }
        });

        /**
         * Select category
         */
        $('.selectedCategory').click(function() {
            $('.selectedCategory').removeClass('btn-pink');
            $('.selectedCategory').addClass('btn-outline-pink');
            $(this).addClass('btn-pink');

            category_id_to_filter = $(this).data('id')
            let url = '{{ route("pos") }}';
            fetchPage(url);
        });

        /**
         * Filter
         */
        $('#filter-btn').click(function() {
            let url = '{{ route("pos") }}';
            fetchPage(url);
        });

        /**
         * Filter after branch selection
         */
        $('#branchSelect').change(function() {
            let url = '{{ route("pos") }}';
            fetchPage(url);
        })

        /**
         * Filter based on search input
         */
        $('#search').on('input', function() {
            let query = $(this).val();
            if (query.length > 2) {
                $.ajax({
                    url: '{{ route("pos.item.search") }}',
                    method: 'GET',
                    data: {
                        query: query
                    },
                    success: function(data) {
                        console.log(data);
                        let suggestions = '';
                        data.forEach(item => {
                            suggestions += `<div class="my-2 border-bottom suggested-item" data-name="${item.name}">
                                <a href="#" class="dropdown-item">
                                <img src="/${item.image}" width="30" height="30">
                                ${item.name}
                            </a>
                            </div>`;
                        });
                        $('#suggestions').html(suggestions).show();
                    },
                    error: function() {
                        $('#suggestions').hide();
                    }
                });
            } else {
                $('#suggestions').hide();
            }
        });

        /**
         * Filter based on suggested item
         */
        $(document).on('click', '.suggested-item', function(e) {
            let product_name = $(this).data('name');
            $('#search').val(product_name);
            $('#suggestions').hide();

            let url = '{{ route("pos") }}';
            fetchPage(url);
        })

        // Hide suggestions when clicking outside
        $(document).on('click', function(e) {
            if (!$(e.target).closest('#search, #suggestions').length) {
                $('#suggestions').hide();
            }
        });

        /**
         * Decrement
         */
        $(document).on('click', '.quantity-selector .btn-decrement', function() {
            var $input = $(this).parent().find('.quantity-input');
            var currentVal = parseInt($input.val());
            if (!isNaN(currentVal) && currentVal > 1) {
                $input.val(currentVal - 1);
            } else {
                $input.val(1);
            }
        });

        /**
         * Increment
         */
        $(document).on('click', '.quantity-selector .btn-increment', function() {
            var $input = $(this).parent().find('.quantity-input');
            var currentVal = parseInt($input.val());
            if (!isNaN(currentVal) && currentVal > 0) {
                $input.val(currentVal + 1);
            } else {
                $input.val(1);
            }
        });

        /**
         * Add to cart
         */
        $(document).on('click', '.single-food-item .add-to-cart',function() {
            const id = $(this).data('id');
            const name = $(this).data('name');
            const price = $(this).data('price');

            // Try selecting and logging the single-food-item container
            const foodItemContainer = $(this).closest('.single-food-item');

            // Now try selecting and logging the quantity input
            const quantityInput = foodItemContainer.find('.quantity-input');

            // Get the value of the quantity input
            let quantity = quantityInput.val();
            if (quantity == '' || quantity < 1) {
                quantity = 1;
            }

            quantityInput.val(1);

            if (quantity !== undefined) {
                ordered_items.push({
                    id: id,
                    name: name,
                    unit_price: price,
                    quantity: quantity,
                    price: (quantity * price)
                });

                localStorage.setItem("ordered_items", JSON.stringify(ordered_items));

                addToCart();
            } else {
                console.error("Quantity not found.");
            }
        });

        /**
         * Increment ordered item
         */
        $(document).on('click', '.ordered-item-amount-increment', function() {
            let index = $(this).data('index');
            ordered_items[index].quantity++;
            ordered_items[index].price = calculateSingleItemTotalPrice(index);
            localStorage.setItem("ordered_items", JSON.stringify(ordered_items));
            addToCart();
        });

        /**
         * Decrement ordered item
         */
        $(document).on('click', '.ordered-item-amount-decrement', function() {
            let index = $(this).data('index');
            if (ordered_items[index].quantity > 1) {
                ordered_items[index].quantity--;
                ordered_items[index].price = calculateSingleItemTotalPrice(index);
                localStorage.setItem("ordered_items", JSON.stringify(ordered_items));
                addToCart();
            }
        });

        /**
         * Remove ordered item
         */
        $(document).on('click', '.ordered-item-remove', function() {
            let index = $(this).data('index');
            ordered_items.splice(index, 1);
            localStorage.setItem("ordered_items", JSON.stringify(ordered_items));
            addToCart();
        });

        /**
         * Show variant
         */
        $(document).on('click', '.show-variant', function() {
            let id = $(this).data('id');
            let name = $(this).data('name');

            const foodItemContainer = $(this).closest('.single-food-item');
            const quantityInput = foodItemContainer.find('.quantity-input');
            const quantity = quantityInput.val();

            quantityInput.val(1);

            $('#loader-overlay').fadeIn();

            $.ajax({
                url: "{{ route('single.item.variants') }}",
                method: 'POST',
                data: {
                    item_id: id,
                    item_name: name,
                    item_quantity: quantity,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    $('#variant-list').html(response);
                    $('#loader-overlay').fadeOut();
                },
                error: function(xhr, status, error) {
                    $('#loader-overlay').fadeOut();
                    console.error(error);
                }
            });
        });

        /**
         * Change variant
         */
        $(document).on('click', '.change-variant', function() {
            let index = $(this).data('index');
            let id = ordered_items[index].id;
            let variant = ordered_items[index].variant;
            $('#loader-overlay').fadeIn();
            $.ajax({
                url: "{{ route('single.item.variants') }}",
                method: 'POST',
                data: {
                    index: index,
                    item_id: id,
                    variant: variant,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    $('#variant-list').html(response);
                    $('#loader-overlay').fadeOut();
                },
                error: function(xhr, status, error) {
                    console.error(error);
                    $('#loader-overlay').fadeOut();
                }
            });
        });

        /**
         * Use variant
         */
        $(document).on('click', '.use-variant', function() {
            let id = $('#variant-list').find('#food_item_id').val();
            let name = $('#variant-list').find('#food_item_name').val();
            let quantity = $('#variant-list').find('#food_item_quantity').val();
            let selected_variant = $('#variant-list input[name="variant"]:checked').val();

            selected_variant = JSON.parse(selected_variant);

            let price = selected_variant.price;

            ordered_items.push({
                id: id,
                name: name,
                unit_price: price,
                quantity: quantity,
                price: (quantity * price),
                variant: selected_variant
            });
            localStorage.setItem("ordered_items", JSON.stringify(ordered_items));
            addToCart();
        });

        /**
         * Update variant
         */
        $(document).on('click', '.update-variant', function() {
            let index = $('#variant-list').find('#order_index').val();
            let selected_variant = $('#variant-list input[name="variant"]:checked').val();

            selected_variant = JSON.parse(selected_variant);

            let price = selected_variant.price;

            ordered_items[index].unit_price = price;
            ordered_items[index].price = calculateSingleItemTotalPrice(index);
            ordered_items[index].variant = selected_variant;

            localStorage.setItem("ordered_items", JSON.stringify(ordered_items));
            addToCart();
        });

        /**
         * Change properties
         */
        $(document).on('click', '.change-properties', function() {
            let index = $(this).data('index');
            let id = ordered_items[index].id;
            let properties = ordered_items[index].properties;
            $('#loader-overlay').fadeIn();
            $.ajax({
                url: "{{ route('get.single.item.properties') }}",
                method: 'POST',
                data: {
                    index: index,
                    item_id: id,
                    properties: properties,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    $('#property-list').html(response);
                    $('#loader-overlay').fadeOut();
                },
                error: function(xhr, status, error) {
                    console.error(error);
                    $('#loader-overlay').fadeOut();
                }
            });
        });

        /**
         * Update Property
         */
        $(document).on('click', '.update-property', function() {
            let index = $('#property-list').find('#order_index').val();
            let selected_property = [];

            $(".food-property-items:checked").each(function() {
                // Get the parent row
                let parentRow = $(this).closest("tr");

                // Get the checkbox value (parsed JSON)
                let itemValue = JSON.parse($(this).val());

                // Get the quantity input value
                let quantity = parentRow.find(".food-property-quantity").val();

                if (quantity == '' || quantity < 1) {
                    quantity = 1;
                }

                // Add quantity directly to the item object
                itemValue.quantity = parseInt(quantity); // Convert quantity to an integer

                // Push the modified item object into the array
                selected_property.push(itemValue);
            });

            ordered_items[index].properties = selected_property;
            ordered_items[index].price = calculateSingleItemTotalPrice(index);

            localStorage.setItem("ordered_items", JSON.stringify(ordered_items));
            addToCart();
        });

        /**
         * Select tables
         */
        $('#select-table').click(function() {
            let html = '';
            checked_tables = [];

            $('.selected-tables:checked').each(function() {
                let table_data = JSON.parse($(this).val());
                let hall_data = $(this).data('hall');

                let hall_id = table_data.hall_id;
                let hall_name = hall_data.name;
                let table_id = table_data.id;
                let table_number = table_data.table_number;

                checked_tables.push({
                    hall_id: hall_id,
                    hall_name: hall_name,
                    table_id: table_id,
                    table_number: table_number
                });

                html = html + `<span class="badge badge-primary">H${hall_name}/T${table_number}</span>`
            });

            localStorage.setItem("checked_tables", JSON.stringify(checked_tables));
            $('#all-selected-table').html(html);
        })

        /**
         * Add ordered items to cart
         *
         * @return void
         */
        function addToCart() {
            let discount = $('#discount').val();
            let discount_type = $('#discount_type').val();
            $('#loader-overlay').fadeIn();
            $.ajax({
                url: "{{ route('pos.add.to.cart') }}",
                method: 'POST',
                data: {
                    ordered_items: ordered_items,
                    order_discount: order_discount,
                    discount: discount,
                    taxes: tax_details,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    $('#order-summary').html(response);
                    makeCustomerSelected();
                    $('#loader-overlay').fadeOut();
                },
                error: function(xhr, status, error) {
                    console.error(error);
                    $('#loader-overlay').fadeOut();
                }
            });
        }

        /**
         * Calculate total price
         */
        function calculateSingleItemTotalPrice($index) {
            let quantity = ordered_items[$index].quantity;
            let price = ordered_items[$index].unit_price;
            let totalPrice = quantity * price;
            let properties = ordered_items[$index].properties;

            if (properties !== undefined && properties !== null) {
                properties.forEach(property => {
                    totalPrice += property.quantity * property.price;
                });
            }

            return totalPrice;
        }

        /**
         * Calculate total price
         */
        function calculateTotalPrice() {
            let totalPrice = 0;
            ordered_items.forEach(item => {
                totalPrice += item.price;
            });
            return totalPrice;
        }

        /**
         * Make tax percentage selected
         *
         * @return void
         */
        function makeTaxPercentageSelected() {
            // Prepare the array of option values to select
            const valuesToSelect = tax_details.map(tax => {
                return `${tax.tax_name}~${tax.tax_id}~${tax.tax_rate}`;
            });

            // Select options in the select2 dropdown
            $('#tax_percentage').val(valuesToSelect).trigger('change');
        }

        /**
         * Make discount selected
         *
         * @return void
         */
        function makeDiscountSelected() {
            let discount_amount = order_discount.discount_amount;
            let discount_type = order_discount.discount_type;

            // Select options in the select2 dropdown
            $('#discount_type').val(discount_type);
            $('#discount').val(discount_amount);
        }

        /**
         * Make customer selected
         */
        function makeCustomerSelected() {

            let customer_id = customer_details.customer_id;
            if (customer_id == '-1') {
                $('#order_customer_name').val(customer_details.customer_name);
                $('#order_customer_mobile').val(customer_details.customer_mobile);
                $('#order_customer_email').val(customer_details.customer_email);
                $('#order_customer_address').val(customer_details.customer_address);
                $('#order_customer').val('add_customer').trigger('change');
            } else {
                $('#order_customer').val(customer_id).trigger('change');
            }
            $('#selected-customer').text(customer_details.customer_name);
        }

        /**
         * Make tables selected
         */
        function makeTablesSelected() {
            let tables = checked_tables;
            let html = '';

            tables.forEach(table => {
                html += `<span class="badge badge-primary">H${table.hall_name}/T${table.table_number}</span>`;
                $(`#table-${table.table_id}`).prop('checked', true);
            });

            // Wait for #all-selected-table to appear
            let interval = setInterval(() => {
                let selectedTableContainer = $('#all-selected-table');
                if (selectedTableContainer.length) {
                    clearInterval(interval);
                    if (html != '') {
                        selectedTableContainer.html(html);
                    }
                }
            }, 100);
        }

        /**
         * Fetch page
         */
        function fetchPage(url) {
            $('#loader-overlay').fadeIn();

            let search = $('#search').val();
            let category = category_id_to_filter;
            let branch = $('#branchSelect').val();

            $.ajax({
                url: url,
                type: 'GET',
                data: {
                    search: search,
                    category: category,
                    branch: branch,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    $('#data-container').html(response.data);
                    $('#pagination-links').html(response.pagination);

                    $('#loader-overlay').fadeOut();
                },
                error: function(xhr) {
                    console.error('An error occurred:', xhr);
                }
            });
        }
    });
</script>
@endpush