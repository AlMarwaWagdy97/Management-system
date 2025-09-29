@extends('admin.app')

@section('title', trans('portfolio.edit_portfolio'))
@section('title_page', trans('portfolio.portfolio'))
@section('title_route', route('admin.portfolio.index') )
@section('button_page')
<a href="{{ route('admin.portfolio.index') }}" class="btn btn-outline-primary waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
@endsection


@section('content')

<div class="card">
    <div class="card-body">

        <form action="{{ route('admin.portfolio.update',$portfolio->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('put')

            <div class="row">

                <div class="col-md-8">
                    @foreach ($languages as $key => $locale)
                    <div class="accordion mt-4 mb-4" id="accordionExample">
                        <div class="accordion-item border rounded">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne{{ $key }}" aria-expanded="true" aria-controls="collapseOne">
                                    {{ trans('lang.' . Locale::getDisplayName($locale)) }}
                                </button>
                            </h2>
                            <div id="collapseOne{{ $key }}" class="accordion-collapse collapse show mt-3" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                <div class="accordion-body">

                                    {{-- title ------------------------------------------------------------------------------------- --}}
                                    <div class="row mb-3">
                                        <label for="example-text-input" class="col-sm-12 col-form-label">{{ trans('admin.title_in') .   trans('lang.' .Locale::getDisplayName($locale)) }}</label>
                                        <div class="col-sm-12">
                                            <input class="form-control" type="text" name="{{ $locale }}[title]" value="{{ @$portfolio->trans->where('locale', $locale)->first()->title }}" id="title{{ $key }}">
                                        </div>
                                        @if ($errors->has($locale . '.title'))
                                        <span class="missiong-spam">{{ $errors->first($locale . '.title') }}</span>
                                        @endif
                                    </div>

                                    {{-- description ------------------------------------------------------------------------------------- --}}
                                    <div class="row mb-3">
                                        <label for="example-text-input" class="col-sm-12 col-form-label">{{ trans('admin.description_in') . trans('lang.' .Locale::getDisplayName($locale)) }} </label>
                                        <div class="col-sm-12 mb-2">
                                            <textarea id="description{{ $key }}" name="{{ $locale }}[description]"> {{ @$portfolio->trans->where('locale',$locale)->first()->description }} </textarea>
                                            @if($errors->has( $locale . '.description'))
                                            <span class="missiong-spam">{{ $errors->first( $locale . '.description') }}</span>
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
                    <div class="accordion mt-4 mb-4" id="accordionExampleTwo">
                        <div class="accordion-item border rounded">
                            <h2 class="accordion-header" id="headingtwo">
                                <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                                    {{ trans('admin.settings') }}
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse show" aria-labelledby="headingTwo" data-bs-parent="#accordionExampleTwo">
                                <div class="accordion-body">
                                    <div class="col-sm-3 col-md-6 mb-3">
                                        <a href="{{ getImage( $portfolio->image) }}" target="_blank">
                                            <img src="{{ getImageThumb( $portfolio->image ) }}" alt="" style="width:100%">
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
                                    {{-- Category  ------------------------------------------------------------------------------- --}}
                                    <div class="col-12">
                                        <div class="row mb-3">
                                            <label for="example-number-input"> @lang('tags.tags')</label>
                                            <div class="col-sm-12">
                                                <select class="form-select form-select-sm select2" name="tag_id">
                                                    <option value="" disabled selected> {{ trans('tags.tags') }}</option>
                                                    @foreach ($tags as $tag)
                                                    <option value="{{ $tag->id }}" {{ $portfolio->tag_id == $tag->id ? 'selected' : '' }}> {{ @$tag->trans->where('locale', $current_lang)->first()->title }} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        @error('category_id')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    {{-- sort ------------------------------------------------------------------------------------- --}}
                                    <div class="col-12">
                                        <div class="row mb-3">
                                            <label for="example-number-input" col-form-label> @lang('portfolio.sort')</label>
                                            <div class="col-sm-12">
                                                <input class="form-control" type="number" id="example-number-input" name="sort" value="{{ @$portfolio->sort }}">
                                            </div>
                                        </div>
                                    </div>
                                    {{-- feature ------------------------------------------------------------------------------------- --}}
                                    <div class="col-12 mb-3">
                                        <div class="form-check form-switch form-check-success">
                                            <label class="form-check-label" for="flexSwitchCheckSuccessFeature">@lang('admin.feature')</label>
                                            <input class="form-check-input" type="checkbox" role="switch" name="feature"  {{  @$portfolio->feature == 1 ? 'checked' : '' }} id="flexSwitchCheckSuccessFeature">
                                        </div>
                                    </div>
                                    {{-- Status ------------------------------------------------------------------------------------- --}}
                                    <div class="col-12 mb-3">
                                        <div class="form-check form-switch form-check-success">
                                            <label class="form-check-label" for="flexSwitchCheckSuccessStatus">@lang('admin.status')</label>
                                            <input class="form-check-input" type="checkbox" role="switch" name="status"  {{  @$portfolio->status == 1 ? 'checked' : '' }} id="flexSwitchCheckSuccessStatus">
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
                        <a href="{{ route('admin.portfolio.index') }}" class="btn btn-outline-danger waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
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
