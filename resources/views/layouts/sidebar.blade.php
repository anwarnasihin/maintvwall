<!-- Main Sidebar Container -->
<style>
    /* 1. Background Sidebar Biru Navy/Gelap (Aestetik) */
    .main-sidebar {
        background: linear-gradient(180deg, #008ED3 0%, #000000 100%) !important;
        border-right: 1px solid rgba(255, 255, 255, 0.1);
    }

    /* 2. Area Logo & User Panel */
    .brand-link, .user-panel {
        /* Kita hapus background rgba(0, 0, 0, 0.3) yang tadi kita buat */
        background: transparent !important;

        /* Kita hapus juga border-bottom agar terlihat menyatu sempurna */
        border-bottom: none !important;

        /* Berikan sedikit bayangan pada teks agar tetap terbaca jelas */
        text-shadow: 1px 1px 2px rgba(0,0,0,0.5);
    }

    /* Pastikan warna teks brand tetap putih terang */
    .brand-link .brand-text, .info a {
        color: #ffffff !important;
        font-weight: 600;
    }

    /* Menu Aktif dengan Kursor KUNING NYALA */
    .sidebar-dark-primary .nav-sidebar > .nav-item > .nav-link.active {
        /* Gradasi Kuning Neon */
        background: linear-gradient(90deg, #ffff00 0%, #ffcc00 100%) !important;

        /* Efek Glow Kuning */
        box-shadow: 0 4px 20px rgba(255, 255, 0, 0.6);

        /* Teks & Icon Hitam agar tajam di atas Kuning */
        color: #000 !important;
        font-weight: 800;
        border-radius: 8px;
        border: none;
        transition: all 0.3s ease;
    }

    /* Pastikan icon di menu aktif juga hitam */
    .sidebar-dark-primary .nav-sidebar > .nav-item > .nav-link.active i {
        color: #000 !important;
    }

    /* 4. Efek Hover (Kuning Tipis saat kursor lewat) */
    .nav-sidebar .nav-link:hover {
        background-color: rgba(255, 255, 0, 0.1) !important;
        color: #ffff00 !important;
        transform: translateX(8px);
        transition: all 0.3s ease;
    }

    /* 5. Footer Sidebar (Senada dengan Biru Gelap di bawah) */
    .sidebar-custom-footer {
        background: #000000 !important;
        border-top: 1px solid rgba(255, 255, 255, 0.1) !important;
    }

    /* 6. Mengatur Sub-Menu (Add Group, Data, Text) saat HOVER */
    .nav-treeview > .nav-item > .nav-link:hover {
        background-color: rgba(255, 255, 0, 0.2) !important; /* Kuning transparan */
        color: #ffff00 !important; /* Teks jadi kuning nyala */
        transform: translateX(10px); /* Geser ke kanan sedikit lebih jauh agar terlihat beda */
        transition: all 0.3s ease;
    }

    /* 7. Mengatur Sub-Menu saat AKTIF (sedang dibuka) */
    .nav-treeview > .nav-item > .nav-link.active {
        /* Samakan dengan gaya Kuning Menyala menu utama */
        background: linear-gradient(90deg, #ffff00 0%, #ffcc00 100%) !important;
        box-shadow: 0 2px 10px rgba(255, 255, 0, 0.4);
        color: #000 !important; /* Teks hitam agar jelas */
        font-weight: 700;
        border-radius: 8px;
    }

    /* Pastikan icon di dalam sub-menu aktif juga jadi hitam */
    .nav-treeview > .nav-item > .nav-link.active i {
        color: #000 !important;
    }

    /* 8. Menyesuaikan Indentasi (Jarak) Sub-menu agar lebih rapi */
    .nav-treeview > .nav-item > .nav-link {
        padding-left: 20px !important;
        transition: all 0.3s ease;
    }
</style>

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
        <img src="{{asset ('assets/beken.png')}}" class="img-circle elevation-2" alt="User Image">
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

        @if (auth()->user()->role == 'admin')
          <li class="nav-item">
            <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
              <i class="nav-icon fa fa-users"></i>
              <p>Users</p>
            </a>
          </li>

        @endif
        <li class="nav-item">
          <a href="" class="nav-link" data-toggle="modal" data-target="#logoutModal">
            <i class="nav-icon fas fa-sign-out-alt"></i>
            <p>Logout</p>
          </a>
        </li>

        {{-- <li class="nav-item">
          <a href="" class="nav-link" data-toggle="modal" data-target="#shutdownModal">
            <i class="nav-icon fa fa-power-off"></i>
            <p>Shutdown</p>
          </a>
        </li> --}}

    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->

  <!-- Bagian Bawah (Copyright) -->
    <div class="sidebar-custom-footer p-3 text-center" style="border-top: 1px solid rgba(255,255,255,0.1); background: #001a33;">
      <p class="mb-0" style="color: #b9b9b9; font-size: 15px; font-weight: 700;">
          Version 6.5.2 <br>
      </p>
  </div>
</aside>


