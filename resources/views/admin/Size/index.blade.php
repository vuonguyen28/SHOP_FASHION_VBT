@extends('admin.layout.app')
@section('title','LIST SIZE')

@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="container mt-3">
        <center>
            <h4>LIST SIZE</h4>
        </center>
        <table class="table">
            <thead class="table-success">
                <a class="btn btn-primary" href="{{ route('size.store') }}">
                    <i class='bx bxs-add-to-queue'></i> Create
                </a>
                <tr>
                    <th>ID</th>
                    <th>TÊN KÍCH THƯỚC</th>
                    <th>Edit</th>
                    <th>Delete</th>
                    <th>Details</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($size as $c)
                    <tr>
                        <td>{{ $c->MaKichThuoc }}</td>
                        <td>{{ $c->TenKichThuoc }}</td>
                        <td>
                            <a href="{{ route('size.edit', $c->MaKichThuoc) }}" class="btn btn-primary">
                                <i class='bx bx-edit'></i>
                            </a>
                        </td>
                        <td>
                            <form action="{{ route('size.destroy', $c->MaKichThuoc) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-warning">
                                    <i class='bx bx-trash'></i>
                                </button>
                            </form>
                        </td>
                        <td>
                            <a href="{{ route('size.show', $c->MaKichThuoc) }}" class="btn btn-success">
                                <i class='bx bxs-cart-alt'></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
