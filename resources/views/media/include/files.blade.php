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