<div>
    <div class="bank payment-content">
        <p> @lang('Pay From Bank Transfer') </p>
        <form wire:submit.prevent="checkout" class="">
            @include('livewire.site.payments.message')
            <div class="payment-fields bank-fields">
                <div class="form-group bank-form">
                    <label for="bank-name"> @lang('Bank name') </label>
                    <select wire:model="bank_id" class="bank-input" id="bank-name">
                        <option value="" selected disabled></option>
                        @forelse (@$bank_accounts as $account)
                        <option value="{{ $account->id }}"> {{ $account->bank_name }} </option>
                        @empty
                        @endforelse
                    </select>
                    @error('bank_id')
                    <span class="text-danger col-12">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group bank-form">
                    <label for="account-owner"> @lang('Account Holder Name') </label>
                    <input class="bank-input" disabled wire:model="bankHoldName" type="text" id="account-owner">
                </div>
                <div class="form-group bank-form">
                    <label for="account-number"> @lang('Account number') </label>
                    <input class="bank-input" disabled type="text" wire:model="account_type" id="account-number">
                </div>
                <div class="form-group bank-form">
                    <label for="iban-number"> @lang('IBAN') </label>
                    <input class="bank-input" disabled type="text" id="iban-number" wire:model="iban">
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
                <button type="submit" class="pay-btn"><i class="fa fa-check"></i> الدفع</button>
                <a type="button" href="{{ route('site.home') }}" class="cancel-btn"><i class="fa fa-times"></i></a>
            </div>
        </form>
    </div>
</div>
