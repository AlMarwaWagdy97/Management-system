

@if($showSection)
<div class="statistics">
    <div class="stat-container">
        <img class="back1" src="{{ asset(site_path('img/leaves.png')) }}" alt="">
        <img class="back2" src="{{ asset(site_path('img/leaves.png')) }}" alt="">
        <div class="statistics-content">
            <div class="statistics-header">
                <h2 class="statistics-title">احصائيات الجمعية</h2>
                <p class="statistics-subtitle">إجمالي تبرعات للجمعية يدا بيد</p>
            </div>

            @php

            $totalItems = count($categoryStats);
            $itemsPerRow = ceil($totalItems / 2);
            $firstRow = array_slice($categoryStats, 0, $itemsPerRow);
            $secondRow = array_slice($categoryStats, $itemsPerRow);
            @endphp
            @if (!empty($categoryStats))
            <div class="statistics-grid desktop-only">

                <!-- First row -->
                <div class="statistics-row">
                    @foreach ($firstRow as $item)
                    <div class="stat-item-2">
                        <div class="stat-label-2">{{ $item['cat_title_' . app()->getLocale()] ?? '' }}</div>
                        <div class="stat-value-2">{{ $item['cat_number'] ?? '' }}</div>
                        <div class="stat-unit-2">{{ $item['cat_item'] ?? '' }}</div>
                    </div>
                    @if (!$loop->last)
                    <div class="stat-divider"></div>
                    @endif
                    @endforeach
                </div>

                <!-- Second row -->
                @if (!empty($secondRow))
                <div class="statistics-row">
                    @foreach ($secondRow as $item)
                    <div class="stat-item-2">
                        <div class="stat-label-2">{{ $item['cat_title_' . app()->getLocale()] ?? '' }}</div>
                        <div class="stat-value-2">{{ $item['cat_number'] ?? '' }}</div>
                        <div class="stat-unit-2">{{ $item['cat_item'] ?? '' }}</div>
                    </div>
                    @if (!$loop->last)
                    <div class="stat-divider"></div>
                    @endif
                    @endforeach
                </div>
                @endif
            </div>

            <div class="statistics-swiper-container mobile-only">
                <div class="swiper statisticsSwiper">
                    <div class="swiper-wrapper">
                        <!-- Swiper Slides -->
                        @forelse ($firstRow as $item)
                        <div class="swiper-slide">
                            <div class="stat-item-2">
                                <div class="stat-label"> {{ $item['cat_title_' . app()->getLocale()] ?? '' }}</div>
                                <div class="stat-value">{{ $item['cat_number'] ?? '' }}</div>
                                <div class="stat-unit">{{ $item['cat_item'] ?? '' }}</div>
                            </div>
                        </div>
                        @empty
                        @endforelse

                        @forelse ($secondRow as $item)
                        <div class="swiper-slide">
                            <div class="stat-item-2">
                                <div class="stat-label"> {{ $item['cat_title_' . app()->getLocale()] ?? '' }}</div>
                                <div class="stat-value">{{ $item['cat_number'] ?? '' }}</div>
                                <div class="stat-unit">{{ $item['cat_item'] ?? '' }}</div>
                            </div>
                        </div>
                  
                        @empty
                        @endforelse

                    </div>
                    <!-- Add pagination -->
                    <div class="swiper-pagination"></div>
                </div>
            </div>
            @endif
        </div>
    </div>
    <div class="statistics-image">
        <img src="{{ asset(site_path('img/hand.png')) }}" alt="يد تحمل نبتة">
    </div>
</div>
@endif
