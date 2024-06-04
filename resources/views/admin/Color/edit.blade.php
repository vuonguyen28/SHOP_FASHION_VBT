@extends('admin.layout.app')
@section('title','EDIT Color')

@section('content')
    <div class="container mt-3">
        <form action="{{ route('Color.update', $Color->MaMau) }}" method="POST">
            @csrf {{-- Cross-Site Request Forgery --}}
            @method('PUT')
            <div class="mb-3 mt-3">
                <label for="TenMau">TÊN MÀU</label>
                <input type="text" name="TenMau" value="{{ $Color->TenMau }}" class="form-control" id="color"
                    placeholder="name Color" required>
            </div>
            <div class="mb-3 mt-3">
                <label for="HEXCODE">HEX CODE</label>
                <input type="color" name="HEXCODE" value="{{ $Color->HEXCODE }}" class="form-control" id="HEXCODE" placeholder="Name Color" required>
            </div>


            <button class="btn btn-primary" type="submit">Save Color</button>
        </form>
    </div>
@endsection
