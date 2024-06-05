
<style>
    .list__img--product {
        margin-top: 20px;
    }

    .image-item {
        position: relative;
        display: inline-block;
    }

    .image-checkbox {
        display: none;
    }

    .image-item img {
        cursor: pointer;
        margin-right: 10px;
        width: 200px;
        height: 230px;
        border: 2px solid transparent;
        transition: all 0.3s;
    }

    .image-item img:hover {
        box-shadow: 1px 1px 1px 1px rgb(95, 94, 94, 0.6);
    }

    .image-item .checkmark {
        position: absolute;
        top: 0;
        left: 0;
        width: 20px;
        height: 20px;
        background-color: white;
        border-radius: 50%;
        display: none;
        align-items: center;
        justify-content: center;
        color: red;
        font-weight: bold;
        clip-path: polygon(0 0, 100% 0, 0 100%); /* cắt góc nữa hình vuông*/
    }

    /* xử lý check hình */
    .image-item input:checked+img {
        border: 2px solid red;
    }

    .image-item input:checked+img+.checkmark {
        display: flex;
    }

    .checkmark::before {
        content: "";
        font-size: 16px;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 20px;
        height: 20px;
        background-color: red;
    }

    .btn__choose--all{
        margin-top: 20px;
    }
</style>



@extends('admin.layout.app')
@section('title', 'LIST IMAGE ')

@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="container mt-3">
        <center>
            <h1>Images for Product: {{ $MaSP }}</h1>
        </center>
        <a href="{{ route('image.create', ['MaSP' => $MaSP]) }}" class="btn btn-primary">
            <i class='bx bxs-add-to-queue'></i> Create
        </a>
        <br>

        <!-- Checkbox để chọn tất cả -->

        <div class="btn__choose--all">
            <!-- Checkbox để chọn tất cả -->
            <input type="checkbox" id="select-all" class="mr-2">
            <label for="select-all">Chọn tất cả</label>
        </div>

        <!-- Nút xóa -->
        <button type="button" id="delete-selected" class="btn btn-danger d-none">
            <i class='bx bx-trash'></i> Xóa đã chọn
        </button>


        {{-- new code --}}
        <div class="list__img--product">
            @foreach ($image as $c)
                <div class="image-item">
                    <input type="checkbox" class="image-checkbox" data-id="{{ $c->MaHinhAnh }}">
                    <img src="{{ $c->hinhanh }}" width="70px" height="70px" alt="Avatar">
                    <span class="checkmark"></span>
                </div>
            @endforeach
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
                axios.post('{{ route('image.destroy') }}', {
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

    {{-- xử lý click img --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const imageItems = document.querySelectorAll('.image-item img');

            imageItems.forEach(img => {
                img.addEventListener('click', function() {
                    const checkbox = this.previousElementSibling;
                    checkbox.checked = !checkbox.checked;
                    checkbox.dispatchEvent(new Event('change'));
                });
            });
        });
    </script>

@endsection
