@extends('admin.layout.app')
@section('title','DETAILS SUPPLIER')

@section('content')
    <div class="container mt-3">
        <div class="card">
            <div class="card-body d-flex justify-content-between align-items-center">
                <a href="{{ route('supplier.index') }}" class="btn btn-secondary"><i class='bx bx-arrow-back'> Back to Index</i></a>
                <h4 style="margin: 0;">Chi tiết nhà cung cấp của mã: <span style="color: red">{{ $supplier->MaNhaCungCap }}</span></h4>
                <div></div>
            </div>
            <div class="card-body">
                <table class="table">
                    <tr>
                        <th>TÊN NHÀ CUNG CẤP</th>:</th>
                        <td>{{ $supplier->TenNhaCungCap }}</td>
                    </tr>
                    <tr>
                        <th>ĐỊA CHỈ:</th>
                        <td>{{ $supplier->DiaChi }}</td>
                    </tr>
                    <tr>
                        <th>SỐ ĐIỆN THOẠI:</th>
                        <td>{{ $supplier->SoDienThoai }}</td>
                    </tr>
                </table><br>
                <a href="{{ route('supplier.edit', $supplier->MaNhaCungCap) }}" class="btn btn-primary"><i class='bx bx-edit'>
                        Edit</i></a>
                <form action="{{ route('supplier.destroy', $supplier->MaNhaCungCap) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger"><i class='bx bx-trash'> Delete</i></button>
                </form>
            </div>
        </div>
    </div>
@endsection
