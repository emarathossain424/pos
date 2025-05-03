@php
$all_categories = getFoodCategories();
$placeholder = getPlaceholderImagePath();
$properties = getFoodProperties();

$all_branches = getBranches();
@endphp
@extends('layouts.master')
@section('title') {{translate('Add Food Item')}} @endsection
@push('css')
<link rel="stylesheet" href="{{asset('pos/plugins/select2/css/select2.min.css')}}">
<link rel="stylesheet" href="{{asset('pos/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
<style>
    select {
        width: 100% !important;
    }
</style>
@endpush
@section('breadcrumb')
<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"><a href="{{route('food.items')}}">{{translate('Food items')}}</a></li>
    <li class="breadcrumb-item active">{{translate('Add Food Item')}}</li>
</ol>
@endsection
@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h5 class="m-0">{{ translate('Add Food Item') }}</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="branch">{{translate('Select Branch')}}  ( <a href="{{route('manage.branch')}}">{{translate("Create branch if you haven't already")}}</a> )</label>
                            <select class="form-control select2 w-100" name="branch" id="branch" multiple>
                                @foreach($all_branches as $branch)
                                    <option value="{{$branch->id}}">{{$branch->branch_name}}</option>
                                @endforeach
                            </select>
                            <div>
                                <span class="text-danger" id="branch_error"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="food-name">{{translate('Food Name')}} <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="food-name" name="food_name" placeholder="Enter food name">
                            <div>
                                <span class="text-danger" id="name_error"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="category">{{translate('Category')}} <span class="text-danger">*</span></label>
                            <select class="form-control select2 w-100" name="category" id="category">
                                <option value="">{{translate('Select Category')}}</option>
                                @foreach($all_categories as $category)
                                <option value="{{$category->id}}">{{$category->name}}</option>
                                @endforeach
                            </select>
                            <div>
                                <span class="text-danger" id="category_error"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="food-details">{{translate('Food Details')}} <span class="text-danger">*</span></label>
                            <textarea class="form-control" rows="5" placeholder="Enter Food Details" name="food_details" id="food-details"></textarea>
                            <div>
                                <span class="text-danger" id="details_error"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="properties">{{translate('Select Properties')}}</label>
                            <select class="form-control select2 w-100" name="properties" id="properties" multiple>
                                <option value="">{{translate('Select Properties')}}</option>
                                @foreach($properties as $property)
                                <option value="{{$property->id}}">{{$property->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div id="property-items">

                        </div>

                        <div class="form-group">
                            <label for="meta-image">{{translate('Image')}} <span class="text-danger">*</span></label>
                            <input type="hidden" name="food_image" id="food-image-input">
                            <div class="row" id="food-image-view">
                                <div class="form-image-container col-2 m-2">
                                    <div class="image-wrapper">
                                        <img src="{{asset($placeholder)}}" class="img-fluid" alt="black sample">
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn text-blue browse-file" data-toggle="modal" data-target="#media-library" data-inputid="food-image-input" data-imagecontainerid="food-image-view" data-isformultiselect='0'>{{translate('Browse File')}}</button>
                            <div>
                                <span class="text-danger" id="image_error"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="food-type">{{translate('Food Type')}} <span class="text-danger">*</span></label>
                            <select class="form-control select2 w-100" name="food_type" id="food-type">
                                <option value="variant">{{translate('Variant Food')}}</option>
                                <option value="single" selected>{{translate('Single Food')}}</option>
                            </select>
                            <div>
                                <span class="text-danger" id="food_type_error"></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <h6><strong>{{translate('Status')}}</strong></h6>
                            <input type="checkbox" id="status" name="status" checked data-bootstrap-switch>
                            <div>
                                <span class="text-danger" id="status"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="price">{{translate('Price')}} ({{getCurrencySymbol(getGeneralSettingsValue( 'default_currency' ))}}) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="price" name="price" placeholder="Enter price">
                            <div>
                                <span class="text-danger" id="price_error"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="offer-price">{{translate('Offer Price')}} ({{getCurrencySymbol(getGeneralSettingsValue( 'default_currency' ))}}) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="offer-price" name="offer_price" placeholder="Enter offer price">
                            <div>
                                <span class="text-danger" id="offer_price_error"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="meta-title">{{translate('Meta Title')}}</label>
                            <input type="text" class="form-control" id="meta-title" placeholder="Enter meta title" name="meta_title">
                        </div>

                        <div class="form-group">
                            <label for="meta-description">{{translate('Meta Description')}}</label>
                            <textarea class="form-control" rows="3" placeholder="Enter Meta Description" name="meta-description" id="meta_description"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="meta-image">{{translate('Meta Image')}}</label>
                            <input type="hidden" name="meta_image" id="meta-image-input">
                            <div class="row" id="meta-image-view">
                                <div class="form-image-container col-2 m-2">
                                    <div class="image-wrapper">
                                        <img src="{{asset($placeholder)}}" class="img-fluid" alt="black sample">
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn text-blue browse-file" data-toggle="modal" data-target="#media-library" data-inputid="meta-image-input" data-imagecontainerid="meta-image-view" data-isformultiselect='0'>{{translate('Browse File')}}</button>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="variant-selections d-none">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="variant-id">{{translate('Select Variant')}} <span class="text-danger"></span></label>
                                <select class="form-control select2" name="variant_id[]" id="variant-id" multiple>
                                    @foreach ($variants as $variant)
                                    <option value="{{$variant->id}}">{{$variant->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row" id="options">

                    </div>
                    <div class="row">
                        <div class="col-md-12" id="variant-table-container">

                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-center">
                    <button class="btn bg-pink btn-block w-25 bold" id="store-button" type="button" onclick="storeFoodItems()">{{translate('Save')}}</button>
                </div>
            </div>
        </div>
        @includeIf('media.include.media_modal')
    </div>
</div>

@parent
@endsection

@push('script')
<script src="{{asset('pos/plugins/bootstrap-switch/js/bootstrap-switch.min.js')}}"></script>
<script src="{{asset('pos/plugins/select2/js/select2.full.min.js')}}"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.0/classic/ckeditor.js"></script>
<script>
    // Array to store the options of each variant combination
    let variant_option_array = [];
    // Array to store the options of each variant (sent from server)
    let variantData = JSON.parse('{!! json_encode($variants->toArray()) !!}');
    // Array to store the selected options
    let selected_variant_with_options = [];

    let food_details_instance = null
    let meta_description_instance = null

    $(function() {
        'use strict'
        //Implement bootstrap switch is status field
        $("input[data-bootstrap-switch]").each(function() {
            $(this).bootstrapSwitch('state', $(this).prop('checked'));
        })

        // Initialize Select2 for category
        $('#category').select2({
            theme: 'bootstrap4',
            width: '100%'
        })
        // Initialize Select2 for properties
        $('#properties').select2({
            theme: 'bootstrap4',
            width: '100%'
        })
        // Initialize Select2 for food type
        $('#food-type').select2({
            theme: 'bootstrap4',
            width: '100%'
        })
        // Initialize Select2 for variant list
        $('#variant-id').select2({
            theme: 'bootstrap4',
            width: '100%'
        })
        // Initialize Select2 for variant list
        $('#branch').select2({
            theme: 'bootstrap4',
            width: '100%'
        })

        //Showing variant selection option based on food type
        $('#food-type').change(() => {
            const food_type = $('#food-type').val()
            if (food_type == 'variant') {
                $('.variant-selections').removeClass('d-none')
            } else {
                $('.variant-selections').addClass('d-none')
            }
        })

        $('#variant-id').change(() => {
            const variant_id = $('#variant-id').val()
            if (variant_id.length > 0) {
                // Find and store the variant ids that do not exist in variant_id
                let removedVariantIds = selected_variant_with_options
                    .filter(v => !variant_id.includes(v.variant.id))
                    .map(v => v.variant.id);

                // Remove the corresponding elements from the DOM
                removedVariantIds.forEach(id => {
                    $(`#variant-div-${id}`).remove();
                });

                // Keeping only the variants that exist in variant_id
                selected_variant_with_options = selected_variant_with_options.filter(v => variant_id.includes(v.variant.id));


                variant_id.forEach(id => {
                    let index = selected_variant_with_options.findIndex(v => v.variant.id == id)
                    if (index == -1) {
                        selected_variant_with_options.push({
                            variant: {
                                name: variantData.find(v => v.id == id).name,
                                id: id
                            },
                            options: []
                        })
                        createSelectBox(id)
                    }
                })
            }

            generateCombinations(selected_variant_with_options);
            generateTableFromVariantCombinations()
        })

        $('#properties').change(() => {
            const properties = $('#properties').val()
            let data = {
                'properties': properties,
                '_token': '{{ csrf_token() }}'
            }

            $.ajax({
                url: '{{ route("get.property.items") }}', // Your endpoint URL
                type: 'GET',
                data: data,
                success: function(response) {
                    console.log(response)
                    $('#property-items').html(response)

                    $('select.property_items').select2({
                        theme: 'bootstrap4',
                    })
                },
                error: function(xhr) {
                    console.log('Unable to get property items');
                }
            });
        })

        ClassicEditor
            .create(document.querySelector('#food-details'))
            .then(editor => {
                food_details_instance = editor;
            })
            .catch(error => {
                console.error(error);
            });

        ClassicEditor
            .create(document.querySelector('#meta_description'))
            .then(editor => {
                meta_description_instance = editor;
            })
            .catch(error => {
                console.error(error);
            });
    });

    // Create select box for each variant
    function createSelectBox(variantId) {
        // Find the variant object with the given ID
        const variant = variantData.find(variant => variant.id == variantId);

        // Start building the raw HTML string for the form-group, label, and select element
        let selectHTML = `<div class="col-md-12" id="variant-div-${variant.id}"><div class="form-group">
        <label for="variant-${variant.id}">${variant.name} <span class="text-danger"></span></label>
        <select class="form-control select2 variant-options" name="variant_id[]"  id="variant-${variant.id}" multiple>`;

        // Loop through the options of the variant and create option elements
        variant.options.forEach(option => {
            selectHTML += `<option data-name="${option.option_name}" value="${option.id}">${option.option_name}</option>`;
        });

        // Close the select and div elements
        selectHTML += `</select></div></div>`;

        // Append the constructed HTML to the desired parent element
        $('#options').append(selectHTML);

        $(`#variant-${variant.id}`).select2({
            theme: 'bootstrap4',
            width: '100%'
        });

        // Add onchange event listener to the select box
        $(`#variant-${variant.id}`).on('change', function() {
            // Retrieve selected option elements
            const selectedOptions = $(this).find('option:selected');

            // Construct the options array
            const options = selectedOptions.map(function() {
                return {
                    id: $(this).val(),
                    name: $(this).data('name')
                };
            }).get(); // Use .get() to convert jQuery object to a plain array

            // Find the existing variant in the array
            const variantIndex = selected_variant_with_options.findIndex(v => v.variant.id == variant.id);

            if (variantIndex > -1) {
                // Update the existing variant's options
                selected_variant_with_options[variantIndex].options = options;
            } else {
                // Add new variant with options
                selected_variant_with_options.push({
                    variant: {
                        name: variant.name,
                        id: variant.id
                    },
                    options: options
                });
            }

            console.log(selected_variant_with_options)
            generateCombinations(selected_variant_with_options);
            generateTableFromVariantCombinations()
        });
    }

    /**
     * Generate variant combinations
     */
    function generateCombinations(variants) {
        const combinations = [];

        const generateComboKey = (combo) => {
            return combo.map(item => `${item.variant.id}:${item.options.id}`).join('|');
        };
        const existingCombos = new Set(variant_option_array.map(combo => generateComboKey(combo.combo)));

        const getCombinations = (options, index = 0, currentCombo = []) => {
            if (index === options.length) {
                let newCombo = {
                    combo: currentCombo.map((item) => ({
                        variant: item.variant,
                        options: item.option
                    })),
                    price: 0,
                    special_price: 0,
                    availability: 0
                };

                const comboKey = generateComboKey(newCombo.combo);

                combinations.push(newCombo);
                existingCombos.add(comboKey);

                return combinations;
            }

            for (const option of options[index].options) {
                getCombinations(options, index + 1, [...currentCombo, {
                    variant: options[index].variant,
                    option
                }]);
            }
        };

        getCombinations(variants);

        const comboKeysInArray2 = new Set(combinations.map(item => generateComboKey(item.combo)));
        variant_option_array = variant_option_array.filter(item => comboKeysInArray2.has(generateComboKey(item.combo)));

        const existingComboKeys = new Set(variant_option_array.map(item => generateComboKey(item.combo)));
        const newCombinations = combinations.filter(item => !existingComboKeys.has(generateComboKey(item.combo)));
        variant_option_array = [...variant_option_array, ...newCombinations];

    }

    /**
     * Generate table from variant combinations
     */
    function generateTableFromVariantCombinations() {
        'use strict';
        let data = variant_option_array;

        // Extract unique variant names
        const variantNames = new Set();
        data.forEach(item => {
            item.combo.forEach(variantCombo => {
                variantNames.add(variantCombo.variant.name);
            });
        });

        // Start building the table HTML
        let tableHTML = '<table border="1" class="table table-bordered" id="variantTable"><thead><tr>';

        // Add headers for each unique variant
        variantNames.forEach(name => {
            tableHTML += `<th>${name}</th>`;
        });

        // Add headers for price and availability
        tableHTML += '<th>{{translate("Price")}} ({{getCurrencySymbol(getGeneralSettingsValue( "default_currency" ))}})</th><th>{{translate("Special Price")}} ({{getCurrencySymbol(getGeneralSettingsValue( "default_currency" ))}})</th><th>{{translate("Is Available")}}</th></tr></thead><tbody>';

        // Add rows for each data item
        data.forEach((item, index) => {
            tableHTML += '<tr>';

            // Add cells for each variant option
            variantNames.forEach(name => {
                const variantCombo = item.combo.find(v => v.variant.name === name);
                tableHTML += `<td>${variantCombo ? variantCombo.options.name : ''}</td>`;
            });

            // Add cells for price and availability
            tableHTML += `<td><input type="number" class="form-control" id="price-${index}" value="${item.price}" onchange="setPrice(${index})"></td>`;
            tableHTML += `<td><input type="number" class="form-control" id="special-price-${index}" value="${item.special_price}" onchange="setSpecialPrice(${index})"></td>`;
            tableHTML += `<td><input type="checkbox" class="form-control" id="availability-${index}" ${item.availability==1 ? 'checked' : ''} onchange="setAvailability(${index})"></td>`;
            tableHTML += '</tr>';
        });

        tableHTML += '</tbody></table>';
        $('#variant-table-container').html(tableHTML);
    }


    /**
     * will set price for each variant combination
     */
    function setPrice(index) {
        'use strict';
        let price = $('#price-' + index).val()
        variant_option_array[index].price = price
    }

    /**
     * will set special price for each variant combination
     */
    function setSpecialPrice(index) {
        'use strict';
        let special_price = $('#special-price-' + index).val()
        variant_option_array[index].special_price = special_price
    }

    /**
     * will set availability for each variant combination
     */
    function setAvailability(index) {
        'use strict';
        let availability = variant_option_array[index].availability
        if (availability == 1) {
            variant_option_array[index].availability = 0
        } else {
            variant_option_array[index].availability = 1
        }
    }

    /**
     * Sending food item data store request
     */
    function storeFoodItems() {
        'use strict';

        let selected_properties = [];

        $('.property_items').each(function() {
            // Get the selected options for this specific property
            let selectedValues = $(this).val();
            let propertyId = $(this).attr('name').match(/\d+/)[0]; // Extract property ID from the name attribute

            selected_properties[ 'property_' + propertyId + '' ] = selectedValues;
        });

        let data = {
            'name': $('#food-name').val(),
            'branch': $('#branch').val(),
            'details': food_details_instance.getData(),
            'category': $('#category').val(),
            'image': $('#food-image-input').val(),
            'status': $('#status').val(),
            'price': $('#price').val(),
            'offer_price': $('#offer-price').val(),
            'food_type': $('#food-type').val(),
            'meta_title': $('#meta-title').val(),
            'meta_description': meta_description_instance.getData(),
            'meta_image': $('#meta-image-input').val(),
            'variant_combo': variant_option_array,
            'properties': {...selected_properties},
            '_token': '{{ csrf_token() }}'
        }

        $.ajax({
            url: '{{ route("store.food.items") }}', // Your endpoint URL
            type: 'POST',
            data: data,
            success: function(response) {
                toastr.success("{{translate('Food item stored successfully')}}", 'success');
                setTimeout(function() {
                    window.location.href = "{{route('food.items')}}";
                }, 2000);
            },
            error: function(xhr) {
                // Check if the response has errors
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    toastr.error("{{translate('Please fill up mandatory fields')}}", 'error');

                    var errors = xhr.responseJSON.errors;

                    // Loop through the errors and display each one using Toastr
                    for (var field in errors) {
                        if (errors.hasOwnProperty(field)) {
                            $('#' + field + '_error').html('');
                            errors[field].forEach(function(message) {
                                $('#' + field + '_error').append(message);
                            });
                        }
                    }
                } else {
                    toastr.error("{{translate('There was an error')}}", 'error');
                }
            }
        });
    }
</script>
@endpush