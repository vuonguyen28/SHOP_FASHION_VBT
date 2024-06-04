@extends('admin.layout.app')
@section('title','EDIT CATEGORY')

@section('content')
    <div class="container mt-3">
        <form action="{{ route('category.update', $category->MaDanhMuc) }}" method="POST">
            @csrf 
            @method('PUT')
            <div class="mb-3 mt-3">
                <label for="TenDanhMuc">TÊN DANH MỤC</label>
                <input type="text" name="TenDanhMuc" value="{{ $category->TenDanhMuc }}" class="form-control" id="TenDanhMuc"
                    placeholder="Name category" required>
            </div>

            <button class="btn btn-primary" type="submit">Save Category</button>
        </form>
    </div>
@endsection
