@if ($settings->getItem('show_slider'))
<div class="banner">

    
    <div class="swiper bannerSwiper">
        <!-- Additional required wrapper -->
        <div class="swiper-wrapper">
            <!-- Slides -->
            @forelse ($slides as $key => $slide)
            <div class="swiper-slide">
                <a href="{{ $slide->url }}">
                    <div class="image_Layer">
                        <img src="{{ asset(getImage($slide->image) ?? 'site/img/bannerBG.png') }}" alt="" />
                    </div>
              
                    
                    <div class="text_Layer">
                        <div class="container">
                            <h1>
                                @if (@$slide->trans?->where('locale', $current_lang)->first()->title)
                                    {{ @$slide->trans?->where('locale', $current_lang)->first()->title }}
                                @endif
                                @if (@$slide->trans?->where('locale', $current_lang)->first()->description)
                                    {{ @$slide->trans?->where('locale', $current_lang)->first()->description }}
                                @endif
                            </h1>
                        </div>
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            </a>
            @empty
            @endforelse
        </div>
        <!-- If we need navigation buttons -->
        <!-- <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div> -->
    </div>
</div>
@endif