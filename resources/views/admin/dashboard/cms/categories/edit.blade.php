@extends('admin.app')

@section('title', trans('categories.edit'))
@section('title_page', trans('categories.categories'))
@section('title_route', route('admin.categories.index') )
@section('button_page')
<a href="{{ route('admin.categories.index') }}" class="btn btn-outline-primary waves-effect waves-light ml-3">@lang('button.cancel')</a>
@endsection


@section('content')

<div class="card">
    <div class="card-body">

        <form action="{{ route('admin.categories.update', $item->id) }}" method="post"  enctype="multipart/form-data">
            @csrf
            @method('put')
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
                            <div id="collapseTitle{{ $key }}" class="accordion-collapse collapse show mt-3" aria-labelledby="headingOne{{ $key }}" data-bs-parent="#accordionExampleTitle{{ $key }}">
                                <div class="accordion-body">
                                    {{-- title ------------------------------------------------------------------------------------- --}}
                                    <div class="row mb-3">
                                        <label for="example-text-input" class="col-sm-12 col-form-label">{{ trans('admin.title_in') . trans('lang.' .Locale::getDisplayName($locale)) }}</label>
                                        <div class="col-sm-12">
                                            <input type="text" id="title{{ $key }}" name="{{ $locale }}[title]" value="{{ @$item->trans->where('locale',$locale)->first()->title}}" class="form-control" required>
                                            @if($errors->has($locale .'.title'))
                                            <span class="missiong-spam">{{ $errors->first($locale . '.title') }}</span>
                                            @endif
                                        </div>
                                    </div>


                                    {{-- Start Slug --}}
                                    <div class="row mb-3 slug-section">
                                        <label for="example-text-input" class="col-sm-12 col-form-label">{{ trans('admin.slug_in') . trans('lang.' .Locale::getDisplayName($locale)) }} </label>

                                        <div class="col-sm-12">
                                            <input type="text" id="slug{{ $key }}" name="{{ $locale }}[slug]" value="{{ @$item->trans->where('locale',$locale)->first()->slug }}" class="form-control slug" required>
                                            @if($errors->has($locale .'.slug'))
                                            <span class="missiong-spam">{{ $errors->first($locale . '.slug') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    @include('admin.layouts.scriptSlug')
                                    {{-- End Slug --}}

                                    {{-- description ------------------------------------------------------------------------------------- --}}
                                    <div class="row mb-3">
                                        <label for="example-text-input" class="col-sm-12 col-form-label">
                                            {{ trans('admin.description_in') . trans('lang.' .Locale::getDisplayName($locale)) }} </label>
                                        <div class="col-sm-12 mt-12">
                                            <textarea id="description{{ $key }}" name="{{ $locale }}[description]" class="form-control" rows="5" cols="100"> {{ @$item->trans->where('locale',$locale)->first()->description}} </textarea>
                                            @if ($errors->has($locale . '.description'))
                                            <span class="missiong-spam">{{ $errors->first($locale . '.description') }}</span>
                                            @endif
                                        </div>
                                        {{-- <script type="text/javascript">
                                            CKEDITOR.replace('description{{ $key }}', {
                                        filebrowserUploadUrl: "{{ route('admin.ckeditor.upload', ['_token' => csrf_token()]) }}"
                                        , filebrowserUploadMethod: 'form'
                                        });
                                        </script> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach

                    <div class="accordion mt-4 mb-4" id="accordionExampleMeta">
                        <div class="accordion-item border rounded">
                            <h2 class="accordion-header" id="headingMeta{{ $key }}">
                                <button class="accordion-button fw-medium " type="button" data-bs-toggle="collapse" data-bs-target="#collapseMeta{{ $key }}" aria-expanded="true" aria-controls="collapseMeta{{ $key }}">
                                    @lang('admin.meta')
                                </button>
                            </h2>
                            <div id="collapseMeta{{ $key }}" class="accordion-collapse collapse  mt-3" aria-labelledby="headingMeta{{ $key }}" data-bs-parent="#accordionExampleMeta">
                                <div class="accordion-body">

                                    @foreach ($languages as $key => $locale)
                                    {{-- meta_title_ ------------------------------------------------------------------------------------- --}}
                                    {{-- meta_title_ ------------------------------------------------------------------------------------- --}}
                                    <div class="row mb-3">
                                        <label for="example-text-input" class="col-sm-2 col-form-label">{{ trans('admin.meta_title_in') . trans('lang.' .Locale::getDisplayName($locale)) }}</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" type="text" name="{{ $locale }}[meta_title]" value="{{ @$item->trans->where('locale',$locale)->first()->meta_title }}" id="title{{ $key }}">
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
                                            <textarea name="{{ $locale }}[meta_description]" class="form-control description"> {{ @$item->trans->where('locale',$locale)->first()->meta_description }} </textarea>
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
                                            <textarea name="{{ $locale }}[meta_key]" class="form-control description"> {{ @$item->trans->where('locale',$locale)->first()->meta_key }} </textarea>
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
                                    <div class="row mb-3">
                                        {{-- image ------------------------------------------------------------------------------------- --}}
                                        <a href="{{ getImageThumb( $item->image) }}" target="_blank">
                                            <img src="{{ getImageThumb( $item->image ) }}" alt="" style="width:100%">
                                        </a>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-12">
                                            <label for="example-number-input"> @lang('admin.image')</label>
                                            <div class="col-sm-12">
                                                <input class="form-control" type="file" name="image">
                                            </div>
                                        </div>
                                        @if ($errors->has("image"))
                                        <span class="missiong-spam">{{ $errors->first("image") }}</span>
                                        @endif
                                    </div>

                                    {{-- parent Category ------------------------------------------------------------------------------------- --}}

                                    <div class="col-12">
                                        <div class="row mb-3">
                                            <label for="example-number-input"> @lang('categories.parent')</label>
                                            <div class="col-sm-12">
                                                <select class="form-select form-select-sm select2" name="parent_id">
                                                    <option value="" selected> {{ trans('categories.select_parent') }}</option>
                                                    @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}" {{ $item->parent_id == $category->id ? 'selected' : '' }}> {{ str_repeat('ـــ ', $category->level - 1) }} {{ @$category->trans->where('locale',$current_lang)->first()->title }} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        @error('parent_id')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    {{-- sort ------------------------------------------------------------------------------------- --}}
                                    <div class="col-12">
                                        <div class="row mb-3">
                                            <label for="example-number-input"> @lang('categories.sort')</label>
                                            <div class="col-sm-12">
                                                <input class="form-control" type="number" name="sort" value="{{ $item->sort }}">
                                            </div>
                                            @error('sort')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>


                                    {{-- Status ------------------------------------------------------------------------------------- --}}
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-check form-switch form-check-success">
                                                <label class="form-check-label" for="flexSwitchCheckSuccessStatus">@lang('admin.status')</label>
                                                <input class="form-check-input" type="checkbox" role="switch" name="status" {{  $item->status == 1 ? 'checked' : '' }} id="flexSwitchCheckSuccessStatus">
                                            </div>
                                            @error('status')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        {{-- feature ------------------------------------------------------------------------------------- --}}
                                        <div class="row2">
                                            <div class="col-12">
                                                <div class="form-check form-switch form-check-success">
                                                    <label class="form-check-label" for="flexSwitchCheckSuccessFeature">@lang('admin.feature')</label>
                                                    <input class="form-check-input" type="checkbox" role="switch" name="feature" {{   $item->feature == 1 ? 'checked' : '' }} id="flexSwitchCheckSuccessFeature">
                                                </div>
                                                @error('feature')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>


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
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-primary waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
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
