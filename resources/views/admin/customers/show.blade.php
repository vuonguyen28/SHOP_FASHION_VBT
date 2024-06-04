@extends('admin.layout.app')
@section('title','LIST CUSTOMERS')

@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="container mt-3">
        <center>
            <h4>LIST CUSTOMERS</h4>
        </center>
        <table class="table">
            <thead class="table-success">
                <a class="btn btn-primary" href="{{ route('customers.add') }}">
                    <i class='bx bxs-add-to-queue'></i> create
                </a>
                <tr>
                    <th>ID</th>
                    <th>AVATAR</th>
                    <th>NAME</th>
                    <th>PHONE</th>
                    <th>EMAIL</th>
                    <th>ADDRESS</th>
                    <th>GENDER</th>
                    <th>STATUS</th>
                    <th>ROLE</th>
                    <th>Edit</th>
                    <th>Delete</th>
                    <th>Details</th>

                </tr>
            </thead>
            <tbody>
                @foreach ($customers as $c)
                    <tr>
                        <td>{{ $c->MaKH }}</td>
                        <td>
                            <img style="border-radius: 50%" src="{{ asset('avatars/' . $c->avatar) }}" width="70px"
                                height="70px" alt="Avatar">
                        </td>
                        <td>{{ $c->TenKH }}</td>
                        <td>{{ $c->SoDienThoai }}</td>
                        <td>{{ $c->Email }}</td>
                        <td>{{ $c->DiaChi }}</td>
                        <td>{{ $c->GioiTinh }}</td>
                        <td>
                            {!! $c->TrangThai == 1 ? '<i class="fa fa-lock"></i>' : '<i class="fa fa-lock-open"></i>' !!}
                        </td>
                        <td>{{ $c->Role }}</td>

                        <td>
                            <a href="{{ route('customers.edit', $c->MaKH) }}" class="btn btn-primary">
                                <i class='bx bx-edit'></i>
                            </a>
                        </td>
                        <td>
                            <form action="{{ route('customers.delete', $c->MaKH) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-warning">
                                    <i class='bx bx-trash'></i>
                                </button>
                            </form>
                        </td>
                        <td>
                            <a href="{{ route('customers.edit', $c->MaKH) }}" class="btn btn-success">
                                <i class='bx bxs-cart-alt'></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
