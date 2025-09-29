{{-- login --}}

<div>
    <!-- Add required CSS and JS libraries -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css" />
    <style>
        .iti {
            width: 100%;
        }

        .iti-mobile .iti__country-list {
            width: 90%;
        }

        .iti__country-name {
            display: none;
        }

    </style>

    @if ($authMessage)
    <h5 class="success-message">
        <span class="icon"> <i class="icofont-check"></i> </span>
        <span class="message"> {{ $authMessage }} </span>
    </h5>
    @endif

    <div class="row" @if($otp_modal || $register_modal)style="opacity:0.3" @endif>
        <div class="col-12">
            <div class="auth-card">
                <div class="auth-header">
                    <h2 class="auth-title">
                        <i class="fas fa-lock-open"></i> تسجيل الدخول إلى حسابك
                    </h2>
                </div>
                <div class="auth-body">
                    @if ($showDescription)
                    <p class="auth-description">
                        مرحبًا بك يا باني الخير! سجل دخولك للوصول إلى حسابك، ومتابعة
                        نشاطاتك السابقة سواء كانت تبرعات، أو خدمات، أو مشاركات في
                        حملات دعم الفئات.
                    </p>
                    <p class="auth-description">
                        نحن نقدر وجودك معنا، ونتطلع لأن تواصل مسيرتك في العطاء
                        والإسهام في صناعة التغيير.
                    </p>
                    @endif

                    <form class="auth-form" id="login-form">
                        <div class="form-group text-center">
                            <label for="mobile" class="form-label">@lang('Mobile') <span class="text-danger">*</span></label>

                            <div class="input-group" wire:ignore>
                                <input type="number" wire:ignore id="login-mobile" class="form-control iti-phone" wire:model.defer="mobile" placeholder="@lang('Log in using mobile number')" style="direction: ltr" />
                                <input id="countryData-login" wire:ignore wire:model="mobileWithCode" value="{{ $mobileWithCode }}" type="hidden" />
                            </div>

                            <div class="row">
                                <div class="text-center">

                                    <span class="text-danger" id="notification-login"></span>
                                    <!-- Display auth error message -->
                                    @if ($authError)
                                    <div class="alert alert-danger" role="alert">
                                        {{ $authError }}
                                    </div>
                                    @endif

                                    <!-- Display validation error message -->
                                    @error('mobile')
                                    <div class="alert alert-danger" role="alert">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="button" id="btnSend" class="btn btn-primary auth-btn w-100 submit_form login" @if ($otp_modal ?? false) disabled @endif>
                                @lang('Send')
                            </button>
                            @if ($showDescription)
                            <p class="mt-3 text-center">
                                <span>@lang('Don`t have an account?')</span>
                                <a class="" href="{{ route('site.register') }}">@lang('Create an account')</a>
                            </p>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>



    <div class="modal fade @if ($register_modal ?? false) show @endif" @if ($register_modal ?? false) style="display: block; " @endif id="register_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row text-center">
                        <div class="col-md-8">
                            <p class="mt-3"> {{ $registerMessage }} </p>
                        </div>
                        <div class="col-md-3 mt-3">
                            <a href="{{ route('site.register') }}" class="bg-primary text-white p-2 rounded">@lang('Create an account')</a>
                        </div>
                        <div class="col-md-1 mt-3">
                            <button type="button" wire:click="closeRegisterModalOTP()" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="modal fade @if ($otp_modal ?? false) show @endif" @if ($otp_modal ?? false) style="display: block; " @endif id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">@lang('OTP') </h5>
                    <div class="col-md-3 text-start">
                        <button type="button" wire:click="closeModalOTP()" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="row text-center">
                        <div class="col-md-9">
                            <input type="text" max="4" min="4" wire:model="otp" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <button class="btn btn-primary auth-btn mt-2" type="button" wire:click="checkOTP()">@lang('Send')
                            </button>
                        </div>
                        @if ($otpError ?? false)
                        <h5 class="success-message text-danger mt-3">
                            <span class="message"> {{ $otpError }} </span>
                        </h5>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- International Tel Input Script -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>

    <script>
        $(document).ready(function() {
            var phoneInputField = document.querySelector("#login-mobile");
            var phoneInput = window.intlTelInput(phoneInputField, {
                preferredCountries: ['sa', 'ae', 'kw', 'qa', 'bh', 'om']
                , separateDialCode: true
                , utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js"
                , initialCountry: "auto"
                , geoIpLookup: function(success, failure) {
                    fetch("https://ipapi.co/json")
                        .then(function(res) {
                            return res.json();
                        })
                        .then(function(data) {
                            success(data.country_code);
                        })
                        .catch(function() {
                            failure();
                        });
                }
            });

            console.log(phoneInputField);
            console.log(phoneInput);

            $(window).keydown(function(event) {
                if (event.keyCode == 13) {
                    event.preventDefault();
                    return false;
                }
            });
            $("#login-form .submit_form.login").on("click", function(e) {
                $("#notification-login").html("");
                var full_number = phoneInput.getNumber(intlTelInputUtils.numberFormat.E164);
                var isValid = phoneInput.isValidNumber();
                console.log(full_number);
                console.log(isValid);
                $("#countryData").val(full_number);
                if (isValid) {
                    Livewire.emit('login', full_number);
                } else {
                    var msg = "رقم الجوال المدخل غير صحيح";
                    $("#notification-login").html(msg);
                }
            });
        });
    </script>
</div>
