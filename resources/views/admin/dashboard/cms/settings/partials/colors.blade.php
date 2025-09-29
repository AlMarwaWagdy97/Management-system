@extends('admin.app')

@section('title', trans('settings.edit', ['name' => $settingMain->title]) )
@section('title_page', trans('settings.settings'))
@section('title_route', route('admin.settings.index') )
@section('button_page')
<a href="{{ route('admin.settings.index') }}" class="btn btn-outline-primary waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
@endsection



@section('content')


<form class="form-horizontal" action="{{route('admin.settings.update-custom', $settingMain->key)}}" method="POST" enctype="multipart/form-data" role="form">
    @csrf

    <div class="row text-center mt-5 mb-3">
        <label class="col-sm-2 col-form-label"> @lang('settings.title_setting') </label>
        <div class="col-sm-10">
            <input class="form-control" type="text" name="title" value="{{ @$settings['title'] }}" required>
        </div>
    </div>

    <div class="accordion mt-4 mb-4" id="accordionSiteColor">
        <div class="accordion-item border rounded">
            <h2 class="accordion-header" id="headingSiteColor">
                <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSiteColor" aria-expanded="true" aria-controls="collapseSiteColor">
                    @lang('settings.site_color')
                </button>
            </h2>
            <div id="collapseSiteColor" class="accordion-collapse collapse show mt-3" aria-labelledby="headingSiteColor" data-bs-parent="#accordionSiteColor">
                <div class="accordion-body">
                    <div class="row">
                        <div class="row">
                            <div class="col-12 col-md-3 mt-3">
                                <label>  @lang('settings.main') </label>
                                <input type="text" name="main" value="{{ @$settings['main'] }}" class="form-control color-picker spectrum with-add-on" placeholder="#FFFFFF">
                                <span class="text-primary"> الشريط العلوي ,  لون الشريط السفلي, التبرع السريع , اللوان المشاريع </span>
                            </div>

                            <div class="col-12 col-md-3 mt-3">
                                <label>  @lang('settings.secound') </label>
                                <input type="text" name="secound" value="{{ @$settings['secound'] }}" class="form-control color-picker spectrum with-add-on" placeholder="#FFFFFF">
                                <span class="text-primary"> الشريط السفلي</span>
                            </div>

                            <div class="col-12 col-md-3 mt-3">
                                <label>  @lang('settings.third') </label>
                                <input type="text" name="third" value="{{ @$settings['third'] }}" class="form-control color-picker spectrum with-add-on" placeholder="#FFFFFF">
                                <span class="text-primary">  لون عنوان القسم</span>
                            </div>

                            {{-- <div class="col-12 col-md-3 mt-3">
                                <label>  @lang('settings.fourth') </label>
                                <input type="text" name="fourth" value="{{ @$settings['fourth'] }}" class="form-control color-picker spectrum with-add-on" placeholder="#FFFFFF">
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="accordion mt-4 mb-4" id="accordionSiteColor">
        <div class="accordion-item border rounded">
            <h2 class="accordion-header" id="headingSiteColor">
                <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSiteColor" aria-expanded="true" aria-controls="collapseSiteColor">
                    @lang('settings.footer_color')
                </button>
            </h2>
            <div id="collapseSiteColor" class="accordion-collapse collapse show mt-3" aria-labelledby="headingSiteColor" data-bs-parent="#accordionSiteColor">
                <div class="accordion-body">
                    <div class="row">
                        <div class="row">
                            <div class="col-12 col-md-3 mt-3">
                                <label>  @lang('settings.bg_footer1') </label>
                                <input type="text" name="bg_footer1" value="{{ @$settings['bg_footer1'] }}" class="form-control color-picker spectrum with-add-on" placeholder="#FFFFFF">
                                <span class="text-primary">  الجزء الاول والثالث للفوتر</span>
                            </div>

                            <div class="col-12 col-md-3 mt-3">
                                <label>  @lang('settings.bg_footer2') </label>
                                <input type="text" name="bg_footer2" value="{{ @$settings['bg_footer2'] }}" class="form-control color-picker spectrum with-add-on" placeholder="#FFFFFF">
                                <span class="text-primary">  الجزء الثاني الرابع للفوتر</span>
                            </div>

                            <div class="col-12 col-md-3 mt-3">
                                <label>  @lang('settings.title_footer') </label>
                                <input type="text" name="title_footer" value="{{ @$settings['title_footer'] }}" class="form-control color-picker spectrum with-add-on" placeholder="#FFFFFF">
                                <span class="text-primary"> عنوان الفوتر  </span>
                            </div> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- <div class="accordion mt-4 mb-4" id="accordionCategory">
        <div class="accordion-item border rounded">
            <h2 class="accordion-header" id="headingCategory">
                <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCategory" aria-expanded="true" aria-controls="collapseCategory">
                    @lang('settings.categories_color')
                </button>
            </h2>
            <div id="collapseCategory" class="accordion-collapse collapse show mt-3" aria-labelledby="headingCategory" data-bs-parent="#accordionCategory">
                <div class="accordion-body">

                    <div class="row">
                        <input type="hidden" name="type_setting" value="color">
                        <label class="mb-3">@lang('settings.categories_color_description')</label>
                        @forelse (json_decode(@$settings['categoryColorlist'])??[] as $key => $item)
                        <div class="old_items col-12 col-md-3  mt-3" data-group="categoryColorlist">
                            <!-- Repeater Content -->
                            <div class="item-content">
                                <div class="row">
                                    <div class="col-md-8">
                                        <input type="text" name="old_category[][background_color]" value="{{ @$item }}" class="form-control color-picker spectrum with-add-on" placeholder="#FFFFFF">
                                    </div>
                                    <!-- Repeater Remove Btn -->
                                    <div class="col-md-2">
                                        <div class="pull-right repeater-remove-btn ">
                                            <button class="btn btn-danger btn-sm old_remove-btn" type="button">
                                                @lang('admin.delete')
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        @endforelse
                        <!-- Repeater Heading -->
                        <div class="repeater-section col-12 col-md-3" style="display: none" id="repeater">
                            <div class="items" data-group="categoryColorlist">
                                <div class="row my-2">
                                    <div class="col-md-8">
                                        <input type="text" data-name="background_color" class="form-control color-picker spectrum with-add-on" placeholder="#FFFFFF">
                                        <script type="text/javascript">
                                            $(document).ready(function() {
                                                $('.color-picker').spectrum({
                                                    showPalette: true
                                                , });
                                            });

                                        </script>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="pull-right repeater-remove-btn mt-2">
                                            <button class="btn btn-danger btn-sm remove-btn"> @lang('admin.delete')</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!--- /Repeater Section Content --->
                        <div class="repeater-heading mt-4 d-none d-flex justify-content-center">
                            <div class="col-md-3">
                                <button type="button" class="btn btn-success btn-sm form-control pull-right repeater-add-btn" id="category_address">
                                    <i class="bx bx-plus"></i>
                                </button>
                            </div>
                        </div>

                        <div class="repeater-show-heading mt-4 d-flex justify-content-center">
                            <div class="col-md-3">
                                <button type="button" class="btn btn-success btn-sm form-control pull-right repeater-show-btn" id="category_address">
                                    <i class="bx bx-plus"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

    <div class="accordion mt-4 mb-4" id="accordionDonations">
        <div class="accordion-item border rounded">
            <h2 class="accordion-header" id="headingDonations">
                <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseDonations" aria-expanded="true" aria-controls="collapseDonations">
                    @lang('settings.donations_color')
                </button>
            </h2>
            <div id="collapseDonations" class="accordion-collapse collapse show mt-3" aria-labelledby="headingDonations" data-bs-parent="#accordionDonations">
                <div class="accordion-body">
                    <div class="row">
                        <label>@lang('settings.donations_color_description')</label>
                        <div class="row">
                            <div class="col-md-6 mt-3">
                                <input type="text" name="donation_color[0]" value="{{ @json_decode(@$settings['donation_color'])[0] }}" class="form-control color-picker spectrum with-add-on" placeholder="#FFFFFF">
                            </div>
                            <div class="col-md-6 mt-3">
                                <input type="text" name="donation_color[1]" value="{{ @json_decode(@$settings['donation_color'])[1] }}" class="form-control color-picker spectrum with-add-on" placeholder="#FFFFFF">
                            </div>
                            <div class="col-md-6 mt-3">
                                <input type="text" name="donation_color[2]" value="{{ @json_decode(@$settings['donation_color'])[2] }}" class="form-control color-picker spectrum with-add-on" placeholder="#FFFFFF">
                            </div>
                            <div class="col-md-6 mt-3">
                                <input type="text" name="donation_color[3]" value="{{ @json_decode(@$settings['donation_color'])[3] }}" class="form-control color-picker spectrum with-add-on" placeholder="#FFFFFF">
                            </div>
                            <div class="col-md-6 mt-3">
                                <input type="text" name="donation_color[4]" value="{{ @json_decode(@$settings['donation_color'])[4] }}" class="form-control color-picker spectrum with-add-on" placeholder="#FFFFFF">
                            </div>
                            <div class="col-md-6 mt-3">
                                <input type="text" name="donation_color[5]" value="{{ @json_decode(@$settings['donation_color'])[5] }}" class="form-control color-picker spectrum with-add-on" placeholder="#FFFFFF">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="row mb-3 text-end">
        <div>
            <a href="{{ route('admin.settings.index') }}" class="btn btn-outline-primary waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
            <button type="submit" class="btn btn-outline-success waves-effect waves-light ml-3 btn-sm">@lang('button.save')</button>
        </div>
    </div>
</form>

@endsection




@section('script')

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <script src="{{ asset('backend/js/spectrum.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.color-picker').spectrum({
                showPalette: true
            , });
        });

    </script>
@endsection
