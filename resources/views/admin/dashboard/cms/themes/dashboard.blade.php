@extends('admin.app')

@section('title', trans('themes.dashboard_theme'))
@section('title_page', trans('themes.dashboard_theme'))

@section('content')

    <div class="container-fluid">

        @php 
            $loginTheme = get_login_dashboard_themes();
            $dashboardTheme = get_dashboard_themes();
        @endphp

        <div class="row">
            <div class="row">
                <div class="col-12 m-3">
                    <div class="card">
                        <div class="card-body">

                            <div class="row d-flex justify-content-end">
                                <div class="col-md-2  m-0 ">
                                    <form action="{{ route('admin.themes.reset') }}" method="post" >
                                        @csrf
                                        <input type="hidden" name="key" value="dashboard">
                                        <button class="btn btn-danger mt-3" onclick="return confirm('Are you sure?')"> @lang('themes.reset_all_data_dashboard')</button>
                                    </form>
                                </div>
                                <div class="col-md-2 m-0">
                                    <form action="{{ route('admin.themes.reset') }}" method="post">
                                        @csrf
                                        <input type="hidden" name="key" value="login_dashboard">
                                        <button class="btn btn-danger mt-3" onclick="return confirm('Are you sure?')"> @lang('themes.reset_all_data_login')</button>
                                    </form>
                                </div>
                            </div>


                            <form action="{{ route('admin.themes.update') }}" method="post" enctype="multipart/form-data">
                                @csrf

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="accordion mt-4 mb-4" id="accordionExample">
                                            <div class="accordion-item border rounded">
                                                <h2 class="accordion-header" id="headingOne">
                                                <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                    {{ trans('themes.login_dashboard_theme') }}
                                                </button>
                                                </h2>
                                                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">

                                                        {{-- color ------------------------------------------------------------------------------------- --}}
                                                        <div class="row mt-3">
                                                            <div class="col-sm-3 col-md-3">
                                                                <label for="example-number-input"  col-form-label> @lang('themes.login_box_color') :</label>
                                                                <input type="text" name="login_dashboard[box_color]" value="{{ @$loginTheme->box_color }}" placeholder="#FFFFFF" class="form-control spectrum with-add-on colorpicker-showinput-intial" id="colorpicker-showinput-intial" >
                                                            </div>
    
                                                            <div class="col-sm-3 col-md-3">
                                                                <label for="example-number-input"  col-form-label>@lang('themes.font_color') : </label>
                                                                <input type="text" name="login_dashboard[font_color]" value="{{ @$loginTheme->font_color }}" placeholder="#212529" class="form-control spectrum with-add-on colorpicker-showinput-intial" id="colorpicker-showinput-intial" >
                                                            </div>

                                                            <div class="col-sm-3 col-md-3">
                                                                <label for="example-number-input"  col-form-label>@lang('themes.button_color') : </label>
                                                                <input type="text" name="login_dashboard[button_color]" value="{{ @$loginTheme->button_color  }}" placeholder="#212529" class="form-control spectrum with-add-on colorpicker-showinput-intial" id="colorpicker-showinput-intial" >
                                                            </div>
                                                        </div>
                                                        {{-- End color ----------------------------------------------------------------------------------------------- --}}
                
                                                            
                                                        {{-- login logo image ----------------------------------------------------------------------------------------- --}}
                                                            <div class="row mt-3">
                                
                                                                <div class="col-sm-3 col-md-3">
                                                                    <label for="example-number-input"  col-form-label>@lang('themes.logo_image')</label>
                                                                    <input type="hidden" name="login_dashboard[logo_image]" value="{{ @$loginTheme->logo_image  }}" >
                                                                    <input class="form-control" type="file" name="login_dashboard[logo_image]" value="{{ @$loginTheme->logo_image }}"   id="example-number-input">
                                                                </div>
                                                               
                                                                <div class="col-sm-3 col-md-3">
                                                                    <label for="example-number-input"  col-form-label> @lang('themes.background_image')</label>
                                                                    <input type="hidden" name="login_dashboard[background]" value="{{ @$loginTheme->background }}" >
                                                                    <input class="form-control" type="file" name="login_dashboard[background]" value="{{ @$loginTheme->background  }}" id="example-number-input">
                                                                </div>

                                                            </div>
                                                        {{-- End login logo image ------------------------------------------------------------------------------------- --}}
                                                        
                                                        {{-- login background image ----------------------------------------------------------------------------------- --}}
                                                            <div class="row mt-3">
                                                                <div class="col-sm-4 col-md-4 ">
                                                                    <a href="{{ getImage( @$loginTheme->logo_image ) }}" target="_blank">
                                                                        <img src="{{ getImage( @$loginTheme->logo_image ) }}" alt=""  width="25%">
                                                                    </a>
                                                                </div>
                                                                <div class="col-sm-4 col-md-4">
                                                                    <a href="{{ getImage(@$loginTheme->background ) }}" target="_blank">
                                                                        <img src="{{ getImage(@$loginTheme->background) }}" alt=""  width="25%">
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


                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="accordion mt-4 mb-4" id="accordionExample">
                                            <div class="accordion-item border rounded">
                                                <h2 class="accordion-header" id="headingTow">
                                                <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                                                    {{ trans('themes.dashboard_theme') }}
                                                </button>
                                                </h2>
                                                <div id="collapseTwo" class="accordion-collapse collapse show" aria-labelledby="headingTow" data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">

                                                        {{-- color ------------------------------------------------------------------------------------- --}}
                                                        <div class="row mt-3">
                                                            <div class="col-sm-3 col-md-3">
                                                                <label for="example-number-input"  col-form-label> @lang('themes.navbar_background_color')</label>
                                                                <input type="text" name="dashboard[navbar_background]" value="{{  @$dashboardTheme->navbar_background }}" placeholder="#FFFFFF" class="form-control spectrum with-add-on colorpicker-showinput-intial" id="colorpicker-showinput-intial" >
                                                            </div>
    
                                                            <div class="col-sm-3 col-md-3">
                                                                <label for="example-number-input"  col-form-label>@lang('themes.navbar_font_color') :</label>
                                                                <input type="text" name="dashboard[navbar_color]" value="{{ @$dashboardTheme->navbar_color }}" placeholder="#212529" class="form-control spectrum with-add-on colorpicker-showinput-intial" id="colorpicker-showinput-intial" >
                                                            </div>

                                                            <div class="col-sm-3 col-md-3">
                                                                <label for="example-number-input"  col-form-label> @lang('themes.side_navbar_background_color') :</label>
                                                                <input type="text" name="dashboard[side_navbar_background]" value="{{ @$dashboardTheme->side_navbar_background  }}" placeholder="#263238" class="form-control spectrum with-add-on colorpicker-showinput-intial" id="colorpicker-showinput-intial" >
                                                            </div>

                                                            <div class="col-sm-3 col-md-3">
                                                                <label for="example-number-input"  col-form-label> @lang('themes.side_navbar_font_color') :</label>
                                                                <input type="text" name="dashboard[side_navbar_color]" value="{{ @$dashboardTheme->side_navbar_color }}" placeholder="#FFFFFF" class="form-control spectrum with-add-on colorpicker-showinput-intial" id="colorpicker-showinput-intial" >
                                                            </div>
                                                        </div>
                                                        {{-- End color ----------------------------------------------------------------------------------------------- --}}
                
                                                            
                                                        {{-- login logo image ----------------------------------------------------------------------------------------- --}}
                                                            <div class="row mt-3">
                                
                                                                <div class="col-sm-3 col-md-3">
                                                                    <label for="example-number-input"  col-form-label> @lang('themes.icon_image') :</label>
                                                                    <input type="hidden" name="dashboard[icon]" value="{{  @$dashboardTheme->icon   }}" >
                                                                    <input class="form-control" type="file" name="dashboard[icon]" value="{{ @$dashboardTheme->icon  }}" >
                                                                </div>
                                                               
                                                                <div class="col-sm-3 col-md-3">
                                                                    <label for="example-number-input"  col-form-label>  @lang('themes.logo_dashboard_image')  :</label>
                                                                    <input type="hidden" name="dashboard[logo]" value="{{ @$dashboardTheme->logo   }}" >
                                                                    <input class="form-control" type="file" name="dashboard[logo]" value="{{ @$dashboardTheme->logo  }}">
                                                                </div>

                                                            </div>
                                                        {{-- End login logo image ------------------------------------------------------------------------------------- --}}
                                                        
                                                        {{-- login background image ----------------------------------------------------------------------------------- --}}

                                                            <div class="row mt-3">
                        
                                                            
                                                                <div class="col-sm-4 col-md-4 ">
                                                                    <a href="{{ asset(@$dashboardTheme->icon ) }}" target="_blank">
                                                                        <img src="{{ asset(@$dashboardTheme->icon  ) }}" alt=""  width="25%">
                                                                    </a>
                                                                </div>

                                                                <div class="col-sm-4 col-md-4">
                                                                    <a href="{{ asset( @$dashboardTheme->logo ) }}" target="_blank">
                                                                        <img src="{{ asset( @$dashboardTheme->logo  ) }}" alt=""  width="25%">
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
                                        <a href="{{ route('admin.home') }}" class="btn btn-outline-danger waves-effect waves-light ml-3">@lang('button.cancel')</a>
                                        <button type="submit" class="btn btn-outline-success waves-effect waves-light ml-3">@lang('button.save')</button>
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



