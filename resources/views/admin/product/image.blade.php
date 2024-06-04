@extends('admin.layout.app')
@section('title', 'EDIT Product')

@section('content')
    <h1>{{ $product->TenSP }}</h1>
    <p>Description: {{ $product->MoTa }}</p>

    <h2>Images:</h2>
    <ul>
        @foreach ($images as $image)
            <li><img src="{{ $image->hinhanh }}" alt="Image"></li>
        @endforeach
    </ul>
@endsection
