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
            <svg xmlns="http://www.w3.org/2000/svg" height="19" viewBox="0 -960 960 960" width="19">
              <path d="m152-823 72 149h130l-72-149h88l72 149h131l-73-149h89l72 149h130l-72-149h91q37.588 0 64.794 27.906Q902-767.188 902-731v502q0 35.775-27.206 63.388Q847.588-138 810-138H150q-37.175 0-64.088-25.938Q59-189.875 59-227v-504q0-36.463 27.475-64.731Q113.95-824 152-823Zm-2 241v353h660v-353H150Zm0 0v353-353Z" />
            </svg>
            <p>
              {{translate('Media Library')}}
            </p>
          </a>
        </li>
        <!-- Media Library-->

        <!-- Plugn -->
        <li class="nav-item">
          <a href="{{route('plugins.index')}}" class="nav-link {{Route::currentRouteName() == 'plugins.index'? 'active':'' }}">
            <svg xmlns="http://www.w3.org/2000/svg" height="19" viewBox="0 -960 960 960" width="19">
              <path d="M320-80v-120L200-440v-240h40v-120q0-33 23.5-56.5T320-880h320q33 0 56.5 23.5T720-800v120h40v240L640-200v120H320Zm0-600h80v-80h40v80h80v-80h40v80h80v-120H320v120Zm80 520h160v-60l120-240v-140H280v140l120 240v60Zm80-300Z" />
            </svg>
            <p>
              {{translate('Plugins')}}
            </p>
          </a>
        </li>
        <!-- Plugn -->

        <!-- Languages -->
        <li class="nav-item">
          <a href="{{route('languages.index')}}" class="nav-link {{Route::currentRouteName() == 'languages.index'? 'active':'' }}">
            <svg xmlns="http://www.w3.org/2000/svg" height="19" viewBox="0 -960 960 960" width="19">
              <path d="m480-80-40-120H160q-33 0-56.5-23.5T80-280v-520q0-33 23.5-56.5T160-880h240l35 120h365q35 0 57.5 22.5T880-680v520q0 33-22.5 56.5T800-80H480ZM286-376q69 0 113.5-44.5T444-536q0-8-.5-14.5T441-564H283v62h89q-8 28-30.5 43.5T287-443q-39 0-67-28t-28-69q0-41 28-69t67-28q18 0 34 6.5t29 19.5l49-47q-21-22-50.5-34T286-704q-67 0-114.5 47.5T124-540q0 69 47.5 116.5T286-376Zm268 20 22-21q-14-17-25.5-33T528-444l26 88Zm50-51q28-33 42.5-63t19.5-47H507l12 42h40q8 15 19 32.5t26 35.5Zm-84 287h280q18 0 29-11.5t11-28.5v-520q0-18-11-29t-29-11H447l47 162h79v-42h41v42h146v41h-51q-10 38-30 74t-47 67l109 107-29 29-108-108-36 37 32 111-80 80Z" />
            </svg>
            <p>
              {{translate('Language')}}
            </p>
          </a>
        </li>
        <!-- Languages -->

        @foreach ($active_plugins_sidebars as $sidebar)
          @include($sidebar)
        @endforeach

      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>