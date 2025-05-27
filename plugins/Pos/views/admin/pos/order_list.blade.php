@php
@endphp
@extends('layouts.master')
@section('title') {{translate('Orders')}} @endsection
@push('css')
<link rel="stylesheet" href="{{asset('pos/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('pos/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('pos/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
@endpush
@section('breadcrumb')
<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"><a href="#">{{translate('Dashboard')}}</a></li>
    <li class="breadcrumb-item active">{{translate('Orders')}}</li>
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
                        <h5 class="m-0">{{ translate('Orders') }}</h5>
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
                                    <th>{{translate('Token')}}</th>
                                    <th>{{translate('Customer Name')}}</th>
                                    <th>{{translate('Payment Type')}}</th>
                                    <th>{{translate('Order Status')}}</th>
                                    <th>{{translate('Discount')}}</th>
                                    <th>{{translate('Subtotal')}}</th>
                                    <th>{{translate('Total')}}</th>
                                    <th>{{translate('Action')}}</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>

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
