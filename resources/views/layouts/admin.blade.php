<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title')</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('admin/plugins/fontawesome-free/css/all.min.css')}}">
    <link rel="icon" href="{{asset('images/browsericon.png')}}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bbootstrap 4 -->
    <link rel="stylesheet"
          href="{{asset('admin/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{asset('admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
    <!-- JQVMap -->
    <link rel="stylesheet" href="{{asset('admin/plugins/jqvmap/jqvmap.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('admin/dist/css/adminlte.min.css')}}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{asset('admin/plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{asset('admin/plugins/daterangepicker/daterangepicker.css')}}">
    <!-- summernote -->
    <link rel="stylesheet" href="{{asset('admin/plugins/summernote/summernote-bs4.css')}}">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

    <style type="text/css">
        li {
            list-style-type: none;
        }
    </style>

    @yield('css')
</head>

<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
            </li>
        </ul>

        <ul class="navbar-nav ml-auto">
            <!-- Authentication Links -->
            @guest
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">Login</a>
                </li>
            @else


                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                   aria-haspopup="true" aria-expanded="false" v-pre>
                    @if(Auth::user()->profile_photo != null)
                        <img src="{{asset(Auth::user()->profile_photo)}}"
                             class="brand-image img-circle elevation-3"
                             style="opacity: .8; height: 35px ; width: 35px;">
                    @endif
                    {{ Auth::user()->name }} <span class="caret"></span>
                </a>


                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">

                    <a class="dropdown-item" href="{{url('/profile')}}">Profile</a>

                    <a class="dropdown-item" href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>


                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </div>


            @endguest
        </ul>

        <!-- Right navbar links -->

    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="{{url('/')}}" class="brand-link">

            <img src=""
                 class="brand-image"
                 style="opacity: 1; background-color: transparent">
            <span class="brand-text font-weight-light" style="font-size: 0.8em; color: transparent">Hexavara</span>
        </a>


        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
                <li class="nav-header">Main Menu</li>
                <li class="nav-item">
                    @if(Request::is('/'))
                        <a href="{{url('/')}}" class="nav-link active">
                            @else
                                <a href="{{url('/')}}" class="nav-link">
                                    @endif
                                    <i class="nav-icon fas fa-tachometer-alt"></i>
                                    <p>
                                        Dashboard
                                    </p>
                                </a>

                </li>


                <li class="nav-item ">
                    @if(Request::is('user'))
                        <a href="{{url('user')}}" class="nav-link active">
                            @else
                                <a href="{{url('user')}}" class="nav-link">
                                    @endif
                                    <i class="nav-icon fas fa-table"></i>
                                    <p>
                                        User
                                    </p>
                                </a>
                        </a>
                </li>



                <li class="nav-item has-treeview">
                    @if(Request::is('manajemenpengguna'))
                        <a href="{{url('manajemenpengguna')}}" class="nav-link active">
                            @else
                                <a href="{{url('manajemenpengguna')}}" class="nav-link">
                                    @endif
                                    <i class="nav-icon fas fa-user"></i>
                                    <p>
                                        Some Menu
                                    </p>
                                </a>

                </li>

                <li class="nav-item has-treeview">
                    @if(Request::is('manajemenrole'))
                        <a href="{{url('manajemenrole')}}" class="nav-link active">
                            @else
                                <a href="{{url('manajemenrole')}}" class="nav-link">
                                    @endif
                                    <i class="nav-icon fas fa-user-tag"></i>
                                    <p>
                                        Some Menu
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
<div class="content-wrapper">
    <!-- Content Header (Page header) -->

@yield('content')



<!-- /.content -->
</div>
<!-- /.content-wrapper -->
<footer class="main-footer">
    <strong>Copyright &copy; 2020 <a href="http://">Hexavara</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
        <b>Version</b> 0.0.1
    </div>
</footer>

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{asset('admin/plugins/jquery/jquery.min.js')}}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{asset('admin/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{asset('admin/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- ChartJS -->
<script src="{{asset('admin/plugins/chart.js/Chart.min.js')}}"></script>
<!-- Sparkline -->
<script src="{{asset('admin/plugins/sparklines/sparkline.js')}}"></script>
<!-- JQVMap -->
<script src="{{asset('admin/plugins/jqvmap/jquery.vmap.min.js')}}"></script>
<script src="{{asset('admin/plugins/jqvmap/maps/jquery.vmap.usa.js')}}"></script>
<!-- jQuery Knob Chart -->
<script src="{{asset('admin/plugins/jquery-knob/jquery.knob.min.js')}}"></script>
<!-- daterangepicker -->
<script src="{{asset('admin/plugins/moment/moment.min.js')}}"></script>
<script src="{{asset('admin/plugins/daterangepicker/daterangepicker.js')}}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{asset('admin/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
<!-- Summernote -->
<script src="{{asset('admin/plugins/summernote/summernote-bs4.min.js')}}"></script>
<!-- overlayScrollbars -->
<script src="{{asset('admin/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('admin/dist/js/adminlte.js')}}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{asset('admin/dist/js/pages/dashboard.js')}}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{asset('admin/dist/js/demo.js')}}"></script>
@yield('script')
</body>
</html>
