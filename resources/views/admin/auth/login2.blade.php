<!doctype html>
<html lang="en" @if($current_lang=="ar" ) dir="rtl" @else dir="ltr" @endif>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title> {{ config('app.name')  }} | @lang('admin.login') </title>
    <!--favicon-->
    <link rel="icon" href="{{ admin_path('images/logos/holol-icon.png') }}" type="image/png" />

    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">

    @if (app()->getLocale() == 'ar')
    @vite(['resources/assets/admin/app-style-rtl.css'])
    @else
    @vite(['resources/assets/admin/app-style.css'])
    @endif

    <style>
        .accountbg {
            position: absolute;
            background-size: cover;
            height: 100%;
            width: 100%;
            top: 0;
        }

        .holol-login {
            .card {
                background-color: transparent;
                box-shadow: 0px 6px 19px 0px rgba(0, 0, 0, 0.2), 0 1px 10px 0 rgba(0, 0, 0, 0.19) !important;
                border-radius: 10px;
            }
            .logo-box {
                background-color: rgba(253, 248, 247, 0.4);
                border-radius: 10px;
            }
            p {
                color: #000;
            }
            input,
            .form-control:focus {
                border: 1px solid rgba(253, 248, 247, 0.4);
            }
            button {
                background-color: #096aa9;
            }
            button:hover {
                color: #096aa9 !important;
                background-color: #fff !important;
            }
            .btn-check:active+.btn,
            .btn-check:checked+.btn,
            .btn.active,
            .btn.show,
            .btn:active {
                color: #096aa9;
                background-color: #fff;
            }
    </style>

</head>

<body>
    @php
    $adminLoginTheme = json_decode(App\Models\Themes::loginDashboard()->get()->first()->value ?? '');
    @endphp
    <div class="accountbg" style="background:  url('{{ @$adminLoginTheme->background != null ? getImage(@$adminLoginTheme->background) : admin_path('images/cover.jpg') }}');background-size: cover;background-position: center;">
    </div>
    <div class="wrapper">
        <div class="section-authentication-cover">
            <div class="holol-login account-pages mt-5 pt-5">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-8 col-lg-5 col-xl-4">

                            <div class="card border-0">
                                <div class="logo-box card-body border-0" style="background-color:{{ @$adminLoginTheme->box_color }}; color:{{ @$adminLoginTheme->font_color }}">
                                    <div class="text-center">
                                        <div class="col-md-12">
                                            <a href="{{ route('admin.login') }}">
                                                <img src="{{ @$adminLoginTheme->logo_image != null ? getImage(@$adminLoginTheme->logo_image) :  admin_path('images/logos/holol-logo.png') }}"alt="logo"></a>
                                        </div>
                                        @include('admin.layouts.message')
                                    </div>
                                    <div class="p-3">
                                        <h4 class="text-center">@lang('admin.welcome_back') </h4>

                                        <p class="text-center mb-4" style="color:{{ @$adminLoginTheme->font_color }} !important"> @lang('admin.sign_in')
                                        </p>



                                        <form class="form-horizontal" method="POST" action="{{ route('admin.login') }}">
                                            @csrf
                                            <div class="mb-3">
                                                <label class="form-label" for="username"> @lang('admin.email') </label>
                                                <input id="email" class="form-control" type="email" name="email" value="{{ old('email') }}" required autofocus>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label" for="userpassword"> @lang('admin.password') </label>
                                                <input id="password" class="form-control" type="password" name="password" required autocomplete="current-password">
                                            </div>

                                            <div class="row mt-4">
                                                <div class="col-sm-12 text-center">
                                                    <button class="btn btn-primary w-md waves-effect waves-light border-0 hover-cutom" type="submit" style=" background-color:{{ @$adminLoginTheme->button_color }};">
                                                        @lang('admin.login') </button>
                                                </div>
                                            </div>
                                        </form>

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @vite(['resources/assets/admin/app-script.js'])

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#show_hide_password a").on('click', function(event) {
                event.preventDefault();
                if ($('#show_hide_password input').attr("type") == "text") {
                    $('#show_hide_password input').attr('type', 'password');
                    $('#show_hide_password i').addClass("bx-hide");
                    $('#show_hide_password i').removeClass("bx-show");
                } else if ($('#show_hide_password input').attr("type") == "password") {
                    $('#show_hide_password input').attr('type', 'text');
                    $('#show_hide_password i').removeClass("bx-hide");
                    $('#show_hide_password i').addClass("bx-show");
                }
            });
        });

        function togglePasswordVisibility() {
            const passwordInput = document.getElementById("inputChoosePassword");
            const visibilityIcon = document.getElementById("passwordVisibilityIcon");

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                visibilityIcon.classList.replace("bx-hide", "bx-show");
            } else {
                passwordInput.type = "password";
                visibilityIcon.classList.replace("bx-show", "bx-hide");
            }
        }

    </script>
</body>
</html>
