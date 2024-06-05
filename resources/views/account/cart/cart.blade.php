@extends('account.layouts.layout')

@section('title', 'Giỏ hàng')
<style>
    .btn_color {
        width: 30px;
        height: 20px;
        border: 0px;
    }

    body {
        font-family: Arial, Helvetica, sans-serif;
    }

    /* The Modal (background) */
    .modal {
        display: none;
        /* Hidden by default */
        position: fixed;
        /* Stay in place */
        z-index: 1;
        /* Sit on top */
        padding-top: 100px;
        /* Location of the box */
        left: 0;
        top: 0;
        width: 100%;
        /* Full width */
        height: 100%;
        /* Full height */
        overflow: auto;
        /* Enable scroll if needed */
        background-color: rgb(0, 0, 0);
        /* Fallback color */
        background-color: rgba(0, 0, 0, 0.4);
        /* Black w/ opacity */
    }

    /* Modal Content */
    .modal-content {
        background-color: #fefefe;
        margin: auto;
        padding: 20px;
        border: 1px solid #888;
        width: 60%;
    }

    /* The Close Button */
    .close {
        color: #aaaaaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close:hover,
    .close:focus {
        color: #000;
        text-decoration: none;
        cursor: pointer;
    }
</style>

<?php
$sumTotal = 0;
$ShippingMoney = 0;
?>

<?php
$totalmoney = 0;
$sumTotalMoney = 0;
$shippingMoney = 0;
$saleVoucher = 0;
?>


@section('content')



    {{-- Hiển thị thông báo thành công nếu có --}}
    @if (session('success'))
        <script>
            Swal.fire({
                title: "Thông Báo",
                text: " {{ session('success') }}",
                icon: "success"
            });
        </script>
    @endif



    {{-- Hiển thị thông báo lỗi chung nếu có --}}
    @if (session('error'))
        <script>
            Swal.fire({
                title: "Thông Báo",
                text: "  {{ session('error') }}",
                icon: "error"
            });
        </script>
    @endif


    @if (!session('LoggedUser'))

        <div class="row ">
            <div class="btn__clearAll--cart">
                <form method="POST" action="{{ route('cart.clearAllCart') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger"><i class='bx bx-trash'></i>Clear All</button>
                </form>
            </div>
        </div>
        <div class="row form__cart">
            {{-- show detail cart --}}
            <div class="col-md-8 col-12">
                <div class="row">
                    @if (count($cart) > 0)
                        {{-- từng sản phẩm trong giỏ --}}
                        @foreach ($cart as $item)
                            <div class="row cart__details">

                                <div class="col-md-1 col-sm-1 col-1 d-flex justify-content-center align-items-center"
                                    style="height: 100%">
                                    <div class="cart__details--checkbox">
                                        <input type="checkbox" checked="">
                                        <span></span>
                                    </div>
                                </div>

                                {{-- img --}}
                                <div class="col-md-2 col-sm-2 col-2 d-flex justify-content-center align-items-center"
                                    style="height: 100%">
                                    <div class="cart__details--img">
                                        <img src="{{ $item['Image'] }}" alt="">
                                    </div>
                                </div>
                                {{-- details --}}
                                <div class="col-md-3 col-sm-3 col-3">
                                    <div class="cart__details--name">
                                        <p>{{ $item['TenSP'] }}</p>
                                    </div>
                                    <div class="cart__details--color">
                                        <p>Màu sắc: <button class="btn_color"
                                                style="background-color: {{ $item['MaMau'] }}; width: auto">{{ $item['MaMau'] }}</button>
                                        </p>
                                    </div>
                                    <div class="cart__details--size">
                                        <p>Size: <span>{{ $item['MaKichThuoc'] }}</span></p>
                                    </div>
                                    <div class="cart__details--price">

                                        @if (!$item['GiaSale'])
                                            <p>Giá: <span>{{ number_format($item['Gia'], 0, ',', '.') }}</span> VNĐ</p>
                                        @else
                                            <p>Giá: {{ number_format($item['GiaSale'], 0, ',', '.') }} VNĐ
                                                <span style="text-decoration: line-through; color: red;">
                                                    {{ number_format($item['Gia'], 0, ',', '.') }} VNĐ
                                                </span>
                                            </p>
                                        @endif

                                    </div>
                                    {{-- @if ($cart->ProductDetails->Size->TenKichThuoc != 0)
                                                <div class="cart__details--percent-sale">
                                                    <p>Giảm giá: </p>
                                                </div>
                                            @endif --}}

                                </div>
                                {{-- quantity --}}
                                <div class="col-md-3 col-sm-3 col-3 d-flex justify-content-center align-items-center"
                                    style="height: 100%">
                                    <div class="cart__details--quantity">


                                        <form method="POST" action="{{ route('cart.decreaseProductQuantity') }} ">
                                            @csrf
                                            <input hidden value="{{ $item['MaSP'] }}" name="MaSP">
                                            <input hidden value="{{ $item['MaKichThuoc'] }}" name="MaKichThuoc">
                                            <input hidden value="{{ $item['MaMau'] }}" name="MaMau">
                                            <button id="btn_reduce">-</button>
                                        </form>

                                        <input type="number" value="{{ $item['SoLuong'] }}" min="1">

                                        <form method="POST" action="{{ route('cart.increaseProductQuantity') }} ">
                                            @csrf
                                            <input hidden value="{{ $item['MaSP'] }}" name="MaSP">
                                            <input hidden value="{{ $item['MaKichThuoc'] }}" name="MaKichThuoc">
                                            <input hidden value="{{ $item['MaMau'] }}" name="MaMau">
                                            <button class="increase-quantity">+</button>
                                        </form>

                                    </div>
                                </div>
                                {{-- total --}}
                                <div class="col-md-2 col-sm-2 col-2">
                                    <div class="cart__details--total">
                                        <h4>Tổng tiền:</h4>


                                        <?php
                                        if (!$item['GiaSale']) {
                                            $Total = $item['Gia'] * $item['SoLuong'];
                                        } else {
                                            $Total = $item['GiaSale'] * $item['SoLuong'];
                                        }
                                        $sumTotal += $Total;
                                        $ShippingMoney = 30000;
                                        ?>


                                        <p>{{ number_format($Total, 0, ',', '.') }} vnđ</p>
                                    </div>
                                </div>

                                <div class="col-md-1 col-sm-1 col-1 d-flex justify-content-center align-items-center"
                                    style="height: 100%">
                                    <div class="cart__details--btn-delete">
                                        <form method="POST" action="{{ route('cart.removeItemProductFromCart') }} ">
                                            @csrf
                                            <input hidden value="{{ $item['MaSP'] }}" name="MaSP">
                                            <input hidden value="{{ $item['MaKichThuoc'] }}" name="MaKichThuoc">
                                            <input hidden value="{{ $item['MaMau'] }}" name="MaMau">

                                            <button type="submit" class="btn btn-danger"><i
                                                    class='bx bxs-trash'></i></button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="bg__emptyCart">
                            <style>
                                .btn__clearAll--cart {
                                    display: none;
                                }
                            </style>
                            <img src="{{ asset('images/emptyCart.png') }}">
                            <button><a href="{{ route('product.showProduct') }}">Shopping Now >></a></button>
                        </div>
                    @endif

                </div>
            </div>


            {{-- payment --}}
            <div class="col-md-4 col-12">
                {{-- row tổng tiền & phí vận chuyển --}}
                <div class="row">
                    <div class="form__payment">
                        <p>Thông Tin Đơn Hàng</p>
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-6">
                                <h4>Số tiền:</h4>
                                <h4>Phí vận chuyển: </h4>
                            </div>
                            <div class="col-md-6 col-sm-6 col-6 d-flex flex-column align-items-end">
                                <h4>{{ number_format($sumTotal, 0, ',', '.') }} vnđ</h4>
                                <h4>{{ number_format($ShippingMoney, 0, ',', '.') }} vnd</h4>
                                <input hidden value="{{ $ShippingMoney }}" name="PhiVanChuyen">
                            </div>
                        </div>
                        {{-- form xác nhận đặt hàng --}}
                        <div class="row">
                            <div class="form__confirm">
                                <div class="row">
                                    <div class="col-md-6 col-sm-6 col-6 total__bill--choose">
                                        <p>Tổng tiền (VAT): </p>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-6 d-flex flex-column align-items-end">
                                        <div class="total__pay">
                                            <p>{{ number_format($ShippingMoney + $sumTotal, 0, ',', '.') }}vnd</p>
                                            <input type="text" hidden value="{{ $ShippingMoney + $sumTotal }}"
                                                name="TongGia">
                                            <input hidden value="{{ $ShippingMoney + $sumTotal }}"
                                                name="TongTienSauKhiGiamGia">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <h4>Hình thức thanh toán</h4>
                                        <div class="col-md-6 d-flex justify-content-center align-items-center">
                                            <form action="{{ route('order.createOrder_WalkInCustomers') }}" method="POST">
                                                @csrf
                                                <button type="submit">Khi Nhận Hàng</button>
                                            </form>
                                        </div>

                                        <div class="col-md-6 d-flex justify-content-center align-items-center">
                                            <form method="POST" action="{{ route('momo.paymentWalkInCustomers') }}">
                                                @csrf
                                                <input hidden type="number" name="total_momo"
                                                    value="{{ (int) $sumTotalMoney + (int) $shippingMoney - (int) $saleVoucher }}">
                                                <button type="submit"> <img src="{{ asset('images/momologo.png') }}"
                                                        width="25px">Qua MOMO</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>


                                <br>
                                <br>

                                <div class="col-md-12 form__deliver--date">
                                    <div class="col-md-6">
                                        <h4>Ngày đặt: </h4>
                                    </div>
                                    <div class="col-md-6">
                                        <h5> {{ date('d-m-y') }}</h5>
                                    </div>
                                </div>
                                <div class="col-md-12 form__deliver--date">
                                    <div class="col-md-6">
                                        <h4>Ngày nhận dự kiến: </h4>
                                    </div>
                                    <div class="col-md-6">
                                        <h5>{{ date('d-m-y', strtotime('+3 days')) }}</h5>
                                    </div>
                                </div>

                                <div class="col-md-12 btn__update--info">
                                    <a href="#" id="myBtn">Cập Nhật Thông tin &nbsp;<i
                                            class='bx bx-edit'></i></a>
                                </div>

                                <div class="col-md-6 form__location--locate">
                                    <input value="{{ session('LoggedName_WalkInCus') }}" placeholder="first name"
                                        name="TenKH" type="text" required readonly>
                                </div>
                                <div class="col-md-6 form__location--locate">
                                    <input value="{{ session('LoggedPhone_WalkInCus') }}" placeholder="Phone"
                                        name="RecipientPhone" type="number" required readonly>
                                </div>

                                <div class="col-md-12 form__location--locate">
                                    <input value="{{ session('LoggedAddress_WalkInCus') }}" placeholder="Address"
                                        name="DiaChiNhanHang" type="text" required readonly>
                                </div>

                                <div class="col-md-12 form__location--locate">
                                    <input value="{{ session('LoggedEmail_WalkInCus') }}" placeholder="Email"
                                        name="Email" type="email" required readonly>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>





            </div>
        </div>

        <div id="myModal" class="modal">

            <!-- Modal content -->
            <div class="modal-content">
                <span class="close">&times;</span>
                <div class="modal-body">
                    <form action="{{ route('update_InfoOrder_WalkInCustomers') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="swal-input1">Số điện thoại</label>
                            <input value="{{ session('LoggedPhone_WalkInCus') }}" name="Phone" type="text"
                                class="form-control" id="swal-input1" placeholder="Số điện thoại">
                        </div>
                        <div class="form-group">
                            <label for="swal-input2">Họ tên</label>
                            <input value="{{ session('LoggedName_WalkInCus') }}" name="Name" type="text"
                                class="form-control" id="swal-input2" placeholder="Họ tên">
                        </div>
                        <div class="form-group">
                            <label for="swal-input3">Email</label>
                            <input value="{{ session('LoggedEmail_WalkInCus') }}" name="email" type="email"
                                class="form-control" id="swal-input3" placeholder="Email">
                        </div>
                        <div class="form-group">
                            <label for="swal-input4">Địa chỉ</label>
                            <input value="{{ session('LoggedAddress_WalkInCus') }}" name="Address" type="text"
                                class="form-control" id="swal-input4" placeholder="Địa chỉ">
                        </div>

                        <button class="btn btn-success" type="submit">Save</button>
                    </form>
                </div>
            </div>

        </div>
    @else
        {{-- login view --}}
        <div class="row form__cart">

            {{-- show detail cart --}}
            <div class="col-md-8 col-12">

                <div class="row">

                    @if (count($cart) > 0)
                        <?php
                        $shippingMoney = 30000;
                        ?>
                        @foreach ($cart as $cart)
                            {{-- từng sản phẩm trong giỏ --}}
                            <div class="row cart__details">


                                {{-- img --}}
                                <div class="col-md-2 col-sm-2 col-2 d-flex justify-content-center align-items-center"
                                    style="height: 100%">
                                    <div class="cart__details--img">

                                        @foreach ($cart->ProductDetails->Product->images->take(1) as $image)
                                            <img src="{{ $image->hinhanh }}" alt="">
                                        @endforeach
                                    </div>

                                </div>
                                {{-- details --}}
                                <div class="col-md-3 col-sm-3 col-3">
                                    <div class="cart__details--name">
                                        <p>{{ $cart->ProductDetails->Product->TenSP }}</p>
                                    </div>
                                    <div class="cart__details--color">
                                        <p>Màu sắc: <button class="btn_color"
                                                style="background-color: {{ $cart->ProductDetails->Color->HEXCODE }}">{{ $cart->ProductDetails->Color->TenMau }}</button>
                                        </p>
                                    </div>
                                    <div class="cart__details--size">
                                        <p>Size: {{ $cart->ProductDetails->Size->TenKichThuoc }}</p>
                                    </div>
                                    <div class="cart__details--price">
                                        <p>Giá: {{ $cart->ProductDetails->Product->Gia }}</p>
                                    </div>
                                    @if ($cart->ProductDetails->Product->PhanTramGiamGia)
                                        <div class="cart__details--percent-sale">
                                            <p>Giảm giá: {{ $cart->ProductDetails->Product->PhanTramGiamGia }}%</p>
                                        </div>
                                    @endif

                                </div>
                                {{-- quantity --}}
                                <div class="col-md-3 col-sm-3 col-3 d-flex justify-content-center align-items-center"
                                    style="height: 100%">
                                    <div class="cart__details--quantity">


                                        <form method="POST" action="{{ route('cart.reduceItemCartProduct') }}">
                                            @csrf
                                            <input hidden name="id_cart" value="{{ $cart->MaGioHang }}">
                                            <button type="submit">+</button>
                                        </form>


                                        <input type="number" value="{{ $cart->SoLuong }}" min="1">


                                        <form method="POST" action="{{ route('cart.addItemCartProduct') }}">
                                            @csrf
                                            <input hidden name="id_cart" hidden value="{{ $cart->MaGioHang }}">
                                            <button type="submit">+</button>
                                        </form>


                                    </div>
                                </div>
                                {{-- total --}}
                                <div class="col-md-2 col-sm-2 col-2">
                                    <div class="cart__details--total">

                                        @if (!$cart->ProductDetails->Product->PhanTramGiamGia)
                                            <?php
                                            $salePrice = $cart->ProductDetails->Product->Gia * $cart->SoLuong;
                                            ?>
                                            <h4>Tổng tiền:</h4>
                                            <p>{{ number_format($salePrice, 0, ',', '.') }}
                                                vnd</p>
                                        @else
                                            @php
                                                $salePrice =
                                                    ($cart->ProductDetails->Product->Gia -
                                                        $cart->ProductDetails->Product->Gia *
                                                            ($cart->ProductDetails->Product->PhanTramGiamGia / 100)) *
                                                    $cart->SoLuong;
                                            @endphp

                                            <h4>Tổng tiền:</h4>
                                            <p>{{ number_format($salePrice, 0, ',', '.') }}
                                                vnd</p>
                                        @endif

                                        <?php
                                        $sumTotalMoney += $salePrice;
                                        ?>


                                    </div>
                                </div>

                                <div class="col-md-1 col-sm-1 col-1 d-flex justify-content-center align-items-center"
                                    style="height: 100%">
                                    <div class="cart__details--btn-delete">
                                        <form method="POST" action="{{ route('cart.deleteCart', $cart->MaGioHang) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"><i class='bx bxs-trash'></i></button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="bg__emptyCart">
                            <style>
                                .btn__clearAll--cart {
                                    display: none;
                                }
                            </style>
                            <img src="{{ asset('images/emptyCart.png') }}">
                            <button><a href="{{ route('product.showProduct') }}">Shopping Now >></a></button>
                        </div>
                    @endif

                </div>
            </div>

            {{-- payment --}}
            <div class="col-md-4 col-12">
                {{-- row tổng tiền & phí vận chuyển --}}

                <div class="row">
                    <div class="form__payment">
                        <p>Thông Tin Đơn Hàng</p>
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-6">
                                <h4>Số tiền:</h4>
                                <h4>Phí vận chuyển: </h4>
                            </div>
                            <div class="col-md-6 col-sm-6 col-6 d-flex flex-column align-items-end">
                                <h4>{{ number_format($sumTotalMoney, 0, ',', '.') }} vnđ</h4>
                                <h4>{{ number_format($shippingMoney, 0, ',', '.') }} vnđ</h4>
                            </div>
                        </div>

                        {{-- form xác nhận đặt hàng --}}
                        <div class="row">
                            <div class="form__confirm">
                                <div class="row">
                                    <div class="col-md-6 col-sm-6 col-6">
                                        <p>Tổng tiền (VAT): </p>
                                        <p>Giảm:</p>
                                        <p>Tổng tiền sau khi giảm:</p>
                                        <p>Tổng tiền thanh toán: </p>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-6 d-flex flex-column align-items-end">
                                        <?php
                                        if (session()->has('sumTotalMoney_SALE')) {
                                            $saleVoucher = session('sumTotalMoney_SALE');
                                        }
                                        
                                        ?>
                                        <p>{{ number_format($sumTotalMoney + $shippingMoney, 0, ',', '.') }} vnđ</p>
                                        <p>{{ $saleVoucher }}vnd</p>

                                        <p>{{ number_format($sumTotalMoney + $shippingMoney - $saleVoucher, 0, ',', '.') }}vnd
                                        </p>
                                        <div class="total__pay">
                                            <p>{{ number_format($sumTotalMoney + $shippingMoney - $saleVoucher, 0, ',', '.') }}
                                                vnđ</p>
                                        </div>


                                    </div>
                                </div>
                                <div class="col-md-12 d-flex justify-content-center align-items-center">
                                    <div class="col-md-12">
                                        <h4>Hình thức thanh toán</h4>
                                        <div class="col-md-6 d-flex justify-content-center align-items-center">
                                            <form name="OrderConfirmationForm" id="OrderConfirmationForm" method="POST"
                                                action="{{ route('order.create') }}">
                                                @csrf

                                                <div class="pay__off">
                                                    <input hidden type="text" id="pay_on_delivery"
                                                        name="payment_method" value="on_delivery">
                                                    <button type="submit" for="pay_on_delivery">Khi nhận hàng</button>
                                                </div>
                                            </form>
                                        </div>

                                        <div class="col-md-6 d-flex justify-content-center align-items-center">
                                            <form method="POST" action="{{ route('momo.payment') }}">
                                                @csrf
                                                <input hidden type="number" name="total_momo"
                                                    value="{{ (int) $sumTotalMoney + (int) $shippingMoney - (int) $saleVoucher }}">
                                                <button type="submit"><img src="{{ asset('images/momologo.png') }}"
                                                        width="20px"> &nbsp;Qua MOMO</button>
                                            </form>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        {{-- form voucher --}}
                        <div class="row">
                            <div class="form__voucher">
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#myModal">Nhập mã giảm giá</button>
                                <div class="col-md-12 form__voucher--info">
                                    <ul>
                                        @if (session('nameVoucher'))
                                            <li> <b>Tên Voucher:</b> {{ session('nameVoucher') }}</li>
                                        @endif

                                        @if (session('MaVoucher'))
                                            <li><b>Mã Voucher: </b> {{ session('MaVoucher') }}</li>
                                            <input value="{{ session('MaVoucher') }}" type="text" hidden
                                                name="MaVoucher">
                                        @endif

                                        @if (session('sale'))
                                            <li><b>Giảm: </b> {{ session('sale') }}%</li>
                                        @endif

                                        @if (session('EndDate'))
                                            <li><b>Ngày hết hạn: </b> {{ session('EndDate') }}</li>
                                        @endif
                                    </ul>
                                </div>

                                @if (session('MaVoucher'))
                                    <div class="col-md-12 btn__delete--voucher">
                                        <form method="GET" action="{{ route('deleteVoucherApplyToOrder') }}">
                                            @csrf
                                            <button type="submit"><i class='bx bx-trash'></i> Delete voucher</button>
                                        </form>
                                    </div>
                                @endif

                            </div>



                        </div>



                        {{-- Ngày giao hàng dự kiến --}}
                        <div class="row">
                            <div class="form__deliver">
                                <div class="col-md-12 form__deliver--title">
                                    <p>Ngày giao hàng dự kiến</p>
                                </div>
                                <div class="col-md-12 form__deliver--date">
                                    <p>Ngày đặt: {{ date('d-m-y') }}</p>
                                    <p>Ngày nhận dự kiến: {{ date('d-m-y', strtotime('+3 days')) }}
                                    </p>

                                </div>
                            </div>
                        </div>

                        {{-- nơi nhận hàng --}}
                        <div class="row">
                            <div class="form__location">
                                <div class="col-md-12 form__location--title">
                                    <p>Thông tin nhận hàng</p>
                                    <div class="btn_changeInfo">
                                        <a href="#" id="showForm">Thay đổi địa chi & Số điện thoại &nbsp;<i
                                                class='bx bx-edit'></i></a>
                                    </div>
                                </div>
                                <div class="col-md-12 form__location--locate">
                                    <input name="DiaChiGiaoHang" value="{{ session('LoggedAddress') }}" type="text"
                                        required readonly>
                                </div>

                                <div class="col-md-12 form__location--locate">
                                    <input value="{{ session('LoggedPhone') }}" placeholder="Phone"
                                        name="RecipientPhone" type="text" required readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <input type="hidden" name="OrderConfirmation" value="OrderConfirmationForm">












            </div>
        </div>


        <!-- The Modal -->
        <div class="modal" id="myModal">
            <div class="modal-dialog">
                <form action="{{ route('applyVoucher') }}" method="POST">
                    @csrf
                    <div class="modal-content">

                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">Áp dụng Voucher</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <input hidden name="sumTotalMoney" value="{{ $sumTotalMoney }}">

                        <!-- Modal body -->
                        {{-- <div class="modal-body">
                            <h3>Thêm mã voucher</h3>
                            <input name="voucherCode" type="text" required>
                        </div> --}}

                        <select name="voucherCode" class="form-control" id="voucherCode" required
                            aria-placeholder="hihii">
                            <option value="">ApplyVoucher</option>
                            @foreach ($vouchers as $vouchers)
                                <option value="{{ $vouchers->MA_VOUCHER }}">{{ $vouchers->Voucher->Ten_VOUCHER }}
                                </option>
                            @endforeach
                        </select>

                        <!-- Modal footer -->
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-danger">Áp dụng Voucher</button>
                        </div>

                    </div>
                </form>
            </div>
        </div>




    @endif




    <!-- Thêm jQuery và SweetAlert2 -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- //KHÁCH HÀNG VÃN LAI --}}
    {{-- <script>
        $(document).ready(function() {
            $('#showFormAddress_WalkInCustomers').on('click', async function(e) {
                e.preventDefault(); // Ngăn chặn hành vi mặc định của thẻ a
    
                const {
                    value: formValues
                } = await Swal.fire({
                    title: "Nhập thông tin",
                    html: `
                        <input id="swal-input1" class="swal2-input" placeholder="Số điện thoại">
                        <input id="swal-input2" class="swal2-input" placeholder="Họ tên">
                        <input id="swal-input3" class="swal2-input" placeholder="Email">
                        <input id="swal-input4" class="swal2-input" placeholder="Địa chỉ">
                    `,
                    focusConfirm: false,
                    preConfirm: () => {
                        return [
                            document.getElementById("swal-input1").value,
                            document.getElementById("swal-input2").value,
                            document.getElementById("swal-input3").value,
                            document.getElementById("swal-input4").value
                        ];
                    }
                });
    
                if (formValues) {
                    // Hiển thị giá trị đã nhập
                    Swal.fire(JSON.stringify(formValues));
    
                    // Gửi dữ liệu về controller thông qua AJAX
                    $.ajax({
                        url: '/update-info-/update-info-order-WalkInCus', // Đường dẫn đến route Laravel xử lý dữ liệu
                        method: 'POST',
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content'), // CSRF token
                            SoDienThoai: formValues[0],
                            HoTen: formValues[1],
                            Email: formValues[2],
                            DiaChi: formValues[3]
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Thành công!',
                                text: response.message
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    location.reload(); // Tự động tải lại trang
                                }
                            });
                        },
                        error: function(xhr, status, error) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Lỗi!',
                                text: xhr.responseText
                            });
                        }
                    });
                }
            });
        });
    </script> --}}


    <script>
        // Get the modal
        var modal = document.getElementById("myModal");

        // Get the button that opens the modal
        var btn = document.getElementById("myBtn");

        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[0];

        // When the user clicks the button, open the modal 
        btn.onclick = function() {
            modal.style.display = "block";
        }

        // When the user clicks on <span> (x), close the modal
        span.onclick = function() {
            modal.style.display = "none";
        }

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>

    {{-- //END --}}



    {{-- //KHÁCH HÀNG ĐÃ ĐĂNG NHÂP --}}
    <script>
        $(document).ready(function() {
            $('#showForm').on('click', async function(e) {
                e.preventDefault(); // Ngăn chặn hành vi mặc định của thẻ a

                const {
                    value: formValues
                } = await Swal.fire({
                    title: "Cập Nhật Thông Tin",
                    html: `
        <input id="swal-input1" class="swal2-input" placeholder="Địa chỉ">
        <input id="swal-input2" class="swal2-input" placeholder="Số điện thoại">
      `,
                    focusConfirm: false,
                    preConfirm: () => {
                        return [
                            document.getElementById("swal-input1").value,
                            document.getElementById("swal-input2").value
                        ];
                    }
                });

                if (formValues) {
                    // Hiển thị giá trị đã nhập
                    Swal.fire(JSON.stringify(formValues));

                    // Gửi dữ liệu về controller thông qua AJAX
                    $.ajax({
                        url: '/update-info-order', // Đường dẫn đến route Laravel xử lý dữ liệu
                        method: 'POST',
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content'), // CSRF token
                            DiaChi: formValues[0],
                            SoDienThoai: formValues[1]
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Thành công!',
                                text: response.message
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    location.reload(); // Tự động tải lại trang
                                }
                            });
                        },
                        error: function(xhr, status, error) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Lỗi!',
                                text: xhr.responseText
                            });
                        }
                    });
                }
            });
        });
    </script>


@endsection
