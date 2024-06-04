@extends('admin.layout.app')
@section('title','LIST CATEGORY')

@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="container mt-3">
        <center>
            <h4>LIST CATEGORY</h4>
        </center>
        <table class="table">
            <thead class="table-success">
                <a class="btn btn-primary" href="{{ route('category.store') }}">
                    <i class='bx bxs-add-to-queue'></i> Create
                </a>
                <tr>
                    <th>ID</th>
                    <th>TÊN DANH MỤC</th>
                    <th>Edit</th>
                    <th>Delete</th>
                    <th>Details</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($category as $c)
                    <tr>
                        <td>{{ $c->MaDanhMuc }}</td>
                        <td>{{ $c->TenDanhMuc }}</td>
                        <td>
                            <a href="{{ route('category.edit', $c->MaDanhMuc) }}" class="btn btn-primary">
                                <i class='bx bx-edit'></i>
                            </a>
                        </td>
                        <td>
                            <form action="{{ route('category.destroy', $c->MaDanhMuc) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-warning">
                                    <i class='bx bx-trash'></i>
                                </button>
                            </form>
                        </td>
                        <td>
                            <a href="{{ route('category.show', $c->MaDanhMuc) }}" class="btn btn-success">
                                <i class='bx bxs-cart-alt'></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
