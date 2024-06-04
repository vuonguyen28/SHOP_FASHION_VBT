@extends('account.layouts.layout')

@section('title', 'BILL CUSTOMER')

@section('content')

    <h1>CHECK ODER CUSOTMER WalkInCustomers</h1>

    <form method="POST" action="{{ route('show.searchBill_WalkInCustomers') }}">
        @csrf
        <input value="{{ session('phone_search') }}" type="number" name="phone">
        <button>search bill</button>
    </form>
    <div class="container mt-3">

        <table class="table ">
            <tbody>
                @foreach ($orders as $item)
                    <tr>
                        <td>{{ $item->MaDonHang }}</td>
                        <td>{{ $item->NgayDat }}</td>
                        <td>{{ $item->NgayDuKienGiaoHang }}</td>
                        <td>{{ $item->TongGia }}</td>
                        <td>{{ $item->TongTienSauKhiGiamGia }}</td>
                        <td>{{ $item->TrangThaiThanhToan }}</td>
                        <td>{{ $item->HinhThucThanhToan }}</td>
                        <td>{{ $item->TrangThaiDonHang }}</td>
                        <td>{{ $item->DiaChiGiaoHang }}</td>
                        <td>{{ $item->MaVoucher }}</td>
                        <td>{{ $item->RecipientPhone }}</td>
                        <td>
                            <form action="{{ route('show.detailOrder') }}" method="POST">
                                @csrf
                                <h1>{{ session('check_show_order_detail') }}</h1>
                                <input hidden value="{{ session('phone_search') }}" name="Phone" type="number" name="phone">
                                <input hidden name="ID_ORDER" value="{{ $item->MaDonHang }}">
                                <button type="submit">Xem Chi tiết</button>
                            </form>
                        </td>
                    </tr>

                    
                        @if($check ==1 )
                            @foreach ($orderDetail as $itemDetail)
                            <tr>
                                <td>
                                    {{ $itemDetail->ProductDetails->Product->TenSP }}
                                </td>
                                <td>
                                    {{ $itemDetail->ProductDetails->Color->TenMau }}
                                </td>

                                <td>
                                    {{ $itemDetail->ProductDetails->Size->TenKichThuoc }}
                                </td>

                                <td>
                                    {{ $itemDetail->Gia }}
                                </td>

                                <td>
                                    {{ $itemDetail->SoLuong }}
                                </td>
                            </tr>
                            @endforeach
                        @endif
                    
                @endforeach
            </tbody>
        </table>
    </div>

    
@endsection
