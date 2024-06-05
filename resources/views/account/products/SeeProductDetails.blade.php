@extends('account.layouts.layout')

@section('title', $product->TenSP)

<style>
    .box_color--item {

        width: 5em;
        margin-right: 2px;
        border: 0px;
        display: inline-block;
        color: #00c6f8;
    }

    .box_color--item:hover {
        border: 0px solid #035200;
        color: #f15cae
    }

    .disabled {
        opacity: 0.9;
        color: red;
        text-decoration: line-through;
        cursor: not-allowed;
        pointer-events: none;
    }


    .select-swap {
        display: flex;
    }

    .swatch-element input[type="radio"] {
        display: none;
    }


    .swatch-element label {
        margin: 10px;
        display: inline-block;
        padding: 8px 16px;
        background-color: #f0f0f0;
        border: 3px solid #ffffff;
        cursor: pointer;
        border-radius: 4px;
    }


    .swatch-element input[type="radio"]:checked+label {
        background-color: #eb6ee0;
        border-color: #aa005e;
    }

    .rating {
        color: #ccc;
        padding: 0;
    }

    .rating .star-selected {
        color: #ffcc00;
    }
</style>
@section('content')
    {{-- Hiển thị thông báo lỗi nếu có --}}
    @if ($errors->any())
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                let errorMessages = '<ul>';
                @foreach ($errors->all() as $error)
                    errorMessages += '<li>{{ $error }}</li>';
                @endforeach
                errorMessages += '</ul>';

                Swal.fire({
                    title: 'Add to cart fail',
                    html: errorMessages,
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            });
        </script>
    @endif


    {{-- Hiển thị thông báo thành công nếu có --}}
    @if (session('success'))
        <script>
            Swal.fire({
                title: "Thông Báo",
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

    <section>
        <form action="{{ route('cart.AddProductToCart') }}" method="POST">
            @csrf
            <div class="container">
                <div class="row">
                    <div class="card__details--product">
                        {{-- row product --}}
                        <div class="row">
                            <div class="col-md-6">
                                <div class="detail__product--img">
                                    @foreach ($product->images->take(1) as $image)
                                        <img id="main-product-img" src="{{ $image->hinhanh }}" alt="">
                                        <input hidden name="Image" type="text" value="{{ $image->hinhanh }}">
                                    @endforeach
                                </div>
                                <div class=" detail__product--img-slider">
                                    @foreach ($product->images as $image)
                                        <img src="{{ $image->hinhanh }}" alt="">
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="detail__product--action">
                                        @php
                                            $totalFeedback = count(
                                                $product->ProductDetails->flatMap->OrderDetails->flatMap->Feedback,
                                            );
                                            $totalFeedback = count(
                                                $product->ProductDetails->flatMap->OrderDetails->flatMap->Feedback,
                                            );
                                            $totalRating = $product->ProductDetails->flatMap->OrderDetails->flatMap->Feedback->sum(
                                                'DanhGia',
                                            );
                                            $averageRating =
                                                $totalFeedback > 0 ? round($totalRating / $totalFeedback) : 0;
                                        @endphp

                                        <input hidden name="TenSP" value="{{ $product->TenSP }}">
                                        <p>{{ $product->TenSP }}</p>
                                        <hr style="border: 1px solid black">
                                        <h5>Đã bán: {{ $totalSold }} | Lượt đánh giá: &nbsp;{{ $totalFeedback }}</h5>
                                        {{-- average --}}
                                        <div>

                                            @if ($averageRating > 0)
                                                {{-- <p> {{ $averageRating }}</p> --}}
                                                <div class="rating">
                                                    @for ($i = 1; $i <= $averageRating; $i++)
                                                        <span class="star-selected">&#9733;</span>
                                                    @endfor
                                                    @for ($i = $averageRating + 1; $i <= 5; $i++)
                                                        <span class="star">&#9733;</span>
                                                    @endfor
                                                </div>
                                            @else
                                                <small>Chưa có đánh giá nào cho sản phẩm này.</small>
                                            @endif
                                        </div>
                                        <div class="detail__product--price">
                                            @if ($product->PhanTramGiamGia == 0)
                                                <p>{{ $product->Gia }} vnd</p>
                                                <input hidden name="Gia" value="{{ $product->Gia }}">
                                            @else
                                                @php
                                                    $salePrice =
                                                        $product->Gia -
                                                        $product->Gia * ($product->PhanTramGiamGia / 100);
                                                @endphp
                                                <p>{{ number_format(intval($salePrice), 0, ',', '.') }} vnđ
                                                <h4><small>{{ $product->Gia }} vnđ </small><span>sale</span></h4>

                                                <input hidden name="Gia" value="{{ $product->Gia }}">
                                                <input hidden name="GiaSale" value="{{ $salePrice }}">
                                                </p>
                                            @endif
                                        </div>
                                        @php
                                            // Tạo mảng hai chiều để lưu trữ thông tin màu theo từng kích thước
                                            $sizesColorsMap = [];

                                            // Điền dữ liệu vào mảng hai chiều
                                            foreach ($productDetails as $detail) {
                                                $ID_size = $detail->Size->MaKichThuoc;
                                                $size = $detail->Size->TenKichThuoc;

                                                $ID_Color = $detail->Color->MaMau;
                                                $colorName = $detail->Color->TenMau;
                                                $hexCode = $detail->Color->HEXCODE;
                                                $quantity = $detail->SoLuongTon;

                                                // Kiểm tra xem kích thước đã tồn tại trong mảng chưa
                                                if (!isset($sizesColorsMap[$size])) {
                                                    $sizesColorsMap[$size] = [];
                                                }
                                                // Thêm thông tin màu vào kích thước tương ứng
                                                $sizesColorsMap[$size][] = [
                                                    'ID_Color' => $ID_Color,
                                                    'colorName' => $colorName,
                                                    'hexCode' => $hexCode,
                                                    'quantity' => $quantity,
                                                ];
                                            }
                                        @endphp

                                        {{-- Truyen Ten SP -> Add to cart --}}
                                        <input hidden value="{{ $product->TenSP }}" name="TenSP">
                                        {{-- lấy MaSP --}}
                                        <input name="MaSP" hidden type="text" value="{{ $product->MaSP }}">

                                        <div>Kích thước:</div>
                                        <div class="select-swap">

                                            @foreach ($sizesColorsMap as $size => $colors)
                                                <div class="swatch-element">
                                                    <input data-size="{{ $size }}" class="size-btn"
                                                        id="{{ $size }}" type="radio" name="MaKichThuoc"
                                                        value="{{ $size }} ">
                                                    <label for="{{ $size }}">
                                                        <span>{{ $size }}</span>
                                                    </label>
                                                </div>
                                            @endforeach

                                        </div>



                                        <div>
                                            <div class="detail__product--colors select-swap" id="color-list">
                                                <h3>Colors:</h3>
                                            </div>
                                        </div>


                                        <script>
                                            document.addEventListener('DOMContentLoaded', function() {
                                                let sizeButtons = document.querySelectorAll('.size-btn');
                                                let colorList = document.getElementById('color-list');

                                                sizeButtons.forEach(function(button) {
                                                    button.addEventListener('click', function() {
                                                        let size = this.getAttribute('data-size');
                                                        showColorsBySize(size);
                                                    });
                                                });

                                                function showColorsBySize(size) {
                                                    // Lấy danh sách màu từ mảng hai chiều
                                                    let colors = @json($sizesColorsMap);
                                                    let sizeColors = colors[size];

                                                    //Show list color
                                                    colorList.innerHTML = '';
                                                    sizeColors.forEach(color => {

                                                        // check số lượng tồn
                                                        let btnClass = color.quantity === 0 ? 'box_color--item disabled' : 'box_color--item';
                                                        let CheckRadio = color.quantity === 0 ? 'checked disabled' : '';
                                                        // create button color
                                                        let colorDivHTML = `
                                                    <div class="swatch-element">
                                                        <input ${CheckRadio} data-size="${color.colorName}" class="size-btn " id="${color.colorName}" type="radio" name="MaMau" value="${color.hexCode}">
                                                        <label style="background-color: ${color.hexCode}" for="${color.colorName}">
                                                            <span class="${btnClass}">${color.colorName}</span>
                                                        </label>
                                                    </div>`;
                                                        colorList.insertAdjacentHTML('beforeend', colorDivHTML);
                                                    });
                                                }

                                            });
                                        </script>

                                        <div class="detail_product--quantity">
                                            <p id="btn_reduce">-</p>
                                            <input name="SoLuong" type="number" min="1" value="1">
                                            <p id="btn_increase">+</p>
                                        </div>
                                        <div class="detail__product--btn">
                                            <button class="btn btn-dark" type="submit"><i class='bx bx-cart-add'></i>
                                                &nbsp;Add
                                                to
                                                cart</button>
                                            <a href="#"><i class='bx bx-credit-card'></i> &nbsp; Buy now</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="row note__product--details">
                                    <hr style="margin-top: 50px ">
                                    <p>{{ $product->MoTa }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                {{--   feedback --}}
                                <hr>
                                <div class="row feedback__product">
                                    <h1>Đánh Giá Khách Hàng</h1>
                                    @foreach ($product->ProductDetails as $productDetail)
                                        @foreach ($productDetail->OrderDetails as $orderDetail)
                                            @foreach ($orderDetail->Feedback as $feedback)
                                                <div class="form__feedback">
                                                    <div class="row avatar_name_star">
                                                        <div class="col-md-1">
                                                            <img src="{{ $feedback->Customer->avatar }}">
                                                        </div>
                                                        <div class="col-md-11">
                                                            <p>{{ $feedback->Customer->TenKH }}</p>
                                                            <div class="form-group">
                                                                <div class="rating">
                                                                    @for ($i = 1; $i <= $feedback->DanhGia; $i++)
                                                                        <span class="star-selected">&#9733;</span>
                                                                    @endfor
                                                                    @for ($i = $feedback->DanhGia + 1; $i <= 5; $i++)
                                                                        <span class="star">&#9733;</span>
                                                                    @endfor
                                                                </div>
                                                            </div>


                                                        </div>
                                                    </div>
                                                    <p><strong>{{ $feedback->NoiDung }}</strong> </p>
                                                    <p> {{ $feedback->ThoiGianfeedback }}</p>

                                                </div>
                                                <hr>
                                            @endforeach
                                        @endforeach
                                    @endforeach
                                </div>
                            </div>
                        </div>

                    </div>

                </div>


            </div>



        </form>
    </section>



@endsection
