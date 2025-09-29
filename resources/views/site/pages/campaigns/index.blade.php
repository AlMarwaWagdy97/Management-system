@extends('site.app')

@section('title', @$campaign->getCustomCampaignData('meta_title_' . $current_lang))
@section('meta_key', $campaign->getCustomCampaignData('meta_key_' . $current_lang))
@section('meta_description', $campaign->getCustomCampaignData( 'meta_description_' . $current_lang))


@section('content')

<div class="container mt-3">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-block px-3">
                    <nav>
                        <ol class="breadcrumb ms-5 ms-md-0">
                            <img src="{{site_path('img/favicon.ico')}}" class="mx-2" alt="">
                            <li class="breadcrumb-item">
                                <a href="{{ route('site.home') }}"> @lang('Home') </a>
                            </li>
                            <li class="breadcrumb-item">
                                @lang('campaign')
                            </li>
                            <li class="breadcrumb-item">
                                {{ @json_decode($campaign->getCustomCampaignData('ar'))->campaign_name }}
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>


<section>
    <div class="container my-5">

        <div class="card p-5">
            <h2 class="text-center text-success">
                {{ json_decode($campaign->getCustomCampaignData('ar'))->campaign_name }}
            </h2>

            <div class="row mt-5">
                <div class="col-md-6">
                    <p>{!! json_decode($campaign->getCustomCampaignData('ar'))->description !!}</p>
                </div>
                <div class="col-md-6">
                    <img src="{{ getImage( @$campaign->getCustomCampaignData('image')) }}" alt=" {{ json_decode($campaign->getCustomCampaignData('ar'))->campaign_name }}">
                </div>
            </div>
        </div>

        <div class="row my-5">
            @livewire('site.campaign.form')
        </div>

    </div>
</section>

@endsection
