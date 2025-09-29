<div>
    @if ($settings->getItem('show_banars'))
        <section class="AdsBanner  mt-4 d-none d-md-block">
            <div class="banner-container  ">
                <div class="swiper-wrapper">
                    <div class="kaba-banner banner-container">
                        <a href="{{ $settings->getItem('banarWeb1_link') }}">
                            <img src="{{ asset(getImage($settings->getItem('banarWeb1'))) }}">
                        </a>
                    </div>
                    <div class="banner-row">
                        <div class="banner-card duaa-banner">
                            <a href="{{ $settings->getItem('banarWeb2_link') }}"></a>
                            <img src="{{ asset(getImage($settings->getItem('banarWeb2'))) }}" alt="يوم عرفة" />
                        </div>
                        <div class="right-banners banner-container">
                            <div class="banner-card salam-banner">
                                <a href="{{ $settings->getItem('banarWeb3_link') }}">
                                    <img src="{{ asset(getImage($settings->getItem('banarWeb3'))) }}"
                                         alt="أحسناكم مستمر" class="banner-image" />
                                </a>
                            </div>
                            <div class="banner-card water-banner">
                                <img src="{{ asset(getImage($settings->getItem('banarWeb4'))) }}"
                                     alt="سقي الماء" class="banner-image" />
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
 
        </section>

        {{-- mobile --}}
        <section class="AdsBannerMobile mt-4 d-block d-md-none">
            <div class="row d-flex flex-column justify-content-center align-items-center gx-2">
                <div class="">
                    <a href="{{ $settings->getItem('banarWeb1_link') }}">
                        <img src="{{ asset(getImage($settings->getItem('banarMobile1'))) }}"
                             class="img-fluid" alt=" 1">
                    </a>
                </div>
                <div class="">
                    <a href="{{ $settings->getItem('banarWeb2_link') }}">
                        <img src="{{ asset(getImage($settings->getItem('banarMobile2'))) }}"
                             class="img-fluid" alt=" 2">
                    </a>
                </div>
                <div class="">
                    <a href="{{ $settings->getItem('banarWeb3_link') }}">
                        <img src="{{ asset(getImage($settings->getItem('banarMobile3'))) }}"
                             class="img-fluid" alt=" 3">
                    </a>
                </div>
            </div>
        </section>
    @endif
</div>
