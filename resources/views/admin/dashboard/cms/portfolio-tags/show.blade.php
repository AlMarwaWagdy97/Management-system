@extends('admin.app')

@section('title', trans('tags.show'))
@section('title_page', trans('portfoliotags.tags'))
@section('title_route', route('admin.portfolio-tags.index') )
@section('button_page')
<a href="{{ route('admin.portfolio-tags.index') }}" class="btn btn-primary waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
@endsection


@section('content')

<div class="card">
    <div class="card-body">


        <div class="row">
            <div class="col-md-8">
                <div class="accordion mt-4 mb-4" id="accordionExampletitle">
                    <div class="accordion-item border rounded">
                        <h2 class="accordion-header" id="headingTitle">
                            <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTitle" aria-expanded="true" aria-controls="collapseTitle">
                                {{ trans('admin.title') }}
                            </button>
                        </h2>
                        <div id="collapseTitle" class="accordion-collapse collapse show mt-3" aria-labelledby="headingTitle" data-bs-parent="#accordionExampletitle">
                            <div class="accordion-body">
                                @foreach ($languages as $key => $locale)
                                {{-- title ------------------------------------------------------------------------------------- --}}
                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">{{ trans('admin.title_in') .  trans('lang.' .Locale::getDisplayName($locale)) }}</label>
                                    <div class="col-sm-10">
                                        <input class="form-control" type="text" name="{{ $locale }}[title]" disabled value="{{ $portfolioTag->trans->where('locale',$locale)->first()->title }}" id="title{{ $key }}">
                                    </div>
                                    @if($errors->has( $locale . '.title'))
                                    <span class="missiong-spam">{{ $errors->first( $locale . '.title') }}</span>
                                    @endif
                                </div>
                                @endforeach

                            </div>
                        </div>
                    </div>
                </div>

            </div>


            <div class="col-md-4">
                {{-- ------ Start Post Settings------ --}}
                <div class="accordion mt-4 mb-4" id="accordionExampleSetting">
                    <div class="accordion-item border rounded">
                        <h2 class="accordion-header" id="headingSetting">
                            <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSetting" aria-expanded="true" aria-controls="collapseSetting">
                                {{ trans('tags.Post_settings') }}
                            </button>
                        </h2>
                        <div id="collapseSetting" class="accordion-collapse collapse show" aria-labelledby="headingSetting" data-bs-parent="#accordionExampleSetting">
                            <div class="accordion-body">

                                {{-- sort ------------------------------------------------------------------------------------- --}}
                                <div class="row mb-3">
                                    <div class="col-12">
                                        <label for="example-number-input" class="col-sm-3 col-form-label"> @lang('articles.sort')</label>
                                            <span>{{ $portfolioTag->sort }}</span>
                                    </div>
                                </div>
                                {{-- feature ------------------------------------------------------------------------------------- --}}
                                <div class="col-12">
                                    <label class="col-sm-3 col-form-label" for="available">{{ trans('admin.feature') }}</label>
                                    @if($portfolioTag->feature == 1 )
                                    <span class="badge  bg-success">@lang("admin.yes")</span>
                                    @else
                                    <span class="badge  bg-danger">@lang("admin.no")</span>
                                    @endif
                                </div>
                                {{-- Status ------------------------------------------------------------------------------------- --}}
                                <div class="col-12">
                                    <label class="col-sm-3 col-form-label" for="available">{{ trans('admin.status') }}</label>
                                    @if($portfolioTag->status == 1 )
                                    <span class="badge  bg-success">@lang("admin.active")</span>
                                    @else
                                    <span class="badge  bg-danger">@lang("admin.dis_active")</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- ------ End Post Settings------ --}}
            </div>
        </div>
    </div>
</div>

@endsection
