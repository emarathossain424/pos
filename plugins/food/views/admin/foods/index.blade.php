@php
$all_categories = getFoodCategories();
$all_branches = getBranches();
@endphp
@extends('layouts.master')
@section('title') {{translate('Food items')}} @endsection
@push('css')
<link rel="stylesheet" href="{{asset('pos/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('pos/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('pos/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">

<link rel="stylesheet" href="{{asset('pos/plugins/select2/css/select2.min.css')}}">
<link rel="stylesheet" href="{{asset('pos/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">

<link rel="stylesheet" href="{{asset('pos/plugins/summernote/summernote-bs4.min.css')}}">
<link rel="stylesheet" href="{{asset('pos/plugins/summernote/summernote-bs4.min.css')}}">

@endpush
@section('breadcrumb')
<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"><a href="#">{{translate('Dashboard')}}</a></li>
    <li class="breadcrumb-item active">{{translate('Food items')}}</li>
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
                        <h5 class="m-0">{{ translate('Food items') }}</h5>
                        <div class="ml-auto">
                            <a class="btn btn-primary" href="{{route('add.food.items')}}">
                                <i class="fa fa-plus"></i>
                                {{translate('Add item')}}
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{route('food.items')}}" method="get">
                            <div class="row d-flex justify-content-center">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <select class="form-control select2 w-100" name="branch" id="branch">
                                            <option value="">{{translate('Select Branch')}}</option>
                                            @foreach($all_branches as $branch)
                                            <option value="{{$branch->id}}" {{ request()->get('branch') == $branch->id ? 'selected' : '' }}>{{$branch->branch_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <select class="form-control select2 w-100" name="category" id="category">
                                            <option value="">{{translate('Select Category')}}</option>
                                            @foreach($all_categories as $category)
                                            <option value="{{$category->id}}" {{ request()->get('category') == $category->id ? 'selected' : '' }}>{{$category->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <select class="form-control select2 w-100" name="food_type" id="food_type">
                                            <option value="">{{translate('Select Food Type')}}</option>
                                            <option value="variant" {{ request()->get('food_type') == 'variant' ? 'selected' : '' }}>{{translate('variant')}}</option>
                                            <option value="single" {{ request()->get('food_type') == 'single' ? 'selected' : '' }}>{{translate('single')}}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <select class="form-control select2 w-100" name="item_status" id="item_status">
                                            <option value="">{{translate('Select Status')}}</option>
                                            <option value="1" {{ request()->get('item_status') == '1' ? 'selected' : '' }}>{{translate('Available')}}</option>
                                            <option value="0" {{ request()->get('item_status') == '0' ? 'selected' : '' }}>{{translate('Not Available')}}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <button class="btn btn-primary sm">{{translate('Filter')}}</button>
                                    <a class="btn btn-danger sm" href="{{route('food.items')}}">{{translate('Clear')}}</a>
                                </div>
                            </div>
                        </form>
                        <table id="itemList" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{translate('Image')}}</th>
                                    <th>{{translate('Name')}}</th>
                                    <th>{{translate('Category')}}</th>
                                    <th>{{translate('Food Type')}}</th>
                                    <th>{{translate('Status')}}</th>
                                    <th>{{translate('Price')}}</th>
                                    <th>{{translate('Offer Price')}}</th>
                                    <th>{{translate('Action')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $key = 0;
                                @endphp
                                @foreach ($food_items as $item)
                                @php
                                $key = $key+1;
                                @endphp
                                <tr>
                                    <td>{{$key}}.</td>
                                    <td>
                                        <img src="/{{ getFilePath($item->image) }}" alt="item-image" class="img-fluid" style="max-width: 50px; max-height: 50px;">
                                    </td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->foodCategory->name }}</td>

                                    <td>{{ $item->food_type }}</td>
                                    <td>
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input change-general-status" id="status{{$key}}" data-id="{{$item->id}}" {{$item->status==1?'checked':''}}>
                                            <label class="custom-control-label" for="status{{$key}}"></label>
                                        </div>
                                    </td>
                                    <td>{{ $item->price }}</td>
                                    <td>{{ $item->offer_price }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <button id="btnGroupDrop1" type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                {{translate('Action')}}
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="{{route('edit.food.item',$item->id)}}">{{translate('Edit')}}</a>
                                                <a class="dropdown-item delete-item" href="#" data-id="{{$item->id}}" data-toggle="modal" data-target="#deleteItem">{{translate('Delete')}}</a>
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

<!-- delete item-->
<x-dynamic-form-modal route="{{route('delete.food.item')}}" modal_type="modal-sm" id="deleteItem" title="{{translate('Delete Food Item')}}" execute_btn_name="{{translate('Delete')}}" execute_btn_class="btn-danger">
    <input type="hidden" name="id" id="delete-id">
    <span>{{translate('Are you sure, you want to delete this item?')}}</span>
</x-dynamic-form-modal>
<!-- /delete item-->

@endsection

@push('script')
<script src="{{asset('pos/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('pos/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('pos/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('pos/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
<script src="{{asset('pos/plugins/select2/js/select2.full.min.js')}}"></script>
<script>
    $(function() {
        'use strict'
        $("#itemList").DataTable()

        $('.delete-item').click(function() {
            const id = $(this).data('id')
            $('#delete-id').val(id)
        })

        $('#category').select2({
            theme: 'bootstrap4',
            width: '100%'
        })

        $('#food_type').select2({
            theme: 'bootstrap4',
            width: '100%'
        })

        $('#item_status').select2({
            theme: 'bootstrap4',
            width: '100%'
        })

        $('.change-general-status').change(function() {
            const id = $(this).data('id')
            var postData = {
                _token: '{{csrf_token()}}',
                id: id
            };
            $.post('{{route("update.item.status")}}', postData, function(response) {
                if(response.success){
                    toastr.success(response.message, 'success');
                    location.reload()
                }
                else{
                    toastr.error(response.message, 'error');
                }
            }).fail(function(error){
                toastr.error('{{translate("Something went wrong")}}', 'error');
            })
        })
    });
</script>
@endpush