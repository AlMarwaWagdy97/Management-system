@extends('site.app')
@section('title', "volunteers")


@section('content')

<!--VolunteeringPage-->
<div class="VolunteeringPage px-0 py-5">
    <div class="container justify-content-center align-items-center align-contenet-center text-center">
        <div class="Farm mx-auto px-lg-5 px-1 py-4 rounded">

            <h5 class="text-end me-lg-5">
                <a class="text-gray fw-bold" href="{{ route('site.volunteering.index') }}"> @lang('volunteers.volunteering')</a> /
                @lang('volunteers.Learn_volunteering') @lang('volunteers.in_birrukum')
            </h5>

            <div class="container">
                <div class="row justify-content-evenly my-5">

                    <!--Volunteering_achievements -->
                    <div class="col-12 col-lg-6">
                        <div class="Volunteering_achievements border mx-auto text-center px-3">
                            <div class="title bg-main text-center my-5 mx-auto border">
                                <h4 class="m-3"> @lang('volunteers.volunteering_achievements') </h4>
                            </div>

                            @forelse($achievements as $key => $achievement)
                            <div class="Number_Volunteering d-flex justify-content-center align-items-center text-center my-4 mx-2">
                                {{-- <i class="icofont-users order-3 mx-lg-2 mx-0 me-3 ms-2"></i> --}}
                                <img src="{{ getImage($achievement['image']) }}" class="img-fluid rounded-top  order-1 mx-lg-2 mx-0 me-3 ms-2" width="10%" />

                                <div class="info px-lg-0 py-lg-4 py-1 order-2">
                                    <span>
                                        {{ $achievement['title_ar'] }}
                                    </span>
                                </div>
                                <div class="number bg-main order-3 p-lg-3 py-lg-2 px-1">
                                    <h4>
                                        {{ $achievement['number'] }}
                                        <small> {{ $achievement['item'] }} </small>
                                    </h4>
                                </div>
                            </div>
                            @empty
                            @endforelse

                        </div>
                    </div>
                    <!--Volunteering_achievements -->


                    <!--Volunteering_nitiative -->
                    <div class="col-12 col-lg-6 p-2">
                        <div class="Volunteering_nitiative border mx-auto text-center px-lg-5 mb-5 mb-lg-0">
                            <div class="title bg-main text-center my-5 mx-auto border">
                                <h4 class="m-3">  @lang('volunteers.volunteering_achievements')</h4>
                            </div>

                            <div class="x d-felx justify-content-lg-around align-items-center mb-5">
                                @forelse($initiatives as $key => $initiative)
                                    <div class="nitiatives justify-content-center align-items-center text-center my-3">
                                        <a href="{{ $initiative['link'] }}" class="btn mx-auto" target="_blank">
                                           {{ $initiative['title_ar'] }}
                                        </a>
                                    </div>
                                @empty
                                @endforelse
                            </div>
                        </div>
                    </div>
                    <!--Volunteering_nitiative -->


                </div>
                {{-- <div class="row ms-5 text-start">
                    <div class="col-12">
                        <button class="d-flex align-contenet-center justify-content-center align-items-center border-0">
                            <i class="fa-solid fa-caret-left me-2"></i>
                            <h4 class="mb-0">السياسات واللوائح</h4>
                        </button>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>
</div>
<!--VolunteeringPage-->

@endsection
