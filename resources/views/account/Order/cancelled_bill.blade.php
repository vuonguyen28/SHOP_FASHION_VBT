@extends('account.layouts.layout')

@section('title', 'BILL CUSTOMER')

@section('content')

    {{-- menu right --}}
    @include('account.Order.menu_layout_bill')
    @include('account.Order.layout_header_bill')


    {{-- end header --}}
    {{-- start content --}}

    @if (session('success'))
        <script>
            Swal.fire({
                title: "The Internet?",
                text: " {{ session('success') }}",
                icon: "success"
            });
        </script>
    @endif
    <div class="row form__bill--content">

        @foreach ($orders as $item)
            <div class="row form__bill--main">

                <div class="col-md-1">
                    <p>#{{ $item->MaDonHang }}</p>
                </div>

                {{-- Order date and delivery date --}}
                <div class="col-md-1">
                    <p>Ngày đặt</p>
                    <h6>{{ $item->NgayDat }}</h6>
                    <p>Ngày dự kiến giao:</p>
                    <h6>{{ $item->NgayDuKienGiaoHang }}</h6>
                </div>

                {{-- Voucher code --}}
                <div class="col-md-1">
                    <p>Mã Voucher:</p>
                    @if (!$item->MaVoucher)
                        <h6># không áp dụng</h6>
                    @else
                        <h6>#{{ $item->MaVoucher }}</h6>
                    @endif
                </div>

                {{-- Total and total after applying voucher --}}
                <div class="col-md-2">
                    <p>Tổng tiền:</p>
                    <h6>{{ $item->TongGia }}</h6>
                    <p>Tổng tiền sau khi giảm:</p>
                    <h6>{{ $item->TongTienSauKhiGiamGia }}</h6>
                </div>

                {{-- Delivery fee --}}
                <div class="col-md-1">
                    <p>Phí vận chuyển:</p>
                    <h6>{{ $item->PhiVanChuyen }}</h6>
                </div>

                {{-- Payment status and method --}}
                <div class="col-md-2">
                    <p>Trạng thái thanh toán:</p>
                    <h6>{{ $item->TrangThaiThanhToan }}</h6>
                    <p>Phương thức thanh toán:</p>
                    <h6>{{ $item->HinhThucThanhToan }}</h6>
                </div>

                {{-- Order status, address, and phone --}}
                <div class="col-md-2">
                    <p>Trạng thái đơn hàng:</p>
                    <h6>{{ $item->TrangThaiDonHang }}</h6>
                    <button type="button" class="btn" data-bs-toggle="modal"
                        data-bs-target="#updateAddressModal{{ $item->MaDonHang }}">
                        cập nhật địa chỉ
                    </button>
                    <h6>{{ $item->DiaChiGiaoHang }}</h6>
                    <p>SĐT nhận hàng: </p>
                    <h6>{{ $item->RecipientPhone }}</h6>
                </div>

                {{-- Update Address Modal --}}
                <div class="modal" id="updateAddressModal{{ $item->MaDonHang }}">
                    <div class="modal-dialog">
                        <form action="{{ route('Order.UpdateAdressAndPhone') }}" method="POST">
                            @csrf
                            <div class="modal-content">

                                {{-- Modal Header --}}
                                <div class="modal-header">
                                    <h4 class="modal-title">Cập nhật địa chỉ</h4>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <div class="modal-body">
                                    <input type="hidden" name="sumTotalMoney" value="">

                                    <div class="form-group">
                                        <label for="MaDonHang{{ $item->MaDonHang }}">Mã Đơn Hàng</label>
                                        <input readonly value="{{ $item->MaDonHang }}" name="MaDonHang" type="text"
                                            class="form-control" id="phone{{ $item->MaDonHang }}" placeholder="text">
                                    </div>


                                    <div class="form-group">
                                        <label for="phone{{ $item->MaDonHang }}">Phone</label>
                                        <input required value="{{ $item->RecipientPhone }}" name="phone" type="phone"
                                            class="form-control" id="phone{{ $item->MaDonHang }}" placeholder="Phone">
                                    </div>

                                    <div class="form-group">
                                        <label for="address{{ $item->MaDonHang }}">Địa chỉ</label>
                                        <input required value="{{ $item->DiaChiGiaoHang }}" name="Address" type="text"
                                            class="form-control" id="address{{ $item->MaDonHang }}" placeholder="Địa chỉ">
                                    </div>
                                </div>

                                {{-- Modal Footer --}}
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-danger">Cập nhật địa chỉ</button>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>

                {{-- Button to see details --}}
                <div class="col-md-2">
                    <div class="bill__info--btn">
                        <form action="{{ route('bill.ShowCancelledBill_Detail_Bill') }}" method="POST">
                            @csrf
                            <input type="hidden" value="{{ $item->MaDonHang }}" name="MaDonHang">
                            <button class="btn_seeDetail"><a>Chi tiết</a></button>
                        </form>
                        <br>
                    </div>
                </div>

            </div>
        @endforeach

        {{-- @endforeach --}}

        @if ($check == 1)
            @foreach ($orderDetail as $item)
                <div class="form__bill--detail">
                    {{-- product img --}}
                    <div class="col-md-2">
                        <div class="bill__img--product">
                            @if ($item->ProductDetails && $item->ProductDetails->Product && $item->ProductDetails->Product->images)
                                @foreach ($item->ProductDetails->Product->images->take(1) as $img)
                                    <img src="{{ $img->hinhanh }}">
                                @endforeach
                            @else
                                <p>No images found for this product.</p>
                            @endif
                        </div>
                    </div>
                    {{-- product info --}}
                    <div class="col-md-10">
                        {{-- row detail --}}
                        <div class="row">
                            {{-- name - size - color - quantity --}}
                            <div class="col-md-2">
                                <div class="bill__info--col1">
                                    <h4>{{ $item->ProductDetails->Product->TenSP }}</h4>
                                    <p>Size:{{ $item->ProductDetails->Size->TenKichThuoc }}</p>
                                    <p>Color: {{ $item->ProductDetails->Color->TenMau }}</p>
                                    <p>Quantity: {{ $item->SoLuong }}</p>
                                </div>
                            </div>

                            {{-- order date - price --}}
                            <div class="col-md-3">
                                <div class="bill__infor--col2">
                                    <h4>Price: </h4>
                                    <p>300.000 vnđ</p>
                                </div>
                            </div>

                            {{-- success date - price total --}}
                            <div class="col-md-5    ">
                                <div class="bill__infor--col3">
                                    <h4>Total: </h4>
                                    <p>{{ $item->Gia }} vnđ</p>
                                </div>
                            </div>



                            {{-- state --}}
                            <div class="col-md-1">
                                <div class="state_delive">
                                    <i class='bx bx-loader'></i>
                                    {{-- <p>{{ $item->TrangThaiDonHang }}</p> --}}
                                </div>
                            </div>
                        </div>
                        <hr style="border: 1px solid black">
                        {{-- row location --}}
                        <div class="row">
                            <div class="location__phone">
                                {{-- <p><i class='bx bxs-map'></i> {{ $item->DiaChiGiaoHang }}</p> --}}
                                {{-- <h6><i class='bx bxs-phone'></i> SDT nhận hàng: {{ $item->RecipientPhone }} </h6> --}}
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
        {{-- đặt foreach ở đây --}}


        {{-- end form bill  --}}
    </div>





@endsection
