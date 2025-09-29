@extends('admin.app')

@section('title', trans('portfolio.show_portfolio'))
@section('title_page', trans('portfolio.portfolio'))
@section('title_route', route('admin.portfolio.index') )
@section('button_page')
<a href="{{ route('admin.portfolio.index') }}" class="btn btn-outline-primary waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
@endsection


@section('content')

<div class="card">
    <div class="card-body">


        <div class="row">

            <div class="col-md-8">
                @foreach ($languages as $key => $locale)
                <div class="accordion mt-4 mb-4" id="accordionExampleTitle">
                    <div class="accordion-item border rounded">
                        <h2 class="accordion-header" id="headingTitle{{ $key }}">
                            <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTitle{{ $key }}" aria-expanded="true" aria-controls="collapseTitle{{ $key }}">
                                {{ trans('lang.' . Locale::getDisplayName($locale)) }}
                            </button>
                        </h2>
                        <div id="collapseTitle{{ $key }}" class="accordion-collapse collapse show mt-3" aria-labelledby="headingTitle" data-bs-parent="#accordionExampleTitle">
                            <div class="accordion-body">

                                {{-- title ------------------------------------------------------------------------------------- --}}
                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">{{ trans('admin.title_in') .   trans('lang.' .Locale::getDisplayName($locale)) }}</label>
                                    <div class="col-sm-10">
                                        <input class="form-control" type="text" name="{{ $locale }}[title]" disabled value="{{ @$portfolio->trans->where('locale', $locale)->first()->title }}" id="title{{ $key }}">
                                    </div>
                                </div>

                                {{-- description ------------------------------------------------------------------------------------- --}}
                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">{{ trans('admin.description_in') . trans('lang.' .Locale::getDisplayName($locale)) }} </label>
                                    <div class="col-sm-10 mb-2">
                                        <p>{!! @$portfolio->trans->where('locale',$locale)->first()->description !!}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                @endforeach
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
                                <div class="col-sm-3 col-md-6 mb-3">
                                    <a href="{{ getImageThumb( $portfolio->image) }}" target="_blank">
                                        <img src="{{ getImage( $portfolio->image ) }}" alt="" style="width:100%">
                                    </a>
                                </div>

                                {{-- Category  ------------------------------------------------------------------------------- --}}
                                <div class="row mb-3">
                                    <div class="col-12">
                                        <label class="col-md-3 col-form-label" for="available"> @lang('tags.tags')</label>
                                        <span class="badge bg-primary">{{ @$portfolio->tag ?@$portfolio->tag->trans->where('locale',$current_lang)->first()->title: "__"  }}</span>
                                    </div>
                                </div>


                                {{-- sort ------------------------------------------------------------------------------------- --}}
                                <div class="row mb-3">
                                    <div class="col-12">
                                        <label class="col-md-3 col-form-label" for="available">@lang('portfolio.sort')</label>
                                        <span>{{ @$portfolio->sort }}</span>
                                    </div>
                                </div>
                                <div class="col-12 ">
                                    <label class="col-md-3 col-form-label" for="available">{{ trans('admin.feature') }}</label>
                                    @if($portfolio->feature == 1 )
                                    <span class="badge  bg-success">@lang("admin.yes")</span>
                                    @else
                                    <span class="badge  bg-danger">@lang("admin.no")</span>
                                    @endif
                                </div>

                                {{-- Status ------------------------------------------------------------------------------------- --}}
                                <div class="col-12">
                                    <label class="col-sm-3 col-form-label" for="available">{{ trans('admin.status') }}</label>
                                    @if($portfolio->status == 1 )
                                    <span class="badge  bg-success">@lang("admin.active")</span>
                                    @else
                                    <span class="badge  bg-danger">@lang("admin.dis_active")</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Butoooons ------------------------------------------------------------------------- --}}
            <div class="row mb-3 text-end">
                <div>
                    <a href="{{ route('admin.portfolio.index') }}" class="btn btn-outline-primary waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
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
