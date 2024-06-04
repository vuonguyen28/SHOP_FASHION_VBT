@extends('admin.layout.app')
@section('title', 'EDIT ORDER')

@section('content')

    <div class="container mt-3">
        <form action="{{ route('order.update') }}" method="POST">
            @csrf
            <input hidden name="id" value="{{ $id }}">

            <div class="mb-3 mt-3">
                <label for="TrangThaiDonHang">TRẠNG THÁI ĐƠN HÀNG</label>
                {{-- <input type="text" name="TrangThaiDonHang" value="{{ $order->TrangThaiDonHang }}" class="form-control" id="TrangThaiDonHang" placeholder="TrangThaiDonHang" required> --}}
                <select name="TrangThaiDonHang" value="{{ $order->TrangThaiDonHang }}"
                    class="form-control" id="TrangThaiDonHang">
                    <option name="TrangThaiDonHang">ĐÃ GIAO</option>
                    <option name="TrangThaiDonHang">ĐÃ HỦY</option>
                    <option name="TrangThaiDonHang">ĐÃ NHẬN</option>
                    <option name="TrangThaiDonHang">ĐANG GIAO</option>
                </select>
            </div>
            <button class="btn btn-primary" type="submit">Update Order</button>
        </form>
    </div>
@endsection
