@extends('admin.app')

@section('title', trans('sections.edit_sections'))
@section('title_page', trans('sections.sections'))
@section('title_route', route('admin.app.sections.index') )
@section('button_page')
<a href="{{ route('admin.app.sections.index') }}" class="btn btn-outline-primary waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
@endsection


@section('content')

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.app.sections.update', $section->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('put')
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
                                            <input class="form-control" type="text" name="{{ $locale }}[title]" value="{{ @$section->trans->title }}" id="title{{ $key }}">
                                        </div>
                                        @if ($errors->has($locale . '.title'))
                                        <span class="missiong-spam">{{ $errors->first($locale . '.title') }}</span>
                                        @endif
                                    </div>

                                    {{-- slug ------------------------------------------------------------------------------------- --}}
                                    <div class="row mb-3 slug-section">
                                        <label for="example-text-input" class="col-sm-12 col-form-label">{{ trans('admin.slug_in') . trans('lang.' . Locale::getDisplayName($locale)) }}
                                        </label>
                                        <div class="col-sm-12">
                                            <input type="text" id="slug{{ $key }}" name="{{ $locale }}[slug]" value="{{ @$section->trans->slug }}" class="form-control slug mb-3" required>
                                            @if ($errors->has($locale . '.slug'))
                                            <span class="missiong-spam">{{ $errors->first($locale . '.slug') }}</span>
                                            @endif
                                        </div>
                                        @include('admin.layouts.scriptSlug')
                                    </div>
                                    {{-- End Slug --}}

                                    {{-- description ------------------------------------------------------------------------------------- --}}
                                    <div class="row mb-3">
                                        <label for="example-text-input" class="col-sm-12 col-form-label"> @lang('admin.description_in')
                                            {{ trans('lang.' . Locale::getDisplayName($locale)) }}
                                        </label>
                                        <div class="col-sm-12 mb-2">
                                            <textarea id="description{{ $key }}" name="{{ $locale }}[description]" class="form-control" rows="5" cols="100"> {{ @$section->trans->description }} </textarea>
                                            @if ($errors->has($locale . '.description'))
                                            <span class="missiong-spam">{{ $errors->first($locale . '.description') }}</span>
                                            @endif
                                        </div>
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
                    @endforeach

                    
                </div>

                <div class="col-md-4">

                    <div class="accordion mt-4 mb-4" id="accordionExampleSetting{{ $key }}">
                        <div class="accordion-item border rounded">
                            <h2 class="accordion-header" id="headingSetting">
                                <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSetting" aria-expanded="true" aria-controls="collapseSetting">
                                    {{ trans('admin.settings') }}
                                </button>
                            </h2>
                            <div id="collapseSetting" class="accordion-collapse collapse show" aria-labelledby="headingSetting" data-bs-parent="#accordionExampleSetting{{ $key }}">
                                <div class="accordion-body">
                                    <div class="col-sm-6 mb-3">
                                        <a href="{{ getImageThumb( $section->image) }}" target="_blank">
                                            <img src="{{ getImageThumb( $section->image ) }}" alt="" style="width:100%">
                                        </a>
                                    </div>
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
                                                @lang('sections.sort')</label>
                                            <div class="col-sm-12">
                                                <input class="form-control" type="number" placeholder="@lang('sections.sort')" id="example-number-input" name="sort" value="{{ @$section->sort }}">
                                            </div>
                                        </div>
                                    </div>
                                    {{-- feature ------------------------------------------------------------------------------------- --}}
                                    <div class="col-12">
                                        <div class="col-sm-10 mb-2">
                                            <div class="form-check form-switch form-check-success">
                                                <label class="form-check-label" for="flexSwitchCheckSuccessFeature">@lang('admin.feature')</label>
                                                <input class="form-check-input" type="checkbox" role="switch" name="feature" {{  @$section->feature == 1 ? 'checked' : '' }} id="flexSwitchCheckSuccessFeature">
                                            </div>
                                        </div>
                                    </div>
                                    {{-- news_ticker ------------------------------------------------------------------------------------- --}}
                                    {{-- <div class="col-12">
                                    <div class="col-sm-10 mb-2">
                                        <div class="form-check form-switch form-check-success">
                                            <label class="form-check-label" for="flexSwitchCheckSuccess">@lang('admin.news_ticker')</label>
                                            <input class="form-check-input" type="checkbox" role="switch" name="news_ticker"  {{ @$section->news_ticker  == 1 ? 'checked' : '' }} id="flexSwitchCheckSuccess">
                                </div>
                            </div>
                        </div> --}}
                        {{-- Status ------------------------------------------------------------------------------------- --}}
                        <div class="col-12">
                            <div class="col-sm-10 mb-2">
                                <div class="form-check form-switch form-check-success">
                                    <label class="form-check-label" for="flexSwitchCheckSuccessStatus">@lang('admin.status')</label>
                                    <input class="form-check-input" type="checkbox" role="switch" name="status" {{  @$section->status  == 1 ? 'checked' : '' }} id="flexSwitchCheckSuccessStatus">
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
        <a href="{{ route('admin.app.sections.index') }}" class="btn btn-outline-danger waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
        <button type="submit" class="btn btn-outline-success waves-effect waves-light ml-3 btn-sm">@lang('button.save')</button>
        <button type="submit" name="submit" value="update" class="btn btn-outline-success waves-effect waves-light  btn-sm">@lang('button.save_update')</button>
    </div>
</div>
</form>
</div>

@endsection


@section('style')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="{{ asset('site/js/ckeditor/ckeditor.js') }}"></script>
@endsection
