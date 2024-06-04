@extends('admin.layout.app')
@section('title', 'ADD NEW PRODUCT')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <p style="font-weight: bold; font-size: 30px">Import Product From Excel</p>
                    </div>
                    <div class="card-body">

                        <form action="{{ route('product.import') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="file" name="import_file" class="form-control"/>
                            <button type="submit" class="btn btn-primary" style="margin-top: 20px">Import</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
