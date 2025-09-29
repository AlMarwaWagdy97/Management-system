<div>
    <form wire:submit.prevent="updateProfile">
        @csrf
        <!-- Personal Info Section (Hidden) -->
        <div class="profile-content" id="personal-info-content">
            <!-- Profile Header -->
            <div class="profile-header mb-4">
                <h2 class="section-title"> @lang('personal account information') </h2>
            </div>

            <div class="profile-info-card card p-3">
                <div class="profile-info-item">
                    <div class="row align-items-center">
                        <div class="col-md-4 profile-info-label">@lang('Name') </div>
                        <input type="text" class="border-0 py-2 col-md-8 profile-info-value  @error('full_name') is-invalid @enderror" wire:model="full_name" value="{{ $donor->full_name }}"  placeholder="عمرو ××××××××××××× " />
                        @error('full_name')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="profile-info-item">
                    <div class="row align-items-center">
                        <div class="col-md-4 profile-info-label"> @lang('Mobile') </div>
                        <input type="text" class="border-0 py-2 col-md-8 profile-info-value @error('mobile') is-invalid @enderror" wire:model="mobile" value="{{ $donor->account->mobile }}" placeholder="5xxxxxxxx" oninput="this.value = this.value.replace(/[^0-9]/g, '');" maxlength="9" />
                        @error('mobile')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="profile-info-item">
                    <div class="row align-items-center">
                        <div class="col-md-4 profile-info-label">
                            @lang('Email')
                        </div>
                        <input type="text" class="border-0 py-2 col-md-8 profile-info-value col-10 @error('email') is-invalid @enderror" wire:model="email" value="{{ $donor->account->email }}" placeholder="gmail@.com××××××××××" />
                        @error('email')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="profile-actions mt-4 text-center">
                    <button type="submit" class="btn bg-info edit-profile-btn"> @lang('Save') </button>
                </div>
            </div>
        </div>

        <div class="modal fade @if($otp_modal)show @endif" @if($otp_modal)style="display: block;"@endif  id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                            <button class="btn button-primary btn-sm p-2" type="button"  wire:click="checkOTP()">@lang('Send') </button>
                        </div>
                        @if($otpError)
                            <h5 class="success-message text-danger mt-3">
                                <span class="message"> {{ $otpError }} </span>
                            </h5>
                        @endif
                        
                    </div>
                </div>
            </div>
            </div>
        </div>
    </form>
</div>
