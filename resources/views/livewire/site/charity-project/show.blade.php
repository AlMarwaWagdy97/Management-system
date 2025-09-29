<div>
    <div class="project-content container">
        <!-- Left Card - Donation Form -->
        <div class="donation-card-container">
            <div class="donation-card content">
                <div class="hadith-text">
                    {{-- {!! $project->trans?->where('locale', $current_lang)->first()->description !!} --}}
                </div>

                @if (is_array($donation))
                @switch($donation['type'])
                @case('unit')
                <div class="donation-amounts text-center">
                    @forelse (@$donation['data'] ?? [] as $key => $data)
                    <label data-toggle="tooltip" data-placement="top" title="{{ $data['name'] }}" {{-- style="background-color:{{ $colors[$key % count($colors)] }}" --}} style="background-color:{{ is_array($colors) && count($colors) > 0 ? $colors[$key % count($colors)] : '#ccc' }}" class="amount-btn {{ $unitValueRadio == json_encode($data) ? 'active' : null }} {{ $data['value'] == $donationAmt ? 'active' : null }}
                                        @if ($donation_status == 1) input-disable @endif">
                        <input wire:model.live="unitValueRadio" type="radio" value="{{ json_encode($data) }}" @if ($donation_status==1) disabled @endif style="display: none">
                        <div class="price">
                            <span>{{ $data['value'] }}</span>
                            {{-- <small class="large-screen"> &#65020;</small> --}}
                        </div>
                    </label>
                    @empty
                    @endforelse
                </div>
                <div class="custom-amount">
                    <input type="number" wire:model.live="unitValueInput" min="0" placeholder="@lang('Another amount')" class="amount-input" />
                    <span class="currency">رس</span>
                </div>
                @break

                @case('share')
                <div class="donation-amounts text-center">
                    @forelse (@$donation['data']??[] as $key => $data)
                    <label data-toggle="tooltip" data-placement="top" title="{{ $data['name'] }}" for="ab-{{ $key }}" style="background-color:{{ is_array($colors) && count($colors) > 0 ? $colors[$key % (count($colors) ?? 0)] : '#ccc' }}" class="amount-btn  {{ $shareValue == json_encode($data) ? 'active' : null }}" {{ $shareValue == json_encode($data) ? 'active' : '' }}>
                        <input wire:model.live="shareValue" type="radio" value="{{ json_encode($data) }}" id="ab-{{ $key }}" style="display: none">
                        {{ $data['value'] }}
                    </label>
                    @empty
                    @endforelse
                </div>
                @break

                @case('fixed')
                <div class="donation-amounts text-center">
                    <button class="btn btn-primary amount-btn amount-btn-500" style="background-color:{{ @$colors[0] }}">
                        {{ @$donation['data'] }} <span>رس</span>
                    </button>
                </div>
                @break

                @case('open')
                <div class="custom-amount">
                    <input type="number" wire:model="openValue" min="0" placeholder="@lang('Price')" class="amount-input" />
                    <span class="currency">رس</span>
                </div>
                @break

                @default
                <span>Something went wrong, please try again</span>
                @endswitch
                @endif

                @livewire('site.gifts.add-gifts', [
                'cards' => $cards,
                'donation' => $donation,
                'colorsAmount' => $colorsAmount,
                'project' => $project,
                ])

                @include('site.layouts.cart-msg')

                <div class="checkout-container">
                    <input disabled class="form-control custom-input-donation" type="text" placeholder="مبلغ التبرع الإجمالي" value="{{ $this->totalAmt }}">
                    <button class="checkout-btn  btn-lg" wire:click="donateNow()">
                        اتمام الطلب
                    </button>
                    <button class="cart-icon-btn" wire:click="addToCart()">
                        <i class="fa-solid fa-cart-shopping"></i>
                    </button>
                </div>
            </div>
            @if ($project && $project->statistic_status)
            <div class="statistics-section">
                <div class="stat-item">
                    <div class="stat-icon">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-title">عدد الزيارات {{ $project->visits_count }} زيارة</div>
                    </div>
                </div>

                <div class="stat-item">
                    <div class="stat-icon">
                        <i class="fa-solid fa-hand-holding-dollar"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-title">عمليات التبرع {{ number_format($project->donations_count + $project->orderDetails?->sum('quantity')  ) }} عملية</div>
                    </div>
                </div>

                <div class="stat-item">
                    <div class="stat-icon">
                        <i class="fa-solid fa-hourglass"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-title">
                            @if ($project->last_donation_at)
                            آخر عملية تبرع {{ \Carbon\Carbon::parse(@$project->orderDetails ? $project->orderDetails?->last()?->created_at : $project->last_donation_at)->diffForHumans() }}
                            @else
                            لا توجد تبرعات بعد
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endif


        </div>

        <!-- Right Card - Project Info -->
        <div class="project-card-container">
            <div class="project-card">
                <div class="project-header-container">
                    <h2 class="project-title">{{ $project->trans?->where('locale', $current_lang)->first()->title }}
                    </h2>
                    <button class="share-btn">
                        <i class="fa-solid fa-share-nodes"></i>
                    </button>
                </div>

                @if (json_decode($project['images'], true) != null)
                <div id="carouselExampleIndicators" class="carousel slide project-image" data-bs-ride="carousel" data-interval="10000">
                    <div class="carousel-indicators">
                        @forelse (json_decode($project['images'], true)??[] as $key => $img)
                        <button type="button" data-bs-target="#carouselExampleIndicators" class="{{ $key == 0 ? 'active' : null }}" data-bs-slide-to="{{ $key }}" aria-label="Slide {{ $key }}"></button>
                        @empty
                        @endforelse
                    </div>
                    <div class="carousel-inner">
                        @forelse (json_decode($project['images'], true)??[] as $key => $img)
                        <div class="carousel-item {{ $key == 0 ? 'active' : null }}">
                            <img src="{{ getImageFileManger($img) }}" class="d-block w-100" alt="{{ $project->title }}">
                        </div>
                        @empty
                        @endforelse
                    </div>

                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
                @else
                <div class="project-image">
                    <img src="{{ getImage($project['cover_image']) }}" alt="{{ $project->title }}" />
                    @if( @$progressBar['avarge'] == "100" || @$project->finished == 1)
                    <span class="closed">مغلق</span>
                    <div class="complete-icon">
                        ✔
                    </div>
                    @endif
                </div>
                @endif
                <div class="project-details">
                    {!! $project->trans?->where('locale', $current_lang)->first()->description !!}

                </div>

                <div class="money-collected">
                    <div class="d-flex justify-content-between custom-card-amount-row">
                        <span>تم جمع: <br>{{ $progressBar['collected'] }} <span>ر.س</span> </br></span>
                        <span class="mt-1">{{ $progressBar['avarge'] }}%</span>
                        <span> المستهدف: <br>{{ $progressBar['target_price'] }} <span>ر.س</span> </br></span>
                    </div>

                    <div class="progress mb-2 custom-card-progress">
                        <div data-toggle="tooltip" data-placement="top" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" data-original-title=" {{ $progressBar['avarge'] }}%" bis_skin_checked="1" class="progress-bar custom-card-progress-bar" style="width: {{ $progressBar['avarge'] }}%">
                            {{-- {{ $progressBar['avarge'] }}% --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @livewire('site.carts.add-modal')




</div>
