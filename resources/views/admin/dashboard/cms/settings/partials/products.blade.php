@extends('admin.app')

@section('title', trans('settings.edit', ['name' =>  $settingMain->title]) )
@section('title_page', trans('settings.settings'))
@section('title_route', route('admin.settings.index') )
@section('button_page')
<a href="{{ route('admin.settings.index') }}" class="btn btn-outline-primary waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
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

    {{-- custom_campaign --}}
    <div class="accordion mt-4 mb-4" id="accordionEmail">
        <div class="accordion-item border rounded">
            <h2 class="accordion-header" id="headingEmail">
                <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseEmail" aria-expanded="true" aria-controls="collapseEmail">
                    @lang('settings.settings')
                </button>
            </h2>
            <div id="collapseEmail" class="accordion-collapse collapse show mt-3" aria-labelledby="headingEmail" data-bs-parent="#accordionEmail">
                <div class="accordion-body">

                    {{-- title & description  ---------------------------------------------------------------------------------    --}}
                    <div class="row">
                        <div class="col-md-12 col-12 mb-3">
                            @forelse ($languages as $key => $locale)

                            {{-- title ------------------------------------------------------------------------------------- --}}
                            <div class="row mb-3">
                                <label for="example-text-input" class="col-sm-12 col-form-label">{{ trans('admin.title_in') . trans('lang.' .Locale::getDisplayName($locale)) }}</label>
                                <div class="col-sm-12">
                                    <input type="text" id="title{{ $key }}" name="{{ $locale }}[title]" value="{{ @json_decode($settings[$locale])->title}}" class="form-control" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="example-text-input" class="col-sm-12 col-form-label">
                                    {{ trans('admin.description_in') . trans('lang.' .Locale::getDisplayName($locale)) }} </label>
                                <div class="col-sm-12 mt-12">
                                    <textarea id="description{{ $key }}" name="{{ $locale }}[description]" class="form-control" rows="5" cols="100"> {{ @json_decode($settings[$locale])->description }} </textarea>
                                </div>
                                <script type="text/javascript">
                                    CKEDITOR.replace('description{{ $key }}', {
                                        filebrowserUploadUrl: "{{ route('admin.ckeditor.upload', ['_token' => csrf_token()]) }}"
                                        , filebrowserUploadMethod: 'form'
                                    });

                                </script>
                            </div>
                            @empty

                            @endforelse

                        </div>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <div class="row mb-3">
                                <label for="example-number-input"> @lang('admin.image')</label>
                                <div class="col-sm-12">
                                    <input class="form-control" type="file" name="image">
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <a href="{{ getImage( @$settings['image']) }}" target="_blank">
                                <img src="{{ getImageThumb( @$settings['image'] ) }}" alt="" style="width:60px; background-color: gray">
                            </a>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <div class="row mb-3">
                                <label for="example-number-input"> @lang('admin.image')</label>
                                <div class="col-sm-12">
                                    <input class="form-control" type="file" name="background_image">
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <a href="{{ getImage( @$settings['background_image']) }}" target="_blank">
                                <img src="{{ getImageThumb( @$settings['background_image'] ) }}" alt="" style="width:60px; background-color: gray">
                            </a>
                        </div>
                    </div>

                    <div class="col-3 mt-3">
                        <label>  @lang('settings.background_color') </label>
                        <input type="text" name="background_color" value="{{ @$settings['background_color'] }}" class="form-control color-picker spectrum with-add-on" placeholder="#FFFFFF">
                    </div>

                    <div class="col-12 mt-3">
                        <label class="form-check-label">@lang('settings.fast_status')</label>
                        <div class="form-check form-switch form-check-success">
                            <input class="form-check-input" type="checkbox" role="switch" value="1" {{ @$settings['fast_status'] == 1 ? 'checked':'' }} name="fast_status">
                        </div>
                    </div>

                    <div class="col-12 mt-3">
                        <label class="form-check-label">@lang('admin.status')</label>
                        <div class="form-check form-switch form-check-success">
                            <input class="form-check-input" type="checkbox" role="switch" value="1" {{ @$settings['status'] == 1 ? 'checked':'' }} name="status">
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


    <div class="row mb-3 text-end">
        <div>
            <a href="{{ route('admin.settings.index') }}" class="btn btn-outline-primary waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
            <button type="submit" class="btn btn-outline-success waves-effect waves-light ml-3 btn-sm">@lang('button.save')</button>
        </div>
    </div>


</form>

@endsection

@section('style')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="{{ asset('site/js/ckeditor/ckeditor.js') }}"></script>
@endsection


@section('script')
    <script src="{{ asset('backend/js/spectrum.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.color-picker').spectrum({
                showPalette: true
            , });
        });
    </script>
@endsection

