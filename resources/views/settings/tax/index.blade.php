@extends('layouts.master')
@section('title') {{translate('Taxes')}} @endsection
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
    <li class="breadcrumb-item active">{{translate('Taxes')}}</li>
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
                        <h5 class="m-0">{{ translate('Taxes') }}</h5>
                        <div class="ml-auto">
                            <a class="btn btn-primary" href="#" data-toggle="modal" data-target="#createTax">{{translate('Create')}}</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="taxList" class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{translate('Name')}}</th>
                                    <th>{{translate('Tax Rate')}}</th>
                                    <th>{{translate('Status')}}</th>
                                    <th>{{translate('Action')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($taxes as $key=>$tax)
                                @php
                                $key = $key+1;
                                @endphp
                                <tr>
                                    <td>{{$key}}.</td>
                                    <td>{{ $tax->tax_name }}</td>
                                    <td>{{ $tax->tax_rate }}</td>
                                    <td>{{ $tax->status == 1 ? translate('Active') : translate('In active') }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <button id="btnGroupDrop1" type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                {{translate('Action')}}
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item edit-tax" href="#" data-toggle="modal" data-target="#editTax" data-id="{{$tax->id}}" data-tax_name="{{$tax->tax_name}}" data-tax_rate="{{$tax->tax_rate}}" data-status="{{$tax->status}}">{{translate('Edit')}}</a>
                                                <a class="dropdown-item delete-tax" href="#" data-toggle="modal" data-target="#deleteTax" data-id="{{$tax->id}}">{{translate('Delete')}}</a>
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

<!-- create tax-->
<x-dynamic-form-modal route="{{route('create.branch')}}" modal_type="modal-md" id="createTax" title="{{translate('Create Tax')}}" execute_btn_name="{{translate('Save')}}" execute_btn_class="btn-success">
    <div class="form-group">
        <label for="tax-name">{{translate('Tax Name')}}</label>
        <input type="text" class="form-control" id="tax-name" placeholder="Enter tax name" name="tax_name">
    </div>
    <div class="form-group">
        <label for="tax-rate">{{translate('Tax Rate')}}</label>
        <input type="number" class="form-control" id="tax-rate" placeholder="Enter tax rate" name="tax_rate">
    </div>
    <div class="form-group">
        <label for="tax-status">{{translate('Status')}}</label>
        <select class="form-control select2 w-100" name="status" id="tax-status">
            <option value="1">{{translate('Active')}}</option>
            <option value="0">{{translate('In active')}}</option>
        </select>
    </div>
</x-dynamic-form-modal>
<!-- /create tax-->

<!-- edit branch-->
<!-- <x-dynamic-form-modal route="{{route('update.branch')}}" modal_type="modal-md" id="editBranch" title="{{translate('Update Branch')}}" execute_btn_name="{{translate('Update')}}" execute_btn_class="btn-success">
    <input type="hidden" name="id" id="editable-branch-id" value="">
    <div class="form-group">
        <label for="editable-branch-name">{{translate('Branch Name')}}</label>
        <input type="text" class="form-control" id="editable-branch-name" placeholder="Enter branch name" name="branch_name">
    </div>
    <div class="form-group lang-independent-area">
        <label for="editable-mobile">{{translate('Mobile Number')}}</label>
        <input type="text" class="form-control" id="editable-mobile" placeholder="Enter mobile number" name="mobile">
    </div>
    <div class="form-group">
        <label for="editable-address">{{translate('Address')}}</label>
        <textarea name="address" id="editable-address" class="form-control" placeholder="Enter branch address"></textarea>
    </div>
    <div class="form-group lang-independent-area">
        <label for="editable-branch-status">{{translate('Status')}}</label>
        <select class="form-control select2 w-100" name="status" id="editable-branch-status">
            <option value="1">{{translate('Active')}}</option>
            <option value="0">{{translate('In active')}}</option>
        </select>
    </div>
</x-dynamic-form-modal> -->
<!-- /edit branch-->

<!-- delete branch-->
<!-- <x-dynamic-form-modal route="{{route('delete.branch')}}" modal_type="modal-sm" id="deleteBranch" title="{{translate('Delete Branch')}}" execute_btn_name="{{translate('Delete')}}" execute_btn_class="btn-danger">
    <input type="hidden" name="id" id="delete-id">
    <span>{{translate('Are you sure, you want to delete this branch?')}}</span>
</x-dynamic-form-modal> -->
<!-- /delete branch-->

@endsection

@push('script')
<script src="{{asset('pos/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('pos/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('pos/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('pos/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>

<script>
    $(function() {
        'use strict'

        $('#taxList').DataTable()

        $('.edit-tax').click(function() {
            const id = $(this).data('id')
            const tax_name = $(this).data('tax_name')
            const tax_rate = $(this).data('tax_rate')
            const status = $(this).data('status')

            $('#editable-tax-id').val(id)
            $('#editable-tax-name').val(tax_name)
            $('#editable-tax-rate').val(tax_rate)
            $('#editable-tax-status').val(status)
        })

        $('.delete-tax').click(function() {
            const id = $(this).data('id')
            $('#tax-id').val(id)
        })
    });
</script>
@endpush