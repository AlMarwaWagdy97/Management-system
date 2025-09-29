@extends('site.app')

@section('title', @$item->trans->where('locale', $current_lang)->first()->meta_title)
@section('meta_key', @$item->trans->where('locale', $current_lang)->first()->meta_key)
@section('meta_description', @$item->trans->where('locale', $current_lang)->first()->meta_description)


@section('content')

<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-block px-3">
                  <nav>
                    <ol class="breadcrumb ms-5 m-3 ms-md-0">
                      <img src="{{site_path('img/favicon.ico')}}" class="mx-2" alt="">
                            <li class="breadcrumb-item">
                                <a href="{{ route('site.home') }}"> @lang('Home') </a>
                            </li>
                            <li class="breadcrumb-item">
                                @lang('Page')
                            </li>
                            <li class="breadcrumb-item">
                                {{ $item->title }}
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>


<section>
    <div class="container mt-5">

        <h2 class="text-center">
            {{ $item->trans->first()->title }}
        </h2>
        <div class="row mt-5">
            <div class="col-md-6">
                <p>{!! $item->trans->first()->description !!}</p>
            </div>
            <div class="col-md-6 my-5">
                <img src="{{ getImage($item->image) }}" alt=" {{ $item->trans->first()->title }}">
            </div>
        </div>

    </div>
</section>

@endsection
