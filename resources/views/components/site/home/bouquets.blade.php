<div>
    @if( $settings->getItem('show_bouquets_ramadan'))
    <div class="RamdanSection mt-5">
        <div class="img_layer">
            <a href="{{ $settings->getItem('bouquets_ramadan_link') }}">
                <img src="{{ getImage($settings->getItem('bouquets_ramadan_img')) }}" alt="" />
            </a>
        </div>
        <div class="content d-flex justify-content-center align-items-center">
            <h2> {{ $settings->getItem('bouquets_ramadan_title') }} </h2>
        </div>
    </div>
    @endif
</div>