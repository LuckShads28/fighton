<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    {{-- <link rel="stylesheet" href="{{ asset('/') }}assets/vendor/adminlte/plugins/fontawesome-free/css/all.min.css"> --}}
    <link rel="stylesheet" href="{{ asset('/') }}assets/vendor/fontawesome/css/fontawesome.min.css" />
    <link rel="stylesheet" href="{{ asset('/') }}assets/vendor/fontawesome/css/solid.min.css" />
    <!-- overlayScrollbars -->
    <link rel="stylesheet"
        href="{{ asset('/') }}assets/vendor/adminlte/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('/') }}assets/vendor/adminlte/dist/css/adminlte.min.css">
    {{-- <link rel="stylesheet" href="{{ asset('/') }}assets/vendor/bootstrap/css/bootstrap.min.css" /> --}}
    <link rel="stylesheet" href="{{ asset('/') }}assets/css/custom.css" />
    <link rel="icon" type="image/x-icon" href="{{ asset('/') }}assets/img/logo/favicon.ico">
    <title>{{ $title }} | fighton.my.id</title>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <!-- Site wrapper -->
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand-lg navbar-dark bg-custom-primary-2">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown ms-md-2">
                    <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
                        <i class="fa-solid fa-user"></i>
                        <span class="fw-bold ms-1">{{ Auth::user()->nickname }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-custom">
                        <li>
                            <a class="dropdown-item" href="{{ route('profile.index') }}">Profile</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('organizer.index') }}">Kelola Turnamen</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('admin.index') }}">Dashboard</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('logout') }}">Logout</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar main-sidebar-custom sidebar-dark-primary bg-custom-primary-2 elevation-4">
            <!-- Brand Logo -->
            <a href="#" class="brand-link">
                <img src="#" alt="logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">{{ Auth::user()->nickname }}</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Dashboard
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-user-group"></i>
                                <p>
                                    Tim
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-trophy"></i>
                                <p>
                                    History Turnamen
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-pencil"></i>
                                <p>
                                    Organizer
                                </p>
                            </a>
                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper text-white" style="background-color: #00031B">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>{{ $title }}</h1>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                @yield('content')
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <footer class="main-footer bg-custom-primary-2">
            <strong><a href="{{ route('home') }}" class="text-white-half">fighton.my.id</a></strong>
        </footer>
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="{{ asset('/') }}assets/vendor/adminlte/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('/') }}assets/vendor/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- overlayScrollbars -->
    <script src="{{ asset('/') }}assets/vendor/adminlte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js">
    </script>
    <!-- AdminLTE App -->
    <script src="{{ asset('/') }}assets/vendor/adminlte/dist/js/adminlte.min.js"></script>
    <!-- DataTables  & Plugins -->
    <script src="{{ asset('/') }}assets/vendor/adminlte/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="{{ asset('/') }}assets/vendor/adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js">
    </script>
    <script src="{{ asset('/') }}assets/vendor/adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js">
    </script>
    <script src="{{ asset('/') }}assets/vendor/adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js">
    </script>
    <script src="{{ asset('/') }}assets/vendor/adminlte/plugins/datatables-buttons/js/dataTables.buttons.min.js">
    </script>
    <script src="{{ asset('/') }}assets/vendor/adminlte/plugins/datatables-buttons/js/buttons.bootstrap4.min.js">
    </script>
    <script src="{{ asset('/') }}assets/vendor/adminlte/plugins/jszip/jszip.min.js"></script>
    <script src="{{ asset('/') }}assets/vendor/adminlte/plugins/pdfmake/pdfmake.min.js"></script>
    <script src="{{ asset('/') }}assets/vendor/adminlte/plugins/pdfmake/vfs_fonts.js"></script>
    <script src="{{ asset('/') }}assets/vendor/adminlte/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="{{ asset('/') }}assets/vendor/adminlte/plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="{{ asset('/') }}assets/vendor/adminlte/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

    @stack('script')
</body>

</html>
