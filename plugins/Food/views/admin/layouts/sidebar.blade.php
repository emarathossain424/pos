@php
    $active_menu_list = ['categories','add.category','edit.category','variations','properties','food.items','add.food.items','edit.food.item'];
    $is_active = in_array(Route::currentRouteName(), $active_menu_list);
@endphp
<li class="nav-item {{$is_active? 'menu-open':'' }}">
    <a href="#" class="nav-link {{$is_active? 'active':'' }}">
    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#5f6368"><path d="M160-120q-33 0-56.5-23.5T80-200v-120h800v120q0 33-23.5 56.5T800-120H160Zm0-120v40h640v-40H160Zm320-180q-36 0-57 20t-77 20q-56 0-76-20t-56-20q-36 0-57 20t-77 20v-80q36 0 57-20t77-20q56 0 76 20t56 20q36 0 57-20t77-20q56 0 77 20t57 20q36 0 56-20t76-20q56 0 79 20t55 20v80q-56 0-75-20t-55-20q-36 0-58 20t-78 20q-56 0-77-20t-57-20ZM80-560v-40q0-115 108.5-177.5T480-840q183 0 291.5 62.5T880-600v40H80Zm400-200q-124 0-207.5 31T166-640h628q-23-58-106.5-89T480-760Zm0 520Zm0-400Z"/></svg>
        <p>
            {{translate('Foods')}}
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            @php
                $active_menu_list = ['categories','add.category','edit.category'];
                $is_active = in_array(Route::currentRouteName(), $active_menu_list);
            @endphp
            <a href="{{route('categories')}}" class="nav-link {{$is_active? 'active':'' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>{{translate('Categories')}}</p>
            </a>
        </li>
        <li class="nav-item">
            @php
                $active_menu_list = ['variations'];
                $is_active = in_array(Route::currentRouteName(), $active_menu_list);
            @endphp
            <a href="{{route('variations')}}" class="nav-link {{$is_active? 'active':'' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>{{translate('Variations')}}</p>
            </a>
        </li>
        <li class="nav-item">
            @php
                $active_menu_list = ['properties'];
                $is_active = in_array(Route::currentRouteName(), $active_menu_list);
            @endphp
            <a href="{{route('properties')}}" class="nav-link {{$is_active? 'active':'' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>{{translate('Properties')}}</p>
            </a>
        </li>
        <li class="nav-item">
            @php
                $active_menu_list = ['food.items'];
                $is_active = in_array(Route::currentRouteName(), $active_menu_list);
            @endphp
            <a href="{{route('food.items')}}" class="nav-link {{$is_active? 'active':'' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>{{translate('Food items')}}</p>
            </a>
        </li>
    </ul>
</li>