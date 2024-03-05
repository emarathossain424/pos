<script src="{{asset('pos/plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('pos/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('pos/dist/js/adminlte.min.js')}}"></script>
<script src="http://cdn.bootcss.com/jquery/2.2.4/jquery.min.js"></script>
<script src="http://cdn.bootcss.com/toastr.js/latest/js/toastr.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.3.0/dropzone.js"></script>
{!! Toastr::message() !!}
@stack('script')
<script>
    $(function() {
        'use strict'

        let selected_files_for_delete = []
        let selected_file_id_to_use = []
        let selected_file_details_to_use = []

        let is_for_multi_select = false

        let target_input_field_id = ''
        let target_image_container_id = ''

        $('#bulk-delete').hide()

        //--Media Library Start--
        //paginate and show more
        $(document).on('click', '#show-more', function() {
            let page = parseInt($(this).data('page')) + 1
            let item = $(this).data('item')
            let lastPage = $(this).data('lastpage')
            let total = $(this).data('total')

            const route = `{{route("paginate.media.library")}}`
            const postData = {
                '_token': '{{csrf_token()}}',
                'page': page,
                'item': item,
                'selected_file': selected_file_id_to_use
            }
            $.post(route, postData, function(response) {
                    $('.library').append(response);
                    let file_container = $('.library').children('div')
                    let currently_showing = file_container.length
                    let pagination_message = "{{translate('Showing')}} " + currently_showing + " {{translate('of')}} " + total + " {{translate('itmes')}}"

                    $('#pagination-message').html(pagination_message)
                    $(this).data('page', page);
                    $(this).data('item', item);

                    if (lastPage == page) {
                        $('#show-more').attr('disabled', true);
                    }
                })
                .fail(function(error) {
                    console.error('Error:', error.statusText);
                });
        })

        //Showing single file details and hide or show delete button
        $('.library').on('click', '.image-container img', function(event) {
            let file_details = $(this).data('details')
            if (event.ctrlKey) {
                let file_id = file_details.file_id
                if (selected_files_for_delete.includes(file_id)) {
                    $(this).closest('.image-container').removeClass('active-image');
                    let index = selected_files_for_delete.indexOf(file_id)
                    selected_files_for_delete.splice(index, 1)
                } else {
                    selected_files_for_delete.push(file_id)
                    $(this).closest('.image-container').addClass('active-image');
                }

                if (selected_files_for_delete.length > 0) {
                    $('#bulk-delete').show()
                } else {
                    $('#bulk-delete').hide()
                }
            } else {
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

                $('#file-details-' + file_details.file_id).attr('data-toggle', 'modal').attr('data-target', '#single-file-details-modal');
            }
        })

        //bulk media file delete
        $('#bulk-delete').on('click', function() {
            $.ajax({
                url: "{{route('delete.files.from.media.in.bulk')}}",
                method: 'POST',
                data: {
                    _token: '{{csrf_token()}}',
                    files: selected_files_for_delete.join(',')
                },
                success: function(response) {
                    if (response.success) {
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

        // Copy to clip board
        $('#copy').on('click', function() {
            let inputField = $('#file-url');
            inputField.select();
            document.execCommand('copy');
        });
        //--Media Library End--

        //--Media Library In Modal Start--
        //STEP01: browse media file
        $('.browse-file').click(function() {
            target_input_field_id = "#" + $(this).data('inputid')
            target_image_container_id = "#" + $(this).data('imagecontainerid')
            is_for_multi_select = $(this).data('isformultiselect')

            let already_selected_file = $(target_input_field_id).val();
            if (already_selected_file.length == 0) {
                $('.use-files').hide()
            }

            const route = `{{route("get.media.for.library")}}`
            const postData = {
                '_token': '{{csrf_token()}}',
                'selected_file': selected_file_id_to_use
            }
            $.post(route, postData, function(response) {
                $('.modal-body').html(response)
            }).fail(function(error) {
                console.error('Error:', error.statusText);
            });
        })

        //STEP02: Select file from library inside form 
        $(document).on('click', '#media-library .library .image-container img', function() {
            let file_details = $(this).data('details')
            let file_id = file_details.file_id

            if (event.ctrlKey && is_for_multi_select == 1) {
                if (selected_file_id_to_use.includes(file_id)) {
                    $(this).closest('.image-container').removeClass('active-image');
                    let index = selected_file_id_to_use.indexOf(file_id)
                    selected_file_id_to_use.splice(index, 1)
                    selected_file_details_to_use.splice(index, 1)
                } else {
                    selected_file_id_to_use.push(file_id)
                    selected_file_details_to_use.push(file_details)
                    $(this).closest('.image-container').addClass('active-image');
                }
            } else {
                $("#media-library .library .image-container").each(function() {
                    $(this).removeClass('active-image');
                });
                $(this).closest('.image-container').addClass('active-image');
                selected_file_id_to_use = []
                selected_file_details_to_use = []

                selected_file_id_to_use[0] = file_id
                selected_file_details_to_use[0] = file_details
            }

            if (selected_file_id_to_use.length > 0) {
                $('.use-files').show()
            } else {
                $('.use-files').hide()
            }
        })

        //STEP03: Use fles
        $(document).on('click', '.use-files', function() {
            showSelectedFiles()
        })

        //STEP04: Delete selected files
        $(document).on('click', '.delete-selection', function() {
            let file_to_remove_id = $(this).data('fileid')
            target_input_field_id = $(this).data('targetinputfield')
            target_image_container_id = $(this).data('targetimagecontainerid')

            selected_file_details_to_use = JSON.parse($(target_input_field_id).data('filedetails'))
            selected_file_id_to_use = $(target_input_field_id).val().split(',')

            console.log("before")
            console.log(selected_file_details_to_use)
            console.log(selected_file_id_to_use)

            selected_file_details_to_use = selected_file_details_to_use.filter(function(file) {
                if (file.file_id != file_to_remove_id) {
                    return true
                }
            })

            selected_file_id_to_use = selected_file_id_to_use.filter(function(file_id) {
                if (file_id != file_to_remove_id) {
                    return true
                }
            })

            console.log("after")
            console.log(selected_file_details_to_use)
            console.log(selected_file_id_to_use)

            showSelectedFiles()
        })

        function showSelectedFiles() {
            let html = ''

            console.log("Inside")
            console.log(selected_file_details_to_use)
            console.log(selected_file_id_to_use)

            if (selected_file_details_to_use.length > 0) {
                selected_file_details_to_use.forEach(function(file) {
                    switch (file.file_extension) {
                        case 'zip':
                            html = html + `<div class="form-image-container col-2 m-2">
                                            <div class="image-wrapper">
                                                <img src="{{asset('assets/images/zip.png')}}" class="img-fluid p-2" alt="Selected Category Image">
                                                <div class="delete-button">
                                                    <button type="button" class="btn btn-sm delete-selection" data-fileid="` + file.file_id + `" data-targetinputfield="` + target_input_field_id + `"  data-targetimagecontainerid="` + target_image_container_id + `">
                                                        <i class="far fa-times-circle"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>`
                            break;
                        case 'pdf':
                            html = html + `<div class="form-image-container col-2 m-2">
                                            <div class="image-wrapper">
                                                <img src="{{asset('assets/images/pdf.png')}}" class="img-fluid p-2" alt="Selected Category Image">
                                                <div class="delete-button">
                                                    <button type="button" class="btn btn-sm delete-selection" data-fileid="` + file.file_id + `" data-targetinputfield="` + target_input_field_id + `"  data-targetimagecontainerid="` + target_image_container_id + `">
                                                        <i class="far fa-times-circle"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>`
                            break;
                        case 'mp4':
                            html = html + `<div class="form-image-container col-2 m-2">
                                            <div class="image-wrapper">
                                                <img src="{{asset('assets/images/multimedia.png')}}" class="img-fluid p-2" alt="Selected Category Image">
                                                <div class="delete-button">
                                                    <button type="button" class="btn btn-sm delete-selection" data-fileid="` + file.file_id + `" data-targetinputfield="` + target_input_field_id + `"  data-targetimagecontainerid="` + target_image_container_id + `">
                                                        <i class="far fa-times-circle"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>`
                            break;
                        case 'mp3':
                            html = html + `<div class="form-image-container col-2 m-2">
                                            <div class="image-wrapper">
                                                <img src="{{asset('assets/images/mic.png')}}" class="img-fluid p-2" alt="Selected Category Image">
                                                <div class="delete-button">
                                                    <button type="button" class="btn btn-sm delete-selection" data-fileid="` + file.file_id + `" data-targetinputfield="` + target_input_field_id + `"  data-targetimagecontainerid="` + target_image_container_id + `">
                                                        <i class="far fa-times-circle"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>`
                            break;
                        default:
                            html = html + `<div class="form-image-container col-2 m-2">
                                            <div class="image-wrapper">
                                                <img src="` + file.file_url + `" class="img-fluid p-2" alt="Selected Category Image">
                                                <div class="delete-button">
                                                    <button type="button" class="btn btn-sm delete-selection" data-fileid="` + file.file_id + `" data-targetinputfield="` + target_input_field_id + `"  data-targetimagecontainerid="` + target_image_container_id + `">
                                                        <i class="far fa-times-circle"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>`
                            break;
                    }

                    $(target_image_container_id).html(html)
                    $(target_input_field_id).val(selected_file_id_to_use.join(','))
                    $(target_input_field_id).data("filedetails", JSON.stringify(selected_file_details_to_use));
                })
            } else {
                let html = `<div class="form-image-container col-2 m-2">
                                            <div class="image-wrapper">
                                                <img src="{{asset($placeholder)}}" class="img-fluid" alt="black sample">
                                            </div>
                                        </div>`
                $(target_image_container_id).html(html)
                $(target_input_field_id).val(selected_file_id_to_use.join(','))
                $(target_input_field_id).data("filedetails", '');
            }
            console.log($(target_input_field_id).data("filedetails"))
            console.log(target_input_field_id)
        }
        //--Media Library In Modal End--
    });

    //Initializig dropzone
    function initDropZone() {
        'use strict'

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
</script>