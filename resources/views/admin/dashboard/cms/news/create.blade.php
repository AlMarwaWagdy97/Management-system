@extends('admin.app')

@section('title', trans('news.create_news'))
@section('title_page', trans('admin.news'))
@section('title_route', route('admin.news.index') )
@section('button_page')
<a href="{{ route('admin.news.index') }}" class="btn btn-outline-primary waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
@endsection


@section('content')



<div class="card">
    <div class="card-body">

        <form action="{{ route('admin.news.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-8">
                    @foreach ($languages as $key => $locale)
                    <div class="accordion mt-4 mb-4" id="accordionExampletitle{{ $key }}">
                        <div class="accordion-item border rounded">
                            <h2 class="accordion-header" id="headingTitle{{ $key }}">
                                <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTitle{{ $key }}" aria-expanded="true" aria-controls="collapseOne{{ $key }}">
                                    {{ trans('lang.' . Locale::getDisplayName($locale)) }}
                                </button>
                            </h2>
                            <div id="collapseTitle{{ $key }}" class="accordion-collapse collapse show mt-3" aria-labelledby="headingTitle{{ $key }}" data-bs-parent="#accordionExampletitle{{ $key }}">
                                <div class="accordion-body">

                                    <div class="row mb-3 title-section">
                                        <label for="example-text-input" class="col-sm-2 col-form-label">{{ trans('admin.title_in') . trans('lang.' . Locale::getDisplayName($locale)) }}</label>

                                        <div class="col-sm-12">
                                            <input type="text" id="title{{ $key }}" name="{{ $locale }}[title]" value="{{ old($locale . '.title') }}" class="form-control title" required>
                                            @if ($errors->has($locale . '.title'))
                                            <span class="missiong-spam">{{ $errors->first($locale . '.title') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="row mb-3 slug-section">
                                        <label for="example-text-input" class="col-sm-12 col-form-label">{{ trans('admin.slug_in') . trans('lang.' . Locale::getDisplayName($locale)) }}
                                        </label>

                                        <div class="col-sm-12">
                                            <input type="text" id="slug{{ $key }}" name="{{ $locale }}[slug]" value="{{ old($locale . '.slug') }}" class="form-control slug" required>
                                            @if ($errors->has($locale . '.slug'))
                                            <span class="missiong-spam">{{ $errors->first($locale . '.slug') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    @include('admin.layouts.scriptSlug')


                                    {{-- Start Slug --}}
                                    {{-- description ------------------------------------------------------------------------------------- --}}
                                    <div class="row mb-3">
                                        <label for="example-text-input" class="col-sm-12 col-form-label">{{ trans('admin.description_in') . trans('lang.' . Locale::getDisplayName($locale)) }}
                                        </label>
                                        <div class="col-sm-12 mb-2">
                                            <textarea id="description{{ $key }}" name="{{ $locale }}[description]" class="form-control" rows="5" cols="100">  </textarea>
                                            @if ($errors->has($locale . '.description'))
                                            <span class="missiong-spam">{{ $errors->first($locale . '.description') }}</span>
                                            @endif
                                        </div>

                                    </div>
                                    <div class="row mb-3">
                                        <label for="example-text-input" class="col-sm-12 col-form-label"> {{ trans('admin.content_in') . trans('lang.' . Locale::getDisplayName($locale)) }}
                                        </label>
                                        <div class="col-sm-12 mb-2">
                                            <textarea id="elm{{ $key }}" name="content"> {{ old($locale . '.content') }} </textarea>
                                            @if ($errors->has($locale . '.content'))
                                            <span class="missiong-spam">{{ $errors->first($locale . '.content') }}</span>
                                            @endif
                                        </div>

                                        <script type="text/javascript">
                                            CKEDITOR.replace('elm{{ $key }}', {
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
                    <div class="accordion mt-4 mb-4" id="accordionExampleMeta">
                        <div class="accordion-item border rounded">
                            <h2 class="accordion-header" id="headingMeta{{ $key }}">
                                <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseMeta{{ $key }}" aria-expanded="true" aria-controls="collapseMeta{{ $key }}">
                                    @lang('admin.meta')
                                </button>
                            </h2>
                            <div id="collapseMeta{{ $key }}" class="accordion-collapse collapse  mt-3" aria-labelledby="headingMeta{{ $key }}" data-bs-parent="#accordionExampleMeta">
                                <div class="accordion-body">

                                    @foreach ($languages as $key => $locale)
                                    {{-- meta_title_ ------------------------------------------------------------------------------------- --}}
                                    <div class="row mb-3">
                                        <label for="example-text-input" class="col-sm-2 col-form-label">{{ trans('admin.meta_title_in') . trans('lang.' . Locale::getDisplayName($locale)) }}</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" type="text" name="{{ $locale }}[meta_title]" value="{{ old($locale . '.meta_title') }}" id="title{{ $key }}">
                                        </div>
                                        @if ($errors->has($locale . '.meta_title'))
                                        <span class="missiong-spam">{{ $errors->first($locale . '.meta_title') }}</span>
                                        @endif
                                    </div>

                                    {{-- meta_description_ ------------------------------------------------------------------------------------- --}}
                                    <div class="row mb-3">
                                        <label for="example-text-input" class="col-sm-2 col-form-label">
                                            {{ trans('admin.meta_description_in') . trans('lang.' . Locale::getDisplayName($locale)) }}
                                        </label>
                                        <div class="col-sm-10 mb-2">
                                            <textarea name="{{ $locale }}[meta_description]" class="form-control description"> {{ old($locale . '.meta_description') }} </textarea>
                                            @if ($errors->has($locale . '.meta_description'))
                                            <span class="missiong-spam">{{ $errors->first($locale . '.meta_description') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    {{-- meta_key_ ------------------------------------------------------------------------------------- --}}
                                    <div class="row mb-3">
                                        <label for="example-text-input" class="col-sm-2 col-form-label">
                                            {{ trans('admin.meta_key_in') . trans('lang.' . Locale::getDisplayName($locale)) }}
                                        </label>
                                        <div class="col-sm-10 mb-2">
                                            <textarea name="{{ $locale }}[meta_key]" class="form-control description"> {{ old($locale . '.meta_key') }} </textarea>
                                            @if ($errors->has($locale . '.meta_key'))
                                            <span class="missiong-spam">{{ $errors->first($locale . '.meta_key') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <hr>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="accordion mt-4 mb-4" id="accordionExampleSetting">
                        <div class="accordion-item border rounded">
                            <h2 class="accordion-header" id="headingSetting">
                                <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSetting" aria-expanded="true" aria-controls="collapseSetting">
                                    {{ trans('admin.settings') }}
                                </button>
                            </h2>
                            <div id="collapseSetting" class="accordion-collapse collapse show" aria-labelledby="headingSetting" data-bs-parent="#accordionExampleSetting">
                                <div class="accordion-body">

                                    {{-- image ------------------------------------------------------------------------------------- --}}
                                    <div class="col-12">
                                        <div class="row mb-3">
                                            <label for="example-number-input" col-form-label>
                                                @lang('admin.image')</label>
                                            <div class="col-sm-12">
                                                <input class="form-control" type="file" placeholder="@lang('admin.image')" id="example-number-input" name="image" value="{{ old('image') }}">
                                            </div>
                                        </div>
                                    </div>
                                    {{-- sort ------------------------------------------------------------------------------------- --}}
                                    <div class="col-12">
                                        <div class="row mb-3">
                                            <label for="example-number-input" col-form-label>
                                                @lang('articles.sort')</label>
                                            <div class="col-sm-12">
                                                <input class="form-control" type="number" placeholder="@lang('articles.sort')" id="example-number-input" name="sort" value="{{ old('sort') }}">
                                            </div>
                                        </div>
                                    </div>
                                    {{-- feature ------------------------------------------------------------------------------------- --}}
                                    <div class="col-12 mt-3">
                                        <div class="col-sm-10">
                                            <div class="form-check form-switch form-check-success">
                                                <label class="form-check-label" for="flexSwitchCheckSuccessFeature">@lang('admin.feature')</label>
                                                <input class="form-check-input" type="checkbox" role="switch" name="feature" {{  request('feature') == 1 ? 'checked' : '' }} id="flexSwitchCheckSuccessFeature">
                                            </div>
                                        </div>
                                    </div>
                                    {{-- news_ticker ------------------------------------------------------------------------------------- --}}
                                    <div class="col-12 mt-3">
                                        <div class="col-sm-10">
                                            <div class="form-check form-switch form-check-success">
                                                <label class="form-check-label" for="flexSwitchCheckSuccessNews_ticker">@lang('admin.news_ticker')</label>
                                                <input class="form-check-input" type="checkbox" role="switch" name="news_ticker" {{  request('news_ticker') == 1 ? 'checked' : '' }} id="flexSwitchCheckSuccessNews_ticker">
                                            </div>
                                        </div>
                                    </div>
                                    {{-- Status ------------------------------------------------------------------------------------- --}}
                                    <div class="col-12 mt-3">
                                        <div class="col-sm-10">
                                            <div class="form-check form-switch form-check-success">
                                                <label class="form-check-label" for="flexSwitchCheckSuccessStatus">@lang('admin.status')</label>
                                                <input class="form-check-input" type="checkbox" role="switch" name="status" {{  request('status') == 1 ? 'checked' : '' }} id="flexSwitchCheckSuccessStatus">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Butoooons ------------------------------------------------------------------------- --}}
                <div class="row mb-3 text-end">
                    <div>
                        <a href="{{ route('admin.news.index') }}" class="btn btn-outline-primary waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
                        <button type="submit" class="btn btn-outline-success waves-effect waves-light ml-3 btn-sm">@lang('button.save')</button>
                        <button type="submit" name="submit" value="new" id="submit" class="btn btn-outline-success waves-effect waves-light btn-sm">@lang('button.save_new')</button>
                    </div>
                </div>

            </div>
        </form>
    </div>
</div>

@endsection


@section('style')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="{{ asset('site/js/ckeditor/ckeditor.js') }}"></script>
@endsection
