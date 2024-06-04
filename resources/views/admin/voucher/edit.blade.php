@extends('admin.layout.app')
@section('title', 'EDIT VOUCHER')

@section('content')
    <div class="container mt-3">
        <form action="{{ route('voucher.update', $voucher->MA_VOUCHER) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3 mt-3">
                <label for="Ten_VOUCHER">TÊN VOUCHER</label>
                <input type="text" name="Ten_VOUCHER" value="{{ $voucher->Ten_VOUCHER }}" class="form-control"
                    id="Ten_VOUCHER" placeholder="Name VOUCHER" required>
            </div>
            <div class="mb-3 mt-3">
                <label for="PhanTramGiam">PHẦN TRĂM GIẢM</label>
                <input type="number" step="0.01" name="PhanTramGiam" value="{{ $voucher->PhanTramGiam }}"
                    class="form-control" id="PhanTramGiam" placeholder="Percent reduction" required>
            </div>
            <div class="mb-3 mt-3">
                <label for="DonToiThieu">ĐƠN TỐI THIỂU</label>
                <input type="number" step="0.01" name="DonToiThieu" value="{{ $voucher->DonToiThieu }}"
                    class="form-control" id="DonToiThieu" placeholder="Minimum order" required>
            </div>
            <div class="mb-3 mt-3">
                <label for="GiamToiDa">GIẢM TỐI ĐA</label>
                <input type="number" step="0.01" name="GiamToiDa" value="{{ $voucher->GiamToiDa }}" class="form-control"
                    id="GiamToiDa" placeholder="Minimize" required>
            </div>
            <div class="mb-3 mt-3">
                <label for="SoLuongVOUCHER">SỐ LƯỢNG VOUCHER</label>
                <input type="number" name="SoLuongVOUCHER" value="{{ $voucher->SoLuongVOUCHER }}" class="form-control"
                    id="SoLuongVOUCHER" placeholder="Quantity" required>
            </div>
            <div class="mb-3 mt-3">
                <label for="Ngaybatdau">NGÀY BẮT ĐẦU</label>
                <input type="datetime-local" name="Ngaybatdau" value="{{ $voucher->Ngaybatdau }}" class="form-control"
                    id="Ngaybatdau" placeholder="Start day" required>
            </div>
            <div class="mb-3 mt-3">
                <label for="Ngayketthuc">NGÀY KẾT THÚC</label>
                <input type="datetime-local" name="Ngayketthuc" value="{{ $voucher->Ngayketthuc }}" class="form-control"
                    id="Ngayketthuc" placeholder="End date" required>
            </div>
            <button class="btn btn-primary" type="submit">SAVE VOUCHER</button>
        </form>
    </div>
@endsection
