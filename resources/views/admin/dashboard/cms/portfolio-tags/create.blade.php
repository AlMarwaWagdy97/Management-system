@extends('admin.app')

@section('title', trans('portfoliotags.create_tags'))
@section('title_page', trans('portfoliotags.tags'))
@section('title_route', route('admin.portfolio-tags.index') )
@section('button_page')
<a href="{{ route('admin.portfolio-tags.index') }}" class="btn btn-primary waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
@endsection

@section('content')

<div class="card">
    <div class="card-body">

        <form action="{{ route('admin.portfolio-tags.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-8">
                    <div class="accordion mt-4 mb-4" id="accordionExampleTitle">
                        <div class="accordion-item border rounded">
                            <h2 class="accordion-header" id="headingTitle">
                                <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTitle" aria-expanded="true" aria-controls="collapseTitle">
                                    @lang('admin.title')
                                </button>
                            </h2>
                            <div id="collapseTitle" class="accordion-collapse collapse show mt-3" aria-labelledby="headingTitle" data-bs-parent="#accordionExampleTitle">
                                <div class="accordion-body">

                                    @foreach ($languages as $key => $locale)
                                    {{-- title ------------------------------------------------------------------------------------- --}}
                                    <div class="row mb-3">
                                        <label for="example-text-input" class="col-sm-2 col-form-label">{{ trans('admin.title_in') . trans('lang.' .Locale::getDisplayName($locale)) }}</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" type="text" name="{{ $locale }}[title]" value="{{ old($locale . '.title') }}" id="title{{ $key }}">
                                        </div>
                                        @if ($errors->has($locale . '.title'))
                                        <span class="missiong-spam">{{ $errors->first($locale . '.title') }}</span>
                                        @endif
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    {{-- ------ Start Post Settings------ --}}
                    <div class="accordion mt-4 mb-4" id="accordionExample">
                        <div class="accordion-item border rounded">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    {{ trans('tags.Post_settings') }}
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                <div class="accordion-body">

                                    {{-- sort ------------------------------------------------------------------------------------- --}}
                                    <div class="col-12">
                                        <div class="row mb-3">
                                            <label for="example-number-input" col-form-label>
                                                @lang('articles.sort')</label>
                                            <div class="col-sm-12">
                                                <input class="form-control" type="number" id="example-number-input" name="sort" value="{{ old('sort') }}">
                                            </div>
                                        </div>
                                    </div>
                                    {{-- feature ------------------------------------------------------------------------------------- --}}
                                    <div class="col-12">
                                        <div class="form-check form-switch form-check-success">
                                            <label class="form-check-label" for="flexSwitchCheckSuccessFeature">@lang('admin.feature')</label>
                                            <input class="form-check-input" type="checkbox" role="switch" name="feature" {{  request('feature') == 1 ? 'checked' : '' }} id="flexSwitchCheckSuccessFeature">
                                        </div>
                                    </div>
                                    {{-- Status ------------------------------------------------------------------------------------- --}}
                                    <div class="col-12">
                                        <div class="form-check form-switch form-check-success">
                                            <label class="form-check-label" for="flexSwitchCheckSuccessStatus">@lang('admin.status')</label>
                                            <input class="form-check-input" type="checkbox" role="switch" name="status" {{  request('status') == 1 ? 'checked' : '' }} id="flexSwitchCheckSuccessStatus">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- ------ End Post Settings------ --}}
                </div>
                {{-- Butoooons ------------------------------------------------------------------------- --}}
                <div class="row mb-3 text-end">
                    <div>
                        <a href="{{ route('admin.portfolio-tags.index') }}" class="btn btn-primary waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
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
