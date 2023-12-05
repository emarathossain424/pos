@php
@endphp
@extends('layouts.master')
@section('title') {{translate('Translations')}} @endsection
@push('css')
<link rel="stylesheet" href="{{asset('pos/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('pos/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('pos/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
@endpush
@section('breadcrumb')
<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"><a href="#">{{translate('Dashboard')}}</a></li>
    <li class="breadcrumb-item active">{{translate('Translate')}}</li>
</ol>
@endsection
@section('content')
<div class="content">
    <div class="container-fluid">
        <x-alert column="col-md-6" alert_type="alert-warning" />
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h5 class="m-0">{{ translate('Translate') }}</h5>
                    </div>
                    <div class="card-body">
                        <table id="language" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{translate('Key')}}</th>
                                    <th>{{translate('Value')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $index = 1;
                                @endphp
                                @foreach($translations as $key=>$value)
                                <tr>
                                    <td>{{$index}}.</td>
                                    <td>{{$key}}</td>
                                    <td>
                                        <form action="{{route('update.translations')}}" method="post">
                                            @csrf
                                            <input type="hidden" name="code" value="{{$code}}">
                                            <input type="hidden" name="key" value="{{$key}}">
                                            <div class="row">
                                                <div class="form-group col-md-10">
                                                    <input type="text" class="form-control" name="value" value="{{translate($key,$code)}}">
                                                </div>
                                                <div class="col-md-2">
                                                    <button type="submit" class="btn btn-success">{{translate('Save')}}</button>
                                                </div>
                                            </div>
                                        </form>
                                    </td>
                                </tr>
                                @php
                                $index++;
                                @endphp
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
        $("#language").DataTable()
    });
</script>
@endpush