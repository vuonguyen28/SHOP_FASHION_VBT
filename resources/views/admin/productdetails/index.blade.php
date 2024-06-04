@extends('admin.layout.app')
@section('title', 'LIST PRODUCT DETAILS')

@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="container mt-3">
        <center>
            <h4>LIST PRODUCT DETAILS</h4>
        </center>
        <!-- Thêm ô nhập liệu tìm kiếm -->
        <div class="row mt-3 mb-3">
            <div class="col-md-6 offset-md-3">
                <form action="{{ route('product.search') }}" method="GET">
                    <div class="input-group">
                        <input type="text" class="form-control" name="keyword" placeholder="Enter keyword...">
                        <button class="btn btn-primary" type="submit">Search</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- End Thêm ô nhập liệu tìm kiếm -->
        <table class="table">
            <thead class="table-success">
                <a class="btn btn-primary" href="{{ route('product.store') }}">
                    <i class='bx bxs-add-to-queue'></i> Create
                </a>
                <tr>

                    <th>ID</th>
                    <th>TÊN SẢN PHẨM</th>
                    <th>GIÁ</th>
                    <th>PHẦN TRĂM GIẢM GIÁ</th>
                    <th>TÊN DANH MỤC</th>
                    <th>TÊN NHÀ CUNG CẤP</th>
                    <th>KÍCH THƯỚC</th>
                    <th>MÀU</th>
                    <th>SỐ LƯỢNG</th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>

                </tr>
            </thead>
            <tbody>
                @foreach ($productDetail as $p)
                    <tr>
                        <td>{{ $p->Product->ProductDetails->TenSP }}</td>
                        
                        {{-- <td>{{ $p->MoTa }}</td> --}}

                        <td>
                            <form id="delete-form-{{ $p->MaSP }}" action="{{ route('product.destroy', $p->MaSP) }}"
                                method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-warning delete-btn" data-id="{{ $p->MaSP }}"
                                    onclick="confirmDelete('{{ $p->MaSP }}')">
                                    <i class='bx bx-trash'></i>
                                </button>
                            </form>
                        </td>
                        <td>
                            <a href="{{ route('product.edit', $p->MaSP) }}" class="btn btn-primary">
                                <i class='bx bx-edit'></i>
                            </a>

                        </td>
                        <td>
                            <a href="{{ route('image.show', ['MaSP' => $p->MaSP]) }}" class="btn btn-success">
                                <i class="fa-solid fa-image"></i>
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('product.show', $p->MaSP) }}" class="btn btn-success">
                                <i class="fa-regular fa-eye"></i>
                            </a>
                        </td>


                        <script>
                            function confirmDelete(productId) {
                                var confirmation = confirm('Are you sure you want to delete this product?');
                                if (confirmation) {
                                    document.getElementById('delete-form-' + productId).submit();
                                }
                            }
                        </script>


                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>



@endsection
