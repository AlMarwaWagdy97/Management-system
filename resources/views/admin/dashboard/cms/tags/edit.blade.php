@extends('admin.app')

@section('title', trans('tags.edit'))
@section('title_page', trans('tags.tags'))
@section('title_route', route('admin.tag.index') )
@section('button_page')
<a href="{{ route('admin.tag.index') }}" class="btn btn-primary waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
@endsection

@section('content')


<div class="row">
    <div class="card">
        <div class="card-body">

            <form action="{{ route('admin.tag.update', $tag->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('put')
                <div class="row">
                    <div class="col-md-8">
                        @foreach ($languages as $key => $locale)
                        <div class="accordion mt-4 mb-4" id="accordionExampleTitle{{ $key }}">
                            <div class="accordion-item border rounded">
                                <h2 class="accordion-header" id="headingTitle{{ $key }}">
                                    <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTitle{{ $key }}" aria-expanded="true" aria-controls="collapseTitle{{ $key }}">
                                        {{ trans('lang.' .Locale::getDisplayName($locale))}}
                                    </button>
                                </h2>
                                <div id="collapseTitle{{ $key }}" class="accordion-collapse collapse show mt-3" aria-labelledby="headingTitle{{ $key }}" data-bs-parent="#accordionExampleTitle{{ $key }}">
                                    <div class="accordion-body">
                                        {{-- title ------------------------------------------------------------------------------------- --}}
                                        <div class="row mb-3">
                                            <label for="example-text-input" class="col-sm-2 col-form-label">{{ trans('admin.title_in') .  trans('lang.' .Locale::getDisplayName($locale))}}</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" type="text" name="{{ $locale }}[title]" value="{{ $tag->trans->where('locale',$locale)->first()->title }}" id="title{{ $key }}">
                                            </div>
                                            @if ($errors->has($locale . '.title'))
                                            <span class="missiong-spam">{{ $errors->first($locale . '.title') }}</span>
                                            @endif
                                        </div>

                                        {{-- Start Slug --}}
                                        <div class="row mb-3 slug-section">
                                            <label for="example-text-input" class="col-sm-2 col-form-label">{{ trans('admin.slug_in') . trans('lang.' .Locale::getDisplayName($locale)) }} </label>
                                            <div class="col-sm-10">
                                                <input type="text" id="slug{{ $key }}" name="{{ $locale }}[slug]" value="{{$tag->trans->where('locale',$locale)->first()->slug }}" class="form-control slug" required>
                                                @if($errors->has($locale .'.slug'))
                                                <span class="missiong-spam">{{ $errors->first($locale . '.slug') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        @include('admin.layouts.scriptSlug')
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
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
                                        {{-- image ------------------------------------------------------------------------------------- --}}
                                        <div class="col-12">
                                            <div class="row mb-3">
                                                <label for="example-number-input" col-form-label> @lang('admin.image')</label>
                                                <div class="col-md-6 m-b">
                                                    <a href="{{ getImage( $tag->image) }}" target="_blank">
                                                        <img src="{{ getImageThumb( $tag->image ) }}" alt="" style="width:100%">
                                                    </a>
                                                </div>
                                                <div class="col-sm-12 mt-3">
                                                    <input class="form-control" type="file" placeholder="@lang('admin.image')" id="example-number-input" name="image" value="{{ old('image') }}">
                                                </div>
                                            </div>
                                        </div>
                                        {{-- sort ------------------------------------------------------------------------------------- --}}
                                        <div class="col-12">
                                            <div class="row mb-3">
                                                <label for="example-number-input" col-form-label>
                                                    @lang('articles.sort')</label>
                                                <div class="col-sm-12">
                                                    <input class="form-control" type="number" id="example-number-input" name="sort" value="{{ $tag->sort }}">
                                                </div>
                                            </div>
                                        </div>
                                        {{-- feature ------------------------------------------------------------------------------------- --}}
                                        <div class="col-12">
                                            <div class="form-check form-switch form-check-success">
                                                <label class="form-check-label" for="flexSwitchCheckSuccess">@lang('admin.feature')</label>
                                                <input class="form-check-input" type="checkbox" role="switch" name="feature" {{  @$tag->feature == 1 ? 'checked' : '' }} id="flexSwitchCheckSuccess">
                                            </div>
                                        </div>
                                        {{-- Status ------------------------------------------------------------------------------------- --}}
                                        <div class="col-12">
                                            <div class="form-check form-switch form-check-success">
                                                <label class="form-check-label" for="flexSwitchCheckSuccess">@lang('admin.status')</label>
                                                <input class="form-check-input" type="checkbox" role="switch" name="status" {{  @$tag->status == 1 ? 'checked' : '' }} id="flexSwitchCheckSuccess">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mb-3 text-end">
                        <div>
                            <a href="{{ route('admin.tag.index') }}" class="btn btn-primary waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
                            <button type="submit" class="btn btn-outline-success waves-effect waves-light ml-3 btn-sm">@lang('button.save')</button>
                            <button type="submit" name="submit" value="update" class="btn btn-outline-success waves-effect waves-light  btn-sm">@lang('button.save_update')</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection


@section('style')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
@endsection
