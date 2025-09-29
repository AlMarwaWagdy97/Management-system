@extends('admin.app')

@section('title', trans('sections.show_section'))
@section('title_page', trans('sections.sections'))
@section('title_route', route('admin.app.sections.index') )
@section('button_page')
<a href="{{ route('admin.app.sections.index') }}" class="btn btn-outline-primary waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
@endsection

@section('content')

<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-8">
                @foreach ($languages as $key => $locale)

                <div class="accordion mt-4 mb-4" id="accordionExampleTitle{{ $key }}">
                    <div class="accordion-item border rounded">
                        <h2 class="accordion-header" id="headingTitle{{ $key }}">
                            <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTitle{{ $key }}" aria-expanded="true" aria-controls="collapseTitle{{ $key }}">
                                {{ trans('lang.' .Locale::getDisplayName($locale)) }}
                            </button>
                        </h2>
                        <div id="collapseTitle{{ $key }}" class="accordion-collapse collapse show mt-3" aria-labelledby="headingTitle{{ $key }}" data-bs-parent="#accordionExampleTitle{{ $key }}">
                            <div class="accordion-body">



                                {{-- title ------------------------------------------------------------------------------------- --}}
                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">{{ trans('admin.title_in') .   trans('lang.' .Locale::getDisplayName($locale))}}</label>
                                    <div class="col-sm-10">
                                        <input class="form-control" type="text" name="{{ $locale }}[title]" disabled value="{{ @$section->trans->title}}" id="title{{ $key }}">
                                    </div>
                                </div>

                                {{-- slug ------------------------------------------------------------------------------------- --}}
                                <div class="row mb-3 slug-section">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">{{ trans('admin.slug_in') .   trans('lang.' .Locale::getDisplayName($locale))}}</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="{{ $locale }}[slug]" disabled value="{{ @$section->trans->slug}}" id="slug{{ $key }}" class="form-control slug" required>
                                    </div>
                                </div>

                                {{-- description ------------------------------------------------------------------------------------- --}}
                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label"> @lang('admin.description_in') {{trans('lang.' .Locale::getDisplayName($locale))}} </label>
                                    <div class="col-sm-10 mb-2">
                                        <p>{!! @$section->trans->description !!}</p>
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
                        <div id="collapseSetting" class="accordion-collapse collapse show" aria-labelledby="headingSetting" data-bs-parent="#accordionExampleSetting">
                            <div class="accordion-body">

                                <div class="row mb-3">
                                    <div class="col-sm-12">
                                        <a href="{{ getImageThumb( $section->image) }}" target="_blank">
                                            <img src="{{ getImageThumb( $section->image ) }}" alt="" style="width:50%">
                                        </a>
                                    </div>
                                </div>

                                {{-- feature ------------------------------------------------------------------------------------- --}}
                                <div class="col-12 ">
                                    <label class="col-md-3 col-form-label" for="available">{{ trans('admin.feature') }}</label>
                                    @if($section->feature == 1 )
                                    <span class="badge  bg-success">@lang("admin.yes")</span>
                                    @else
                                    <span class="badge  bg-danger">@lang("admin.no")</span>
                                    @endif
                                </div>
                                {{-- Status ------------------------------------------------------------------------------------- --}}
                                <div class="col-12">
                                    <label class="col-sm-3 col-form-label" for="available">{{ trans('admin.status') }}</label>
                                    @if($section->status == 1 )
                                    <span class="badge  bg-success">@lang("admin.active")</span>
                                    @else
                                    <span class="badge  bg-danger">@lang("admin.dis_active")</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-3 text-end">
                <div>
                    <a href="{{ route('admin.app.sections.index') }}" class="btn btn-outline-primary waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection
