@foreach($media as $file)
<div class="col-sm-1">
    <div class="align-items-center d-flex img-container justify-content-center mb-1">
        <img src="{{asset($file->file_location)}}" alt="Thumbnail">
    </div>
</div>
@endforeach