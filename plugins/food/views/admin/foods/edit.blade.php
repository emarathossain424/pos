@php
$all_categories = getFoodCategories();
$placeholder = getPlaceholderImagePath();
$languages = getAllLanguages();
$default_lang = getGeneralSettingsValue('default_lang');
$translatedLang = isset(request()->lang)?request()->lang:$default_lang;

$all_branches = getBranches();
@endphp
@extends('layouts.master')
@section('title') {{translate('Update Food Item')}} @endsection
@push('css')
<link rel="stylesheet" href="{{asset('pos/plugins/select2/css/select2.min.css')}}">
<link rel="stylesheet" href="{{asset('pos/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
<style>
    select {
        width: 100% !important;
    }

    .disabled-div {
        opacity: 0.5;
        pointer-events: none;
    }
</style>
@endpush
@section('breadcrumb')
<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"><a href="{{route('food.items')}}">{{translate('Food items')}}</a></li>
    <li class="breadcrumb-item active">{{translate('Update Food Item')}}</li>
</ol>
@endsection
@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h5 class="m-0">{{ translate('Update Food Item') }}</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="translateInto">{{translate('Translate Into')}}</label>
                            <select class="form-control select2 w-100" name="translate_into" id="translateInto">
                                @foreach($languages as $lang)
                                <option value="{{$lang->id}}" {{ $lang->id == $translatedLang ? 'selected' : '' }}>{{$lang->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="branch">{{translate('Select Branch')}}  ( <a href="{{route('manage.branch')}}">{{translate("Create branch if you haven't already")}}</a> )</label>
                            <select class="form-control select2 w-100" name="branch" id="branch" multiple>
                                <option value="">{{translate('Select Branch')}}</option>
                                @foreach($all_branches as $branch)
                                    <option value="{{$branch->id}}" {{in_array($branch->id, $food_item_branches)? 'selected':'' }}>{{$branch->branch_name}}</option>
                                @endforeach
                            </select>
                            <div>
                                <span class="text-danger" id="branch_error"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="food-name">{{translate('Food Name')}} <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="food-name" name="food_name" placeholder="Enter food name" value="{{$food_item['name']}}">
                            <div>
                                <span class="text-danger" id="name_error"></span>
                            </div>
                        </div>

                        <div class="form-group lang-independent-area">
                            <label for="category">{{translate('Category')}} <span class="text-danger">*</span></label>
                            <select class="form-control select2 w-100" name="category" id="category">
                                <option value="">{{translate('Select Category')}}</option>
                                @foreach($all_categories as $category)
                                <option value="{{$category->id}}" {{$food_item['category'] == $category->id? 'selected':'' }}>{{$category->name}}</option>
                                @endforeach
                            </select>
                            <div>
                                <span class="text-danger" id="category_error"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="food-details">{{translate('Food Details')}} <span class="text-danger">*</span></label>
                            <textarea name="food_details" id="food-details"> {{$food_item['details']}} </textarea>
                            <div>
                                <span class="text-danger" id="details_error"></span>
                            </div>
                        </div>

                        <div class="form-group lang-independent-area">
                            <label for="meta-image">{{translate('Image')}} <span class="text-danger">*</span></label>
                            <input type="hidden" name="food_image" id="food-image-input" value="{{$food_item['image']}}">
                            <div class="row" id="food-image-view">
                                @if(!empty($food_item['image']))
                                <div class="form-image-container col-2 m-2">
                                    <div class="image-wrapper">
                                        <img src="{{asset(getFilePath($food_item['image']))}}" class="img-fluid p-2" alt="Selected Food Image">
                                        <div class="delete-button">
                                            <button type="button" class="btn btn-sm delete-selection" data-fileid="{{$food_item['image']}}" data-targetinputfield="#food-image-input" data-targetimagecontainerid="#food-image-view">
                                                <i class="far fa-times-circle"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                @else
                                <div class="form-image-container col-2 m-2">
                                    <div class="image-wrapper">
                                        <img src="{{asset($placeholder)}}" class="img-fluid" alt="black sample">
                                    </div>
                                </div>
                                @endif
                            </div>
                            <button type="button" class="btn text-blue browse-file" data-toggle="modal" data-target="#media-library" data-inputid="food-image-input" data-imagecontainerid="food-image-view" data-isformultiselect='0'>{{translate('Browse File')}}</button>
                            <div>
                                <span class="text-danger" id="image_error"></span>
                            </div>
                        </div>

                        <div class="form-group lang-independent-area">
                            <label for="food-type">{{translate('Food Type')}} <span class="text-danger">*</span></label>
                            <select class="form-control select2 w-100" name="food_type" id="food-type">
                                <option value="variant" {{$food_item['food_type'] == 'variant'? 'selected':''}}>{{translate('Variant Food')}}</option>
                                <option value="single" {{$food_item['food_type'] == 'single'? 'selected':''}}>{{translate('Single Food')}}</option>
                            </select>
                            <div>
                                <span class="text-danger" id="food_type_error"></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group lang-independent-area">
                            <h6><strong>{{translate('Status')}}</strong></h6>
                            <input type="checkbox" id="status" name="status" {{$food_item['status']=='1'? 'checked':''}} data-bootstrap-switch>
                            <div>
                                <span class="text-danger" id="status"></span>
                            </div>
                        </div>

                        <div class="form-group lang-independent-area">
                            <label for="price">{{translate('Price')}} <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="price" name="price" placeholder="Enter price" value="{{$food_item['price']}}">
                            <div>
                                <span class="text-danger" id="price_error"></span>
                            </div>
                        </div>

                        <div class="form-group lang-independent-area">
                            <label for="offer-price">{{translate('Offer Price')}} <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="offer-price" name="offer_price" placeholder="Enter offer price" value="{{$food_item['offer_price']}}">
                            <div>
                                <span class="text-danger" id="offer_price_error"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="meta-title">{{translate('Meta Title')}}</label>
                            <input type="text" class="form-control" id="meta-title" placeholder="Enter meta title" name="meta_title" value="{{$food_item['meta_title']}}">
                        </div>

                        <div class="form-group">
                            <label for="meta-description">{{translate('Meta Description')}}</label>
                            <textarea class="form-control" rows="3" placeholder="Enter Meta Description" name="meta_description" id="meta_description"> {{$food_item['meta_description']}} </textarea>
                        </div>

                        <div class="form-group lang-independent-area">
                            <label for="meta-image">{{translate('Meta Image')}}</label>
                            <input type="hidden" name="meta_image" id="meta-image-input" value="{{$food_item['meta_image']}}">
                            <div class="row" id="meta-image-view">
                                @if(!empty($food_item['meta_image']))
                                <div class="form-image-container col-2 m-2">
                                    <div class="image-wrapper">
                                        <img src="{{asset(getFilePath($food_item['meta_image']))}}" class="img-fluid p-2" alt="Selected Meta Image">
                                        <div class="delete-button">
                                            <button type="button" class="btn btn-sm delete-selection" data-fileid="{{$food_item['meta_image']}}" data-targetinputfield="#meta-image-input" data-targetimagecontainerid="#meta-image-view">
                                                <i class="far fa-times-circle"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                @else
                                <div class="form-image-container col-2 m-2">
                                    <div class="image-wrapper">
                                        <img src="{{asset($placeholder)}}" class="img-fluid" alt="black sample">
                                    </div>
                                </div>
                                @endif
                            </div>
                            <button type="button" class="btn text-blue browse-file" data-toggle="modal" data-target="#media-library" data-inputid="meta-image-input" data-imagecontainerid="meta-image-view" data-isformultiselect='0'>{{translate('Browse File')}}</button>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="variant-selections lang-independent-area d-none">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="variant-id">{{translate('Select Variant')}} <span class="text-danger"></span></label>
                                <select class="form-control select2" name="variant_id[]" id="variant-id" multiple>
                                    @foreach ($variants as $variant)
                                    <option value="{{$variant->id}}" {{in_array($variant->id, $variant_ids) ? 'selected' : ''}}>{{$variant->name}}</option>
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
                    <button class="btn bg-pink btn-block w-25 bold" id="store-button" type="button" onclick="updateFoodItems()">{{translate('Save')}}</button>
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
    let variant_option_array = JSON.parse('{!! json_encode($variant_option_array) !!}');
    // Array to store the options of each variant (sent from server)
    let variantData = JSON.parse('{!! json_encode($variants->toArray()) !!}');
    // Array to store the selected options
    let selected_variant_with_options = [];

    let variant_with_options_ids = JSON.parse('{!! json_encode($variant_option_ids) !!}');

    let is_structure_created = false

    let food_details_instance = null
    let meta_description_instance = null

    const initial_food_type = $("#food-type").val();
    let food_type = $("#food-type").val();

    separateSelectedVariantWithOptions()

    $(function() {
        'use strict'

        const default_lang = '{{$default_lang}}'
        let selected_lang = '{{$translatedLang}}'

        $('#translateInto').select2({
            theme: 'bootstrap4'
        })

        $('#translateInto').change(function() {
            let selected_lang = $('#translateInto').val()
            var currentBaseUrl = window.location.origin;
            var pathname = window.location.pathname
            var newUrl = currentBaseUrl + pathname + '?lang=' + selected_lang;
            window.location.href = newUrl;
        });

        if (selected_lang != default_lang) {
            $('.lang-independent-area').addClass('disabled-div')
        } else {
            $('.lang-independent-area').removeClass('disabled-div')
        }

        //Implement bootstrap switch is status field
        $("input[data-bootstrap-switch]").each(function() {
            $(this).bootstrapSwitch('state', $(this).prop('checked'));
        })

        // Initialize Select2 for category
        $('#category').select2({
            theme: 'bootstrap4',
            width: '100%'
        })
        // Initialize Select2 for branch
        $('#branch').select2({
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

        // Define the change event handler first
        $('#food-type').change(function() {
            food_type = $(this).val();
            if (food_type == 'variant') {
                $('.variant-selections').removeClass('d-none');
            } else {
                $('.variant-selections').addClass('d-none');
            }
        });

        $('#variant-id').change(() => {
            'use strict';

            const variant_id = $('#variant-id').val()

            //checking if structure is created for the first time while editing food item
            if (is_structure_created || initial_food_type!='variant') {
                if (variant_id.length > 0) {

                    // Find  variant ids that do not exist in variant_id (selected variants) and then
                    // remove the corresponding elements from the DOM
                    let removedVariantIds = selected_variant_with_options
                        .filter(v => !variant_id.includes(v.variant.id))
                        .map(v => v.variant.id);
                    removedVariantIds.forEach(id => {
                        $(`#variant-div-${id}`).remove();
                    });

                    // Keeping only the variants that exist in variant_id
                    selected_variant_with_options = selected_variant_with_options.filter(v => variant_id.includes(v.variant.id));

                    //Pushing new selected variants in selected_variant_with_options
                    // and creating select boxes for them
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

                //generate variant_option_array array
                generateCombinations(selected_variant_with_options);
            } else {
                // creating select box for the first time
                if (variant_id.length > 0) {
                    variant_id.forEach(id => {
                        createSelectBox(id)
                    })
                }
            }
            generateTableFromVariantCombinations()
            is_structure_created = true
        })

        // Trigger the change event
        $('#food-type').trigger('change');

        if (food_type == 'variant') {
            $('#variant-id').trigger('change')
        }

        let item_image = JSON.stringify([{
            'file_id': "{{$food_item['image']}}"
        }])
        $('#food-image-input').data('filedetails', item_image)

        let meta_image = JSON.stringify([{
            'file_id': "{{$food_item['meta_image']}}"
        }])
        $('#meta-image-input').data('filedetails', meta_image)

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

        let selected_options = variant_with_options_ids.filter(v => v.variant_id == variantId).map(v => parseInt(v.option_id))

        // Start building the raw HTML string for the form-group, label, and select element
        let selectHTML = `<div class="col-md-12" id="variant-div-${variant.id}"><div class="form-group">
        <label for="variant-${variant.id}">${variant.name} <span class="text-danger"></span></label>
        <select class="form-control select2 variant-options" name="variant_id[]"  id="variant-${variant.id}" multiple>`;

        // Loop through the options of the variant and create option elements
        variant.options.forEach(option => {
            // Check if the option.id exists in selected_options and add the selected attribute if true
            let selected = selected_options.includes(option.id) ? 'selected' : '';
            selectHTML += `<option data-name="${option.option_name}" value="${option.id}" ${selected}>${option.option_name}</option>`;
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
        tableHTML += '<th>{{translate("Price")}}</th><th>{{translate("Special Price")}}</th><th>{{translate("Is Available")}}</th></tr></thead><tbody>';

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
     * will separate selected variant with options
     * or you can say preparing selected_variant_with_options array
     */
    function separateSelectedVariantWithOptions() {
        'use strict';
        variant_option_array.forEach(v => {
            v.combo.forEach(c => {
                const variantIndex = selected_variant_with_options.findIndex(v => v.variant.id == c.variant.id);
                if (variantIndex > -1) {
                    const optionIndex = selected_variant_with_options[variantIndex].options.findIndex((option) => {
                        return option.id == c.options.id
                    });

                    if (optionIndex == -1) {
                        selected_variant_with_options[variantIndex].options.push(c.options);
                    }
                } else {
                    selected_variant_with_options.push({
                        variant: {
                            name: c.variant.name,
                            id: c.variant.id
                        },
                        options: [c.options]
                    })
                }
            })
        })
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
    function updateFoodItems() {
        'use strict';
        let data = {
            'id': "{{$food_item['id']}}",
            'name': $('#food-name').val(),
            'branch': $('#branch').val(),
            'translate_into': $('#translateInto').val(),
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
            '_token': '{{ csrf_token() }}'
        }

        $.ajax({
            url: '{{ route("update.food.items") }}', // Your endpoint URL
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