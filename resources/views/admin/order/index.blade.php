@extends('admin.layout.app')
@section('title', 'DANH SÁCH ĐƠN HÀNG')

@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="container mt-3">
        <center>
            <h4>DANH SÁCH ĐƠN HÀNG</h4>
        </center>



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
                <option value="on_delivery" {{ $paymentMethod == 'Sau khi nhận hàng' ? 'selected' : '' }}>Sau khi nhận hàng</option>
                <option value="momo" {{ $paymentMethod == 'Thanh toán MoMo' ? 'selected' : '' }}>Thanh toán MoMo</option>
            </select>
        
            <input type="text" name="customerPhone" placeholder="Customer Phone" value="{{ $customerPhone }}" onchange="this.form.submit()">
            <input type="text" name="address" placeholder="Address" value="{{ $address }}" onchange="this.form.submit()">
        </form>
        

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
@endsection
