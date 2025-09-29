<div class="payment-fields bank-fields mt-5">
    <div class="label bank-text">
        <p> @lang('Pay From Bank Transfer') </p>
    </div>
    <form wire:submit.prevent="checkout" class="">
        @include('livewire.site.payments.message')
        <div class="bank payment-content">
            <div class="payment-fields bank-fields">
                <div class="form-group bank-form">
                    <label for="bank-name"> @lang('Bank name')</label>
                    <select class="bank-input" id="bank-name" wire:model="bank_id">
                        <option value="" selected disabled></option>
                        @forelse (@$bank_accounts as $account)
                        <option value="{{ $account->id }}" selected=""> {{ $account->bank_name }} </option>
                        @empty
                        @endforelse
                    </select>
                    @error('bank_id')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group bank-form">
                    <label for="account-owner"> @lang('Account Holder Name') </label>
                    <input class="bank-input" wire:model="bankHoldName" type="text" id="account-owner">
                </div>
                <div class="form-group bank-form">
                    <label for="account-number"> @lang('Account number')</label>
                    <input class="bank-input" type="text" id="account-number" wire:model="account_type">
                </div>
                <div class="form-group bank-form">
                    <label for="iban-number">رقم الايبان</label>
                    <input class="bank-input" type="text" id="iban-number" wire:model="iban">
                </div>
                <div class="form-group bank-form">
                    <input wire:model="image" type="file" class="pay-btn d-none" id="fileInput"  x-ref="fileInput" @change="fileName = $refs.fileInput.files[0]?.name || ''" >

                    <label for="fileInput" type="button" x-text="fileName" class="pay-btn attach-btn" style="background: #22B573; min-width: 180px;">
                        ارفاق إيصال الدفع
                        <span style="font-size: 0.9rem; margin-right: 8px; color: #333;">Pdf - jpeg - png</span>
                        <i class="fa fa-paperclip"></i>
                    </label>
                    @error('image')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

            </div>
            <div class="cart-form-actions">
                <p class="proceed-text">
                    اتمام الدفع
                </p>
                <button type="submit" class="pay-btn" @if(@auth('account')->user()?->types->where('type', 'donor')->first() == null) disabled @endif><i class="fa fa-check"></i> @lang('Pay') </button>
                <a href="{{ route('site.home') }}" type="button" class="cancel-btn"><i class="fa fa-times"></i></a>
            </div>
        </div>
    </form>
</div>
