@if($categories->count() > 0 && $showSection)
<section class="sections home">
    <div class="category-container">
        <p class="title text-center">الأقســـــــام</p>
        <div class="SectionSwiper mt-lg-5 mt-sm-0">
            <div class="swiper ProjectSections">
                <div class="swiper-wrapper">
                    @foreach ($categories as $key => $category)
                        <div class="swiper-slide">
                            <a href="{{ route('site.projectCategories.show', $category->transNow->slug) }}">
                                <div class="category-content Card">
                                    @if ($category->background_image)
                                        <img class="category-img"
                                            src="{{ asset(getImage($category->background_image) ?? 'site/img/icon3.png') }}"
                                            alt="">
                                    @endif
                                    
                                    @php
                                        $title = $category->trans->first()->title ?? '';
                                    @endphp

                                    @if(strlen($title) > 10)
                                        <div class="category-desc category-title">
                                            {{ $title }}
                                        </div>
                                    @else
                                        <div class="category-desc">
                                            {{ $title }}
                                        </div>
                                    @endif
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>

                @if($categories->count() > 1)
                    <div class="swiper-button-prev ProjectSection-button-prev"></div>
                    <div class="swiper-button-next ProjectSection-button-next"></div>
                @endif
            </div>
            @if($categories->count() > 1)
                <div class="swiper-pagination"></div>
            @endif
            <div class="infoBox text-center mt-1 px-3 py-1">
                <a href="{{ route('site.projectCategories.index') }}" class="btn btn-success flex-grow-1 custom-card-donate-btn">
                    المزيـــــــــد
                </a>
            </div>
        </div>
    </div>
</section>
@endif