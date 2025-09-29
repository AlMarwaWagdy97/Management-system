{{-- register --}}

<div>
    <!--   Add required CSS and JS libraries  -->
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


    <div class="row" @if($otp_modal )style="opacity:0.3" @endif>
        <div class="col-12">
            <div class="auth-card register-card">
                <div class="auth-header">
                    <h2 class="auth-title">
                        <i class="fas fa-lock"></i> تسجيل حساب جديد
                    </h2>
                </div>
                @if ($authMessage)
                <h5 class="success-message">
                    <span class="icon"> <i class="icofont-check"></i> </span>
                    <span class="message"> {{ $authMessage }} </span>
                </h5>
                @endif
             

                <div class="auth-body">
                    @if ($showDescription1)
                    <p class="auth-description">
                        انضم إلينا وكن جزءًا من مجتمع يسعى لصنع التغيير. يمكنك متابعة
                        مبادراتنا الخيرية، التبرع بسهولة وأمان، والمشاركة في حملات دعم
                        الفئات الأكثر احتياجًا.
                    </p>
                    <p class="auth-description">
                        حسابك هو خطواتك الأولى نحو عالم أفضل — عالم مليء بالأمل،
                        والعطاء، والتضامن. سجل الآن وكن سببًا في رسم الابتسامة على
                        وجوه الآخرين.
                    </p>
                    @endif
                    @if(@count($errors->all()) > 0)
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <div  class="text-center">
                                @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form class="auth-form" id="register-form">
                       

                        <!--username-->
                        <div class="form-group mb-2" wire:ignore>
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
                            @if ($authError)
                                <span class="text-danger">{{ $authError }}</span>
                            @endif

                        <!--email-->
                        <div class="form-group mb-2" wire:ignore>
                            <label for="email" class="form-label"> @lang('Email') </label>
                            <input type="email" wire:model="email" class="form-control" dir="rtl" placeholder="@lang('Email')" />
                            @error('email')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- btn-->
                        <div class="form-group mb-3 mt-3">
                            <button type="button" id="btnSend" class="btn btn-primary w-100  btn-send submit_form" value="register" @if ($otp_modal) disabled @endif>
                                @lang('Create New Account')
                            </button>
                        </div>

                        @if ($showDescription1)
                        <p>
                            <span> @lang('Do you have account') </span>
                            <a href="{{ route('site.login') }}"> @lang('Login') </a>
                        </p>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>


    {{-- Modal OTP  --}}
    <div class="modal fade @if ($otp_modal ?? false) show @endif" @if ($otp_modal ?? false) style="display: block;" @endif id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                            <button class="btn btn-success auth-btn mt-1" type="button" wire:click="checkOTP()">@lang('Send')
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


    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
    <script>
        var phoneInputField = document.querySelector("#mobile");
        var phoneInputField = window.intlTelInput(phoneInputField, {
            preferredCountries: ['sa', 'ae', 'kw', 'qa', 'bh', 'om']
            , separateDialCode: true
            , utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js"
            , initialCountry: "sa"
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


        $(document).ready(function() {
            $(window).keydown(function(event) {
                if (event.keyCode == 13) {
                    event.preventDefault();
                    return false;
                }
            });
            $(".submit_form").on("click", function(e) {
                $("#notification-register").html("");
                var full_number = phoneInputField.getNumber(intlTelInputUtils.numberFormat.E164);
                var isValid = phoneInputField.isValidNumber();
                $("#countryData").val(full_number);

                if (isValid) {
                    Livewire.emit('register', full_number);
                } else {
                    var msg = "رقم الجوال المدخل غير صحيح";
                    $("#notification-register").html(msg);
                }
            });
        });

    </script>

</div>
