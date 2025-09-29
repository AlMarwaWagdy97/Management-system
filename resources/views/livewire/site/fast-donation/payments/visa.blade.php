<div>
    <form wire:submit.prevent="checkout" class="">
    <div class="visa payment-content">
            @include('livewire.site.payments.message')
            <div class="label bank-text">
                <p> @lang('Pay From Visa') </p>
            </div>

            @if(count($myCards??[]))
                <div class="payment-card payment-white p-1" id="paymentByCard" style="">

                    @forelse ($myCards as $myCard)
                    <div class="row selected_saved_card my-2">
                        <div class="text-start">
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
                    <div class="row selected_cvv my-2 {{ $selected_card == $myCard->id ? 'd-block' : 'd-none'}} text-center">
                        <input type="text" wire:model="selected_cvv" placeholder="CVV" maxlength="3" inputmode="numeric" pattern="[0-9]*" class="form-control col-md-6 only-number card-exp valid">
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

            <div class="payment-fields bank-fields" {{ $this->showNewCard == false && count($myCards) != 0? 'd-none' :'d-block' }}>
                <div class="form-group bank-form">
                    <label for="card-number">رقم البطاقة</label>
                    <input wire:model="card_number" class="bank-input" type="text" id="card-number"  maxlength="16" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" placeholder="@lang('Card Number')">
                    @error('card_number')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group bank-form">
                    <label for="card-name">اسم على البطاقة</label>
                    <input class="bank-input" type="text" id="card-name" wire:model="card_name" placeholder="@lang('Card Name')">
                    @error('card_name')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="payment-row fast-pay-payment-row ">
                    <div class="form-group bank-form exp-form">
                        <label for="exp-month">تاريخ الانتهاء</label>
                        <div class="exp-date-inputs">
                            <input class="bank-input" type="text" id="exp-month" name="exp-month" placeholder="MM" wire:model="expired_month" maxlength="2" inputmode="numeric" pattern="[0-9]*" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                            <span class="exp-divider">|</span>
                            <input class="bank-input" type="text" id="exp-year" name="exp-year" placeholder="YY" wire:model="expired_year" maxlength="2" inputmode="numeric" pattern="[0-9]*" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                        </div>
                        @error('expired_month')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                        @error('expired_year')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    </div>
                    <div class="form-group bank-form ccv-form">
                        <label for="ccv">رمز الامان CCV</label>
                        <input class="bank-input ccv-input" wire:model="cvv" type="text" placeholder="@lang('CVV')" maxlength="3" inputmode="numeric" pattern="[0-9]*" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                        @error('cvv')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                </div>
            </div>
           
            <div class="cart-form-actions">
                <p class="proceed-text">
                    اتمام الدفع
                </p>
                <button type="submit" class="pay-btn" ><i class="fa fa-check"></i> الدفع</button>
                <a href="{{ route('site.home') }}" type="button" class="cancel-btn"><i class="fa fa-times"></i></a>
            </div>
            
        </div>
    </form>
</div>
