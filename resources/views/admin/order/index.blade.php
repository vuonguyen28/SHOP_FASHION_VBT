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
        <table class="table">
            <thead class="table-success">
                <tr>
                    <th>MÃ ĐƠN</th>
                    <th>MÃ KHÁCH HÀNG</th>
                    <th>NGÀY ĐẶT</th></th>
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
                        <td>{{ $item->MaDonHang  }}</td>                        
                        <td>{{ $item->MaKhachHang  }}</td>
                        <td>{{ $item->NgayDat  }}</td>
                        <td>{{ $item->NgayDuKienGiaoHang  }}</td>
                        <td>{{ $item->TongGia  }}</td>
                        <td>{{ $item->TongTienSauKhiGiamGia  }}</td>
                        <td>{{ $item->PhiVanChuyen  }}</td>
                        <td>{{ $item->TrangThaiThanhToan  }}</td>
                        <td>{{ $item->HinhThucThanhToan  }}</td>
                        <td>{{ $item->TrangThaiDonHang  }}</td>
                        <td>{{ $item->DiaChiGiaoHang  }}</td>
                        <td>{{ $item->MaVoucher  }}</td>
                        <td>{{ $item->RecipientPhone  }}</td>
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
