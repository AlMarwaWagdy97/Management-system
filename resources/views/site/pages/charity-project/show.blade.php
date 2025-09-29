@extends('site.app')

@section('title', @$project->trans?->where('locale', $current_lang)->first()->title)
@section('meta_key', @$project->trans?->where('locale', $current_lang)->first()->meta_key)
@section('meta_description', @$project->trans?->where('locale', $current_lang)->first()->meta_description)

@section('content')

    <main>
        <div class="container  project-page">
            {{-- <div class="project-header">
                <figure class="head-img-container">
                    <img src="\site\img\leave.png" alt="">
                </figure>
                <div class="project-header-content">
                    قال رسول الله ﷺ : ( من فطر صائمًا كان له مثل أجره )
                    <br>
                    وجبة إفطار منك تٌطعم صائمًا و يكتب ثوابها لك ..
                </div>
            </div> --}}

            <div class="row mt-5 ms-5">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item h2 display-6"><a href="{{ route('site.home') }}"> الرئيسية </a></li>
                        <span class="split-page"> / </span>
                        <li class="breadcrumb-item h2 display-6"><a href="{{ route('site.projectCategories.show', $project->categories?->first()->transNow?->slug ) }}"> {{ $project->categories?->first()->transNow?->title }} </a></li>
                        <span class="split-page"> / </span>
                        <li class="breadcrumb-item active h2 display-6"> {{ $project->transNow?->title  }} </li>
                    </ol>
                </nav>
            </div>

            <livewire:site.charity-project.show :project="$project" :amount="$amount" />
        </div>
        </main>

    @endsection
