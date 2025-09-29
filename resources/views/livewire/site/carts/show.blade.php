<div class="cart-container">
    <div class="cart-items-list">
        @php $total = 0; @endphp
        @forelse ($items as $key => $itemCart)
            <div class="cart-item">
                <a class="text-decoration-none"
                    href="{{ route('site.charity-project.show', $itemCart->item->transNow->slug) }}">

                    <div class="cart-item-img-title">
                        <img src="{{ getImage($itemCart->item->cover_image) }}" alt="project" class="cart-item-img">
                        <span class="cart-item-title">
                            {{ @$itemCart->item_name }}
                            @if (@$itemCart->item_sub_type)
                                <span> ({{ @$itemCart->item_sub_type }} ) </span>
                            @endif
                        </span>

                    </div>
                </a>
                <div class="cart-item-controls">
                    <div class="cart-item-unit">
                        <span class="unit-value">{{ $itemCart['price'] }} ريال</span>
                        <span class="unit-label">الوحدة</span>
                    </div>
                    <div class="cart-item-qty">
                        <button class="qty-btn qty-minus" wire:click="minus({{ $itemCart->id }})"><i
                                class="fa fa-minus"></i></button>
                        <span class="qty-value">{{ $itemCart['quantity'] }}</span>
                        <button class="qty-btn qty-plus" wire:click="plus({{ $itemCart->id }})"><i
                                class="fa fa-plus"></i></button>
                        <span class="qty-label">الكمية</span>
                    </div>
                </div>
                <div class="cart-item-price">
                    <span class="price-value">{{ $itemCart['quantity'] * $itemCart['price'] }}</span>
                    <span class="price-currency">ريال</span>
                </div>

                @php
                    $gift_details = json_decode($itemCart['gift_details']);
                    $total += $itemCart['price'] * $itemCart['quantity'];
                @endphp
                @if ($gift_details)
                    <button class="btn btn-sm btn-warm warm m-1" data-bs-toggle="modal"
                        data-bs-target="#giftGiven{{ $key }}">
                        <i class="fa-solid fa-gift text-success mx-1"></i>
                    </button>
                    <div class="modal fade" id="giftGiven{{ $key }}" data-bs-backdrop="static"
                        data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title text-success" id="staticBackdropLabel">
                                        @lang('The information of then given')</h5>
                                </div>
                                <div class="modal-body h6">
                                    <div class="row">
                                        <p class="text-dark"> <span class="text-dark-blue">
                                                @lang('Project name') : </span>
                                            {{ $gift_details->donationtype }}
                                        </p>
                                        <p class="text-dark"> <span class="text-dark-blue">
                                                @lang('Donation Amount') : </span>
                                            {{ $gift_details->donationAmt }}
                                        </p>
                                        <p class="text-dark"> <span class="text-dark-blue">
                                                @lang('Name') : </span>
                                            {{ $gift_details->giver_name }}
                                        </p>
                                        <p class="text-dark"> <span class="text-dark-blue">
                                                @lang('Mobile') : </span>
                                            {{ $gift_details->giver_mobile }}
                                        </p>
                                        <p class="text-dark"> <span class="text-dark-blue">
                                                @lang('Email') : </span>
                                            {{ $gift_details->giver_email }}
                                        </p>
                                        <p class="text-dark"> <span class="text-dark-blue">
                                                @lang('Send a copy of the card to my mobile phone') : </span>
                                            {{ $gift_details->sendCopy == 1 ? trans('yes') : trans('no') }}
                                        </p>
                                        <img src="{{ getImageThumb(@$gift_details->image) }}" class="rounded w-50"
                                            alt="gift">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn bg-danger btn-secondary"
                                        data-bs-dismiss="modal">@lang('Close')</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <script>
                        window.addEventListener('closemodal', (event) => {
                            itemId = event.detail;
                            console.log('#giftGivenEmpty' + itemId);
                            console.log(itemId);
                            $('#giftGivenEmpty' + itemId).modal().hide();
                            $('#giftGivenEmpty' + itemId).modal('hide');
                            $('.modal-backdrop').remove();
                        });
                    </script>
                @endif


                <button class="cart-item-remove" wire:click="removeItem({{ $itemCart->id }})"><i
                        class="fa fa-trash"></i></button>

            </div>
        @empty
            <div class="empty-cart-message">
                <h5> @lang('The cart is empty') </h5>
            </div>
        @endforelse

           @if (count($items))
                <a wire:click="emptyCart()" class="btn btn-sm btn-danger rounded">
                    @lang('Empty Cart')
                </a>
            @endif

    </div>

    @if (count($items))
        <div class="cart-main">
            <div class="cart-summary">
                <div class="cart-sub">
                    <div class="cart-total-label">
                        <svg xmlns="http://www.w3.org/2000/svg" width="318.055" height="47.886"
                            viewBox="0 0 318.055 47.886">
                            <path id="Path_48846" data-name="Path 48846"
                                d="M220.9,494.489a16.21,16.21,0,0,1,5.7-.921h3.726a3.353,3.353,0,0,1,2.457.789,3.285,3.285,0,0,1,.789,2.412,3.059,3.059,0,0,1-.789,2.324,3.353,3.353,0,0,1-2.457.789h-3.463a7.54,7.54,0,0,0-3.641.789,4.3,4.3,0,0,0-1.884,2.018,6.8,6.8,0,0,0-.484,2.763,5.833,5.833,0,0,0,.484,2.587,3.783,3.783,0,0,0,1.842,1.8,8.733,8.733,0,0,0,3.684.658h7.323a3.242,3.242,0,0,1,2.455.834,1.572,1.572,0,0,1,.395.526,3.224,3.224,0,0,1,.526,1.973q0,3.115-3.244,3.113H220.109q-4.3,0-5.481,2.807a6.521,6.521,0,0,0-.526,3.508,4.344,4.344,0,0,0,1.49,3.115h-7.278q-2.149-7.632,2.148-12.324a9.712,9.712,0,0,1,5.262-2.937,13.928,13.928,0,0,1-.613-1.536,15.212,15.212,0,0,1-.613-4.516,15.059,15.059,0,0,1,.613-4.473,9.219,9.219,0,0,1,5.788-6.1ZM247.188,493a10.825,10.825,0,0,1,4.736-1.008,10.692,10.692,0,0,1,4.692,1.053,10.06,10.06,0,0,1,3.376,2.807,16.641,16.641,0,0,1,3.157,8.946q.307,3.595.352,5.7h4.121v6.446H266a3.132,3.132,0,0,1-2.676-1.052,19.586,19.586,0,0,1-1.14,4.912,10.5,10.5,0,0,1-2.852,4.123q-3.464,3.024-10.13,3.2-3.331.131-4.56-.834a2.688,2.688,0,0,1-.965-1.316,3.4,3.4,0,0,1-.174-1.755,3.307,3.307,0,0,1,1.1-2.324,4.077,4.077,0,0,1,2.588-.7h.832a23.922,23.922,0,0,0,4.341-.263,4.694,4.694,0,0,0,3.115-2.675,6.977,6.977,0,0,0,.613-2.1,10.452,10.452,0,0,1-4.165.789,10.092,10.092,0,0,1-4.736-1.052,10.406,10.406,0,0,1-3.378-2.85A12.016,12.016,0,0,1,241.75,509a15.744,15.744,0,0,1-.7-4.736,16.023,16.023,0,0,1,.7-4.649,11.013,11.013,0,0,1,2.06-3.9,9.277,9.277,0,0,1,3.378-2.72Zm6.62,5.57a3.2,3.2,0,0,0-1.884-.658,4.074,4.074,0,0,0-1.931.571,3.929,3.929,0,0,0-1.316,1.358,7.053,7.053,0,0,0-.789,1.973,9.631,9.631,0,0,0-.263,2.238,11.639,11.639,0,0,0,.263,2.323,9.583,9.583,0,0,0,.789,2.279,5.132,5.132,0,0,0,1.316,1.755,2.707,2.707,0,0,0,1.931.7,3.009,3.009,0,0,0,1.884-.571,3.977,3.977,0,0,0,1.316-1.49,7.489,7.489,0,0,0,.789-2.062,12.674,12.674,0,0,0,.22-2.236,14.185,14.185,0,0,0-.22-2.324,9.046,9.046,0,0,0-.789-2.192,4.371,4.371,0,0,0-1.316-1.668Zm24.185,18.373H265.848v-6.446h12.146Zm10.395,0H276.241v-6.446h12.148Zm10.393,0H286.633v-6.446h12.148Zm10.393,0H297.026v-6.446h12.148Zm10.393,0H307.419v-6.446h12.148Zm10.393,0H317.814v-6.446H329.96Zm10.393,0H328.207v-6.446h12.146Zm10.395,0H338.6v-6.446h12.148Zm10.393,0H348.993v-6.446H361.14Zm10.393,0H359.385v-6.446h12.148Zm10.393,0H369.778v-6.446h12.148Zm10.393,0H380.173v-6.446h12.146Zm10.395,0H390.566v-6.446h12.148ZM417.842,492.3a10.619,10.619,0,0,1,4.647,1.008,10.316,10.316,0,0,1,3.378,2.763,13.244,13.244,0,0,1,2.06,3.991,14.481,14.481,0,0,1,.7,4.6,15.033,15.033,0,0,1-.7,4.692c-.146.411-.293.789-.439,1.14h3.991v6.446h-2.5q-3.288,0-3.289-3.245v-.219a9.383,9.383,0,0,1-3.2,2.544,11.282,11.282,0,0,1-4.647.919H400.959v-6.446h7.323a7.273,7.273,0,0,1-.526-1.358,15.056,15.056,0,0,1-.7-4.693,14.635,14.635,0,0,1,.7-4.647,12.173,12.173,0,0,1,2.062-3.86,9.548,9.548,0,0,1,3.332-2.674A10.579,10.579,0,0,1,417.842,492.3Zm1.884,6.489a3.2,3.2,0,0,0-1.884-.658,4,4,0,0,0-1.886.571q-2.851,1.8-2.281,6.359a6.875,6.875,0,0,0,2.281,4.823,2.849,2.849,0,0,0,1.886.7,3.256,3.256,0,0,0,1.884-.571q2.413-1.709,2.368-5.7-.088-3.771-2.368-5.525Zm22.124,18.155H429.7v-6.446h12.148Zm8.375-24.862h8.814a17.109,17.109,0,0,1,6.139,1.008,10.017,10.017,0,0,1,4.036,2.763,11.729,11.729,0,0,1,2.192,4.034,16.024,16.024,0,0,1,.7,4.649v5.963h3.947v6.446h-1.623a2.8,2.8,0,0,1-2.85-1.577,4.555,4.555,0,0,1-.526.658,4.462,4.462,0,0,1-3.026.919H440.1v-6.446h25.435v-6.27a6.518,6.518,0,0,0-.526-2.674,4.567,4.567,0,0,0-2.281-1.931,9,9,0,0,0-3.947-.7h-8.551a3.642,3.642,0,0,1-2.676-.878,3.528,3.528,0,0,1-.832-2.587,3.465,3.465,0,0,1,.832-2.544A3.672,3.672,0,0,1,450.226,492.079Zm6.27,29.95a4.367,4.367,0,0,1,1.8-.484,4.731,4.731,0,0,1,1.842.484,4.182,4.182,0,0,1,1.316,1.271,4.366,4.366,0,0,1,.482,1.8,4.455,4.455,0,0,1-.482,1.842,3.168,3.168,0,0,1-1.316,1.315,4.469,4.469,0,0,1-1.842.484,4.366,4.366,0,0,1-1.8-.484,3.655,3.655,0,0,1-1.271-1.315,3.765,3.765,0,0,1-.482-1.842,3.685,3.685,0,0,1,.482-1.8,2.961,2.961,0,0,1,1.271-1.271ZM491.185,492.3a10.632,10.632,0,0,1,4.649,1.008,10.311,10.311,0,0,1,3.376,2.763,13.247,13.247,0,0,1,2.06,3.991,14.483,14.483,0,0,1,.7,4.6,15.035,15.035,0,0,1-.7,4.692c-.146.411-.292.789-.437,1.14h3.989v6.446h-2.5q-3.288,0-3.289-3.245v-.219a9.4,9.4,0,0,1-3.2,2.544,11.3,11.3,0,0,1-4.649.919H474.3v-6.446h7.324a7.022,7.022,0,0,1-.526-1.358,15,15,0,0,1-.7-4.693,14.583,14.583,0,0,1,.7-4.647,12.172,12.172,0,0,1,2.06-3.86,9.553,9.553,0,0,1,3.333-2.674A10.572,10.572,0,0,1,491.185,492.3Zm1.886,6.489a3.209,3.209,0,0,0-1.886-.658,4.012,4.012,0,0,0-1.886.571q-2.851,1.8-2.279,6.359a6.874,6.874,0,0,0,2.279,4.823,2.85,2.85,0,0,0,1.886.7,3.261,3.261,0,0,0,1.886-.571q2.411-1.709,2.368-5.7-.091-3.771-2.368-5.525Zm16.158-14.645q0-3.288,3.244-3.289a3.116,3.116,0,0,1,2.368.832,3.331,3.331,0,0,1,.834,2.457v28.766a4.128,4.128,0,0,1-.965,3.026,3.55,3.55,0,0,1-2.763,1.008h-8.9v-6.446h6.183V484.141Zm9.932.7q0-3.243,3.246-3.244t3.244,3.244V513.7a3.329,3.329,0,0,1-.834,2.455,4.079,4.079,0,0,1-4.823,0,3.322,3.322,0,0,1-.834-2.455V484.841Z"
                                transform="translate(-207.597 -480.852)" fill="#59706c" />
                        </svg>
                    </div>
                    <div class="cart-total-value">
                        <span>{{ $total }}</span>
                        <span class="currency">
                            <svg xmlns="http://www.w3.org/2000/svg" width="54.345" height="55.829"
                                viewBox="0 0 54.345 55.829">
                                <path id="Path_53483" data-name="Path 53483"
                                    d="M216.155,580.734a24.98,24.98,0,0,1,.99-3.924,18.321,18.321,0,0,1,.932-2.309l17.3-3.595v-8.155l-15.991,3.342c-.443-.981,1.132-6.56,1.71-6.914l14.19-3.106.094-25.205c.261-1.36,4.786-4.827,6.265-5.337v29.275l6.389-1.451.133-19.522a20.749,20.749,0,0,1,6.226-5.164v23.1l.43.231,15.664-3.155a22.588,22.588,0,0,1-1.886,6.686L254.4,558.57v6.482l16.091-3.346a22.055,22.055,0,0,1-1.781,6.686l-20.58,4.6V560.033l-6.457,1.275-.162,8.307c-2.793,4.139-3.216,6.955-8.425,8.3-5.552,1.431-11.314,2.292-16.93,3.447.014-.206-.021-.423,0-.627"
                                    transform="translate(-216.148 -525.532)" fill="#59706c" />
                            </svg>
                        </span>
                    </div>
                </div>
                <button class="cart-checkout-btn"
                    onclick="window.location.href='{{ route('site.checkout.show') }}'">المتابعة للدفع</button>
            </div>
         
        </div>


    @endif

</div>
