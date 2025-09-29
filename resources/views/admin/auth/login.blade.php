<!doctype html>
<html lang="en" @if($current_lang=="ar" ) dir="rtl" @else dir="ltr" @endif>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title> {{ config('app.name')  }} | @lang('admin.login') </title>
    <!--favicon-->
    <link rel="icon" href="{{ admin_path('images/logos/birrukum-icon.ico') }}" type="image/png" />

	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">

    @if (app()->getLocale() == 'ar')
    @vite(['resources/assets/admin/app-style-rtl.css'])
    @else
    @vite(['resources/assets/admin/app-style.css'])
    @endif

</head>

<body>
    @php
    $adminLoginTheme = json_decode(App\Models\Themes::loginDashboard()->get()->first()->value ?? '');
    @endphp
    <div class="wrapper">
        <div class="section-authentication-cover">
            <div class="">
                <div class="row g-0">
                    <div class="col-12 col-xl-7 col-xxl-8 auth-cover-left align-items-center justify-content-center d-none d-xl-flex"
                        style="background-image: url( {{ @$adminLoginTheme->background ? getImage(@$adminLoginTheme->background) : admin_path('images/logos/login_charity.jpg') }} ); background-repeat: no-repeat;">
                    <div class="card shadow-none bg-transparent shadow-none rounded-0 mb-0">
                            <div class="card-body">

                                {{-- <img src="{{ @$adminLoginTheme->background != null ? getImage(@$adminLoginTheme->background) : admin_path('images/login-images/login-cover.svg') }}" class="img-fluid auth-img-cover-login" width="650" alt="" /> --}}
                                {{-- <img src="{{ admin_path('images/login-images/login-cover.svg') }}" class="img-fluid auth-img-cover-login" width="650" alt=""/> --}}
                            </div>
                        </div>
                    </div>
                    <div class="login-card col-12 col-xl-5 col-xxl-4 auth-cover-right align-items-center justify-content-center">
                        <div class="card rounded-0 m-3 shadow-none bg-transparent mb-0">

                            @include('admin.layouts.message')

                            <div class="col-12 col-xl-12 col-xxl-12 mt-0 text-end ">
                                @foreach($locals as $local)
                                <a href="{{ \LaravelLocalization::getLocalizedURL($local , \Request::fullUrl() ) }}" class="btn btn-outline-primary">
                                    {{ substr(Locale::getDisplayName($local), 0, 2) }}
                                </a>
                                @endforeach
                            </div>
                            <div class="card-body p-sm-5">
                                <div class="">
                                    <div class="mb-3 text-center">
                                        <img src="{{ @$adminLoginTheme->logo_image  != null ? getImage( @$adminLoginTheme->logo_image ) : admin_path('images/logos/birrukum-logo.png') }}" width="50%" alt="">
                                    </div>
                                    <div class="text-center mb-4">
                                        <h5 class="" style="color:{{  @$adminLoginTheme->font_color  }} !important">@lang('admin.welcome') </h5>
                                    </div>
                                    <div class="form-body">
                                        <form class="row g-3" method="POST" action="{{ route('admin.login') }}">
                                            @csrf
                                            <div class="col-12">
                                                <label for="inputEmailAddress" class="form-label" style="color:{{  @$adminLoginTheme->font_color  }} !important">@lang('admin.email') </label>
                                                <input type="email" name="email" class="form-control" id="inputEmailAddress" placeholder="jhon@example.com" required>
                                            </div>
                                            <div class="col-12">
                                                <label for="inputChoosePassword" class="form-label" style="color:{{  @$adminLoginTheme->font_color  }} !important">@lang('admin.password')</label>

                                                <div class="input-group" id="show_hide_password">
                                                    <input type="password" name="password" class="form-control border-end-0" id="inputChoosePassword" placeholder="@lang('admin.enter_password')" required>
                                                    <a href="javascript:;" class="input-group-text bg-transparent" onclick="togglePasswordVisibility()">
                                                        <i class="bx bx-hide" id="passwordVisibilityIcon"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="d-grid">
                                                    <button type="submit" class="btn btn-primary" style=" background-color:{{ @$adminLoginTheme->button_color }}; border-color: {{ @$adminLoginTheme->button_color }} ;">@lang('admin.login')</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="login-separater text-center mb-5">
                                    </div>
                                    <div class="list-inline contacts-social text-center">
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
