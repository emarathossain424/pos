@props([
'id',
'title',
'execute_btn_name',
'execute_btn_class',
'route',
'modal_type'=>'',
'show_header'=>true,
'show_footer'=>true,
'modal_header_class'
])
<!-- Modal -->
<div class="modal fade" id="{{ $id }}" tabindex="-1" role="dialog" aria-labelledby="{{$id}}Label" aria-hidden="true">
  <div class="modal-dialog {{$modal_type}}" role="document">
    <form action="{{$route}}" method="post">
      @csrf
      <div class="modal-content">
        @if ($show_header)
        <div class="modal-header {{isset($modal_header_class)??$modal_header_class}}">
          <h5 class="modal-title" id="exampleModalLabel">{{$title}}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        @endif

        <div class="modal-body">{{$slot}}</div>

        @if ($show_footer)
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">{{translate('Close')}}</button>
          <button type="submit" class="btn {{$execute_btn_class}}">{{$execute_btn_name}}</button>
        </div>
        @endif
      </div>
    </form>
  </div>
</div>