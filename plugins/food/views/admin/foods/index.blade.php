@php
@endphp
@extends('layouts.master')
@section('title') {{translate('Food items')}} @endsection
@push('css')
<link rel="stylesheet" href="{{asset('pos/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('pos/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('pos/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
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
                                            <input type="checkbox" class="custom-control-input change-featured-status" id="status{{$key}}" data-id="{{$item->id}}" {{$item->status==1?'checked':''}}>
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
                                                <a class="dropdown-item delete-category" href="#" data-id="{{$item->id}}" data-toggle="modal" data-target="#deleteCategory">{{translate('Delete')}}</a>
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

@endsection

@push('script')
<script src="{{asset('pos/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('pos/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('pos/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('pos/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>

<script>
    $(function() {
        'use strict'
        $("#itemList").DataTable()
    });
    
</script>
@endpush