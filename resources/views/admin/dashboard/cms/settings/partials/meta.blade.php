@extends('admin.app')

@section('title', trans('settings.edit', ['name' =>  $settingMain->title]) )
@section('title_page', trans('settings.settings'))
@section('title_route', route('admin.settings.index') )
@section('button_page')
<a href="{{ route('admin.settings.index') }}" class="btn btn-outline-primary waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
@endsection


@section('style')
{{-- @vite(['resources/assets/admin/css/data-tables.js']) --}}
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="{{ asset('site/js/ckeditor/ckeditor.js') }}"></script>
@endsection

@section('content')

<div class="card">
    <div class="card-body">

        <form class="form-horizontal" action="{{ route('admin.settings.update', $settingMain->key) }}" method="POST" enctype="multipart/form-data" role="form">
            @csrf

            <div class="row">
                <div class="col-md-12">

                    <div class="accordion mt-4 mb-4" id="accordionExample">
                        <div class="accordion-item border rounded">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    @lang('settings.home')
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse show mt-3" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                <div class="accordion-body">

                                    @foreach ($languages as $key => $locale)
                                    {{-- meta_title_ ------------------------------------------------------------------------------------- --}}
                                    <div class="row mb-3">
                                        <label for="example-text-input" class="col-sm-2 col-form-label">{{ trans('admin.meta_title_in') . trans('lang.' .Locale::getDisplayName($locale)) }}</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" type="text" name="home_meta_title_{{ $locale }}" value="{{ @$settings['home_meta_title_' . $locale] }}" id="title{{ $key }}">
                                        </div>
                                    </div>

                                    {{-- meta_description_ ------------------------------------------------------------------------------------- --}}
                                    <div class="row mb-3">
                                        <label for="example-text-input" class="col-sm-2 col-form-label"> {{ trans('admin.meta_description_in') . trans('lang.' .Locale::getDisplayName($locale)) }}
                                        </label>
                                        <div class="col-sm-10 mb-2">
                                            <textarea name="home_meta_description_{{ $locale }}" class="form-control description"> {{ @$settings['home_meta_description_' . $locale] }} </textarea>

                                        </div>
                                    </div>

                                    {{-- meta_key_ ------------------------------------------------------------------------------------- --}}
                                    <div class="row mb-3">
                                        <label for="example-text-input" class="col-sm-2 col-form-label"> {{ trans('admin.meta_key_in') . trans('lang.' .Locale::getDisplayName($locale)) }}
                                        </label>
                                        <div class="col-sm-10 mb-2">
                                            <textarea name="home_meta_key_{{ $locale }}" class="form-control description"> {{ @$settings['home_meta_key_' . $locale] }} </textarea>

                                        </div>
                                    </div>
                                    <hr>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="accordion mt-4 mb-4" id="accordionExample">
                        <div class="accordion-item border rounded">
                            <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                                    @lang('settings.services')
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse show mt-3" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                <div class="accordion-body">

                                    @foreach ($languages as $key => $locale)
                                    {{-- meta_title_ ------------------------------------------------------------------------------------- --}}
                                    <div class="row mb-3">
                                        <label for="example-text-input" class="col-sm-2 col-form-label">{{ trans('admin.meta_title_in') . trans('lang.' .Locale::getDisplayName($locale)) }}</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" type="text" name="services_meta_title_{{ $locale }}" value="{{ @$settings['services_meta_title_' . $locale] }}" id="title{{ $key }}">
                                        </div>
                                    </div>

                                    {{-- meta_description_ ------------------------------------------------------------------------------------- --}}
                                    <div class="row mb-3">
                                        <label for="example-text-input" class="col-sm-2 col-form-label"> {{ trans('admin.meta_description_in') . trans('lang.' .Locale::getDisplayName($locale)) }}
                                        </label>
                                        <div class="col-sm-10 mb-2">
                                            <textarea name="services_meta_description_{{ $locale }}" class="form-control description"> {{ @$settings['services_meta_description_' . $locale] }} </textarea>

                                        </div>
                                    </div>

                                    {{-- meta_key_ ------------------------------------------------------------------------------------- --}}
                                    <div class="row mb-3">
                                        <label for="example-text-input" class="col-sm-2 col-form-label"> {{ trans('admin.meta_key_in') . trans('lang.' .Locale::getDisplayName($locale)) }}
                                        </label>
                                        <div class="col-sm-10 mb-2">
                                            <textarea name="services_meta_key_{{ $locale }}" class="form-control description"> {{ @$settings['services_meta_key_' . $locale] }} </textarea>

                                        </div>
                                    </div>
                                    <hr>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="accordion mt-4 mb-4" id="accordionExample">
                        <div class="accordion-item border rounded">
                            <h2 class="accordion-header" id="headingTree">
                                <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTree" aria-expanded="true" aria-controls="collapseTree">
                                    @lang('settings.blogs')
                                </button>
                            </h2>
                            <div id="collapseTree" class="accordion-collapse collapse show mt-3" aria-labelledby="headingTree" data-bs-parent="#accordionExample">
                                <div class="accordion-body">

                                    @foreach ($languages as $key => $locale)
                                    {{-- meta_title_ ------------------------------------------------------------------------------------- --}}
                                    <div class="row mb-3">
                                        <label for="example-text-input" class="col-sm-2 col-form-label">{{ trans('admin.meta_title_in') . trans('lang.' .Locale::getDisplayName($locale)) }}</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" type="text" name="blogs_meta_title_{{ $locale }}" value="{{ @$settings['blogs_meta_title_' . $locale] }}" id="title{{ $key }}">
                                        </div>
                                    </div>

                                    {{-- meta_description_ ------------------------------------------------------------------------------------- --}}
                                    <div class="row mb-3">
                                        <label for="example-text-input" class="col-sm-2 col-form-label"> {{ trans('admin.meta_description_in') . trans('lang.' .Locale::getDisplayName($locale)) }}
                                        </label>
                                        <div class="col-sm-10 mb-2">
                                            <textarea name="blogs_meta_description_{{ $locale }}" class="form-control description"> {{ @$settings['blogs_meta_description_' . $locale] }} </textarea>

                                        </div>
                                    </div>

                                    {{-- meta_key_ ------------------------------------------------------------------------------------- --}}
                                    <div class="row mb-3">
                                        <label for="example-text-input" class="col-sm-2 col-form-label"> {{ trans('admin.meta_key_in') . trans('lang.' .Locale::getDisplayName($locale)) }}
                                        </label>
                                        <div class="col-sm-10 mb-2">
                                            <textarea name="blogs_meta_key_{{ $locale }}" class="form-control description"> {{ @$settings['blogs_meta_key_' . $locale] }} </textarea>

                                        </div>
                                    </div>
                                    <hr>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="accordion mt-4 mb-4" id="accordionExample">
                        <div class="accordion-item border rounded">
                            <h2 class="accordion-header" id="headingFour">
                                <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="true" aria-controls="collapseFour">
                                    @lang('settings.portfolio')
                                </button>
                            </h2>
                            <div id="collapseFour" class="accordion-collapse collapse show mt-3" aria-labelledby="headingFour" data-bs-parent="#accordionExample">
                                <div class="accordion-body">

                                    @foreach ($languages as $key => $locale)
                                    {{-- meta_title_ ------------------------------------------------------------------------------------- --}}
                                    <div class="row mb-3">
                                        <label for="example-text-input" class="col-sm-2 col-form-label">{{ trans('admin.meta_title_in') . trans('lang.' .Locale::getDisplayName($locale)) }}</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" type="text" name="portfolio_meta_title_{{ $locale }}" value="{{ @$settings['portfolio_meta_title_' . $locale] }}" id="title{{ $key }}">
                                        </div>
                                    </div>

                                    {{-- meta_description_ ------------------------------------------------------------------------------------- --}}
                                    <div class="row mb-3">
                                        <label for="example-text-input" class="col-sm-2 col-form-label"> {{ trans('admin.meta_description_in') . trans('lang.' .Locale::getDisplayName($locale)) }}
                                        </label>
                                        <div class="col-sm-10 mb-2">
                                            <textarea name="portfolio_meta_description_{{ $locale }}" class="form-control description"> {{ @$settings['portfolio_meta_description_' . $locale] }} </textarea>

                                        </div>
                                    </div>

                                    {{-- meta_key_ ------------------------------------------------------------------------------------- --}}
                                    <div class="row mb-3">
                                        <label for="example-text-input" class="col-sm-2 col-form-label"> {{ trans('admin.meta_key_in') . trans('lang.' .Locale::getDisplayName($locale)) }}
                                        </label>
                                        <div class="col-sm-10 mb-2">
                                            <textarea name="portfolio_meta_key_{{ $locale }}" class="form-control description"> {{ @$settings['portfolio_meta_key_' . $locale] }} </textarea>

                                        </div>
                                    </div>
                                    <hr>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="accordion mt-4 mb-4" id="accordionExample">
                        <div class="accordion-item border rounded">
                            <h2 class="accordion-header" id="headingTree">
                                <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTree" aria-expanded="true" aria-controls="collapseTree">
                                    @lang('settings.offers')
                                </button>
                            </h2>
                            <div id="collapseTree" class="accordion-collapse collapse show mt-3" aria-labelledby="headingTree" data-bs-parent="#accordionExample">
                                <div class="accordion-body">

                                    @foreach ($languages as $key => $locale)
                                    {{-- meta_title_ ------------------------------------------------------------------------------------- --}}
                                    <div class="row mb-3">
                                        <label for="example-text-input" class="col-sm-2 col-form-label">{{ trans('admin.meta_title_in') . trans('lang.' .Locale::getDisplayName($locale)) }}</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" type="text" name="offers_meta_title_{{ $locale }}" value="{{ @$settings['offers_meta_title_' . $locale] }}" id="title{{ $key }}">
                                        </div>
                                    </div>

                                    {{-- meta_description_ ------------------------------------------------------------------------------------- --}}
                                    <div class="row mb-3">
                                        <label for="example-text-input" class="col-sm-2 col-form-label"> {{ trans('admin.meta_description_in') . trans('lang.' .Locale::getDisplayName($locale)) }}
                                        </label>
                                        <div class="col-sm-10 mb-2">
                                            <textarea name="offers_meta_description_{{ $locale }}" class="form-control description"> {{ @$settings['offers_meta_description_' . $locale] }} </textarea>

                                        </div>
                                    </div>

                                    {{-- meta_key_ ------------------------------------------------------------------------------------- --}}
                                    <div class="row mb-3">
                                        <label for="example-text-input" class="col-sm-2 col-form-label"> {{ trans('admin.meta_key_in') . trans('lang.' .Locale::getDisplayName($locale)) }}
                                        </label>
                                        <div class="col-sm-10 mb-2">
                                            <textarea name="offers_meta_key_{{ $locale }}" class="form-control description"> {{ @$settings['offers_meta_key_' . $locale] }} </textarea>

                                        </div>
                                    </div>
                                    <hr>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="accordion mt-4 mb-4" id="accordionExample">
                        <div class="accordion-item border rounded">
                            <h2 class="accordion-header" id="headingFive">
                                <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="true" aria-controls="collapseFive">
                                    @lang('settings.contact')
                                </button>
                            </h2>
                            <div id="collapseFive" class="accordion-collapse collapse show mt-3" aria-labelledby="headingFive" data-bs-parent="#accordionExample">
                                <div class="accordion-body">

                                    @foreach ($languages as $key => $locale)
                                    {{-- meta_title_ ------------------------------------------------------------------------------------- --}}
                                    <div class="row mb-3">
                                        <label for="example-text-input" class="col-sm-2 col-form-label">{{ trans('admin.meta_title_in') . trans('lang.' .Locale::getDisplayName($locale)) }}</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" type="text" name="contact_meta_title_{{ $locale }}" value="{{ @$settings['contact_meta_title_' . $locale] }}" id="title{{ $key }}">
                                        </div>
                                    </div>

                                    {{-- meta_description_ ------------------------------------------------------------------------------------- --}}
                                    <div class="row mb-3">
                                        <label for="example-text-input" class="col-sm-2 col-form-label"> {{ trans('admin.meta_description_in') . trans('lang.' .Locale::getDisplayName($locale)) }}
                                        </label>
                                        <div class="col-sm-10 mb-2">
                                            <textarea name="contact_meta_description_{{ $locale }}" class="form-control description"> {{ @$settings['contact_meta_description_' . $locale] }} </textarea>

                                        </div>
                                    </div>

                                    {{-- meta_key_ ------------------------------------------------------------------------------------- --}}
                                    <div class="row mb-3">
                                        <label for="example-text-input" class="col-sm-2 col-form-label"> {{ trans('admin.meta_key_in') . trans('lang.' .Locale::getDisplayName($locale)) }}
                                        </label>
                                        <div class="col-sm-10 mb-2">
                                            <textarea name="contact_meta_key_{{ $locale }}" class="form-control description"> {{ @$settings['contact_meta_key_' . $locale] }} </textarea>

                                        </div>
                                    </div>
                                    <hr>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pixel Settings Section -->
                    <div class="accordion mt-4 mb-4" id="accordionPixel">
                        <div class="accordion-item border rounded">
                            <h2 class="accordion-header" id="headingPixel">
                                <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" 
                                        data-bs-target="#collapsePixel" aria-expanded="true" aria-controls="collapsePixel">
                                    @lang('settings.pixel_settings')
                                </button>
                            </h2>
                            <div id="collapsePixel" class="accordion-collapse collapse show mt-3" 
                                 aria-labelledby="headingPixel">
                                <div class="accordion-body">
                                    <!-- Google Pixel -->
                                    <div class="row mb-3">
                                        <label class="col-sm-2 col-form-label">@lang('settings.google_pixel')</label>
                                        <div class="col-sm-8">
                                            <textarea name="google_pixel_id" class="form-control" rows="4">{{ @$settings['google_pixel_id'] ?? '' }}</textarea>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-check form-switch form-check-success mt-1">
                                                <input type="hidden" name="show_google_pixel" value="0">
                                                <input class="form-check-input" type="checkbox" name="show_google_pixel" 
                                                       @if(@$settings['show_google_pixel'] == 1) checked @endif value="1">
                                                <label class="form-check-label">@lang('settings.enable')</label>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Meta Pixel -->
                                    <div class="row mb-3">
                                        <label class="col-sm-2 col-form-label">@lang('settings.meta_pixel')</label>
                                        <div class="col-sm-8">
                                            <textarea name="meta_pixel_id" class="form-control" rows="4">{{ @$settings['meta_pixel_id'] ?? '' }}</textarea>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-check form-switch form-check-success mt-1">
                                                <input type="hidden" name="show_meta_pixel" value="0">
                                                <input class="form-check-input" type="checkbox" name="show_meta_pixel" 
                                                       @if(@$settings['show_meta_pixel'] == 1) checked @endif value="1">
                                                <label class="form-check-label">@lang('settings.enable')</label>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Snapchat Pixel -->
                                    <div class="row mb-3">
                                        <label class="col-sm-2 col-form-label">@lang('settings.snapchat_pixel')</label>
                                        <div class="col-sm-8">
                                            <textarea name="snapchat_pixel_id" class="form-control" rows="4">{{ @$settings['snapchat_pixel_id'] ?? '' }}</textarea>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-check form-switch form-check-success mt-1">
                                                <input type="hidden" name="show_snapchat_pixel" value="0">
                                                <input class="form-check-input" type="checkbox" name="show_snapchat_pixel" 
                                                       @if(@$settings['show_snapchat_pixel'] == 1) checked @endif value="1">
                                                <label class="form-check-label">@lang('settings.enable')</label>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- TikTok Pixel -->
                                    <div class="row mb-3">
                                        <label class="col-sm-2 col-form-label">@lang('settings.tiktok_pixel')</label>
                                        <div class="col-sm-8">
                                            <textarea name="tiktok_pixel_id" class="form-control" rows="4">{{ @$settings['tiktok_pixel_id'] ?? '' }}</textarea>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-check form-switch form-check-success mt-1">
                                                <input type="hidden" name="show_tiktok_pixel" value="0">
                                                <input class="form-check-input" type="checkbox" name="show_tiktok_pixel" 
                                                       @if(@$settings['show_tiktok_pixel'] == 1) checked @endif value="1">
                                                <label class="form-check-label">@lang('settings.enable')</label>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Twitter Pixel -->
                                    <div class="row mb-3">
                                        <label class="col-sm-2 col-form-label">@lang('settings.twitter_pixel')</label>
                                        <div class="col-sm-8">
                                            <textarea name="twitter_pixel_id" class="form-control" rows="4">{{ @$settings['twitter_pixel_id'] ?? '' }}</textarea>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-check form-switch form-check-success mt-1">
                                                <input type="hidden" name="show_twitter_pixel" value="0">
                                                <input class="form-check-input" type="checkbox" name="show_twitter_pixel" 
                                                       @if(@$settings['show_twitter_pixel'] == 1) checked @endif value="1">
                                                <label class="form-check-label">@lang('settings.enable')</label>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Custom Pixel Script -->
                                    <div class="row mb-3">
                                        <label class="col-sm-2 col-form-label">@lang('settings.custom_pixel')</label>
                                        <div class="col-sm-10">
                                            <textarea name="custom_pixel_script" class="form-control" rows="6" placeholder="Paste your custom pixel/analytics code here">{{ @$settings['custom_pixel_script'] ?? '' }}</textarea>
                                            <small class="text-muted">@lang('settings.custom_pixel_help')</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Pixel Settings Section -->

                    <div class="row mb-3 text-end">
                        <div>
                            <a href="{{ route('admin.settings.index') }}" class="btn btn-outline-primary waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
                            <button type="submit" class="btn btn-outline-success waves-effect waves-light ml-3 btn-sm">@lang('button.save')</button>
                        </div>
                    </div>
                    <!-- /.card-footer -->
                </form>
            </div>
            <!-- /.card -->
        </div>
    </div>
@endsection




@section('script')
{{-- @vite(['resources/assets/admin/js/data-tables.js']) --}}
@endsection
