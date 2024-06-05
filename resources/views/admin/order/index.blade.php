@extends('admin.layout.app')
@section('title', 'DANH SÁCH ĐƠN HÀNG')

@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <style>
        .table-wrapper {
            height: 600px;
            overflow: auto;
            position: relative;
            margin-top: 10px;
            width: auto;
        }

        .table thead {
            vertical-align: middle;
            position: sticky;
            top: 0;
            text-align: center;
            font-size: 12px;
        }

        .form__filter {
            display: flex;
            justify-content: space-around;
            align-items: center;
            background-color: #fff;
            padding: 20px;

        }

        .form__filter select {
            padding: 5px;
            margin-right: 10px;
        }

        .form__filter input {
            padding: 3px;
            margin-right: 10px;
        }
    </style>
    <div class="container-fill mt-3">
        <center>
            <h1><b>DANH SÁCH ĐƠN HÀNG</b></h1><br>
        </center>



        <div class="row ">
            <div class="form__filter">
                <form id="orderForm" action="{{ route('order.index') }}" method="POST">
                    @csrf
                    <select name="orderBy" onchange="this.form.submit()">
                        <option value="ASC" {{ $orderBy == 'ASC' ? 'selected' : '' }}>ASC DATE ORDER</option>
                        <option value="DESC" {{ $orderBy == 'DESC' ? 'selected' : '' }}>DESC DATE ORDER</option>
                    </select>

                    <select name="state" onchange="this.form.submit()">
                        <option value="Tất cả" {{ $state == 'Tất cả' ? 'selected' : '' }}>All</option>
                        <option value="Đã đặt hàng" {{ $state == 'Đã đặt hàng' ? 'selected' : '' }}>Đã Đặt Hàng</option>
                        <option value="ĐÃ GIAO" {{ $state == 'ĐÃ GIAO' ? 'selected' : '' }}>Đã Giao</option>
                        <option value="ĐÃ NHẬN" {{ $state == 'ĐÃ NHẬN' ? 'selected' : '' }}>Đã Nhận</option>
                        <option value="ĐANG GIAO" {{ $state == 'ĐANG GIAO' ? 'selected' : '' }}>Đang Giao</option>
                        <option value="ĐÃ HỦY" {{ $state == 'ĐÃ HỦY' ? 'selected' : '' }}>Đã Hủy</option>
                    </select>

                    <select name="paymentMethod" onchange="this.form.submit()">
                        <option value="Tất cả" {{ $paymentMethod == 'Tất cả' ? 'selected' : '' }}>Tất cả</option>
                        <option value="on_delivery" {{ $paymentMethod == 'Sau khi nhận hàng' ? 'selected' : '' }}>Sau khi
                            nhận
                            hàng
                        </option>
                        <option value="momo" {{ $paymentMethod == 'Thanh toán MoMo' ? 'selected' : '' }}>Thanh toán MoMo
                        </option>
                    </select>

                    <input type="text" name="customerPhone" placeholder="Customer Phone" value="{{ $customerPhone }}"
                        onchange="this.form.submit()">
                    <input type="text" name="address" placeholder="Address" value="{{ $address }}"
                        onchange="this.form.submit()">
                </form>
            </div>
        </div>


        <div class="table-wrapper" style="width:100%">
            <table class="table">
                <thead class="table-success">
                    <tr>
                        <th>MÃ ĐƠN</th>
                        <th>MÃ KHÁCH HÀNG</th>
                        <th>NGÀY ĐẶT</th>
                        <th>NGÀY GIAO DỰ KIẾN</th>
                        <th>TỔNG GIÁ</th>
                        <th>TỔNG TIỀN SAU GIẢM</th>
                        <th>PHÍ VẬN CHUYỂN</th>
                        <th>TRẠNG THÁI THANH TOÁN</th>
                        <th>HÌNH THỨC THANH TOÁN</th>
                        <th>TRẠNG THÁI ĐƠN</th>
                        <th>ĐỊA CHỈ</th>
                        <th>MÃ VOUCHER</th>
                        <th>SỐ ĐIỆN THOẠI</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $item)
                        <tr style="font-size: 12px">
                            <td>{{ $item->MaDonHang }}</td>
                            <td>{{ $item->MaKhachHang }}</td>
                            <td>{{ $item->NgayDat }}</td>
                            <td>{{ $item->NgayDuKienGiaoHang }}</td>
                            <td>{{ $item->TongGia }}</td>
                            <td>{{ $item->TongTienSauKhiGiamGia }}</td>
                            <td>{{ $item->PhiVanChuyen }}</td>
                            <td>{{ $item->TrangThaiThanhToan }}</td>
                            <td>{{ $item->HinhThucThanhToan }}</td>
                            <td>{{ $item->TrangThaiDonHang }}</td>
                            <td>{{ $item->DiaChiGiaoHang }}</td>
                            <td>{{ $item->MaVoucher }}</td>
                            <td>{{ $item->RecipientPhone }}</td>

                            <td>
                                <form method="POST" action="{{ Route('order.index_DetailOrder') }}">
                                    @csrf
                                    <input hidden type="text" value={{ $item->MaDonHang }} name = "id">
                                    <button class="btn btn-primary" type="submit"><i class='bx bx-wallet'></i></button>
                                </form>
                            </td>
                            {{-- <td>
                                <form method="POST" action="{{ Route('order.edit') }}">
                                    @csrf
                                    <input hidden type="text" value={{ $item->MaDonHang }} name = "id">
                                    <button class="btn btn-primary" type="submit"><i class='bx bx-edit'></i></button>
                                </form>
                            </td> --}}
                            <td>
                                <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                    data-bs-target="#updateAddressModal{{ $item->MaDonHang }}">
                                    <i class='bx bx-coin-stack'></i>
                                </button>
                            </td>



                            {{-- Update Address Modal --}}
                            <div class="modal" id="updateAddressModal{{ $item->MaDonHang }}">
                                <div class="modal-dialog">
                                    <form action="{{ route('order.update') }}" method="POST">
                                        @csrf
                                        <div class="modal-content">

                                            {{-- Modal Header --}}
                                            <div class="modal-header">
                                                <h4 class="modal-title">Cập nhật trạng thái đơn hàng</h4>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>

                                            <div class="modal-body">
                                                <input type="hidden" name="sumTotalMoney" value="">
                                                <div class="form-group">
                                                    <label for="MaDonHang{{ $item->MaDonHang }}">Mã Đơn Hàng</label>
                                                    <input readonly value="{{ $item->MaDonHang }}" name="id"
                                                        type="text" class="form-control"
                                                        id="phone{{ $item->MaDonHang }}" placeholder="text">
                                                </div>


                                                <div class="mb-3 mt-3">
                                                    <label for="TrangThaiDonHang">TRẠNG THÁI ĐƠN HÀNG</label>
                                                    {{-- <input type="text" name="TrangThaiDonHang" value="{{ $order->TrangThaiDonHang }}" class="form-control" id="TrangThaiDonHang" placeholder="TrangThaiDonHang" required> --}}
                                                    <select name="TrangThaiDonHang" value="{{ $item->TrangThaiDonHang }}"
                                                        class="form-control" id="TrangThaiDonHang">
                                                        <option name="TrangThaiDonHang">ĐÃ GIAO</option>
                                                        <option name="TrangThaiDonHang">ĐÃ HỦY</option>
                                                        <option name="TrangThaiDonHang">ĐÃ NHẬN</option>
                                                        <option name="TrangThaiDonHang">ĐANG GIAO</option>
                                                    </select>
                                                </div>
                                            </div>

                                            {{-- Modal Footer --}}
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-danger">Update Order</button>
                                            </div>

                                        </div>
                                    </form>
                                </div>
                            </div>

                        </tr>
                    @endforeach
                    @if ($orderDetail->count() != 0)


                        <table class="table table-hover">
                            <thead style="background-color: #cf14a4">
                                <th>Mã đơn Hàng</th>
                                <th>Tên Sản Phẩm</th>
                                <th>Màu</th>
                                <th>Size</th>
                                <th>Gia</th>
                                <th>SoLuong</th>
                            </thead>
                            <tbody>
                                @foreach ($orderDetail as $detail)
                                    <tr>
                                        <td>{{ $detail->MaDonHang }}</td>
                                        <td>{{ $detail->ProductDetails->Product->TenSP }}</td>
                                        <td>{{ $detail->ProductDetails->Color->TenMau }}</td>
                                        <td>{{ $detail->ProductDetails->Size->TenKichThuoc }}</td>
                                        <td>{{ $detail->Gia }}</td>
                                        <td>{{ $detail->SoLuong }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>



                    @endif

                </tbody>
            </table>


        </div>
    </div>
@endsection
