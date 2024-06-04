@extends('admin.layout.app')
@section('title','ADD NEW SIZE')

@section('content')
    <div class="container mt-3">
        <form action="{{ route('size.store') }}" method="POST">
            @csrf {{-- Cross-Site Request Forgery --}}
            <div class="mb-3 mt-3">
                <label for="TenKichThuoc">TÊN KÍCH THƯỚC</label>
                <input type="text" name="TenKichThuoc" class="form-control" id="TenKichThuoc" placeholder="size name" required>
            </div>

            <button class="btn btn-primary" type="submit">ADD NEW SIZE</button>
        </form>
    </div>
@endsection
