@extends('admin.app')

@section('title', trans('settings.setting_create'))
@section('title_page', trans('settings.edit', ['name' => @$homeSetting->title_section]))


@section('style')
    {{-- @vite(['resources/assets/admin/css/data-tables.js']) --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="{{ asset('site/js/ckeditor/ckeditor.js') }}"></script>

@endsection

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">

                        <form action="{{ route('admin.home-settings.update',$homeSetting->id) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('put')
                            <div class="row">
                                <div class="col-md-8">
                                    @foreach ($languages as $key => $locale)
                                        <div class="accordion mt-4 mb-4" id="accordionExample">
                                            <div class="accordion-item border rounded">
                                                <h2 class="accordion-header" id="headingOne{{ $key }}">
                                                    <button class="accordion-button fw-medium" type="button"
                                                        data-bs-toggle="collapse"
                                                        data-bs-target="#collapseOne{{ $key }}"
                                                        aria-expanded="true" aria-controls="collapseOne{{ $key }}">
                                                        {{ trans('lang.' . Locale::getDisplayName($locale)) }}
                                                    </button>
                                                </h2>
                                                <div id="collapseOne{{ $key }}"
                                                    class="accordion-collapse collapse show mt-3"
                                                    aria-labelledby="headingOne{{ $key }}"
                                                    data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">

                                                        <div class="row mb-3 title-section">
                                                            <label for="example-text-input"
                                                                class="col-sm-2 col-form-label">{{ trans('admin.title_in') . trans('lang.' . Locale::getDisplayName($locale)) }}</label>

                                                            <div class="col-sm-10">
                                                                <input type="text" id="title{{ $key }}"
                                                                    name="{{ $locale }}[title]"
                                                                    value="{{ @$homeSetting->trans->where('locale', $locale)->first()->title }}"
                                                                    class="form-control title">
                                                                @if ($errors->has($locale . '.title'))
                                                                    <span
                                                                        class="missiong-spam">{{ $errors->first($locale . '.title') }}</span>
                                                                @endif
                                                            </div>
                                                        </div>

                                                        {{-- Start Slug --}}
                                                        {{-- description ------------------------------------------------------------------------------------- --}}
                                                        <div class="row mb-3">
                                                            <label for="example-text-input"
                                                                class="col-sm-2 col-form-label">{{ trans('admin.description_in') . trans('lang.' . Locale::getDisplayName($locale)) }}
                                                            </label>
                                                            <div class="col-sm-10 mb-2">
                                                                <textarea id="description{{ $key }}" name="{{ $locale }}[description]">{{ @$homeSetting->trans->where('locale', $locale)->first()->description }}  </textarea>
                                                                @if ($errors->has($locale . '.description'))
                                                                    <span
                                                                        class="missiong-spam">{{ $errors->first($locale . '.description') }}</span>
                                                                @endif
                                                            </div>

                                                            <script type="text/javascript">
                                                                CKEDITOR.replace('description{{ $key }}', {
                                                                    filebrowserUploadUrl: "{{ route('admin.ckeditor.upload', ['_token' => csrf_token()]) }}",
                                                                    filebrowserUploadMethod: 'form'
                                                                });
                                                            </script>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    @endforeach
                                </div>
                                <div class="col-md-4">

                                    <div class="accordion mt-4 mb-4" id="accordionExample">
                                        <div class="accordion-item border rounded">
                                            <h2 class="accordion-header" id="headingOne">
                                                <button class="accordion-button fw-medium" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#collapseOne"
                                                    aria-expanded="true" aria-controls="collapseOne">
                                                    {{ trans('admin.settings') }}
                                                </button>
                                            </h2>
                                            <div id="collapseOne" class="accordion-collapse collapse show"
                                                aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    {{-- title_section ------------------------------------------------------------------------------------- --}}
                                                    <div class="col-12">
                                                        <div class="row mb-3">
                                                            <label for="example-number-input" col-form-label>
                                                                @lang('settings.setting_name_section')</label>
                                                            <div class="col-sm-12">
                                                                <input class="form-control" type="text"
                                                                    placeholder="@lang('settings.setting_name_section')"
                                                                    id="example-number-input" name="title_section" disabled
                                                                    value="{{ @$homeSetting->title_section }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    {{-- url ------------------------------------------------------------------------------------- --}}
                                                    <div class="col-12">
                                                        <div class="row mb-3">
                                                            <label for="example-number-input" col-form-label>
                                                                @lang('settings.url')</label>
                                                            <div class="col-sm-12">
                                                                <input class="form-control" type="text"
                                                                    placeholder="@lang('settings.url')"
                                                                    id="example-number-input" name="url"
                                                                    value="{{ @$homeSetting->url }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3 mb-3">
                                                        @if ($homeSetting->image != null)
                                                            <img src="{{ getImageThumb($homeSetting->image) }}" alt=""
                                                                style="width:100%">
                                                        @endif
                                                    </div>
                                                    {{-- image ------------------------------------------------------------------------------------- --}}
                                                    <div class="col-12">
                                                        <div class="row mb-3">
                                                            <label for="example-number-input" col-form-label>
                                                                @lang('admin.image')</label>
                                                            <div class="col-sm-12">
                                                                <input class="form-control" type="file"
                                                                    placeholder="@lang('admin.image')"
                                                                    id="example-number-input" name="image"
                                                                    value="{{ old('image') }}">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    {{-- Status ------------------------------------------------------------------------------------- --}}
                                                    <div class="col-12">
                                                        <label class="col-sm-12 col-form-label"
                                                            for="available">{{ trans('admin.status') }}</label>
                                                        <div class="col-sm-10">
                                                            <input class="form-check form-switch" name="status"
                                                                type="checkbox" id="switch3" switch="success"
                                                                {{ @$homeSetting->status == 1 ? 'checked' : '' }}
                                                                value="1">
                                                            <label class="form-label" for="switch3"
                                                                data-on-label=" @lang('admin.yes') "
                                                                data-off-label=" @lang('admin.no')"></label>
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
                                        <a href="{{ route('admin.home-settings.index') }}"
                                            class="btn btn-outline-primary waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
                                        <button type="submit"
                                            class="btn btn-outline-success waves-effect waves-light ml-3 btn-sm">@lang('button.save')</button>
                                    </div>
                                </div>

                            </div>



                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div> <!-- container-fluid -->

@endsection


@section('script')

    {{-- @vite(['resources/assets/admin/js/data-tables.js']) --}}
@endsection
