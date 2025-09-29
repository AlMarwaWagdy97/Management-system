@extends('admin.app')

@section('title', trans('menus.show_menu'))
@section('title_page', trans('admin.menus'))
@section('title_route', route('admin.menus.index') )
@section('button_page')
<a href="{{ route('admin.menus.index') }}" class="btn btn-outline-primary waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
@endsection


@section('content')

<div class="row">
    <div class="col-12 m-3">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-9">
                        {{-- Start Input Name Arabic   --}}
                        @foreach ($languages as $key => $locale)
                        <div class="accordion mb-4" id="accordionExampleTitle{{ $key }}">
                            <div class="accordion-item border rounded">
                                <h2 class="accordion-header" id="headingTitle{{ $key }}">
                                    <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTitle{{ $key }}" aria-expanded="true" aria-controls="collapseTitle{{ $key }}">
                                        {{ trans('lang.' .Locale::getDisplayName($locale)) }}
                                    </button>
                                </h2>
                                <div id="collapseTitle{{ $key }}" class="accordion-collapse collapse show mt-3" aria-labelledby="headingTitle{{ $key }}" data-bs-parent="#accordionExampleTitle{{ $key }}">
                                    <div class="accordion-body">
                                        {{-- title ------------------------------------------------------------------------------------- --}}
                                        <div class="row mb-3">
                                            <label for="example-text-input" class="col-sm-2 col-form-label">{{ trans('admin.title_in') . trans('lang.' .Locale::getDisplayName($locale)) }}</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" type="text" name="{{ $locale }}[title]" disabled value="{{ $menu->trans->where('locale',$current_lang)->first()->title }}" id="name{{ $key }}">
                                            </div>

                                        </div>

                                        {{-- slug ------------------------------------------------------------------------------------- --}}
                                        <div class="row mb-3 slug-section">
                                            <label for="example-text-input" class="col-sm-2 col-form-label">{{ trans('admin.slug_in') . trans('lang.' .Locale::getDisplayName($locale)) }}</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="{{ $locale }}[slug]" value="{{ $menu->trans->where('locale',$current_lang)->first()->slug }}" id="slug{{ $key }}" disabled class="form-control slug" required>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="col-md-3">
                        <div class="card">
                            <div class="accordion" id="accordionExampleSetting">
                                <div class="accordion-item border rounded">
                                    <h2 class="accordion-header" id="headingSetting">
                                        <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSetting" aria-expanded="true" aria-controls="collapseSetting">
                                            {{ trans('menus.Settings') }}
                                        </button>
                                    </h2>
                                    <div id="collapseSetting" class="accordion-collapse collapse show" aria-labelledby="headingSetting" data-bs-parent="#accordionExampleSetting">
                                        <div class="accordion-body">
                                            <div class=" row mb-3">
                                                <label for="example-number-input">
                                                    @lang('menus.parent')</label>
                                                <div class="col-sm-12">
                                                    <p class="h2 text-primary ">{{ @$menu->parent ?@$menu->parent->title: "__"  }}</p>
                                                </div>
                                            </div>

                                            <div class="row mb-3 title-section">
                                                <label for="example-text-input" class="col-sm-6 col-form-label">{{ trans('menus.type') }}</label>
                                                <div class="col-sm-12">
                                                    <select class="form-select form-select-sm" disabled name="type" id="type" aria-label=".form-select-sm example">
                                                        <option selected>@lang('menus.type') </option>
                                                        @foreach (App\Enums\MunesEnum::values() as $ee)
                                                        <option {{ $ee == @$menu->type ? 'selected' : '' }}> {{ $ee }} </option>
                                                        @endforeach
                                                    </select>

                                                </div>
                                            </div>

                                            <div class="row mb-3 title-section" id="static-url" @if (@$menu->type != App\Enums\MunesEnum::STATIC) style="display: none;" @endif>
                                                <label for="example-text-input" class="col-sm-6 col-form-label">{{ trans('menus.url') }}</label>
                                                <div class="col-sm-12">
                                                    <input class="form-control" id="static_url" disabled type="text" name="url" value="{{ @$menu->url ?? old('url') }}">

                                                </div>
                                            </div>

                                            <div id="dynamic-url" @if (@$menu->type != App\Enums\MunesEnum::DYNAMIC) style="display: none;" @endif>
                                                <div class="row mb-3 title-section">
                                                    <label for="example-text-input" class="col-sm-6 col-form-label">{{ trans('menus.type_url') }}</label>
                                                    <div class="col-sm-12">
                                                        <select class="form-select form-select-sm" disabled id="dynamic-type" name="dynamic_table" aria-label=".form-select-sm example">
                                                            <option value=""> @lang('menus.select_url')
                                                            </option>
                                                            @foreach (App\Enums\UrlTypesEnum::values() as $enumTypes)
                                                            <option value="{{ $enumTypes }}" {{ $enumTypes == @$menu->dynamic_table ? 'selected' : '' }}>
                                                                {{ $enumTypes }}</option>
                                                            @endforeach
                                                        </select>

                                                    </div>
                                                </div>

                                                <div class="row mb-3 title-section">
                                                    <label for="example-text-input" class="col-sm-6 col-form-label">{{ trans('menus.url') }}</label>
                                                    <div class="col-sm-12">
                                                        <select class="form-select form-select-sm" disabled name="dynamic_url" id="get-dynamic-urls" aria-label=".form-select-sm example">
                                                            <option value="{{ @$menu->dynamic_url }}">
                                                                {{ @$menu->dynamic_url }}</option>
                                                        </select>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12">
                                                    <label class="col-sm-3 col-form-label" for="available">{{ trans('menus.status') }}</label>
                                                    <div class="col-sm-10">
                                                        @if($menu->status == 1 )
                                                        <p class="badge  bg-success h3" style="font-size:20px">@lang("admin.active")</p>
                                                        @else
                                                        <p class="badge  bg-danger h3" style="font-size:20px">@lang("admin.dis_active")</p>
                                                        @endif
                                                    </div>
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
                            <a href="{{ route('admin.menus.index') }}" class="btn btn-outline-primary waves-effect waves-light ml-3">@lang('button.cancel')</a>
                            <button type="submit" class="btn btn-outline-success waves-effect waves-light ml-3">@lang('button.save')</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div> <!-- end col -->
</div>

@endsection


@section('style')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="{{ asset('site/js/ckeditor/ckeditor.js') }}"></script>
@endsection
@section('script')



<script>
    $(document).ready(function() {
        $("#type").on('change', function() {
            var val = $(this).val();
            console.log(val, val == "static");
            if (val == "static") {
                $('#static-url').show();
                $('#dynamic-url').hide();

                $("#static_url").prop('required', true);
                $("#dynamic-type").prop('required', false);
                $("#get-dynamic-urls").prop('required', false);

            } else {
                $('#static-url').hide();
                $('#dynamic-url').show();
                $('#get-dynamic-urls').find('option').remove().end();

                $("#static_url").prop('required', false);
                $("#dynamic-type").prop('required', true);
                $("#get-dynamic-urls").prop('required', true);
            }
        });

        $("#dynamic-type").on('change', function() {
            let val = $(this).val();
            $.ajax({
                type: 'GET'
                , url: '/admin/menus/urls/' + val
                , success: function(data) {
                    $('#get-dynamic-urls').find('option').remove().end();
                    $("#get-dynamic-urls").append('<option value=""></option>');

                    $.each(data, function(key, value) {
                        $("#get-dynamic-urls").append('<option value="' + value + '">' + value + '</option>');
                    });
                }
            });
        });
    });

</script>

@endsection
