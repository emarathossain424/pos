<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-light-pink elevation-4">
  <!-- Brand Logo -->
  <a href="index3.html" class="brand-link bg-pink">
    <img src="{{asset('pos/dist/img/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">AdminLTE 3</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="{{asset('pos/dist/img/user2-160x160.jpg')}}" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="#" class="d-block">Alexander Pierce</a>
      </div>
    </div>

    <!-- SidebarSearch Form -->
    <div class="form-inline">
      <div class="input-group" data-widget="sidebar-search">
        <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-sidebar">
            <i class="fas fa-search fa-fw"></i>
          </button>
        </div>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Media Library-->
        <li class="nav-item">
          <a href="{{route('media.library')}}" class="nav-link  {{Route::currentRouteName() == 'media.library'? 'active':'' }}">
            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#5f6368"><path d="M160-120q-33 0-56.5-23.5T80-200v-640l67 67 66-67 67 67 67-67 66 67 67-67 67 67 66-67 67 67 67-67 66 67 67-67v640q0 33-23.5 56.5T800-120H160Zm0-80h280v-240H160v240Zm360 0h280v-80H520v80Zm0-160h280v-80H520v80ZM160-520h640v-120H160v120Z"/></svg>
            <p>
              {{translate('Media Library')}}
            </p>
          </a>
        </li>
        <!-- Media Library-->

        <!-- Plugn -->
        <li class="nav-item">
          <a href="{{route('plugins.index')}}" class="nav-link {{Route::currentRouteName() == 'plugins.index'? 'active':'' }}">
          <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#5f6368"><path d="M352-120H200q-33 0-56.5-23.5T120-200v-152q48 0 84-30.5t36-77.5q0-47-36-77.5T120-568v-152q0-33 23.5-56.5T200-800h160q0-42 29-71t71-29q42 0 71 29t29 71h160q33 0 56.5 23.5T800-720v160q42 0 71 29t29 71q0 42-29 71t-71 29v160q0 33-23.5 56.5T720-120H568q0-50-31.5-85T460-240q-45 0-76.5 35T352-120Zm-152-80h85q24-66 77-93t98-27q45 0 98 27t77 93h85v-240h80q8 0 14-6t6-14q0-8-6-14t-14-6h-80v-240H480v-80q0-8-6-14t-14-6q-8 0-14 6t-6 14v80H200v88q54 20 87 67t33 105q0 57-33 104t-87 68v88Zm260-260Z"/></svg>
            <p>
              {{translate('Plugins')}}
            </p>
          </a>
        </li>
        <!-- Plugn -->

        <!-- Languages -->
        <li class="nav-item">
          <a href="{{route('languages.index')}}" class="nav-link {{Route::currentRouteName() == 'languages.index'? 'active':'' }}">
          <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#5f6368"><path d="m480-80-40-120H160q-33 0-56.5-23.5T80-280v-520q0-33 23.5-56.5T160-880h240l35 120h365q35 0 57.5 22.5T880-680v520q0 33-22.5 56.5T800-80H480ZM286-376q69 0 113.5-44.5T444-536q0-8-.5-14.5T441-564H283v62h89q-8 28-30.5 43.5T287-443q-39 0-67-28t-28-69q0-41 28-69t67-28q18 0 34 6.5t29 19.5l49-47q-21-22-50.5-34T286-704q-67 0-114.5 47.5T124-540q0 69 47.5 116.5T286-376Zm268 20 22-21q-14-17-25.5-33T528-444l26 88Zm50-51q28-33 42.5-63t19.5-47H507l12 42h40q8 15 19 32.5t26 35.5Zm-84 287h280q18 0 29-11.5t11-28.5v-520q0-18-11-29t-29-11H447l47 162h79v-42h41v42h146v41h-51q-10 38-30 74t-47 67l109 107-29 29-108-108-36 37 32 111-80 80Z"/></svg>
            <p>
              {{translate('Language')}}
            </p>
          </a>
        </li>
        <!-- Languages -->

        @foreach ($active_plugins_sidebars as $sidebar)
          @include($sidebar)
        @endforeach

        @php
          $active_menu_list = ['manage.branch','general.settings','manage.taxes'];
          $is_active = in_array(Route::currentRouteName(), $active_menu_list);
        @endphp
        <li class="nav-item {{$is_active? 'menu-open':'' }}">
          <a href="#" class="nav-link {{$is_active? 'active':'' }}">
          <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#5f6368"><path d="m370-80-16-128q-13-5-24.5-12T307-235l-119 50L78-375l103-78q-1-7-1-13.5v-27q0-6.5 1-13.5L78-585l110-190 119 50q11-8 23-15t24-12l16-128h220l16 128q13 5 24.5 12t22.5 15l119-50 110 190-103 78q1 7 1 13.5v27q0 6.5-2 13.5l103 78-110 190-118-50q-11 8-23 15t-24 12L590-80H370Zm70-80h79l14-106q31-8 57.5-23.5T639-327l99 41 39-68-86-65q5-14 7-29.5t2-31.5q0-16-2-31.5t-7-29.5l86-65-39-68-99 42q-22-23-48.5-38.5T533-694l-13-106h-79l-14 106q-31 8-57.5 23.5T321-633l-99-41-39 68 86 64q-5 15-7 30t-2 32q0 16 2 31t7 30l-86 65 39 68 99-42q22 23 48.5 38.5T427-266l13 106Zm42-180q58 0 99-41t41-99q0-58-41-99t-99-41q-59 0-99.5 41T342-480q0 58 40.5 99t99.5 41Zm-2-140Z"/></svg>
              <p>
                  {{translate('Settings')}}
                  <i class="right fas fa-angle-left"></i>
              </p>
          </a>
          <ul class="nav nav-treeview">
              <li class="nav-item">
                  @php
                      $active_menu_list = ['general.settings'];
                      $is_active = in_array(Route::currentRouteName(), $active_menu_list);
                  @endphp
                  <a href="{{route('general.settings')}}" class="nav-link {{$is_active? 'active':'' }}">
                      <i class="far fa-circle nav-icon"></i>
                      <p>{{translate('General Settings')}}</p>
                  </a>
              </li>
              <li class="nav-item">
                  @php
                      $active_menu_list = ['manage.branch'];
                      $is_active = in_array(Route::currentRouteName(), $active_menu_list);
                  @endphp
                  <a href="{{route('manage.branch')}}" class="nav-link {{$is_active? 'active':'' }}">
                      <i class="far fa-circle nav-icon"></i>
                      <p>{{translate('Manage Branch')}}</p>
                  </a>
              </li>
              <li class="nav-item">
                  @php
                      $active_menu_list = ['manage.order.status'];
                      $is_active = in_array(Route::currentRouteName(), $active_menu_list);
                  @endphp
                  <a href="{{route('manage.order.status')}}" class="nav-link {{$is_active? 'active':'' }}">
                      <i class="far fa-circle nav-icon"></i>
                      <p>{{translate('Manage Order Status')}}</p>
                  </a>
              </li>
              <li class="nav-item">
                  @php
                      $active_menu_list = ['manage.taxes'];
                      $is_active = in_array(Route::currentRouteName(), $active_menu_list);
                  @endphp
                  <a href="{{route('manage.taxes')}}" class="nav-link {{$is_active? 'active':'' }}">
                      <i class="far fa-circle nav-icon"></i>
                      <p>{{translate('Manage Taxes')}}</p>
                  </a>
              </li>
          </ul>
        </li>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>