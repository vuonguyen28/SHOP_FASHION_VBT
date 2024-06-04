@extends('admin.layout.app')
@section('title','ADD NEW CUSTOMERS')

@section('content')
    <div class="container mt-3">
        <form action="{{ route('customers.store') }}" method="POST" enctype="multipart/form-data">
            @csrf 
            <div class="mb-3 mt-3">
                <label for="TenKH">Tên Khách Hàng:</label>
                <input type="text" name="TenKH" class="form-control" id="email" placeholder="Name" required>
            </div>

            <div class="mb-3 mt-3">
                <label for="SoDienThoai">Số Điện Thoại:</label>
                <input type="text" name="SoDienThoai" class="form-control" id="email" placeholder="Phone" required>
            </div>

            <div class="mb-3 mt-3">
                <label for="Email">Email</label>
                <input type="email" name="Email" class="form-control" id="email" placeholder="Enter email" required>
            </div>

            <div class="mb-3 mt-3">
                <label for="DiaChi">Địa Chỉ:</label>
                <input type="text" name="DiaChi" class="form-control" id="email" placeholder="Address" required>
            </div>

            <div class="mb-3 mt-3">
                <label for="Password_hs5">PassWord</label>
                <input type="password" name="Password_hs5" class="form-control" id="email" placeholder="PassWord"
                    required>
            </div>
            <div class="mb-3 mt-3">
                <label for="avatar">Avata</label>
                <input type="file" name="avatar">
            </div>
           

            <div class="mb-3 mt-3">
                <label for="GioiTinh">Giới Tính:</label>
                <select name="GioiTinh" required>
                    <option value="Nam">Nam</option>
                    <option value="Nữ">Nữ</option>
                </select>

                <label for="TrangThai">Trạng Thái:</label>
                <select name="TrangThai" required>
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
            </div>
            <button class="btn btn-primary" type="submit">ADD NEW CUSTOMERS</button>
        </form>
    </div>
@endsection
