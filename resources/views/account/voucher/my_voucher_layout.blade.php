@extends('account.layouts.layout')

@section('title', 'BILL CUSTOMER')

@section('content')

    {{-- menu right --}}
    @include('account.Order.menu_layout_bill')


    {{-- end header --}}
    {{-- start content --}}
    <div class="col-md-10">
        <div class="row form__bill--content">
            @foreach ($vouchers as $item)
                <div class="col-md-12">
                    <div class="voucher__card" style="flex-direction: row; border-radius: 5px; margin: 20px">
                        <div class="col-md-1">
                            <img class="logo" src="{{ asset('images/logo_shopbvt.png') }}">
                        </div>
                        <div class="col-md-2">
                            <h3>{{ $item->MA_VOUCHER }}</h3>
                            <h3>{{ $item->Voucher->PhanTramGiam }}%</h3>
                        </div>
                        <div class="col-md-2">
                            <div class="voucher__row">
                                <span id="cpnCode">{{ $item->MA_VOUCHER }}</span>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <p>Đơn tổi thiểu: {{ $item->Voucher->DonToiThieu }}</p>
                            <p>Giảm tối đa: {{ $item->Voucher->GiamToiDa }}</p>
                        </div>
                        <div class="col-md-1">
                            <p>Số lượng:{{ $item->Voucher->SoLuongVOUCHER }}</p>
                        </div>
                        <div class="col-md-3    ">
                            <p>{{ \Illuminate\Support\Str::before($item->Voucher->Ngaybatdau, ' ') }} đến
                                {{ \Illuminate\Support\Str::before($item->Voucher->Ngayketthuc, ' ') }}</p>
                        </div>
                        <div class="circle circle1"
                            style="background-image: url('{{ asset('images/Background_index.jpg') }}'); width: 20px; height: 20px; left: -10px">
                        </div>
                        <div class="circle circle2"
                            style="background-image: url('{{ asset('images/Background_index.jpg') }}'); width: 20px; height: 20px; right: -10px">
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    </div>
    </div>
    {{-- end form bill  --}}
    </div>

    </div>


@endsection
