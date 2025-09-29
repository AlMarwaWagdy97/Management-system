@extends('site.app')

@section('title', __('Vendor Dashboard'))


@section('content')

<div class="profile">
    <div class="container bg-light mt-5 border-main">
        <div class="row gx-2">

            <x-site.vendors.side-menu />

            <!--index section -->
            <div class="col-12 order-lg-2 order-2 col-lg-9 mx-auto">
                        <div class="card mt-4">
                            <div class="card-body">
                                <div class="col-md-7 text-center text-md-end col-12 mt-3">
                                    <h1 class="fs-4"> @lang('Add a product') </h1>
                                </div>
                                <form action="{{ route('site.vendors.products.store') }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12">
                                            @foreach ($languages as $key => $locale)
                                            <div class="accordion mt-4 mb-4" id="accordionExample">
                                                <div class="accordion-item border rounded">
                                                    <h2 class="accordion-header" id="headingOne{{ $key }}">
                                                        <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne{{ $key }}" aria-expanded="true" aria-controls="collapseOne{{ $key }}">
                                                            {{ trans('lang.' . Locale::getDisplayName($locale)) }}
                                                        </button>
                                                    </h2>
                                                    <div id="collapseOne{{ $key }}" class="accordion-collapse collapse show mt-3" aria-labelledby="headingOne{{ $key }}" data-bs-parent="#accordionExample">
                                                        <div class="accordion-body">
                                                            {{-- title ------------------------------------------------------------------------------------- --}}
                                                            <div class="row mb-3">
                                                                <label for="example-text-input" class="col-sm-2 col-form-label">{{ trans('admin.title_in') . trans('lang.' . Locale::getDisplayName($locale)) }}</label>
                                                                <div class="col-sm-10">
                                                                    <input class="form-control" type="text" name="{{ $locale }}[title]" value="{{ old($locale . '.title') }}" id="title{{ $key }}" required />
                                                                </div>
                                                                @if ($errors->has($locale . '.title'))
                                                                <span class="missiong-spam">{{ $errors->first($locale . '.title') }}</span>
                                                                @endif
                                                            </div>
                                                            {{-- Start Slug --}}
                                                            <div class="row mb-3 slug-section">
                                                                <label for="example-text-input" class="col-sm-2 col-form-label">{{ trans('admin.slug_in') . trans('lang.' . Locale::getDisplayName($locale)) }}
                                                                </label>
                                                                <div class="col-sm-10">
                                                                    <input type="text" id="slug{{ $key }}" name="{{ $locale }}[slug]" value="{{ old($locale . '.slug') }}" class="form-control slug">
                                                                    @if ($errors->has($locale . '.slug'))
                                                                    <span class="missiong-spam">{{ $errors->first($locale . '.slug') }}</span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            {{-- @include('admin.layouts.scriptSlug') --}}
                                                            {{-- End Slug --}}


                                                            {{-- description ------------------------------------------------------------------------------------- --}}
                                                            <div class="row mb-3">
                                                                <label for="example-text-input" class="col-sm-2 col-form-label"> @lang('admin.description_in')
                                                                    {{ trans('lang.' . Locale::getDisplayName($locale)) }}
                                                                </label>
                                                                <div class="col-sm-10 mb-2">
                                                                    <textarea id="description{{ $key }}"  class="form-control" name="{{ $locale }}[description]" rows="5"> {{  old($locale . '.description') }} </textarea>
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
                                        </div>


                                        <div class="col-md-12">
                                            {{-- ------ Start Post Settings------ --}}
                                            <div class="accordion mt-4 mb-4" id="accordionExample">
                                                <div class="accordion-item border rounded">
                                                    <h2 class="accordion-header" id="headingOne">
                                                        <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                            {{ trans('products.settings') }}
                                                        </button>
                                                    </h2>
                                                    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                                        <div class="accordion-body">
                                                            <div class="row">
                                                                <div class="col-6">
                                                                    {{-- category ------------------------------------------------------------------------------------- --}}
                                                                    <div class="row mb-3 title-section">
                                                                        <label for="example-text-input" class="col-sm-12 col-form-label">@lang('charityProject.category')</label>
                                                                        <div class="col-sm-12">
                                                                            <select class="form-select form-select-sm" name="category_id" aria-label=".form-select-sm example" required>
                                                                                <option value="">@lang('charityProject.choose_category')</option>
                                                                                @foreach ($category as $item)
                                                                                <option value="{{ $item->id }}" {{  $item->id == old('category_id')? 'selected' : ''  }}> {{ $item->trans->where('locale', $current_lang)->first()->title }} </option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-6">
                                                                    {{-- price ------------------------------------------------------------------------------------- --}}
                                                                    <div class="col-12">
                                                                        <div class="row mb-3">
                                                                            <label for="example-number-input" col-form-label> @lang('products.price')</label>
                                                                            <div class="col-sm-12">
                                                                                <input class="form-control" type="number" step="any" id="example-number-input" name="vendor_price" value="{{ old('vendor_price') }}" required>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    {{-- sort ------------------------------------------------------------------------------------- --}}
                                                                    <div class="col-12">
                                                                        <div class="row mb-3">
                                                                            <label for="example-number-input" col-form-label>
                                                                                @lang('articles.sort')</label>
                                                                            <div class="col-sm-12">
                                                                                <input class="form-control" type="number" id="example-number-input" name="sort" value="{{ old('sort') }}">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>


                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- ------ End Post Settings------ --}}
                                            {{-- ------------images--------------- --}}
                                            <div class="accordion mt-4 mb-4" id="accordionExample">
                                                <div class="accordion-item border rounded">
                                                    <h2 class="accordion-header" id="headingOne">
                                                        <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#images_project" aria-expanded="true" aria-controls="images_project">
                                                            {{ trans('charityProject.images_project') }}
                                                        </button>
                                                    </h2>
                                                    <div id="images_project" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                                        <div class="accordion-body">

                                                            {{-- images ------------------------------------------------------------------------------------- --}}
                                                            <div class="col-12">
                                                                <div class="">
                                                                    <label class="control-label" for="imageUpload">@lang('admin.image')
                                                                        : </label>
                                                                    <div class="glr-group row">
                                                                        <input id="galery" readonly name="image" class="form-control" type="text" value="{{ old('images') }}">
                                                                        <a data-toggle="modal" href="javascript:;" data-bs-toggle="modal" data-bs-target="#exampleModal" class="btn btn-info text-white ml-3 btn-sm mt-1" type="button">@lang('products.select_images')</a>
                                                                    </div>
                                                                    <!-- /.modal -->
                                                                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                        <div class="modal-dialog modal-xl">
                                                                            <div class="modal-content">
                                                                                <div class="card-body mt-0 pt-0">
                                                                                    <iframe width="100%" height="500" src="{{ asset('backend/filemanager/dialog.php') }}?type=2&field_id=galery&relative_url=1" frameborder="0" style="overflow: scroll; overflow-x: hidden; overflow-y: scroll; "></iframe>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- /.modal -->
                                                                </div>
                                                            </div>
                                                            {{-- cover image ------------------------------------------------------------------------------------- --}}
                                                            <div class="col-12">
                                                                <div class="row mb-3">
                                                                    <label for="example-number-input" class="col-sm-12 col-form-label">
                                                                        @lang('charityProject.cover_image') : </label>
                                                                    <div class="col-sm-12">
                                                                        <input class="form-control" type="file" placeholder="@lang('admin.cover_image')" id="example-number-input" name="cover_image" value="{{ old('cover_image') }}">
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
                                                <button type="submit" class="btn btn-success waves-effect waves-light ml-3 btn-sm">@lang('button.save')</button>
                                                <button type="submit" name="submit" value="new" id="submit" class="btn btn-success waves-effect waves-light btn-sm">@lang('button.save_new')</button>
                                            </div>
                                        </div>

                                    </div>


                                </form>

                            </div>
                </div> <!-- end row-->
            </div>
            <!--index section -->

        </div>
    </div>
</div>


@endsection