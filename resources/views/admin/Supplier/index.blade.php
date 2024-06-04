@extends('admin.layout.app')
@section('title','LIST SUPPLIER')

@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="container mt-3">
        <center>
            <h4>LIST SUPPLIER</h4>
        </center>
        <table class="table">
            <thead class="table-success">
                <a class="btn btn-primary" href="{{ route('supplier.store') }}">
                    <i class='bx bxs-add-to-queue'></i> Create
                </a>
                <tr>
                    <th>ID</th>
                    <th>TÊN NHÀ CUNG CẤP</th>
                    <th>ĐẠI CHỈ</th>
                    <th>SỐ ĐIỆN THOẠI</th>
                    <th>Edit</th>
                    <th>Delete</th>
                    <th>Details</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($supplier as $c)
                    <tr>
                        <td>{{ $c->MaNhaCungCap }}</td>
                        <td>{{ $c->TenNhaCungCap }}</td>
                        <td>{{ $c->DiaChi }}</td>
                        <td>{{ $c->SoDienThoai }}</td>

                        <td>
                            <a href="{{ route('supplier.edit', $c->MaNhaCungCap) }}" class="btn btn-primary">
                                <i class='bx bx-edit'></i>
                            </a>
                        </td>
                        <td>
                            <form action="{{ route('supplier.destroy', $c->MaNhaCungCap) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-warning">
                                    <i class='bx bx-trash'></i>
                                </button>
                            </form>
                        </td>
                        <td>
                            <a href="{{ route('supplier.show',  $c->MaNhaCungCap) }}" class="btn btn-success">
                                <i class='bx bxs-cart-alt'></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
