@extends('account.layouts.layout')

@section('title', 'Sản Phẩm BVT-SHOP')


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

{{-- <a href="{{ route('voucher.myVoucher') }}">MY VOUCHER</a> --}}

<div class="container">
  <div class="btn__myvoucher">
      <a href="{{ route('voucher.myVoucher') }}">MY VOUCHER >></a>
  </div>
  <div class="row">
      @foreach ($vouchers as $item)
          <div class="col-md-3">
              <div class="voucher__card">
                  <img class="logo" src="{{ asset('images/logo_shopbvt.png') }}">
                  <h3>{{ $item->Ten_VOUCHER }}</h3>
                  <h3>{{ $item->PhanTramGiam }}%</h3>
                  <div class="voucher__row">
                      <span id="cpnCode">{{ $item->MA_VOUCHER }}</span>
                  </div>
                  <p>Đơn tổi thiểu: {{ $item->DonToiThieu }}</p>
                  <p>Giảm tối đa: {{ $item->GiamToiDa }}</p>

                  <p>Số lượng: {{ $item->SoLuongVOUCHER }}</p>

                  <p>{{ \Illuminate\Support\Str::before($item->Ngaybatdau, ' ') }} đến
                      {{ \Illuminate\Support\Str::before($item->Ngayketthuc, ' ') }}</p>

                  <form action="{{ route('voucher.saveVoucher') }}" method="POST">
                      @csrf
                      <input hidden name="MaVoucher" value="{{ $item->MA_VOUCHER }}">
                      <button type="submit">Save</button>
                  </form>

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
      @foreach ($vouchers as $item )
      <tr>
          <td>{{ $item->MA_VOUCHER   }}</td>
          <td>{{ $item->Ten_VOUCHER  }}</td>
          <td>{{ $item->PhanTramGiam  }}</td>
          <td>{{ $item->DonToiThieu  }}</td>
          <td>{{ $item->GiamToiDa  }}</td>
          <td>{{ $item->SoLuongVOUCHER  }}</td>
          <td>{{ $item->Ngaybatdau  }}</td>
          <td>{{ $item->Ngayketthuc  }}</td>
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