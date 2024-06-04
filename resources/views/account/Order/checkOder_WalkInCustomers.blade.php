@extends('account.layouts.layout')

@section('title', 'BILL CUSTOMER')

@section('content')

    <div class="container">
        <div class="form__checkOrder">
            <h1 class="title__checkOrder">Kiểm Tra Đơn Hàng</h1>
            <p>Vui lòng nhập số điện thoại điểm kiểm tra đơn hàng của bạn.</p>

            <div class="col-12">
                <form method="POST" action="{{ route('show.searchBill_WalkInCustomers') }}">
                    @csrf
                    <input value="{{ session('phone_search') }}" type="number" name="phone"
                        placeholder="Nhập số điện thoại...">
                    <button><i class='bx bx-search-alt-2'></i></button>
                </form>
            </div>
        </div>

        <div class="container mt-3 form__Order--content">
            <div class="row">
                @foreach ($orders as $item)
                    <div class="row">
                        <div class="list__ordercheck">
                            <div class="col-md-1">
                                <i class='bx bx-package'></i>
                            </div>

                            <div class="col-md-1 order_code">
                                <p>Mã Đơn:</p>
                                <h6>{{ $item->MaDonHang }}</h6>
                            </div>

                            <div class="col-md-1 order_date">
                                <p>Ngày đặt:</p>
                                <h6>{{ $item->NgayDat }}</h6>
                                <p>Ngày giao:</p>
                                <h6>{{ $item->NgayDuKienGiaoHang }}</h6>
                            </div>

                            <div class="col-md-2 order_price">
                                <p>Tổng tiền:</p>
                                <h6>{{ $item->TongGia }}</h6>
                                <p>Tổng tiền sau khi giảm:</p>
                                <h6 style="color: red; font-weight:bold">{{ $item->TongTienSauKhiGiamGia }}</h6>
                            </div>

                            <div class="col-md-2 pay_state_method">
                                <p>Hình thức thanh toán:</p>
                                <h6>{{ $item->HinhThucThanhToan }}</h6>
                                <p>Trạng thái thanh toán:</p>
                                <h6>{{ $item->TrangThaiThanhToan }}</h6>
                            </div>

                            <div class="col-md-2 order_state_voucher">
                                <p>Mã voucher:</p>
                                <h6>{{ $item->MaVoucher }}</h6>
                                <p>Trạng thái đơn hàng:</p>
                                <h6>{{ $item->TrangThaiDonHang }}</h6>
                            </div>

                            <div class="col-md-2 order_loca_phone">
                                <p>SĐT:</p>
                                <h6>{{ $item->RecipientPhone }}</h6>
                                <p>Địa chỉ:</p>
                                <h6>{{ $item->DiaChiGiaoHang }}</h6>
                            </div>

                            <div class="col-md-1 order__btn--seeDetails">
                                <form action="{{ route('show.detailOrder') }}" method="POST">
                                    @csrf
                                    <h1>{{ session('check_show_order_detail') }}</h1>
                                    <input hidden value="{{ session('phone_search') }}" name="Phone" type="number"
                                        name="phone">
                                    <input hidden name="ID_ORDER" value="{{ $item->MaDonHang }}">
                                    <button type="submit">Xem Chi tiết</button>
                                </form>
                            </div>

                        </div>
                        @if ($check == 1)
                            <h3 style="text-align: center; color:rgb(33, 196, 47); margin-top: 10px">Chi Tiết Đơn Hàng</h3>
                            @foreach ($orderDetail as $itemDetail)
                                <div class="row">
                                    <div class="form__details--click">
                                        <div class="col-md-3">
                                            <p>Tên Sản phẩm: </p>
                                            <h6> {{ $itemDetail->ProductDetails->Product->TenSP }}</h6>
                                        </div>
                                        <div class="col-md-1">
                                            <p>Color: </p>
                                            <h6> {{ $itemDetail->ProductDetails->Color->TenMau }}</h6>
                                        </div>

                                        <div class="col-md-2">
                                            <p>Size: </p>
                                            <h6> {{ $itemDetail->ProductDetails->Size->TenKichThuoc }}</h6>
                                        </div>

                                        <div class="col-md-3">
                                            <p>Số lượng:</p>
                                            <h6> {{ $itemDetail->SoLuong }}</h6>
                                        </div>

                                        <div class="col-md-3">
                                            <p>Giá:</p>
                                            <h6> {{ $itemDetail->Gia }}</h6>
                                        </div>

                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                @endforeach
            </div>

        </div>

       
    </div>


@endsection
