@php
$table_types = getAllTableTypes();
$table_status = getAllTableStatus();
$table_shapes = getAllTableShapes();


@endphp
@extends('layouts.master')
@section('title') {{translate('Tables')}} @endsection
@push('css')
<link rel="stylesheet" href="{{asset('pos/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('pos/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('pos/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
@endpush
@section('breadcrumb')
<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"><a href="#">{{translate('Dashboard')}}</a></li>
    <li class="breadcrumb-item active">{{translate('Tables')}}</li>
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
                        <h5 class="m-0">{{ translate('Tables') }}</h5>
                        <div class="ml-auto">
                            <a class="btn btn-primary" href="#" data-toggle="modal" data-target="#createTable">{{translate('Create')}}</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="tableList" class="table table-hover">
                            <thead>
                                <tr>
                                    <th>{{translate('Table No.')}}</th>
                                    <th>{{translate('Shape')}}</th>
                                    <th>{{translate('Type')}}</th>
                                    <th>{{translate('Status')}}</th>
                                    <th>{{translate('Chair Limit')}}</th>
                                    <th>{{translate('Action')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tables as $key=>$table)
                                <tr>
                                    <td>{{ $table->table_number }}.</td>
                                    <td>{{ $table_shapes[$table->shape] }}</td>
                                    <td>{{ $table_types[$table->type] }}</td>
                                    <td>{{ $table_status[$table->status] }}</td>
                                    <td>{{ $table->chair_limit }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <button id="btnGroupDrop1" type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                {{translate('Action')}}
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item edit-table" href="#" data-toggle="modal" data-target="#editTable" data-id="{{$table->id}}" data-table_number="{{$table->table_number}}" data-shape="{{$table->shape}}" data-type="{{$table->type}}" data-chair_limit="{{$table->chair_limit}}" data-status="{{$table->status}}">{{translate('Edit')}}</a>
                                                <a class="dropdown-item delete-table" href="#" data-toggle="modal" data-target="#deleteTable" data-id="{{$table->id}}">{{translate('Delete')}}</a>
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

<!-- create table-->
<x-dynamic-form-modal route="{{route('create.table')}}" modal_type="modal-md" id="createTable" title="{{translate('Create Table')}}" execute_btn_name="{{translate('Save')}}" execute_btn_class="btn-success">
    <input type="hidden" name="hall_id" value="{{ $hall_id }}">
    <div class="form-group">
        <label for="table-number">{{translate('Table Number')}}</label>
        <input type="number" class="form-control" id="table-number" placeholder="Enter Table Number" name="table_number">
    </div>
    <div class="form-group">
        <label for="table-shape">{{translate('Table Shape')}}</label>
        <select class="form-control select2 w-100" name="table_shape" id="table-shape">
            @foreach ($table_shapes as $key => $table_shape)
            <option value="{{ $key }}">{{ $table_shape }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label for="table-type">{{translate('Table Type')}}</label>
        <select class="form-control select2 w-100" name="table_type" id="table-type">
            @foreach ($table_types as $key => $table_type)
            <option value="{{ $key }}">{{ $table_type }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label for="table-status">{{translate('Table Status')}}</label>
        <select class="form-control select2 w-100" name="table_status" id="table-status">
            @foreach ($table_status as $key => $status)
            <option value="{{ $key }}">{{ $status }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label for="chair-limit">{{translate('Chair Limit')}}</label>
        <input type="number" class="form-control" id="chair-limit" placeholder="Enter Chair Limit" name="chair_limit">
    </div>
</x-dynamic-form-modal>
<!-- /create table-->

<!-- edit table-->
<x-dynamic-form-modal route="{{route('update.table')}}" modal_type="modal-md" id="editTable" title="{{translate('Update Table')}}" execute_btn_name="{{translate('Update')}}" execute_btn_class="btn-success">
    <input type="hidden" name="id" value="" id="editable-table-id">
    <div class="form-group">
        <label for="editable-table-number">{{translate('Table Number')}}</label>
        <input type="number" class="form-control" id="editable-table-number" placeholder="Enter Table Number" name="table_number">
    </div>
    <div class="form-group">
        <label for="editable-table-shape">{{translate('Table Shape')}}</label>
        <select class="form-control select2 w-100" name="table_shape" id="editable-table-shape">
            @foreach ($table_shapes as $key => $table_shape)
            <option value="{{ $key }}">{{ $table_shape }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label for="editable-table-type">{{translate('Table Type')}}</label>
        <select class="form-control select2 w-100" name="table_type" id="editable-table-type">
            @foreach ($table_types as $key => $table_type)
            <option value="{{ $key }}">{{ $table_type }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label for="editable-table-status">{{translate('Table Status')}}</label>
        <select class="form-control select2 w-100" name="table_status" id="editable-table-status">
            @foreach ($table_status as $key => $status)
            <option value="{{ $key }}">{{ $status }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label for="editable-chair-limit">{{translate('Chair Limit')}}</label>
        <input type="number" class="form-control" id="editable-chair-limit" placeholder="Enter Chair Limit" name="chair_limit">
    </div>
</x-dynamic-form-modal>
<!-- /edit table-->

<!-- delete hall-->
<x-dynamic-form-modal route="{{route('delete.table')}}" modal_type="modal-sm" id="deleteTable" title="{{translate('Delete Table')}}" execute_btn_name="{{translate('Delete')}}" execute_btn_class="btn-danger">
    <input type="hidden" name="id" id="delete-id">
    <span>{{translate('Are you sure, you want to delete this table?')}}</span>
</x-dynamic-form-modal>
<!-- /delete hall-->

@endsection

@push('script')
<script src="{{asset('pos/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('pos/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('pos/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('pos/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>

<script>
    $(function() {
        'use strict'

        $('#tableList').DataTable()

        $('.edit-table').click(function() {
            const id = $(this).data('id')
            const table_number = $(this).data('table_number')
            const table_shape = $(this).data('shape')
            const table_type = $(this).data('type')
            const table_status = $(this).data('status')
            const chair_limit = $(this).data('chair_limit')

            $('#editable-table-number').val(table_number)
            $('#editable-table-shape').val(table_shape)
            $('#editable-table-type').val(table_type)
            $('#editable-table-status').val(table_status)
            $('#editable-chair-limit').val(chair_limit)
            $('#editable-table-id').val(id)


        })

        $('.delete-table').click(function() {
            const id = $(this).data('id')
            $('#delete-id').val(id)
        })
    });
</script>
@endpush