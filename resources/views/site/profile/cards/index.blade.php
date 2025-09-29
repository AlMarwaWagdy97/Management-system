@extends('site.app')
@section('title', __('Payment Cards'))
@section('content')


<main class="ProfileSection">
<div class="profile">
    <div class="container bg-light mt-5 border-main">
        <div class="row gx-2">

            <x-site.profile.side-menu />

            <!--edit section -->
            <div class="col-12 order-lg-2 order-2 col-lg-9 mx-auto ">
                <div class="Visa">
                    <div class=" info row px-md-5 bg-white m-md-4">
                        <h1 class="col-12 fs-4 text-end mt-5"> @lang('Payment Cards') </h1>

                        <hr class="spater" />

                        <div class="VisaDiv rounded-3 col-12 my-5">

                            <div class="row">

                                @forelse ($creditCards as $card)
                                    <div class="col-12 col-lg-6 mt-3 mb-3 text-center" dir="ltr">
                                        <div class="card my-2 my-md-0 position-relative fs-5  ">

                                            <div class="headOfCard row  justify-content-around align-content-center mt-5">
                                                <img class="col-2 " src="{{ site_path('img/visa/1.png') }}" alt="">
                                                <div class="col-5 img-fluid  visaLogo" id="visaLogo"></div>
                                            </div>

                                            <div class="NumberOfCard row justify-content-center mt-3  mx-auto">

                                                <div class="dots col-3 d-flex  my-auto">
                                                    <div class="dot me-1"></div>
                                                    <div class="dot me-1"></div>
                                                    <div class="dot me-1"></div>
                                                    <div class="dot me-1"></div>
                                                </div>

                                                <div class="dots col-3 d-flex my-auto">
                                                    <div class="dot me-1"></div>
                                                    <div class="dot me-1"></div>
                                                    <div class="dot me-1"></div>
                                                    <div class="dot me-1"></div>
                                                </div>

                                                <div class="dots col-3 d-flex  my-auto">
                                                    <div class="dot me-1"></div>
                                                    <div class="dot me-1"></div>
                                                    <div class="dot me-1"></div>
                                                    <div class="dot me-1"></div>
                                                </div>

                                                <div class="col-3 fs-6">{{ substr((@$card->number), -4) }}</div>
                                            </div>

                                            <div class="card-date mx-3">
                                                <p>{{  decrypt(@$card->expired_year) }} / {{ decrypt(@$card->expired_month) }}</p>
                                                <p> {{ base64_decode(@$card->name) }} </p>
                                            </div>

                                        </div>
                                        <form action="{{ route('site.profile.cards.delete', $card->id) }}" method="POST" class="text-start mt-1">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" onclick="return confirm('Are you sure?') ? true : false" class="btn btn-sm btn-danger"> @lang('Delete') </button>
                                        </form>
                                    </div>
                                @empty
                                    <div class="messageNoCard custom-border bg-light d-flex p-2 my-3 rounded-3">
                                        <i class="icofont-exclamation-tringle mx-2"></i>
                                        <span> @lang('You do not have payment cards registered') </span>
                                    </div>
                                @endforelse



                                <a class="btn bg-main col col-xl-6  fs-5 mx-3 text-center text-white" href="{{ route('site.profile.cards.add') }}" role="button">
                                    <i class="fa-solid fa-plus ms-3"></i>
                                    @lang('Add Payment Cards')
                                </a>

                            </div>

                        </div>

                    </div>
                </div>

            </div>

        </div>
    </div>
</div>
</main>
@endsection
