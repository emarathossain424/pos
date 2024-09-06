@php
    $active_menu_list = ['all.halls','create.hall','update.hall','delete.hall','all.tables','create.table','update.table','delete.table'];
    $is_active = in_array(Route::currentRouteName(), $active_menu_list);
@endphp
<li class="nav-item">
    <a href="{{route('all.halls')}}" class="nav-link {{$is_active? 'active':'' }}">
    <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="#5f6368"><path d="M180-600h600l-38-96H218l-38 96Zm300-48Zm192 120H277l-13 72h421l-13-72ZM144-192l61-336h-61q-26 0-41-21.5T99-594l58-144q6-14 18-22t27-8h556q15 0 27 8t18 22l58 144q11 23-4 44.5T816-528h-72l61 336h-72l-35-192H251l-35 192h-72Z"/></svg>
        <p>
            {{translate('Hall & Tables')}}
        </p>
    </a>
</li>