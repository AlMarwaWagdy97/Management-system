<div>

    <div class="visa payment-content">

        <div class="label bank-text">
            <p> @lang('Pay From Visa') </p>
        </div>
        <form wire:submit.prevent="checkout" class="">
            @include('livewire.site.payments.message')

            @if(count($myCards))
            <div class="payment-card payment-white p-1" id="paymentByCard" style="">

                @forelse ($myCards as $myCard)
                <div class="row selected_saved_card my-2">
                    <div class="col-md-3">
                        <div class="selected_cvv {{ $selected_card == $myCard->id ? 'd-block' : 'd-none'}}">
                            <input type="text" wire:model="selected_cvv" placeholder="CVV" maxlength="3" inputmode="numeric" pattern="[0-9]*" class="form-control only-number card-exp valid">
                        </div>
                    </div>
                    <div class="col-md-9 text-start">
                        <label class="checkcontainer">
                            <span>({{ base64_decode($myCard->name) }})</span>
                            <span style="color:black">
                                {{ substr(($myCard->number), -4) . str_repeat('*', 4) }}
                            </span>
                            <img src="{{ site_path('img/visa.png') }}" alt="visa" width="20px" class="rounded-0 m-1" style="width: 20px;">
                            <input type="radio" wire:model="selected_card" name="selected_card" value="{{ $myCard->id }}" class="select_card" data-gtm-form-interact-field-id="1">
                        </label>
                    </div>
                </div>
                <hr>
                @empty

                @endforelse

                <label class="row text-start my-3 ms-4" id="add_new_card">
                    <div class="col-md-12" wire:click="addNewCardBlock()">
                        <i class="icofont-plus me-2" aria-hidden="true"></i>
                        @lang('Add Payment Card')
                    </div>
                </label>
                <hr>
            </div>
            @endif

            <div class="payment-fields bank-fields">
                <div class="form-group bank-form">
                    <label for="card-number">رقم البطاقة</label>
                    <input wire:model="card_number" maxlength="16" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" class="bank-input" type="text" id="card-number">
                    @error('card_number')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group bank-form">
                    <label for="card-name">اسم على البطاقة</label>
                    <input wire:model="card_name" class="bank-input" type="text" id="card-name">
                    @error('card_name')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="payment-row ">
                    <div class="form-group bank-form exp-form">
                        <label for="exp-month">تاريخ الانتهاء</label>
                        <div class="exp-date-inputs">
                            <input class="bank-input" wire:model="expired_month" type="text" placeholder="MM" maxlength="2" inputmode="numeric" pattern="[0-9]*" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                            <span class="exp-divider">|</span>
                            <input class="bank-input" wire:model="expired_year" type="text" placeholder="YY" maxlength="2" inputmode="numeric" pattern="[0-9]*" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                        </div>
                        @error('expired_month')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group bank-form ccv-form">
                        <label for="ccv">رمز الامان CCV</label>
                        <input class="bank-input ccv-input" wire:model="cvv" type="text" placeholder="XXX" maxlength="3" inputmode="numeric" pattern="[0-9]*" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                        @error('cvv')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                </div>
            </div>

            <div class="cart-form-options bank-form">
                <label class="custom-checkbox">
                    <input type="checkbox" wire:model="savecard">
                    <span class="checkmark"></span>
                    @lang('Save the card data for future donations')
                </label>
            </div>


            <div class="cart-form-actions">
                <p class="proceed-text">
                    اتمام الدفع
                </p>
                <button type="submit" class="pay-btn" @if(@auth('account')->user()?->types->where('type', 'donor')->first() == null) disabled  @endif> 
                    <i class="fa fa-check"></i> @lang('Pay')
                </button>
                <a type="button" href="{{ route('site.home') }}" class="cancel-btn"><i class="fa fa-times"></i></a>
            </div>

        </form>
    </div>
</div>
