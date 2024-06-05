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

        .form__filter select{
            padding: 5px;
            margin-right: 10px;
        }

        .form__filter input{
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


        <div class="table-wrapper">
            <table class="table">
                <thead class="table-success">
                    <tr>
                        <th>MÃ ĐƠN</th>
                        <th>MÃ KHÁCH HÀNG</th>
                        <th>NGÀY ĐẶT</th>
                        </th>
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
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $item)
                        <tr>
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
                                <form method="POST" action="{{ Route('order.edit') }}">
                                    @csrf
                                    <input hidden type="text" value={{ $item->MaDonHang }} name = "id">
                                    <button class="btn btn-primary" type="submit"><i class='bx bx-edit'></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
