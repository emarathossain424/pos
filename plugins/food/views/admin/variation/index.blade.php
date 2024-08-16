@php
@endphp
@extends('layouts.master')
@section('title') {{translate('Variations')}} @endsection
@push('css')
<link rel="stylesheet" href="{{asset('pos/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('pos/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('pos/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
@endpush
@section('breadcrumb')
<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"><a href="#">{{translate('Dashboard')}}</a></li>
    <li class="breadcrumb-item active">{{translate('Variations')}}</li>
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
                        <h5 class="m-0">{{ translate('Variant List') }}</h5>
                        <div class="ml-auto">
                            <a class="btn btn-primary" href="#" data-toggle="modal" data-target="#createVariant">{{translate('Create Variant')}}</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="variantList" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{translate('Name')}}</th>
                                    <th>{{translate('Options')}}</th>
                                    <th>{{translate('Action')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($variants as $key=>$variant)
                                @php
                                $key = $key+1;
                                @endphp
                                <tr>
                                    <td>{{$key}}.</td>
                                    <td>{{ $variant->name }}</td>
                                    @if (!empty($variant->options))
                                    <td>
                                        @foreach ($variant->options as $option)
                                        <span class="badge bg-secondary">{{ $option->option_name }}</span>
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
                                                <a class="dropdown-item update-variant" href="#" data-id="{{$variant->id}}" data-name="{{$variant->name}}" data-toggle="modal" data-target="#updateVariant">{{translate('Edit')}}</a>
                                                <a class="dropdown-item delete-variant" href="#" data-id="{{$variant->id}}" data-toggle="modal" data-target="#deleteVariant">{{translate('Delete')}}</a>
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

<!-- delete variant-->
<x-dynamic-form-modal route="{{route('delete.variant')}}" modal_type="modal-sm" id="deleteVariant" title="{{translate('Delete Variant')}}" execute_btn_name="{{translate('Delete')}}" execute_btn_class="btn-danger">
    <input type="hidden" name="id" id="delete-id">
    <span>{{translate('Are you sure, you want to delete this variant?')}}</span>
</x-dynamic-form-modal>
<!-- /delete variant-->

<!-- create variant-->
<x-dynamic-form-modal route="{{route('create.variant')}}" modal_type="modal-md" id="createVariant" title="{{translate('Create Variant')}}" execute_btn_name="{{translate('Save')}}" execute_btn_class="btn-success">
    <div class="form-group">
        <label for="variant-name">{{translate('Variant Name')}}</label>
        <input type="text" class="form-control" id="variant-name" placeholder="Enter variant name" name="variant_name">
    </div>
</x-dynamic-form-modal>
<!-- /create variant-->

<x-dynamic-form-modal route="{{route('update.variant')}}" modal_type="modal-md" id="updateVariant" title="{{translate('Edit Variant')}}" execute_btn_name="{{translate('Update')}}" execute_btn_class="btn-success">
    <input type="hidden" name="id" id="edit-id">
    <div class="form-group">
        <label for="variant-name">{{translate('Variant Name')}}</label>
        <input type="text" class="form-control" id="edit-variant-name" placeholder="Enter variant name" name="variant_name">
    </div>
</x-dynamic-form-modal>
<!-- /create variant-->

@endsection

@push('script')
<script src="{{asset('pos/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('pos/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('pos/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('pos/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>

<script>
    $(function() {
        'use strict'

        $('#variantList').DataTable()

        $('.update-variant').click(function() {
            const id = $(this).data('id')
            const name = $(this).data('name')
            $('#edit-id').val(id)
            $('#edit-variant-name').val(name)
        })
        
        $('.delete-variant').click(function() {
            const id = $(this).data('id')
            $('#delete-id').val(id)
        })
    });
</script>
@endpush