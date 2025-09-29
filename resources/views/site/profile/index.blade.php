@extends('site.app')
@section('title', __('Profile'))

@section('content')

    <main>
        <div class="profile-container ">
            <div class="container card py-5 mt-3">
                <div class="row">
                    <!-- Sidebar Navigation -->

                    <x-site.profile.side-menu />

                    <!-- Main Content -->
                    <div class="col-md-8">
                        <!-- Personal Info Section (Hidden) -->
                        <div class="profile-content" id="personal-info-content">
                            <!-- Profile Header -->
                            <div class="profile-header mb-4">
                                <h2 class="section-title fs-2"> @lang('personal account information') </h2>
                            </div>

                            <div class="profile-info-card card gap-3 p-3">
                                <div class="profile-info-item">
                                    <div class="row align-items-center">
                                        <div class="col-md-4  profile-info-label">@lang('Name') </div>
                                        <div class="col-md-8 profile-info-value">{{ $donor->full_name }} </div>
                                    </div>
                                </div>

                                <div class="profile-info-item">
                                    <div class="row align-items-center">
                                        <div class="col-md-4 profile-info-label"> @lang('Mobile') </div>
                                        <div class="col-md-8 profile-info-value"> {{ $donor->account->mobile }} </div>
                                    </div>
                                </div>

                                <div class="profile-info-item">
                                    <div class="row align-items-center">
                                        <div class="col-md-4 profile-info-label">
                                            @lang('Email')
                                        </div>
                                        <div class="col-md-8 profile-info-value">
                                            {{ $donor->account->email }}
                                        </div>
                                    </div>
                                </div>

                                <div class="profile-actions mt-4 text-center">
                                    <a href="{{ route('site.profile.edit') }}" class="btn btn-primary edit-profile-btn">
                                        @lang('Edit') </a>
                                </div>
                            </div>

                         

                          
                            <!-- STATISTICS -->
                            <div class="statistics-header ">تبرعاتي</div>
                            <div class="statistics-container p-5">


                                <div class="statistic card">
                                    <div class="statistic-title"> @lang('Total Amount') </div>

                                    <div class="statistic-value">{{ $orders->sum('total') }}</div>
                                    <div class="statistic-currency">ر.س</div>
                                </div>

                                <div class="statistic card">
                                    <div class="statistic-title">@lang('Number of donates')</div>

                                    <div class="statistic-value">{{ $orders->sum('total') }}</div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

@endsection


<style>
    body {
        background-color: #ffffff !important;
    }
</style>