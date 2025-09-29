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

    @if ($show_auth)
    @if (@auth('account')->user()?->types->where('type', 'donor')->first() == null)


    <div class="cart-main mb-0">
        <div class="User cart-form-tabs">

            <div class="Btns d-flex">
                <button class="btn btn_user tab-btn mx-3 @if (!$new_donor) active @endif" wire:click="updateNewDonor(0)">
                    @lang('Old Donor')
                </button>
                <button class="btn btn_user tab-btn @if ($new_donor) active @endif" wire:click="updateNewDonor(1)">
                    @lang('New Donor')
                </button>
            </div>
        </div>

        <div class="cart-form">

            @if ($authError != '')
            <div class="alert alert-warning alert-dismissible fade show alert-small" role="alert">
                {{ $authError }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif



            {{-- @livewire('site.auth.register', ['showDescription1' => false], key('register-' . now())) --}}

            <form class="auth-form @if (!$new_donor) d-none @endif" id="register-form">

                <!--username-->
                <div class="form-group mb-2">
                    <label for="name" class="form-label"> @lang('Name') <span class="text-danger">*</span> </label>
                    <input type="text" wire:model="name" class="form-control" id="name" dir="rtl" placeholder="@lang('Full Name')" />
                    @error('name')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!--Phone with Country Code-->
                <div class="form-group mb-2" wire:ignore>
                    <label for="mobile" class="form-label ">@lang('Mobile') <span class="text-danger">*</span> </label>
                    <input type="number" class="form-control mobile" wire:model="mobile" value="{{ $mobile }}" wire:ignore id="mobile" style="direction: ltr" />
                    <input id="countryData" wire:model="mobileWithCode" wire:ignore value="" {{ $mobileWithCode }} type="hidden" />
                    <!-- Error message for invalid mobile number -->
                    <span class="text-danger" id="notification-register"></span>
                    @error('mobile')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!--email-->
                <div class="form-group mb-2">
                    <label for="email" class="form-label">
                        @lang('Email') </label>
                    <input type="email" wire:model="email" class="form-control" dir="rtl" placeholder="@lang('Email')" />
                    @error('email')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- btn-->
                <div class="form-group mb-3">
                    <button type="button" id="btnSend" class="btn btn-primary w-100 register submit_form" @if ($otp_modal) disabled @endif>
                        @lang('Create New Account')
                    </button>
                </div>
            </form>

            <form class="auth-form @if ($new_donor) d-none @endif" id="login-form">
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
                </div>
            </form>

            {{-- @livewire('site.auth.login', ['showDescription' => false], key('login-' . now())) --}}


            <!-- OTP Modal -->
            <div class="modal fade @if ($otp_modal)show @endif" @if ($otp_modal)style="display: block;" @endif id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">@lang('OTP') </h5>
                            <div class="col-md-3 text-start">
                                <button type="button" wire:click="closeModalOTP()" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                        </div>
                        <div class="modal-body">
                            <div class="row text-center">
                                <div class="col-md-9">
                                    <input type="text" max="4" min="4" wire:model="otp" class="form-control">
                                </div>
                                <div class="col-md-3">
                                    <button class="btn btn-primary" type="button" wire:click="checkOTP()">@lang('Send') </button>
                                </div>
                                @if ($otpError)
                                <h5 class="success-message text-danger mt-3">
                                    <span class="message"> {{ $otpError }} </span>
                                </h5>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    @endif


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

    <script>
        $(document).ready(function() {
            var phoneInputFieldRegister = document.querySelector("#mobile");
            var phoneInputFieldRegister = window.intlTelInput(phoneInputFieldRegister, {
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

            $(window).keydown(function(event) {
                if (event.keyCode == 13) {
                    event.preventDefault();
                    return false;
                }
            });
            $(".submit_form").on("click", function(e) {
                $("#notification-register").html("");
                var full_numberRegister = phoneInputFieldRegister.getNumber(intlTelInputUtils.numberFormat.E164);
                var isValidRegister = phoneInputFieldRegister.isValidNumber();
                $("#countryData").val(full_numberRegister);
                console.log(full_numberRegister, isValidRegister);

                if (isValidRegister) {
                    console.log("registttter", isValidRegister);
                    Livewire.emit('register', full_numberRegister);
                } else {
                    var msg = "رقم الجوال المدخل غير صحيح";
                    $("#notification-register").html(msg);
                }
            });
        });

    </script>

</div>
<style>
    .cart-main-checkout {
        width: 400px !important;
    }

</style>
