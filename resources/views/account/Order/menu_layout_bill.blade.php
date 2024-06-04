<style>
    .nav-item li.active {
        background-color: rgb(219, 219, 219);
        border-radius: 10px 0 0 10px;
    }

    .form__bill--header a.activeheader {
        background-color: #906C10;
    }
</style>

<div class="container">
    <div class="row">
        {{-- menu --}}
        <div class="col-md-2">
            <div class="form__info--main">
                @if (session('Avatar'))
                    <img class="avatar" src="{{ asset('avatars/' . session('Avatar')) }}" alt="User Avatar">
                @endif
                <p> {{ session('LoggedName') }}</p>
                <hr style="border: 1px solid black; width: 100%;">
                <nav>
                    <ul class="nav-item">
                        <li>
                            <i class='bx bx-user-circle'></i>
                            <a href="{{ route('user.ShowProfile') }}" onclick="highlight(this)">My Profile</a>
                        </li>
                        <li>
                            <i class='bx bx-cart-alt'></i>
                            <a href="{{ route('bill.CheckYourOrder') }}" onclick="highlight(this)">My Order</a>
                        </li>
                        <li>
                            <i class='bx bx-gift'></i>
                            <a  href="{{ route('voucher.MyVoucherLayout') }}" onclick="highlight(this)">My Voucher</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
       

                        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                        <script>
                            $(document).ready(function() {
                                // Get the current URL
                                var url = window.location.href;

                                // Check the URL against each menu item's href
                                $('.nav-item a').each(function() {
                                    if (url == $(this).attr('href')) {
                                        $(this).parent().addClass('active');
                                    }
                                });

                                // Highlight the active header link
                                $('.form__bill--header a').each(function() {
                                    if (url == $(this).attr('href')) {
                                        $(this).addClass('activeheader');
                                    }
                                });
                            });

                            function highlight(element, event) {
                                event.preventDefault(); // Ngăn chặn tải lại trang
                                $('.nav-item li').removeClass('active');
                                $(element).parent().addClass('active');

                                // Đối với các liên kết trong form__bill--header
                                $('.form__bill--header a').removeClass('activeheader');
                                $(element).addClass('activeheader');
                            }
                        </script>
