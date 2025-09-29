@extends('site.app')

@section('title', @$settings->getProductsData('meta_title_' . $current_lang))
@section('meta_key', $settings->getProductsData('meta_key_' . $current_lang))
@section('meta_description', $settings->getProductsData( 'meta_description_' . $current_lang))


@section('content')

<div class="container mt-3">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-block px-3 wow bounceInUp">
                    <nav>
                        <ol class="breadcrumb ms-5 ms-md-0">
                            <img src="{{site_path('img/favicon.ico')}}" class="mx-2" alt="">
                            <li class="breadcrumb-item">
                                <a href="{{ route('site.home') }}"> @lang('Home') </a>
                            </li>
                            <li class="breadcrumb-item">
                                {{ json_decode(@$settings->getProductsData($current_lang))->title }}
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>

<!--Project Banner secation-->
<div class="ProjectBanner mt-1">
    <div class="container">
        <div class="row mt-3 text-center rounded wow bounceInDown">
            <div class="col-12 banner text-center mt-2">
                <img src="{{ getImage( @$settings->getProductsData('cover_image') ) }}" class="border border-3" alt="@lang('Charitable gifting')" />
                <h1 class="my-5 text-main">
                    {{ json_decode(@$settings->getProductsData($current_lang))->title }}
                </h1>
                <p class="fs-5">
                    {!! json_decode(@$settings->getProductsData($current_lang))->description !!}
                </p>
            </div>
        </div>
    </div>
    <hr>
</div>
<!--Project Banner secation-->


<section id="projects">
    <div class="container mt-3">
        <div class="projects-body">
            <div class="row my-3">
                <livewire:site.home.charity-gifts :pageCount="12" />
            </div>
        </div>
    </div>
</section>


@endsection
