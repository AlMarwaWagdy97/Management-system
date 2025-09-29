<div>
    <div class="row mb-3">
        @if($msg)
            <div class="mb-3 text-center">
                <span class="text-danger my-2 text-center"> {{ $msg }} </span>
            </div>
        @endif
        <label for="example-text-input" class="col-sm-3 col-form-label">{{ trans('admin.users') }}</label>
        <div class="col-sm-9">
            <input class="form-control" wire:model='search_accounts' wire:keydown.escape="reseting()" type="text">
            @error('name')
            <span class="text-danger">{{ $message }}</span>
            @enderror
            <ul class="list-group list-group-numbered">
                @if($accounts)
                @forelse ($accounts as $account)
                <li class="list-group-item d-flex justify-content-between align-items-start bg" wire:click="selectAccount({{ $account }})">
                    <div class="text-start col-10"> ({{ $account->email }}) {{ $account->user_name }}  </div>
                    <span class="badge bg-primary rounded-pill"> @lang('Add') </span>
                </li>
                @empty
                <li class="list-group-item d-flex justify-content-between align-items-start bg-sucess-light" wire:click="newAccount()">
                    <div class="text-start col-10"> @lang('New Account') </div>
                </li>
                @endforelse
                @endif
            </ul>
        </div>

    </div>

    @if ($new)
        <div class="row">
            <!-- Name input -->
            <div class="col-12 col-md-6">
                <div class="form-outline">
                    <label class="form-label" for="form8Example1">@lang('users.name')</label>
                    <input type="text" id="form8Example1" class="form-control @error('user_name') is-invalid @enderror" value="{{ old('user_name') }}" name="user_name" />
                </div>
            </div>
            <!-- phone input -->
            <!-- Add required CSS and JS libraries -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
<style>
    .iti { width: 100%; }
    .iti-mobile .iti__country-list { width: 90%; }
    .iti__country-name { display: none; }
    .iti__flag-container {
        left: 10px !important;
        right: auto !important;
    }
    .iti__selected-flag {
        left: 0 !important;
        right: auto !important;
    }
    .iti__country-list {
        left: 0 !important;
        right: auto !important;
    }
    .iti input {
        padding-left: 70px !important;
        padding-right: 12px !important;
        text-align: left !important;
        direction: ltr !important;
    }
    .iti__selected-flag {
        position: absolute !important;
        top: 0 !important;
        bottom: 0 !important;
        left: 0 !important;
        right: auto !important;
        width: 60px !important;
        height: 100% !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        border-right: 1px solid #ced4da !important;
    }
    .password-container {
        position: relative;
    }
    .password-eye {
        position: absolute;
        left: 10px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
        z-index: 10;
        color: #888;
    }
    .password-eye:hover {
        color: #495057;
    }
    .password-requirements {
        margin-top: 5px;
        font-size: 14px;
    }
    .requirement {
        display: block;
        margin: 2px 0;
        transition: color 0.3s ease;
    }
    .requirement.valid {
        color: #28a745;
    }
    .requirement.invalid {
        color: #dc3545;
    }
</style>

<div class="col-12 col-md-6">
    <div class="form-outline">
        <label class="form-label" for="form8Example3">@lang('users.mobile')</label>
        <div class="input-group" wire:ignore>
            <input type="tel" id="mobile" name="mobile" class="form-control @error('mobile') is-invalid @enderror" value="{{ old('mobile') }}" style="direction: ltr" />
            <input id="countryData" name="mobileWithCode" type="hidden" />
        </div>
        <span class="text-danger" id="notification-mobile"></span>
    </div>
</div>

<!-- International Tel Input Script -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
<script>
    var phoneInputField = document.querySelector("#mobile");
    var phoneInput = window.intlTelInput(phoneInputField, {
        preferredCountries: ['sa', 'ae', 'kw', 'qa', 'bh', 'om'],
        separateDialCode: true,
        utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
        initialCountry: "auto",
        geoIpLookup: function(success, failure) {
            fetch("https://ipapi.co/json")
                .then(function(res) { return res.json(); })
                .then(function(data) { success(data.country_code); })
                .catch(function() { failure(); });
        }
    });

    $(document).ready(function() {
        $("#mobile").on("input", function() {
            var full_number = phoneInput.getNumber(intlTelInputUtils.numberFormat.E164);
            var isValid = phoneInput.isValidNumber();
            
            $("#countryData").val(full_number);
            
            if (!isValid) {
                $("#notification-mobile").html("رقم الجوال المدخل غير صحيح");
            } else {
                $("#notification-mobile").html("");
            }
        });
    });
</script>
            </div>
            <!-- Email input -->
            <div class="col-12 col-md-6">
                <div class="form-outline">
                    <label class="form-label" for="form8Example2">@lang('users.email')
                    </label>
                    <input type="email" id="form8Example2" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" name="email" />
                </div>
            </div>
            <!-- password input -->
            @if($show_password)
            <div class="col-12 col-md-6">
                <div class="form-outline">
                    <label class="form-label" for="form8Example5">@lang('users.password')</label>
                    <div class="password-container">
                        <span class="password-eye" onclick="togglePasswordVisibility('form8Example5')">
                            <i id="password-eye-icon" class="fa fa-eye"></i>
                        </span>
                        <input type="password" id="form8Example5" name="password" class="form-control @error('password') is-invalid @enderror" value="{{ old('password') }}" oninput="validatePassword(this.value)" style="padding-left: 35px;" />
                    </div>
                    <div class="password-requirements" id="password-requirements">
                        <span class="requirement invalid" id="length-req">• يجب أن تحتوي على 8 أحرف على الأقل</span>
                        <span class="requirement invalid" id="uppercase-req">• يجب أن تحتوي على حرف كبير</span>
                        <span class="requirement invalid" id="lowercase-req">• يجب أن تحتوي على حرف صغير</span>
                        <span class="requirement invalid" id="number-req">• يجب أن تحتوي على رقم</span>
                        <span class="requirement invalid" id="special-req">• يجب أن تحتوي على رمز خاص (!@#$%^&*)</span>
                    </div>
                </div>
            </div>
            @endif
        </div>
    @else
    @if($user)
    <div class="row">
        <input type="hidden" name="account_id" value="{{ $user['id'] }}">
        <!-- phone input -->
        <div class="col-12 col-md-6">
            <div class="form-outline">
                <label class="form-label" for="form8Example3">@lang('users.mobile')</label>
                <input type="tel" name="mobile" disabled class="form-control @error('mobile') is-invalid @enderror " value="{{ $user['mobile'] }}" style="border:none" />
            </div>
        </div>
        <!-- Name input -->
        <div class="col-12 col-md-6">
            <div class="form-outline">
                <label class="form-label" for="form8Example1">@lang('users.name')</label>
                <input type="text" id="form8Example1" class="form-control @error('user_name') is-invalid @enderror" value="{{ $user['user_name'] }}" name="user_name" />
            </div>
        </div>
        <!-- Email input -->
        <div class="col-12 col-md-6">
            <div class="form-outline">
                <label class="form-label" for="form8Example2">@lang('users.email')
                </label>
                <input type="email" id="form8Example2" class="form-control @error('email') is-invalid @enderror" value="{{ $user['email'] }}" name="email" />
            </div>
        </div>

        <!-- password input -->
        @if($show_password)
        <div class="col-12 col-md-6">
            <div class="form-outline">
                <label class="form-label" for="form8Example5">@lang('users.password')</label>
                <div class="password-container">
                    <span class="password-eye" onclick="togglePasswordVisibility('form8Example5')">
                        <i id="password-eye-icon" class="fa fa-eye"></i>
                    </span>
                    <input type="password" id="form8Example5" name="password" class="form-control @error('password') is-invalid @enderror" value="" oninput="validatePassword(this.value)" style="padding-left: 35px;" />
                </div>
                <div class="password-requirements" id="password-requirements">
                    <span class="requirement invalid" id="length-req">• يجب أن تحتوي على 8 أحرف على الأقل</span>
                    <span class="requirement invalid" id="uppercase-req">• يجب أن تحتوي على حرف كبير</span>
                    <span class="requirement invalid" id="lowercase-req">• يجب أن تحتوي على حرف صغير</span>
                    <span class="requirement invalid" id="number-req">• يجب أن تحتوي على رقم</span>
                    <span class="requirement invalid" id="special-req">• يجب أن تحتوي على رمز خاص (!@#$%^&*)</span>
                </div>
            </div>
        </div>
        @endif
    </div>
    @endif
    @endif
    <script src="{{ asset('tell/intlTelInput.js') }}"></script>

    <script>
        function togglePasswordVisibility(inputId) {
            const passwordInput = document.getElementById(inputId);
            const icon = document.getElementById('password-eye-icon');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        function validatePassword(password) {
            // Length validation
            const lengthReq = document.getElementById('length-req');
            if (password.length >= 8) {
                lengthReq.classList.remove('invalid');
                lengthReq.classList.add('valid');
            } else {
                lengthReq.classList.remove('valid');
                lengthReq.classList.add('invalid');
            }

            // Uppercase validation
            const uppercaseReq = document.getElementById('uppercase-req');
            if (/[A-Z]/.test(password)) {
                uppercaseReq.classList.remove('invalid');
                uppercaseReq.classList.add('valid');
            } else {
                uppercaseReq.classList.remove('valid');
                uppercaseReq.classList.add('invalid');
            }

            // Lowercase validation
            const lowercaseReq = document.getElementById('lowercase-req');
            if (/[a-z]/.test(password)) {
                lowercaseReq.classList.remove('invalid');
                lowercaseReq.classList.add('valid');
            } else {
                lowercaseReq.classList.remove('valid');
                lowercaseReq.classList.add('invalid');
            }

            // Number validation
            const numberReq = document.getElementById('number-req');
            if (/[0-9]/.test(password)) {
                numberReq.classList.remove('invalid');
                numberReq.classList.add('valid');
            } else {
                numberReq.classList.remove('valid');
                numberReq.classList.add('invalid');
            }

            // Special char          acter validation
            const specialReq = document.getElementById('special-req');
            if (/[!@#$%^&*(),.?":{}|<>]/.test(password)) {
                specialReq.classList.remove('invalid');
                specialReq.classList.add('valid');
            } else {
                specialReq.classList.remove('valid');
                specialReq.classList.add('invalid');
            }
        }
    </script>

</div>