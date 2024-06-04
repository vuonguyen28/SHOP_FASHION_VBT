@extends('admin.layout.app')
@section('title','DETAILS SIZE')

@section('content')
    <div class="container mt-3">
        <div class="card">
            <div class="card-body d-flex justify-content-between align-items-center">
                <a href="{{ route('size.index') }}" class="btn btn-secondary"><i class='bx bx-arrow-back'> Back to Index</i></a>
                <h4 style="margin: 0;">Chi tiết kích thước của mã: <span style="color: red">{{ $size->MaKichThuoc }}</span></h4>
                <div></div>
            </div>
            <div class="card-body">
                <table class="table">
                    <tr>
                        <th>MÃ KÍCH THƯỚC:</th>
                        <td>{{ $size->MaKichThuoc }}</td>
                    </tr>
                    <tr>
                        <th>TÊN KÍCH THƯỚC:</th>
                        <td>{{ $size->TenKichThuoc }}</td>
                    </tr>
                </table><br>
                <a href="{{ route('size.edit', $size->MaKichThuoc) }}" class="btn btn-primary"><i class='bx bx-edit'>
                        Edit</i></a>
                <form action="{{ route('size.destroy', $size->MaKichThuoc) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger"><i class='bx bx-trash'> Delete</i></button>
                </form>
            </div>
        </div>
    </div>
@endsection
