@extends('admin.layout.app')
@section('title','ADD NEW VOUCHER')

@section('content')
    <div class="container mt-3">
        <form action="{{ route('voucher.store') }}" method="POST">
            @csrf 
            <div class="mb-3 mt-3">
                <label for="MA_VOUCHER">MÃ VOUCHER</label>
                <input type="text" name="MA_VOUCHER" class="form-control" id="MA_VOUCHER" placeholder="Code VOUCHER" required>
            </div>
            <div class="mb-3 mt-3">
                <label for="Ten_VOUCHER">TÊN VOUCHER</label>
                <input type="text" name="Ten_VOUCHER" class="form-control" id="Ten_VOUCHER" placeholder="Name VOUCHER" required>
            </div>
            <div class="mb-3 mt-3">
                <label for="PhanTramGiam">PHẦN TRĂM GIẢM</label>
                <input type="number" name="PhanTramGiam" class="form-control" id="PhanTramGiam" placeholder="Percent reduction" required>
            </div>
            <div class="mb-3 mt-3">
                <label for="DonToiThieu">ĐƠN TỐI THIỂU</label>
                <input type="number" name="DonToiThieu" class="form-control" id="DonToiThieu" placeholder="Minimum order" required>
            </div>
            <div class="mb-3 mt-3">
                <label for="GiamToiDa">GIẢM TỐI ĐA</label>
                <input type="number" name="GiamToiDa" class="form-control" id="GiamToiDa" placeholder="Minimize" required>
            </div>
            <div class="mb-3 mt-3">
                <label for="SoLuongVOUCHER">SỐ LƯỢNG VOUCHER</label>
                <input type="number" name="SoLuongVOUCHER" class="form-control" id="SoLuongVOUCHER" placeholder="Quantity" required>
            </div>
            <div class="mb-3 mt-3">
                <label for="Ngaybatdau">NGÀY BẮT ĐẦU</label>
                <input type="datetime-local" name="Ngaybatdau" class="form-control" id="Ngaybatdau" required>
            </div>
            <div class="mb-3 mt-3">
                <label for="Ngayketthuc">NGÀY KẾT THÚC</label>
                <input type="datetime-local" name="Ngayketthuc" class="form-control" id="Ngayketthuc" required>
            </div>

            <button class="btn btn-primary" type="submit">ADD NEW VOUCHER</button>
        </form>
    </div>
@endsection
