@php
$all_categories = [];
$placeholder = getPlaceholderImagePath();
@endphp
@extends('layouts.master')
@section('title') {{translate('Categories')}} @endsection
@push('css')
<link rel="stylesheet" href="{{asset('pos/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('pos/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('pos/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
@endpush
@section('breadcrumb')
<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"><a href="#">{{translate('Dashboard')}}</a></li>
    <li class="breadcrumb-item active">{{translate('Create Category')}}</li>
</ol>
@endsection
@section('content')
<div class="content">
    <div class="container-fluid">
        <x-alert column="col-md-12" alert_type="alert-warning" />
        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h5 class="m-0">{{ translate('Add Category') }}</h5>
                    </div>
                    <div class="card-body">
                        <form>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="category-name">{{translate('Category Name')}}</label>
                                    <input type="text" class="form-control" id="category-name" placeholder="Enter category name">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Password</label>
                                    <select class="form-control select2" style="width: 100%;">
                                        <option selected="selected">Alabama</option>
                                        <option>Alaska</option>
                                        <option>California</option>
                                        <option>Delaware</option>
                                        <option>Tennessee</option>
                                        <option>Texas</option>
                                        <option>Washington</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="category-image">{{translate('Category Image')}}</label>
                                    <input type="hidden" name="category_image" id="category-image-input">
                                    <div class="form-image-container col-2">
                                        <img src="{{asset($placeholder)}}" class="img-fluid p-2" alt="black sample" id="category-image-view">
                                    </div>
                                    <button type="button" class="btn text-blue" data-toggle="modal" data-target="#media-library" data-inputid="category-image-input" data-imagecontainerid="category-image-view" id="browse-file">{{translate('Browse File')}}</button>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                    <label class="form-check-label" for="exampleCheck1">Check me out</label>
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn bg-pink">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @includeIf('media.include.media_modal')
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
    });
</script>
@endpush