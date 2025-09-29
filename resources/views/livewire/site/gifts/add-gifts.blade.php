<div>
    <div class="gift-option">
        <span class="gift-text">تبرع عن أسرتك و أصدقائك و شاركهم الأجر</span>
        <i class="fa-solid fa-gift"></i>
        <input type="checkbox" class="gift-checkbox" wire:model.live="giftStatus" wire:change="startGift" />
    </div>

    <div class="gift-container" style="@if (!$giftStatus) display: none !important; @endif;">
        @forelse($cardFields as $index => $field)
        @if (isset($cardInfo[$index]['saved']) && $cardInfo[$index]['saved'])
        <div class="gift-form saved-card mb-4">
            <div class="text-start">
                <i class="fa-solid fa-times-circle text-danger" wire:click="removeField({{ $index }})"></i>
            </div>

            <div class="gift-header">
                <h4>بيانات المهدى إليه</h4>
            </div>

            <!-- Donation Amount Section (for saved fields) -->
            <div class="gift-donation-section mb-4">
                <div class="donation-label">مبلغ التبرع </div>
                <span class="p-2 mx-auto d-inline-block">
                    <input type="text" wire:model="cardFields.{{ $index }}.donationAmt" disabled class="form-control">
                </span>
            </div>
            <div class="gift-form">
                <div class="form-group mb-3">
                    <div class="inputs-container">
                        <!-- اسم المستلم - مطلوب دائماً -->
                        <div class="form-group mb-2">
                            <label class="form-label" for="recipient_name" id="recipient_name">الاسم</label>
                            <input type="text" class="form-control" wire:model="cardFields.{{ $index }}.giver_name" placeholder="اسم المستلم" disabled />
                        </div>

                        @if(!empty($cardFields[$index]['giver_mobile']))
                        <div class="form-group mb-2">
                            <label>الجوال</label>
                            <input type="tel" class="form-control" wire:model="cardFields.{{ $index }}.giver_mobile" placeholder="رقم الجوال" disabled />
                        </div>
                        @endif

                    </div>
                </div>

                @if(!empty($cardFields[$index]['sendCopy']))
                <div class="send-copy-container">
                    <input type="checkbox" class="form-check-input" wire:model="cardFields.{{ $index }}.sendCopy" disabled />
                    <label class="form-check-label">إرسال نسخة من البطاقة إلى جوالي</label>
                </div>
                @endif

                <!-- Card Image (for saved cards) -->
                <div class="mb-3 row">
                    <div class="col-12 col-md-4">
                        <input type="text" wire:model="cardFields.{{ $index }}.cardTitle" value="{{ getImageFileManger($cardFields[$index]['image']) }}" class="form-control content-input" disabled>
                    </div>
                    <div class="col-md-3">
                        @php
                        $img = $cardFields[$index]['image'] ?? null;
                        @endphp

                        @if ($img)
                        <a href="{{ getImageFileManger($img) }}" target="_blank">
                            <img src="{{ asset(getImage($img)) }}" width="60" alt="بطاقة الإهداء">
                        </a>
                        @endif
                    </div>
                </div>
                <hr />
            </div>
        </div>
        @else
        <div class="gift-form mb-4">
            <div class="text-start">
                <i class="fa-solid fa-times-circle text-danger" wire:click="removeField({{ $index }})"></i>
            </div>
            <h4 class="text-center mb-3">بيانات المهدى إليه</h4>

            @if ($index == $errorIndex)
            <div class="alert alert-danger text-center" role="alert">
                {{ $cardInfoMessage }}
            </div>
            @endif

            <!-- Donation Amount Section -->
            <div class="gift-donation-section mb-3">
                <div class="donation-label mb-2" style="text-align: right;">مبلغ التبرع</div>
                <div class="donation-amounts">
                    @if (is_array($donation))
                        @switch($donation['type'])
                            @case('unit')
                                <div class="donation-amounts text-center">
                                    @forelse (@$donation['data'] ?? [] as $key => $data)
                                    <label data-toggle="tooltip" data-placement="top" title="{{ $data['name'] }}"  style="background-color:{{ is_array($colors) && count($colors) > 0 ? $colors[$key % count($colors)] : '#ccc' }}" 
                                        class="amount-btn amount-btn {{ $cardFields[$index]['unitValueRadio'] == json_encode($data) ? 'active' : null }} ">
                                        <input wire:model.live="cardFields.{{ $index }}.unitValueRadio" type="radio" value="{{ json_encode($data) }}"  wire:click="updateDonation({{ $index }})" style="display: none">
                                        <div class="price">
                                            <span>{{ $data['value'] }}</span>
                                            {{-- <small class="large-screen"> &#65020;</small> --}}
                                        </div>
                                    </label>
                                    @empty
                                    @endforelse
                                </div>
                                <div class="custom-amount">
                                    <input type="number" wire:model.live="cardFields.{{ $index }}.unitValueInput" wire:change="updateDonation({{ $index }})"  min="0" placeholder="@lang('Another amount')" class="amount-input" />
                                    <span class="currency">رس</span>
                                </div>
                                @break

                            @case('share')
                                @foreach ($donation['data'] as $key => $data)
                                    @php
                                    $color = is_array($colors) && count($colors) > 0 ? $colors[$key % count($colors)] : '#36a2eb';
                                    @endphp
                                    <label class="amount-btn {{ @$cardFields[$index]['shareValue']  == json_encode($data) ? 'active' : null }}" style="background-color: {{ $color }};" data-toggle="tooltip" data-placement="top" title="{{ $data['name'] }}">
                                        <input type="radio" wire:model.live="cardFields.{{ $index }}.shareValue" value="{{ json_encode($data) }}" wire:click="updateDonation({{ $index }})" style="display: none" />
                                        {{ $data['value'] }}
                                    </label>
                                @endforeach
                                @break

                            @case('fixed')
                                <button class="amount-btn" style="background-color: {{ is_array($colors) && count($colors) > 0 ? $colors[0] : '#36a2eb' }};">
                                    {{ $donation['data'] }} رس
                                </button>
                                @break

                            @case('open')
                                <div class="custom-amount">
                                    <input type="number" wire:model.live="cardFields.{{ $index }}.openValue" wire:change="updateDonation({{ $index }})" class="form-control text-center" placeholder="أدخل المبلغ" min="1" required>
                                    <span class="currency">رس</span>
                                </div>
                                @break

                            @default
                                @foreach ($donation['data'] as $key => $data)
                                @php
                                $color = is_array($colors) && count($colors) > 0 ? $colors[$key % count($colors)] : '#36a2eb';
                                @endphp
                                <label class="amount-btn" style="background-color: {{ $color }};">
                                    <input type="radio" wire:model.live="cardFields.{{ $index }}.donationAmt" value="{{ $data['value'] }}" style="display: none" />
                                    <div class="price">
                                        <span>{{ $data['value'] }}</span>
                                    </div>
                                </label>
                                @endforeach
                        @endswitch
                    @else
                        @foreach ($donation['data'] as $key => $data)
                            @php
                            $color = is_array($colors) && count($colors) > 0 ? $colors[$key % count($colors)] : '#36a2eb';
                            @endphp
                            <label class="amount-btn" style="background-color: {{ $color }};">
                                <input type="radio" wire:model.live="cardFields.{{ $index }}.donationAmt" value="{{ $data['value'] }}" style="display: none" />
                                <div class="price">
                                    <span>{{ $data['value'] }} رس</span>
                                </div>
                            </label>
                        @endforeach
                    @endif
                </div>
            </div>

            <div class="form-group mb-3">
                <div class="inputs-container">
                    <!-- Recipient Inputs -->
                    <div class="form-group">
                        <label>الاسم</label>
                        <input type="text" class="form-control" wire:model="cardFields.{{ $index }}.giver_name" placeholder="اسم المستلم" />
                    </div>
                    <div class="form-group">
                        <label>الجوال <span class="text-muted">(اجباري)</span></label>
                        <input type="tel" class="form-control" wire:model="cardFields.{{ $index }}.giver_mobile" placeholder="رقم الجوال" oninput="this.value = this.value.replace(/[^0-9]/g, '');" maxlength="9" required />
                    </div>
                </div>
            </div>

            <!-- Copy to mobile -->
            <div class="send-copy-container">
                <input type="checkbox" class="form-check-input" id="send_copy_checkbox" wire:model="cardFields.{{ $index }}.sendCopy" />
                <label class="form-check-label">إرسال نسخة من البطاقة إلى جوالي</label>
            </div>

            <!-- Gift Category -->
            <div class="form-group mb-3">
                <label class="gift-category-label">فئة الإهداء</label>
                <select wire:model="cardFields.{{ $index }}.giftType" class="form-select" wire:change="selectGiftType({{ $index }})">
                    <option value="">اختيار فئة الإهداء</option>
                    @foreach (json_decode($cards ?? '', true) ?? [] as $keyCard => $cardtitle)
                    <option value="{{ $keyCard }}">
                        {{ $cardtitle['title_' . app()->getLocale()] }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div id="gift_cards_container" class="gift-cards-container">
                <!-- Gift Cards -->
                @if (!empty($cardInfo[$index]['cardImages']))
                <div class="gift-cards-grid">
                    @foreach (json_decode($cardInfo[$index]['cardImages'], true) as $keyImg => $img)
                    <label class="btn btn-light gift-img group-img image-selector @if ($cardFields[$index]['image'] == $img) active @endif" for="gift-{{ $keyImg }}">
                        <input type="radio" id="gift-{{ $keyImg }}" class="d-none" value="{{ $img }}" wire:model.live="cardFields.{{ $index }}.image" required="">
                        <img src="{{ asset(getImage($img)) }}" alt="بطاقة إهداء">
                    </label>
                    @endforeach
                </div>
                @endif
            </div>

            <div class="text-end mt-3">
                <button class="btn btn-primary btn-xs" wire:click="saveGiftInfo({{ $index }})">
                    <i class="fa-solid fa-check"></i> حفظ
                </button>
            </div>
        </div>
        @endif
        @empty
        @endforelse

        <!-- Add Another Gift Button -->
        @if ($cardFields)
        <div class="text-end mt-3">
            <button class="btn btn-primary gift-btn" id="add_another_gift" wire:click="addField">
                <i class="fa-solid fa-plus"></i> @lang('Add a gift for someone else')
            </button>
        </div>
        @endif
    </div>

    <!-- Modal for gift card preview -->
    <div class="modal fade" id="popup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <!-- Image will be inserted here -->
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        function initializeImageSelectors() {
            document.querySelectorAll('.image-selector').forEach(function(selector) {
                selector.addEventListener('click', function() {
                    const container = this.closest('.gift-cards-grid');

                    container.querySelectorAll('.image-selector').forEach(function(s) {
                        s.classList.remove('active');
                    });

                    this.classList.add('active');

                    const radioInput = this.querySelector('input[type="radio"]');
                    if (radioInput) {
                        radioInput.checked = true;
                        radioInput.dispatchEvent(new Event('change'));
                    }
                });
            });
        }

        function initializeDonationButtons() {
            document.querySelectorAll('.donation-amount-btn').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    const container = this.closest('.donation-amount-buttons');

                    container.querySelectorAll('.donation-amount-btn').forEach(function(b) {
                        b.classList.remove('active');
                    });

                    this.classList.add('active');
                });
            });
        }

        initializeImageSelectors();
        initializeDonationButtons();

        document.addEventListener('livewire:load', function() {
            initializeImageSelectors();
            initializeDonationButtons();
        });

        document.addEventListener('livewire:initialized', function() {
            initializeImageSelectors();
            initializeDonationButtons();
        });

        Livewire.hook('message.processed', (message, component) => {
            setTimeout(() => {
                initializeImageSelectors();
                initializeDonationButtons();
            }, 100);
        });
    });

</script>
