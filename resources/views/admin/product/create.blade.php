@extends('admin.layout.app')
@section('title','ADD NEW PRODUCT')

@section('content')
    <div class="container mt-3">
        <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3 mt-3">
                <label for="TenSP">TÊN SẢN PHẨM</label>
                <input type="text" name="TenSP" class="form-control" id="TenSP" placeholder="product name" required>
            </div>

            <div class="mb-3 mt-3">
                <label for="Gia">GIÁ</label>
                <input type="text" name="Gia" class="form-control" id="TenSP" placeholder="Product Price" required>
            </div>
            <div class="mb-3 mt-3">
                <label for="PhanTramGiamGia">PHẦN TRĂM GIẢM GIÁ</label>
                <input type="text" name="PhanTramGiamGia" class="form-control" id="TenSP" placeholder="percent discount" >
            </div>

            <div class="mb-3 mt-3">
                <label for="MoTa">MÔ TẢ</label>
                <input type="text" name="MoTa" class="form-control" id="TenSP" placeholder="describe" required>
            </div>
            <div class="mb-3 mt-3">
                <label for="category_id">DANH MỤC</label>
                <select name="MaDanhMuc" class="form-control" id="category_id" required>
                    @foreach($categories as $category)
                        <option value="{{ $category->MaDanhMuc }}">{{ $category->TenDanhMuc }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3 mt-3">
                <label for="category_id">NHÀ CUNG CẤP</label>
                <select name="MaNhaCungCap" class="form-control" id="category_id" required>
                    @foreach($supplier as $supplier)
                        <option value="{{ $supplier->MaNhaCungCap }}">{{ $supplier->TenNhaCungCap }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3 mt-3">
                <label for="TrinhTrang">TÌNH TRẠNG</label>
                <input type="text" name="TrinhTrang" class="form-control" id="TenSP" placeholder="condition" required>
            </div>

            <div class="mb-3 mt-3">
                <label for="hinhanh">HÌNH ẢNH</label>
                <input type="file" name="hinhanh[]" class="form-control" id="hinhanh" placeholder="product name" multiple required>
            </div>

            <button class="btn btn-primary" type="submit">ADD NEW PRODUCT</button>
        </form>
    </div>
@endsection
