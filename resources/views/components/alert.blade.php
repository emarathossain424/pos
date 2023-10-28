@props([
'column'=>'',
'alert_type'=>''
])
<div class="row">
    <div class="{{$column}}">
        @if ($errors->any())
        @foreach ($errors->all() as $error)
        <div class="alert {{$alert_type}} alert-dismissible fade show" role="alert">
            <strong>{{translate('Oops!')}}</strong> {{$error}}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endforeach
        @endif
    </div>
</div>