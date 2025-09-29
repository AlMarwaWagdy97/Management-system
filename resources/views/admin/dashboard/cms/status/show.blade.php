@extends('admin.app')

@section('title', trans('status.sho'))
@section('title_page', trans('status.show_status'))
@section('title_route', route('admin.status.index') )
@section('button_page')
<a href="{{ route('admin.status.index') }}" class="btn btn-primary waves-effect waves-light ml-3">@lang('button.cancel')</a>
@endsection


@section('content')

<div class="card">
    <div class="card-body">

        <form action="{{ route('admin.status.update',$status->id) }}" method="post" enctype="multipart/form-data">
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
                                        <label for="example-text-input" class="col-sm-2 col-form-label">{{ trans('admin.title_in') .  Locale::getDisplayName($locale)}}</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" type="text" name="{{ $locale }}[title]" disabled value="{{ $status->trans->where('locale',$locale)->first()->title }}" id="title{{ $key }}">
                                        </div>
                                    </div>
                                    {{-- slug ------------------------------------------------------------------------------------- --}}
                                    <div class="mb-3 row slug-section">
                                        <label for="example-text-input" class="col-sm-2 col-form-label">{{ trans('admin.slug_in') .  Locale::getDisplayName($locale)}}</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="{{ $locale }}[slug]" disabled value="{{ $status->trans->where('locale',$locale)->first()->slug}}" id="slug{{ $key }}" class="form-control slug" required>
                                        </div>
                                    </div>

                                    {{-- description ------------------------------------------------------------------------------------- --}}
                                    <div class="mb-3 row">
                                        <label for="example-text-input" class="col-sm-12 col-form-label"> @lang('admin.description_in') {{ Locale::getDisplayName($locale)}} </label>
                                        <div class="mb-2 col-sm-12">
                                            <p>{!! $status->trans->where('locale',$locale)->first()->description !!}</p>
                                        </div>
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
                                        <div class="col-5">
                                            <input type="text" name="color" value="{{ @$status->color }}" placeholder="#FFFFFF" disabled class="form-control spectrum with-add-on colorpicker-showinput-intial " id="colorpicker-showinput-intial">
                                        </div>
                                        @if ($errors->has('background_color'))
                                        <span class="missiong-spam">{{ $errors->first('color') }}</span>
                                        @endif
                                    </div>
                                    {{-- Status ------------------------------------------------------------------------------------- --}}
                                    <div class="col-12 mb-3">
                                        <label for="example-number-input" class="col-md-4"> {{ trans('admin.status') }}</label>
                                        @if($status->status == 1 )
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
            </div>

            {{-- Butoooons ------------------------------------------------------------------------- --}}
            <div class="mb-3 row text-end">
                <div>
                    <a href="{{ route('admin.status.index') }}" class="ml-3 btn btn-primary waves-effect waves-light">@lang('button.cancel')</a>
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
