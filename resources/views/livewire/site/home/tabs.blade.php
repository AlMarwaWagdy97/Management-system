<!-- categories -->
<div>
    @if( $showCategory) 
    <section id="categories">
        <div class="container mt-lg-4">
            <!-- start swiper -->
            <div class="swiper categories">
                <div class="swiper-wrapper custom-swiper">
                    <!-- swiper-slide -->
                    @foreach ($categories as $key => $category)
                    <div class="swiper-slide category-item category-item {{ $key == 0 ? ' swiper-slide-active': ''}}" data-val="{{ $category->id }}">
                        <a href="javascript:void(0)" class="swiper-slide-category-item shadow pe-auto bg-category" style="background-color: {{ $category->background_color?? $colors[$key % count($colors??[])] }}!important">
                            <div class="swiper-slide-category-item-icon text-center">
                                {{-- <i class="icofont-heart-alt"></i> --}}
                                <img src="{{asset( getImage($category->image)) }}" alt="{{ $category->trans->first()->title }}" height="100">
                            </div>
                            <div class="swiper-slide-category-item-text text-center mt-2">
                               {{ $category->trans->first()->title }} 
                            </div>
                        </a>
                    </div>
                    @endforeach
                
                    {{-- Gifts ------------------------------------ --}}
                    @if($productStatus)
                        <div class="swiper-slide" data-val="gifts">
                            <a href="javascript:void(0)" class="swiper-slide-category-item shadow pe-auto bg-dark" style="background-color: {{ $productFastColor }} !important">
                                <div class="swiper-slide-category-item-icon text-center">
                                    <img src="{{ getImage( @$giftData['image']) }}" alt="gifts" height="100">
                                </div>
                                <div class="swiper-slide-category-item-text text-center mt-2">
                                    <h3> {{ @$giftData['title'] }} </h3>
                                </div>
                            </a>
                        </div>
                    @endif
                    {{-- zakah ------------------------------------ --}}
                    <div class="swiper-slide" data-val="zakah">
                        <a href="javascript:void(0)" class="swiper-slide-category-item shadow pe-auto bg-danger">
                            <div class="swiper-slide-category-item-icon text-center">
                                <img src="{{asset(site_path('img/category/get-moneyW.png')) }}" alt="zakah-elmal" height="100">
                            </div>
                            <div class="swiper-slide-category-item-text text-center mt-2">
                                <h3> @lang('Zakat al-Mal:') </h3>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="boxs">
                    <div class="box"></div>
                    <div class="box active"></div>
                    <div class="box"></div>
                </div>
            </div>
        </div>
        {{-- @livewireScripts --}}
    </section>

    @livewire('site.home.sub-categories', ['firstCategory' => $firstCategory ])

    @endif

</div>
