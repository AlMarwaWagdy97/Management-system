@extends('admin.app')

@section('title', trans('slider.slider_edit'))
@section('title_page', trans('slider.sliders'))
@section('title_route', route('admin.slider.index'))
@section('button_page')
    <a href="{{ route('admin.slider.index') }}"
        class="btn btn-primary waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
@endsection


@section('content')
    <div class="card">
        <div class="card-body">

            <form action="{{ route('admin.slider.update', $slider->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('put')
                <div class="row">
                    <div class="col-md-9">
                        @foreach ($languages as $key => $locale)
                            <div class="accordion mt-4 mb-4" id="accordionExampleTitle{{ $key }}">
                                <div class="accordion-item border rounded">
                                    <h2 class="accordion-header" id="headiTitle{{ $key }}">
                                        <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseTitle{{ $key }}" aria-expanded="true"
                                            aria-controls="collapseTitle{{ $key }}">
                                            {{ trans('lang.' . Locale::getDisplayName($locale)) }}

                                        </button>
                                    </h2>
                                    <div id="collapseTitle{{ $key }}" class="accordion-collapse collapse show mt-3"
                                        aria-labelledby="headingTitle{{ $key }}"
                                        data-bs-parent="#accordionExampleTitle{{ $key }}">
                                        <div class="accordion-body">
                                            {{-- title ------------------------------------------------------------------------------------- --}}
                                            <div class="row mb-3">
                                                <label for="example-text-input"
                                                    class="col-sm-2 col-form-label">{{ trans('admin.title_in') . trans('lang.' . Locale::getDisplayName($locale)) }}</label>
                                                <div class="col-sm-10">
                                                    <input class="form-control" type="text"
                                                        name="{{ $locale }}[title]"
                                                        value="{{ @$slider->trans->where('locale', $locale)->first()->title }}"
                                                        id="title{{ $key }}">
                                                </div>
                                                @if ($errors->has($locale . '.title'))
                                                    <span
                                                        class="missiong-spam">{{ $errors->first($locale . '.title') }}</span>
                                                @endif
                                            </div>
                                            {{-- description ------------------------------------------------------------------------------------- --}}
                                            <div class="row mb-3">
                                                <label for="example-text-input"
                                                    class="col-sm-2 col-form-label">{{ trans('admin.description_in') . trans('lang.' . Locale::getDisplayName($locale)) }}
                                                </label>
                                                <div class="col-sm-10 mb-2">
                                                    <textarea id="description{{ $key }}" name="{{ $locale }}[description]" class="form-control"
                                                        rows="4"> {{ @$slider->trans->where('locale', $locale)->first()->description }} </textarea>
                                                    @if ($errors->has($locale . '.description'))
                                                        <span
                                                            class="missiong-spam">{{ $errors->first($locale . '.description') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>


                    <div class="col-md-3">
                        <div class="accordion mt-4 mb-4" id="accordionExampleSetting">
                            <div class="accordion-item border rounded">
                                <h2 class="accordion-header" id="headingSetting">
                                    <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseSetting" aria-expanded="true"
                                        aria-controls="collapseSetting">
                                        {{ trans('admin.settings') }}
                                    </button>
                                </h2>
                                <div id="collapseSetting" class="accordion-collapse collapse show"
                                    aria-labelledby="headingOne" data-bs-parent="#accordionExampleSetting">
                                    <div class="accordion-body">
                                        {{-- image ------------------------------------------------------------------------------------- --}}
                                        <a href="{{ getImage($slider->image) }}" target="_blank">
                                            <img src="{{ getImage($slider->image) }}" alt="" style="width:100%">
                                        </a>
                                        <div class="col-12">
                                            <div class="row mb-3">
                                                <label for="example-number-input" col-form-label>
                                                    @lang('admin.image')</label>
                                                <div class="col-sm-12">
                                                    <input class="form-control" type="file" accept="image/*"
                                                        id="example-number-input" name="image"
                                                        value="{{ old('image') }}">
                                                    <small class="text-danger">المقاس المطلوب: <strong>990px ×
                                                            391px</strong> بكسل</small>
                                                    @error('image')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        {{-- mobile_image ------------------------------------------------------------------------------------- --}}
                                        <a href="{{ getImage($slider->mobile_image) }}" target="_blank">
                                            <img src="{{ getImage($slider->mobile_image) }}" alt=""
                                                style="width:100%">
                                        </a>
                                        <div class="col-12">
                                            <div class="row mb-3">
                                                <label for="example-number-input" col-form-label>
                                                    @lang('admin.mobile_image')</label>
                                                <div class="col-sm-12">
                                                    <input class="form-control" type="file" accept="image/*" id="example-number-input"
                                                        name="mobile_image" 
                                                        value="{{ old('mobile_image') }}">
                                                    <small class="text-danger">المقاس المطلوب: <strong>990px ×
                                                            391px</strong> بكسل</small>
                                                    @error('mobile_image')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        {{-- URL ------------------------------------------------------------------------------------- --}}
                                        <div class="col-12">
                                            <div class="row mb-3">
                                                <label for="example-number-input" col-form-label>
                                                    @lang('slider.url')</label>
                                                <div class="col-sm-12">
                                                    <input class="form-control" type="text" id="example-number-input"
                                                        name="url"
                                                        value="{{ $slider->url == 'javascript:void(0)' ? '' : $slider->url }}">
                                                </div>
                                            </div>
                                        </div>
                                        {{-- sort ------------------------------------------------------------------------------------- --}}
                                        <div class="col-12">
                                            <div class="row mb-3">
                                                <label for="example-number-input" col-form-label>
                                                    @lang('slider.sort')</label>
                                                <div class="col-sm-12">
                                                    <input class="form-control" type="number" id="example-number-input"
                                                        name="sort" value="{{ $slider->sort }}">
                                                </div>
                                            </div>
                                        </div>
                                        {{-- Status ------------------------------------------------------------------------------------- --}}
                                        <div class="col-12">
                                            <div class="col-sm-10">
                                                <div class="form-check form-switch form-check-success">
                                                    <label class="form-check-label"
                                                        for="flexSwitchCheckSuccessStatus">@lang('admin.status')</label>
                                                    <input class="form-check-input" type="checkbox" role="switch"
                                                        name="status" {{ $slider->status == 1 ? 'checked' : '' }}
                                                        id="flexSwitchCheckSuccessStatus">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="row mb-3 text-end">
                        <div>
                            <a href="{{ route('admin.slider.index') }}"
                                class="btn btn-primary waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
                            <button type="submit"
                                class="btn btn-outline-success waves-effect waves-light ml-3 btn-sm">@lang('button.save')</button>
                            <button type="submit" name="submit" value="update"
                                class="btn btn-outline-success waves-effect waves-light  btn-sm">@lang('button.save_update')</button>
                        </div>
                    </div>
                </div>

            </form>

        </div>
    </div>

@endsection


@push('scripts')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="{{ asset('site/js/ckeditor/ckeditor.js') }}"></script>

    <script>
        $(document).ready(function() {
            $("#name_ar").on('keyup', function() {
                var Text = $(this).val();
                Text = Text.toLowerCase();
                Text = Text.replace(/[^a-zA-Z0-9ء-ي]+/g, '-');
                $("#slug_ar").val(Text);
            });


            $("#name_en").on('keyup', function() {
                var Text = $(this).val();
                Text = Text.toLowerCase();
                Text = Text.replace(/[^a-zA-Z0-9ء-ي]+/g, '-');
                $("#slug_en").val(Text);
            });
        });
    </script>
     <script>
  document.querySelectorAll('input[type=file][name="image"], input[type=file][name="mobile_image"]')
    .forEach(input => {
      input.addEventListener('change', () => {
        const file = input.files[0];
        if (!file) return;
        const img = new Image();
        img.onload = () => {
          if (img.width !== 990 || img.height !== 391) {
            alert('يجب أن تكون الصورة بمقاس 990×391 بكسل.');
            input.value = ''; 
          }
        };
        img.src = URL.createObjectURL(file);
      });
    });
</script>

@endpush