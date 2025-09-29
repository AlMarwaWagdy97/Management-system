@extends('site.app')

@section('title', @$product->trans?->where('locale', $current_lang)->first()->title)
@section('meta_key', @$product->trans?->where('locale', $current_lang)->first()->meta_key)
@section('meta_description', @$product->trans?->where('locale', $current_lang)->first()->meta_description)

@section('content')

<div class="container mt-3">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-block px-3 wow bounceInUp">
                    <nav>
                        <ol class="breadcrumb ms-5 ms-md-0">
                            <img src="{{ site_path('img/favicon.ico')}}" class="mx-2" alt="">
                            <li class="breadcrumb-item"><a href="{{ route('site.home') }}"> @lang('Home') </a></li>
                            <li class="breadcrumb-item">
                               <a href="{{ route('site.charity-products.index') }}">
                                    {{ json_decode(@$settings->getProductsData($current_lang))->title }}
                               </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page"> {{ $product->trans?->where('locale', $current_lang)->first()->title }} </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>

<livewire:site.charity-product.show :product="$product"/>
@endsection