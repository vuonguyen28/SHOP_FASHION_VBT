<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="{{ asset('css/customer/style_login_register.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<style>
    body {
        background-image: url("{{ asset('images/bgnew1.jpg ') }}");
        height: auto;
    }


    .error-message {
        color: red;
        margin-top: 10px;
    }

    .form-wrapper {
        position: relative;
        width: 900px;
        margin-top: 70px;
    }

    .form-container {
        position: absolute;
        width: 100%;
        transition: opacity 0.3s ease-in-out, visibility 0.3s ease-in-out;
    }

    .hidden {
        opacity: 0;
        visibility: hidden;
    }

    .visible {
        opacity: 1;
        visibility: visible;
    }
</style>

<body>

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


    <div class="container d-flex justify-content-center align-items-center">

        <div class="form-wrapper">
            {{-- login form --}}
            <div id="login-form" class=" form-container main__form--login row boder rounded-5 p-3 shadow box-area">

                {{-- left box --}}
                <div
                    class="col-md-6 rounded-4 d-flex justify-content-center align-items-center flex-column left__form--login">
                    <div class="featured-image mb-3">
                        <img src="{{ asset('images/logo_shopbvt.png') }}" class="img-fluid" style="width: 250px;">
                    </div>
                    <p>FASHION - SHOP </p>
                    <small>Lựa chọn ngay phong cách cho riêng bạn!!!</small>

                </div>
                {{-- end left box --}}

                {{-- right box --}}
                <div class="col-md-6 right__form--login">

                    <div class="row align_items-center">

                        <div class="form__login--header mb-4">
                            <p>Chào Mừng, Quay Trở Lại</p>
                            <h5>Hãy đăng nhập để xem sản phẩm của bạn</h5>
                        </div>

                        <form action="{{ route('login.login') }}" method="POST">
                            @csrf
                            <div class="form-group form__login--input mb-3">
                                <label for="username">Email:</label>
                                <input class="form-control fs-6 " type="email" id="email" name="email" required>
                                {{-- <input type="text" class="form-control fs-6 " > --}}
                            </div>

                            <div class="form-group form__login--input mb-1">
                                <label for="password">Password:</label>
                                <input class="form-control fs-6 " type="password" id="password" name="Password_hs5"
                                    required>
                                {{-- <input type="password" class="form-control fs-6 " placeholder="Password"> --}}
                            </div>

                            <div class="form__login--input mb-5 d-flex justify-content-between">
                                <div class="form__login--check">
                                    <input type="checkbox" class="form-check-input" id="formcheckremember">
                                    <label for="formcheckremember"
                                        class="form-check-label text-secondary"><small>Remember
                                            me</small></label>
                                </div>
                                <div class="form__login--forgot">
                                    <small><a id="emailLink" href="#">Quên mật khẩu?</a></small>
                                </div>
                            </div>

                            @if (session('error'))
                                <div class="error-message">{{ session('error') }}</div>
                            @endif
                            <div class="form__login--input mb-3">
                                <button type="submit" class="w-100">Login</button>
                            </div>
                            <div class="row">
                                <small>Bạn chưa có tài khoản?<a id="registerLink" href="#">Đăng ký</a></small>
                            </div>
                            {{-- <button type="submit">Login</button> --}}
                        </form>

                    </div>
                </div>
                {{-- end right box --}}

            </div>

            {{-- register form --}}
            <div id="register-form" class="form-container main__form--register row boder rounded-5 p-3  shadow box-area hidden">

                {{-- left box --}}
                <div
                    class="col-md-6 rounded-4 d-flex justify-content-center align-items-center flex-column left__form--login">
                    <div class="featured-image mb-3">
                        <img src="{{ asset('images/logo_shopbvt.png') }}" class="img-fluid" style="width: 250px;">
                    </div>
                    <p>FASHION - SHOP </p>
                    <small>Lựa chọn ngay phong cách cho riêng bạn!!!</small>

                </div>
                {{-- end left box --}}

                {{-- right box --}}
                <div class="col-md-6 right__form--login">

                    <div class="row align_items-center">

                        <div class="form__login--header mb-4">
                            <p>Đăng Ký Tài Khoản</p>
                        </div>

                        <form action="{{ route('login.Register') }}" method="POST">
                            @csrf
                            <div class="form-group form__login--input mb-3">
                                <label for="username">Full Name</label>
                                <input class="form-control fs-6 " type="text" id="username" name="username"
                                    required>
                            </div>

                            <div class="form-group form__login--input mb-3">
                                <label for="email">Email:</label>
                                <input class="form-control fs-6 " type="email" id="email" name="email" required>
                                {{-- <input type="text" class="form-control fs-6 " > --}}
                            </div>

                            <div class="form-group form__login--input mb-1">
                                <label for="password">Password:</label>
                                <input class="form-control fs-6 " type="password" id="password" name="Password_hs5"
                                    required>
                                {{-- <input type="password" class="form-control fs-6 " placeholder="Password"> --}}
                            </div>

                            <div class="form-group form__login--input mb-1">
                                <label for="confirmpassword">Confirm password:</label>
                                <input class="form-control fs-6 " type="password" id="confirmpassword"
                                    name="confirmPassword_hs5" required>
                                {{-- <input type="password" class="form-control fs-6 " placeholder="Password"> --}}
                            </div>

                            <div class="form__login--input mb-5 d-flex justify-content-between">
                                <div class="form__login--forgot">
                                    <small><a href="#">Quên mật khẩu?</a></small>
                                </div>
                            </div>

                            @if (session('error'))
                                <div class="error-message">{{ session('error') }}</div>
                            @endif
                            <div class="form__login--input mb-3">
                                <button type="submit" class="w-100">Register</button>
                            </div>
                            <div class="row">
                                <small>Bạn đã có tài khoản?<a id="loginLink" href="#">Đăng nhập</a></small>
                            </div>
                            {{-- <button type="submit">Login</button> --}}
                        </form>

                    </div>
                </div>
                {{-- end right box --}}

            </div>
        </div>

    </div>

    </div>


    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        document.getElementById('emailLink').addEventListener('click', async function(event) {
            event.preventDefault(); // Ngăn chặn hành động mặc định của thẻ <a>

            const {
                value: email
            } = await Swal.fire({
                title: "Input email address",
                input: "email",
                inputLabel: "Your email address",
                inputPlaceholder: "Enter your email address"
            });

            if (email) {
                // Gửi dữ liệu email đến server qua AJAX
                $.ajax({
                    url: '/send-email', // Đường dẫn đến route xử lý trong Laravel
                    type: 'POST',
                    data: {
                        email: email,
                        _token: $('meta[name="csrf-token"]').attr('content') // CSRF token
                    },
                    success: function(response) {
                        if (response.message) {
                            // Hiển thị thông báo thành công nếu tồn tại thông báo từ server
                            Swal.fire('Success', response.message, 'success');
                            // Thay đổi nội dung của một phần tử trên trang
                            document.getElementById('result').innerHTML = response.message;
                        } else if (response.error) {
                            // Hiển thị thông báo lỗi nếu tồn tại thông báo lỗi từ server
                            Swal.fire('Error', response.error, 'error');
                        } else {
                            // Xử lý trường hợp không có dữ liệu phản hồi từ server
                            Swal.fire('Error', 'There was an error sending the email.', 'error');
                        }
                    }

                });
            }
        });
    </script>

    {{-- js xử lý chuyển form login - register --}}
    <script>
        document.getElementById('registerLink').addEventListener('click', function(event) {
            event.preventDefault();
            document.getElementById('login-form').classList.remove('visible');
            document.getElementById('login-form').classList.add('hidden');
            document.getElementById('register-form').classList.remove('hidden');
            document.getElementById('register-form').classList.add('visible');
        });

        document.getElementById('loginLink').addEventListener('click', function(event) {
            event.preventDefault();
            document.getElementById('register-form').classList.remove('visible');
            document.getElementById('register-form').classList.add('hidden');
            document.getElementById('login-form').classList.remove('hidden');
            document.getElementById('login-form').classList.add('visible');
        });
    </script>

</body>

</html>
