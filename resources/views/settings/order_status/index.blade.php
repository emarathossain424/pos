@php
$languages = getAllLanguages();
$default_lang = getGeneralSettingsValue('default_lang');
$translatedLang = isset(request()->lang)?request()->lang:$default_lang;
@endphp
@extends('layouts.master')
@section('title') {{translate('Order Status')}} @endsection
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
    <li class="breadcrumb-item active">{{translate('Order Status')}}</li>
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
                        <h5 class="m-0">{{ translate('Order Status') }}</h5>
                        <div class="ml-auto">
                            <a class="btn btn-primary" href="#" data-toggle="modal" data-target="#createOrderStatus">{{translate('Create')}}</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="statusList" class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{translate('Name')}}</th>
                                    <th>{{translate('Action')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($status_list as $key=>$status)
                                @php
                                $key = $key+1;
                                @endphp
                                <tr>
                                    <td>{{$key}}.</td>
                                    <td>{{ $status->name }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <button id="btnGroupDrop1" type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                {{translate('Action')}}
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item edit-status" href="#" data-toggle="modal" data-target="#editStatus" data-id="{{$status->id}}" data-status_name="{{$status->name}}">{{translate('Edit')}}</a>
                                                <a class="dropdown-item delete-status" href="#" data-toggle="modal" data-target="#deleteStatus" data-id="{{$status->id}}">{{translate('Delete')}}</a>
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

<!-- create order status-->
<x-dynamic-form-modal route="{{route('create.order.status')}}" modal_type="modal-md" id="createOrderStatus" title="{{translate('Create Order Status')}}" execute_btn_name="{{translate('Save')}}" execute_btn_class="btn-success">
    <div class="form-group">
        <label for="status-name">{{translate('Status Name')}}</label>
        <input type="text" class="form-control" id="status-name" placeholder="Enter status name" name="status_name">
    </div>
</x-dynamic-form-modal>
<!-- /create order status-->

<!-- edit order status-->
<x-dynamic-form-modal route="{{route('update.order.status')}}" modal_type="modal-md" id="editStatus" title="{{translate('Update Status')}}" execute_btn_name="{{translate('Update')}}" execute_btn_class="btn-success">
    <input type="hidden" name="id" id="editable-status-id" value="">
    <div class="form-group">
        <label for="translateInto">{{translate('Translate Into')}}</label>
        <select class="form-control select2 w-100" name="translate_into" id="statusTranslation">
            @foreach($languages as $lang)
            <option value="{{$lang->id}}" {{ $lang->id == $default_lang ? 'selected' : '' }}>{{$lang->name}}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label for="editable-status-name">{{translate('Status Name')}}</label>
        <input type="text" class="form-control" id="editable-status-name" placeholder="Enter status name" name="status_name">
    </div>
</x-dynamic-form-modal>
<!-- /edit order status-->

<!-- delete order status-->
<x-dynamic-form-modal route="{{route('delete.order.status')}}" modal_type="modal-sm" id="deleteStatus" title="{{translate('Delete Status')}}" execute_btn_name="{{translate('Delete')}}" execute_btn_class="btn-danger">
    <input type="hidden" name="id" id="delete-id">
    <span>{{translate('Are you sure, you want to delete this status?')}}</span>
</x-dynamic-form-modal>
<!-- /delete order status-->

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

        $('#statusList').DataTable()

        $('.edit-status').click(function() {
            $('.lang-independent-area').removeClass('disabled-div')
            getStatusTranslation()

            const id = $(this).data('id')
            const status_name = $(this).data('status_name')

            $('#editable-status-id').val(id)
            $('#editable-status-name').val(status_name)
        })

        $('.delete-status').click(function() {
            const id = $(this).data('id')
            $('#delete-id').val(id)
        })

        $('#statusTranslation').change(() => {
            console.log(123)
            getStatusTranslation()
        })

        function getStatusTranslation() {
            const lang_id = $('#statusTranslation').val()
            const id = $('#editable-status-id').val()

            if (lang_id != default_lang) {
                $('.lang-independent-area').addClass('disabled-div')
            } else {
                $('.lang-independent-area').removeClass('disabled-div')
            }

            $.ajax({
                url: "{{ route('get.status.translation') }}",
                type: 'GET',
                data: {
                    _token: '{{ csrf_token() }}',
                    status_id: id,
                    lang_id: lang_id,
                },
                success: function(response) {
                    if (response.success == 1) {
                        $('#editable-status-name').val(response.data.name)
                    }
                }
            })
        }
    });
</script>
@endpush