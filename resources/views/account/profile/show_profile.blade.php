@extends('account.layouts.layout')

@section('title', 'BILL CUSTOMER')

@section('content')

    {{-- menu right --}}
    @include('account.Order.menu_layout_bill')


    {{-- end header --}}
    {{-- start content --}}
    <div class="col-md-10">
        <div class="row form__bill--content">
            <div class="row form_profile">
                {{-- avatar --}}
                <div class="col-md-5 form__edit--profile-avatar">
                    <div class="profile__avatar">
                        {{-- <img src="{{ asset('avatars/' . $customer->avatar) }}" width="100" height="100" alt="Current Avatar"> --}}
                    </div>

                    <div class="profile__btn--choose-avatar">
                        <input type="file" name="avatar" id="avatar">
                        <label for="avatar">Upload file</label>
                    </div>
                </div>

                {{-- infomation --}}
                <div class="col-md-7 form__edit--info">

                    <div class="row">
                        <div class="col-md-6">
                            <label for="TenKH">Họ và tên:</label>
                            {{-- <input type="text" name="TenKH" value="{{ $customer->TenKH }}" class="form-control" id="name" --}}
                            {{-- placeholder="Enter Name" required> --}}
                        </div>
                        <div class="col-md-6">
                            <label for="GioiTinh">Giới Tính:</label>
                            <select class="form-select" id="gender" name="GioiTinh" style="width:50%">
                                {{-- <option value="Nam" {{ $customer->GioiTinh == 'Nam' ? 'selected' : '' }}>Nam</option>
                                <option value="Nữ" {{ $customer->GioiTinh == 'Nữ' ? 'selected' : '' }}>Nữ</option> --}}
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label for="SoDienThoai">Số Điện Thoại:</label>
                            {{-- <input type="text" name="SoDienThoai" value="{{ $customer->SoDienThoai }}" class="form-control"
                                id="phone" placeholder="Enter Phone" required> --}}
                        </div>
                    </div>
                    <div class="mb-3 mt-3">
                        <label for="Email">Email:</label>
                        {{-- <input type="email" name="Email" value="{{ $customer->Email }}" class="form-control" id="email" --}}
                        {{-- placeholder="Enter email" required style="width:70%"> --}}
                    </div>
                    <div class="mb-3 mt-3">
                        <label for="Password_hs5">PassWord:</label>
                        {{-- <input type="password" name="Password_hs5" value="{{ $customer->Password_hs5 }}" class="form-control" --}}
                        {{-- id="password" placeholder="Enter Password" required style="width:70%"> --}}
                    </div>

                    <div class="mb-3 mt-3">
                        <label for="DiaChi">Địa Chỉ:</label>
                        {{-- <input type="text" name="DiaChi" value="{{ $customer->DiaChi }}" class="form-control" id="adđress"
                            placeholder="Enter Address" required style="width:90%"> --}}
                    </div>
                </div>
                <div class="col-md-12 ">
                    <div class="form__edit--btn">
                        <button  type="submit"><i class='bx bx-save'></i>SAVE CHANGE</button>
                    </div>
                </div>
            </div>

        </div>
    </div>
    </div>
    </div>
    {{-- end form bill  --}}
    </div>

    </div>


@endsection
