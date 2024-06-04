@extends('admin.layout.app')
@section('title', 'PRODUCT DETAILS')

@section('content')
    <div class="container mt-3">
        <div class="card">
            <div class="card-body d-flex justify-content-between align-items-center">
                <a href="{{ route('product.index') }}" class="btn btn-secondary"><i class='bx bx-arrow-back'> Back to Index</i></a>
                <h4 style="margin: 0;">Chi tiết sản phẩm của mã: <span style="color: red">{{ $product->MaSP }}</span></h4>
                <div></div>
            </div>
            <div class="card-body">
                <table class="table">
                    <tr>
                        <th>TÊN SẢN PHẨM:</th>
                        <td>{{ $product->TenSP }}</td>
                    </tr>
                    <tr>
                        <th>GIÁ:</th>
                        <td>{{ $product->Gia }}</td>
                    </tr>
                    <tr>
                        <th>PHẦN TRĂM GIẢM GIÁ:</th>
                        <td>{{ $product->PhanTramGiamGia }}%</td>
                    </tr>
                    <tr>
                        <th>TÊN DANH MỤC:</th>
                        <td>{{ $product->Category->TenDanhMuc }}</td>
                    </tr>
                    <tr>
                        <th>TÊN NHÀ CUNG CẤP:</th>
                        <td>{{ $product->Supplier->TenNhaCungCap }}</td>
                    </tr>
                    <tr>
                        <th>TÌNH TRẠNG SẢN PHẨM:</th>
                        <td>{{ $product->TrinhTrang }}</td>
                    </tr>
                    <tr>
                        <th>MÔ TẢ SẢN PHẨM:</th>
                        <td>{{ $product->MoTa }}</td>
                    </tr>
                </table><br>

                <table class="table">
                    <thead class="table-success">
                        <a href="{{ route('productdetails.create', ['MaSP' => $product->MaSP]) }}" class="btn btn-primary">
                            Create
                        </a>
                                                
                        <tr>
                            <th>KÍCH THƯỚC</th>
                            <th>MÀU</th>
                            <th>SỐ LƯỢNG TỒN</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($productDetails as $detail)
                            <tr>
                                <td>{{ $detail->Size->TenKichThuoc }}</td>
                                <td>{{ $detail->Color->TenMau }}</td>
                                <td>{{ $detail->SoLuongTon }}</td>
                                <td>
                                    <a href="{{ route('productdetails.edit', ['id' => $detail->MaChiTiet]) }}" class="btn btn-primary">
                                        <i class='bx bx-edit'></i>
                                    </a>
                                </td>
                                <td>
                                    <form id="delete-form-{{ $detail->MaChiTiet }}" action="{{ route('productdetails.destroy', $detail->MaChiTiet) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-warning delete-btn" data-id="{{ $detail->MaChiTietP }}" onclick="confirmDelete('{{ $detail->MaChiTiet }}')">
                                            <i class='bx bx-trash'></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        function confirmDelete(productId) {
            var confirmation = confirm('Bạn có muốn xóa không?');
            if (confirmation) {
                document.getElementById('delete-form-' + productId).submit();
            }
        }
    </script>
@endsection
