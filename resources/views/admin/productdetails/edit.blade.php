@extends('admin.layout.app')
@section('title', 'EDIT PRODUCTDETAILS')

@section('content')
    <div class="container mt-3">
        <form action="{{ route('productdetails.update', $productdetails->MaChiTiet) }}" method="POST" enctype="multipart/form-data">
            @csrf 
            @method('PUT')
            <div class="mb-3 mt-3">
                <label for="MaSP">SẢN PHẨM:</label>
                <select class="form-select" id="MaSP" name="MaSP" readonly>
                    @foreach ($product as $product)
                        <option value="{{ $product->MaSP }}" {{ $product->MaSP == $productdetails->MaSP ? 'selected' : '' }}>
                            {{ $product->TenSP }}</option>
                    @endforeach
                </select>
            </div>            
            <div class="mb-3 mt-3">
                <label for="MaKichThuoc">KÍCH THƯỚC:</label>
                <select class="form-select" id="MaKichThuoc" name="MaKichThuoc">
                    @foreach ($size as $size)
                        <option value="{{ $size->MaKichThuoc }}" {{ $size->MaKichThuoc == $productdetails->MaKichThuoc ? 'selected' : '' }}>
                            {{ $size->TenKichThuoc }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3 mt-3">
                <label for="MaMau">MÀU SẮC:</label>
                <select class="form-select" id="MaMau" name="MaMau">
                    @foreach ($color as $color)
                        <option value="{{ $color->MaMau }}" {{ $color->MaMau == $productdetails->MaMau ? 'selected' : '' }}>
                            {{ $color->TenMau }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3 mt-3">
                <label for="SoLuongTon">SỐ LƯỢNG:</label>
                <input type="number" name="SoLuongTon" value="{{ $productdetails->SoLuongTon }}" class="form-control"
                    id="SoLuongTon" placeholder="Enter discount percentage" required>
            </div>
            
            <button class="btn btn-primary" type="submit">SAVE PRODUCT DETAILS</button>
        </form>
    </div>
@endsection
