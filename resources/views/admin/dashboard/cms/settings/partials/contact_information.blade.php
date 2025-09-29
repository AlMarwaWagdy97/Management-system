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


<form class="form-horizontal" action="{{route('admin.settings.update-custom', $settingMain->key)}}" method="POST" enctype="multipart/form-data" role="form">
    @csrf

    <div class="row text-center mt-5 mb-3">
        <label class="col-sm-2 col-form-label"> @lang('settings.title_setting') </label>
        <div class="col-sm-10">
            <input class="form-control" type="text" name="title" value="{{ @$settings['title'] }}" required>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">

            {{-- Social Media Setting  --}}
            <div class="accordion mt-4 mb-4" id="accordionSocialMedia">
                <div class="accordion-item border rounded">
                    <h2 class="accordion-header" id="headingSocialMedia">
                        <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSocialMedia" aria-expanded="true" aria-controls="collapseSocialMedia">
                            @lang('settings.social_media')
                        </button>
                    </h2>
                    <div id="collapseSocialMedia" class="accordion-collapse collapse show mt-3" aria-labelledby="headingSocialMedia" data-bs-parent="#accordionSocialMedia">
                        <div class="accordion-body">
                            <div class="row">
                                {{-- Facebook  --}}
                                <div class="col-12 col-md-6">
                                    <div class="row mb-3">
                                        <label class="col-sm-2 col-form-label"> @lang('settings.facebook') </label>
                                        <div class="col-sm-9">
                                            <input class="form-control" type="text" name="facebook" value="{{ @$settings['facebook'] }}">
                                        </div>
                                    </div>
                                </div>
                                {{-- Instagram  --}}
                                <div class="col-12 col-md-6">
                                    <div class="row mb-3">
                                        <label class="col-sm-2 col-form-label"> @lang('settings.instagram') </label>
                                        <div class="col-sm-9">
                                            <input class="form-control" type="text" name="instagram" value="{{ @$settings['instagram'] }}">
                                        </div>
                                    </div>
                                </div>

                                {{-- Twitter  --}}
                                <div class="col-12 col-md-6">
                                    <div class="row mb-3">
                                        <label class="col-sm-2 col-form-label"> @lang('settings.twitter') </label>
                                        <div class="col-sm-9">
                                            <input class="form-control" type="text" name="twitter" value="{{ @$settings['twitter'] }}">
                                        </div>
                                    </div>
                                </div>

                                {{-- linkedin  --}}
                                <div class="col-12 col-md-6">
                                    <div class="row mb-3">
                                        <label class="col-sm-2 col-form-label"> @lang('settings.linkedin') </label>
                                        <div class="col-sm-9">
                                            <input class="form-control" type="text" name="linkedin" value="{{ @$settings['linkedin'] }}">
                                        </div>
                                    </div>
                                </div>

                                {{-- youtube  --}}
                                <div class="col-12 col-md-6">
                                    <div class="row mb-3">
                                        <label class="col-sm-2 col-form-label"> @lang('settings.youtube') </label>
                                        <div class="col-sm-9">
                                            <input class="form-control" type="text" name="youtube" value="{{ @$settings['youtube'] }}">
                                        </div>
                                    </div>
                                </div>

                                {{-- snapchat  --}}
                                <div class="col-12 col-md-6">
                                    <div class="row mb-3">
                                        <label class="col-sm-2 col-form-label"> @lang('settings.snapchat') </label>
                                        <div class="col-sm-9">
                                            <input class="form-control" type="text" name="snapchat" value="{{ @$settings['snapchat'] }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            {{-- contact inforamtion Setting  --}}
            <div class="accordion mt-4 mb-4" id="accordionConatact">
                <div class="accordion-item border rounded">
                    <h2 class="accordion-header" id="headingConatact">
                        <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseConatact" aria-expanded="true" aria-controls="collapseConatact">
                            @lang('settings.social_media')
                        </button>
                    </h2>
                    <div id="collapseConatact" class="accordion-collapse collapse show mt-3" aria-labelledby="headingConatact" data-bs-parent="#accordionConatact">
                        <div class="accordion-body">
                            <div class="row">
                                {{-- email  --}}
                                <div class="col-12 col-md-6">
                                    <div class="row mb-3">
                                        <label class="col-sm-2 col-form-label"> @lang('settings.email') </label>
                                        <div class="col-sm-9">
                                            <input class="form-control" type="text" name="email" value="{{ @$settings['email'] }}">
                                        </div>
                                    </div>
                                </div>
                                {{-- mobile  --}}
                                <div class="col-12 col-md-6">
                                    <div class="row mb-3">
                                        <label class="col-sm-2 col-form-label"> @lang('settings.mobile') </label>
                                        <div class="col-sm-9">
                                            <input class="form-control" type="text" name="mobile" value="{{ @$settings['mobile'] }}">
                                        </div>
                                    </div>
                                </div>
                                {{-- phone  --}}
                                <div class="col-12 col-md-6">
                                    <div class="row mb-3">
                                        <label class="col-sm-2 col-form-label"> @lang('settings.phone') </label>
                                        <div class="col-sm-9">
                                            <input class="form-control" type="text" name="phone" value="{{ @$settings['phone'] }}">
                                        </div>
                                    </div>
                                </div>
                                {{-- whatsapp  --}}
                                <div class="col-12 col-md-6">
                                    <div class="row mb-3">
                                        <label class="col-sm-2 col-form-label"> @lang('settings.whatsapp') </label>
                                        <div class="col-sm-9">
                                            <input class="form-control" type="text" name="whatsapp" value="{{ @$settings['whatsapp'] }}">
                                        </div>
                                    </div>
                                </div>
                                {{-- address ------------------------------------------------------------------------------------- --}}
                                @forelse ($languages as $key => $locale)
                                    <div class="col-12 col-md-6">
                                        <div class="row mb-3">
                                            <label class="col-sm-2 col-form-label"> {{ trans('settings.address') . trans('lang.' .Locale::getDisplayName($locale)) }} </label>
                                            <div class="col-sm-9">
                                                <input class="form-control" type="text" name="address_{{ $locale }}" value="{{ @$settings['address_' . $locale] }}" id="title{{ $key }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="row mb-3">
                                            <label class="col-sm-2 col-form-label"> {{ trans('settings.working_hours') . trans('lang.' .Locale::getDisplayName($locale)) }} </label>
                                            <div class="col-sm-9">
                                                <input class="form-control" type="text" name="working_hours_{{ $locale }}" value="{{ @$settings['working_hours_' . $locale] }}" id="title{{ $key }}">
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                @endforelse

                                {{--  maps  --}}
                                <div class="col-12">
                                    <div class="row mb-3">
                                        <label class="col-sm-1 col-form-label"> @lang('settings.maps') </label>
                                        <div class="col-sm-11">
                                            <input class="form-control" type="text" name="maps" value="{{ @$settings['maps'] }}">
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
                                <label for="example-text-input" class="col-sm-2 col-form-label">{{ trans('admin.meta_title_in') . trans('lang.' .Locale::getDisplayName($locale)) }}</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" name="meta_title_{{ $locale }}" value="{{ @$settings['meta_title_' . $locale] }}" id="title{{ $key }}">
                                </div>
                            </div>

                            {{-- meta_description_ ------------------------------------------------------------------------------------- --}}
                            <div class="row mb-3">
                                <label for="example-text-input" class="col-sm-2 col-form-label"> {{ trans('admin.meta_description_in') . trans('lang.' .Locale::getDisplayName($locale)) }}
                                </label>
                                <div class="col-sm-10 mb-2">
                                    <textarea name="meta_description_{{ $locale }}" class="form-control description"> {{ @$settings['meta_description_' . $locale] }} </textarea>
                                </div>
                            </div>

                            {{-- meta_key_ ------------------------------------------------------------------------------------- --}}
                            <div class="row mb-3">
                                <label for="example-text-input" class="col-sm-2 col-form-label"> {{ trans('admin.meta_key_in') . trans('lang.' .Locale::getDisplayName($locale)) }}
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
@endsection
