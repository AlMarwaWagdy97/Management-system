@extends('admin.app')

@section('title', trans('services.show_services'))
@section('title_page', trans('services.services'))
@section('title_route', route('admin.services.index') )
@section('button_page')
<a href="{{ route('admin.services.index') }}" class="btn btn-outline-primary waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
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
                                        <input class="form-control" type="text" name="{{ $locale }}[title]" disabled value="{{ @$service->trans->where('locale',$locale)->first()->title}}" id="title{{ $key }}">
                                    </div>
                                    @if($errors->has( $locale . '.title'))
                                    <span class="missiong-spam">{{ $errors->first( $locale . '.title') }}</span>
                                    @endif
                                </div>

                                {{-- slug ------------------------------------------------------------------------------------- --}}
                                <div class="row mb-3 slug-section">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">{{ trans('admin.slug_in') .   trans('lang.' .Locale::getDisplayName($locale))}}</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="{{ $locale }}[slug]" disabled value="{{ @$service->trans->where('locale',$locale)->first()->slug}}" id="slug{{ $key }}" class="form-control slug" required>
                                    </div>
                                    @if($errors->has( $locale . '.slug'))
                                    <span class="missiong-spam">{{ $errors->first( $locale . '.slug') }}</span>
                                    @endif
                                </div>

                                {{-- description ------------------------------------------------------------------------------------- --}}
                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label"> @lang('admin.description_in') {{trans('lang.' .Locale::getDisplayName($locale))}} </label>
                                    <div class="col-sm-10 mb-2">
                                        <p>{!! @$service->trans->where('locale',$locale)->first()->description  !!}</p>
                                    </div>
                                </div>

                                {{-- content ------------------------------------------------------------------------------------- --}}
                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label"> @lang('admin.content_in') {{ trans('lang.' .Locale::getDisplayName($locale)) }} </label>
                                    <div class="col-sm-10 mb-2">
                                        <p>{!! @$service->trans->where('locale',$locale)->first()->content  !!}</p>
                                    </div>
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
                        <div id="collapseMeta{{ $key }}" class="accordion-collapse collapse show mt-3" aria-labelledby="headingTwo{{ $key }}" data-bs-parent="#accordionExampleMeta">
                            <div class="accordion-body">
                                @foreach ($languages as $key => $locale)
                                {{-- meta_title_ ------------------------------------------------------------------------------------- --}}
                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">{{ trans('admin.meta_title_in') . trans('lang.' .Locale::getDisplayName($locale)) }}</label>
                                    <div class="col-sm-10">
                                        <input class="form-control" type="text" name="{{ $locale }}[meta_title]" disabled value="{{ @$service->trans->where('locale',$locale)->first()->meta_title}}" id="title{{ $key }}">
                                    </div>
                                    @if($errors->has( $locale . '.meta_title'))
                                    <span class="missiong-spam">{{ $errors->first( $locale . '.meta_title') }}</span>
                                    @endif
                                </div>

                                {{-- meta_description_ ------------------------------------------------------------------------------------- --}}
                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label"> @lang('admin.meta_description_in') {{ trans('lang.' .Locale::getDisplayName($locale)) }} </label>
                                    <div class="col-sm-10 mb-2">
                                        <textarea name="{{ $locale }}[meta_description]" class="form-control description" disabled> {{ @$service->trans->where('locale',$locale)->first()->meta_description }} </textarea>
                                        @if($errors->has( $locale . '.meta_description'))
                                        <span class="missiong-spam">{{ $errors->first( $locale . '.meta_description') }}</span>
                                        @endif
                                    </div>
                                </div>

                                {{-- meta_key_ ------------------------------------------------------------------------------------- --}}
                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label"> @lang('admin.meta_key_in') {{ trans('lang.' .Locale::getDisplayName($locale))}} </label>
                                    <div class="col-sm-10 mb-2">
                                        <textarea name="{{ $locale }}[meta_key]" class="form-control description" disabled> {{ @$service->trans->where('locale',$locale)->first()->meta_key }} </textarea>
                                        @if($errors->has( $locale . '.meta_key'))
                                        <span class="missiong-spam">{{ $errors->first( $locale . '.meta_key') }}</span>
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
                                <div class="col-12">
                                    <div class="row mb-3">
                                        <div class="col-sm-6">
                                            <a href="{{ getImage( $service->image) }}" target="_blank">
                                                <img src="{{ getImageThumb( $service->image ) }}" alt="" style="width:100%">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                {{-- sort ------------------------------------------------------------------------------------- --}}
                                <div class="row mb-3">
                                    <div class="col-12">
                                        <label for="example-number-input" class="col-md-3 col-form-label"> @lang('articles.sort')</label>
                                        <span>{{ $service->sort }}</span>
                                    </div>
                                </div>
                                {{-- feature ------------------------------------------------------------------------------------- --}}
                                <div class="col-12 ">
                                    <label class="col-md-3 col-form-label" for="available">{{ trans('admin.feature') }}</label>
                                    @if($service->feature == 1 )
                                    <span class="badge bg-success">@lang("admin.yes")</span>
                                    @else
                                    <span class="badge bg-danger">@lang("admin.no")</span>
                                    @endif
                                </div>
                                {{-- news_ticker ------------------------------------------------------------------------------------- --}}
                                {{-- <div class="col-12">
                                    <label class="col-sm-3 col-form-label" for="available">{{ trans('admin.news_ticker') }}</label>
                                    @if($service->news_ticker == 1 )
                                    <span class="badge bg-success">@lang("admin.yes")</span>
                                    @else
                                    <span class="badge bg-danger">@lang("admin.no")</span>
                                    @endif
                                </div> --}}
                                {{-- Status ------------------------------------------------------------------------------------- --}}
                                <div class="col-12">
                                    <label class="col-sm-3 col-form-label" for="available">{{ trans('admin.status') }}</label>
                                    @if($service->status == 1 )
                                    <span class="badge bg-success">@lang("admin.active")</span>
                                    @else
                                    <span class="badge bg-danger">@lang("admin.dis_active")</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row mb-3 text-end">
                <div>
                    <a href="{{ route('admin.services.index') }}" class="btn btn-outline-primary waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection


@section('style')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="{{ asset('site/js/ckeditor/ckeditor.js') }}"></script>
@endsection
