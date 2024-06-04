@extends('admin.layout.app')
@section('title','ADD NEW CATEGORY')

@section('content')
    <div class="container mt-3">
        <form action="{{ route('category.store') }}" method="POST">
            @csrf
            <div class="mb-3 mt-3">
                <label for="TenDanhMuc">TÊN DANH MỤC</label>
                <input type="text" name="TenDanhMuc" class="form-control" id="TenDanhMuc" placeholder="Name Category" required>
            </div>

            <button class="btn btn-primary" type="submit">Add New Category</button>
        </form>
    </div>
@endsection
