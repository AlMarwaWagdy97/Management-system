@extends('site.app')

@section('title', @$page->trans->where('locale', $current_lang)->first()->meta_title)
@section('meta_key', @$page->trans->where('locale', $current_lang)->first()->meta_key)
@section('meta_description', @$page->trans->where('locale', $current_lang)->first()->meta_description)


@section('content')


{{-- <section>
    <div class="container mt-5">

        <h2 class="text-center">
            {{ $page->title }}
        </h2>

        <div class="row mt-5">

            <div class="col-md-6">
                <p>{!! $page->content !!}</p>
            </div>
            <div class="col-md-6">
                <img src="{{ getImage($page->image) }}" alt=" {{ $page->title }}">
            </div>
        </div>

    </div>
</section> --}}

  <main>
        <div class="hawkama-container">
          <div class="hawkama-content">
            <div class="row">
              
              <div class="col-md-8 col-lg-9 governance-sections">

                <div class="governance-section">
                  <h2 class="section-title">  {{ $page->title }}</h2>
                 <p>{!! $page->content !!}</p>
                </div>
                
           
              </div>

              <div class="col-md-4 col-lg-3">
                <div class="logo-section">
                  <img src="{{ getImage($page->image) }}" alt="شعار جمعية يدا بيد للخدمات الإنسانية" class="img-fluid">
                  <!-- <h1 class="organization-name">جمعية يدا بيد<br>للخدمات الإنسانية</h1> -->
                </div>
              </div>

            </div>
          </div>
        </div>
      </main>



@endsection
