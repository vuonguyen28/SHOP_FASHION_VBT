@extends('admin.layout.app')
@section('title','EDIT Product')

@section('content')
  
    <div class="container mt-3">
        <form action="{{ route('product.update', $product->MaSP) }}}" method="POST">
            @csrf 
            @method('PUT') 
            <div class="mb-3 mt-3">
                <label for="TenSP">TÊN SẢN PHẨM</label>
                <input type="text" name="TenSP" value="{{ $product->TenSP }}" class="form-control" id="TenSP" placeholder="Product Name" required>
            </div>

            <div class="mb-3 mt-3">
                <label for="Gia">GIÁ</label>
                <input type="text" name="Gia" value="{{ $product->Gia }}" class="form-control" id="Gia" placeholder="Product Price" required>
            </div>

            <div class="mb-3 mt-3">
                <label for="PhanTramGiamGia">PHẦN TRĂM GIẢM GIÁ</label>
                <input type="text" name="PhanTramGiamGia" value="{{ $product->PhanTramGiamGia }}" class="form-control" id="PhanTramGiamGia" placeholder="Percent Discount" >
            </div>

            <div class="mb-3 mt-3">
                <label for="MoTa">MÔ TẢ</label>
                <input type="text" name="MoTa" value="{{ $product->MoTa }}" class="form-control" id="MoTa" placeholder="Description" required>
            </div>

            <div class="mb-3 mt-3">
                <label for="category_id">DANH MỤC</label>
                <select name="MaDanhMuc" class="form-control" id="category_id" required>
                    @foreach($category as $category)
                        <option value="{{ $category->MaDanhMuc }}" {{ $category->MaDanhMuc == $product->MaDanhMuc ? 'selected' : '' }}>{{ $category->TenDanhMuc }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3 mt-3">
                <label for="supplier_id">NHÀ CUNG CẤP</label>
                <select name="MaNhaCungCap" class="form-control" id="supplier_id" required>
                    @foreach($supplier as $supplier)
                        <option value="{{ $supplier->MaNhaCungCap }}" {{ $supplier->MaNhaCungCap == $product->MaNhaCungCap ? 'selected' : '' }}>{{ $supplier->TenNhaCungCap }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3 mt-3">
                <label for="TrinhTrang">TÌNH TRẠNG</label>
                <input type="text" name="TrinhTrang" value="{{ $product->TrinhTrang }}" class="form-control" id="TrinhTrang" placeholder="Condition" required>
            </div>

            <button class="btn btn-primary" type="submit">Update Product</button>
        </form>
    </div>
@endsection
