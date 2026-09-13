<!-- Main Sidebar Container -->

<style>
    /* 1. Background Sidebar Biru Navy/Gelap */
    .main-sidebar {
        background: linear-gradient(180deg, #008ED3 0%, #000000 100%) !important;
        border-right: 1px solid rgba(255, 255, 255, 0.1);
    }

    /* 2. Area Logo & User Panel */
    .brand-link,
    .user-panel {
        background: transparent !important;
        border-bottom: none !important;
        text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
    }

    /* Pastikan warna teks brand tetap putih terang */
    .brand-link .brand-text,
    .info a {
        color: #ffffff !important;
        font-weight: 600;
    }

    /* 3. Menu Aktif dengan Kursor KUNING NYALA */
    .sidebar-dark-primary .nav-sidebar > .nav-item > .nav-link.active {
        background: linear-gradient(90deg, #ffff00 0%, #ffcc00 100%) !important;
        box-shadow: 0 4px 20px rgba(255, 255, 0, 0.6);
        color: #000 !important;
        font-weight: 800;
        border-radius: 8px;
        border: none;
        transition: all 0.3s ease;
    }

    /* Icon menu aktif menjadi hitam */
    .sidebar-dark-primary .nav-sidebar > .nav-item > .nav-link.active i {
        color: #000 !important;
    }

    /* 4. Efek Hover */
    .nav-sidebar .nav-link:hover {
        background-color: rgba(255, 255, 0, 0.1) !important;
        color: #ffff00 !important;
        transform: translateX(8px);
        transition: all 0.3s ease;
    }

    /* 5. Footer Sidebar */
    .sidebar-custom-footer {
        background: #000000 !important;
        border-top: 1px solid rgba(255, 255, 255, 0.1) !important;
    }

    /* 6. Sub-menu saat HOVER */
    .nav-treeview > .nav-item > .nav-link:hover {
        background-color: rgba(255, 255, 0, 0.2) !important;
        color: #ffff00 !important;
        transform: translateX(10px);
        transition: all 0.3s ease;
    }

    /* 7. Sub-menu saat AKTIF */
    .nav-treeview > .nav-item > .nav-link.active {
        background: linear-gradient(90deg, #ffff00 0%, #ffcc00 100%) !important;
        box-shadow: 0 2px 10px rgba(255, 255, 0, 0.4);
        color: #000 !important;
        font-weight: 700;
        border-radius: 8px;
    }

    /* Icon sub-menu aktif menjadi hitam */
    .nav-treeview > .nav-item > .nav-link.active i {
        color: #000 !important;
    }

    /* 8. Indentasi Sub-menu */
    .nav-treeview > .nav-item > .nav-link {
        padding-left: 20px !important;
        transition: all 0.3s ease;
    }
</style>


<aside class="main-sidebar sidebar-dark-primary elevation-4">

    <!-- Brand / User Panel -->
    <div class="sidebar">

        <!-- Sidebar User -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">

            <div class="image">
                <img
                    src="{{ asset('assets/beken.png') }}"
                    class="img-circle elevation-2"
                    alt="User Image"
                >
            </div>

            <div class="info">
                <a
                    href="{{ route('dashboard') }}"
                    class="d-block"
                >
                    TV WALL BINUS@BEKASI
                </a>
            </div>

        </div>


        <!-- Sidebar Menu -->
        <nav class="mt-2">

            <ul
                class="nav nav-pills nav-sidebar flex-column"
                data-widget="treeview"
                role="menu"
                data-accordion="false"
            >

                <!-- ========================= -->
                <!-- DASHBOARD -->
                <!-- ========================= -->

                <li class="nav-item">

                    <a
                        href="/dashboard"
                        class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}"
                    >

                        <i class="nav-icon fas fa-tachometer-alt"></i>

                        <p>
                            Dashboard
                        </p>

                    </a>

                </li>


                <!-- ========================= -->
                <!-- UPLOAD -->
                <!-- ========================= -->

                <li
                    class="nav-item {{ request()->routeIs('datagroup*', 'datafile*', 'datatext*') ? 'menu-open' : '' }}"
                >

                    <!-- Parent Upload TIDAK dibuat active -->
                    <a
                        href="#"
                        class="nav-link"
                    >

                        <i class="nav-icon fas fa-rocket"></i>

                        <p>
                            Upload
                            <i class="right fas fa-angle-left"></i>
                        </p>

                    </a>


                    <!-- Sub Menu Upload -->
                    <ul class="nav nav-treeview">


                        <!-- ADD GROUP -->
                        <li class="nav-item">

                            <a
                                href="{{ route('datagroup') }}"
                                class="nav-link {{ request()->routeIs('datagroup*') ? 'active' : '' }}"
                            >

                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                <i class="fas fa-layer-group"></i>

                                &nbsp;

                                <p>
                                    Add Group
                                </p>

                            </a>

                        </li>


                        <!-- ADD DATA -->
                        <li class="nav-item">

                            <a
                                href="{{ route('datafile') }}"
                                class="nav-link {{ request()->routeIs('datafile*') ? 'active' : '' }}"
                            >

                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                <i class="fas fa-folder-plus"></i>

                                &nbsp;

                                <p>
                                    Add Data
                                </p>

                            </a>

                        </li>


                        <!-- ADD TEXT -->
                        <li class="nav-item">

                            <a
                                href="{{ route('datatext') }}"
                                class="nav-link {{ request()->routeIs('datatext*') ? 'active' : '' }}"
                            >

                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                <i class="fab fa-adversal"></i>

                                &nbsp;

                                <p>
                                    Add Text
                                </p>

                            </a>

                        </li>

                    </ul>

                </li>


                <!-- ================================================= -->
                <!-- MENU KHUSUS ADMIN -->
                <!-- ================================================= -->

                @auth

                    @if (auth()->user()->role == 'admin')


                        <!-- USERS -->
                        <li class="nav-item">

                            <a
                                href="{{ route('admin.users.index') }}"
                                class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}"
                            >

                                <i class="nav-icon fa fa-users"></i>

                                <p>
                                    Users
                                </p>

                            </a>

                        </li>


                        <!-- RECYCLE BIN -->
                        <li class="nav-item">

                            <a
                                href="{{ route('admin.recyclebin') }}"
                                class="nav-link {{ request()->routeIs('admin.recyclebin*') ? 'active' : '' }}"
                            >

                                <i class="nav-icon fas fa-trash-alt"></i>

                                <p>
                                    Recycle Bin
                                </p>

                            </a>

                        </li>


                    @endif


                    <!-- ========================= -->
                    <!-- LOGOUT -->
                    <!-- ========================= -->

                    <li class="nav-item">

                        <a
                            href="#"
                            class="nav-link"
                            data-toggle="modal"
                            data-target="#logoutModal"
                        >

                            <i class="nav-icon fas fa-sign-out-alt"></i>

                            <p>
                                Logout
                            </p>

                        </a>

                    </li>


                    {{-- Shutdown sengaja tetap tidak digunakan --}}

                    {{--
                    <li class="nav-item">

                        <a
                            href="#"
                            class="nav-link"
                            data-toggle="modal"
                            data-target="#shutdownModal"
                        >

                            <i class="nav-icon fa fa-power-off"></i>

                            <p>
                                Shutdown
                            </p>

                        </a>

                    </li>
                    --}}


                @endauth

            </ul>

        </nav>

        <!-- /.sidebar-menu -->

    </div>

    <!-- /.sidebar -->


    <!-- ========================================= -->
    <!-- FOOTER SIDEBAR -->
    <!-- ========================================= -->

    <div
        class="sidebar-custom-footer text-center"
        style="
            border-top: 1px solid rgba(255,255,255,0.1);
            background: #001a33;
            padding: 12px 8px;
        "
    >

        <!-- COPYRIGHT -->

        <div
            style="
                color: #b9b9b9;
                font-size: 12px;
                font-weight: 600;
                line-height: 1.4;
                margin-bottom: 5px;
            "
        >

            Copyright &copy; IT Univ BINUS@Bekasi 2026.

        </div>


        <!-- VERSION -->

        <div
            style="
                color: #ffffff;
                font-size: 13px;
                font-weight: 700;
            "
        >

            Version 6.5.5

        </div>

    </div>


</aside>
