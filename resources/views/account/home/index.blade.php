@extends('account.layouts.layout')

@section('title', 'Trang chủ BVT Shop')

{{-- start section content --}}
@section('content')

    {{-- section banner --}}
    <section>
        <div class="container-fill">
            <div id="myCarousel" class="carousel slide " data-ride="carousel">
                <!-- Indicators -->
                <ol class="carousel-indicators">
                    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                    <li data-target="#myCarousel" data-slide-to="1"></li>
                    <li data-target="#myCarousel" data-slide-to="2"></li>
                </ol>

                <!-- Wrapper for slides -->
                <div class="carousel-inner">
                    <div class="item active">
                        <img src="{{ asset('images/banner/banner1.jpg') }}" alt="Banner Image" style="width:100%;">
                    </div>

                    <div class="item">
                        <img src="{{ asset('images/banner/banner2.jpg') }}" alt="Banner Image" style="width:100%;">
                    </div>

                    <div class="item">
                        <img src="{{ asset('images/banner/banner3.jpg') }}" alt="Banner Image" style="width:100%;">
                    </div>
                </div>

                <!-- Left and right controls -->
                <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                    <span class="glyphicon glyphicon-chevron-left"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="right carousel-control" href="#myCarousel" data-slide="next">
                    <span class="glyphicon glyphicon-chevron-right"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>

        </div>
    </section>
    {{-- <section>
        @foreach ($products as $product)
            <h2>{{ $product->TenSP }}</h2>
            <p>{{ $product->MoTa }}</p>
            <p>Giá: {{ $product->Gia }}</p>
            <p>Phần trăm giảm giá: {{ $product->PhanTramGiamGia }}</p>

            <!-- Hiển thị danh sách hình ảnh của sản phẩm -->
            @foreach ($product->images->take(2) as $image)
                <img width="200px" height="200px" src="{{ asset('product/' . $image->hinhanh) }}">
            @endforeach
        @endforeach
    </section> --}}

    {{-- section main --}}
    <section>
        {{-- name shop --}}
        <div class="row">
            <hr style="border: 3px solid black">
            <p class="name__shop">BVT - FASHION SHOP</p>
        </div>

        {{-- info shop freeship - support 24/7 genuine prpduct --}}
        <div class="row">
            <div class="bvtshop__info">
                <div class="bvtshop__info--card">
                    <i class='bx bxs-truck'></i>
                    {{-- <img src="{{ asset('images/icons/truckfreeship.png') }}" alt="Banner Image"> --}}
                    <p>Miễn Phí Vận Chuyển</p>
                    <h4>Áp dụng cho đơn hàng từ 500k</h4>
                </div>
                <div class="bvtshop__info--card">
                    <i class='bx bx-headphone'></i>
                    {{-- <img src="{{ asset('images/icons/call24h.png') }}" alt="Banner Image" > --}}
                    <p>Hỗ Trợ 24/7</p>
                    <h4>Hotline: 0909.100.200</h4>
                </div>
                <div class="bvtshop__info--card">
                    <i class='bx bxs-badge-check'></i>
                    {{-- <img src="{{ asset('images/icons/genuine.png') }}" alt="Banner Image" > --}}
                    <p>Sản Phẩm Chính Hãng</p>
                    <h4>Từ nhà sản xuất và <br> các đơn vị cung cấp chính thức</h4>
                </div>
            </div>
            <hr style="border: 2px solid black">
        </div>

        {{-- sản phẩm nổi bật --}}
        <div class="row frame__treending--product">
            <div class="col-md-4  title__trending--product show__animate-trending">
                <p id="trending_title">SẢN PHẨM NỔI BẬT</p>
                <a id="trending_seemore" href="#">Xem thêm >></a>
            </div>

            <div class="col-md-8 trending__product--slider" id="trending_slide">

                @foreach ($products as $product)
                    <div class="trending__product--card">
                        @foreach ($product->images->take(1) as $image)
                            <img class="img_sale1" src="{{ $image->hinhanh }}" alt="">
                        @endforeach

                        <div class="trending__product--card-info">
                            <h5 style="color: #fff; margin-top:5px;">{{ $product->TenSP }}</h5>
                        </div>
                    </div>
                @endforeach
            </div>


        </div>
        <hr style="border: 3px solid black">
        {{-- end trending product --}}

        {{-- Sale product --}}
        <div class="row frame__sale--product">
            <div class="col-md-12 sale__product--title">
                <p>Sản Phẩm Đang Sale <i class='bx bx-purchase-tag'></i></p>
            </div>
            @foreach ($products as $product)
                <div class="col-6 col-lg-3 col-md-4 col-sm-6">

                    <div class="sale__product--card col-lg-3 col-md-4 col-sm-6 xs-6 col-6">
                        <div class="sale__sale-tag">-{{ $product->PhanTramGiamGia }}%</div>
                        <div class="sale__prooduct--img">
                            @foreach ($product->images->take(1) as $image)
                                <img class="img_sale1" src="{{ $image->hinhanh }}" alt="">
                            @endforeach
                            @foreach ($product->images->skip(1)->take(1) as $image)
                                <img class="img_sale2" src="{{ $image->hinhanh }}" alt="">
                            @endforeach
                        </div>
                        <div class="sale__product--name">
                            <p>Áo polo</p>
                        </div>
                        <div class="sale_product--price">
                            @php
                                $salePrice = $product->Gia - $product->Gia * ($product->PhanTramGiamGia / 100);
                            @endphp
                            <h4>{{ number_format(intval($salePrice), 0, ',', '.') }} vnđ</h4>
                            <h5>{{ $product->Gia }} vnd</h5> <span>Sale</span>
                        </div>

                        <div class="sale__card--btn">
                            <a href="#">Mua Ngay</a>
                            <a href="#">Thêm vào giỏ</a>
                        </div>
                    </div>

                </div>
            @endforeach

            <div class="col-md-12 sale__product--btn-more d-flex justify-content-center">
                <a href="{{ url('account/home/top-8-sale') }}">Xem Thêm >></a>
            </div>
        </div>
        {{-- end sale product --}}


    </section>

    {{-- @foreach ($topProducts as $product)
        <li>
            <h2>{{ $product->TenSP }}</h2>
            <p>Total Quantity Sold: {{ $product->total_quantity }}</p>
            <p>Price: {{ $product->Gia }}</p>
            <p>Description: {{ $product->MoTa }}</p>
        </li>
    @endforeach --}}

    {{-- @foreach ($topProducts as $product)
        <li>
            <h3>{{ $product->TenSP }}</h3>
            <img src="{{ $product->HinhAnh }}" alt="{{ $product->TenSP }}">
        </li>
    @endforeach --}}

@endsection
{{--  end section content --}}
