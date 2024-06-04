@extends('admin.layout.app')
@section('title', 'THÊM HÌNH ẢNH')

@section('content')
    <div class="container mt-3">
        <form action="{{ route('image.store', ['MaSP' => $MaSP]) }}" method="POST" enctype="multipart/form-data">
            @csrf {{-- Cross-Site Request Forgery --}}
            <div class="mb-3 mt-3">
                <label for="hinhanh">Hình ảnh</label>
                <input type="file" name="hinhanh[]" class="form-control" id="hinhanh" placeholder="product name" multiple required>
            </div>

            <div class="mb-3 mt-3">
                <label>MaSP</label>
                <input type="text" name="MaSP" class="form-control" value="{{ $MaSP }}" >
            </div>
            

            <button class="btn btn-primary" type="submit">Create Product</button>
        </form>
    </div>
@endsection
