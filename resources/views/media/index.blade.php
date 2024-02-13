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

    .library .image-container:hover {
        border: 4px solid #e83e8c;
    }

    .file-details {
        font-size: 13px;
    }

    .file-details .title {
        font-weight: bold;
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
                            <button class="btn btn-link ml-2" id="show-more" {{$media->currentPage()==$media->lastPage()?'disabled':''}}>
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

        let page = 1
        let item = 22
        const lastPage = '{{$media->lastPage()}}'

        let selected_files = []

        $('#bulk-delete').hide()

        //paginate and show more
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
                    let file_container = $('.library').children('div')
                    let currently_showing = file_container.length
                    let pagination_message = "{{translate('Showing')}} " + currently_showing + " {{translate('of')}} {{$media->total()}} {{translate('itmes')}}" 

                    $('#pagination-message').html(pagination_message)
                    
                    if (lastPage == page) {
                        $('#show-more').attr('disabled', true);
                    }
                })
                .fail(function(error) {
                    console.error('Error:', error.statusText);
                });
        })

        //Showing single file details
        $('.library').on('click', '.image-container img', function(event) {
            let file_details = $(this).data('details')
            if (event.ctrlKey) {
                let file_id = file_details.file_id
                if (selected_files.includes(file_id)) {
                    $(this).closest('.image-container').removeAttr('style');
                    let index = selected_files.indexOf(file_id)
                    selected_files.splice(index, 1)
                } else {
                    selected_files.push(file_id)
                    $(this).closest('.image-container').css('border', '4px solid #e83e8c');
                }

                if (selected_files.length > 0) {
                    $('#bulk-delete').show()
                } else {
                    $('#bulk-delete').hide()
                }

                console.log(selected_files)
            } else {
                console.log(file_details)
                $('#file-name').html(file_details.file_name)
                $('#file-url').val(file_details.file_url)
                $('#file-type').html(file_details.file_type)
                $('#file-size').html(file_details.file_size)
                $('#file-uploaded-by').html(file_details.file_uploaded_by)
                $('#file-uploaded-at').html(file_details.file_uploaded_at)
                $('#file_id').val(file_details.file_id)

                $('#download-file').attr('href', file_details.file_url)

                switch (file_details.file_extension) {
                    case 'zip':
                        $('#orig-image').attr('src', "{{asset('assets/images/zip.png')}}")
                        break;
                    case 'pdf':
                        $('#orig-image').attr('src', "{{asset('assets/images/pdf.png')}}")
                        break;
                    case 'mp4':
                        $('#orig-image').attr('src', "{{asset('assets/images/multimedia.png')}}")
                        break;
                    case 'mp3':
                        $('#orig-image').attr('src', "{{asset('assets/images/mic.png')}}")
                        break;
                    default:
                        $('#orig-image').attr('src', file_details.file_url)
                        break;
                }



                // Assuming you want to add these attributes to an element with class 'some-element'
                $('#file-details-' + file_details.file_id).attr('data-toggle', 'modal').attr('data-target', '#single-file-details-modal');
            }
        })

        // Copy to clip board
        $('#copy').on('click', function() {
            let inputField = $('#file-url');
            inputField.select();
            document.execCommand('copy');
        });

        $('#bulk-delete').on('click', function() {
            $.ajax({
                url: "{{route('delete.files.from.media.in.bulk')}}",
                method: 'POST',
                data: {
                    _token:'{{csrf_token()}}',
                    files:selected_files.join(',')
                },
                success: function(response) {
                    if(response.success){
                        toastr.success('Selected files deleted successfully', 'Success');
                        $('#bulk-delete').hide()
                        location.reload()
                    }
                },
                error: function(xhr, status, error) {
                    toastr.error('Unable to delete files', 'Error');
                }
            });

        })

        //Initializig dropzone
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