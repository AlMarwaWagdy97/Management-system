@extends('admin.app')

@section('title', trans('themes.site_theme'))
@section('title_page', trans('themes.site_theme'))

@section('content')

    <div class="container-fluid">

        @php
            $site_theme = get_site_themes();
        @endphp

        <div class="row">
            <div class="row">
                <div class="col-12 m-3">
                    <div class="card">
                        <div class="card-body">

                            <div class="row">
                                <div class="col-md-12 text-end">
                                    <form action="{{ route('admin.themes.reset') }}" method="post">
                                        @csrf
                                        <input type="hidden" name="key" value="site">
                                        <button class="btn btn-danger"> @lang('themes.reset_all_data')</button>
                                    </form>
                                </div>
                            </div>
                            <form action="{{ route('admin.themes.update') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="accordion mt-4 mb-4" id="accordionExample">
                                            <div class="accordion-item border rounded">
                                                <h2 class="accordion-header" id="headingTow">
                                                    <button class="accordion-button fw-medium" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#collapseTwo"
                                                        aria-expanded="true" aria-controls="collapseTwo">
                                                        {{ trans('themes.site_theme') }}
                                                    </button>
                                                </h2>
                                                <div id="collapseTwo" class="accordion-collapse collapse show"
                                                    aria-labelledby="headingTow" data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">

                                                        {{-- color ------------------------------------------------------------------------------------- --}}
                                                        <div class="row mt-3">
                                                            <div class="col-sm-3 col-md-3 mb-3">
                                                                <label for="example-number-input" col-form-label>
                                                                    @lang('themes.top_navbar_background')</label>
                                                                <input type="text" name="site[top_navbar_background]"
                                                                    value="{{ @$site_theme->top_navbar_background }}"
                                                                    placeholder="#FFFFFF"
                                                                    class="form-control spectrum with-add-on colorpicker-showinput-intial"
                                                                    id="colorpicker-showinput-intial">
                                                            </div>

                                                            <div class="col-sm-3 col-md-3">
                                                                <label for="example-number-input"
                                                                    col-form-label>@lang('themes.top_navbar_font_color') :</label>
                                                                <input type="text" name="site[top_navbar_font_color]"
                                                                    value="{{ @$site_theme->top_navbar_font_color }}"
                                                                    placeholder="#212529"
                                                                    class="form-control spectrum with-add-on colorpicker-showinput-intial"
                                                                    id="colorpicker-showinput-intial">
                                                            </div>

                                                            <div class="col-sm-3 col-md-3 mb-3">
                                                                <label for="example-number-input" col-form-label>
                                                                    @lang('themes.navbar_background_color')</label>
                                                                <input type="text" name="site[navbar_background]"
                                                                    value="{{ @$site_theme->navbar_background }}"
                                                                    placeholder="#FFFFFF"
                                                                    class="form-control spectrum with-add-on colorpicker-showinput-intial"
                                                                    id="colorpicker-showinput-intial">
                                                            </div>

                                                            <div class="col-sm-3 col-md-3">
                                                                <label for="example-number-input"
                                                                    col-form-label>@lang('themes.navbar_font_color') :</label>
                                                                <input type="text" name="site[navbar_color]"
                                                                    value="{{ @$site_theme->navbar_color }}"
                                                                    placeholder="#212529"
                                                                    class="form-control spectrum with-add-on colorpicker-showinput-intial"
                                                                    id="colorpicker-showinput-intial">
                                                            </div>

                                                            <div class="col-sm-3 col-md-3">
                                                                <label for="example-number-input" col-form-label>
                                                                    @lang('themes.button_color_background') :</label>
                                                                <input type="text" name="site[button_color_background]"
                                                                    value="{{ @$site_theme->button_color_background }}"
                                                                    placeholder="#263238"
                                                                    class="form-control spectrum with-add-on colorpicker-showinput-intial"
                                                                    id="colorpicker-showinput-intial">
                                                            </div>

                                                            <div class="col-sm-3 col-md-3">
                                                                <label for="example-number-input" col-form-label>
                                                                    @lang('themes.button_color_font') :</label>
                                                                <input type="text" name="site[button_color_font]"
                                                                    value="{{ @$site_theme->button_color_font }}"
                                                                    placeholder="#263238"
                                                                    class="form-control spectrum with-add-on colorpicker-showinput-intial"
                                                                    id="colorpicker-showinput-intial">
                                                            </div>

                                                            <div class="col-sm-3 col-md-3">
                                                                <label for="example-number-input" col-form-label>
                                                                    @lang('themes.box_color_background') :</label>
                                                                <input type="text" name="site[box_color_background]"
                                                                    value="{{ @$site_theme->box_color_background }}"
                                                                    placeholder="#FFFFFF"
                                                                    class="form-control spectrum with-add-on colorpicker-showinput-intial"
                                                                    id="colorpicker-showinput-intial">
                                                            </div>

                                                            <div class="col-sm-3 col-md-3">
                                                                <label for="example-number-input" col-form-label>
                                                                    @lang('themes.box_color_font') :</label>
                                                                <input type="text" name="site[box_color_font]"
                                                                    value="{{ @$site_theme->box_color_font }}"
                                                                    placeholder="#FFFFFF"
                                                                    class="form-control spectrum with-add-on colorpicker-showinput-intial"
                                                                    id="colorpicker-showinput-intial">
                                                            </div>
                                                            <div class="col-sm-3 col-md-3">
                                                                <label for="example-number-input" col-form-label>
                                                                    @lang('themes.box_color_background_hover') :</label>
                                                                <input type="text"
                                                                    name="site[box_color_background_hover]"
                                                                    value="{{ @$site_theme->box_color_background_hover }}"
                                                                    placeholder="#FFFFFF"
                                                                    class="form-control spectrum with-add-on colorpicker-showinput-intial"
                                                                    id="colorpicker-showinput-intial">
                                                            </div>

                                                            <div class="col-sm-3 col-md-3">
                                                                <label for="example-number-input" col-form-label>
                                                                    @lang('themes.box_color_font_hover') :</label>
                                                                <input type="text" name="site[box_color_font_hover]"
                                                                    value="{{ @$site_theme->box_color_font_hover }}"
                                                                    placeholder="#FFFFFF"
                                                                    class="form-control spectrum with-add-on colorpicker-showinput-intial"
                                                                    id="colorpicker-showinput-intial">
                                                            </div>
                                                            <div class="col-sm-3 col-md-3">
                                                                <label for="example-number-input" col-form-label>
                                                                    @lang('themes.footer_background_color') :</label>
                                                                <input type="text" name="site[footer_background_color]"
                                                                    value="{{ @$site_theme->footer_background_color }}"
                                                                    placeholder="#255d82"
                                                                    class="form-control spectrum with-add-on colorpicker-showinput-intial"
                                                                    id="colorpicker-showinput-intial">
                                                            </div>
                                                            <div class="col-sm-3 col-md-3">
                                                                <label for="example-number-input" col-form-label>
                                                                    @lang('themes.footer_font_color') :</label>
                                                                <input type="text" name="site[footer_font_color]"
                                                                    value="{{ @$site_theme->footer_font_color }}"
                                                                    placeholder="#FFFFFF"
                                                                    class="form-control spectrum with-add-on colorpicker-showinput-intial"
                                                                    id="colorpicker-showinput-intial">
                                                            </div>
                                                        </div>
                                                        {{-- End color ----------------------------------------------------------------------------------------------- --}}


                                                        {{-- login logo image ----------------------------------------------------------------------------------------- --}}
                                                        <div class="row mt-3">

                                                            <div class="col-sm-3 col-md-3">
                                                                <label for="example-number-input" col-form-label>
                                                                    @lang('themes.home_image') :</label>
                                                                <input type="hidden" name="site[home_image]"
                                                                    value="{{ @$site_theme->home_image }}">
                                                                <input class="form-control" type="file"
                                                                    name="site[home_image]"
                                                                    value="{{ @$site_theme->home_image }}">
                                                            </div>

                                                            <div class="col-sm-3 col-md-3">
                                                                <label for="example-number-input" col-form-label>
                                                                    @lang('themes.footer_image') :</label>
                                                                <input type="hidden" name="site[footer_image]"
                                                                    value="{{ @$site_theme->footer_image }}">
                                                                <input class="form-control" type="file"
                                                                    name="site[footer_image]"
                                                                    value="{{ @$site_theme->footer_image }}">
                                                            </div>

                                                            <div class="col-sm-3 col-md-3">
                                                                <label for="example-number-input" col-form-label>
                                                                    @lang('themes.prevue_image') :</label>
                                                                <input type="hidden" name="site[prevue_image]"
                                                                    value="{{ @$site_theme->prevue_image }}">
                                                                <input class="form-control" type="file"
                                                                    name="site[prevue_image]"
                                                                    value="{{ @$site_theme->prevue_image }}">
                                                            </div>
                                                        </div>
                                                        {{-- End login logo image ------------------------------------------------------------------------------------- --}}

                                                        {{-- login background image ----------------------------------------------------------------------------------- --}}

                                                        <div class="row mt-3">


                                                            <div class="col-sm-4 col-md-4 ">
                                                                <a href="{{ asset(@$site_theme->home_image) }}"
                                                                    target="_blank">
                                                                    <img src="{{ asset(@$site_theme->home_image) }}"
                                                                        alt="" width="25%">
                                                                </a>
                                                            </div>

                                                            <div class="col-sm-4 col-md-4">
                                                                <a href="{{ asset(@$site_theme->footer_image) }}"
                                                                    target="_blank">
                                                                    <img src="{{ asset(@$site_theme->footer_image) }}"
                                                                        alt="" width="25%">
                                                                </a>
                                                            </div>
                                                            <div class="col-sm-4 col-md-4">
                                                                <a href="{{ asset(@$site_theme->prevue_image) }}"
                                                                    target="_blank">
                                                                    <img src="{{ asset(@$site_theme->prevue_image) }}"
                                                                        alt="" width="25%">
                                                                </a>
                                                            </div>
                                                        </div>
                                                        {{-- End login background image -------------------------------------------------------------------------------- --}}


                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Butoooons ------------------------------------------------------------------------- --}}
                                <div class="row mb-3 text-end">
                                    <div>
                                        <a href="{{ route('admin.home') }}"
                                            class="btn btn-outline-danger waves-effect waves-light ml-3">@lang('button.cancel')</a>
                                        <button type="submit"
                                            class="btn btn-outline-success waves-effect waves-light ml-3">@lang('button.save')</button>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div> <!-- end col -->
            </div>
        </div> <!-- end row-->

    </div> <!-- container-fluid -->

@endsection


@section('style')
@endsection
