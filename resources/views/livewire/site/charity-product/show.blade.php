<section id="projects">
    <div class="container mt-5">
        <div class="projects-body row mb-5">
            <!-- project -->
            <div class="col-lg-5 wow bounceInRight">
                <div class="project shadow">
                    <div class="header d-flex">
                        <h5 class="project-title">
                            <a title="#">
                                {{$product->trans?->where('locale', $current_lang)->first()->title}}
                            </a>
                        </h5>
                        <ul class="project-social p-0 nav flex-column" data-bs-toggle="collapse" href="#socialShare1" role="button" aria-expanded="false" aria-controls="socialShare1">
                            <a class="social-share nav-link active">
                                <i class="icofont-share"></i>
                            </a>
                            <span class="collapse toggelShare" id="socialShare1">
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ route('site.charity-product.show', $product->trans?->where('locale', $current_lang)->first()->slug) }}" target="blank" class="nav-link">
                                    <i class="icofont-facebook"></i>
                                </a>
                                <a href="https://wa.me/?text=" target="blank" class="nav-link">
                                    <i class="icofont-brand-whatsapp"></i>
                                </a>
                                <a href="mailto:?&subject=&cc=&bcc=&body={{ route('site.charity-product.show',  $product->trans?->where('locale', $current_lang)->first()->slug) }}" target="blank" class="nav-link">
                                    <i class="icofont-envelope"></i>
                                </a>
                                <a target="blank" class="nav-link">
                                    <i class="icofont-twitter"></i>
                                </a>
                            </span>
                        </ul>

                    </div>

                    <div class="projects-show">

                        @if(json_decode($product['image'], true) != null)
                        <div class="container">
                            <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel" data-interval="10000">
                                <div class="carousel-indicators">
                                    @forelse (json_decode($product['image'], true)??[] as $key => $img)
                                    <button type="button" data-bs-target="#carouselExampleIndicators" class="{{$key == 0 ? 'active' : null }}" data-bs-slide-to="{{ $key }}" aria-label="Slide {{ $key }}"></button>
                                    @empty
                                    @endforelse
                                </div>
                                <div class="carousel-inner">
                                    @forelse (json_decode($product['image'], true)??[] as $key => $img)
                                    <div class="carousel-item {{$key == 0 ? 'active' : null}}">
                                        <img src="{{ asset(pathImage($img)) }}" class="d-block w-100" alt="{{$product->title}}" width="100%">
                                    </div>
                                    @empty
                                    @endforelse
                                </div>
                                <!-- slider content  -->

                                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            </div>
                        </div>
                        @else
                        <div class="item text-center">
                            <img class="" src="{{ getImage($product['cover_image'])}}" alt="{{$product->trans?->where('locale', $current_lang)->first()->description}}">
                        </div>
                        @endif

                    </div>

                    <div class="project-description m-4">
                        <h5 class="card-title main-donation">
                            {!!$product->trans?->where('locale', $current_lang)->first()->description!!}
                        </h5>
                    </div>

                </div>
            </div>

            <!-- gift data  -->
            <div class="col-lg-7 wow bounceInLeft">
                <div class="card project-details">
                    <div class="card-body">

                        @livewire('site.auth.index', ['type' => 'project'])


                        {{-- gift user  ------------------ --}}
                        <div class="gifted-user my-3">
                            <div class="row">
                                <h5 class="fs-6 text-center">بيانات المهدى اليه</h5>
                                <div class="mb-3 row">
                                    <label for="input-1" class="col-sm-2 col-form-label">@lang('Name')</label>
                                    <div class="col-sm-10">
                                        <input type="text" wire:model.defer="giver_name" class="form-control">
                                        @error('giver_name')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="input-2" class="col-sm-2 col-form-label">@lang('Mobile')</label>
                                    <div class="col-sm-10">
                                        <input id="phone" type="tel" wire:model.defer="giver_mobile" dir="rtl" class="form-control phone numberInput" placeholder="5XXXXXXXX" data-inputmask="'mask': '9999999999'"
                                            maxlength="9" oninput="this.value = this.value.replace(/[^0-9]/g, '');" />
                                        @error('giver_mobile')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror

                                    </div>
                                </div>
                                {{-- <div class="mb-3 row">
                                    <label for="input-2" class="col-sm-2 col-form-label">@lang('Email')</label>
                                    <div class="col-sm-10">
                                        <input type="email" wire:model.defer="giver_email" class="form-control">
                                        @error('giver_email')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div> --}}

                                <div class="mb-3 row">
                                    <label for="input-3" class="col-sm-2 col-form-label">@lang('Address')</label>
                                    <div class="col-sm-10">
                                        <input type="text" wire:model.defer="giver_address" class="form-control">
                                        @error('giver_address')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                {{-- <div class="mb-3 row">
                                    <label for="input-4" class="col-sm-2 col-form-label">@lang('Gift message')</label>
                                    <div class="col-sm-10">
                                        <textarea wire:model.defer="giver_message" class="form-control" rows="3">{{ $giver_message }}</textarea>
                                        @error('giver_message')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div> --}}


                            </div>
                        </div>

                        <hr>

                        {{-- gift cards  ------------------ --}}

                        <div class="gift-carts mb-3">
                            <div class="row m-3">
                                <label class="form-check-label checkbox-label">
                                    <input class="form-check-input" wire:model="giftCartStatus" type="checkbox" data-bs-toggle="collapse" data-bs-target="#gift-body">
                                    <span class="checkbox"></span>
                                    @lang('Add a gift card')
                                </label>
                            </div>
                            @if($this->giftCartStatus)
                                <div class="my-4 row ">
                                    <div class="col-lg-6 col-12">
                                        <div class="row">
                                            <label class="col-lg-4 col-12 col-form-label"> @lang('Gifting occasions') </label>
                                            <select wire:model="selectedCardCategories" wire:change="updateCards" class="form-select col-lg-6 col-12 w-50 bg-main gift-input">
                                                <option value=""></option>
                                                @forelse($cardCategories as $key => $cardCategory)
                                                <option value="{{$cardCategory->id}}">{{ $cardCategory->translate($current_lang)->title }}</option>
                                                @empty
                                                @endforelse
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-12">
                                        <div class="row">
                                            <label class="col-lg-4 col-12 col-form-label"> @lang('Donation field') </label>
                                            <select wire:model="selectedCardOcassions" wire:change="updateCards" class="form-select col-lg-6 col-12 w-50 w-md-100 bg-main gift-input">
                                                <option value=""></option>
                                                @forelse($cardOcassions as $key => $cardOcassion)
                                                <option value="{{$cardOcassion->id}}">{{ $cardOcassion->translate($current_lang)->title }}</option>
                                                @empty
                                                @endforelse
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                @if($selectedCardCategories != null || $selectedCardOcassions != null)
                                    <h4 class="fs-6 text-center">اختر بطاقة الإهداء</h4>
                                    <div class="gifts owl-carousel owl-rtl owl-loaded owl-drag mb-3 text-center">
                                        @forelse($cards??[] as $key => $card)
                                        <div class="gift-item">
                                            <a href="{{ getImage($card->image) }}" target="_blank">
                                                <img src="{{ getImageThumb($card->image) }}" alt="" width="100%" class="rounded-3">
                                            </a>
                                            <label for="gift-{{ $key }}" class="radio-label">
                                                <input type="radio" id="gift-{{ $key }}" value="{{ $card->id }}" wire:model.lazy="selectedCard"  required="">
                                                <span class="radio"></span>
                                            </label>
                                        </div>
                                        @empty
                                            <span class="text-danger"> @lang('Please Select Category and Occasions')</span>
                                        @endforelse
                                    </div>
                                    @error('selectedCard')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                @endif

                                <hr>
                            @endif


                        </div>



                        {{-- Gift Projects --}}
                        <div class="gift-project my-4">
                            <div class="row m-3">
                                {{-- <label class="form-check-label checkbox-label">
                                    <input class="form-check-input" wire:model="giftProjectStatus" type="checkbox" data-bs-toggle="collapse" data-bs-target="#gift-body">
                                    <span class="checkbox"></span>
                                    @lang('Add a donation')
                                </label> --}}
                            </div>
                            @if($giftProjectStatus)
                                <div class="row">
                                    <h5 class="fs-6 text-center"> تبرع في مشروع </h5>
                                    <div class="gift-project-item mb-3">
                                        <select class="form-select" wire:model="selectedProject" >
                                            <option value="">@lang('Choose project')</option>
                                            @forelse ($projects as $key => $project)
                                            <option value="{{$project->id }}">
                                                {{ $project->trans?->where('locale', $current_lang)->first()->title }}
                                            </option>
                                            @empty

                                            @endforelse
                                        </select>
                                    </div>

                                    @if(is_array($donation))
                                        @switch($donation['type'])
                                        @case('unit')
                                            <div class="options my-3">
                                                @foreach ($donation['data'] as $key => $data)
                                                <div class="option-item">
                                                    <label data-toggle="tooltip" data-placement="top" title="{{ $data['name'] }}" class="{{ $colorsAmount[$key % count($colorsAmount??[])] }} {{ $unitValueRadio == json_encode($data) ? 'active' : null }} {{ $data['value'] == $donationAmt ? 'active' : null }}" >
                                                        <input wire:model.live="unitValueRadio" type="radio" value="{{ json_encode($data) }}" >
                                                        <h6 class="title">{{ $project['title'] }} </h6>
                                                        <div class="price">
                                                            {{ $data['value'] }}
                                                            <small> &#65020;</small>
                                                        </div>
                                                    </label>
                                                </div>
                                                @endforeach
                                                <div class="mx-2">
                                                    <input type="number" wire:model.live="unitValueInput" min="0" class="form-control" placeholder="@lang('Another amount')" >
                                                </div>
                                            </div>
                                        @break

                                        @case('share')
                                            <div class="options my-3">
                                                @foreach ($donation['data'] as $key => $data)
                                                <div class="option-item">
                                                    <label data-toggle="tooltip" data-placement="top" title="{{ $data['name'] }}" class="{{ $colorsAmount[$key % count($colorsAmount ?? [])] }}  rounded-6 d-flex flex-row gap-1 {{ $shareValue == json_encode($data) ? 'active' : null }} {{ $data['value'] == $donationAmt ? 'active' : null }}">
                                                        <input wire:model.live="shareValue" type="radio" value="{{ json_encode($data) }}" >
                                                        <h6 class="title">{{ $data['name'] }}</h6>
                                                        <div class="price">
                                                            <span>{{ $data['value'] }}</span>
                                                            <small> &#65020;</small>
                                                        </div>
                                                    </label>
                                                </div>
                                                @endforeach
                                            </div>
                                        @break

                                        @case('fixed')
                                            <div class="options my-3">
                                                <div class="option-item">
                                                    <label title="{{ $project['title'] }}" class="bg-secound active" >
                                                        <h6 class="title">{{ $project['title'] }} </h6>
                                                        <div class="price">
                                                            {{ $donation['data'] }}
                                                            <small> &#65020;</small>
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                        @break

                                        @case('open')
                                            <div class="options my-3">
                                                <div class="option-item">
                                                    <input type="number" wire:model="openValue" min="0" class="form-control amount" placeholder="@lang('Donation Amount')" >
                                                </div>
                                            </div>
                                        @break

                                        @default
                                            <span>Something went wrong, please try again</span>
                                        @endswitch
                                    @endif

                                    @error('donationAmt')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            @endif
                        </div>


                        {{-- Donation  ------------------ --}}
                        <div class="donation-now mt-3 mb-3">
                            <input type="number" class="form-control" min="0" disabled value="{{  @$donationAmt + @$productPrice}}" />
                            <button wire:click="donateNow()" class="bg-main btn" {{ $mustLogin ? 'disabled':'' }}>
                                @lang('Donate Now')
                            </button>
                            <button wire:click="addToCart" class="bg-secound btn" {{ $mustLogin ? 'disabled':'' }}>
                                <i class="icofont-cart-alt"></i>
                            </button>
                        </div>

                        {{-- @include('site.layouts.cart-msg') --}}

                    </div>
                </div>
            </div>


        </div>
    </div>
    @livewire('site.carts.add-modal')




</section>


@section('script')
<script>
    $(".gifts").trigger('destroy.owl.carousel').owlCarousel({
        rtl: true
        , loop: false
        , margin: 10
        , nav: false
        , dots: true
    , });

    window.addEventListener('owlCarouselUpdate', event => {
        setTimeout(() => {
            console.log("gifts");
            $(".gifts").trigger('destroy.owl.carousel').owlCarousel({
                rtl: true
                , loop: false
                , margin: 10
                , nav: false
                , dots: true
            , });
        }, 0); // Adjust the delay as needed
    });

</script>
@endsection
