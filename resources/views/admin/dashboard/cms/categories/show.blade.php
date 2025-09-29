@extends('admin.app')

@section('title', trans('categories.show_all'))
@section('title_page', trans('categories.categories'))
@section('title_route', route('admin.categories.index') )
@section('button_page')
<a href="{{ route('admin.categories.index') }}" class="btn btn-outline-primary waves-effect waves-light ml-3">@lang('button.cancel')</a>
@endsection


@section('content')
<div class="card">
    <div class="card-body">


        <div class="row">
            <div class="col-md-9">
                @foreach ($languages as $key => $locale)
                <div class="accordion mt-4 mb-4" id="accordionExampleTitle{{ $key }}">
                    <div class="accordion-item border rounded">
                        <h2 class="accordion-header" id="headingTitle{{ $key }}">
                            <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTitle{{ $key }}" aria-expanded="true" aria-controls="collapseTitle{{ $key }}">
                                {{ trans('lang.' .Locale::getDisplayName($locale))   }}

                            </button>
                        </h2>
                        <div id="collapseTitle{{ $key }}" class="accordion-collapse collapse show mt-3" aria-labelledby="headingTitle{{ $key }}" data-bs-parent="#accordionExampleTitle{{ $key }}">
                            <div class="accordion-body">
                                {{-- title ------------------------------------------------------------------------------------- --}}
                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">{{ trans('admin.title_in') . trans('lang.' .Locale::getDisplayName($locale)) }}</label>
                                    <div class="col-sm-10">
                                        <input type="text" id="title{{ $key }}" name="{{ $locale }}[title]" disabled value="{{ @$item->trans->where('locale',$locale)->first()->title}}" class="form-control" required>

                                    </div>
                                </div>

                                {{-- Start Slug --}}
                                <div class="row mb-3 slug-section">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">{{ trans('admin.slug_in') . trans('lang.' .Locale::getDisplayName($locale)) }} </label>

                                    <div class="col-sm-10">
                                        <input type="text" id="slug{{ $key }}" name="{{ $locale }}[slug]" disabled value="{{ @$item->trans->where('locale',$locale)->first()->slug }}" class="form-control slug" required>
                                    </div>
                                </div>

                                {{-- description ------------------------------------------------------------------------------------- --}}
                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">
                                        {{ trans('admin.description_in') . trans('lang.' .Locale::getDisplayName($locale)) }} </label>
                                    <div class="col-sm-10 mt-2">
                                        <p>{!! @$item->trans->where('locale',$locale)->first()->slug !!}</p>
                                        @if ($errors->has($locale . '.description'))
                                        <span class="missiong-spam">{{ $errors->first($locale . '.description') }}</span>
                                        @endif
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
                        <div id="collapseMeta{{ $key }}" class="accordion-collapse collapse  mt-3" aria-labelledby="headingMeta{{ $key }}" data-bs-parent="#accordionExampleMeta">
                            <div class="accordion-body">

                                @foreach ($languages as $key => $locale)
                                {{-- meta_title_ ------------------------------------------------------------------------------------- --}}
                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">{{ trans('admin.meta_title_in') . trans('lang.' .Locale::getDisplayName($locale)) }}</label>
                                    <div class="col-sm-10">
                                        <input class="form-control" type="text" disabled name="{{ $locale }}[meta_title]" value="{{ @$item->trans->where('locale',$locale)->first()->meta_title }}" id="title{{ $key }}">
                                    </div>
                                    @if ($errors->has($locale . '.meta_title'))
                                    <span class="missiong-spam">{{ $errors->first($locale . '.meta_title') }}</span>
                                    @endif
                                </div>

                                {{-- meta_description_ ------------------------------------------------------------------------------------- --}}
                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label"> {{ trans('admin.meta_description_in') . trans('lang.' .Locale::getDisplayName($locale)) }}
                                    </label>
                                    <div class="col-sm-10 mb-2">
                                        <textarea name="{{ $locale }}[meta_description]" disabled class="form-control description"> {{ @$item->trans->where('locale',$locale)->first()->meta_description }} </textarea>
                                        @if ($errors->has($locale . '.meta_description'))
                                        <span class="missiong-spam">{{ $errors->first($locale . '.meta_description') }}</span>
                                        @endif
                                    </div>
                                </div>

                                {{-- meta_key_ ------------------------------------------------------------------------------------- --}}
                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label"> {{ trans('admin.meta_key_in') . trans('lang.' .Locale::getDisplayName($locale)) }}
                                    </label>
                                    <div class="col-sm-10 mb-2">
                                        <textarea name="{{ $locale }}[meta_key]" disabled class="form-control description"> {{ @$item->trans->where('locale',$locale)->first()->meta_key }} </textarea>
                                        @if ($errors->has($locale . '.meta_key'))
                                        <span class="missiong-spam">{{ $errors->first($locale . '.meta_key') }}</span>
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

            <div class="col-md-3">
                <div class="accordion mt-4 mb-4" id="accordionExampleSetting">
                    <div class="accordion-item border rounded">
                        <h2 class="accordion-header" id="headingSetting">
                            <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSetting" aria-expanded="true" aria-controls="collapseSetting">
                                {{ trans('admin.settings') }}
                            </button>
                        </h2>
                        <div id="collapseSetting" class="accordion-collapse collapse show" aria-labelledby="headingSetting" data-bs-parent="#accordionExampleSetting">
                            <div class="accordion-body">

                                {{-- image ------------------------------------------------------------------------------------- --}}
                                <div class="col-12">
                                    <div class="row mb-3">
                                        <div class="col-sm-12">
                                            <a href="{{ getImage( $item->image) }}" target="_blank">
                                                <img src="{{  getImageThumb( $item->image ) }}" alt="" style="width:100%">
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                {{-- parent Category ------------------------------------------------------------------------------------- --}}

                                <div class="row mb-3">
                                    <div class="col-12">
                                        <label for="example-number-input" class="col-md-6"> @lang('categories.parent')</label>
                                        <span class="text-primary col-md-6">{{ @$item->parent?  @$item->parent->trans->where('locale',$current_lang)->first()->title :""  }}</span>
                                    </div>
                                </div>

                                {{-- sort ------------------------------------------------------------------------------------- --}}
                                <div class="row mb-3">
                                    <div class="col-12">
                                        <label for="example-number-input" class="col-md-6"> @lang('categories.sort')</label>
                                        <span class="col-md-6">{{ @$item->sort  }}</span>
                                    </div>
                                </div>
                                {{-- feature ------------------------------------------------------------------------------------- --}}
                                <div class="col-12 ">
                                    <label class="col-md-6 col-form-label" for="available">{{ trans('admin.feature') }}</label>
                                    @if($item->feature == 1 )
                                    <span class="badge bg-success">@lang("admin.yes")</span>
                                    @else
                                    <span class="badge bg-danger">@lang("admin.no")</span>
                                    @endif
                                </div>


                                {{-- Status ------------------------------------------------------------------------------------- --}}
                                <div class="col-12">
                                    <label class="col-sm-6 col-form-label" for="available">{{ trans('admin.status') }}</label>
                                    @if($item->status == 1 )
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
        <div class="row mb-3 text-end">
            <div>
                <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-primary waves-effect waves-light ml-3">@lang('button.cancel')</a>
                <button type="submit" class="btn btn-outline-success waves-effect waves-light ml-3">@lang('button.save')</button>
            </div>
        </div>

    </div>
</div>

@endsection



@section('style')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="{{ asset('site/js/ckeditor/ckeditor.js') }}"></script>
@endsection
