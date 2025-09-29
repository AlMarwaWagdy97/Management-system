@extends('admin.app')

@section('title', trans('users.create_user'))
@section('title_page', trans('admin.users'))
@section('title_route', route('admin.users.index') )
@section('button_page')
    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-primary waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
@endsection

@section('style')
    <link rel="stylesheet" href="{{ asset('tell/intlTelInput.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <style>
        .iti { width: 100%; }
        .iti-mobile .iti__country-list { width: 90%; }
        .iti__country-name { display: none; }
        .input-icon { position: relative; }
        .input-icon .form-control { padding-right: 2.5rem; }
        .input-icon .icon-eye { right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer; color: #888; }
        .password-requirements { margin-top: 10px; }
        .password-requirements li { color: red; }
        .password-requirements li.valid { color: green; }
    </style>
@endsection

@section('content')

<div class="row">
    <div class="card">
        <form action="{{ route('admin.users.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row d-flex justify-content-center ">
                <div class="col-md-6">

                    <div class="accordion mt-4 mb-4 " id="accordionExamUser">
                        <div class="accordion-item border rounded ">
                            <h2 class="accordion-header" id="headingUser">
                                <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseUser" aria-expanded="true" aria-controls="collapseOne1">
                                    {{ trans('users.create_user') }}
                                </button>
                            </h2>
                            <div id="collapseUser" class="accordion-collapse collapse show mt-3" aria-labelledby="headingUser" data-bs-parent="#accordionExamUser">
                                <div class="accordion-body">

                                    <div class="row mb-3">
                                        <label for="example-text-input" class="col-sm-2 col-form-label">{{ trans('users.user_name') }}</label>
                                        <div class="col-sm-10">
                                            <div class="position-relative input-icon">
                                                <input class="form-control @error('user_name') is-invalid @enderror" type="text" name="user_name" value="{{ old('user_name') }}" required>
                                                <span class="position-absolute top-50 translate-middle-y"><i class='bx bx-user'></i></span>
                                            </div>
                                            @error('user_name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="example-email-input" class="col-sm-2 col-form-label">{{ trans('users.email') }}</label>
                                        <div class="col-sm-10">
                                            <div class="position-relative input-icon">
                                                <input class="form-control @error('email') is-invalid @enderror" type="email" value="{{ old('email') }}" name="email" required>
                                                <span class="position-absolute top-50 translate-middle-y"><i class='bx bx-envelope'></i></span>
                                            </div>
                                            @error('email')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="example-tel-input" class="col-sm-2 col-form-label">{{ trans('users.mobile') }}</label>
                                        <div class="col-sm-10">
                                            <div class="form-outline">
                                                <div class="input-group">
                                                    <input type="tel" id="mobile" name="mobile" class="form-control @error('mobile') is-invalid @enderror" value="{{ old('mobile') }}" style="direction: ltr" />
                                                    <input id="countryData" name="mobileWithCode" type="hidden" />
                                                </div>
                                                <span class="text-danger" id="notification-mobile"></span>
                                                @error('mobile')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="example-password-input" class="col-sm-2 col-form-label">@lang('admin.password')</label>
                                        <div class="col-sm-10">
                                            <div class="position-relative input-icon">
                                                <input class="form-control @error('password') is-invalid @enderror" type="password" name="password" required id="psw" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*]).{8,}">
                                                <span class="position-absolute icon-eye" onclick="togglePassword('psw', 'psw-eye')"><i id="psw-eye" class="fa fa-eye"></i></span>
                                            </div>
                                            @error('password')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                            <ul class="password-requirements">
                                                <li id="length">يجب أن تحتوي على 8 أحرف على الأقل</li>
                                                <li id="uppercase">يجب أن تحتوي على حرف كبير</li>
                                                <li id="lowercase">يجب أن تحتوي على حرف صغير</li>
                                                <li id="number">يجب أن تحتوي على رقم</li>
                                                <li id="special">يجب أن تحتوي على رمز خاص (!@#$%^&*)</li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="example-password-input" class="col-sm-2 col-form-label">@lang('admin.confirm_password')</label>
                                        <div class="col-sm-10">
                                            <div class="position-relative input-icon">
                                                <input class="form-control @error('password_confirmation') is-invalid @enderror" type="password" name="password_confirmation" required id="confirm_psw">
                                                <span class="position-absolute icon-eye" onclick="togglePassword('confirm_psw', 'confirm-psw-eye')"><i id="confirm-psw-eye" class="fa fa-eye"></i></span>
                                            </div>
                                            @error('password_confirmation')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="col-md-5">
                    <div class="accordion mt-4 mb-4" id="accordionExampleSetting">
                        <div class="accordion-item border rounded">
                            <h2 class="accordion-header" id="headingSetting">
                                <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSetting" aria-expanded="true" aria-controls="collapseOne">
                                    {{ trans('admin.settings') }}
                                </button>
                            </h2>
                            <div id="collapseSetting" class="accordion-collapse collapse show" aria-labelledby="headingSetting" data-bs-parent="#accordionExampleSetting">
                                <div class="accordion-body">

                                    {{-- image ------------------------------------------------------------------------------------- --}}
                                    <div class="col-12">
                                        <div class="row mb-3">
                                            <label for="example-number-input" col-form-label>
                                                @lang('admin.image')</label>
                                            <div class="col-sm-12">
                                                <input class="form-control" type="file" placeholder="@lang('admin.image')" id="example-number-input" name="image" value="{{ old('image') }}">
                                            </div>
                                        </div>
                                    </div>

                                    {{-- role ------------------------------------------------------------------------------------- --}}
                                    <div class="col-md-12">
                                        <label for="input30" class="form-label">Role</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bx-flag"></i></span>
                                            <select class="form-select" id="input30" multiple="" name="roles[]" required>
                                                @foreach ($roles as $role)
                                                <option {{ $role->name == request('role') ? 'selected' : '' }} value="{{ $role->name }}">
                                                    {{ $role->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    {{-- Status ------------------------------------------------------------------------------------- --}}
                                    <div class="col-12 mt-3">
                                        <div class="form-check form-switch form-check-success">
                                            <label class="form-check-label" for="flexSwitchCheckSuccessStatus">@lang('admin.status')</label>
                                            <input class="form-check-input" type="checkbox" role="switch" name="status"  {{  request('status') == 1 ? 'checked' : '' }} id="flexSwitchCheckSuccessStatus">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>                                                            
                </div>
                <div class="row mb-3 text-end ">
                    <div>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-primary waves-effect waves-light btn-sm">@lang('button.cancel')</a>
                        <button type="submit" id="submit" class="btn btn-outline-success waves-effect waves-light btn-sm">@lang('button.save')</button>
                        <button type="submit" name="submit" value="new" id="submit" class="btn btn-outline-success waves-effect waves-light btn-sm">@lang('button.save_new')</button>
                    </div>
                </div>

            </div>
        </form>
    </div>
</div>

@endsection

@section('script')
    <!-- Add required JS libraries -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
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

            $("#psw").on("input", function() {
                var password = $(this).val();
                
                // Check length (at least 8 characters)
                if (password.length >= 8) {
                    $("#length").addClass("valid");
                } else {
                    $("#length").removeClass("valid");
                }
                
                // Check uppercase
                if (/[A-Z]/.test(password)) {
                    $("#uppercase").addClass("valid");
                } else {
                    $("#uppercase").removeClass("valid");
                }
                
                // Check lowercase
                if (/[a-z]/.test(password)) {
                    $("#lowercase").addClass("valid");
                } else {
                    $("#lowercase").removeClass("valid");
                }
                
                // Check number
                if (/[0-9]/.test(password)) {
                    $("#number").addClass("valid");
                } else {
                    $("#number").removeClass("valid");
                }
                
                // Check special character
                if (/[!@#$%^&*]/.test(password)) {
                    $("#special").addClass("valid");
                } else {
                    $("#special").removeClass("valid");
                }
            });
        });

        function togglePassword(inputId, eyeId) {
            var input = document.getElementById(inputId);
            var icon = document.getElementById(eyeId);
            if (input.type === "password") {
                input.type = "text";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            } else {
                input.type = "password";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            }
        }
    </script>
    
    <script src="{{ asset('tell/intlTelInput.js') }}"></script>
@endsection