@extends('admin.layout.app')
@section('title','DETAILS CATEGORY')

@section('content')
    <div class="container mt-3">
        <div class="card">
            <div class="card-body d-flex justify-content-between align-items-center">
                <a href="{{ route('category.index') }}" class="btn btn-secondary"><i class='bx bx-arrow-back'> Back to Index</i></a>
                <h4 style="margin: 0;">Chi tiết danh mục của mã: <span style="color: red">{{ $category->MaDanhMuc }}</span></h4>
                <div></div>
            </div>
            <div class="card-body">
                <table class="table">
                    <tr>
                        <th>MÃ DANH MỤC:</th>
                        <td>{{ $category->MaDanhMuc }}</td>
                    </tr>
                    <tr>
                        <th>TÊN DANH MỤC:</th>
                        <td>{{ $category->TenDanhMuc }}</td>
                    </tr>
                </table><br>
                <a href="{{ route('category.edit', $category->MaDanhMuc) }}" class="btn btn-primary"><i class='bx bx-edit'>
                        Edit</i></a>
                <form action="{{ route('category.destroy', $category->MaDanhMuc) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger"><i class='bx bx-trash'> Delete</i></button>
                </form>
            </div>
        </div>
    </div>
@endsection
