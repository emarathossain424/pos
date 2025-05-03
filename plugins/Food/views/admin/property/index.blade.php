@php
$languages = getAllLanguages();
$default_lang = getGeneralSettingsValue('default_lang');
$translatedLang = isset(request()->lang)?request()->lang:$default_lang;
@endphp
@extends('layouts.master')
@section('title') {{translate('Properties')}} @endsection
@push('css')
<link rel="stylesheet" href="{{asset('pos/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('pos/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('pos/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
<style>
    .disabled-div {
        opacity: 0.5;
        pointer-events: none;
    }
</style>
@endpush
@section('breadcrumb')
<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"><a href="#">{{translate('Dashboard')}}</a></li>
    <li class="breadcrumb-item active">{{translate('Properties')}}</li>
</ol>
@endsection
@section('content')
<div class="content">
    <div class="container-fluid">
        <x-alert column="col-md-12" alert_type="alert-warning" />
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h5 class="m-0">{{ translate('Property List') }}</h5>
                        <div class="ml-auto">
                            <a class="btn btn-primary" href="#" data-toggle="modal" data-target="#createProperty">{{translate('Create Property')}}</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="propertyList" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{translate('Name')}}</th>
                                    <th>{{translate('Status')}}</th>
                                    <th>{{translate('Items')}}</th>
                                    <th>{{translate('Action')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($properties as $key=>$property)
                                @php
                                $key = $key+1;
                                @endphp
                                <tr>
                                    <td>{{$key}}.</td>
                                    <td>{{ $property->name }}</td>
                                    <td>{{ $property->status == 1 ? translate('Active') : translate('Inactive') }}</td>
                                    @if (!empty($property->items))
                                    <td>
                                        @foreach ($property->items as $item)
                                        @php
                                        $status_class = $item->status == 1 ? 'success' : 'danger';
                                        @endphp
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-sm btn-{{$status_class}}">{{ $item->item_name }} ({{ setPriceFormat( $item->price )}})</button>
                                            <button type="button" class="btn btn-sm btn-{{$status_class}} dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                <span class="sr-only">Toggle Dropdown</span>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item update-item" href="#" data-id="{{$item->id}}" data-name="{{$item->item_name}}" data-price="{{$item->price}}" data-status="{{$item->status}}" data-toggle="modal" data-target="#updateItem">{{translate('Edit')}}</a>
                                                <a class="dropdown-item delete-item" href="#" data-id="{{$item->id}}" data-toggle="modal" data-target="#deleteItem">{{translate('Delete')}}</a>
                                            </div>
                                        </div>
                                        @endforeach
                                    </td>
                                    @else
                                    <td>
                                        <i class="fa fa-ban"></i>
                                    </td>
                                    @endif
                                    <td>
                                        <div class="btn-group" role="group">
                                            <button id="btnGroupDrop1" type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                {{translate('Action')}}
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item add-item" href="#" data-id="{{$property->id}}" data-toggle="modal" data-target="#addItem">{{translate('Add Item')}}</a>
                                                <a class="dropdown-item update-property" href="#" data-id="{{$property->id}}" data-name="{{$property->name}}" data-status="{{$property->status}}" data-toggle="modal" data-target="#updateProperty">{{translate('Edit')}}</a>
                                                <a class="dropdown-item delete-property" href="#" data-id="{{$property->id}}" data-toggle="modal" data-target="#deleteProperty">{{translate('Delete')}}</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- delete property-->
<x-dynamic-form-modal route="{{route('delete.property')}}" modal_type="modal-sm" id="deleteProperty" title="{{translate('Delete Property')}}" execute_btn_name="{{translate('Delete')}}" execute_btn_class="btn-danger">
    <input type="hidden" name="id" id="delete-id">
    <span>{{translate('Are you sure, you want to delete this property?')}}</span>
</x-dynamic-form-modal>
<!-- /delete property-->

<!-- create property-->
<x-dynamic-form-modal route="{{route('create.property')}}" modal_type="modal-md" id="createProperty" title="{{translate('Create Property')}}" execute_btn_name="{{translate('Save')}}" execute_btn_class="btn-success">
    <div class="form-group">
        <label for="property-name">{{translate('Property Name')}}</label>
        <input type="text" class="form-control" id="property-name" placeholder="Enter property name" name="property_name">
    </div>
    <div class="form-group">
        <label for="propertyStatus">{{translate('Property Status')}}</label>
        <select class="form-control select2 w-100" name="property_status" id="propertyStatus">
            <option value="1">{{translate('Active')}}</option>
            <option value="0">{{translate('In active')}}</option>
        </select>
    </div>
</x-dynamic-form-modal>
<!-- /create property-->

<!-- update property-->
<x-dynamic-form-modal route="{{route('update.property')}}" modal_type="modal-md" id="updateProperty" title="{{translate('Edit Property')}}" execute_btn_name="{{translate('Update')}}" execute_btn_class="btn-success">
    <input type="hidden" name="id" id="edit-id">
    <div class="form-group">
        <label for="translateInto">{{translate('Translate Into')}}</label>
        <select class="form-control select2 w-100" name="translate_into" id="propertyTranslation">
            @foreach($languages as $lang)
            <option value="{{$lang->id}}" {{ $lang->id == $translatedLang ? 'selected' : '' }}>{{$lang->name}}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label for="property-name">{{translate('Property Name')}}</label>
        <input type="text" class="form-control" id="edit-property-name" placeholder="Enter property name" name="property_name">
    </div>
    <div class="form-group lang-independent-area">
        <label for="edit-property-status">{{translate('Property Status')}}</label>
        <select class="form-control select2 w-100" name="property_status" id="edit-property-status">
            <option value="1">{{translate('Active')}}</option>
            <option value="0">{{translate('In active')}}</option>
        </select>
    </div>
</x-dynamic-form-modal>
<!-- /update property-->

<!-- delete item-->
<x-dynamic-form-modal route="{{route('delete.item')}}" modal_type="modal-sm" id="deleteItem" title="{{translate('Delete Item')}}" execute_btn_name="{{translate('Delete')}}" execute_btn_class="btn-danger">
    <input type="hidden" name="id" id="delete-item-id">
    <span>{{translate('Are you sure, you want to delete this item?')}}</span>
</x-dynamic-form-modal>
<!-- /delete item-->

<!-- update item-->
<x-dynamic-form-modal route="{{route('update.item')}}" modal_type="modal-md" id="updateItem" title="{{translate('Edit Item')}}" execute_btn_name="{{translate('Update')}}" execute_btn_class="btn-success">
    <input type="hidden" name="id" id="edit-item-id">
    <div class="form-group">
        <label for="translateInto">{{translate('Translate Into')}}</label>
        <select class="form-control select2 w-100" name="translate_into" id="itemTranslation">
            @foreach($languages as $lang)
            <option value="{{$lang->id}}" {{ $lang->id == $translatedLang ? 'selected' : '' }}>{{$lang->name}}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label for="edit-item-name">{{translate('Item Name')}}</label>
        <input type="text" class="form-control" id="edit-item-name" placeholder="Enter item name" name="item_name">
    </div>
    <div class="form-group lang-independent-area">
        <label for="edit-item-price">{{translate('Item Price')}} ({{getCurrencySymbol(getGeneralSettingsValue( 'default_currency' ))}})</label>
        <input type="text" class="form-control" id="edit-item-price" placeholder="Enter item price" name="item_price">
    </div>
    <div class="form-group lang-independent-area">
        <label for="edit-item-status">{{translate('Item Status')}}</label>
        <select class="form-control select2 w-100" name="item_status" id="edit-item-status">
            <option value="1">{{translate('Active')}}</option>
            <option value="0">{{translate('In active')}}</option>
        </select>
    </div>
</x-dynamic-form-modal>
<!-- /update item-->

<!-- add item-->
<x-dynamic-form-modal route="{{route('add.item')}}" modal_type="modal-md" id="addItem" title="{{translate('Add Item')}}" execute_btn_name="{{translate('Save')}}" execute_btn_class="btn-success">
    <input type="hidden" name="property_id" id="property-id">
    <div class="form-group">
        <label for="item-name">{{translate('Item Name')}}</label>
        <input type="text" class="form-control" id="item-name" placeholder="Enter item name" name="item_name">
    </div>
    <div class="form-group">
        <label for="item-price">{{translate('Item Price')}} ({{getCurrencySymbol(getGeneralSettingsValue( 'default_currency' ))}})</label>
        <input type="number" class="form-control" id="item-price" placeholder="Enter item price" name="item_price" step="0.01">
    </div>
    <div class="form-group">
        <label for="itemStatus">{{translate('Item Status')}}</label>
        <select class="form-control select2 w-100" name="item_status" id="itemStatus">
            <option value="1">{{translate('Active')}}</option>
            <option value="0">{{translate('In active')}}</option>
        </select>
    </div>
</x-dynamic-form-modal>
<!-- /add item-->

@endsection

@push('script')
<script src="{{asset('pos/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('pos/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('pos/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('pos/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>

<script>
    $(function() {
        'use strict'

        const default_lang = '{{$default_lang}}'

        $('#propertyList').DataTable()

        //Set property editable properties
        $('.update-property').click(function() {
            $('.lang-independent-area').removeClass('disabled-div')

            getPropertyTranslation()

            const id = $(this).data('id')
            const name = $(this).data('name')
            const status = $(this).data('status')
            $('#edit-id').val(id)
            $('#edit-property-name').val(name)
            $('#edit-property-status').val(status)
        })

        //Set property id to be deleted
        $('.delete-property').click(function() {
            const id = $(this).data('id')
            $('#delete-id').val(id)
        })

        //Set property id while adding item
        $('.add-item').click(function() {
            const id = $(this).data('id')
            $('#property-id').val(id)
        })

        //Set item editable content
        $('.update-item').click(function() {
            $('.lang-independent-area').removeClass('disabled-div')

            getItemTranslation()

            const id = $(this).data('id')
            const name = $(this).data('name')
            const price = $(this).data('price')
            const status = $(this).data('status')

            $('#edit-item-id').val(id)
            $('#edit-item-name').val(name)
            $('#edit-item-price').val(price)
            $('#edit-item-status').val(status)
        })

        //Set item id to be deleted
        $('.delete-item').click(function() {
            const id = $(this).data('id')
            $('#delete-item-id').val(id)
        })

        //translate property name on language change
        $('#propertyTranslation').change(() => {
            getPropertyTranslation()
        })

        //translate item name on language change
        $('#itemTranslation').change(() => {
            getItemTranslation()
        })

        //manage property translation
        function getPropertyTranslation() {
            const lang_id = $('#propertyTranslation').val()
            const id = $('#edit-id').val()

            if (lang_id != default_lang) {
                $('.lang-independent-area').addClass('disabled-div')
            } else {
                $('.lang-independent-area').removeClass('disabled-div')
            }

            $.ajax({
                url: "{{ route('get.property.translation') }}",
                type: 'GET',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: id,
                    lang_id: lang_id,
                },
                success: function(response) {
                    if (response.success == 1) {
                        $('#edit-property-name').val(response.data.name)
                    }
                }
            })
        }

        //manage item translation
        function getItemTranslation() {
            const lang_id = $('#itemTranslation').val()
            const id = $('#edit-item-id').val()
            if (lang_id != default_lang) {
                $('.lang-independent-area').addClass('disabled-div')
            } else {
                $('.lang-independent-area').removeClass('disabled-div')
            }

            $.ajax({
                url: "{{ route('get.item.translation') }}",
                type: 'GET',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: id,
                    lang_id: lang_id,
                },
                success: function(response) {
                    if (response.success == 1) {
                        $('#edit-item-name').val(response.data.name)
                    }
                }
            })
        }
    });
</script>
@endpush