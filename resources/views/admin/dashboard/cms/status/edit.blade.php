@extends('admin.app')

@section('title', trans('status.status'))
@section('title_page', trans('status.status'))
@section('title_route', route('admin.status.index') )
@section('button_page')
<a href="{{ route('admin.status.index') }}" class="btn btn-primary waves-effect waves-light ml-3">@lang('button.cancel')</a>
@endsection


@section('content')

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.status.update', $status->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('put')
            <div class="row">
                <div class="col-md-8">
                    @foreach ($languages as $key => $locale)
                    <div class="mt-4 mb-4 accordion" id="accordionExampleTitle{{ $key }}">
                        <div class="border rounded accordion-item">
                            <h2 class="accordion-header" id="headingTitle{{ $key }}">
                                <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTitle{{ $key }}" aria-expanded="true" aria-controls="collapseTitle{{ $key }}">
                                    {{ Locale::getDisplayName($locale) }}
                                </button>
                            </h2>
                            <div id="collapseTitle{{ $key }}" class="mt-3 accordion-collapse collapse show" aria-labelledby="headingTitle{{ $key }}" data-bs-parent="#accordionExampleTitle{{ $key }}">
                                <div class="accordion-body">
                                    {{-- title ------------------------------------------------------------------------------------- --}}
                                    <div class="mb-3 row">
                                        <label for="example-text-input" class="col-sm-12 col-form-label">{{ trans('admin.title_in') . Locale::getDisplayName($locale) }}</label>
                                        <div class="col-sm-12">
                                            <input class="form-control" type="text" name="{{ $locale }}[title]" value="{{ $status->trans->where('locale',$locale)->first()->title }}" id="title{{ $key }}">
                                        </div>
                                        @if ($errors->has($locale . '.title'))
                                        <span class="missiong-spam">{{ $errors->first($locale . '.title') }}</span>
                                        @endif
                                    </div>

                                    {{-- Start Slug --}}
                                    <div class="mb-3 row slug-section">
                                        <label for="example-text-input" class="col-sm-12 col-form-label"> @lang('admin.' . $locale . '.slug') </label>
                                        <div class="col-sm-12">
                                            <input type="text" id="slug{{ $key }}" name="{{ $locale }}[slug]" value="{{$status->trans->where('locale',$locale)->first()->slug }}" class="form-control slug" required>
                                            @if($errors->has($locale .'.slug'))
                                            <span class="missiong-spam">{{ $errors->first($locale . '.slug') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    @include('admin.layouts.scriptSlug')
                                    {{-- End Slug --}}

                                    {{-- description ------------------------------------------------------------------------------------- --}}
                                    <div class="mb-3 row">
                                        <label for="example-text-input" class="col-sm-12 col-form-label"> @lang('admin.description_in')
                                            {{ Locale::getDisplayName($locale) }} </label>
                                        <div class="mb-3 col-sm-12">
                                            <textarea id="description{{ $key }}" name="{{ $locale }}[description]"> {{ $status->trans->where('locale',$locale)->first()->description }} </textarea>
                                            @if ($errors->has($locale . '.description'))
                                            <span class="missiong-spam">{{ $errors->first($locale . '.description') }}</span>
                                            @endif
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
                    </div>
                    @endforeach
                </div>

                <div class="col-md-4">
                    {{-- ------ Start Post Settings------ --}}
                    <div class="mt-4 mb-4 accordion" id="accordionExampleSetting">
                        <div class="border rounded accordion-item">
                            <h2 class="accordion-header" id="headingSetting">
                                <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSetting" aria-expanded="true" aria-controls="collapseSetting">
                                    {{ trans('admin.settings') }}
                                </button>
                            </h2>
                            <div id="collapseSetting" class="accordion-collapse collapse show" aria-labelledby="headingSetting" data-bs-parent="#accordionExampleSetting">
                                <div class="accordion-body">
                                    {{-- color------------------------------------------------------------------------------------- --}}
                                    <div class="mb-3 row">
                                        <div class="col-4">
                                            <label for="example-number-input" class="col-form-label"> @lang('charityProject.color') </label>
                                        </div>
                                        <div class="col-6">
                                            <input type="text" name="color" value="{{ @$status->color }}" placeholder="#FFFFFF"  class="form-control spectrum with-add-on colorpicker-showinput-intial " id="colorpicker-showinput-intial">
                                        </div>
                                        @if ($errors->has('background_color'))
                                        <span class="missiong-spam">{{ $errors->first('color') }}</span>
                                        @endif
                                    </div>
                                    {{-- Status ------------------------------------------------------------------------------------- --}}
                                    <div class="col-12">
                                        <div class="col-sm-10 mt-3">
                                            <div class="form-check form-switch form-check-success">
                                                <label class="form-check-label" for="flexSwitchCheckSuccessStatus">@lang('admin.status')</label>
                                                <input class="form-check-input" type="checkbox" role="switch" name="status" {{  @$status->status == 1 ? 'checked' : '' }} id="flexSwitchCheckSuccessStatus">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- ------ End Post Settings------ --}}
                </div>
            </div>
            {{-- Butoooons ------------------------------------------------------------------------- --}}
            <div class="mb-3 row text-end">
                <div>
                    <a href="{{ route('admin.status.index') }}" class="ml-3 btn btn-primary waves-effect waves-light btn-sm">@lang('button.cancel')</a>
                    <button type="submit" class="ml-3 btn btn-outline-success waves-effect waves-light btn-sm">@lang('button.save')</button>
                    <button type="submit" name="submit" value="update" class="btn btn-outline-success waves-effect waves-light  btn-sm">@lang('button.save_update')</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection


@section('style')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="{{ asset('site/js/ckeditor/ckeditor.js') }}"></script>
@endsection
