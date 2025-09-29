@extends('admin.app')

@section('title', trans('admin.page_edit'))
@section('title_page', trans('admin.pages'))
@section('title_route', route('admin.pages.index') )
@section('button_page')
<a href="{{ route('admin.pages.index') }}" class="btn btn-outline-primary waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
@endsection

@section('content')

<div class="row">
    <div class="col-12 m-3">
        <div class="card">
            <div class="card-body">

                <form action="{{ route('admin.pages.update', $page->id)  }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-8">
                            @foreach ($languages as $key => $locale)
                            <div class="accordion mt-4 mb-4" id="accordionExampleTitle{{ $key }}">
                                <div class="accordion-item border rounded">
                                    <h2 class="accordion-header" id="headingTitle{{ $key }}">
                                        <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTitle{{ $key }}" aria-expanded="true" aria-controls="collapseOne{{ $key }}">
                                            {{ trans('lang.' .Locale::getDisplayName($locale))   }}
                                        </button>
                                    </h2>
                                    <div id="collapseTitle{{ $key }}" class="accordion-collapse collapse show mt-3" aria-labelledby="headingTitle{{ $key }}" data-bs-parent="#accordionExampleTitle{{ $key }}">
                                        <div class="accordion-body">



                                            {{-- title ------------------------------------------------------------------------------------- --}}
                                            <div class="row mb-3">
                                                <label for="example-text-input" class="col-sm-12 col-form-label">{{ trans('admin.title_in') . trans('lang.' .Locale::getDisplayName($locale)) }}</label>
                                                <div class="col-sm-12">
                                                    <input class="form-control" type="text" name="{{ $locale }}[title]" value="{{ @$page->trans->where('locale', $locale)->first()->title }}" id="title{{ $key }}">
                                                </div>
                                                @if ($errors->has($locale . '.title'))
                                                <span class="missiong-spam">{{ $errors->first($locale . '.title') }}</span>
                                                @endif
                                            </div>

                                            {{-- slug ------------------------------------------------------------------------------------- --}}
                                            {{-- Start Slug --}}
                                            <div class="row mb-3 slug-section">
                                                <label for="example-text-input" class="col-sm-12 col-form-label">{{ trans('admin.slug_in') . trans('lang.' .Locale::getDisplayName($locale)) }} </label>

                                                <div class="col-sm-12">
                                                    <input type="text" id="slug{{ $key }}" name="{{ $locale }}[slug]" value="{{ @$page->trans->where('locale', $locale)->first()->slug }}" class="form-control slug mb-2" required>
                                                    @if ($errors->has($locale . '.slug'))
                                                    <span class="missiong-spam">{{ $errors->first($locale . '.slug') }}</span>
                                                    @endif
                                                </div>
                                                @include('admin.layouts.scriptSlug')
                                                {{-- End Slug --}}



                                                {{-- content ------------------------------------------------------------------------------------- --}}
                                                <div class="row mb-3">
                                                    <label for="example-text-input" class="col-sm-12 col-form-label">
                                                        {{ trans('admin.content_in') . trans('lang.' .Locale::getDisplayName($locale)) }} </label>
                                                    <div class="col-sm-12 mb-2">
                                                        <textarea id="content{{ $key }}" name="{{ $locale }}[content]"> {{ @$page->trans->where('locale', $locale)->first()->content }} </textarea>
                                                        @if ($errors->has($locale . '.content'))
                                                        <span class="missiong-spam">{{ $errors->first($locale . '.content') }}</span>
                                                        @endif
                                                    </div>
                                                    <script type="text/javascript">
                                                        CKEDITOR.replace('content{{ $key }}', {
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


                                <div class="accordion mt-4 mb-4" id="accordionExample">
                                    <div class="accordion-item border rounded">
                                        <h2 class="accordion-header" id="headingTwo{{ $key }}">
                                            <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo{{ $key }}" aria-expanded="true" aria-controls="collapseTwo{{ $key }}">
                                                @lang('admin.meta')
                                            </button>
                                        </h2>
                                        <div id="collapseTwo{{ $key }}" class="accordion-collapse collapse  mt-3" aria-labelledby="headingTwo{{ $key }}" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">

                                                @foreach ($languages as $key => $locale)
                                                {{-- meta_title_ ------------------------------------------------------------------------------------- --}}
                                                <div class="row mb-3">
                                                    <label for="example-text-input" class="col-sm-2 col-form-label">{{ trans('admin.meta_title_in') . trans('lang.' .Locale::getDisplayName($locale)) }}</label>
                                                    <div class="col-sm-10">
                                                        <input class="form-control" type="text" name="{{ $locale }}[meta_title]" value="{{ @$page->trans->where('locale', $locale)->first()->meta_title }}" id="title{{ $key }}">
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
                                                        <textarea name="{{ $locale }}[meta_description]" class="form-control description"> {{ @$page->trans->where('locale', $locale)->first()->meta_description }} </textarea>
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
                                                        <textarea name="{{ $locale }}[meta_key]" class="form-control description"> {{ @$page->trans->where('locale', $locale)->first()->meta_key }} </textarea>
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
                        </div>




                    </div>


                    <div class="col-md-4">

                        <div class="accordion mt-4 mb-4" id="accordionExampleSetting">
                            <div class="accordion-item border rounded">
                                <h2 class="accordion-header" id="headingSetting">
                                    <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSetting" aria-expanded="true" aria-controls="collapseOne">
                                        {{ trans('admin.settings') }}
                                    </button>
                                </h2>
                                <div id="collapseSetting" class="accordion-collapse collapse show" aria-labelledby="headingSetting" data-bs-parent="#accordionExampleSetting">
                                    <div class="accordion-body">
                                        <div class="col-sm-3 mb-3">
                                            <a href="{{ getImage( $page->image) }}" target="_blank">
                                                <img src="{{  getImageThumb( $page->image )   }}" alt="" style="width:100%">
                                            </a>
                                        </div>

                                        {{-- image ------------------------------------------------------------------------------------- --}}
                                        <div class="col-12">
                                            <div class="row mb-3">
                                                <label for="example-number-input" col-form-label>
                                                    @lang('admin.image')</label>
                                                <div class="col-sm-12">
                                                    <input class="form-control" type="file" placeholder="@lang('admin.image')" id="example-number-input" name="image" value="{{ old('image') }}">
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Status ------------------------------------------------------------------------------------- --}}
                                        <div class="col-12">
                                            <label class="col-sm-12 col-form-label" for="available">{{ trans('admin.status') }}</label>
                                            <div class="col-sm-10">
                                                <div class="form-check form-switch form-check-success">
                                                    <label class="form-check-label" for="flexSwitchCheckSuccessStatus">@lang('admin.status')</label>
                                                    <input class="form-check-input" type="checkbox" role="switch" name="status"  {{  @$page->status == 1 ? 'checked' : '' }} id="flexSwitchCheckSuccessStatus">
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
                            <a href="{{ route('admin.pages.index') }}" class="btn btn-outline-primary waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
                            <button type="submit" class="btn btn-outline-success waves-effect waves-light ml-3 btn-sm">@lang('button.save')</button>
                            <button type="submit" name="submit" value="update" class="btn btn-outline-success waves-effect waves-light  btn-sm">@lang('button.save_update')</button>
                        </div>
                    </div>
            </div>




            </form>

        </div>
    </div>
</div>

</div> <!-- container-fluid -->

@endsection


@section('style')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="{{ asset('site/js/ckeditor/ckeditor.js') }}"></script>
@endsection
