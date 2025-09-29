@extends('admin.app')

@section('title', trans('portfoliotags.edit'))
@section('title_page', trans('portfoliotags.tags'))
@section('title_route', route('admin.portfolio-tags.index') )
@section('button_page')
<a href="{{ route('admin.portfolio-tags.index') }}" class="btn btn-primary waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
@endsection

@section('content')

<div class="container-fluid">

    <div class="card">
        <div class="card-body">

            <form action="{{ route('admin.portfolio-tags.update', $portfolioTag->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('put')
                <div class="row">
                    <div class="col-md-8">
                        <div class="accordion mt-4 mb-4" id="accordionExampleTitle">
                            <div class="accordion-item border rounded">
                                <h2 class="accordion-header" id="headingOneTitle">
                                    <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOnetitle" aria-expanded="true" aria-controls="collapseOnetitle">
                                        {{ trans('admin.title')}}
                                    </button>
                                </h2>
                                <div id="collapseOnetitle" class="accordion-collapse collapse show mt-3" aria-labelledby="headingOneTitle" data-bs-parent="#accordionExampleTitle">
                                    <div class="accordion-body">


                                        @foreach ($languages as $key => $locale)

                                        {{-- title ------------------------------------------------------------------------------------- --}}
                                        <div class="row mb-3">
                                            <label for="example-text-input" class="col-sm-2 col-form-label">{{ trans('admin.title_in') .  trans('lang.' .Locale::getDisplayName($locale))}}</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" type="text" name="{{ $locale }}[title]" value="{{ $portfolioTag->trans->where('locale',$locale)->first()->title }}" id="title{{ $key }}">
                                            </div>
                                            @if ($errors->has($locale . '.title'))
                                            <span class="missiong-spam">{{ $errors->first($locale . '.title') }}</span>
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
                                        <div class="col-12">
                                            <div class="row mb-3">
                                                <label for="example-number-input" class="col-md-3 col-form-label"> @lang('articles.sort')</label>
                                                <div class="col-sm-8">
                                                    <input class="form-control" type="number" id="example-number-input" name="sort" value="{{ $portfolioTag->sort }}">
                                                </div>
                                            </div>
                                        </div>
                                        {{-- feature ------------------------------------------------------------------------------------- --}}
                                        <div class="col-12">
                                            <div class="form-check form-switch form-check-success">
                                                <label class="form-check-label" for="flexSwitchCheckSuccessFeature">@lang('admin.feature')</label>
                                                <input class="form-check-input" type="checkbox" role="switch" name="feature" {{  @$portfolioTag->feature  == 1 ? 'checked' : '' }} id="flexSwitchCheckSuccessFeature">
                                            </div>
                                        </div>

                                        {{-- Status ------------------------------------------------------------------------------------- --}}
                                        <div class="col-12">
                                            <div class="form-check form-switch form-check-success">
                                                <label class="form-check-label" for="flexSwitchCheckSuccessStatus">@lang('admin.status')</label>
                                                <input class="form-check-input" type="checkbox" role="switch" name="status" {{  @$portfolioTag->status == 1 ? 'checked' : '' }} id="flexSwitchCheckSuccessStatus">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>                        {{-- ------ End Post Settings------ --}}
                    </div>
                    {{-- Butoooons ------------------------------------------------------------------------- --}}
                    <div class="row mb-3 text-end">
                        <div>
                            <a href="{{ route('admin.portfolio-tags.index') }}" class="btn btn-primary waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
                            <button type="submit" class="btn btn-outline-success waves-effect waves-light ml-3 btn-sm">@lang('button.save')</button>
                            <button type="submit" name="submit" value="update" class="btn btn-outline-success waves-effect waves-light  btn-sm">@lang('button.save_update')</button>
                        </div>
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
