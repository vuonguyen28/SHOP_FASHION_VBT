<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    @include('admin.layout.link')
</head>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Jersey+15&family=Open+Sans:ital,wght@0,400;1,600&family=Roboto:ital,wght@1,900&display=swap');

    .text_name-logo {
        font-family: "Jersey 15", sans-serif;
        font-size: 25px;
        color: antiquewhite;

    }

    .sidebar-color {
        background-color: #184651;
    }

    .nav-item p {
        color: #ffb964
    }

    .nav-item .nav-icon {
        background: linear-gradient(to left, #C6FFDD, #FBD786, #f7797d);
        /* Mã màu gradient */
        -webkit-background-clip: text;
        /* Clip vùng background vào vùng text */
        -webkit-text-fill-color: transparent;
        /* Cho phép vùng background hiển thị qua vùng text */

    }

    .icon-black {
        color: black;
    }

    .bg-logo_img {
        filter: drop-shadow(10px 10px 10px #fff);

    }
</style>

<body class="sidebar-mini layout-fixed sidebar-closed sidebar-collapse" style="height: auto;">
    <div class="wrapper">
        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center" style="height: 0px;">
            <img class="animation__shake" src="" alt="AdminLTELogo" height="60" width="60"
                style="display: none;">
        </div>
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class='bx bx-menu-alt-left' style="color:black; font-size: 25px;"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="" class="nav-link">Home</a>
                </li>
            </ul>

        </nav>
        <!-- /.navbar -->
        <!-- Main Sidebar Container -->

        @include('admin.layout.sidebar')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" style="min-height: 834px;">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-12">


                            @yield('content')


                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
        </div>
    
        <!-- /.control-sidebar -->
        <div id="sidebar-overlay"></div>
    </div>
    @include('admin.layout.script')
    <div class="jqvmap-label" style="display: none;"></div>
</body>
</html>
