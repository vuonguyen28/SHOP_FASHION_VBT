@extends('account.layouts.layout')

@section('title', 'MY VOUCHER')


{{-- start section content --}}
@section('content')
    <br>
    <br>
    {{-- Hiển thị thông báo thành công nếu có --}}
    @if (session('success'))
        <script>
            Swal.fire({
                title: "The Internet?",
                text: " {{ session('success') }}",
                icon: "success"
            });
        </script>
    @endif

    {{-- Hiển thị thông báo lỗi chung nếu có --}}
    @if (session('error'))
        <script>
            Swal.fire({
                title: "The Internet?",
                text: "  {{ session('error') }}",
                icon: "error"
            });
        </script>
    @endif

    {{-- <a href="">MY VOUCHER</a> --}}

    <div class="container">
        <div class="row">
            @foreach ($vouchers as $item)
                <div class="col-md-3">
                    <div class="voucher__card">
                        <img class="logo" src="{{ asset('images/logo_shopbvt.png') }}">
                        <h3>{{ $item->MA_VOUCHER }}</h3>
                        <h3>{{ $item->Voucher->PhanTramGiam }}%</h3>
                        <div class="voucher__row">
                            <span id="cpnCode">{{ $item->MA_VOUCHER }}</span>
                        </div>
                        <p>Đơn tổi thiểu: {{ $item->Voucher->DonToiThieu }}</p>
                        <p>Giảm tối đa: {{ $item->Voucher->GiamToiDa }}</p>

                        <p>Số lượng: {{ $item->Voucher->SoLuongVOUCHER }}</p>
                        <p>{{ $item->note }}</p>

                        <p>{{ \Illuminate\Support\Str::before($item->Voucher->Ngaybatdau, ' ') }} đến
                            {{ \Illuminate\Support\Str::before($item->Voucher->Ngayketthuc, ' ') }}</p>


                        <div class="circle circle1"
                            style="background-image: url('{{ asset('images/Background_index.jpg') }}');"></div>
                        <div class="circle circle2"
                            style="background-image: url('{{ asset('images/Background_index.jpg') }}');"></div>

                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- <table class="table table-borderless">
        <tbody>
            @foreach ($vouchers as $item)
                <tr>
                    <td>{{ $item->MA_VOUCHER }}</td>
                    <td>{{ $item->Voucher->Ten_VOUCHER }}</td>
                    <td>{{ $item->Voucher->PhanTramGiam }}</td>
                    <td>{{ $item->Voucher->DonToiThieu }}</td>
                    <td>{{ $item->Voucher->GiamToiDa }}</td>
                    <td>{{ $item->Voucher->SoLuongVOUCHER }}</td>
                    <td>{{ $item->Voucher->Ngaybatdau }}</td>
                    <td>{{ $item->Voucher->Ngayketthuc }}</td>
                    <td>
                        <form action="{{ route('voucher.saveVoucher') }}" method="POST">
                            @csrf
                            <input hidden name="MaVoucher" value="{{ $item->MA_VOUCHER }}">
                            <button type="submit" class="btn btn-success">save</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table> --}}
@endsection
