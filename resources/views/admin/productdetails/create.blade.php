@extends('admin.layout.app')
@section('title', 'ADD NEW PRODUCT DETAIL')

@section('content')
    <div class="container mt-3">
        <form action="{{ route('productdetails.store') }}" method="POST">
            @csrf
            <div class="mb-3 mt-3">
                <label for="product_name">SẢN PHẨM</label>
                @if(isset($product))
                    <input type="text" name="product_name" class="form-control" id="product_name" value="{{ $product->TenSP }}" readonly>
                    <input type="hidden" name="MaSP" value="{{ $product->MaSP }}">
                @else
                    <input type="text" name="product_name" class="form-control" id="product_name" value="Chưa chọn sản phẩm" readonly>
                @endif
            </div>
            <div class="mb-3 mt-3">
                <label for="size_id">KÍCH THƯỚC</label>
                <select name="MaKichThuoc" class="form-control" id="size_id" required>
                    @foreach ($sizes as $s)
                        <option value="{{ $s->MaKichThuoc }}">{{ $s->TenKichThuoc }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3 mt-3">
                <label for="color_id">MÀU SẮC</label>
                <select name="MaMau" class="form-control" id="color_id" required>
                    @foreach ($colors as $c)
                        <option value="{{ $c->MaMau }}">{{ $c->TenMau }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3 mt-3">
                <label for="SoLuongTon">SỐ LƯỢNG TỒN</label>
                <input type="number" name="SoLuongTon" class="form-control" id="SoLuongTon" placeholder="Số lượng" required>
            </div>

            <button class="btn btn-primary" type="submit">ADD NEW PRODUCT DETAILS</button>
        </form>
    </div>
@endsection
