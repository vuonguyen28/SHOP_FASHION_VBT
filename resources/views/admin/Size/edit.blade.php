@extends('admin.layout.app')
@section('title','EDIT Color')

@section('content')
    <div class="container mt-3">
        <form action="{{ route('size.update', $size->MaKichThuoc) }}" method="POST">
            @csrf {{-- Cross-Site Request Forgery --}}
            @method('PUT')
            <div class="mb-3 mt-3">
                <label for="TenSize">TÊN KÍCH THƯỚC</label>
                <input type="text" name="TenKichThuoc" value="{{ $size->TenKichThuoc }}" class="form-control" id="size"
                    placeholder="size name" required>
            </div>

            <button class="btn btn-primary" type="submit">SAVE SIZE</button>
        </form>
    </div>
@endsection
