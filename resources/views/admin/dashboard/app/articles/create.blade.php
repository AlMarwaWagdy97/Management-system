@extends('admin.app')

@section('title', trans('articles.create_articles'))
@section('title_page', trans('articles.articles'))
@section('title_route', route('admin.app.articles.index') )
@section('button_page')
<a href="{{ route('admin.app.articles.index') }}" class="btn btn-outline-primary waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
@endsection


@section('content')

<div class="card">
    <div class="card-body">

        <form action="{{ route('admin.app.articles.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-8">
                    @foreach ($languages as $key => $locale)
                    <div class="accordion mt-4 mb-4" id="accordionExampleTitle{{ $key }}">
                        <div class="accordion-item border rounded">
                            <h2 class="accordion-header" id="headingTitle{{ $key }}">
                                <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTitle{{ $key }}" aria-expanded="true" aria-controls="collapseTitle{{ $key }}">
                                    {{ trans('lang.' . Locale::getDisplayName($locale)) }}
                                </button>
                            </h2>
                            <div id="collapseTitle{{ $key }}" class="accordion-collapse collapse show mt-3" aria-labelledby="headingTitle{{ $key }}" data-bs-parent="#accordionExampleTitle{{ $key }}">
                                <div class="accordion-body">

                                    {{-- title ------------------------------------------------------------------------------------- --}}
                                    <div class="row mb-3">
                                        <label for="example-text-input" class="col-sm-12 col-form-label">{{ trans('admin.title_in') . trans('lang.' . Locale::getDisplayName($locale)) }}</label>
                                        <div class="col-sm-12">
                                            <input class="form-control" type="text" name="{{ $locale }}[title]" value="{{ old($locale . '.title') }}" id="title{{ $key }}">
                                        </div>
                                        @if ($errors->has($locale . '.title'))
                                        <span class="missiong-spam">{{ $errors->first($locale . '.title') }}</span>
                                        @endif
                                    </div>

                                    {{-- slug ------------------------------------------------------------------------------------- --}}
                                    {{-- Start Slug --}}
                                    <div class="row mb-3 slug-section">
                                        <label for="example-text-input" class="col-sm-12 col-form-label">{{ trans('admin.slug_in') . trans('lang.' . Locale::getDisplayName($locale)) }}
                                        </label>

                                        <div class="col-sm-12">
                                            <input type="text" id="slug{{ $key }}" name="{{ $locale }}[slug]" value="{{ old($locale . '.slug') }}" class="form-control slug" required>
                                            @if ($errors->has($locale . '.slug'))
                                            <span class="missiong-spam">{{ $errors->first($locale . '.slug') }}</span>
                                            @endif
                                        </div>
                                        @include('admin.layouts.scriptSlug')
                                        {{-- End Slug --}}


                                        {{-- description ------------------------------------------------------------------------------------- --}}
                                        <div class="row mb-3 mt-3">
                                            <label for="example-text-input" class="col-sm-12 col-form-label"> @lang('admin.description_in')
                                                {{ trans('lang.' . Locale::getDisplayName($locale)) }}
                                            </label>
                                            <div class="col-sm-12 mb-2">
                                                <textarea id="description{{ $key }}" name="{{ $locale }}[description]" class="form-control" rows="5" cols="100"> {{ old($locale . '.description') }} </textarea>
                                                @if ($errors->has($locale . '.description'))
                                                <span class="missiong-spam">{{ $errors->first($locale . '.description') }}</span>
                                                @endif
                                            </div>
                                            <script type="text/javascript">
                                                CKEDITOR.replace('description{{ $key }}', {
                                            filebrowserUploadUrl: "{{ route('admin.ckeditor.upload', ['_token' => csrf_token()]) }}",
                                            filebrowserUploadMethod: 'form'
                                            });
                                            </script>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach

                  
                </div>

                <div class="col-md-4">
                    <div class="accordion mt-4 mb-4" id="accordionExampleSetting">
                        <div class="accordion-item border rounded">
                            <h2 class="accordion-header" id="headingSetting">
                                <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSetting" aria-expanded="true" aria-controls="collapseSetting">
                                    {{ trans('admin.settings') }}
                                </button>
                            </h2>
                            <div id="collapseSetting" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExampleSetting">
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
                                    {{-- category ------------------------------------------------------------------------------------- --}}
                                    <div class="col-12">
                                        <div class="row mb-3">
                                            <label for="example-number-input" col-form-label>
                                                @lang('categories.category')</label>
                                            <div class="col-sm-12">

                                                <select name="section_id" class="form-control form-select  select2">
                                                    <option value="" selected>
                                                        {{ trans('categories.category') }}</option>
                                                    @foreach ($sections as $item)
                                                    <option value="{{ $item->id }}" {{ old('section_id') == $item->id ? 'selected' : '' }}>
                                                        {{ $item->trans->title }}
                                                    </option>
                                                    @endforeach
                                                </select>
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
                                    <div class="col-12">
                                        <div class="col-sm-10">
                                            <div class="form-check form-switch form-check-success">
                                                <label class="form-check-label" for="flexSwitchCheckSuccessfeature">@lang('admin.feature')</label>
                                                <input class="form-check-input" type="checkbox" role="switch" name="feature" {{  request('feature') == 1 ? 'checked' : '' }} id="flexSwitchCheckSuccessfeature">
                                            </div>
                                        </div>
                                    </div>
                                    {{-- Status ------------------------------------------------------------------------------------- --}}
                                    <div class="col-12">
                                        <div class="col-sm-10">
                                            <div class="form-check form-switch form-check-success">
                                                <label class="form-check-label" for="flexSwitchCheckSuccessstatus">@lang('admin.status')</label>
                                                <input class="form-check-input" type="checkbox" role="switch" name="status" {{  request('status') == 1 ? 'checked' : '' }} id="flexSwitchCheckSuccessstatus">
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
                        <a href="{{ route('admin.app.articles.index') }}" class="btn btn-outline-primary waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
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
