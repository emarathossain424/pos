@php
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
    <li class="breadcrumb-item active">{{translate('Categories')}}</li>
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
                        <h5 class="m-0">{{ translate('Categories') }}</h5>
                        <div class="ml-auto">
                            <a class="btn btn-primary" href="{{route('add.category')}}">{{translate('Create')}}</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="example2" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{translate('Iamge')}}</th>
                                    <th>{{translate('Name')}}</th>
                                    <th>{{translate('Parent')}}</th>
                                    <th>{{translate('Action')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($categories as $key=>$category)
                                @php
                                $key = $key+1;
                                @endphp
                                <tr>
                                    <td>{{$key}}.</td>
                                    <td>
                                        <img src="/{{ getFilePath($category->image) }}" alt="category-image" class="img-fluid" style="max-width: 50px; max-height: 50px;">
                                    </td>
                                    <td>{{ $category->name }}</td>
                                    @if (!empty($category->parentCategory))
                                    <td>{{ $category->parentCategory->name }}</td>
                                    @else
                                    <td>
                                        <i class="fa fa-ban"></i>
                                    </td>
                                    @endif
                                    <td>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-default">{{translate('Action')}}</button>
                                            <button type="button" class="btn btn-default dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                                <span class="sr-only">Toggle Dropdown</span>
                                            </button>
                                            <div class="dropdown-menu" role="menu">
                                                <a class="dropdown-item" href="{{route('edit.category',$category->id)}}">{{translate('Edit')}}</a>
                                                <a class="dropdown-item delete-category" href="#" data-id="{{$category->id}}" data-toggle="modal" data-target="#deleteCategory">{{translate('Delete')}}</a>
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

<!-- delete category-->
<x-dynamic-form-modal route="{{route('delete.category')}}" modal_type="modal-sm" id="deleteCategory" title="{{translate('Delete Category')}}" execute_btn_name="{{translate('Delete')}}" execute_btn_class="btn-danger">
    <input type="hidden" name="id" id="delete-id">
    <span>{{translate('Are you sure, you want to delete this category?')}}</span>
</x-dynamic-form-modal>
<!-- /delete category-->

@endsection

@push('script')
<script src="{{asset('pos/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('pos/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('pos/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('pos/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>

<script>
    $(function() {
        'use strict'

        $('.delete-category').click(function() {
            const id = $(this).data('id')
            $('#delete-id').val(id)
        })
    });
</script>
@endpush