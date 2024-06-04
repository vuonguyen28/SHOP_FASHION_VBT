@extends('admin.layout.app')
@section('title','EDIT SUPPLIER')

@section('content')
    <div class="container mt-3">
        <form action="{{ route('supplier.update', $supplier->MaNhaCungCap) }}" method="POST">
            @csrf {{-- Cross-Site Request Forgery --}}
            @method('PUT')
            <div class="mb-3 mt-3">
                <label for="TenNhaCungCap">TÊN NHÀ CUNG CẤP</label>
                <input type="text" name="TenNhaCungCap" value="{{ $supplier->TenNhaCungCap }}" class="form-control" id="supplier"
                    placeholder="name Supplier" required>
            </div>
            <div class="mb-3 mt-3">
                <label for="DiaChi">ĐỊA CHỈ</label>
                <input type="text" name="DiaChi" value="{{ $supplier->DiaChi }}" class="form-control" id="Adderss"
                    placeholder="Adderss" required>
            </div>
            <div class="mb-3 mt-3">
                <label for="SoDienThoai">SỐ ĐIỆN THOẠI</label>
                <input type="text" name="SoDienThoai" value="{{ $supplier->SoDienThoai }}" class="form-control" id="phone"
                    placeholder="Phone" required>
            </div>

            <button class="btn btn-primary" type="submit">SAVE SUPPLIER</button>
        </form>
    </div>
@endsection
