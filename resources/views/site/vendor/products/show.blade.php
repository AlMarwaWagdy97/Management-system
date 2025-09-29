@extends('site.app')

@section('title', __('Vendor Dashboard'))

@section('content')

<div class="profile">
    <div class="container bg-light mt-5 border-main">
        <div class="row gx-2">

            <x-site.vendors.side-menu />

            <!--index section -->
            <div class="col-12 order-lg-2 order-2 col-lg-9 mx-auto">
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                
                                <div class="col-md-7 text-center text-md-end col-12 mt-3">
                                    <h1 class="fs-4"> @lang('Show Products') </h1>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        @foreach ($languages as $key => $locale)
                                        <div class="accordion mt-4 mb-4" id="accordionExample">
                                            <div class="accordion-item border rounded">
                                                <h2 class="accordion-header" id="headingOne{{ $key }}">
                                                    <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne{{ $key }}" aria-expanded="true" aria-controls="collapseOne{{ $key }}">
                                                        {{ trans('lang.' . Locale::getDisplayName($locale)) }}
                                                    </button>
                                                </h2>
                                                <div id="collapseOne{{ $key }}" class="accordion-collapse collapse show mt-3" aria-labelledby="headingOne{{ $key }}" data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">
                                                        {{-- title ------------------------------------------------------------------------------------- --}}
                                                        <div class="row mb-3">
                                                            <label for="example-text-input" class="col-sm-2 col-form-label">{{ trans('admin.title_in') . trans('lang.' . Locale::getDisplayName($locale)) }}</label>
                                                            <div class="col-sm-10">
                                                                <input class="form-control" type="text" name="{{ $locale }}[title]" disabled value="{{ $product->trans->where('locale',$locale)->first()->title }}" id="title{{ $key }}" required />
                                                            </div>
                                                        </div>
                                                        {{-- Start Slug --}}
                                                        <div class="row mb-3 slug-section">
                                                            <label for="example-text-input" class="col-sm-2 col-form-label">{{ trans('admin.slug_in') . trans('lang.' . Locale::getDisplayName($locale)) }}
                                                            </label>
                                                            <div class="col-sm-10">
                                                                <input type="text" id="slug{{ $key }}" name="{{ $locale }}[slug]" disabled value="{{  $product->trans->where('locale',$locale)->first()->slug }}" class="form-control slug">
                                                            </div>
                                                        </div>
                                                        @include('admin.layouts.scriptSlug')
                                                        {{-- End Slug --}}


                                                        {{-- description ------------------------------------------------------------------------------------- --}}
                                                        <div class="row mb-3">
                                                            <label for="example-text-input" class="col-sm-2 col-form-label"> @lang('admin.description_in')
                                                                {{ trans('lang.' . Locale::getDisplayName($locale)) }}
                                                            </label>
                                                            <div class="col-sm-10 mb-2">
                                                                <textarea id="description{{ $key }}" disabled name="{{ $locale }}[description]"> {{ $product->trans->where('locale',$locale)->first()->description  }} </textarea>
                                                            </div>

                                                            <script type="text/javascript">
                                                                CKEDITOR.replace('description{{ $key }}', {
                                                                    filebrowserUploadUrl: "{{ route('admin.ckeditor.upload', ['_token' => csrf_token()]) }}"
                                                                    , filebrowserUploadMethod: 'form'
                                                                });

                                                            </script>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>


                                    <div class="col-md-12">

                                        {{-- ------ Start Post Settings------ --}}
                                        <div class="accordion mt-4 mb-4" id="accordionExample">
                                            <div class="accordion-item border rounded">
                                                <h2 class="accordion-header" id="headingOne">
                                                    <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                        {{ trans('products.settings') }}
                                                    </button>
                                                </h2>
                                                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">
                                                        <div class="row">
                                                            <div class="col-6">
                                                                {{-- category ------------------------------------------------------------------------------------- --}}
                                                                <div class="row mb-3 title-section">
                                                                    <label for="example-text-input" class="col-sm-12 col-form-label">@lang('charityProject.category') :</label>
                                                                    <div class="col-sm-12">
                                                                        <input type="text" disabled class="form-control" value="{{ $product->category->title }}">
                                                                        <p> </p>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-6">
                                                                {{-- price ------------------------------------------------------------------------------------- --}}
                                                                <div class="col-12">
                                                                    <div class="row mb-3">
                                                                        <label for="example-number-price" col-form-label> @lang('products.price')</label>
                                                                        <div class="col-sm-12">
                                                                            <input class="form-control" disabled type="number" step="any"  value="{{ @$product->vendor_price }}" required>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                {{-- sort ------------------------------------------------------------------------------------- --}}
                                                                <div class="col-12">
                                                                    <div class="row mb-3">
                                                                        <label for="example-number-sort" col-form-label>
                                                                            @lang('articles.sort')</label>
                                                                        <div class="col-sm-12">
                                                                            <input class="form-control" disabled type="number" name="sort" value="{{ @$product->sort }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>


                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- ------ End Post Settings------ --}}

                                        {{-- ------------images--------------- --}}
                                        <div class="accordion mt-4 mb-4" id="accordionExample">
                                            <div class="accordion-item border rounded">
                                                <h2 class="accordion-header" id="headingOne">
                                                    <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#images_project" aria-expanded="true" aria-controls="images_project">
                                                        {{ trans('charityProject.images_project') }}
                                                    </button>
                                                </h2>
                                                <div id="images_project" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">
                                                        @if ($product->image != null)
                                                        <label class="control-label" for="imageUpload">@lang('admin.image'): </label>
                                                        <div class="row">

                                                            @forelse (hinddelImage($product->image) as $image)
                                                            <div class="col-md-2 col-sm-6">
                                                                <a href="{{ asset(pathImage($image)) }}">
                                                                    <img src="{{ asset(pathImage($image)) }}" alt="Card image" width="100px" class="">
                                                                </a>
                                                            </div>
                                                            @empty
                                                            @endforelse
                                                        </div>
                                                        @endif
                                                      <hr class="my-2">
                                                        {{-- cover image ------------------------------------------------------------------------------------- --}}
                                                        <div class="col-12">
                                                            <label for="example-number-cover_image" class="col-sm-12 col-form-label">@lang('charityProject.cover_image') : </label>
                                                            @if ($product->cover_image != null)
                                                            <img src="{{ getImageThumb($product->cover_image) }}" alt="Card image" style="width:200px; height:200px;margin:10px;">
                                                            @endif
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    {{-- Butoooons ------------------------------------------------------------------------- --}}
                                    <div class="row mb-3 text-end">
                                        <div>
                                            <a href="{{ route('site.vendors.products.index') }}" class="btn btn-info waves-effect waves-light text-white btn-sm">@lang('button.back')</a>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div> <!-- end col -->
                </div> <!-- end row-->
            </div>
            <!--index section -->

        </div>
    </div>
</div>


@endsection


@section('style')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="{{ asset('site/js/ckeditor/ckeditor.js') }}"></script>
@endsection
