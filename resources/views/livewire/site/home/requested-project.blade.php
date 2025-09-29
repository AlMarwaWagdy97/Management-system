<div class="col-12 col-md-6 col-lg-4 mt-3">
    <div class="CardBox custom-card">
        <div class="custom-card-header d-flex align-items-center justify-content-between custom-card-header-bg">
            <span class="custom-card-title">{{ $project->trans->first()?->title }}</span>
            <i class="fa-solid fa-share-nodes custom-card-icon"></i>
        </div>
        <div onclick="window.location.href='{{ route('site.charity-project.show', $project->trans->first()?->slug) }}'" class="custom-card-img custom-card-img-bg">
            <img src="{{ asset(getImage($project['cover_image']) ?? 'site/img/project3.png') }}" alt="project" class="custom-card-img-el">
            @if( @$progressBar['avarge'] == "100" || @$project->finished == 1)
            <span class="closed">مغلق</span>
            <div class="complete-icon">
                ✔
            </div>
            @endif
        </div>
        <div class="custom-card-body custom-card-body-bg">
            <div class="money-collected">
                <div class="d-flex justify-content-between mb-2 custom-card-amount-row">
                    <span>تم جمع: <br>{{ $progressBar['collected'] }} ر.س</br></span>
                    <span class="mt-1">{{ $progressBar['avarge'] }}%</span>
                    <span>المستهدف: <br>{{ $progressBar['target_price'] }} ر.س</br></span>
                </div>
                <div class="progress mb-2 custom-card-progress">
                    <div data-toggle="tooltip" data-placement="top" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" data-original-title=" {{ $progressBar['avarge'] }}%" bis_skin_checked="1" class="progress-bar custom-card-progress-bar" style="width: {{ $progressBar['avarge'] }}%">
                        {{-- {{ $progressBar['avarge'] }}% --}}
                    </div>
                </div>
            </div>

            @if (is_array($donation))
            @switch($donation['type'])
            @case('unit')
            <div class="d-flex-t mb-3" style="display: flex;">
                <div style="min-width: 66%;" class="donations d-flex align-items-center gap-1 justify-content-center custom-card-btn-row">
                    @forelse (@$donation['data'] ?? [] as $key => $data)
                    <label title="{{ $data['name'] }}" class="amount-btn amount-btn-100 {{ $unitValueRadio == json_encode($data) ? 'active' : null }}" style="background-color: {{ isset($colors) && is_array($colors) && count($colors) > 0 ? $colors[$key % count($colors)] : '#007bff' }}">
                        <input wire:model.live="unitValueRadio" type="radio" value="{{ json_encode($data) }}" style="display: none;">
                        {{ $data['value'] }}
                    </label>
                    @empty
                    @endforelse

                </div>

                <div class="input-open-container">
                    <input type="number" wire:model.live="unitValueInput" min="0" class="form-control open custom-placeholder" placeholder="@lang('Another amount')">
                </div>

            </div>
            @break

            @case('share')
            <div class="donations d-flex align-items-center justify-content-center gap-1 mb-3 custom-card-btn-row">
                @forelse (@$donation['data'] ?? [] as $key => $data)
                <label title="{{ $data['name'] }}" class="amount-btn amount-btn-100 {{ $shareValue == json_encode($data) ? 'active' : null }}" style="background-color: {{ isset($colors) && is_array($colors) && count($colors) > 0 ? $colors[$key % count($colors)] : '#28a745' }}">
                    <input wire:model.live="shareValue" type="radio" value="{{ json_encode($data) }}" style="display: none;">
                    {{ $data['value'] }}
                    <span>ر.س</span>
                </label>
                @empty
                @endforelse
            </div>
            @break

            @case('fixed')
            <div class="donations d-flex align-items-center justify-content-center gap-1 mb-3 custom-card-btn-row">
                <label title="{{ @$project['title'] }}" class="bg-secound amount-btn amount-btn-500">
                    {{ @$donation['data'] }}
                    <span>ر.س</span>
                </label>
            </div>
            @break

            @case('open')
            <div class="input-open-container">
                <input class="form-control open" type="number" placeholder="@lang('Price')" wire:model="openValue">
            </div>
            @break

            @default
            <div class="input-open-container">
                <input class="form-control open" type="number" placeholder="مبلغ التبرع">
            </div>
            @endswitch
            @else
            <div class="input-open-container">
                <input class="form-control open" type="number" placeholder="مبلغ التبرع">
            </div>
            @endif

            <div class="d-flex align-items-center justify-content-between mb-3 custom-card-action-row">
                <input disabled class="form-control custom-card-input" type="text" placeholder="مبلغ التبرع" wire:model="donationAmt">
                <a href="{{ route('site.charity-project.show', $project->trans->first()?->slug) }}?amount={{ @$donationAmt }}" class="btn btn-success flex-grow-1 custom-card-donate-btn">
                    تبرع الآن
                </a>
                @if ($project && isset($project['id']))
                <button class="btn btn-outline-secondary custom-card-cart-btn">
                    <i class="fa-solid fa-cart-plus" wire:click="addToCart"></i>
                </button>
                @else
                <p>Project data not available</p>
                @endif
            </div>

            @include('site.layouts.cart-msg')

            <div class="view-details" onclick="window.location.href='{{ route('site.charity-project.show', $project->trans->first()?->slug) }}'">
                عرض التفاصيل
            </div>
        </div>
    </div>
</div>
