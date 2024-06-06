@extends('account.layouts.layout')

@section('title', 'BILL CUSTOMER')

@section('content')

    {{-- menu right --}}
    @include('account.Order.menu_layout_bill')


    {{-- Hiển thị thông báo thành công nếu có --}}
    @if (session('success'))
        <script>
            Swal.fire({
                title: "Thông Báo",
                text: " {{ session('success') }}",
                icon: "success"
            });
        </script>
    @endif

    {{-- Hiển thị thông báo lỗi chung nếu có --}}
    @if (session('error'))
        <script>
            Swal.fire({
                title: "The Internet?",
                text: "  {{ session('error') }}",
                icon: "error"
            });
        </script>
    @endif

    {{-- end header --}}
    {{-- start content --}}
    <div class="col-md-10">
        <div class="row form__bill--content">
            <div class="row form_profile">
                {{-- avatar --}}
                <div class="col-md-5 form__edit--profile-avatar">
                    <div class="profile__avatar">
                        <img src="{{  $customer->avatar }}" width="100" height="100"
                            alt="Current Avatar">
                    </div>
                    <div class="profile__btn--choose-avatar">
                        <button type="button" class="btn" data-bs-toggle="modal"
                            data-bs-target="#updateAddressModal_image">
                            Upload Image
                        </button>
                    </div>
                </div>

                {{-- infomation --}}
                <div class="col-md-7 form__edit--info">

                    <div class="row">
                        <div class="col-md-6  form__edit--info-col1">
                            {{-- name --}}
                            <label for="TenKH">Họ và tên:
                                <button type="button" class="btn"
                                    data-bs-toggle="modal"data-bs-target="#updateAddressModal_NAME">
                                    <i class='bx bx-edit-alt'></i>
                                </button>
                            </label>
                            <input type="text" name="TenKH" value="{{ $customer->TenKH }}" class="form-control"
                                id="name" placeholder="Enter Name" required readonly>

                            {{-- phone --}}
                            <label for="SoDienThoai">Số Điện Thoại:
                                <button type="button" class="btn" data-bs-toggle="modal"
                                    data-bs-target="#updateAddressModal_Phone"><i class='bx bx-edit-alt'></i></button>
                            </label>
                            <input type="text" name="SoDienThoai" value="{{ $customer->SoDienThoai }}"
                                class="form-control" id="phone" placeholder="Enter Phone" required readonly>


                            {{-- address  --}}
                            <label for="DiaChi">Address:
                                <button type="button" class="btn" data-bs-toggle="modal"
                                    data-bs-target="#updateAddressModal_Address">
                                    <i class='bx bx-edit-alt'></i></button>
                            </label>
                            <input type="text" name="DiaChi" value="{{ $customer->DiaChi }}" class="form-control"
                                id="adđress" placeholder="Enter Address" required readonly>


                            {{-- btn_change password --}}
                            <div class="form__edit--info-changepass">
                                <button type="button" class="btn" data-bs-toggle="modal"
                                    data-bs-target="#updateAddressModal_Password">Change Password
                                </button>
                            </div>
                        </div>



                        <div class="col-md-6 form__edit--info-col2">
                            <label for="GioiTinh">Giới Tính:
                                <button type="button" class="btn" data-bs-toggle="modal"
                                    data-bs-target="#updateAddressModal_gender">
                                    <i class='bx bx-edit-alt'></i>
                                </button>
                            </label>
                            <input type="text" name="GioiTinh" value="{{ $customer->GioiTinh }}" class="form-control"
                                id="gioitinh" placeholder="Enter Gender" required readonly>

                            {{-- email --}}
                            <label for="Email">Email:
                                <button type="button" class="btn" data-bs-toggle="modal"
                                    data-bs-target="#updateAddressModal_Email">
                                    <i class='bx bx-edit-alt'></i>
                                </button>
                            </label>
                            <input type="email" name="Email" value="{{ $customer->Email }}" class="form-control"
                                id="email" placeholder="Enter email" required  readonly>
                        </div>
                    </div>


                </div>
            </div>

        </div>
    </div>




    <div class="modal" id="updateAddressModal_NAME">
        <div class="modal-dialog">
            <form action="{{ route('profile.editName') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">User Name</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <input type="hidden" name="sumTotalMoney" value="">
                        <div class="form-group">
                            <label>USER NAME</label>
                            <input value="" name="name" placeholder="text feedback">
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger">UPDATE PROFILE</button>
                    </div>

                </div>
            </form>
        </div>
    </div>





    <div class="modal" id="updateAddressModal_Phone">
        <div class="modal-dialog">
            <form action="{{ route('profile.editPhone') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Phone</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <input type="hidden" name="sumTotalMoney" value="">
                        <div class="form-group">
                            <label>phone</label>
                            <input value="" name="Phone" placeholder="text feedback">
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger">UPDATE PROFILE</button>
                    </div>

                </div>
            </form>
        </div>
    </div>





    <div class="modal" id="updateAddressModal_Email">
        <div class="modal-dialog">
            <form action="{{ route('profile.editEmail') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Email</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <input type="hidden" name="sumTotalMoney" value="">
                        <div class="form-group">
                            <label>Email</label>
                            <input value="" name="Email" placeholder="Email">
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger">UPDATE PROFILE</button>
                    </div>

                </div>
            </form>
        </div>
    </div>




    <div class="modal" id="updateAddressModal_Address">
        <div class="modal-dialog">
            <form action="{{ route('profile.editAddress') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Address</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <input type="hidden" name="sumTotalMoney" value="">
                        <div class="form-group">
                            <label>Address</label>
                            <input value="" name="Address" placeholder="Address">
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger">UPDATE PROFILE</button>
                    </div>

                </div>
            </form>
        </div>
    </div>



    <div class="modal" id="updateAddressModal_gender">
        <div class="modal-dialog">
            <form action="{{ route('profile.editgender') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">gender</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <select class="form-select" id="gender" name="gender" style="width:50%">
                            <option value="Nam" {{ $customer->GioiTinh == 'Nam' ? 'selected' : '' }}>Nam</option>
                            <option value="Nữ" {{ $customer->GioiTinh == 'Nữ' ? 'selected' : '' }}>Nữ</option>
                        </select>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger">UPDATE PROFILE</button>
                    </div>

                </div>
            </form>
        </div>
    </div>



    <div class="modal" id="updateAddressModal_image">
        <div class="modal-dialog">
            <form action="{{ route('profile.editimage') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">image</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <div class="profile__btn--choose-avatar">
                            <input type="file" name="avatar" id="avatar">
                            <label for="avatar">Upload file</label>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger">UPDATE PROFILE</button>
                    </div>

                </div>
            </form>
        </div>
    </div>





    <div class="modal" id="updateAddressModal_Password">
        <div class="modal-dialog">
            <form action="{{ route('profile.editPassword') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Password</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <input type="hidden" name="sumTotalMoney" value="">
                        <div class="form-group">
                            <label>nhập mật khẩu cũ</label>
                            <input type="password" value="" name="oldPassword" placeholder="Password">
                        </div>
                    </div>

                    <div class="modal-body">
                        <input type="hidden" name="sumTotalMoney" value="">
                        <div class="form-group">
                            <label>nhập mật khẩu mới</label>
                            <input type="password" value="" name="Password" placeholder="Password">
                        </div>
                    </div>




                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger">UPDATE PROFILE</button>
                    </div>

                </div>
            </form>
        </div>
    </div>


@endsection
