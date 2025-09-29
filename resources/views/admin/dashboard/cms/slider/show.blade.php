@extends('admin.app')

@section('title', trans('slider.slider_show'))
@section('title_page', trans('slider.sliders'))
@section('title_route', route('admin.slider.index') )
@section('button_page')
<a href="{{ route('admin.slider.index') }}" class="btn btn-primary waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
@endsection

@section('content')

<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-9 col-sm-12">
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
                                    <label for="example-text-input" class="col-sm-2 col-form-label">{{ trans('admin.title_in') . trans('lang.' . Locale::getDisplayName($locale)) }}</label>
                                    <div class="col-sm-10">
                                        <input class="form-control" type="text" name="{{ $locale }}[title]" disabled value="{{ @$slider->trans->where('locale',$locale)->first()->title }}" id="title{{ $key }}">
                                    </div>
                                    @if($errors->has($locale . '.title'))
                                    <span class="missiong-spam">{{ $errors->first($locale . '.title') }}</span>
                                    @endif
                                </div>
                                {{-- description ------------------------------------------------------------------------------------- --}}
                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">{{ trans('admin.description_in') . trans('lang.' . Locale::getDisplayName($locale)) }}
                                    </label>
                                    <div class="col-sm-10 mb-2">
                                        <p>{!! @$slider->trans->where('locale',$locale)->first()->description !!}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="col-md-3 col-sm-12">
                <div class="row">
                    <div class="accordion mt-4 mb-4" id="accordionExampleSetting">
                        <div class="accordion-item border rounded">
                            <h2 class="accordion-header" id="headingSetting">
                                <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSetting" aria-expanded="true" aria-controls="collapseSetting">
                                    {{ trans('admin.settings') }}
                                </button>
                            </h2>
                            <div id="collapseSetting" class="accordion-collapse collapse show" aria-labelledby="headingSetting" data-bs-parent="#accordionExampleSetting">
                                <div class="accordion-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <a href="{{ getImage( $slider->image) }}" target="_blank">
                                                <img src="{{  getImageThumb( $slider->image ) }}" alt="" style="width:100%">
                                            </a>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <a href="{{ getImage( $slider->mobile_image) }}" target="_blank">
                                                <img src="{{  getImageThumb( $slider->mobile_image ) }}" alt="" style="width:100%">
                                            </a>
                                        </div>
                                    </div>
                                    {{-- Status ------------------------------------------------------------------------------------- --}}
                                    <div class="col-12 mb-3">
                                        <label class="col-4 col-form-label" for="available">{{ trans('admin.status') }}</label>
                                        @if($slider->status == 1 )
                                        <span class="badge bg-success">@lang("admin.active")</span>
                                        @else
                                        <span class="badge bg-danger">@lang("admin.dis_active")</span>
                                        @endif
                                    </div>
                                    {{-- URL ------------------------------------------------------------------------------------- --}}
                                    <div class="col-12">
                                        <div class="row mb-3">
                                            <label for="example-number-input" class="col-4 col-form-label"> @lang('slider.url')</label>
                                            <a href="{{ $slider->url}}">{{ $slider->url == "javascript:void(0)"?"sss": $slider->url }}</a>
                                        </div>
                                    </div>
                                    {{-- sort ------------------------------------------------------------------------------------- --}}
                                    <div class="col-12">
                                        <div class="row mb-3">
                                            <label for="example-number-input" col-form-label>
                                                @lang('slider.sort')</label>
                                            <span>{{ $slider->sort }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
