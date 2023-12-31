<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  {{-- <a href="{{asset ('assets/index3.html')}}" class="brand-link">
  <img src="{{asset ('')}}assets/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
  <span class="brand-text font-weight-light">kuigiufiuu 3</span>
  </a> --}}

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="{{asset ('assets/b3.png')}}" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="{{ route('dashboard')}}" class="d-block">TV WALL BINUS@BEKASI</a>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
        <li class="nav-item ">
          <a href="/dashboard" class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
              Dashboard
            </p>
          </a>
        </li>

        <li class="nav-item {{ request()->is('datafile','datagroup','datatext') ? 'menu-open' : '' }}">
          <a href="" class="nav-link">
            <i class="nav-icon fas fa-rocket"></i>
            <p>
              Upload
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href=" {{ route('datagroup') }} " class="nav-link {{ request()->is('datagroup') ? 'active' : '' }}">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fas fa-layer-group"></i>
                &nbsp;<p>Add Group</p>
              </a>
            </li>

            <li class="nav-item">
              <a href=" {{ route('datafile') }} " class="nav-link {{ request()->is('datafile') ? 'active' : '' }}">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fas fa-folder-plus"></i>
                &nbsp;<p>Add Data</p>
              </a>
            </li>

            <li class="nav-item">
              <a href=" {{ route('datatext') }} " class="nav-link {{ request()->is('datatext') ? 'active' : '' }}">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fab fa-adversal"></i>
                &nbsp;<p>Add Text</p>
              </a>
            </li>
            
          </ul>
        </li>

        <li class="nav-item">
          <a href="{{ route('datausers') }}" class="nav-link {{ request()->is('datausers') ? 'active' : '' }}">
            <i class="nav-icon fa fa-users"></i>
            <p>Users</p>
          </a>
        </li>

        <li class="nav-item">
          <a href="" class="nav-link" data-toggle="modal" data-target="#logoutModal">
            <i class="nav-icon fas fa-sign-out-alt"></i>
            <p>Logout</p>
          </a>
        </li>

        <li class="nav-item">
          <a href="" class="nav-link" data-toggle="modal" data-target="#shutdownModal">
            <i class="nav-icon fa fa-power-off"></i>
            <p>Shutdown</p>
          </a>
        </li>
        
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>