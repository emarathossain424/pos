@php
@endphp
@extends('layouts.master')
@section('title') {{translate('Branches')}} @endsection
@push('css')
<link rel="stylesheet" href="{{asset('pos/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('pos/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('pos/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
@endpush
@section('breadcrumb')
<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"><a href="#">{{translate('Dashboard')}}</a></li>
    <li class="breadcrumb-item active">{{translate('Branches')}}</li>
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
                        <h5 class="m-0">{{ translate('Branches') }}</h5>
                        <div class="ml-auto">
                            <a class="btn btn-primary" href="#" data-toggle="modal" data-target="#createBranch">{{translate('Create')}}</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="branchList" class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{translate('Name')}}</th>
                                    <th>{{translate('Mobile')}}</th>
                                    <th>{{translate('Address')}}</th>
                                    <th>{{translate('Status')}}</th>
                                    <th>{{translate('Make Default')}}</th>
                                    <th>{{translate('Action')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($branches as $key=>$branch)
                                @php
                                $key = $key+1;
                                @endphp
                                <tr>
                                    <td>{{$key}}.</td>
                                    <td>{{ $branch->branch_name }}</td>
                                    <td>{{ $branch->mobile }}</td>
                                    <td>{{ $branch->address }}</td>
                                    <td>{{ $branch->status == 1 ? translate('Active') : translate('In active') }}</td>
                                    <td>
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input change-default-status" id="defaultStatus{{$key}}" data-id="{{$branch->id}}" {{$branch->is_default==1?'checked':''}}>
                                            <label class="custom-control-label" for="defaultStatus{{$key}}"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <button id="btnGroupDrop1" type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                {{translate('Action')}}
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item edit-branch" href="#" data-toggle="modal" data-target="#editBranch" data-id="{{$branch->id}}" data-branch_name="{{$branch->branch_name}}" data-mobile="{{$branch->mobile}}" data-address="{{$branch->address}}" data-status="{{$branch->status}}">{{translate('Edit')}}</a>
                                                <a class="dropdown-item delete-branch" href="#" data-toggle="modal" data-target="#deleteBranch" data-id="{{$branch->id}}">{{translate('Delete')}}</a>
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

<!-- create branch-->
<x-dynamic-form-modal route="{{route('create.branch')}}" modal_type="modal-md" id="createBranch" title="{{translate('Create Branch')}}" execute_btn_name="{{translate('Save')}}" execute_btn_class="btn-success">
    <div class="form-group">
        <label for="branch-name">{{translate('Branch Name')}}</label>
        <input type="text" class="form-control" id="branch-name" placeholder="Enter branch name" name="branch_name">
    </div>
    <div class="form-group">
        <label for="mobile">{{translate('Mobile Number')}}</label>
        <input type="text" class="form-control" id="mobile" placeholder="Enter mobile number" name="mobile">
    </div>
    <div class="form-group">
        <label for="address">{{translate('Address')}}</label>
        <textarea name="address" id="address" class="form-control" placeholder="Enter branch address"></textarea>
    </div>
    <div class="form-group">
        <label for="branch-status">{{translate('Status')}}</label>
        <select class="form-control select2 w-100" name="status" id="branch-status">
            <option value="1">{{translate('Active')}}</option>
            <option value="0">{{translate('In active')}}</option>
        </select>
    </div>
</x-dynamic-form-modal>
<!-- /create branch-->

<!-- edit branch-->
<x-dynamic-form-modal route="{{route('update.branch')}}" modal_type="modal-md" id="editBranch" title="{{translate('Update Branch')}}" execute_btn_name="{{translate('Update')}}" execute_btn_class="btn-success">
    <input type="hidden" name="id" id="editable-branch-id" value="">
    <div class="form-group">
        <label for="editable-branch-name">{{translate('Branch Name')}}</label>
        <input type="text" class="form-control" id="editable-branch-name" placeholder="Enter branch name" name="branch_name">
    </div>
    <div class="form-group">
        <label for="editable-mobile">{{translate('Mobile Number')}}</label>
        <input type="text" class="form-control" id="editable-mobile" placeholder="Enter mobile number" name="mobile">
    </div>
    <div class="form-group">
        <label for="editable-address">{{translate('Address')}}</label>
        <textarea name="address" id="editable-address" class="form-control" placeholder="Enter branch address"></textarea>
    </div>
    <div class="form-group">
        <label for="editable-branch-status">{{translate('Status')}}</label>
        <select class="form-control select2 w-100" name="status" id="editable-branch-status">
            <option value="1">{{translate('Active')}}</option>
            <option value="0">{{translate('In active')}}</option>
        </select>
    </div>
</x-dynamic-form-modal>
<!-- /edit branch-->

<!-- delete branch-->
<x-dynamic-form-modal route="{{route('delete.branch')}}" modal_type="modal-sm" id="deleteBranch" title="{{translate('Delete Branch')}}" execute_btn_name="{{translate('Delete')}}" execute_btn_class="btn-danger">
    <input type="hidden" name="id" id="delete-id">
    <span>{{translate('Are you sure, you want to delete this branch?')}}</span>
</x-dynamic-form-modal>
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

        $('#branchList').DataTable()

        $('.edit-branch').click(function() {
            const id = $(this).data('id')
            const branch_name = $(this).data('branch_name')
            const mobile = $(this).data('mobile')
            const address = $(this).data('address')
            const status = $(this).data('status')

            $('#editable-branch-id').val(id)
            $('#editable-branch-name').val(branch_name)
            $('#editable-mobile').val(mobile)
            $('#editable-address').val(address)
            $('#editable-branch-status').val(status)
        })

        $('.delete-branch').click(function() {
            const id = $(this).data('id')
            $('#delete-id').val(id)
        })

        $('.change-default-status').change(function() {
            const id = $(this).data('id')
            var postData = {
                _token: '{{csrf_token()}}',
                id: id
            };
            $.post('{{route("update.branch.default.status")}}', postData, function(response) {
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