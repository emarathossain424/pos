@php
@endphp
@extends('layouts.master')
@section('title') {{translate('Languages')}} @endsection
@push('css')
<link rel="stylesheet" href="{{asset('pos/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('pos/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('pos/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
@endpush
@section('breadcrumb')
<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"><a href="#">{{translate('Dashboard')}}</a></li>
    <li class="breadcrumb-item active">{{translate('Languages')}}</li>
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
                        <h5 class="m-0">{{ translate('Languages') }}</h5>
                        <div class="ml-auto">
                            <button class="btn btn-primary" data-toggle="modal" data-target="#createLang">{{translate('Create')}}</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="language" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{translate('Name')}}</th>
                                    <th>{{translate('Code')}}</th>
                                    <th>{{translate('Is RTL')}}</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($languages as $key=>$lang)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{$lang->name}}</td>
                                    <td>{{$lang->code}}</td>
                                    <td>
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input change-rtl-status" id="rtlStatus{{$key}}" data-id="{{$lang->id}}" {{$lang->is_rtl==1?'checked':''}}>
                                            <label class="custom-control-label" for="rtlStatus{{$key}}"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <button id="btnGroupDrop1" type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                {{translate('Action')}}
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="{{route('translate',$lang->code)}}">{{translate('Translate')}}</a>
                                                <a class="dropdown-item update-lang" href="#" data-id="{{$lang->id}}" data-name="{{$lang->name}}" data-code="{{$lang->code}}" data-toggle="modal" data-target="#updateLang">{{translate('Edit')}}</a>
                                                <a class="dropdown-item delete-lang" href="#" data-id="{{$lang->id}}" data-toggle="modal" data-target="#deleteLang">{{translate('Delete')}}</a>
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

<!-- create language-->
<x-dynamic-form-modal route="{{route('languages.store')}}" id="createLang" title="{{translate('Create Language')}}" execute_btn_name="{{translate('Save')}}" execute_btn_class="btn-success">
    <div class="form-group">
        <label for="name">{{translate('Name')}}</label>
        <input type="text" class="form-control" id="name" name="name" placeholder="{{translate('Enter Language Name')}}">
    </div>
    <div class="form-group">
        <label for="code">{{translate('Code')}}</label>
        <input type="text" class="form-control" id="code" name="code" placeholder="{{translate('Enter Language Code')}}">
    </div>
</x-dynamic-form-modal>
<!-- /create language-->


<!-- update language-->
<x-dynamic-form-modal route="{{route('languages.update')}}" id="updateLang" title="{{translate('Update Language')}}" execute_btn_name="{{translate('Update')}}" execute_btn_class="btn-success">
    <input type="hidden" name="id" id="update-id">
    <div class="form-group">
        <label for="name">{{translate('Name')}}</label>
        <input type="text" class="form-control" id="update-name" name="name" placeholder="{{translate('Enter Language Name')}}">
    </div>
    <div class="form-group">
        <label for="code">{{translate('Code')}}</label>
        <input type="text" class="form-control" id="update-code" name="code" placeholder="{{translate('Enter Language Code')}}">
    </div>
</x-dynamic-form-modal>
<!-- /update language-->

<!-- delete language-->
<x-dynamic-form-modal route="{{route('languages.delete')}}" modal_type="modal-sm" id="deleteLang" title="{{translate('Delete Language')}}" execute_btn_name="{{translate('Delete')}}" execute_btn_class="btn-danger">
    <input type="hidden" name="id" id="delete-id">
    <span>{{translate('Are you sure, you want to delete this language?')}}</span>
</x-dynamic-form-modal>
<!-- /delete language-->

@endsection

@push('script')
<script src="{{asset('pos/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('pos/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('pos/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('pos/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>

<script>
    $(function() {
        'use strict'
        $("#language").DataTable()

        $('.update-lang').click(function() {
            const id = $(this).data('id')
            const name = $(this).data('name')
            const code = $(this).data('code')

            $('#update-name').val(name)
            $('#update-code').val(code)
            $('#update-id').val(id)
        })

        $('.delete-lang').click(function() {
            const id = $(this).data('id')
            $('#delete-id').val(id)
        })

        $('.change-rtl-status').change(function() {
            const id = $(this).data('id')
            var postData = {
                _token: '{{csrf_token()}}',
                id: id,
            };
            $.post('{{route("update.language.rtl.status")}}', postData, function(response) {
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