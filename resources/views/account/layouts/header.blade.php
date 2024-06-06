<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/boxicons.min.css') }}">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Slick Slider CSS -->
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link rel="stylesheet" href="{{ asset('css/home/style_index.css') }}">
    <link rel="stylesheet" href="{{ asset('css/layouts/style_header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/products/style_products.css') }}">
    <link rel="stylesheet" href="{{ asset('css/layouts/style_footer.css') }}">
    <link rel="stylesheet" href="{{ asset('css/reponsive.css') }}">
    <link rel="stylesheet" href="{{ asset('css/customer/style_cart.css') }}">
    <link rel="stylesheet" href="{{ asset('css/customer/style_voucher.css') }}">
    <link rel="stylesheet" href="{{ asset('css/customer/style_bill.css') }}">
    <link rel="stylesheet" href="{{ asset('css/customer/style_profile.css') }}">





    <title>@yield('title')</title>
    <style>
        body {
            background-image: url("{{ asset('images/Background_index.jpg') }}");
        }
    </style>
</head>

<body>
    {{-- header --}}
    <header class="header">

        <!-- Navbar -->
        <div class="header__navbar">
            <div class="header__navbar--logo">
                <a href="">
                    <img src="{{ asset('images/logo_shopbvt.png') }}">
                </a>
            </div>
            <ul class="header__navbar--links-nav">
                <li><a href="{{ route('product.top-8-sale') }}">Home</a></li>
                <li class="header__navbar--dropdown-product">
                    <a href="{{ route('product.showProduct') }}" class="dropdown__product-btn">Product</a>
                    <div class="navbar__dropdown--product-content">

                        @include('account.layouts.dorpdown_category')

                        {{-- <a href="#">Áo thun</a>
                        <a href="#">Quần</a> --}}
                    </div>
                </li>
                <li><a href="#">Contact</a></li>
                <li><a href="#">About</a></li>
            </ul>

            {{-- search box --}}
            <div class="header__navbar--search">
                <form method="POST" action="{{ route('SearchProduct') }}">
                    @csrf
                    <input type="search" name="ProductName" value="{{ session('ProductName') }}">
                    <button type="submit"><i class='bx bx-search-alt-2'></i></button>
                </form>
            </div>


            {{-- cart  --}}
            <div class="header__navbar--cart">
                <a href="{{ route('cart.showCart') }}"><i class='bx bx-cart-alt'></i></a>
            </div>

            {{-- Button login --}}
            @if (session('LoggedUser'))
                <div class="header__navbar--cart">
                    <a href="{{ route('voucher.showVoucher') }}">
                        <i class='bx bxl-firebase'></i>
                    </a>
                </div>

                <button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown" style="font-size: 13px; font-weight:bold;">
                    {{ session('LoggedName') }}
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="{{ route('bill.CheckYourOrder') }}"><b><i
                                    class='bx bx-memory-card'></i> Check your order</b></a></li>
                    <li><a class="dropdown-item" href="{{ route('login.LogOut') }}"><b><i
                                    class='bx bx-log-out-circle'></i> Log out</b></a></li>
                </ul>
            @else
                <div class="header__navbar--cart">
                    <a href="{{ route('show.CheckOrderForm_WalkInCustomers') }}">check<i
                            class="fa-solid fa-truck-fast"></i></a>
                </div>

                <button class="header__navbar--btn-login"><a
                        href="{{ route('login.ShowLoginForm') }}">Login</a></button>
            @endif


            <div class="header__navbar--toggle-btn">
                <i class='bx bx-menu'></i>
            </div>
        </div> <!--End class navbar-main-->

        @include('account.layouts.dropdown_menu')

    </header>

    {{-- main --}}
    <main>
