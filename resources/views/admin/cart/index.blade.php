@extends('admin.layout.app')
@section('title', 'LIST CART')

@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="container mt-3">
        <center>
            <h4>LIST CART</h4>
        </center>
        <table class="table">
            <thead class="table-success">
                <a class="btn btn-primary" href="{{ route('cart.store') }}">
                    <i class='bx bxs-add-to-queue'></i> Create
                </a>
                <tr>

                    <th>ID</th>
                    <th>Mã khách hàng</th>
                    <th>Tên khách hàng</th>
                    <th>Mã chi tiết</th>
                    <th>Số lượng</th>
                    <th></th>
                    <th></th>
                    <th></th>

                </tr>
            </thead>
            <tbody>
                @foreach ($cart as $c)
                    <tr>
                        <td>{{ $c->MaGioHang }}</td>
                        <td>{{ $c->MaKhachHang }}</td>
                        <td>{{ $c->Customer->TenKH }}</td>
                        <td>{{ $c->MaChiTietSanPham }}</td>
                        <td>{{ $c->SoLuong }}</td>

                        <td>
                            <form id="delete-form-{{ $c->MaGioHang }}" action="{{ route('cart.destroy', $c->MaGioHang) }}"
                                method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-warning delete-btn" data-id="{{ $c->MaGioHang }}"
                                    onclick="confirmDelete('{{ $c->MaGioHang }}')">
                                    <i class='bx bx-trash'></i>
                                </button>
                            </form>
                        </td>
                        <td>
                            <a href="{{ route('cart.edit', $c->MaGioHang) }}" class="btn btn-primary">
                                <i class='bx bx-edit'></i>
                            </a>

                        </td>
                        <td>
                            <a href="" class="btn btn-success">
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
