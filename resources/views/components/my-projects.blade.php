<div>
    <div class="row">
        <div class="col-md-8">
            @foreach ($languages as $key => $locale)
            <div class="mt-4 mb-4 accordion" id="accordionExampleTitle{{ $key }}">
                <div class="border rounded accordion-item">
                    <h2 class="accordion-header" id="headingTitles{{ $key }}">
                        <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTitle{{ $key }}" aria-expanded="true" aria-controls="collapseOne{{ $key }}">
                            {{ trans('lang.' . Locale::getDisplayName($locale)) }}
                        </button>
                    </h2>
                    <div id="collapseTitle{{ $key }}" class="mt-3 accordion-collapse collapse show" aria-labelledby="headingTitles{{ $key }}" data-bs-parent="#accordionExampleTitle{{ $key }}">
                        <div class="accordion-body">
                            {{-- title ------------------------------------------------------------------------------------- --}}
                            <div class="mb-3 row">
                                <label for="example-text-input" class="col-sm-12 col-form-label">
                                    {{ trans('admin.title_in') . trans('lang.' . Locale::getDisplayName($locale)) }}
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col-sm-12">
                                    <input class="form-control {{ (empty($errors->first($locale . '.title'))) ?: 'has-error'  }}" type="text" name="{{ $locale }}[title]" value="{{ old($locale . '.title') }}" id="title{{ $key }}">
                                    @if ($errors->has($locale . '.title'))
                                    <span class="missiong-spam">{{ $errors->first($locale . '.title') }}</span>
                                    @endif
                                </div>

                            </div>

                            {{-- slug ------------------------------------------------------------------------------------- --}}
                            <div class="mb-3 row slug-section">
                                <label for="example-text-input" class="col-sm-12 col-form-label">{{
                                    trans('admin.slug_in') . trans('lang.' . Locale::getDisplayName($locale)) }}
                                </label>
                                <div class="col-sm-12">
                                    <input type="text" id="slug{{ $key }}" name="{{ $locale }}[slug]" value="{{ old($locale . '.slug') }}" class="form-control slug {{ (empty($errors->first($locale . '.slug'))) ?: 'has-error'  }}">
                                    @if ($errors->has($locale . '.slug'))
                                    <span class="missiong-spam">{{ $errors->first($locale . '.slug') }}</span>
                                    @endif
                                </div>
                                @include('admin.layouts.scriptSlug')
                                {{-- End Slug ---------------------------------------------------------------------- --}}
                            </div>

                            <div class="mt-3 row">
                                <label for="example-text-input" class="col-sm-12 col-form-label">
                                    {{ trans('admin.description_in') . trans('lang.' .
                                    Locale::getDisplayName($locale)) }}
                                </label>
                                <div class="mb-2 col-sm-12">
                                    <textarea id="description{{ $key }}" name="{{ $locale }}[description]" class="m-auto form-control {{ (empty($errors->first($locale . '.description'))) ?: 'has-error'  }}" style="margin-top: 10px"> {{ old($locale . '.description') }} </textarea>
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
            <div class="mt-4 mb-4 accordion" id="accordionExampleMeta">
                <div class="border rounded accordion-item">
                    <h2 class="accordion-header" id="headingMeta{{ $key }}">
                        <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseMeta{{ $key }}" aria-expanded="true" aria-controls="collapseTwo{{ $key }}">
                            @lang('admin.meta')
                        </button>
                    </h2>
                    <div id="collapseMeta{{ $key }}" class="mt-3 accordion-collapse collapse" aria-labelledby="headingMeta{{ $key }}" data-bs-parent="#accordionExampleMeta">
                        <div class="accordion-body">

                            @foreach ($languages as $key => $locale)
                            {{-- meta_title_ ------------------------------------------------------------------------------------- --}}
                            <div class="mb-3 row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">
                                    {{ trans('admin.meta_title_in') . trans('lang.' . Locale::getDisplayName($locale)) }}</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" name="{{ $locale }}[meta_title]" value="{{ old($locale . '.meta_title') }}" id="title{{ $key }}">
                                </div>
                                @if ($errors->has($locale . '.meta_title'))
                                <span class="missiong-spam">{{ $errors->first($locale . '.meta_title') }}</span>
                                @endif
                            </div>

                            {{-- meta_description_   ------------------------------------------------------------------------------------- --}}
                            <div class="mb-3 row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">
                                    {{ trans('admin.meta_description_in') . trans('lang.' .  Locale::getDisplayName($locale)) }}
                                </label>
                                <div class="mb-2 col-sm-10">
                                    <textarea name="{{ $locale }}[meta_description]" class="form-control description"> {{ old($locale . '.meta_description') }} </textarea>
                                    @if ($errors->has($locale . '.meta_description'))
                                    <span class="missiong-spam">{{ $errors->first($locale . '.meta_description')
                                        }}</span>
                                    @endif
                                </div>
                            </div>

                            {{-- meta_key_  ------------------------------------------------------------------------------------- --}}
                            <div class="mb-3 row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">
                                    {{ trans('admin.meta_key_in') . trans('lang.' . Locale::getDisplayName($locale)) }}
                                </label>
                                <div class="mb-2 col-sm-10">
                                    <textarea name="{{ $locale }}[meta_key]" class="form-control description"> {{ old($locale . '.meta_key') }} </textarea>
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
        <div class="col-md-4">
            @livewire('admin.charity.form.info')
            {{-- ------------images------------------------------------------------------------------- --}}
            <div class="mt-4 mb-4 accordion" id="accordionExampleImages">
                <div class="border rounded accordion-item">
                    <h2 class="accordion-header" id="headingImages">
                        <button class="accordion-button fw-medium collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#images_project" aria-expanded="true" aria-controls="images_project">
                            {{ trans('charityProject.images_project') }}
                        </button>
                    </h2>
                    <div id="images_project" class="accordion-collapse collapse" aria-labelledby="headingImages" data-bs-parent="#accordionExampleImages">
                        <div class="accordion-body">

                            <div class="col-12">
                                <div class="">
                                    <label class="control-label" for="imageUpload">@lang('admin.images') </label>
                                    <div class="glr-group row">
                                        <input id="galery" readonly name="images" class="form-control" type="text" value="{{ old('images') }}">
                                        <a data-toggle="modal" href="javascript:;" data-bs-toggle="modal" data-bs-target="#exampleModal" class="mt-2 ml-3 btn btn-primary waves-effect waves-light btn-sm" type="button">@lang('admin.choose')</a>
                                    </div>
                                    <!-- /.modal -->
                                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-xl">
                                            <div class="modal-content">

                                                <div class="pt-0 mt-0 card-body">
                                                    <iframe width="100%" height="500" src="{{ asset('backend/filemanager/dialog.php') }}?type=2&field_id=galery&relative_url=1" frameborder="0" style="overflow: scroll; overflow-x: hidden; overflow-y: scroll; "></iframe>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.modal -->
                                </div>
                            </div>
                            {{-- cover image    ------------------------------------------------------------------------------------- --}}
                            <div class="col-12">
                                <div class="mb-3 row">
                                    <label for="example-number-input" class="col-sm-12 col-form-label">
                                        @lang('charityProject.cover_image') </label>
                                    <div class="col-sm-12">
                                        <input class="form-control {{ (empty($errors->first('cover_image'))) ?: 'has-error'}}" type="file" placeholder="@lang('admin.cover_image')" id="example-number-input" name="cover_image" value="{{ old('cover_image') }}">
                                    </div>
                                </div>
                            </div>
                            {{-- background_image-------------------------------------------------------------------------------------   --}}
                            <div class="col-12">
                                <div class="mb-3 row">
                                    <label for="example-number-input" class="col-sm-12 col-form-label">
                                        @lang('charityProject.background_image') </label>
                                    <div class="col-sm-12">
                                        <input class="form-control {{ (empty($errors->first('background_image'))) ?: 'has-error'}}" type="file" placeholder="@lang('admin.background_image')" id="example-number-input" name="background_image" value="{{ old('background_image') }}">
                                    </div>
                                </div>
                            </div>
                            {{-- background_color------------------------------------------------------------------------------------- --}}
                            <div class="col-12">
                                <div class="mb-3 row">
                                    <label for="example-number-input" col-form-label>
                                        @lang('charityProject.background_color') </label>
                                    <input type="text" name="background_color" value="{{ old('background_color') }}" placeholder="#FFFFFF" class="form-control spectrum with-add-on colorpicker-showinput-intial" id="colorpicker-showinput-intial">
                                </div>
                                @if ($errors->has('background_color'))
                                <span class="missiong-spam">{{ $errors->first('background_color') }}</span>
                                @endif
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
