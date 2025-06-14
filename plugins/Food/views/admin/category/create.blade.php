@php
$all_categories = getFoodCategories();
$placeholder = getPlaceholderImagePath();
@endphp
@extends('layouts.master')
@section('title') {{translate('Categories')}} @endsection
@push('css')
<link rel="stylesheet" href="{{asset('pos/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('pos/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('pos/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('pos/plugins/select2/css/select2.min.css')}}">
<link rel="stylesheet" href="{{asset('pos/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">

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
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h5 class="m-0">{{ translate('Add Category') }}</h5>
            </div>
            <div class="card-body">
                <form method="post" action="{{route('store.category')}}">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="category-name">{{translate('Category Name')}} <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="category-name" name="category_name" placeholder="Enter category name">
                                @error('category_name')
                                <div>
                                    <span class="text-danger">{{ $message }}</span>
                                </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="exampleInputPassword1">{{translate('Parent Category')}}</label>
                                <select class="form-control select2 w-100" name="parent_category" id="parent-category">
                                    <option value="">{{translate('Select Parent')}}</option>
                                    @foreach($all_categories as $category)
                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <h6><strong>{{translate('Featured Status')}}</strong></h6>
                                <input type="checkbox" id="is-featured" name="featured_status" checked data-bootstrap-switch>
                            </div>

                            <div class="form-group">
                                <h6><strong>{{translate('Status')}}</strong></h6>
                                <input type="checkbox" id="status" name="status" checked data-bootstrap-switch>
                            </div>

                            <div class="form-group">
                                <label for="category-image">{{translate('Category Image')}} <span class="text-danger">*</span></label>
                                <input type="hidden" name="category_image" id="category-image-input">
                                <div class="row" id="category-image-view">
                                    <div class="form-image-container col-2 m-2">
                                        <div class="image-wrapper">
                                            <img src="{{asset($placeholder)}}" class="img-fluid" alt="black sample">
                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="btn text-blue browse-file" data-toggle="modal" data-target="#media-library" data-inputid="category-image-input" data-imagecontainerid="category-image-view" data-isformultiselect='0'>{{translate('Browse File')}}</button>
                                @error('category_image')
                                <div>
                                    <span class="text-danger">{{ $message }}</span>
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="meta-title">{{translate('Meta Title')}}</label>
                                <input type="text" class="form-control" id="meta-title" placeholder="Enter meta title" name="meta_title">
                            </div>

                            <div class="form-group">
                                <label for="meta-description">{{translate('Meta Description')}}</label>
                                <textarea class="form-control" rows="8" placeholder="Enter Meta Description" name="meta_description"></textarea>
                            </div>

                            <div class="form-group">
                                <label for="meta-image">{{translate('Meta Image')}}</label>
                                <input type="hidden" name="meta_image" id="meta-image-input">
                                <div class="row" id="meta-image-view">
                                    <div class="form-image-container col-2 m-2">
                                        <div class="image-wrapper">
                                            <img src="{{asset($placeholder)}}" class="img-fluid" alt="black sample">
                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="btn text-blue browse-file" data-toggle="modal" data-target="#media-library" data-inputid="meta-image-input" data-imagecontainerid="meta-image-view" data-isformultiselect='0'>{{translate('Browse File')}}</button>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn bg-pink btn-block w-25 bold">{{translate('Save')}}</button>
                    </div>
                </form>
            </div>
        </div>
        @includeIf('media.include.media_modal')
    </div>
</div>

@parent
@endsection

@push('script')
<script src="{{asset('pos/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('pos/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('pos/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('pos/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
<script src="{{asset('pos/plugins/bootstrap-switch/js/bootstrap-switch.min.js')}}"></script>
<script src="{{asset('pos/plugins/select2/js/select2.full.min.js')}}"></script>

<script>
    $(function() {
        'use strict'
        $("input[data-bootstrap-switch]").each(function() {
            $(this).bootstrapSwitch('state', $(this).prop('checked'));
        })

        $('#parent-category').select2({
            theme: 'bootstrap4'
        })
    });
</script>
@endpush