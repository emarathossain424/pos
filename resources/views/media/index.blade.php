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

    .library {
        display: flex;
        flex-wrap: wrap;
        /* Allow items to wrap to the next row */
    }

    .library .image-container {
        background-color: #e2eaf1 !important;
    }

    .img-fluid {
        max-height: 100%;
        object-fit: cover;
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
                    <div class="card-body">
                        <!-- <div class="row library">
                            @foreach($media as $file)
                            <div>
                                <div class="align-items-center d-flex img-container justify-content-center mb-1">
                                    <img src="{{asset($file->file_location)}}" alt="Thumbnail">
                                </div>
                            </div>
                            @endforeach
                        </div> -->
                        <div class="row library">
                            @foreach($media as $file)
                            <div class="col-md-1 d-flex align-items-center m-1 image-container">
                                @if($file->file_extension == 'zip')
                                <img src="{{asset('assets/images/zip.png')}}" alt="Thumbnail" class="img-fluid">
                                @elseif($file->file_extension == 'pdf')
                                <img src="{{asset('assets/images/pdf.png')}}" alt="Thumbnail" class="img-fluid">
                                @elseif($file->file_extension == 'mp4')
                                <img src="{{asset('assets/images/multimedia.png')}}" alt="Thumbnail" class="img-fluid">
                                @elseif($file->file_extension == 'mp3')
                                <img src="{{asset('assets/images/mic.png')}}" alt="Thumbnail" class="img-fluid">
                                @else
                                <img src="{{asset($file->file_location)}}" alt="Thumbnail" class="img-fluid">
                                @endif
                            </div>
                            @endforeach
                        </div>
                        <div class="row mt-2 justify-content-center">
                            <button class="btn bg-gradient-gray" id="show-more" {{$media->currentPage()==$media->lastPage()?'disabled':''}}>{{translate('Show More')}}</button>
                        </div>
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

        let page = 1
        let item = 22
        const lastPage = '{{$media->lastPage()}}'

        $('#show-more').on('click', function() {
            page = page + 1
            const route = `{{route("paginate.media.library")}}`
            const postData = {
                '_token': '{{csrf_token()}}',
                'page': page,
                'item': item
            }
            $.post(route, postData, function(response) {
                    $('.library').append(response);
                    if (lastPage == page) {
                        $('#show-more').attr('disabled', true);
                    }
                })
                .fail(function(error) {
                    console.error('Error:', error.statusText);
                });
        })

        function initDropZone() {
            Dropzone.autoDiscover = false;

            $("#demo-upload").dropzone({
                url: `{{ route('media.upload') }}`,
                parallelUploads: 2,
                maxFilesize: 10, // in MB
                acceptedFiles: 'image/jpeg,image/png,image/bmp,application/pdf,application/zip,video/mp4,audio/mpeg,application/x-zip-compressed', // Allow images, PDFs, and ZIP files

                init: function() {
                    this.on('addedfile', function(file) {
                        // Check if the file type is allowed
                        var allowedTypes = this.options.acceptedFiles.split(',');
                        var fileType = file.type;
                        console.log(fileType)
                        if (!allowedTypes.includes(fileType)) {
                            toastr.error('Invalid file type. Allowed types: ' + this.options.acceptedFiles, 'Error');
                            this.removeFile(file);
                        }

                        // Check for the maximum number of parallel uploads
                        if (this.files.length > this.options.parallelUploads) {
                            toastr.error('Too many files. Maximum allowed: ' + this.options.parallelUploads, 'Error');
                            this.removeFile(file);
                        }
                    });

                    this.on('maxfilesexceeded', function(file) {
                        toastr.error('Max file size exceeded. Maximum allowed: ' + this.options.maxFilesize + 'MB', 'Error');
                        this.removeFile(file);
                    });

                    this.on('error', function(file, response) {
                        // Handle other errors here
                        toastr.error('Unable to upload file', 'Error');
                        this.removeFile(file);
                    });
                },

                success: function(file, response) {

                    var colDiv = document.createElement('div');
                    colDiv.className = 'col-md-1 d-flex align-items-center m-1 image-container';

                    var thumbnailElement = document.createElement('img');
                    thumbnailElement.src = response.path;
                    thumbnailElement.className = 'img-fluid';
                    thumbnailElement.alt = 'Thumbnail';

                    colDiv.appendChild(thumbnailElement);

                    // Get the reference to the first child of .library
                    var firstChild = document.querySelector('.library').firstChild;

                    // Insert colDiv before the first child
                    document.querySelector('.library').insertBefore(colDiv, firstChild);

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