@extends('admin.layout.app')
@section('title', 'LIST PRODUCT')

@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif



    <!-- Checkbox để chọn tất cả -->
    <input type="checkbox" id="select-all" class="mr-2">
    <label for="select-all">Chọn tất cả</label>

    <!-- Nút xóa -->
    <button type="button" id="delete-selected" class="btn btn-danger d-none">
        <i class='bx bx-trash'></i> Xóa đã chọn
    </button>


    <div class="container-fuil mt-3">
        <center>
            <h4>LIST PRODUCT</h4>
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
        <a class="btn btn-primary" href="{{ route('product.store') }}">
            <i class='bx bxs-add-to-queue'></i> create
        </a>
        <a class="btn btn-primary" href="{{ route('product.import') }}">
            <i class='bx bxs-add-to-queue'></i> Import
        </a>

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
                                    <img width="70px" height="auto" src="{{ $image->hinhanh }}"
                                        alt="">
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
        <div class="row">
            <div class="col-md-4">
                {{ $product->appends(['per_page' => $perPage])->links() }}
            </div>
            <!-- Select  chọn số lượng sản phẩm hiển thị mỗi trang -->

            <div class="col-md-3 d-flex" style="margin-left: 60px; width:30%">
                <form action="{{ route('product.index') }}" method="GET" id="perPageForm">
                    <select name="per_page" id="perPageSelect" class="form-control"
                        onchange="document.getElementById('perPageForm').submit();">
                        <option value="10"{{ $perPage == 10 ? ' selected' : '' }}>10</option>
                        <option value="20"{{ $perPage == 20 ? ' selected' : '' }}>20</option>
                        <option value="50"{{ $perPage == 50 ? ' selected' : '' }}>50</option>
                        <option value="100"{{ $perPage == 100 ? ' selected' : '' }}>100</option>
                    </select>
                    <span style="margin-left: 10px;">sản phẩm/trang</span>
                </form>
            </div>
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
