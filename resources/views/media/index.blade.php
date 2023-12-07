@extends('layouts.master')
@section('title') {{translate('Media Library')}} @endsection
@push('css')
<link rel="stylesheet" href="{{asset('pos/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('pos/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('pos/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
<style>
    h1 {
        text-align: center;
    }

    .dropzone {
        background: white;
        border-radius: 5px;
        border: 2px dashed rgb(0, 135, 247);
        border-image: none;
        margin-left: auto;
        margin-right: auto;
    }
</style>
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
        <div class="row mt-3">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h5 class="m-0">{{ translate('Media Library') }}</h5>
                    </div>
                    <div class="card-body library">

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
        initDropZone()

        function initDropZone() {
            Dropzone.autoDiscover = false;

            $("#demo-upload").dropzone({
                url: `{{route('media.upload')}}`,
                parallelUploads: 2,
                thumbnailHeight: 120,
                thumbnailWidth: 120,
                maxFilesize: 3,
                filesizeBase: 1000,
                success: function(file, response) {
                    var thumbnailElement = document.createElement('img');
                    thumbnailElement.src = response.path;
                    document.querySelector('.library').appendChild(thumbnailElement);
                },
            });

            var minSteps = 6,
                maxSteps = 60,
                timeBetweenSteps = 100,
                bytesPerStep = 100000;

            dropzone.uploadFiles = function(files) {
                var self = this;

                for (var i = 0; i < files.length; i++) {
                    var file = files[i];
                    var totalSteps = Math.round(Math.min(maxSteps, Math.max(minSteps, file.size / bytesPerStep)));

                    for (var step = 0; step < totalSteps; step++) {
                        var duration = timeBetweenSteps * (step + 1);
                        setTimeout(
                            (function(file, totalSteps, step) {
                                return function() {
                                    file.upload = {
                                        progress: 100 * (step + 1) / totalSteps,
                                        total: file.size,
                                        bytesSent: (step + 1) * file.size / totalSteps,
                                    };

                                    self.emit('uploadprogress', file, file.upload.progress, file.upload.bytesSent);
                                    if (file.upload.progress == 100) {
                                        file.status = Dropzone.SUCCESS;
                                        self.emit('success', file, 'success', null);
                                        self.emit('complete', file);
                                        self.processQueue();
                                    }
                                };
                            })(file, totalSteps, step),
                            duration
                        );
                    }
                }
            };
        }
    });
</script>
@endpush