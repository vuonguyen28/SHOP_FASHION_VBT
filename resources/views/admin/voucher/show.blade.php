@extends('admin.layout.app')
@section('title', 'VOUCHER DETAILS')

@section('content')
    <div class="container mt-3">
        <div class="card">
            <div class="card-body d-flex justify-content-between align-items-center">
                <a href="{{ route('voucher.index') }}" class="btn btn-secondary"><i class='bx bx-arrow-back'> Back to Index</i></a>
                <h4 style="margin: 0;">Chi tiết voucher: <span style="color: red">{{ $voucher->MA_VOUCHER }}</span></h4>
                <div></div>
            </div>
            <div class="card-body">
                <table class="table">
                    <tr>
                        <th>MÃ VOUCHER:</th>
                        <td>{{ $voucher->MA_VOUCHER }}</td>
                    </tr>
                    <tr>
                        <th>TÊN VOUCHER:</th>
                        <td>{{ $voucher->Ten_VOUCHER }}</td>
                    </tr>
                    <tr>
                        <th>PHẦN TRĂM GIẢM:</th>
                        <td>{{ $voucher->PhanTramGiam }}</td>
                    </tr>
                    <tr>
                        <th>ĐƠN TỐI THIỂU:</th>
                        <td>{{ $voucher->DonToiThieu }}</td>
                    </tr>
                    <tr>
                        <th>GIẢM TỐI ĐA:</th>
                        <td>{{ $voucher->GiamToiDa }}</td>
                    </tr>
                    <tr>
                        <th>SỐ LƯỢNG VOUCHER:</th>
                        <td>{{ $voucher->SoLuongVOUCHER }}</td>
                    </tr>
                    <tr>
                        <th>NGÀY BẮT ĐẦU:</th>
                        <td>{{ $voucher->Ngaybatdau }}</td>
                    </tr>
                    <tr>
                        <th>NGÀY KẾT THÚC:</th>
                        <td>{{ $voucher->Ngayketthuc }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
@endsection
