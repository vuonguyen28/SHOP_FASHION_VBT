@extends('admin.layout.app')
@section('title','ADD NEW SUPPLIER')

@section('content')
    <div class="container mt-3">
        <form action="{{ route('supplier.store') }}" method="POST">
            @csrf {{-- Cross-Site Request Forgery --}}
            <div class="mb-3 mt-3">
                <label for="TenNhaCungCap">TÊN NHÀ CUNG CẤP</label>
                <input type="text" name="TenNhaCungCap" class="form-control" id="TenNhaCungCap" placeholder="Name Supplier" required>
            </div>

            <div class="mb-3 mt-3">
                <label for="DiaChi">ĐỊA CHỈ</label>
                <input type="text" name="DiaChi" class="form-control" id="DiaChi" placeholder=" Supplier Address" required>
            </div>

            <div class="mb-3 mt-3">
                <label for="Phone">SỐ ĐIỆN THOẠI</label>
                <input type="phone" name="SoDienThoai" class="form-control" id="SoDienThoai" placeholder=" Supplier Phone" required>
            </div>

            <button class="btn btn-primary" type="submit">ADD NEW SUPPLIER</button>
        </form>
    </div>
@endsection
