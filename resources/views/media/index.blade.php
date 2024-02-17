@extends('layouts.master')
@section('title') {{translate('Media Library')}} @endsection
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
        <!-- Dropzone -->
        <section>
            <div id="dropzone">
                <form class="dropzone needsclick" id="demo-upload" action="/upload" method="post" enctype="multipart/form-data" name="media_file">
                    @csrf
                    <div class="dz-message needsclick">
                        <h4>{{translate('Drop files here or click to upload.')}}<br>
                            <span class="note needsclick">({{translate('This is just a demo dropzone. Selected files are not actually uploaded.')}})</span>
                        </h4>
                    </div>
                </form>
            </div>
        </section>
        <!-- /Dropzone -->

        <!-- Media library -->
        <div class="row mt-3">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h5 class="m-0">{{ translate('Media Library') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="row library">
                            @foreach($media as $file)
                            @php
                            $file_details = json_encode([
                            'file_name' => $file->name,
                            'file_url' => asset($file->file_location),
                            'file_type' => $file->file_type,
                            'file_size' => $file->file_size/1024 . " kb",
                            'file_uploaded_by' => $file->uploaded_by,
                            'file_uploaded_at' => $file->created_at,
                            'file_id' => $file->id,
                            'file_extension' => $file->file_extension
                            ]);

                            @endphp
                            <div class="col-md-1 d-flex align-items-center m-1 image-container" id="file-details-{{$file->id}}" data-details="{{$file_details}}">
                                @if($file->file_extension == 'zip')
                                <img src="{{asset('assets/images/zip.png')}}" alt="Thumbnail" class="img-fluid" id="file-details-{{$file->id}}" data-details="{{$file_details}}">
                                @elseif($file->file_extension == 'pdf')
                                <img src="{{asset('assets/images/pdf.png')}}" alt="Thumbnail" class="img-fluid" id="file-details-{{$file->id}}" data-details="{{$file_details}}">
                                @elseif($file->file_extension == 'mp4')
                                <img src="{{asset('assets/images/multimedia.png')}}" alt="Thumbnail" class="img-fluid" id="file-details-{{$file->id}}" data-details="{{$file_details}}">
                                @elseif($file->file_extension == 'mp3')
                                <img src="{{asset('assets/images/mic.png')}}" alt="Thumbnail" class="img-fluid" id="file-details-{{$file->id}}" data-details="{{$file_details}}">
                                @else
                                <img src="{{asset($file->file_location)}}" alt="Thumbnail" class="img-fluid" id="file-details-{{$file->id}}" data-details="{{$file_details}}">
                                @endif
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row mt-2 justify-content-between">
                            <p id="pagination-message">{{translate('Showing')}} {{$media->perPage()}} {{translate('of')}} {{$media->total()}} {{translate('itmes')}}</p>
                            <button class="btn btn-link ml-2" id="show-more" {{$media->currentPage()==$media->lastPage()?'disabled':''}} data-lastPage='{{$media->lastPage()}}' data-total='{{$media->total()}}' data-page='1' data-item='22'>
                                <strong>{{translate('Show More')}}</strong>
                            </button>
                            <button class="btn btn-outline-danger rounded-pill" id="bulk-delete">{{translate('Delete Selected Files')}}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Media library -->

        <!-- Single file details -->
        <div class="modal fade" id="single-file-details-modal">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <img src="/uploads/2023/12/1702140255_8917.jpg" alt="Thumbnail" class="img-fluid" id="orig-image">
                            </div>
                            <div class="col-md-6">
                                <div class="border-left h-100">
                                    <div class="file-details pl-3 pr-3">
                                        <span class="title">{{translate('File Name :')}}</span></strong>
                                        <span id="file-name"></span>
                                    </div>
                                    <div class="file-details pl-3 pr-3 pb-1">
                                        <span class="title">{{translate('File URL :')}}</span></strong>
                                        <input type="text" id="file-url" class="form-control-file">
                                    </div>
                                    <div class="file-details pl-3 pr-3">
                                        <span class="title">{{translate('File Type :')}}</span></strong>
                                        <span id="file-type"></span>
                                    </div>
                                    <div class="file-details pl-3 pr-3">
                                        <span class="title">{{translate('File Size :')}}</span></strong>
                                        <span id="file-size"></span>
                                    </div>
                                    <div class="file-details pl-3 pr-3">
                                        <span class="title">{{translate('Uploaded By :')}}</span></strong>
                                        <span id="file-uploaded-by"></span>
                                    </div>
                                    <div class="file-details pl-3 pr-3">
                                        <span class="title">{{translate('Uploaded At :')}}</span></strong>
                                        <span id="file-uploaded-at"></span>
                                    </div>
                                    <div class="d-flex">
                                        <a href="" class="btn text-pink" id="download-file">{{translate('Download')}}</a>
                                        <button class="btn text-blue" id="copy">{{translate('Copy to clipboard')}}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <form action="{{route('delete.file.from.media')}}" method="post">
                            @csrf
                            <input type="hidden" id="file_id" value="" name="id">
                            <button type="submit" class="btn btn-danger">{{translate('Delete')}}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Single file details -->
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
        initDropZone()
    });
</script>
@endpush