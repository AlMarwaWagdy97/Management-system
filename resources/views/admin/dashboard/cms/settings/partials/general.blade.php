@extends('admin.app')

@section('title', trans('settings.edit', ['name' => $settingMain->title]))
@section('title_page', trans('settings.settings'))
@section('title_route', route('admin.settings.index'))
@section('button_page')
<a href="{{ route('admin.settings.index') }}" class="btn btn-outline-primary waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
@endsection


@section('style')
{{-- @vite(['resources/assets/admin/css/data-tables.js']) --}}
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="{{ asset('site/js/ckeditor/ckeditor.js') }}"></script>
@endsection

@section('content')


<form class="form-horizontal" action="{{ route('admin.settings.update-custom', $settingMain->key) }}" method="POST" enctype="multipart/form-data" role="form">
    @csrf


    <div class="row text-center mt-5 mb-3">
        <label class="col-sm-2 col-form-label"> @lang('settings.title_setting') </label>
        <div class="col-sm-10">
            <input class="form-control" type="text" name="title" value="{{ @$settings['title'] }}" required>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">

            {{-- general setting  --}}
            <div class="accordion mt-4 mb-4" id="accordionGeneral">
                <div class="accordion-item border rounded">
                    <h2 class="accordion-header" id="headingGeneral">
                        <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseGeneral" aria-expanded="true" aria-controls="collapseGeneral">
                            @lang('settings.settings')
                        </button>
                    </h2>
                    <div id="collapseGeneral" class="accordion-collapse collapse show mt-3" aria-labelledby="headingGeneral" data-bs-parent="#accordionGeneral">
                        <div class="accordion-body">
                            <div class="row">
                                {{-- Welcome Message --}}
                                @forelse ($languages as $key => $locale)
                                <div class="col-12 col-md-6">
                                    <div class="row mb-3">
                                        <label class="col-sm-3 col-form-label">
                                            {{ trans('settings.welcome_message') . ' (' . trans('lang.' . \Locale::getDisplayName($locale)) . ')' }}
                                        </label>
                                        <div class="col-sm-9">
                                            <input class="form-control" type="text" name="welcome_message_{{ $locale }}" value="{{ @$settings['welcome_message_' . $locale] }}" placeholder="@lang('settings.enter_welcome_message')">
                                        </div>
                                    </div>
                                </div>
                                @empty
                                <div class="col-12">
                                    <p class="text-muted">@lang('No languages available')</p>
                                </div>
                                @endforelse
                                {{-- link applications  --}}
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <div class="row mb-3">
                                            <label class="col-sm-2 col-form-label"> @lang('settings.google_play') </label>
                                            <div class="col-sm-9">
                                                <input class="form-control" type="url" name="google_play" value="{{ @$settings['google_play'] }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="row mb-3">
                                            <label class="col-sm-2 col-form-label"> @lang('settings.app_store') </label>
                                            <div class="col-sm-9">
                                                <input class="form-control" type="url" name="app_store" value="{{ @$settings['app_store'] }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- item status --}}
                                <div class="row">
                                    <div class="col-12 col-md-4">
                                        <div class="row mb-3">
                                            <label class="col-sm-4 col-form-label"> @lang('settings.show_slider') </label>
                                            <div class="col-sm-5">
                                                <div class="form-check form-switch form-check-success mt-1">
                                                    <input type="hidden" name="show_slider" value="0">
                                                    <input class="form-check-input" type="checkbox" name="show_slider" {{ @$settings['show_slider'] == 1 ? 'checked' : '' }} id="show_slider">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <div class="row mb-3">
                                            <label class="col-sm-4 col-md-5 col-form-label"> @lang('settings.show_category') </label>
                                            <div class="col-sm-5 col-md-5">
                                                <div class="form-check form-switch form-check-success mt-1">
                                                    <input type="hidden" name="show_category" value="0">
                                                    <input class="form-check-input" type="checkbox" name="show_category" {{ @$settings['show_category'] == 1 ? 'checked' : '' }} id="show_category">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <div class="row mb-3">
                                            <label class="col-sm-4 col-md-5 col-form-label"> @lang('settings.show_products') </label>
                                            <div class="col-sm-5 col-md-5">
                                                <div class="form-check form-switch form-check-success mt-1">
                                                    <input type="hidden" name="show_products" value="0">
                                                    <input class="form-check-input" type="checkbox" name="show_products" {{ @$settings['show_products'] == 1 ? 'checked' : '' }} id="show_products">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <div class="row mb-3">
                                            <label class="col-sm-4 col-md-5 col-form-label"> @lang('settings.show_fast_donation') </label>
                                            <div class="col-sm-5 col-md-5">
                                                <div class="form-check form-switch form-check-success mt-1">
                                                    <input type="hidden" name="show_fast_donation" value="0">
                                                    <input class="form-check-input" type="checkbox" name="show_fast_donation" {{ @$settings['show_fast_donation'] == 1 ? 'checked' : '' }} id="show_fast_donation">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-4">
                                        <div class="row mb-3">
                                            <label class="col-sm-4 col-md-5 col-form-label"> @lang('settings.show_most_order') </label>
                                            <div class="col-sm-5 col-md-5">
                                                <div class="form-check form-switch form-check-success mt-1">
                                                    <input type="hidden" name="show_most_order" value="0">
                                                    <input class="form-check-input" type="checkbox" name="show_most_order" {{ @$settings['show_most_order'] == 1 ? 'checked' : '' }} id="show_most_order">
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

            {{-- logo & icons  --}}
            <div class="accordion mt-4 mb-4" id="accordionFooter">
                <div class="accordion-item border rounded">
                    <h2 class="accordion-header" id="headingFooter">
                        <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFooter" aria-expanded="true" aria-controls="collapseFooter">
                            @lang('settings.logo&Icons')
                        </button>
                    </h2>
                    <div id="collapseFooter" class="accordion-collapse collapse show mt-3" aria-labelledby="headingFooter" data-bs-parent="#accordionFooter">
                        <div class="accordion-body">
                            @forelse ($languages as $key => $locale)
                            {{-- logos  --}}
                            <div class="col-12 col-md-6">
                                <div class="row">

                                    <div class="col-sm-6">
                                        <label class="col-sm-12 col-form-label">
                                            {{ trans('settings.logo') . ' (' . trans('lang.' . Locale::getDisplayName($locale)) . ')' }}
                                        </label>
                                        <input class="form-control @error('logo_' . $locale) is-invalid @enderror" type="file" name="logo_{{ $locale }}" accept="image/*">
                                        <small class="text-danger pt-2">المقاس المطلوب: <strong>400px ×
                                                450px</strong>
                                        </small>
                                        @error('logo_' . $locale)
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    @if (isset($settings['logo_' . $locale]))
                                    <div class="col-sm-6">
                                        <a href="{{ getImage(@$settings['logo_' . $locale]) }}">
                                            <img src="{{ asset(getImageThumb(@$settings['logo_' . $locale])) }}" width="50px" />
                                        </a>
                                    </div>
                                    @else
                                    <div class="col-sm-3">
                                        <img src="{{ admin_path('images/not_found.PNG') }}" width="50px" />
                                    </div>
                                    @endif
                                </div>
                            </div>
                            {{-- icons  --}}

                            {{-- logos  Mobile --}}
                            <div class="col-12 col-md-6">
                                <div class="row">

                                    <div class="col-sm-6">
                                        <label class="col-sm-12 col-form-label">
                                            {{ trans('settings.logo_mobile') . ' (' . trans('lang.' . Locale::getDisplayName($locale)) . ')' }}
                                        </label>
                                        <input class="form-control @error('logo_' . $locale) is-invalid @enderror" type="file" name="logo_mobile_{{ $locale }}" accept="image/*">
                                        <small class="text-danger pt-2">المقاس المطلوب: <strong>400px ×
                                                450px</strong>
                                        </small>
                                        @error('logo_mobile_' . $locale)
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    @if (isset($settings['logo_mobile_' . $locale]))
                                    <div class="col-sm-6">
                                        <a href="{{ getImage(@$settings['logo_' . $locale]) }}">
                                            <img src="{{ asset(getImageThumb(@$settings['logo_mobile_' . $locale])) }}" width="50px" />
                                        </a>
                                    </div>
                                    @else
                                    <div class="col-sm-3">
                                        <img src="{{ admin_path('images/not_found.PNG') }}" width="50px" />
                                    </div>
                                    @endif
                                </div>
                            </div>
                            {{-- Mobile --}}

                            @empty
                            @endforelse

                            <div class="col-12 col-md-6">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <label class="col-sm-12 col-form-label"> @lang('settings.icons')</label>
                                        <input class="form-control" type="file" name="icon">
                                    </div>
                                    @if (isset($settings['icon']))
                                    <div class="col-sm-6">
                                        <a href="{{ asset(getImage(@$settings['icon'])) }}">
                                            <img src="{{ asset(getImageThumb(@$settings['icon'])) }}" width="50px" />
                                        </a>
                                    </div>
                                    @else
                                    <div class="col-sm-3">
                                        <img src="{{ admin_path('images/not_found.PNG') }}" width="50px" />
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            {{-- banars  --}}
            <div class="accordion mt-4 mb-4" id="accordionBanars">
                <div class="accordion-item border rounded">
                    <h2 class="accordion-header" id="headingBanars">
                        <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseBanars" aria-expanded="true" aria-controls="collapseBanars">
                            @lang('settings.Banars')
                        </button>
                    </h2>
                    <div id="collapseBanars" class="accordion-collapse collapse show mt-3" aria-labelledby="headingBanars" data-bs-parent="#accordionFooter">
                        <div class="accordion-body">
                            {{-- banar web   --}}
                            <div class="row">
                                <div class="col-9 my-3">
                                    <label> @lang('admin.title') </label>
                                    <input type="text" name="banar_title" value="{{ @$settings['banar_title'] }}" class="form-control">
                                </div>
                                {{-- banar web 1  --}}
                                <div class="col-12 col-md-6 mt-2">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label> @lang('settings.banarWeb1') </label>
                                            <input class="form-control" type="file" placeholder="@lang('settings.banarWeb1')" name="banarWeb1">
                                            <small class="text-danger">المقاس المطلوب: <strong>2948px ×
                                                    814px</strong> </small>
                                            @error('banarWeb1')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror

                                        </div>
                                        @if (isset($settings['banarWeb1']))
                                        <div class="col-sm-6">
                                            <a href="{{ getImage($settings['banarWeb1']) }}">
                                                <img src="{{ asset(getImageThumb($settings['banarWeb1'])) }}" width="50px" />
                                            </a>
                                        </div>
                                        @else
                                        <div class="col-sm-3">
                                            <img src="{{ admin_path('images/not_found.PNG') }}" width="50px" />
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 mt-2">
                                    <label> @lang('admin.link') </label>
                                    <input type="text" name="banarWeb1_link" value="{{ @$settings['banarWeb1_link'] }}" class="form-control">
                                </div>
                                {{-- banar web 2  --}}
                                <div class="col-12 col-md-6 mt-2">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label> @lang('settings.banarWeb2') </label>
                                            <input class="form-control" type="file" placeholder="@lang('settings.banarWeb2')" name="banarWeb2">
                                            <small class="text-danger">المقاس المطلوب: <strong>1721px ×
                                                    1748px</strong> </small>
                                            @error('banarWeb2')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        @if (isset($settings['banarWeb2']))
                                        <div class="col-sm-6">
                                            <a href="{{ getImage($settings['banarWeb2']) }}">
                                                <img src="{{ asset(getImageThumb($settings['banarWeb2'])) }}" width="50px" />
                                            </a>
                                        </div>
                                        @else
                                        <div class="col-sm-3">
                                            <img src="{{ admin_path('images/not_found.PNG') }}" width="50px" />
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 mt-2">
                                    <label> @lang('admin.link') </label>
                                    <input type="text" name="banarWeb2_link" value="{{ @$settings['banarWeb2_link'] }}" class="form-control">
                                </div>
                                {{-- banar web 3  --}}
                                <div class="col-12 col-md-6 mt-2">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label> @lang('settings.banarWeb3') </label>
                                            <input class="form-control" type="file" placeholder="@lang('settings.banarWeb3')" name="banarWeb3">
                                            <small class="text-danger">المقاس المطلوب: <strong>2948px ×
                                                    814px</strong> </small>
                                            @error('banarWeb3')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        @if (isset($settings['banarWeb3']))
                                        <div class="col-sm-6">
                                            <a href="{{ getImage($settings['banarWeb3']) }}">
                                                <img src="{{ asset(getImageThumb($settings['banarWeb3'])) }}" width="50px" />
                                            </a>
                                        </div>
                                        @else
                                        <div class="col-sm-3">
                                            <img src="{{ admin_path('images/not_found.PNG') }}" width="50px" />
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 mt-2">
                                    <label> @lang('admin.link') </label>
                                    <input type="text" name="banarWeb3_link" value="{{ @$settings['banarWeb3_link'] }}" class="form-control">
                                </div>
                                {{-- banar web 4  --}}
                                <div class="col-12 col-md-6 mt-2">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label> @lang('settings.banarWeb4') </label>
                                            <input class="form-control" type="file" placeholder="@lang('settings.banarWeb3')" name="banarWeb4">
                                            <small class="text-danger">المقاس المطلوب: <strong>2948px ×
                                                    738px</strong> </small>
                                            @error('banarWeb4')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        @if (isset($settings['banarWeb4']))
                                        <div class="col-sm-6">
                                            <a href="{{ getImage($settings['banarWeb4']) }}">
                                                <img src="{{ asset(getImageThumb($settings['banarWeb4'])) }}" width="50px" />
                                            </a>
                                        </div>
                                        @else
                                        <div class="col-sm-3">
                                            <img src="{{ admin_path('images/not_found.PNG') }}" width="50px" />
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 mt-2">
                                    <label> @lang('admin.link') </label>
                                    <input type="text" name="banarWeb4_link" value="{{ @$settings['banarWeb4_link'] }}" class="form-control">
                                </div>
                            </div>
                            <hr>
                            {{-- banar mobile   --}}
                            <div class="row">
                                {{-- banar mobile 1  --}}
                                <div class="col-12 col-md-6 mt-2">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label> @lang('settings.banarMobile1') </label>
                                            <input class="form-control" type="file" name="banarMobile1">
                                        </div>
                                        @if (isset($settings['banarMobile1']))
                                        <div class="col-sm-6">
                                            <a href="{{ getImage($settings['banarMobile1']) }}">
                                                <img src="{{ asset(getImageThumb($settings['banarMobile1'])) }}" width="50px" />
                                            </a>
                                        </div>
                                        @else
                                        <div class="col-sm-3">
                                            <img src="{{ admin_path('images/not_found.PNG') }}" width="50px" />
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 mt-2">
                                    <label> @lang('admin.link') </label>
                                    <input type="text" name="banarMobile1_link" value="{{ @$settings['banarMobile1_link'] }}" class="form-control">
                                </div>
                                {{-- banar mobile 2  --}}
                                <div class="col-12 col-md-6 mt-2">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label> @lang('settings.banarMobile2') </label>
                                            <input class="form-control" type="file" name="banarMobile2">
                                        </div>
                                        @if (isset($settings['banarMobile2']))
                                        <div class="col-sm-6">
                                            <a href="{{ getImage($settings['banarMobile2']) }}">
                                                <img src="{{ asset(getImageThumb($settings['banarMobile2'])) }}" width="50px" />
                                            </a>
                                        </div>
                                        @else
                                        <div class="col-sm-3">
                                            <img src="{{ admin_path('images/not_found.PNG') }}" width="50px" />
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 mt-2">
                                    <label> @lang('admin.link') </label>
                                    <input type="text" name="banarMobile2_link" value="{{ @$settings['banarMobile2_link'] }}" class="form-control">
                                </div>
                                {{-- banar mobile 3  --}}
                                <div class="col-12 col-md-6 mt-2">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label> @lang('settings.banarMobile3') </label>
                                            <input class="form-control" type="file" name="banarMobile3">
                                        </div>
                                        @if (isset($settings['banarMobile3']))
                                        <div class="col-sm-6">
                                            <a href="{{ getImage($settings['banarMobile3']) }}">
                                                <img src="{{ asset(getImageThumb($settings['banarMobile3'])) }}" width="50px" />
                                            </a>
                                        </div>
                                        @else
                                        <div class="col-sm-3">
                                            <img src="{{ admin_path('images/not_found.PNG') }}" width="50px" />
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 mt-2">
                                    <label> @lang('admin.link') </label>
                                    <input type="text" name="banarMobile3_link" value="{{ @$settings['banarMobile3_link'] }}" class="form-control">
                                </div>
                            </div>
                            {{-- banar status   --}}
                            <div class="col-12 col-md-6 mt-2">
                                <div class="row mb-3">
                                    <label class="col-sm-4 col-form-label"> @lang('settings.show_banars') </label>
                                    <div class="col-sm-5">
                                        <div class="form-check form-switch form-check-success mt-1">
                                            <input type="hidden" name="show_banars" value="0">
                                            <input class="form-check-input" type="checkbox" name="show_banars" {{ @$settings['show_banars'] == 1 ? 'checked' : '' }} id="show_banars">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- counts  --}}
            {{-- <div class="accordion mt-4 mb-4" id="accordionCounts">
                    <div class="accordion-item border rounded">
                        <h2 class="accordion-header" id="headingCounts">
                            <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseCounts" aria-expanded="true" aria-controls="collapseCounts">
                                @lang('settings.countsData')
                            </button>
                        </h2>
                        <div id="collapseCounts" class="accordion-collapse collapse show mt-3"
                            aria-labelledby="headingCounts" data-bs-parent="#accordionCounts">
                            <div class="accordion-body">
                                <div class="row">
                                    <div class="col-12 col-md-6 mt-2">
                                        <label> @lang('admin.title') </label>
                                        <input type="text" name="count1_title"
                                            value="{{ @$settings['count1_title'] }}" class="form-control">
        </div>
        <div class="col-12 col-md-6 mt-2">
            <label> @lang('admin.count') </label>
            <input type="text" name="count1_number" value="{{ @$settings['count1_number'] }}" class="form-control">
        </div>
        <div class="col-12 col-md-6 mt-2">
            <div class="row">
                <div class="col-sm-6">
                    <label> @lang('admin.image') </label>
                    <input class="form-control" type="file" placeholder="@lang('admin.image')" name="count1_img">
                </div>
                @if (isset($settings['count1_img']))
                <div class="col-sm-6">
                    <a href="{{ getImage($settings['count1_img']) }}">
                        <img src="{{ asset(getImageThumb($settings['count1_img'])) }}" width="50px" />
                    </a>
                </div>
                @else
                <div class="col-sm-3">
                    <img src="{{ admin_path('images/not_found.PNG') }}" width="50px" />
                </div>
                @endif
            </div>
        </div>

    </div>
    <hr>

    <div class="row">
        <div class="col-12 col-md-6 mt-2">
            <label> @lang('admin.title') </label>
            <input type="text" name="count2_title" value="{{ @$settings['count2_title'] }}" class="form-control">
        </div>
        <div class="col-12 col-md-6 mt-2">
            <label> @lang('admin.count') </label>
            <input type="text" name="count2_number" value="{{ @$settings['count2_number'] }}" class="form-control">
        </div>
        <div class="col-12 col-md-6 mt-2">
            <div class="row">
                <div class="col-sm-6">
                    <label> @lang('admin.image') </label>
                    <input class="form-control" type="file" placeholder="@lang('admin.image')" name="count2_img">
                </div>
                @if (isset($settings['count2_img']))
                <div class="col-sm-6">
                    <a href="{{ getImage($settings['count2_img']) }}">
                        <img src="{{ asset(getImageThumb($settings['count2_img'])) }}" width="50px" />
                    </a>
                </div>
                @else
                <div class="col-sm-3">
                    <img src="{{ admin_path('images/not_found.PNG') }}" width="50px" />
                </div>
                @endif
            </div>
        </div>

    </div>
    <hr>

    <div class="row">
        <div class="col-12 col-md-6 mt-2">
            <label> @lang('admin.title') </label>
            <input type="text" name="count3_title" value="{{ @$settings['count3_title'] }}" class="form-control">
        </div>
        <div class="col-12 col-md-6 mt-2">
            <label> @lang('admin.count') </label>
            <input type="text" name="count3_number" value="{{ @$settings['count3_number'] }}" class="form-control">
        </div>
        <div class="col-12 col-md-6 mt-2">
            <div class="row">
                <div class="col-sm-6">
                    <label> @lang('admin.image') </label>
                    <input class="form-control" type="file" placeholder="@lang('admin.image')" name="count3_img">
                </div>
                @if (isset($settings['count3_img']))
                <div class="col-sm-6">
                    <a href="{{ getImage($settings['count3_img']) }}">
                        <img src="{{ asset(getImageThumb($settings['count3_img'])) }}" width="50px" />
                    </a>
                </div>
                @else
                <div class="col-sm-3">
                    <img src="{{ admin_path('images/not_found.PNG') }}" width="50px" />
                </div>
                @endif
            </div>
        </div>

    </div>
    <hr>

    <div class="row">
        <div class="col-12 col-md-6 mt-2">
            <label class="col-sm-4 col-form-label"> @lang('settings.show_banars') </label>
            <div class="col-sm-5">
                <div class="form-check form-switch form-check-success mt-1">
                    <input type="hidden" name="show_count" value="0">
                    <input class="form-check-input" type="checkbox" name="show_count" {{ @$settings['show_count'] == 1 ? 'checked' : '' }} id="show_count">
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    </div>
    </div> --}}

    {{-- footer  --}}
    <div class="accordion mt-4 mb-4" id="accordionFooter">
        <div class="accordion-item border rounded">
            <h2 class="accordion-header" id="headingFooter">
                <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFooter" aria-expanded="true" aria-controls="collapseFooter">
                    @lang('settings.Footer')
                </button>
            </h2>
            <div id="collapseFooter" class="accordion-collapse collapse show mt-3" aria-labelledby="headingFooter" data-bs-parent="#accordionFooter">
                <div class="accordion-body">

                    <div class="row">
                        @forelse ($languages as $key => $locale)
                        <div class="col-12 col-md-6">
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">
                                    {{ trans('settings.footer_title') . trans('lang.' . Locale::getDisplayName($locale)) }}
                                </label>
                                <div class="col-sm-9">
                                    <input class="form-control" name="footer_title{{ $locale }}" value="{{ @$settings['footer_title' . $locale] }}">
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">
                                    {{ trans('settings.footer_description') . trans('lang.' . Locale::getDisplayName($locale)) }}
                                </label>
                                <div class="col-sm-9">
                                    <textarea class="form-control" name="footer_description_{{ $locale }}" cols="30" rows="6">{{ @$settings['footer_description_' . $locale] }}</textarea>
                                </div>
                            </div>
                        </div>
                        @empty
                        @endforelse

                        <!-- Footer Logo Section -->
                        <div class="col-12 col-md-6">
                            <div class="row mb-3">
                                <div class="col-12">
                                    <label class="form-label">@lang('settings.footer_logo')</label>
                                    <input class="form-control" type="file" name="footer_logo">
                                </div>
                                @if (isset($settings['footer_logo']))
                                <div class="col-12 mt-2">
                                    <div class="position-relative d-inline-block">
                                        <a href="{{ getImage($settings['footer_logo']) }}" class="d-inline-block">
                                            <img src="{{ asset(getImage($settings['footer_logo'])) }}" width="80" class="border rounded" />
                                        </a>
                                        <span class="position-absolute delete-image" data-setting-key="footer_logo" title="حذف الصورة" style="top: -8px; right: -8px; color: #dc3545; font-size: 20px; font-weight: bold; cursor: pointer; background: white; border-radius: 50%; width: 25px; height: 25px; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 5px rgba(0,0,0,0.2);">
                                            ×
                                        </span>
                                    </div>
                                </div>
                                @else
                                <div class="col-12 mt-2">
                                    <img src="{{ admin_path('images/not_found.PNG') }}" width="80px" class="border rounded opacity-50" />
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- Commercial License Section -->
                        <div class="col-12 col-md-6">
                            <div class="row mb-3">
                                <div class="col-12">
                                    <label class="form-label">@lang('settings.commercial_license')</label>
                                    <input class="form-control" type="file" name="commercial_license">
                                </div>
                                @if (isset($settings['commercial_license']))
                                <div class="col-12 mt-2">
                                    <div class="position-relative d-inline-block">
                                        <a href="{{ getImage($settings['commercial_license']) }}" class="d-inline-block">
                                            <img src="{{ asset(getImage($settings['commercial_license'])) }}" width="80" class="border rounded" />
                                        </a>
                                        <span class="position-absolute delete-image" data-setting-key="commercial_license" title="حذف الصورة" style="top: -8px; right: -8px; color: #dc3545; font-size: 20px; font-weight: bold; cursor: pointer; background: white; border-radius: 50%; width: 25px; height: 25px; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 5px rgba(0,0,0,0.2);">
                                            ×
                                        </span>
                                    </div>
                                </div>
                                @else
                                <div class="col-12 mt-2">
                                    <img src="{{ admin_path('images/not_found.PNG') }}" width="80px" class="border rounded opacity-50" />
                                </div>
                                @endif
                            </div>
                        </div>

                        {{-- footer status   --}}
                        <div class="col-12 col-md-6">
                            <div class="row mb-3">
                                <label class="col-sm-4 col-form-label"> @lang('settings.show_footer') </label>
                                <div class="col-sm-5">
                                    <div class="form-check form-switch form-check-success mt-1">
                                        <input type="hidden" name="show_footer" value="0">
                                        <input class="form-check-input" type="checkbox" name="show_footer" {{ @$settings['show_footer'] == 1 ? 'checked' : '' }} id="show_footer">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- Meta Setting  --}}
    <div class="accordion mt-4 mb-4" id="accordionMeta">
        <div class="accordion-item border rounded">
            <h2 class="accordion-header" id="headingMeta">
                <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseMeta" aria-expanded="true" aria-controls="collapseMeta">
                    @lang('settings.meta')
                </button>
            </h2>
            <div id="collapseMeta" class="accordion-collapse collapse show mt-3" aria-labelledby="headingMeta" data-bs-parent="#accordionMeta">
                <div class="accordion-body">

                    @forelse ($languages as $key => $locale)
                    {{-- meta_title_ ------------------------------------------------------------------------------------- --}}
                    <div class="row mb-3">
                        <label for="example-text-input" class="col-sm-2 col-form-label">{{ trans('admin.meta_title_in') . trans('lang.' . Locale::getDisplayName($locale)) }}</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="text" name="meta_title_{{ $locale }}" value="{{ @$settings['meta_title_' . $locale] }}" id="title{{ $key }}">
                        </div>
                    </div>

                    {{-- meta_description_ ------------------------------------------------------------------------------------- --}}
                    <div class="row mb-3">
                        <label for="example-text-input" class="col-sm-2 col-form-label">
                            {{ trans('admin.meta_description_in') . trans('lang.' . Locale::getDisplayName($locale)) }}
                        </label>
                        <div class="col-sm-10 mb-2">
                            <textarea name="meta_description_{{ $locale }}" class="form-control description"> {{ @$settings['meta_description_' . $locale] }} </textarea>
                        </div>
                    </div>

                    {{-- meta_key_ ------------------------------------------------------------------------------------- --}}
                    <div class="row mb-3">
                        <label for="example-text-input" class="col-sm-2 col-form-label">
                            {{ trans('admin.meta_key_in') . trans('lang.' . Locale::getDisplayName($locale)) }}
                        </label>
                        <div class="col-sm-10 mb-2">
                            <textarea name="meta_key_{{ $locale }}" class="form-control description"> {{ @$settings['meta_key_' . $locale] }} </textarea>
                        </div>
                    </div>
                    @empty
                    @endforelse
                </div>
            </div>
        </div>
    </div>


    {{-- categories statistics   --}}
    <div class="accordion mt-4 mb-4" id="accordionCategory">
        <div class="accordion-item border rounded">
            <h2 class="accordion-header" id="headingCategory">
                <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCategory" aria-expanded="true" aria-controls="collapseCategory">
                    @lang('settings.categories_statistics_description')
                </button>
            </h2>
            @if (0)
            <div id="collapseCategory" class="accordion-collapse collapse show mt-3" aria-labelledby="headingCategory" data-bs-parent="#accordionCategory">
                <div class="accordion-body">

                    <div class="row">
                        <input type="hidden" name="type_setting" value="color">
                        <label class="mb-3">@lang('settings.categories_statistics_description')</label>
                        @forelse (json_decode(@$settings['categoryColorlist'])??[] as $key => $item)
                        <div class="old_items col-12 col-md-3  mt-3" data-group="categoryColorlist">
                            <!-- Repeater Content -->
                            <div class="item-content">
                                <div class="row">
                                    <div class="col-md-3">
                                        <input type="text" name="old_category[cat_title_ar][]" value="{{ @$item }}" class="form-control color-picker " placeholder="Title">
                                    </div>
                                    <div class="col-md-3">
                                        <input type="text" name="old_category[cat_title_en][]" value="{{ @$item }}" class="form-control color-picker " placeholder="Title">
                                    </div>
                                    <div class="col-md-2">
                                        <input type="text" name="old_category[cat_number][]" value="{{ @$item }}" class="form-control color-picker " placeholder="Number">
                                    </div>
                                    <div class="col-md-3">
                                        <input type="text" name="old_category[cat_item][]" value="{{ @$item }}" class="form-control color-picker " placeholder="Item">
                                    </div>
                                    <!-- Repeater Remove Btn -->
                                    <div class="col-md-1">
                                        <div class="pull-right repeater-remove-btn ">
                                            <button class="btn btn-danger btn-sm old_remove-btn" type="button">
                                                @lang('admin.delete')
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        @endforelse
                        <!-- Repeater Heading -->
                        <div class="repeater-section col-12 col-md-12" style="display: none" id="repeater">
                            <div class="items" data-group="old_category">
                                <div class="row my-2">
                                    <div class="col-md-3">
                                        <input type="text" name="old_category[][cat_title_ar][]" class="form-control color-picker " placeholder="القسم">
                                    </div>
                                    <div class="col-md-3">
                                        <input type="text" name="old_category[][cat_title_en][]" class="form-control color-picker " placeholder="القسم EN">
                                    </div>
                                    <div class="col-md-3">
                                        <input type="text" name="old_category[][cat_number][]" class="form-control color-picker " placeholder="العدد">
                                    </div>
                                    <div class="col-md-3">
                                        <input type="text" name="old_category[][cat_item][]" class="form-control color-picker " placeholder="الوحده">
                                    </div>
                                    <div class="col-md-3">
                                        <div class="pull-right repeater-remove-btn mt-2">
                                            <button class="btn btn-danger btn-sm remove-btn">
                                                @lang('admin.delete')</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!--- /Repeater Section Content --->
                        <div class="repeater-heading mt-4 d-none d-flex justify-content-center">
                            <div class="col-md-3">
                                <button type="button" class="btn btn-success btn-sm form-control pull-right repeater-add-btn" id="category_address">
                                    <i class="bx bx-plus"></i>
                                </button>
                            </div>
                        </div>

                        <div class="repeater-show-heading mt-4 d-flex justify-content-center">
                            <div class="col-md-3">
                                <button type="button" class="btn btn-success btn-sm form-control pull-right repeater-show-btn" id="category_address">
                                    <i class="bx bx-plus"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @endif
            <div id="collapseCategory" class="accordion-collapse collapse show mt-3" aria-labelledby="headingCategory" data-bs-parent="#accordionCategory">
                <div class="accordion-body">
                    <div class="row">
                        <input type="hidden" name="type_setting" value="color">
                        {{-- <label class="mb-3">@lang('settings.categories_statistics_description')</label> --}}

                        <div class="row">
                            <label class="col-sm-4 col-md-2 col-form-label"> @lang('settings.show_statistics') </label>
                            <div class="col-sm-5 col-md-5">
                                <div class="form-check form-switch form-check-success mt-1">
                                    <input type="hidden" name="show_statistics" value="0">
                                    <input class="form-check-input" type="checkbox" name="show_statistics" {{ @$settings['show_statistics'] == 1 ? 'checked' : '' }} id="show_statistics">
                                </div>
                            </div>
                        </div>


                        @php
                        $categoryColorlist = json_decode($settings['cats_statistics'] ?? '[]', true);
                        @endphp

                        @forelse ($categoryColorlist as $key => $item)
                        <div class="old_items col-12 col-md-12 mt-3" data-group="categoryColorlist">
                            <div class="item-content">
                                <div class="row">
                                    <div class="col-md-3">
                                        <input type="text" name="new_category[cat_title_ar][]" value="{{ $item['cat_title_ar'] ?? '' }}" class="form-control" placeholder="Title AR">
                                    </div>
                                    <div class="col-md-3">
                                        <input type="text" name="new_category[cat_title_en][]" value="{{ $item['cat_title_en'] ?? '' }}" class="form-control" placeholder="Title EN">
                                    </div>
                                    <div class="col-md-2">
                                        <input type="text" name="new_category[cat_number][]" value="{{ $item['cat_number'] ?? '' }}" class="form-control" placeholder="Number">
                                    </div>
                                    <div class="col-md-3">
                                        <input type="text" name="new_category[cat_item][]" value="{{ $item['cat_item'] ?? '' }}" class="form-control" placeholder="Item">
                                    </div>
                                    <div class="col-md-1">
                                        <button type="button" class="btn btn-danger btn-sm old_remove-btn mt-1">
                                            @lang('admin.delete')
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        @endforelse

                        <div class="repeater-template d-none">
                            <div class="items row my-2">
                                <div class="col-md-3">
                                    <input type="text" name="new_category[cat_title_ar][]" class="form-control" placeholder="القسم">
                                </div>
                                <div class="col-md-3">
                                    <input type="text" name="new_category[cat_title_en][]" class="form-control" placeholder="القسم EN">
                                </div>
                                <div class="col-md-2">
                                    <input type="text" name="new_category[cat_number][]" class="form-control" placeholder="العدد">
                                </div>
                                <div class="col-md-3">
                                    <input type="text" name="new_category[cat_item][]" class="form-control" placeholder="الوحدة">
                                </div>
                                <div class="col-md-1">
                                    <button type="button" class="btn btn-danger btn-sm remove-btn mt-1">@lang('admin.delete')</button>
                                </div>
                            </div>
                        </div>

                        <div class="repeater-add-btn-wrapper mt-4 d-flex justify-content-center">
                            <div class="col-md-3">
                                <button type="button" class="btn btn-success btn-sm form-control repeater-add-btn">
                                    <i class="bx bx-plus"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    </div>
    </div>


    <div class="row mb-3 text-end">
        <div>
            <a href="{{ route('admin.settings.index') }}" class="btn btn-outline-primary waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
            <button type="submit" class="btn btn-outline-success waves-effect waves-light ml-3 btn-sm">@lang('button.save')</button>
        </div>
    </div>
    <!-- /.card-footer -->
</form>
@endsection




@section('script')
{{-- @vite(['resources/assets/admin/js/data-tables.js']) --}}
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const addBtn = document.querySelector(".repeater-add-btn");
        const template = document.querySelector(".repeater-template");
        const container = document.querySelector("#collapseCategory .accordion-body .row");

        // Add New Category
        addBtn.addEventListener("click", function() {
            const clone = template.cloneNode(true);
            clone.classList.remove("d-none", "repeater-template");
            container.insertBefore(clone, addBtn.closest('.repeater-add-btn-wrapper'));
        });

        // Remove Existing Old Items
        container.addEventListener("click", function(e) {
            if (e.target.classList.contains("old_remove-btn") || e.target.classList.contains(
                    "remove-btn")) {
                e.target.closest(".row").remove();
            }
        });
    });

</script>
<script>
    document.querySelectorAll('input[type=file][name^="logo_"]').forEach(input => {
        input.addEventListener('change', () => {
            const file = input.files[0];
            if (!file) return;
            const img = new Image();
            img.onload = () => {
                if (img.width !== 400 || img.height !== 450) {
                    alert('يجب أن تكون الصورة بمقاس 400×450 بكسل.');
                    input.value = '';
                }
            };
            img.src = URL.createObjectURL(file);
        });
    });

</script>
<script>
    $(document).ready(function() {
        // Handle delete image button click
        $(document).on('click', '.delete-image', function(e) {
            e.preventDefault();

            const button = $(this);
            const settingKey = button.data('setting-key');
            const imageContainer = button.closest('.col-sm-6');

            // Show confirmation dialog
            if (confirm('{{ __("admin.are_you_sure") }}')) {
                // Send AJAX request to delete the image
                $.ajax({
                    url: '{{ route("admin.settings.delete-image") }}'
                    , type: 'DELETE'
                    , data: {
                        _token: '{{ csrf_token() }}'
                        , key: settingKey
                    }
                    , success: function(response) {
                        if (response.success) {
                            // Remove the image preview and delete button
                            imageContainer.remove();
                            // Show success message
                            toastr.success(response.message || '{{ __("admin.deleted_successfully") }}');
                        } else {
                            toastr.error(response.message || '{{ __("admin.error_occurred") }}');
                        }
                    }
                    , error: function(xhr) {
                        console.error('Error deleting image:', xhr.responseText);
                        toastr.error('{{ __("admin.error_occurred") }}');
                    }
                });
            }
        });
    });

</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.delete-image').forEach(function(button) {
            button.addEventListener('click', function(e) {
                e.preventDefault();

                const settingKey = this.getAttribute('data-setting-key');
                const imageContainer = this.closest('.position-relative');

                imageContainer.classList.add('fade-out');

                if (confirm('هل أنت متأكد من حذف هذه الصورة؟')) {
                    // Send AJAX request to delete the image
                    fetch('/admin/settings/delete-image', {
                            method: 'POST'
                            , headers: {
                                'Content-Type': 'application/json'
                                , 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                , 'Accept': 'application/json'
                            }
                            , body: JSON.stringify({
                                setting_key: settingKey
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Remove the image container completely after animation
                                setTimeout(() => {
                                    // Replace with "no image found" placeholder
                                    const parentDiv = imageContainer.closest('.col-12');
                                    parentDiv.innerHTML = `
                                <div class="col-12 mt-2">
                                    <img src="${window.location.origin}/admin/images/not_found.PNG" width="80px" class="border rounded opacity-50" />
                                    <small class="text-muted d-block mt-1">لا توجد صورة</small>
                                </div>
                            `;
                                }, 300);

                                showMessage('تم حذف الصورة بنجاح', 'success');
                            } else {
                                imageContainer.classList.remove('fade-out');
                                showMessage('حدث خطأ أثناء حذف الصورة', 'error');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            imageContainer.classList.remove('fade-out');
                            showMessage('حدث خطأ في الاتصال', 'error');
                        });
                } else {
                    imageContainer.classList.remove('fade-out');
                }
            });
        });

        function showMessage(message, type) {
            const messageDiv = document.createElement('div');
            messageDiv.className = `alert alert-${type === 'success' ? 'success' : 'danger'} alert-dismissible fade show position-fixed`;
            messageDiv.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
            messageDiv.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;

            document.body.appendChild(messageDiv);

            setTimeout(() => {
                if (messageDiv.parentNode) {
                    messageDiv.remove();
                }
            }, 3000);
        }
    });

</script>
<style>
    .delete-image {
        position: absolute;
        top: 2px;
        right: 2px;
        width: 18px;
        height: 18px;
        color: #ff0000;
        background: none;
        border: none;
        font-size: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0;
        cursor: pointer;
        opacity: 0.8;
        transition: opacity 0.2s ease;
    }

    .delete-image:hover {
        opacity: 1;
        color: #cc0000;
        transform: scale(1.1);
    }

    .delete-image i {
        line-height: 1;
        text-shadow: 0 0 3px rgba(255, 255, 255, 0.8);
    }

    .position-relative {
        position: relative;
        display: inline-block;
    }

</style>

<style>
    .delete-image {
        transition: all 0.2s ease;
        user-select: none;
    }

    .delete-image:hover {
        transform: scale(1.1);
        background-color: #dc3545 !important;
        color: white !important;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3) !important;
    }

    .position-relative:hover .delete-image {
        opacity: 1;
    }

    .fade-out {
        opacity: 0;
        transform: scale(0);
        transition: all 0.3s ease;
    }

</style>
@endsection
