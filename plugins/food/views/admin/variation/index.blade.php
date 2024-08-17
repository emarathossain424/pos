@php
$languages = getAllLanguages();
$default_lang = getGeneralSettingsValue('default_lang');
$translatedLang = isset(request()->lang)?request()->lang:$default_lang;
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
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-sm btn-outline-dark">{{ $option->option_name }}</button>
                                            <button type="button" class="btn btn-sm btn-outline-dark dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                <span class="sr-only">Toggle Dropdown</span>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item update-option" href="#" data-id="{{$option->id}}" data-name="{{$option->option_name}}" data-toggle="modal" data-target="#updateOption">{{translate('Edit')}}</a>
                                                <a class="dropdown-item delete-option" href="#" data-id="{{$option->id}}" data-toggle="modal" data-target="#deleteOption">{{translate('Delete')}}</a>
                                            </div>
                                        </div>
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
                                                <a class="dropdown-item add-option" href="#" data-id="{{$variant->id}}" data-toggle="modal" data-target="#addOption">{{translate('Add Option')}}</a>
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

<!-- update variant-->
<x-dynamic-form-modal route="{{route('update.variant')}}" modal_type="modal-md" id="updateVariant" title="{{translate('Edit Variant')}}" execute_btn_name="{{translate('Update')}}" execute_btn_class="btn-success">
    <input type="hidden" name="id" id="edit-id">
    <div class="form-group">
        <label for="translateInto">{{translate('Translate Into')}}</label>
        <select class="form-control select2 w-100" name="translate_into" id="variantTranslation">
            @foreach($languages as $lang)
            <option value="{{$lang->id}}" {{ $lang->id == $translatedLang ? 'selected' : '' }}>{{$lang->name}}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label for="variant-name">{{translate('Variant Name')}}</label>
        <input type="text" class="form-control" id="edit-variant-name" placeholder="Enter variant name" name="variant_name">
    </div>
</x-dynamic-form-modal>
<!-- /update variant-->

<!-- delete option-->
<x-dynamic-form-modal route="{{route('delete.option')}}" modal_type="modal-sm" id="deleteOption" title="{{translate('Delete Option')}}" execute_btn_name="{{translate('Delete')}}" execute_btn_class="btn-danger">
    <input type="hidden" name="id" id="delete-option-id">
    <span>{{translate('Are you sure, you want to delete this option?')}}</span>
</x-dynamic-form-modal>
<!-- /delete option-->

<!-- update option-->
<x-dynamic-form-modal route="{{route('update.option')}}" modal_type="modal-md" id="updateOption" title="{{translate('Edit Option')}}" execute_btn_name="{{translate('Update')}}" execute_btn_class="btn-success">
    <input type="hidden" name="id" id="edit-option-id">
    <div class="form-group">
        <label for="translateInto">{{translate('Translate Into')}}</label>
        <select class="form-control select2 w-100" name="translate_into" id="optionTranslation">
            @foreach($languages as $lang)
            <option value="{{$lang->id}}" {{ $lang->id == $translatedLang ? 'selected' : '' }}>{{$lang->name}}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label for="option-name">{{translate('Option Name')}}</label>
        <input type="text" class="form-control" id="edit-option-name" placeholder="Enter option name" name="option_name">
    </div>
</x-dynamic-form-modal>
<!-- /update variant-->

<!-- add option-->
<x-dynamic-form-modal route="{{route('add.option')}}" modal_type="modal-md" id="addOption" title="{{translate('Add Option')}}" execute_btn_name="{{translate('Save')}}" execute_btn_class="btn-success">
    <input type="hidden" name="variant_id" id="variant-id">
    <div class="form-group">
        <label for="option-name">{{translate('Option Name')}}</label>
        <input type="text" class="form-control" id="variant-name" placeholder="Enter option name" name="option_name">
    </div>
</x-dynamic-form-modal>
<!-- /add option-->

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

        $('.add-option').click(function() {
            const id = $(this).data('id')
            $('#variant-id').val(id)
        })

        $('.update-option').click(function() {
            const id = $(this).data('id')
            const name = $(this).data('name')
            $('#edit-option-id').val(id)
            $('#edit-option-name').val(name)
        })

        $('.delete-option').click(function() {
            const id = $(this).data('id')
            $('#delete-option-id').val(id)
        })

        $('#variantTranslation').change(() => {
            const lang_id = $('#variantTranslation').val()
            const id = $('#edit-id').val()
            $.ajax({
                url: "{{ route('get.variant.translation') }}",
                type: 'GET',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: id,
                    lang_id: lang_id,
                },
                success: function(response) {
                    if (response.success == 1) {
                        $('#edit-variant-name').val(response.data.name)
                    }
                }
            })
        })

        $('#optionTranslation').change(() => {
            const lang_id = $('#optionTranslation').val()
            const id = $('#edit-option-id').val()
            $.ajax({
                url: "{{ route('get.option.translation') }}",
                type: 'GET',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: id,
                    lang_id: lang_id,
                },
                success: function(response) {
                    if (response.success == 1) {
                        $('#edit-option-name').val(response.data.name)
                    }
                }
            })
        })
    });
</script>
@endpush