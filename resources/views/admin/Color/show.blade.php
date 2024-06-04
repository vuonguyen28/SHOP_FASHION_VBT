@extends('admin.layout.app')
@section('title','DETAILS COLOR')

@section('content')
    <div class="container mt-3">
        <div class="card">
            <div class="card-body d-flex justify-content-between align-items-center">
                <a href="{{ route('Color.index') }}" class="btn btn-secondary"><i class='bx bx-arrow-back'> Back to Index</i></a>
                <h4 style="margin: 0;">Chi tiết màu sắc của mã: <span style="color: red">{{ $color->MaMau }}</span></h4>
                <div></div>
            </div>
            <div class="card-body">
                <table class="table">
                    <tr>
                        <th>MÃ MÀU:</th>
                        <td>{{ $color->MaMau }}</td>
                    </tr>
                    <tr>
                        <th>TÊN MÀU:</th>
                        <td>{{ $color->TenMau }}</td>
                    </tr>
                </table><br>
                <a href="{{ route('Color.edit', $color->MaMau) }}" class="btn btn-primary"><i class='bx bx-edit'>
                        Edit</i></a>
                <form action="{{ route('Color.destroy', $color->MaMau) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger"><i class='bx bx-trash'> Delete</i></button>
                </form>
            </div>
        </div>
    </div>
@endsection
