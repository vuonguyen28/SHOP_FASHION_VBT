 {{-- Bill --}}
 <div class="col-md-10">
    {{-- form search bill --}}
    <div class="form__search--bill col-md-12">
        <input type="text" id="search" placeholder="Search your order here...">
        <button type="submit"> <i class='bx bx-search-alt-2'></i></button>
    </div>

    {{-- form bill --}}
    <div class="row">
        <div class="form__bill">
            <div class="row">
                <div class="form__bill--header">
                    <a href="{{ route('bill.ShowOrderedBill') }}" onclick="highlight(this)">Đơn Đã Đặt</a>
                    <a href="{{ route('bill.CheckYourOrder') }}" onclick="highlight(this)">Đơn Đang Giao</a>
                    <a href="{{ route('bill.ShowDeliveredBill') }}" onclick="highlight(this)">Đơn Đã Nhận</a>
                    <a href="{{ route('bill.ShowCancelledBill') }}" onclick="highlight(this)">Đơn Đã Hủy</a>
                </div>