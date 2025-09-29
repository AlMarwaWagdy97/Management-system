@extends('site.app')

@section('title', __('Vendor Dashboard'))

@section('content')

<div class="profile">
    <div class="container bg-light mt-5 border-main">
        <div class="row gx-2">

            <x-site.referer.side-menu />

            <!--edit section -->
            <div class="col-12 order-lg-2 order-2 col-lg-9 mx-auto">
                <div class="info row px-3 bg-white m-md-4 border-main">
                    <h1 class="col-12 fs-2 text-center mt-5" dir="rtl"> @lang('personal account information')</h1>
                    <div class="row personl_info mt-5 mb-3">
                        <p type="text" class="border-0 col-10 fs-4" dir="rtl" id=""> {{ @$refer->name }}</p>
                        <i class="icofont-user-alt-3 col-2 fa-user-pen fs-2"></i>
                    </div>
                    <hr class="spater" />
                    <div class="row personl_info mt-2 mb-3">
                        <p type="text" class="border-0 col-10 fs-4" dir="rtl" id=""> {{ $refer->account->mobile }} </p>
                        <i class="icofont-phone fa-envelope col-2 fs-2 mt-2"></i>
                    </div>
                    <hr class="spater" />
                    <div class="row personl_info mt-2 mb-3">
                        <p type="text" class="border-0 col-10 fs-4" dir="rtl" id=""> {{ $refer->account->email }} </p>
                        <i class="icofont-envelope fa-envelope col-2 fs-2 mt-2"></i>
                    </div>
                </div>
                <div class="info  row px-5 bg-white m-md-5 border-main">
                    <div class="row">
                        <div class="col-md-12">
                            <h1 class="fs-6 text-md-end text-center pt-5" dir="rtl">
                                @lang('Statistics')
                            </h1>
        
                            <div class="numbers row py-2 mb-4" dir="rtl">
                                <div class="numerOfdonamtion col-md-5 col-12 me-1 bg-main rounded-3 text-center">
                                    <h1 class="fs-1 mt-3"> {{ count($orders) }} </h1>
                                    <p class="fs-4" dir="rtl"> @lang('Number of donates') </p>
                                </div>
        
                                <div class="col-1">
                                    <!--extra div-->
                                </div>
        
                                <div class="totalAmount col-md-5 col-12 mt-md-0 bg-main rounded-3 text-center">
                                    <h1 class="fs-1 mt-3"> {{ $orders->sum('total') }} </h1>
                                    <p class="fs-4" dir="rtl"> @lang('Total Amount') </p>
                                </div>
                            </div>
                        </div>

                       
                    </div>
                  
                    
                   



                </div>
            </div>
            <!--edit section -->

        </div>
    </div>
</div>


@endsection
