@extends('site.app')

@section('title', @$category->transNow->meta_title)
@section('meta_key', @$category->transNow->meta_key)
@section('meta_description', @$category->transNow->meta_description)

@section('content')

<main>
    <section class="sections home">
        <div class="category-container">
            <p class="title text-center"> {{ @$category->trans->first()->title }}</p>
            <div class="SectionSwiper mt-5">
                <div class="swiper ProjectSections">
                    <div class="wrapper">
                        <div class="slide ">
                            <div class="category-content Card">
                                <img src="{{ asset(getImage($category['background_image']) ?? 'site/img/icon3.png') }}" class="category-img" alt="{{ @$category['trans'][0]['title'] }}" />
                                {{-- <img src="{{ asset(getImage($category->image) ?? 'site/img/icon3.png') }}" class="sub-category-img" alt="{{ @$category->trans->first()->title }}" /> --}}
                                {{-- <div class="category-desc">
                                    {{ @$category->trans->first()->title }}
                                </div> --}}
                                @if(strlen($title = @$category->trans->first()->title ) > 10 )
                                    <div class="category-desc category-title">
                                        {{$title }}
                                    </div>
                                @else
                                    <div class="category-desc">
                                        {{ $title }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="RamdanProjects mt-2">
        <div class="container pb-2 text-center">
            <h2> {!! @$category->trans->first()->description !!} </h2>

            @livewire('site.charity-category.show', ['category' => $category])

        </div>
    </section>

</main>
@endsection
