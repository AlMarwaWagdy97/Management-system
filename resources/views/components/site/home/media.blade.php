
@if( $settings->getItem('show_banars') )
    <section id="media" class="my-5">
        <div class="container">
            <div class="row g-2">

                <div class="col-6 col-md-3 mt-2 media-img">
                    <a class="large-screen" href="{{ $settings->getItem('banarWeb3_link') }}">
                        <img src="{{ getImage($settings->getItem('banarWeb3'))}}" alt="" class="w-100">
                    </a>
                    <a class="small-screen" href="{{ $settings->getItem('banarMobile3_link') }}">
                        <img src="{{ getImage($settings->getItem('banarMobile3'))}}" alt="" class="w-100">
                    </a>
                </div>

                <div class="col-6 col-md-3 mt-2 media-img">
                    <a class="large-screen" href="{{ $settings->getItem('banarWeb2_link') }}">
                        <img src="{{ getImage($settings->getItem('banarWeb2'))}}" alt="" class="w-100">
                    </a>
                    <a class="small-screen" href="{{ $settings->getItem('banarMobile2_link') }}">
                        <img src="{{ getImage($settings->getItem('banarMobile2'))}}" alt="" class="w-100">
                    </a>
                </div>

                <div class="col-12 col-md-6 mt-2 media-img">
                    <a class="large-screen" href="{{ $settings->getItem('banarWeb1_link') }}">
                        <img src="{{ getImage($settings->getItem('banarWeb1'))}}" alt="" class="w-100">
                    </a>
                    <a class="small-screen" href="{{ $settings->getItem('banarMobile1_link') }}">
                        <img src="{{ getImage($settings->getItem('banarMobile1'))}}" alt="" class="w-100">
                    </a>
                </div>
            </div>
        </div>
    </section>
@endif
