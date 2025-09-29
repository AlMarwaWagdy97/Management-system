@extends('admin.app')

@section('title', trans('portfolio.create'))
@section('title_page', trans('portfolio.portfolio'))
@section('title_route', route('admin.portfolio.index') )
@section('button_page')
<a href="{{ route('admin.portfolio.index') }}" class="btn btn-outline-primary waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
@endsection


@section('content')

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.portfolio.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-8">
                    @foreach ($languages as $key => $locale)
                    <div class="accordion mt-4 mb-4" id="accordionExampleTitle">
                        <div class="accordion-item border rounded">
                            <h2 class="accordion-header" id="headingTitle{{ $key }}">
                                <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTitle{{ $key }}" aria-expanded="true" aria-controls="collapseTitle{{ $key }}">
                                    {{ trans('lang.' . Locale::getDisplayName($locale)) }}
                                </button>
                            </h2>
                            <div id="collapseTitle{{ $key }}" class="accordion-collapse collapse show mt-3" aria-labelledby="headingTitle{{ $key }}" data-bs-parent="#accordionExampleTitle">
                                <div class="accordion-body">
                                    {{-- title ------------------------------------------------------------------------------------- --}}
                                    <div class="row mb-3">
                                        <label for="example-text-input" class="col-sm-12 col-form-label">{{ trans('admin.title_in') .  trans('lang.' .Locale::getDisplayName($locale)) }}</label>
                                        <div class="col-sm-12">
                                            <input class="form-control" type="text" name="{{ $locale }}[title]" value="{{ old($locale . '.title') }}">
                                        </div>
                                        @if ($errors->has($locale . '.title'))
                                        <span class="missiong-spam">{{ $errors->first($locale . '.title') }}</span>
                                        @endif
                                    </div>

                                    {{-- description ------------------------------------------------------------------------------------- --}}
                                    <div class="row mb-3 mt-3">
                                        <label for="example-text-input" class="col-sm-12 col-form-label"> @lang('admin.description_in')
                                            {{ trans('lang.' . Locale::getDisplayName($locale)) }}
                                        </label>
                                        <div class="col-sm-12 mb-2">
                                            <textarea id="description{{ $key }}" name="{{ $locale }}[description]"> {{ old($locale . '.description') }} </textarea>
                                            @if ($errors->has($locale . '.description'))
                                            <span class="missiong-spam">{{ $errors->first($locale . '.description') }}</span>
                                            @endif
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
                <div class="col-md-4">
                    <div class="accordion mt-4 mb-4" id="accordionExample1Setting">
                        <div class="accordion-item border rounded">
                            <h2 class="accordion-header" id="headingSetting">
                                <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSetting" aria-expanded="true" aria-controls="collapseSetting">
                                    {{ trans('admin.settings') }}
                                </button>
                            </h2>
                            <div id="collapseSetting" class="accordion-collapse collapse show" aria-labelledby="headingSetting" data-bs-parent="#accordionExample1Setting">
                                <div class="accordion-body">
                                    {{-- image ------------------------------------------------------------------------------------- --}}
                                    <div class="col-12">
                                        <div class="row mb-3">
                                            <label for="example-number-input" col-form-label>
                                                @lang('admin.image')</label>
                                            <div class="col-sm-12">
                                                <input class="form-control" type="file" placeholder="@lang('admin.image')" id="example-number-input" name="image" required value="{{ old('image') }}">
                                            </div>
                                        </div>
                                    </div>
                                    {{-- Category  ------------------------------------------------------------------------------- --}}
                                    <div class="col-12">
                                        <div class="row mb-3">
                                            <label for="example-number-input"> @lang('tags.tags')</label>
                                            <div class="col-sm-12">
                                                <select class="form-select form-select-sm select2" name="tag_id">
                                                    <option value="" selected disabled> {{ trans('tags.tags') }}</option>
                                                    @foreach ($tags as $tag)
                                                    <option value="{{ $tag->id }}" {{ old('tag_id') == $tag->id ? 'selected' : '' }}> {{ @$tag->trans->where('locale', $current_lang)->first()->title }} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        @error('category_id')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    {{-- sort ------------------------------------------------------------------------------------- --}}
                                    <div class="col-12">
                                        <div class="row mb-3">
                                            <label for="example-number-input" col-form-label>
                                                @lang('admin.sort')</label>
                                            <div class="col-sm-12">
                                                <input class="form-control" type="number" id="example-number-input" name="sort" value="{{ old('sort') }}">
                                            </div>
                                        </div>
                                    </div>
                                    {{-- feature ------------------------------------------------------------------------------------- --}}
                                    <div class="col-12 mb-3">
                                        <div class="form-check form-switch form-check-success">
                                            <label class="form-check-label" for="flexSwitchCheckSuccessFeature">@lang('admin.feature')</label>
                                            <input class="form-check-input" type="checkbox" role="switch" name="feature" {{  request('feature') == 1 ? 'checked' : '' }} id="flexSwitchCheckSuccessFeature">
                                        </div>
                                    </div>

                                    {{-- Status ------------------------------------------------------------------------------------- --}}
                                    <div class="col-12 mb-3">
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
                {{-- Butoooons ------------------------------------------------------------------------- --}}
                <div class="row mb-3 text-end">
                    <div>
                        <a href="{{ route('admin.portfolio.index') }}" class="btn btn-outline-primary waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
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
