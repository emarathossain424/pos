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
<div class="col-md-1 d-flex align-items-center m-1 image-container">
    @if($file->file_extension == 'zip')
    <img src="{{asset('assets/images/zip.png')}}" alt="Thumbnail" class="img-fluid" data-details="{{$file_details}}" id="file-details-{{$file->id}}">
    @elseif($file->file_extension == 'pdf')
    <img src="{{asset('assets/images/pdf.png')}}" alt="Thumbnail" class="img-fluid" data-details="{{$file_details}}" id="file-details-{{$file->id}}">
    @elseif($file->file_extension == 'mp4')
    <img src="{{asset('assets/images/multimedia.png')}}" alt="Thumbnail" class="img-fluid" data-details="{{$file_details}}" id="file-details-{{$file->id}}">
    @elseif($file->file_extension == 'mp3')
    <img src="{{asset('assets/images/mic.png')}}" alt="Thumbnail" class="img-fluid" data-details="{{$file_details}}" id="file-details-{{$file->id}}">
    @else
    <img src="{{asset($file->file_location)}}" alt="Thumbnail" class="img-fluid" data-details="{{$file_details}}" id="file-details-{{$file->id}}">
    @endif
</div>
@endforeach