@extends('site.app')
@section('title', "volunteers")


@section('content')

<!--volunteer-->
{{-- <div class="Volunteer my-5">
    <div class="container">
        <div class="contant py-5">
            <div class="title px-4 py-2 mx-auto">
                <h2> @lang('volunteers.birrukum_pride')  </h2>
            </div>
            <div class="VolunterSwiper">
                <div class="volunteer-swiper px-3">
                    <div class="swiper-wrapper">

                        @forelse ($voluntrees as $key => $voluntree)
                        <div class="swiper-slide">
                            <div class="Card">
                                @switch($voluntree->medal)
                                @case(1)
                                <img src="{{ site_path('/img/medals/gold.webp') }}" class="modal" alt="" />
                                @break
                                @case(2)
                                <img src="{{ site_path('/img/medals/sliver.webp') }}" class="modal" alt="" />
                                @break
                                @case(3)
                                <img src="{{ site_path('/img/medals/BronzeMedal.webp') }}/" class="modal" alt="" />
                                @break
                                @default
                                @endswitch
                                <img src="{{ getImage($voluntree->image) }}" class="man mx-auto" alt="" />
                                <div class="text">
                                    <span> @lang('volunteers.the_volunteer') </span>
                                    <h5> {{ $voluntree->name }} </h5>
                                    <p class="mt-3"> {{ $voluntree->activity }} </p>
                                </div>
                            </div>
                        </div>
                        @empty
                        @endforelse

                    </div>

                </div>
                <div class="pointer d-flex justify-content-center align-items-center m-3">
                    <div class="swiper-pagination"></div>
                    <a href="{{ route('site.volunteering.volunteers') }}" class="btn btn-primay btn-more">
                        <span> @lang('More') </span>
                      <i class="fa-solid icofont-caret-left"></i>
                    </a>
                  </div>
            </div>

            <div class="Btns d-flex flex-wrap justify-content-center align-items-center pt-3">

                <a href="{{ route('site.volunteering.join-community') }}" class="btn btn-hash">
                    @lang('volunteers.Join__community') <br/>
                    @lang('volunteers.birrukum_voluntree')

                </a>
                <a href="{{ route('site.volunteering.informations') }}" class="btn btn-Info">
                    @lang('volunteers.Learn_volunteering')<br /> @lang('volunteers.in_birrukum')
                </a>
                <a href="{{ route('site.volunteering.ideas') }}" class="btn btn-Idea">
                    @lang('volunteers.idea_bank')<br />
                    @lang('volunteers.interactive')
                </a>
            </div>
        </div>
    </div>
</div> --}}
 <div class="ThankYou mt-1">
        <div class="container">

            <div class="success-icon-container">
                <div class="success-icon">
                    <img src="{{ site_path('img/verified.gif') }}" alt="Verified" class="your-css-class-if-needed" />
                </div>
            </div>
            <div class="row mt-3 mx-3 mx-md-0">

                <div class="col-12 text-center pt-1">
                    <i class="icofont-star star-icon text-secound fs-1 my-1"></i>
                    <div class="text">
                        {{-- <h1 class="text-main display-1" dir="ltr">@lang('Thank you')</h1> --}}

                        <div class="thanks-message">
                            <h2>شكرًا لك تم التسجيل  </h2>
                        </div>

                  
                        @include('site.layouts.message')
                        {{-- <p class="fs-4"> مع تحيات جمعية {{ $settings->getItem('site_name') }} </p> --}}
                        <a href="{{ route('site.home') }}"
                            class="btn bg-main donation-record-btn py-2 my-3 w-50 btn btn-main">
                            @lang('Back to website')
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!--volunteer-->

@endsection
