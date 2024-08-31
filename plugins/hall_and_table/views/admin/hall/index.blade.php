@php
@endphp
@extends('layouts.master')
@section('title') {{translate('Halls')}} @endsection
@push('css')
<link rel="stylesheet" href="{{asset('pos/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('pos/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('pos/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
@endpush
@section('breadcrumb')
<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"><a href="#">{{translate('Dashboard')}}</a></li>
    <li class="breadcrumb-item active">{{translate('Halls')}}</li>
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
                        <h5 class="m-0">{{ translate('Halls') }}</h5>
                        <div class="ml-auto">
                            <a class="btn btn-primary" href="#" data-toggle="modal" data-target="#createHall">{{translate('Create')}}</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="hallList" class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{translate('Name')}}</th>
                                    <th>{{translate('Capacity')}}</th>
                                    <th>{{translate('Status')}}</th>
                                    <th>{{translate('Manage Tables')}}</th>
                                    <th>{{translate('Action')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($halls as $key=>$hall)
                                @php
                                $key = $key+1;
                                @endphp
                                <tr>
                                    <td>{{$key}}.</td>
                                    <td>{{ $hall->name }}</td>
                                    <td>{{ $hall->table_capacity }}</td>
                                    <td>{{ $hall->status == 1 ? translate('Active') : translate('In active') }}</td>
                                    <td>
                                        <a class="btn bg-pink btn-sm" href="#">{{translate('Manage Tables')}}</a>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <button id="btnGroupDrop1" type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                {{translate('Action')}}
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item edit-hall" href="#" data-toggle="modal" data-target="#editHall" data-id="{{$hall->id}}" data-name="{{$hall->name}}" data-capacity="{{$hall->table_capacity}}" data-status="{{$hall->status}}">{{translate('Edit')}}</a>
                                                <a class="dropdown-item delete-hall" href="#" data-toggle="modal" data-target="#deleteHall" data-id="{{$hall->id}}">{{translate('Delete')}}</a>
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

<!-- create hall-->
<x-dynamic-form-modal route="{{route('create.hall')}}" modal_type="modal-md" id="createHall" title="{{translate('Create Hall')}}" execute_btn_name="{{translate('Save')}}" execute_btn_class="btn-success">
    <div class="form-group">
        <label for="hall-name">{{translate('Hall Name')}}</label>
        <input type="text" class="form-control" id="hall-name" placeholder="Enter hall name" name="hall_name">
    </div>
    <div class="form-group">
        <label for="table-capacity">{{translate('Table Capacity')}}</label>
        <input type="number" class="form-control" id="table-capacity" placeholder="Enter Table Capacity" name="table_capacity">
    </div>
    <div class="form-group">
        <label for="hall-status">{{translate('Hall Status')}}</label>
        <select class="form-control select2 w-100" name="hall_status" id="hall-status">
            <option value="1">{{translate('Active')}}</option>
            <option value="0">{{translate('In active')}}</option>
        </select>
    </div>
</x-dynamic-form-modal>
<!-- /create hall-->

<!-- edit hall-->
<x-dynamic-form-modal route="{{route('update.hall')}}" modal_type="modal-md" id="editHall" title="{{translate('Update Hall')}}" execute_btn_name="{{translate('Update')}}" execute_btn_class="btn-success">
    <input type="hidden" name="id" id="editable-hall-id" value="">
    <div class="form-group">
        <label for="editable-hall-name">{{translate('Hall Name')}}</label>
        <input type="text" class="form-control" id="editable-hall-name" placeholder="Enter hall name" name="hall_name">
    </div>
    <div class="form-group">
        <label for="editable-table-capacity">{{translate('Table Capacity')}}</label>
        <input type="number" class="form-control" id="editable-table-capacity" placeholder="Enter Table Capacity" name="table_capacity">
    </div>
    <div class="form-group">
        <label for="editable-hall-status">{{translate('Hall Status')}}</label>
        <select class="form-control select2 w-100" name="hall_status" id="editable-hall-status">
            <option value="1">{{translate('Active')}}</option>
            <option value="0">{{translate('In active')}}</option>
        </select>
    </div>
</x-dynamic-form-modal>
<!-- /edit hall-->

<!-- delete hall-->
<x-dynamic-form-modal route="{{route('delete.hall')}}" modal_type="modal-sm" id="deleteHall" title="{{translate('Delete Hall')}}" execute_btn_name="{{translate('Delete')}}" execute_btn_class="btn-danger">
    <input type="hidden" name="id" id="delete-id">
    <span>{{translate('Are you sure, you want to delete this hall?')}}</span>
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

        $('#hallList').DataTable()

        $('.edit-hall').click(function() {
            const id = $(this).data('id')
            const name = $(this).data('name')
            const capacity = $(this).data('capacity')
            const status = $(this).data('status')

            $('#editable-hall-id').val(id)
            $('#editable-hall-name').val(name)
            $('#editable-table-capacity').val(capacity)
            $('#editable-hall-status').val(status)
        })

        $('.delete-hall').click(function() {
            const id = $(this).data('id')
            $('#delete-id').val(id)
        })
    });
</script>
@endpush