@extends('admin.app')


@section('title', trans('settings.edit', ['name' => $settingMain->title]))
@section('title_page', trans('settings.settings'))
@section('title_route', route('admin.settings.index'))
@section('button_page')
<a href="{{ route('admin.settings.index') }}" class="btn btn-outline-primary waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
@endsection

@section('content')
<form class="form-horizontal" action="{{ route('admin.settings.update-custom', $settingMain->key) }}" method="POST" enctype="multipart/form-data" role="form">
    @csrf

    <div class="row  mt-5 mb-3">
        <label class="col-sm-2 text-center col-form-label"> @lang('settings.title_setting') </label>
        <div class="col-sm-10 text-center">
            <input class="form-control" type="text" name="title" value="{{ @$settings['title'] }}" required>
        </div>
    </div>

    <div class="accordion mt-4 mb-4" id="accordionMeta">

        {{-- Google Pixel --}}
        <div class="accordion-item border rounded">
            <h2 class="accordion-header" id="headingGoogle">
                <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseGoogle" aria-expanded="true" aria-controls="collapseGoogle">
                    @lang('settings.google_pixel')
                </button>
            </h2>
            <div id="collapseGoogle" class="accordion-collapse collapse show mt-3" aria-labelledby="headingGoogle">
                <div class="accordion-body">
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label">@lang('settings.google_pixel')</label>
                        <div class="col-sm-8">
                            <textarea name="google_pixel_id" class="form-control" cols="30" rows="6">{{ $settings['google_pixel_id'] ?? '' }}</textarea>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-check form-switch form-check-success mt-1">
                                <input type="hidden" name="show_google_pixel" value="0">
                                <input class="form-check-input" type="checkbox" name="show_google_pixel" @if(@$settings['show_google_pixel']==1 ) checked @endif>
                                <label class="form-check-label">@lang('settings.enable')</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Meta Pixel --}}
        <div class="accordion-item border rounded mt-2">
            <h2 class="accordion-header" id="headingMetaPixel">
                <button class="accordion-button fw-medium collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseMetaPixel" aria-expanded="false" aria-controls="collapseMetaPixel">
                    @lang('settings.meta_pixel')
                </button>
            </h2>
            <div id="collapseMetaPixel" class="accordion-collapse collapse mt-3" aria-labelledby="headingMetaPixel">
                <div class="accordion-body">
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label">@lang('settings.meta_pixel')</label>
                        <div class="col-sm-8">
                            <textarea name="meta_pixel_id" class="form-control" cols="30" rows="6">{{ $settings['meta_pixel_id'] ?? '' }}</textarea>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-check form-switch form-check-success mt-1">
                                <input type="hidden" name="show_meta_pixel" value="0">
                                <input class="form-check-input" type="checkbox" name="show_meta_pixel" @if(@$settings['show_meta_pixel']==1 ) checked @endif>
                                <label class="form-check-label">@lang('settings.enable')</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Snapchat Pixel --}}
        <div class="accordion-item border rounded mt-2">
            <h2 class="accordion-header" id="headingSnap">
                <button class="accordion-button fw-medium collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSnap" aria-expanded="false" aria-controls="collapseSnap">
                    @lang('settings.snapchat_pixel')
                </button>
            </h2>
            <div id="collapseSnap" class="accordion-collapse collapse mt-3" aria-labelledby="headingSnap">
                <div class="accordion-body">
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label">@lang('settings.snapchat_pixel')</label>
                        <div class="col-sm-8">
                            <textarea name="snapchat_pixel_id" class="form-control" cols="30" rows="6">{{ $settings['snapchat_pixel_id'] ?? '' }}</textarea>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-check form-switch form-check-success mt-1">
                                <input type="hidden" name="show_snapchat_pixel" value="0">
                                <input class="form-check-input" type="checkbox" name="show_snapchat_pixel" @if(@$settings['show_snapchat_pixel']==1 ) checked @endif>
                                <label class="form-check-label">@lang('settings.enable')</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- TikTok Pixel --}}
        <div class="accordion-item border rounded mt-2">
            <h2 class="accordion-header" id="headingTiktok">
                <button class="accordion-button fw-medium collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTiktok" aria-expanded="false" aria-controls="collapseTiktok">
                    @lang('settings.tiktok_pixel')
                </button>
            </h2>
            <div id="collapseTiktok" class="accordion-collapse collapse mt-3" aria-labelledby="headingTiktok">
                <div class="accordion-body">
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label">@lang('settings.tiktok_pixel')</label>
                        <div class="col-sm-8">
                            <textarea name="tiktok_pixel_id" class="form-control" cols="30" rows="6">{{ $settings['tiktok_pixel_id'] ?? '' }}</textarea>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-check form-switch form-check-success mt-1">
                                <input type="hidden" name="show_tiktok_pixel" value="0">
                                <input class="form-check-input" type="checkbox" name="show_tiktok_pixel" @if(@$settings['show_tiktok_pixel']==1 ) checked @endif>
                                <label class="form-check-label">@lang('settings.enable')</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Twitter Pixel --}}
        <div class="accordion-item border rounded mt-2">
            <h2 class="accordion-header" id="headingTwitter">
                <button class="accordion-button fw-medium collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwitter" aria-expanded="false" aria-controls="collapseTwitter">
                    @lang('settings.twitter_pixel')
                </button>
            </h2>
            <div id="collapseTwitter" class="accordion-collapse collapse mt-3" aria-labelledby="headingTwitter">
                <div class="accordion-body">
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label">@lang('settings.twitter_pixel')</label>
                        <div class="col-sm-8">
                            <textarea name="twitter_pixel_id" class="form-control" cols="30" rows="6">{{ $settings['twitter_pixel_id'] ?? '' }}</textarea>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-check form-switch form-check-success mt-1">
                                <input type="hidden" name="show_twitter_pixel" value="0">
                                <input class="form-check-input" type="checkbox" name="show_twitter_pixel" @if(@$settings['show_twitter_pixel']==1 ) checked @endif>
                                <label class="form-check-label">@lang('settings.enable')</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Custom Script Pixel --}}
        <div class="accordion-item border rounded mt-2">
            <h2 class="accordion-header" id="headingCustom">
                <button class="accordion-button fw-medium collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCustom" aria-expanded="false" aria-controls="collapseCustom">
                    @lang('settings.custom_pixel_script')
                </button>
            </h2>
            <div id="collapseCustom" class="accordion-collapse collapse mt-3" aria-labelledby="headingCustom">
                <div class="accordion-body">
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label">@lang('settings.custom_pixel_script')</label>
                        <div class="col-sm-10">
                            <textarea name="custom_pixel_script" class="form-control" cols="30" rows="6">{{ $settings['custom_pixel_script'] ?? '' }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="row mb-3 text-end">
        <div>
            <a href="{{ route('admin.settings.index') }}" class="btn btn-outline-primary btn-sm">@lang('button.cancel')</a>
            <button type="submit" class="btn btn-outline-success btn-sm">@lang('button.save')</button>
        </div>
    </div>
</form>
@endsection
