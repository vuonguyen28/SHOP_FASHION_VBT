@extends('account.layouts.layout')

@section('title', 'Sản Phẩm theo loai')


{{-- start section content --}}
@section('content')

    <section>
        <div class="row product__section">

            {{-- danh mục sản phẩm --}}
            <div class="col-md-2">
                <div class="sidebar__category">
                    <div class="sildebar__category--title">
                        <p>Category</p>
                        <hr style="border: 1px solid black">
                        <ul>
                            @foreach ($category as $category)
                                <li><a href="{{ route('product.DisplayProductsByType', ['MaDanhMuc' => $category->MaDanhMuc]) }}">{{ $category->TenDanhMuc }}</a></li>
                                <hr style="border: 1px solid black">
                            @endforeach
                            <li><a href="{{ route('product.showProduct')}}">Xem tất cả</a></li>
                            <hr style="border: 1px solid black">
                        </ul>
                    </div>
                </div>
            </div>

            {{-- Phần sản phẩm --}}
            <div class="col-md-10">
                {{-- Sale product --}}
                <div class="row frame__sale--product">
                    @foreach ($products as $product)
                        <div class="col-lg-4 col-md-4 col-sm-6">

                            <div class="sale__product--card">
                                @if ($product->PhanTramGiamGia != 0)
                                    <div class="sale__sale-tag">-{{ $product->PhanTramGiamGia }}%</div>
                                @endif
                                <div class="sale__prooduct--img">
                                    @foreach ($product->images->take(1) as $image)
                                        <img class="img_sale1" src="{{$image->hinhanh }}"
                                            alt="">
                                    @endforeach
                                    @foreach ($product->images->skip(1)->take(1) as $image)
                                        <img class="img_sale2" src="{{  $image->hinhanh }}"
                                            alt="">
                                    @endforeach
                                </div>
                                <div class="sale__product--name">
                                    <p>Áo polo</p>
                                </div>
                                <div class="sale_product--price">

                                    @if ($product->PhanTramGiamGia == 0)
                                        <h4>{{ $product->Gia }} vnd</h4>
                                    @else
                                        @php
                                            $salePrice =
                                                $product->Gia - $product->Gia * ($product->PhanTramGiamGia / 100);
                                        @endphp
                                        <h4>{{ number_format(intval($salePrice), 0, ',', '.') }} vnđ</h4>
                                        <h5>{{ $product->Gia }} vnd</h5> <span>Sale</span>
                                    @endif

                                </div>

                                <div class="sale__card--btn">
                                    <a href="{{ route('product.SeeProductDetails', ['id' => $product->MaSP]) }}">Mua Ngay</a>
                                    <a href="{{ route('product.SeeProductDetails', ['id' => $product->MaSP]) }}">Thêm vào giỏ</a>
                                </div>
                            </div>

                        </div>
                    @endforeach
                </div>
            </div>






        </div>
    </section>

@endsection
{{-- end section content --}}
