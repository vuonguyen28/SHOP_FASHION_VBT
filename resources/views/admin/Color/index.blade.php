@extends('admin.layout.app')
@section('title','LIST COLOR')
<style>
    /* .box_color{
        width: 100px;
        height: 100px;
        background-color:  
    } */
</style>
@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="container mt-3">
        <center>
            <h4>LIST Color</h4>
        </center>
        <table class="table">
            <thead class="table-success">
                <a class="btn btn-primary" href="{{ route('Color.store') }}">
                    <i class='bx bxs-add-to-queue'></i> Create
                </a>
                <tr>
                    <th>ID</th>
                    <th>TÊN MÀU</th>
                    <th>Color</th>
                    <th></th>
                    <th>Edit</th>
                    <th>Delete</th>
                    <th>Details</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($color as $c)
                    <tr>
                        <td>{{ $c->MaMau }}</td>
                        <td>{{ $c->TenMau }}</td>
                        <td>
                            <div class="box_color" style="with:100px; height: 20px; background-color:{{ $c->HEXCODE }}">

                            </div>
                        </td>
                        <td>{{ $c->HEXCODE }}</td>
                        <td>
                            <a href="{{ route('Color.edit', $c->MaMau) }}" class="btn btn-primary">
                                <i class='bx bx-edit'></i>
                            </a>
                        </td>
                        <td>
                            <form action="{{ route('Color.destroy', $c->MaMau) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-warning">
                                    <i class='bx bx-trash'></i>
                                </button>
                            </form>
                        </td>
                        <td>
                            <a href="{{ route('Color.show', $c->MaMau) }}" class="btn btn-success">
                                <i class='bx bxs-cart-alt'></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
