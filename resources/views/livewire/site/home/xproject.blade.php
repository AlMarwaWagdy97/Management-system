<div class="col-12 col-md-6 col-lg-4 mt-3">
    <div class="CardBox custom-card">
        <a href="{{ route('site.charity-project.show', $project['slug']) }}">
            <div class="custom-card-header d-flex align-items-center justify-content-between custom-card-header-bg">
                <span class="custom-card-title"> {{ $project['title'] }} </span>
                <i class="fa-solid fa-share-nodes custom-card-icon"></i>
            </div>
            <div class="custom-card-img custom-card-img-bg">
                <img src="{{ asset(getImage($project['cover_image']) ?? 'site/img/project3.png') }}" alt="project"
                    class="custom-card-img-el">
            </div>
        </a>
        <div class="custom-card-body custom-card-body-bg">
            <div class="money-collected">

                <div class="d-flex justify-content-between mb-2 custom-card-amount-row">
                    <span>تم جمع: <br>{{ $progressBar['collected'] }} ر.س</br></span>
                    <span>المبلغ المتبقي: <br>{{ $progressBar['reminder'] }} ر.س</br></span>
                </div>
                <div class="progress mb-2 custom-card-progress">
                    <div class="progress-bar custom-card-progress-bar">
                        {{ $progressBar['percent'] }}@lang('%')
                    </div>
                </div>
            </div>
            <div class="donations d-flex align-items-center justify-content-center gap-1  mb-3 custom-card-btn-row">
                @if (is_array($donation))
                    @switch($donation['type'])
                        @case('unit')
                            @forelse (@$donation['data'] ?? [] as $key => $data)
                                {{-- <label  title="{{ $data['name'] }}" class="amount-btn amount-btn-100  {{ $unitValueRadio == json_encode($data) ? 'active' : null }}" style="background-color: {{  $colors[$key % count($colors?? [])] }}"> --}}
                                <input wire:model.live="unitValueRadio" type="radio" value="{{ json_encode($data) }}">
                                {{ $data['value'] }}
                                {{-- <span>ر.س</span> --}}
                                </label>
                            @empty
                            @endforelse
                            <input type="number" wire:model.live="unitValueInput" min="0"
                                class="form-control custom-card-input" placeholder="@lang('Another amount')">
                        @break

                        @case('share')
                            @forelse (@$donation['data'] ?? [] as $key => $data)
                                {{-- <label title="{{ $data['name'] }}" class="amount-btn amount-btn-100 {{ $shareValue == json_encode($data) ? 'active' : null }}" style="background-color: {{  $colors[$key % count($colors)] }}"> --}}
                                <input wire:model.live="shareValue" type="radio" value="{{ json_encode($data) }}">
                                {{ $data['value'] }}
                                <span>ر.س</span>
                                </label>
                            @empty
                            @endforelse
                        @break

                        @case('fixed')
                            <label title="{{ @$project['title'] }}" class="bg-secound amount-btn amount-btn-500">
                                {{ @$donation['data'] }}
                                <span>ر.س</span>
                            </label>
                        @break

                        @case('open')
                            <input class="form-control m-0 custom-card-input" type="number" placeholder="@lang('Price')"
                                wire:model="openValue">
                        @break

                        @default
                            <span>Something went wrong, please try again</span>
                    @endswitch
                @endif
                <!-- <span class="custom-card-donation-label">مبلغ التبرع</span> -->
            </div>
            <div class="d-flex align-items-center justify-content-between mb-3 custom-card-action-row">
                <input disabled class="form-control custom-input-donation" type="text" placeholder="مبلغ التبرع"
                    wire:model="donationAmt">
                <a href="{{ route('site.charity-project.show', $project['slug']) }}?amount={{ @$donationAmt }}"
                    class="btn btn-success flex-grow-1 custom-card-donate-btn">
                    تبرع الآن
                </a>
                <button class="btn btn-outline-secondary custom-card-cart-btn">
                    <i class="fa-solid fa-cart-plus" wire:click="addToCart"></i>
                </button>
            </div>
            @include('site.layouts.cart-msg')
        </div>
    </div>
</div>
