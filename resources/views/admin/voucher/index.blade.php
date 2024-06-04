@extends('admin.layout.app')
@section('title', 'LIST VOUCHER')
@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="container mt-3">
        <center>
            <h4>LIST VOUCHER</h4>
        </center>
        
        <div class="row mt-3 mb-3">
            <div class="col-md-6 offset-md-3">
                <form action="{{ route('voucher.search') }}" method="GET">
                    <div class="input-group">
                        <input type="text" class="form-control" name="keyword" placeholder="Tìm kiếm...">
                        <button class="btn btn-success" type="submit">Search</button>
                    </div>
                </form>
            </div>
        </div>
        
        <table class="table">
            <thead class="table-success">
                <a class="btn btn-primary" href="{{ route('voucher.store') }}">
                    <i class='bx bxs-add-to-queue'></i> Create
                </a>
                <tr>
                    <th>ID</th>
                    <th>TÊN VOUCHER</th>
                    <th>PHẦN TRĂM GIẢM</th>
                    <th>ĐƠN TỐI THIỂU</th>
                    <th>GIẢM TỐI ĐA</th>
                    <th>SỐ LƯỢNG</th>
                    <th>NGÀY BẮT ĐẦU</th>
                    <th>NGÀY KẾT THÚC</th>
                    <th>Edit</th>
                    <th>Delete</th>
                    <th>Details</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($voucher as $v)
                    <tr>
                        <td>{{ $v->MA_VOUCHER }}</td>
                        <td>{{ $v->Ten_VOUCHER }}</td>
                        <td>{{ $v->PhanTramGiam }}</td>
                        <td>{{ $v->DonToiThieu }}</td>
                        <td>{{ $v->GiamToiDa }}</td>
                        <td>{{ $v->SoLuongVOUCHER }}</td>
                        <td>{{ $v->Ngaybatdau }}</td>
                        <td>{{ $v->Ngayketthuc }}</td>
                        <td>
                            <a href="{{ route('voucher.edit', $v->MA_VOUCHER) }}" class="btn btn-primary">
                                <i class='bx bx-edit'></i>
                            </a>
                        </td>
                        <td>
                            <form action="{{ route('voucher.destroy', $v->MA_VOUCHER) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-warning">
                                    <i class='bx bx-trash'></i>
                                </button>
                            </form>
                        </td>
                        <td>
                            <a href="{{ route('voucher.show', $v->MA_VOUCHER) }}" class="btn btn-success">
                                <i class='bx bxs-cart-alt'></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
