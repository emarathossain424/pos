@php
$selectedFileIdsArray = explode(',',$selectedFileIds);
@endphp
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
    <div class="col-md-1 d-flex align-items-center m-1 image-container {{in_array($file->id,$selectedFileIdsArray)?'active-image':''}}" id="file-details-{{$file->id}}" data-details="{{$file_details}}">
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
<div class="row mt-2 justify-content-center">
    <p id="pagination-message" class="mt-2">{{translate('Showing')}} {{$media->perPage()}} {{translate('of')}} {{$media->total()}} {{translate('itmes')}}</p>
    <button class="btn btn-link ml-2" id="show-more" {{$media->currentPage()==$media->lastPage()?'disabled':''}} data-lastPage='{{$media->lastPage()}}' data-total='{{$media->total()}}' data-page='1' data-item='20'>
        <strong>{{translate('Show More')}}</strong>
    </button>
</div>