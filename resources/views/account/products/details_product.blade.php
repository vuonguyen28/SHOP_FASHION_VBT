@extends('account.layouts.layout')

@section('title', 'Gắn tên sản phẩm ở đây')

{{-- start section content --}}
@section('content')
    <section>

        <div class="container">
            <div class="row">
                <div class="card__details--product">
                    <div class="col-md-6">
                        <div class="detail__product--img">
                            <img id="main-product-img" src="{{ asset('/images/products/ao1.png') }}" alt="">
                        </div>
                        <div class=" detail__product--img-slider">
                            <img src="{{ asset('/images/products/ao1.png') }}" alt="">
                            <img src="{{ asset('/images/products/ao2.png') }}" alt="">
                            <img src="{{ asset('/images/products/ao1.png') }}" alt="">
                            <img src="{{ asset('/images/products/ao2.png') }}" alt="">
                            <img src="{{ asset('/images/products/ao1.png') }}" alt="">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="detail__product--action">
                            <p>Áo Polo</p>
                            <hr style="border: 1px solid black">
                            <h5>Đã bán: 999 | Lượt đánh giá: 899</h5>
                            <div> * * * * *</div>

                            <div class="detail__product--price">
                                <p>Giá: <span>300.000 vnđ</span></p>
                            </div>

                            <div class="detail__product--color">
                                <p>Màu Sắc:</p>
                            </div>

                            <div class="detail__product--size">
                                <p>Kích thước:</p>
                            </div>

                            <div class="detail_product--quantity">
                                <button>-</button>
                                <input type="number" min="1" value="1">
                                <button>+</button>
                            </div>

                            <div class="detail__product--btn">
                                <a href="#"><i class='bx bx-cart-add'></i> &nbsp;Thêm Vào Giỏ</a>
                                <a href="#"><i class='bx bx-credit-card'></i> &nbsp;   Mua Ngay</a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </section>
@endsection
{{-- end section content --}}
