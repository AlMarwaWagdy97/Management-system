@extends('admin.app')

@section('title', trans('project.create'))
@section('title_page', trans('project.project'))
@section('title_route', route('admin.projects.index') )
@section('button_page')
<a href="{{ route('admin.projects.index') }}" class="btn btn-outline-primary waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
@endsection

@section('content')

<div class="card">
    <div class="card-body">

        <form action="{{ route('admin.projects.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-8">
                    <div class="accordion mt-4 mb-4" id="accordionExample">
                        <div class="accordion-item border rounded">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    {{ trans('admin.title') }}
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse show mt-3" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                <div class="accordion-body">

                                    @foreach ($languages as $key => $locale)
                                    {{-- title ------------------------------------------------------------------------------------- --}}
                                    <div class="row mb-3">
                                        <label for="example-text-input" class="col-sm-2 col-form-label">{{ trans('admin.title_in') .  trans('lang.' .Locale::getDisplayName($locale)) }}</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" type="text" name="{{ $locale }}[title]" value="{{ old($locale . '.title') }}">
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

                    {{-- images Gellary  --}}
                    <div class="accordion mt-4 mb-4" id="accordionExample">
                        <div class="accordion-item border rounded">
                            <h2 class="accordion-header" id="headingImage">
                                <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseImage" aria-expanded="true" aria-controls="collapseOne">
                                    @lang('admin.gallerys')
                                </button>
                            </h2>
                            <div id="collapseImage" class="accordion-collapse collapse show mt-3" aria-labelledby="headingImage" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <div class="row mb-3">
                                        <input name="gallery[][img]" id="image-uploadify" type="file" accept=".xlsx,.xls,image/*,.doc,audio/*,.docx,video/*,.ppt,.pptx,.txt,.pdf" multiple>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-md-4">
                    <div class="accordion mt-4 mb-4" id="accordionExample1">
                        <div class="accordion-item border rounded">
                            <h2 class="accordion-header" id="headingtwo">
                                <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                                    {{ trans('admin.settings') }}
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse show" aria-labelledby="headingtwo" data-bs-parent="#accordionExample1">
                                <div class="accordion-body">
                                    {{-- image ------------------------------------------------------------------------------------- --}}
                                    <div class="col-12">
                                        <div class="row mb-3">
                                            <label for="example-number-input" class="col-form-label">
                                                @lang('admin.image')</label>
                                            <div class="col-sm-12">
                                                <input  type="file" name="image" class="form-control" required >
                                            </div>
                                        </div>
                                    </div>
                                    {{-- portfolio  ------------------------------------------------------------------------------- --}}
                                    <div class="col-12">
                                        <div class="row mb-3">
                                            <label for="example-number-input"> @lang('project.portfolio')</label>
                                            <div class="col-sm-12">
                                                <select class="form-select form-select-sm select2" name="portfolio_id">
                                                    <option value="" selected disabled> {{ trans('admin.please_select') }}</option>
                                                    @foreach ($portfolios as $portfolio)
                                                    <option value="{{ $portfolio->id }}" {{ old('portfolio_id') == $portfolio->id ? 'selected' : '' }}> {{ @$portfolio->trans->where('locale', $current_lang)->first()->title }} </option>
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
                                            <label for="example-number-input" col-form-label>
                                                @lang('admin.sort')</label>
                                            <div class="col-sm-12">
                                                <input class="form-control" type="number" id="example-number-input" name="sort" value="{{ old('sort') }}">
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Status ------------------------------------------------------------------------------------- --}}
                                    <div class="col-12">
                                        <div class="form-check form-switch form-check-success">
                                            <label class="form-check-label" for="flexSwitchCheckSuccessStatus">@lang('admin.status')</label>
                                            <input class="form-check-input" type="checkbox" role="switch" name="status" {{  request('status') == 1 ? 'checked' : '' }} id="flexSwitchCheckSuccessStatus">
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
                        <a href="{{ route('admin.projects.index') }}" class="btn btn-outline-primary waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
                        <button type="submit m-3" class="btn btn-outline-success waves-effect waves-light ml-3 btn-sm">@lang('button.save')</button>
                        <button type="submit" name="submit" value="new" id="submit" class="btn btn-outline-success waves-effect waves-light btn-sm">@lang('button.save_new')</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection


@section('style')
    @vite(['resources/assets/admin/file-upload-script.css'])
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>    
    <script src="{{ asset('site/js/ckeditor/ckeditor.js') }}"></script>
@endsection

@section('script')
    @vite(['resources/assets/admin/file-upload-script.js'])
    <script>
        $(document).ready(function() {
            $('#fancy-file-upload').FancyFileUpload({
                params: {
                    action: 'fileuploader'
                }
                , maxfilesize: 1000000
            });


            $('#image-uploadify').imageuploadify();
        });


        $(document).ready(function() {
            $('#add_images_section').on('click', function() {
                $('#images_section').append(
                    `
                        <div class="images ">
                            <div class="row">
                                <div class="col-12">
                                        <label for="example-number-input"  > @lang("admin.image")</label>
                                    <input type="file" name="gallery[][image]"   class="form-control" required>
                                </div>
                                <div class="col-6">
                                    <label for="example-number-input"  > @lang("admin.sort")</label>
                                    <input type="number" name="gallery[][sort]"  class="form-control"  >
                                </div>
                                <div class="col-12 mt-3">
                                    <button class="btn btn-danger delete_img form-control"><i class="bx bxs-trash"></i></button>
                                </div>
                            </div>
                            <hr>
                        </div>
                        `
                )

            });


            $('#images_section').on('click', '.delete_img', function(e) {
                $(this).parent().parent().parent().remove();
            })
        });

    </script>
@endsection
