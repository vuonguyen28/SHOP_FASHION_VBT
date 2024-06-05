@extends('admin.layout.app')
@section('title', 'LIST PRODUCT')

@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <style>
        .btn_importExcel {
            background-color: #fff;
            border: 2px solid greenyellow;
            color: black;
            padding: 5px;
            font-weight: bold;
            box-shadow: 1px 1px 1px black;
        }

        .btn__createNew {
            background-color: #fff;
            border: 2px solid rgb(98, 0, 255);
            color: black;
            padding: 5px;
            font-weight: bold;
            margin-right: 20px;
            box-shadow: 1px 1px 1px black;
        }

        .btn__create_import {
            margin: 10px
        }

        .dropdown__choose--quantity {
            display: flex;
            justify-content: end;
            align-items: center;
            height: 100%;
        }

        .dropdown__choose--quantity select {
            width: 100px;
            padding: 3px;
        }

        .checkbox__select--all {
            background: #fff;
            border: 2px solid black;
            width: 120px;
            margin: 10px;
            display: flex;
            justify-content: center;
            align-content: center;
        }

        .btn__delete--choose{
            display: flex;
            justify-content: center;
            align-items: center;
        }
        #delete-selected {
            margin: 0;
        }
    </style>






    <div class="container-fuil mt-3">
        <center>
            <h1><b>LIST PRODUCT</b></h1>
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

        <div class="row">
            <div class="col-md-2">
                <div class="checkbox__select--all">
                    <input type="checkbox" id="select-all" class="mr-2">
                    <label for="select-all">Chọn tất cả</label>
                </div>
            </div>

            <div class="col-md-2">
                <!-- Nút xóa -->
                <div class="btn__delete--choose">
                    <button type="button" id="delete-selected" class="btn btn-danger d-none">
                        <i class='bx bx-trash'></i> Xóa đã chọn
                    </button>
                </div>
            </div>

            <!-- Checkbox để chọn tất cả -->
            <div class="col-md-3">
                <div class="btn__create_import">
                    <a class="btn__createNew" href="{{ route('product.store') }}">
                        <i class='bx bxs-add-to-queue'></i> create
                    </a>
                    <a class="btn_importExcel" href="{{ route('product.import') }}">
                        <img src="{{ asset('images/iconexcel.png') }}" width="25"> Import
                    </a>
                </div>


            </div>



            <div class="col-md-3">
                <!-- Select  chọn số lượng sản phẩm hiển thị mỗi trang -->
                <div class="dropdown__choose--quantity">
                    <p><b>Số sản phẩm / trang:</b></p>
                    <form action="{{ route('product.index') }}" method="GET" id="perPageForm">
                        <select name="per_page" id="perPageSelect" class="form-control"
                            onchange="document.getElementById('perPageForm').submit();">
                            <option value="10"{{ $perPage == 10 ? ' selected' : '' }}>10</option>
                            <option value="20"{{ $perPage == 20 ? ' selected' : '' }}>20</option>
                            <option value="50"{{ $perPage == 50 ? ' selected' : '' }}>50</option>
                            <option value="100"{{ $perPage == 100 ? ' selected' : '' }}>100</option>
                        </select>
                    </form>
                </div>
            </div>

        </div>

        <div class="table-wrapper" style="height: 500px; overflow:auto; position:relative">
            <table class="table">
                <thead class="table-success" style="position:sticky; top:0;">
                    <tr>
                        <th>Select</th>
                        <th>ID</th>
                        <th>HÌNH ẢNH</th>
                        <th>TÊN SẢN PHẨM</th>
                        <th>GIÁ</th>
                        <th>PHẦN TRĂM GIẢM GIÁ</th>
                        <th>TÊN DANH MỤC</th>
                        <th>NHÀ CUNG CẤP</th>
                        <th>TÌNH TRẠNG</th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($product as $p)
                        <tr>
                            <td><input type="checkbox" class="image-checkbox" data-id="{{ $p->MaSP }}"></td>
                            <td>{{ $p->MaSP }}</td>
                            <td>
                                @foreach ($p->images->take(1) as $image)
                                    <img width="70px" height="auto" src="{{ $image->hinhanh }}" alt="">
                                @endforeach
                            </td>
                            <td>{{ $p->TenSP }}</td>
                            <td>{{ $p->Gia }}</td>
                            <td>{{ $p->PhanTramGiamGia }}</td>
                            <td>{{ $p->Category->TenDanhMuc }}</td>
                            <td>{{ $p->Supplier->TenNhaCungCap }}</td>
                            <td>{{ $p->TrinhTrang }}</td>
                            {{-- <td>{{ $p->MoTa }}</td> --}}

                            <td>
                                <form id="delete-form-{{ $p->MaSP }}"
                                    action="{{ route('product.destroy', $p->MaSP) }}" method="POST">
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

        <!-- phân trang -->
        <div class="row" style="margin: 10px;">
            {{ $product->appends(['per_page' => $perPage])->links() }}
        </div>
    </div>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.min.js"></script>
    <script>
        // Lắng nghe sự kiện khi checkbox được thay đổi
        document.querySelectorAll('.image-checkbox').forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                // Hiển thị hoặc ẩn nút xóa dựa trên trạng thái của checkbox
                const deleteBtn = document.getElementById('delete-selected');
                deleteBtn.classList.toggle('d-none', !document.querySelector('.image-checkbox:checked'));
            });
        });

        // Xử lý sự kiện khi checkbox "Chọn tất cả" được thay đổi
        document.getElementById('select-all').addEventListener('change', function() {
            const isChecked = this.checked;
            document.querySelectorAll('.image-checkbox').forEach(function(checkbox) {
                checkbox.checked = isChecked;
            });

            // Hiển thị hoặc ẩn nút xóa dựa trên trạng thái của checkbox
            const deleteBtn = document.getElementById('delete-selected');
            deleteBtn.classList.toggle('d-none', !isChecked);
        });

        // Xử lý sự kiện khi nút xóa được nhấn
        document.getElementById('delete-selected').addEventListener('click', function() {
            // Lấy danh sách các ID được chọn
            const selectedIds = Array.from(document.querySelectorAll('.image-checkbox:checked')).map(function(
                checkbox) {
                return checkbox.getAttribute('data-id');
            });

            // Kiểm tra xem đã chọn ít nhất một hình ảnh hay chưa
            if (selectedIds.length > 0) {
                // Gửi yêu cầu xóa đến route đã tạo
                axios.post('{{ route('product.destroy_all') }}', {
                        selectedIds: selectedIds
                    })
                    .then(function(response) {
                        // Xử lý phản hồi từ server
                        if (response.data.success) {
                            alert('Các hình ảnh đã được xóa thành công.');
                            window.location.reload(); // Tải lại trang để cập nhật danh sách hình ảnh
                        } else {
                            alert('Đã xảy ra lỗi khi xóa hình ảnh.');
                            window.location.reload();
                        }
                    })
                    .catch(function(error) {
                        console.error(error);
                        alert('Đã xảy ra lỗi khi xóa hình ảnh hệ thống');
                    });
            } else {
                alert('Vui lòng chọn ít nhất một hình ảnh để xóa.');
            }
        });
    </script>

@endsection
