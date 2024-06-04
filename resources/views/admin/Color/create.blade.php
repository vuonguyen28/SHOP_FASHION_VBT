@extends('admin.layout.app')
@section('title','ADD NEW COLOR')

@section('content') 
    <div class="container mt-3">
        <form action="{{ route('Color.store') }}" method="POST">
            @csrf 
            <div class="mb-3 mt-3">
                <label for="TenMau">TÊN MÀU</label>
                <input type="text" name="TenMau" class="form-control" id="TenMau" placeholder="Name Color" required>
            </div>
            <div class="mb-3 mt-3">
                <label for="HEXCODE">HEX CODE</label>
                <input type="color" name="HEXCODE" class="form-control" id="HEXCODE" placeholder="Name Color" required>
            </div>

            <button class="btn btn-primary" type="submit">ADD NEW COLOR</button>
        </form>
    </div>
@endsection
