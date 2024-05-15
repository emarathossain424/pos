@php
$all_categories = getFoodCategories();
$placeholder = getPlaceholderImagePath();

@endphp
@extends('layouts.master')
@section('title') {{translate('Add Food Item')}} @endsection
@push('css')
<link rel="stylesheet" href="{{asset('pos/plugins/select2/css/select2.min.css')}}">
<link rel="stylesheet" href="{{asset('pos/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('pos/plugins/summernote/summernote-bs4.min.css')}}">
@endpush
@section('breadcrumb')
<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"><a href="{{route('food.itmes')}}">{{translate('Food Itmes')}}</a></li>
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
                <form method="post" action="{{route('store.food.itmes')}}">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="food-name">{{translate('Food Name')}} <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="food-name" name="food_name" placeholder="Enter food name">
                                @error('food_name')
                                <div>
                                    <span class="text-danger">{{ $message }}</span>
                                </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="category">{{translate('Category')}}</label>
                                <select class="form-control select2 w-100" name="category" id="category">
                                    <option value="">{{translate('Select Category')}}</option>
                                    @foreach($all_categories as $category)
                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="food-details">{{translate('Food Details')}}</label>
                                <textarea class="form-control" rows="5" placeholder="Enter Food Details" name="food_details" id="food-details"></textarea>
                            </div>

                            <div class="form-group">
                                <label for="meta-image">{{translate('Image')}}</label>
                                <input type="hidden" name="food_image" id="food-image-input">
                                <div class="row" id="food-image-view">
                                    <div class="form-image-container col-2 m-2">
                                        <div class="image-wrapper">
                                            <img src="{{asset($placeholder)}}" class="img-fluid" alt="black sample">
                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="btn text-blue browse-file" data-toggle="modal" data-target="#food-library" data-inputid="food-image-input" data-imagecontainerid="food-image-view" data-isformultiselect='0'>{{translate('Browse File')}}</button>
                            </div>

                            <div class="form-group">
                                <label for="food-type">{{translate('Food Type')}}</label>
                                <select class="form-control select2 w-100" name="food-type" id="food-type">
                                    <option value="">{{translate('Select Food Type')}}</option>
                                    <option value="varient">{{translate('Varient Food')}}</option>
                                    <option value="single">{{translate('Single Food')}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <h6><strong>{{translate('Status')}}</strong></h6>
                                <input type="checkbox" id="status" name="status" checked data-bootstrap-switch>
                            </div>

                            <div class="form-group">
                                <label for="price">{{translate('Price')}} <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="price" name="price" placeholder="Enter price">
                                @error('price')
                                <div>
                                    <span class="text-danger">{{ $message }}</span>
                                </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="offer-price">{{translate('Offer Price')}} <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="offer-price" name="offer_price" placeholder="Enter offer price">
                                @error('offer_price')
                                <div>
                                    <span class="text-danger">{{ $message }}</span>
                                </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="meta-title">{{translate('Meta Title')}}</label>
                                <input type="text" class="form-control" id="meta-title" placeholder="Enter meta title" name="meta_title">
                            </div>

                            <div class="form-group">
                                <label for="meta-description">{{translate('Meta Description')}}</label>
                                <textarea class="form-control" rows="3" placeholder="Enter Meta Description" name="meta_description"></textarea>
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
                    <div class="varient-options">
                        <div class="row d-flex justify-content-end">
                            <button type="button" class="btn bg-primary bold ml-2" id="add-varient">{{translate('+ Add Option')}}</button>
                        </div>
                        <div class="varients">
                            <div class="row single-varient">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="varient-name">{{translate('Varient Name')}} <span class="text-danger"></span></label>
                                        <input type="text" class="form-control" id="varient-name" name="varient_name" placeholder="Ex. Size">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="options">{{translate('Options')}} <span class="text-danger"></span></label>
                                        <input type="text" class="form-control" id="options" name="options" placeholder="Ex. Small,Medium,Large">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row d-flex justify-content-center">
                            <button type="button" class="btn bg-primary bold ml-2" id="generate-varient">
                                <i class="fas fa-sync-alt"></i>
                                {{translate('Generate Variations')}}
                            </button>
                        </div>

                        <hr />

                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-bordered">
                                    <thead class="bg-pink">
                                        <tr id="varient-table-header">
                                            <th>{{translate('Price')}}</th>
                                            <th>{{translate('Special Price')}}</th>
                                            <th>{{translate('Is Available')}}</th>
                                        </tr>
                                    </thead>
                                    <tbody id="varient-table-content"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn bg-pink btn-block w-25 bold">{{translate('Save')}}</button>
                    </div>
                </form>
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
<script src="{{asset('pos/plugins/summernote/summernote-bs4.min.js')}}"></script>
<script>
    let varient_option_array = [];
    $(function() {
        'use strict'
        $("input[data-bootstrap-switch]").each(function() {
            $(this).bootstrapSwitch('state', $(this).prop('checked'));
        })

        $('#category').select2({
            theme: 'bootstrap4'
        })
        $('#food-type').select2({
            theme: 'bootstrap4'
        })

        $('#food-type').change(() => {
            const food_type = $('#food-type').val()
            if (food_type == 'varient') {
                $('.varient-options').removeClass('d-none')
            } else {
                $('.varient-options').addClass('d-none')
            }
        })

        $('#add-varient').click(() => {
            const html = `<div class="row single-varient">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="varient-name">{{translate('Varient Name')}}</label>
                                    <input type="text" class="form-control" id="varient-name" name="varient_name" placeholder="Ex. Size">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="options">{{translate('Options')}}</label>
                                    <input type="text" class="form-control" id="options" name="options" placeholder="Ex. Small,Medium,Large">
                                </div>
                            </div>
                         </div>`
            $('.varients').append(html)
        })

        $('#generate-varient').click(() => {
            let table_header_html = ``;
            let table_content_html = ``;
            let options_array = {};

            //Extracting options of each varient and store them in array
            $('.single-varient').each(function() {
                let varientName = $(this).find('[name="varient_name"]').val();
                if (varientName != '') {
                    table_header_html = table_header_html + `<th>` + varientName + `</th>`

                    let options = $(this).find('[name="options"]').val();
                    options_array[createSlug(varientName)] = options.split(',')
                }
            });

            //generating varient combinetion
            if (Object.keys(options_array).length != 0) {
                varient_option_array = cartesianProduct(options_array)
            }

            //Generating html for varient combinetion table header 
            table_header_html = table_header_html + `<th>{{translate('Price')}}</th>
                    <th>{{translate('Special Price')}}</th>
                    <th>{{translate('Is Available')}}</th>`

            $('#varient-table-header').html(table_header_html)

            //Generating html for varient combinetion table row
            for (let i = 0; i < varient_option_array.length; i++) {
                table_content_html = table_content_html + `<tr>`
                for (let key in varient_option_array[i]) {
                    table_content_html = table_content_html + `<td>` + varient_option_array[i][key] + `</td>`
                }

                table_content_html = table_content_html + `<td>
                                    <div class="form-group">
                                        <input type="number" class="form-control" name="price" id="price-` + i + `" onchange="setPrice(` + i + `)">
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <input type="number" class="form-control" name="special_price" id="special-price-` + i + `" onchange="setSpecialPrice(` + i + `)">
                                    </div>
                                </td>
                                <td>
                                <div class="form-group">
                                    <input type="checkbox" class="form-control" name="is_available" id="availablity-` + i + `" onchange="setAvailablity(` + i + `)"  checked data-bootstrap-switch>
                                </div>
                            </td>
                            </tr>`
            }
            $('#varient-table-content').html(table_content_html)

            $("input[data-bootstrap-switch]").each(function() {
                $(this).bootstrapSwitch('state', $(this).prop('checked'));
            })
        })

        /**
         * Will generate varient combinetion
         */
        function cartesianProduct(variants) {
            const keys = Object.keys(variants);
            const values = Object.values(variants);

            return values.reduce((accumulator, currentValue, index) => {
                const variantName = keys[index];

                return accumulator.flatMap((accItem) => {
                    return currentValue.map((option) => {
                        const newItem = {
                            ...accItem
                        };
                        newItem[variantName] = option;
                        return newItem;
                    });
                });
            }, [{}]);
        }

        /**
         * Will create slug 
         */
        function createSlug(str) {
            return str
                .toLowerCase()
                .replace(/[^\w\s-]/g, '') // Remove special characters
                .replace(/\s+/g, '-') // Replace spaces with dashes
                .replace(/--+/g, '-') // Replace consecutive dashes with a single dash
                .trim(); // Trim leading/trailing spaces and dashes
        }
    });

    /**
     * will set price for each varient combinetion
     */
    function setPrice(index) {
        let price = $('#price-' + index).val()
        varient_option_array[index].price = price
    }

    /**
     * will set availablity status for each varient combinetion
     */
    function setAvailablity(index) {
        let availablity = $('#availablity-' + index).val()
        varient_option_array[index].availablity = availablity
    }

    /**
     * will set special price for each varient combinetion
     */
    function setSpecialPrice(index) {
        let special_price = $('#special-price-' + index).val()
        varient_option_array[index].special_price = special_price
    }
</script>
@endpush