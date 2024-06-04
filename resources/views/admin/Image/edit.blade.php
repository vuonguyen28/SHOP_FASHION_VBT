@extends('admin.layout.app')
@section('title','EDIT CUSTOMERS')

@section('content')
    <div class="container mt-3">
        <form action="{{ route('customers.update', $customer->MaKH) }}" method="POST" enctype="multipart/form-data">
            @csrf {{-- Cross-Site Request Forgery --}}
            @method('PUT')
            
            <div class="mb-3 mt-3">
                <label for="hinhanh">Image Product</label>
                <input type="file" name="hinhanh">
            </div>

            <div class="mb-3 mt-3">
                <label for="hinhanh">Hình ảnh hiện tại:</label>
                <img src="{{ asset('product/' . $image->hinhanh) }}" width="100" height="100" alt="Current Avatar">
            </div>
            
            <button class="btn btn-primary" type="submit">Update Image</button>
        </form>
    </div>
@endsection
