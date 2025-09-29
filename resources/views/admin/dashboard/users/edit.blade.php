@extends('admin.app')

@section('title', trans('users.edit_user'))
@section('title_page', trans('admin.users'))
@section('title_route', route('admin.users.index') )
@section('button_page')
    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-primary waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
@endsection

@section('style')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
<style>
    .iti { 
        width: 100%; 
        direction: ltr;
    }
    .iti--allow-dropdown .iti__flag-container {
        background-color: #f8f9fa;
        border-right: 1px solid #ced4da;
    }
    .iti__country-list {
        width: 120px !important;
        max-width: 120px !important;
        min-width: 120px !important;
    }
    .iti__country-name {
        display: none !important;
        visibility: hidden !important;
    }
    .iti__country .iti__country-name {
        display: none !important;
    }
    .iti__country {
        padding: 8px 12px;
        display: flex;
        align-items: center;
        justify-content: flex-start;
    }
    .iti__dial-code {
        margin-left: 8px;
        font-weight: 600;
        color: #495057;
        font-size: 14px;
    }
    .iti__flag {
        margin-right: 8px;
        flex-shrink: 0;
    }
    .iti__country span:not(.iti__dial-code):not(.iti__flag) {
        display: none !important;
    }
    .iti__selected-flag {
        background-color: #f8f9fa;
        border-right: 1px solid #ced4da;
        padding: 0 8px;
        min-width: 52px;
    }
    .iti__selected-flag:hover {
        background-color: #e9ecef;
    }
    .iti__arrow {
        border-left-color: #6c757d;
    }
    .iti__selected-dial-code {
        color: #495057;
        font-weight: 600;
        margin-left: 6px;
        font-size: 14px;
    }
    .iti__flag {
        margin-right: 0;
        flex-shrink: 0;
    }
    .input-icon { 
        position: relative; 
        width: 100%;
    }
    .input-icon .form-control { 
        padding-right: 40px !important;
        padding-left: 15px !important;
        width: 100%;
    }
    .input-icon .icon-eye { 
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        z-index: 2;
        cursor: pointer;
        pointer-events: auto;
    }
    .input-icon .icon-eye i {
        font-size: 1rem;
        color: #6c757d;
    }
    .input-icon .icon-eye:hover i {
        color: #495057;
    }
    .password-requirements { 
        margin-top: 10px; 
        font-size: 0.875rem;
    }
    .password-requirements li { 
        color: #dc3545;
        margin-bottom: 4px;
        transition: all 0.3s ease;
    }
    .password-requirements li.valid { 
        color: #198754;
    }
    .password-requirements li i {
        display: inline-block;
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background-color: #dc3545;
        margin-right: 6px;
        position: relative;
        top: -1px;
    }
    /* تحسينات إضافية للتصميم */
    .iti input {
        border: 1px solid #ced4da;
        border-radius: 0.375rem;
        padding: 0.375rem 0.75rem;
        padding-left: 52px;
    }
    .iti input:focus {
        border-color: #86b7fe;
        outline: 0;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
    }
    .phone-validation {
        margin-top: 5px;
        font-size: 0.875rem;
    }
    .phone-validation.valid {
        color: #198754;
    }
    .phone-validation.invalid {
        color: #dc3545;
    }
    #password, #password_confirmation {
        padding-right: 40px !important;
        padding-left: 15px !important;
        cursor: text;
    }
</style>
@endsection

@section('content')
    <div class="row">
        <div class="card">
            <form action="{{ route('admin.users.update', $user->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" value="{{ $user->id }}">
                <input type="hidden" name="full_mobile" id="full_mobile" value="">
                
                <div class="row d-flex justify-content-center">
                    <div class="col-md-6">
                        <div class="accordion mt-4 mb-4" id="accordionExamUser">
                            <div class="accordion-item border rounded">
                                <h2 class="accordion-header" id="headingUser">
                                    <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseUser" aria-expanded="true" aria-controls="collapseUser">
                                        <span class=" text-success "> {{ $user->user_name }}</span>
                                    </button>
                                </h2>
                                <div id="collapseUser" class="accordion-collapse collapse show mt-3" aria-labelledby="headingUser" data-bs-parent="#accordionExamUser">
                                    <div class="accordion-body">

                                        <div class="row mb-3">
                                            <label for="example-text-input" class="col-sm-2 col-form-label">{{ trans('users.user_name') }}</label>
                                            <div class="col-sm-10">
                                                <div class="position-relative input-icon">
                                                    <input class="form-control @error('user_name') is-invalid @enderror" type="text" name="user_name" value="{{ $user->user_name }}" required>
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
                                                    <input class="form-control @error('email') is-invalid @enderror" type="email" value="{{ $user->email }}" name="email" required>
                                                    <span class="position-absolute top-50 translate-middle-y"><i class='bx bx-envelope'></i></span>
                                                </div>
                                                @error('email')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <div class="row mb-3">
                                            <label for="phone" class="col-sm-2 col-form-label">{{ trans('users.mobile') }}</label>
                                            <div class="col-sm-10">
                                                <div class="form-outline">
                                                    <input type="tel" 
                                                           id="phone" 
                                                           name="mobile" 
                                                           class="form-control @error('mobile') is-invalid @enderror" 
                                                           value="{{ $user->mobile }}" 
                                                           required 
                                                           placeholder="أدخل رقم الهاتف"
                                                           oninput="this.value = this.value.replace(/[^0-9]/g, '');" 
                                                           maxlength="15"/>
                                                    <div id="phone-validation" class="phone-validation"></div>
                                                </div>
                                                @error('mobile')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <div class="row mb-3">
                                            <label for="example-password-input" class="col-sm-2 col-form-label">@lang('admin.password')</label>
                                            <div class="col-sm-10">
                                                <div class="position-relative input-icon">
                                                    <input class="form-control" type="password" name="password" id="password" oninput="checkPasswordRequirements()">
                                                    <span class="position-absolute top-50 translate-middle-y icon-eye" style="right: 10px;" id="toggle-password" onclick="togglePassword('password', 'toggle-password')">
                                                        <i class="fas fa-eye"></i>
                                                    </span>
                                                </div>
                                                <!-- شروط كلمة المرور -->
                                                <div class="password-requirements mt-2" id="password-requirements">
                                                    <ul class="list-unstyled mb-0">
                                                        <li id="length-req"><i></i> يجب أن تحتوي على 8 أحرف على الأقل</li>
                                                        <li id="uppercase-req"><i></i> يجب أن تحتوي على حرف كبير</li>
                                                        <li id="lowercase-req"><i></i> يجب أن تحتوي على حرف صغير</li>
                                                        <li id="number-req"><i></i> يجب أن تحتوي على رقم</li>
                                                        <li id="special-req"><i></i> يجب أن تحتوي على رمز خاص (!@#$%^&*)</li>
                                                    </ul>
                                                </div>
                                                @error('password')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <div class="row mb-3">
                                            <label for="example-password-input" class="col-sm-2 col-form-label">@lang('admin.confirm_password')</label>
                                            <div class="col-sm-10">
                                                <div class="position-relative input-icon">
                                                    <input class="form-control" type="password" name="password_confirmation" id="password_confirmation">
                                                    <span class="position-absolute top-50 translate-middle-y icon-eye" style="right: 10px;" id="toggle-password-confirm" onclick="togglePassword('password_confirmation', 'toggle-password-confirm')">
                                                        <i class="fas fa-eye"></i>
                                                    </span>
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
                        <div class="accordion mt-4 mb-4" id="accordionExample">
                            <div class="accordion-item border rounded">
                                <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button fw-medium " type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        {{ trans('admin.settings') }}
                                    </button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <div class="col-sm-3 mb-3">
                                            <img src="{{ getImageThumb($user->image) }}" alt="" style="width:100%">
                                        </div>
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
                                                        <option {{ $user->roles->pluck('name')->contains($role->name) ? 'selected' : '' }} value="{{ $role->name }}">
                                                            {{ $role->name }}</option>
                                                        @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        {{-- Status ------------------------------------------------------------------------------------- --}}
                                        <div class="col-12 mt-3">
                                            <div class="form-check form-switch form-check-success">
                                                <label class="form-check-label" for="flexSwitchCheckSuccessStatus">@lang('admin.status')</label>
                                                <input class="form-check-input" type="checkbox" role="switch" name="status"  {{  @$user->status == 1 ? 'checked' : '' }} id="flexSwitchCheckSuccessStatus">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>                                                            
                    </div>
                    
                    <div class="row mb-3 text-end">
                        <div>
                            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-primary waves-effect waves-light  btn-sm">@lang('button.cancel')</a>
                            <button type="submit" class="btn btn-outline-success waves-effect waves-light  btn-sm">@lang('button.save')</button>
                            <button type="submit" name="submit" value="update" class="btn btn-outline-success waves-effect waves-light  btn-sm">@lang('button.save_update')</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // تهيئة intl-tel-input
    const phoneInput = document.querySelector("#phone");
    const iti = window.intlTelInput(phoneInput, {
        allowDropdown: true,
        autoHideDialCode: false, 
        autoPlaceholder: "aggressive",
        dropdownContainer: document.body,
        excludeCountries: [],
        formatOnDisplay: true,
        geoIpLookup: function(callback) {
            fetch('https://ipapi.co/json/')
                .then(function(res) { return res.json(); })
                .then(function(data) { 
                    console.log('Detected country:', data.country_code);
                    callback(data.country_code); 
                })
                .catch(function() { 
                    console.log('IP lookup failed, using Egypt as default');
                    callback('eg'); 
                });
        },
        hiddenInput: "full_number",
        initialCountry: "auto",
        localizedCountries: {},
        nationalMode: false,
        onlyCountries: [],
        placeholderNumberType: "MOBILE",
        preferredCountries: ['eg', 'sa', 'ae', 'kw', 'qa', 'bh', 'om'],
        separateDialCode: true,
        utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
    });

    function validatePhone() {
        const phoneValidation = document.getElementById('phone-validation');
        
        if (phoneInput.value.trim()) {
            if (iti.isValidNumber()) {
                phoneValidation.textContent = 'رقم الهاتف صحيح ✓';
                phoneValidation.className = 'phone-validation valid';
                phoneInput.classList.remove('is-invalid');
                phoneInput.classList.add('is-valid');
                
                document.getElementById('full_mobile').value = iti.getNumber();
                
                return true;
            } else {
                phoneValidation.textContent = 'رقم الهاتف غير صحيح ✗';
                phoneValidation.className = 'phone-validation invalid';
                phoneInput.classList.remove('is-valid');
                phoneInput.classList.add('is-invalid');
                
                return false;
            }
        } else {
            phoneValidation.textContent = '';
            phoneValidation.className = 'phone-validation';
            phoneInput.classList.remove('is-valid', 'is-invalid');
            
            return true; 
        }
    }

    phoneInput.addEventListener('input', validatePhone);
    phoneInput.addEventListener('keyup', validatePhone);
    phoneInput.addEventListener('change', validatePhone);
    phoneInput.addEventListener('countrychange', function() {
        validatePhone();
        document.getElementById('full_mobile').value = iti.getNumber();
    });

    if (phoneInput.value) {
        const currentNumber = phoneInput.value;
        if (currentNumber.startsWith('+')) {
            iti.setNumber(currentNumber);
        } else {
            iti.setNumber('+20' + currentNumber);
        }
        validatePhone();
    }

    const form = phoneInput.closest('form');
    form.addEventListener('submit', function(e) {
        if (phoneInput.value && !iti.isValidNumber()) {
            e.preventDefault();
            alert('يرجى إدخال رقم هاتف صحيح');
            phoneInput.focus();
            return false;
        }
        
        if (phoneInput.value) {
            document.getElementById('full_mobile').value = iti.getNumber();
        }
    });
});

function togglePassword(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon = document.querySelector('#' + iconId + ' i');
    
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}

function checkPasswordRequirements() {
    const password = document.getElementById('password').value;
    
    const lengthReq = document.getElementById('length-req');
    if (password.length >= 8) {
        lengthReq.classList.add('valid');
    } else {
        lengthReq.classList.remove('valid');
    }
    
    const uppercaseReq = document.getElementById('uppercase-req');
    if (/[A-Z]/.test(password)) {
        uppercaseReq.classList.add('valid');
    } else {
        uppercaseReq.classList.remove('valid');
    }
    
    const lowercaseReq = document.getElementById('lowercase-req');
    if (/[a-z]/.test(password)) {
        lowercaseReq.classList.add('valid');
    } else {
        lowercaseReq.classList.remove('valid');
    }
    
    const numberReq = document.getElementById('number-req');
    if (/[0-9]/.test(password)) {
        numberReq.classList.add('valid');
    } else {
        numberReq.classList.remove('valid');
    }
    
    const specialReq = document.getElementById('special-req');
    if (/[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(password)) {
        specialReq.classList.add('valid');
    } else {
        specialReq.classList.remove('valid');
    }
}

</script>
@endsection