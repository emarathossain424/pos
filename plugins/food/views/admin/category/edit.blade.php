@php
$all_categories = getFoodCategories();
$placeholder = getPlaceholderImagePath();
$languages = getAllLanguages();
$default_lang = getGeneralSettingsValue('default_lang');
$translatedLang = isset(request()->lang)?request()->lang:$default_lang;
@endphp
@extends('layouts.master')
@section('title') {{translate('Categories')}} @endsection
@push('css')
<link rel="stylesheet" href="{{asset('pos/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('pos/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('pos/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('pos/plugins/select2/css/select2.min.css')}}">
<link rel="stylesheet" href="{{asset('pos/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
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
    <li class="breadcrumb-item active">{{translate('Create Category')}}</li>
</ol>
@endsection
@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h5 class="m-0">{{ translate('Update Category') }}</h5>
            </div>
            <div class="card-body">
                <form method="post" action="{{route('update.category')}}">
                    @csrf
                    <input type="hidden" name="id" value="{{$e_category->id}}">
                    <div class="row">
                        <div class="col-md-6">

                            <div class="form-group">
                                <label for="translateInto">{{translate('Translate Into')}}</label>
                                <select class="form-control select2 w-100" name="translate_into" id="translateInto">
                                    @foreach($languages as $lang)
                                    <option value="{{$lang->id}}" {{ $lang->id == $translatedLang ? 'selected' : '' }}>{{$lang->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="category-name">{{translate('Category Name')}} <span class="text-danger">*</span></label>
                                <input type="text" value="{{$e_category->name}}" class="form-control" id="category-name" name="category_name" placeholder="Enter category name">
                                @error('category_name')
                                <div>
                                    <span class="text-danger">{{ $message }}</span>
                                </div>
                                @enderror
                            </div>

                            <div class="form-group lang-indipendent-area">
                                <label for="parent-category">{{translate('Parent Category')}}</label>
                                <select class="form-control select2 w-100" name="parent_category" id="parent-category">
                                    <option value="">{{translate('Select Parent')}}</option>
                                    @foreach($all_categories as $category)
                                    <option value="{{$category->id}}" {{ $category->id == $e_category->parent ? 'selected' : '' }}>{{$category->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group lang-indipendent-area">
                                <h6><strong>{{translate('Featured Status')}}</strong></h6>
                                <input type="checkbox" id="is-featured" name="featured_status" {{ $e_category->featured_status == 1 ? 'checked' : '' }} data-bootstrap-switch>
                            </div>

                            <div class="form-group lang-indipendent-area">
                                <h6><strong>{{translate('Status')}}</strong></h6>
                                <input type="checkbox" id="status" name="status" {{ $e_category->status == 1 ? 'checked' : '' }} data-bootstrap-switch>
                            </div>

                            <div class="form-group lang-indipendent-area">
                                <label for="category-image">{{translate('Category Image')}} <span class="text-danger">*</span></label>
                                <input type="hidden" name="category_image" id="category-image-input" value="{{$e_category->image}}">
                                <div class="row" id="category-image-view">
                                    @if(!empty($e_category->image))
                                    <div class="form-image-container col-2 m-2">
                                        <div class="image-wrapper">
                                            <img src="{{asset(getFilePath($e_category->image))}}" class="img-fluid p-2" alt="Selected Category Image">
                                            <div class="delete-button">
                                                <button type="button" class="btn btn-sm delete-selection" data-fileid="{{$e_category->image}}" data-targetinputfield="#category-image-input" data-targetimagecontainerid="#category-image-view">
                                                    <i class="far fa-times-circle"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    @else
                                    <div class="form-image-container col-2 m-2">
                                        <div class="image-wrapper">
                                            <img src="{{asset($placeholder)}}" class="img-fluid" alt="black sample">
                                        </div>
                                    </div>
                                    @endif
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
                                <input type="text" value="{{$e_category->meta_title}}" class="form-control" id="meta-title" placeholder="Enter meta title" name="meta_title">
                            </div>

                            <div class="form-group">
                                <label for="meta-description">{{translate('Meta Description')}}</label>
                                <textarea class="form-control" rows="8" placeholder="Enter Meta Description" name="meta_description">
                                {{$e_category->meta_description}}
                                </textarea>
                            </div>

                            <div class="form-group lang-indipendent-area">
                                <label for="meta-image">{{translate('Meta Image')}}</label>
                                <input type="hidden" name="meta_image" id="meta-image-input" value="{{$e_category->image}}">
                                <div class="row" id="meta-image-view">
                                    @if(!empty($e_category->meta_image))
                                    <div class="form-image-container col-2 m-2">
                                        <div class="image-wrapper">
                                            <img src="{{asset(getFilePath($e_category->meta_image))}}" class="img-fluid p-2" alt="Selected Category Image">
                                            <div class="delete-button">
                                                <button type="button" class="btn btn-sm delete-selection" data-fileid="{{$e_category->meta_image}}" data-targetinputfield="#meta-image-input" data-targetimagecontainerid="#meta-image-view">
                                                    <i class="far fa-times-circle"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    @else
                                    <div class="form-image-container col-2 m-2">
                                        <div class="image-wrapper">
                                            <img src="{{asset($placeholder)}}" class="img-fluid" alt="black sample">
                                        </div>
                                    </div>
                                    @endif
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

        const default_lang = '{{$default_lang}}'
        let selected_lang = '{{$translatedLang}}'
        
        console.log(default_lang)
        console.log(selected_lang)

        if (selected_lang != default_lang) {
            $('.lang-indipendent-area').addClass('disabled-div')
        } else {
            $('.lang-indipendent-area').removeClass('disabled-div')
        }

        $("input[data-bootstrap-switch]").each(function() {
            $(this).bootstrapSwitch('state', $(this).prop('checked'));
        })

        $('#parent-category').select2({
            theme: 'bootstrap4'
        })

        $('#translateInto').select2({
            theme: 'bootstrap4'
        })

        $('#translateInto').change(function() {
            let selected_lang = $('#translateInto').val()

            // console.log(window.location)

            var currentBaseUrl = window.location.origin;
            var pathname = window.location.pathname
            var newUrl = currentBaseUrl + pathname + '?lang=' + selected_lang;
            window.location.href = newUrl;
        });



        let category_image = JSON.stringify([{
            'file_id': '{{$e_category->image}}'
        }])
        $('#category-image-input').data('filedetails', category_image)

        let meta_image = JSON.stringify([{
            'file_id': '{{$e_category->meta_image}}'
        }])
        $('#meta-image-input').data('filedetails', meta_image)
    });
</script>
@endpush