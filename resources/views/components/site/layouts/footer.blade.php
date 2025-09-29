<footer>
    <div class="row">
        <div class="col-12 col-lg-3 p-0  ">
            <div class="first bg_footer1 p-3">
                <div class="footer-text">


                    <h2 class="first-title title_footer">عــن الجمعية</h2>

                    <p class="first-text title_footer">
                        {{ $settings->getItem('footer_description') }}
                    </p>
                </div>
                <div class="socialIncons d-flex justify-content-center align-items-center mt-4">
                    @if( $settings->getContactInformationData('instagram'))
                    <a class="icon" href="{{ $settings->getContactInformationData('instagram') }}">
                        <i class="fa-brands fa-instagram"></i>
                    </a>
                    @endif

                    @if( $settings->getContactInformationData('instagram'))
                    <a class="icon" href="{{ $settings->getContactInformationData('facebook') }}">
                        <i class="fa-brands fa-facebook"></i>
                    </a>
                    @endif

                    @if( $settings->getContactInformationData('youtube'))
                    <a class="icon" href="{{ $settings->getContactInformationData('youtube') }}">
                        <i class="fa-brands fa-youtube"></i>
                    </a>
                    @endif

                    @if( $settings->getContactInformationData('twitter'))
                    <a class="icon" href="{{ $settings->getContactInformationData('twitter') }}">
                        <i class="fa-brands fa-x-twitter"></i>
                    </a>
                    @endif

                    @if( $settings->getContactInformationData('snapchat'))
                    <a class="icon" href="{{ $settings->getContactInformationData('snapchat') }}">
                        <i class="fa-brands fa-snapchat"></i>
                    </a>
                    @endif

                    @if( $settings->getContactInformationData('whatsapp'))
                    <a class="icon" href="{{ $settings->getContactInformationData('whatsapp') }}">
                        <i class="fa-brands fa-whatsapp"></i>
                    </a>
                    @endif
                </div>
                <p class="mt-3 title_footer text-center d-none d-md-block">
                    جميع الحقوق محفوظة {{ date('Y') }} &#169;
                </p>
            </div>
        </div>

        <div class="col-12 col-lg-3 p-0 ">
            <div class="secand bg_footer2 p-3 h-100">
                <ul class="text-center ">
                    <h5 class="title_footer">أهم الروابط :</h5>

                    @forelse($menus as $key => $menu)
                    @if ($menu->type == App\Enums\MunesEnum::DYNAMIC)
                    <li> <a class="title_footer" href="{{ App::make('url')->to($menu->dynamic_url) }}">{{ $menu->title }}</a> </li>

                    @elseif ($menu->type == App\Enums\MunesEnum::STATIC)
                    <li> <a class="title_footer" href="{{ App::make('url')->to($menu->url) }}">{{ $menu->title }}</a></li>
                    @endif
                    @empty
                    @endforelse
                </ul>
            </div>
        </div>
        <div class="col-12 col-lg-3 p-0 ">
            <div class="thrid bg_footer1 h-100 d-flex flex-column justify-content-center align-items-center p-3 p-lg-0">
                <div class="ImgContainer d-flex justify-content-between align-items-center">
                    <img src="{{ asset(getImage($settings->getItem('footer_logo')) ?? site_path('img/Logo 1.png')) }}" class="img-fluid" alt="" />
                    <img src="{{ asset(getImage($settings->getItem('commercial_license')) ?? site_path('img/Logo 1.png')) }}" class="img-fluid" alt="" />
                </div>
                <div class="ImgContainer2 d-flex justify-content-center align-items-center mt-2">
                    @forelse($payment_methodImages as $pay_img)
                    <img src="{{ asset(getImage($pay_img)) }}" class="img-fluid" alt="" />
                    @empty
                    {{-- <img src="{{ asset(getImage($settings->getItem('payment_method')) ?? site_path('img/Logo 1.png')) }}"
                    class="img-fluid" alt="" /> --}}

                    <img src="{{ site_path('img/pay-1.png') }}" class="img-fluid" alt="" />
                    <img src="{{ site_path('img/pay-2.png') }}" class="img-fluid" alt="" />
                    <img src="{{ site_path('img/pay-4.png') }}" class="img-fluid" alt="" />
                    @endforelse
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-3  p-0 four ">
            <div class="fourth bg_footer2 d-flex flex-column justify-content-start align-items-center h-100">
                @if ($settings->getContactInformationData('whatsapp'))
                <a href="https://wa.me/{{ $settings->getContactInformationData('whatsapp') }}" class="whatsapp-icon">
                    <i class=" whats-bg fa-brands fa-whatsapp"></i>
                </a>
                @endif
                <h2 class="fourth-title title_footer">معلومات الاتصال</h2>
                <div class="fristrow  d-flex justify-content-center align-items-center ">
                    @if ($settings->getContactInformationData('mobile'))
                    <a class="contact" href="tel:{{ $settings->getContactInformationData('mobile') }}">
                        <span>{{ $settings->getContactInformationData('mobile') }}</span>
                        <i class="fa-solid fa-phone"></i>
                    </a>
                    @endif
                    @if ($settings->getContactInformationData('phone'))
                    <a class="contact" href="https://wa.me/{{ $settings->getContactInformationData('phone') }}">
                        <span>{{ $settings->getContactInformationData('phone') }}</span>
                        <i class="fa-solid  fa-blender-phone"></i>
                    </a>
                    @endif

                </div>
                <div class="Secandrow  my-3">
                    <a class="contact" href="mailto:{{ $settings->getContactInformationData('email') }}" class="d-inline-block">
                        <span>
                            {{ $settings->getContactInformationData('email') }}
                        </span>
                        <i id="email-icon" class="fa-solid fa-envelope"></i>
                    </a>
                </div>
                <div class="ThridRow d-flex justify-content-between align-items-center">
                    @if($settings->getItem('app_store'))
                    <a href="{{ $settings->getItem('app_store') }}">
                        <img src="{{ asset('site/img/pay-6.png') }}" class="img-fluid" />
                    </a>
                    @endif
                    @if($settings->getItem('google_play'))
                    <a href="{{ $settings->getItem('google_play') }}">
                        <img src="{{ asset('site/img/pay-7.png') }}" class="img-fluid" />
                    </a>
                    @endif
                </div>
                <p class="mt-3 text-center d-md-none">
                    جميع الحقوق محفوظة 2025 &#169;
                </p>
            </div>
        </div>
    </div>
</footer>
