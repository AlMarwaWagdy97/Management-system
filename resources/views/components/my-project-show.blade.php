<div>
    <div class="row">
        <div class="col-md-8">
            @foreach ($languages as $key => $locale)
            <div class="accordion mt-4 mb-4" id="accordionExampleTitle{{ $key }}">
                <div class="accordion-item border rounded">
                    <h2 class="accordion-header" id="headingTitle{{ $key }}">
                        <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne{{ $key }}" aria-expanded="true" aria-controls="collapseOne{{ $key }}">
                            {{ trans('lang.' . Locale::getDisplayName($locale)) }}
                        </button>
                    </h2>
                    <div id="collapseOne{{ $key }}" class="accordion-collapse collapse show mt-3" aria-labelledby="headingTitle{{ $key }}" data-bs-parent="#accordionExampleTitle{{ $key }}">
                        <div class="accordion-body">
                            {{-- title ------------------------------------------------------------------------------------- --}}
                            <div class="row mb-3">
                                <label for="example-text-input" class="col-sm-2 col-form-label">{{ trans('admin.title_in') . trans('lang.' . Locale::getDisplayName($locale)) }}</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" name="{{ $locale }}[title]" value="{{ @$items->trans->where('locale', $locale)->first()->title }}" id="title{{ $key }}" disabled>
                                </div>
                            </div>

                            {{-- slug ------------------------------------------------------------------------------------- --}}
                            <div class="row mb-3 slug-section">
                                <label for="example-text-input" class="col-sm-2 col-form-label">{{ trans('admin.slug_in') . trans('lang.' . Locale::getDisplayName($locale)) }}
                                </label>
                                <div class="col-sm-10">
                                    <input type="text" id="slug{{ $key }}" name="{{ $locale }}[slug]" value="{{ @$items->trans->where('locale', $locale)->first()->slug }}" class="form-control slug" required disabled>
                                </div>
                            </div>
                            {{-- End Slug ------------------------------------------------------------------------------- --}}

                            <div class="row mt-3">
                                <label for="example-text-input" class="col-sm-12 col-form-label">
                                    {{ trans('admin.description_in') . trans('lang.' . Locale::getDisplayName($locale)) }}
                                </label>
                                <div class="col-sm-12 mb-2">
                                    <p>{!! @$items->trans->where('locale', $locale)->first()->description !!}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach

            <div class="accordion mt-4 mb-4" id="accordionExampleMeta{{ $key }}">
                <div class="accordion-item border rounded">
                    <h2 class="accordion-header" id="headingMeta{{ $key }}">
                        <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseMeta{{ $key }}" aria-expanded="true" aria-controls="collapseTwo{{ $key }}">
                            @lang('admin.meta')
                        </button>
                    </h2>
                    <div id="collapseTwo{{ $key }}" class="accordion-collapse collapse mt-3" aria-labelledby="headingTwo{{ $key }}" data-bs-parent="#accordionExampleMeta{{ $key }}">
                        <div class="accordion-body">

                            @foreach ($languages as $key => $locale)
                            {{-- meta_title_ ------------------------------------------------------------------------------------- --}}
                            <div class="row mb-3">
                                <label for="example-text-input" class="col-sm-2 col-form-label">{{ trans('admin.meta_title_in') . trans('lang.' . Locale::getDisplayName($locale)) }}</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" name="{{ $locale }}[meta_title]" value="{{ @$items->trans->where('locale', $locale)->first()->meta_title }}" id="title{{ $key }}" disabled>
                                </div>
                                @if ($errors->has($locale . '.meta_title'))
                                <span class="missiong-spam">{{ $errors->first($locale . '.meta_title') }}</span>
                                @endif
                            </div>

                            {{-- meta_description_ ------------------------------------------------------------------------------------- --}}
                            <div class="row mb-3">
                                <label for="example-text-input" class="col-sm-2 col-form-label">
                                    {{ trans('admin.meta_description_in') . trans('lang.' . Locale::getDisplayName($locale)) }}
                                </label>
                                <div class="col-sm-10 mb-2">
                                    <textarea name="{{ $locale }}[meta_description]" class="form-control description" disabled> {{ @$items->trans->where('locale', $locale)->first()->meta_description }} </textarea>
                                    @if ($errors->has($locale . '.meta_description'))
                                    <span class="missiong-spam">{{ $errors->first($locale . '.meta_description') }}</span>
                                    @endif
                                </div>
                            </div>

                            {{-- meta_key_ ------------------------------------------------------------------------------------- --}}
                            <div class="row mb-3">
                                <label for="example-text-input" class="col-sm-2 col-form-label">
                                    {{ trans('admin.meta_key_in') . trans('lang.' . Locale::getDisplayName($locale)) }}
                                </label>
                                <div class="col-sm-10 mb-2">
                                    <textarea name="{{ $locale }}[meta_key]" class="form-control description" disabled> {{ @$items->trans->where('locale', $locale)->first()->meta_key }} </textarea>
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
            {{-- ------------images--------------- --}}
            <div class="accordion mt-4 mb-4" id="accordionExampleImages">
                <div class="accordion-item border rounded">
                    <h2 class="accordion-header" id="headingImages">
                        <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#images_project" aria-expanded="true" aria-controls="images_project">
                            {{ trans('charityProject.images_project') }}
                        </button>
                    </h2>
                    <div id="images_project" class="accordion-collapse collapse show" aria-labelledby="headingImages" data-bs-parent="#accordionExampleImages">
                        <div class="accordion-body">
                            <div class="row">
                                <label class="control-label" for="imageUpload">@lang('charityProject.images_project')</label>
                                <div class="col-sm-3 col-md-6 mb-3">
                                    @forelse(hinddelImage($items->images) as $image)
                                    <div class="col-sm-3 col-md-6 mb-3 d-flex justify-content-center">
                                        <img src="{{ getImageThumb($image) }}" alt="Card image" style="width:200px; height:200px;margin:10px;">
                                    </div>
                                    @empty
                                    <img src="{{ asset( admin_path('images\gallery\empty.jpg')) }}" alt="Card image" style="width:200px; height:200px;margin:10px;">

                                    @endforelse

                                </div>
                            </div>
                            {{-- cover image ------------------------------------------------------------------------------------- --}}
                            <div class="row mb-3">
                                <div class="col-sm-6 col-md-6 mb-3">
                                    {{-- @if ($items->cover_image != null) --}}
                                    <label for="example-number-input" class="col-sm-12 col-form-label">
                                        @lang('charityProject.cover_image') : </label>
                                    <img src="{{ getImageThumb($items->cover_image) }}" alt="Card image" style="width:200px; height:200px;margin:10px;">
                                    {{-- @endif --}}

                                </div>

                                <div class="col-sm-6 col-md-6 mb-3">
                                    {{-- @if ($items->cover_image != null) --}}
                                    <label for="example-number-input" class="col-sm-12 col-form-label">
                                        @lang('charityProject.background_image') : </label>
                                    <img src="{{ getImageThumb($items->background_image) }}" alt="Card image" style="width:200px; height:200px;margin:10px;">
                                    {{-- @endif --}}

                                </div>
                            </div>
                            {{-- background_color------------------------------------------------------------------------------------- --}}
                            <div class="row mb-3">
                                <div class="col-4">
                                    <label for="example-number-input" col-form-label>
                                        @lang('charityProject.background_color') :</label>
                                    <input type="text" name="background_color" disabled value="{{ $items->background_color }}" placeholder="#FFFFFF" class="form-control spectrum with-add-on colorpicker-showinput-intial" id="colorpicker-showinput-intial">
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            {{-- Setting --}}
            <div class="accordion mt-4 mb-4" id="accordionExampleSetting">
                <div class="accordion-item border rounded">
                    <h2 class="accordion-header" id="headingSetting">
                        <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            {{ trans('admin.settings') }}
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingSetting" data-bs-parent="#accordionExampleSetting">
                        <div class="accordion-body">

                            {{-- beneficiary ------------------------------------------------------------------------------------- --}}
                            <div class="row mb-3">
                                <div class="col-12">
                                    <label for="example-number-input" class="col-sm-12 col-form-label" l> @lang('charityProject.number') </label>
                                    <div class="col-sm-12">
                                        <input class="form-control" type="text" id="example-number-input" name="number" disabled value="{{ $items->number }}">
                                    </div>
                                </div>
                            </div>
                            {{-- beneficiary ------------------------------------------------------------------------------------- --}}
                            <div class="row mb-3">
                                <label class="col-sm-12 col-form-label" for="available">@lang('charityProject.beneficiary') </label>
                                <div class="col-sm-12">
                                    <input class="form-control" name="beneficiary" disabled type="text" value="{{ $items->beneficiary }}">
                                </div>
                            </div>

                            {{-- category ------------------------------------------------------------------------------------- --}}
                            <div class="row mb-3 title-section">
                                <label for="example-text-input" class="col-sm-12 col-form-label">@lang('charityProject.category')</label>
                                <div class="col-sm-12">
                                    <div class="col-sm-12">
                                        <input class="form-control" name="beneficiary" disabled type="text" value="{{ $items->category->trans->where('locale', $current_lang)->first()->title }}">
                                    </div>
                                </div>
                            </div>
                            {{-- tags ------------------------------------------------------------------------------------- --}}
                            <div class="row mb-3 title-section">
                                <label for="example-text-input" class="col-sm-12 col-form-label">@lang('charityProject.tags')</label>
                                <div class="col-sm-12">
                                    @forelse ($items->tags as $tag)
                                    <span class="badge rounded-pill bg-primary">{{ $tag->trans->where('locale', $current_lang)->first()->title }}</span>
                                    @empty
                                    @endforelse
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            {{-- Setting Post --}}
            <div class="accordion mt-4 mb-4" id="accordionExamplePublish">
                <div class="accordion-item border rounded">
                    <h2 class="accordion-header" id="headingPublish">
                        <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#settings_post" aria-expanded="true" aria-controls="settings_post">
                            {{ trans('charityProject.settings_post') }}
                        </button>
                    </h2>
                    <div id="settings_post" class="accordion-collapse collapse show" aria-labelledby="headingPublish" data-bs-parent="#accordionExamplePublish">
                        <div class="accordion-body">
                            <div class="row">
                                {{-- sort ------------------------------------------------------------------------------------- --}}
                                <div class="row mb-3">
                                    <div class="col-12">
                                        <label for="example-number-input" class="col-md-6"> @lang('charityProject.sort'):</label>
                                        <span class="col-md-6">{{ @$items->sort  }}</span>
                                    </div>
                                </div>
                                {{-- Start Date ------------------------------------------------------------------------------------- --}}
                                <div class="row mb-3">
                                    <div class="col-12">
                                        <label for="example-number-input" class="col-md-6"> @lang('charityProject.start_date'):</label>
                                        <span class="col-md-6">{{ @$items->start_date  }}</span>
                                    </div>
                                </div>
                                {{-- End Date ------------------------------------------------------------------------------------- --}}
                                <div class="row mb-3">
                                    <div class="col-12">
                                        <label for="example-number-input" class="col-md-6"> @lang('charityProject.end_date'):</label>
                                        <span class="col-md-6">{{ @$items->end_date  }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row m-auto ">
                                {{-- ------------------- status ------------------------------ --}}
                                <div class="col-12 mb-3">
                                    <label for="example-number-input" class="col-md-6"> {{ trans('admin.status') }}</label>
                                    @if($items->status == 1 )
                                    <span class="badge bg-success">@lang("admin.active")</span>
                                    @else
                                    <span class="badge bg-danger">@lang("admin.dis_active")</span>
                                    @endif
                                </div>
                                {{-- ---------------------- featuer ------------------------ --}}
                                <div class="col-12 mb-3">
                                    <label for="example-number-input" class="col-md-6"> {{ trans('charityProject.featuer') }}</label>
                                    @if($items->featuer == 1 )
                                    <span class="badge bg-success">@lang("admin.yes")</span>
                                    @else
                                    <span class="badge bg-danger">@lang("admin.no")</span>
                                    @endif
                                </div>
                                {{-- ---------------------- finished ------------------------ --}}
                                <div class="col-12 mb-3">
                                    <label for="example-number-input" class="col-md-6"> {{ trans('charityProject.finished') }}</label>
                                    @if($items->finished == 1 )
                                    <span class="badge bg-success">@lang("admin.yes")</span>
                                    @else
                                    <span class="badge bg-danger">@lang("admin.no")</span>
                                    @endif
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
            {{-- Payment Methoed --}}
            <div class="accordion mt-4 mb-4" id="accordionExamplePayments">
                <div class="accordion-item border rounded">
                    <h2 class="accordion-header" id="headingPayments">
                        <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#payment_method" aria-expanded="true" aria-controls="payment_method">
                            {{ trans('charityProject.payment_method') }}
                        </button>
                    </h2>
                    <div id="payment_method" class="accordion-collapse collapse show" aria-labelledby="headingPaymentsPayments" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            {{-- donation_type ------------------------------------------------------------------------------------- --}}
                            <div class="row mb-3 title-section">
                                <label for="example-text-input" class="col-sm-12 col-form-label">@lang('charityProject.donation_type')</label>
                                <div class="col-sm-12">
                                    <div class="col-sm-12">
                                        <input class="form-control" type="text" id="example-number-input" name="kafara" disabled value="{{ @$donation['type']  }}">
                                    </div>

                                </div>
                            </div>
                            {{-- ------------------ Start forms donation_type  ------------------- --}}
                            {{-- Start input share Value --}}
                            <div class="row mb-3  {{ @$donation['type'] == 'share' ? '' : 'd-none' }}" id="section-share-value">
                                <div id="ads_section">
                                    @if (@$donation['type'] == 'share')
                                    @foreach (@$donation['data'] as $key => $value)
                                    <div>
                                        <div class="ads">
                                            <div class="col-12">
                                                <div class="row mb-3">
                                                    <label for="example-number-input">
                                                        @lang('charityProject.donation_name_share'):</label>
                                                    <div class="col-sm-12">
                                                        <input type="" name="share_name[]" class="form-control" required value="{{ $value['name'] }}" disabled>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <div class="row mb-3">
                                                    <label for="example-number-input">
                                                        @lang('charityProject.donation_value_share'):</label>
                                                    <div class="col-sm-12">
                                                        <input type="number" name="share_value[]" class="form-control" required value="{{ $value['value'] }}" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                        </div>
                                    </div>
                                    @endforeach
                                    {{-- {{ $donation['data'] }} --}}
                                    @endif
                                </div>
                            </div>
                            {{-- End input share Value --}}

                            {{-- Start input Fixed Value --}}


                            <div class="col-12 {{ @$donation['type'] == 'fixed' ? '' : 'd-none' }}" id="section-fixed-value">
                                <div class="row mb-3">
                                    @if (@$donation['type'] == 'fixed')
                                    @foreach (@$donation['data'] as $key => $value)
                                    <label for="example-number-input" class="col-sm-12 col-form-label">
                                        @lang('charityProject.fiexd_value') : </label>
                                    <div class="col-sm-12">
                                        <input class="form-control" type="number" id="fixed-value" name="fixed_value" value="{{ @$value['value'] }}" disabled>
                                    </div>
                                    @endforeach
                                    @endif

                                </div>
                            </div>
                            {{-- End input Fixed Value --}}


                            {{-- Start input Deometion Value --}}
                            <div class="row mb-3 {{ @$donation['type'] == 'unit' ? '' : 'd-none' }}" id="section-donation-value">
                                <div id="donation_section">
                                    @if (@$donation['type'] == 'unit')
                                    @foreach (@$donation['data'] as $key => $value)
                                    <div>
                                        <div class="ads">
                                            <div class="col-12">
                                                <div class="row mb-3">
                                                    <label for="example-number-input">
                                                        @lang('charityProject.donation_name'):</label>
                                                    <div class="col-sm-12">
                                                        <input type="" name="donation_name[]" class="form-control" required value="{{ $value['name'] }}" disabled>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <div class="row mb-3">
                                                    <label for="example-number-input">
                                                        @lang('charityProject.donation_value'):</label>
                                                    <div class="col-sm-12">
                                                        <input type="number" name="donation_value[]" class="form-control" required value="{{ $value['value'] }}" disabled>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>
                                        </div>
                                    </div>
                                    @endforeach

                                    @endif
                                </div>

                            </div>

                            {{-- End input Deometion Value --}}
                            {{-- ------------------ End forms donation_type  ------------------- --}}

                            {{-- target_price ------------------------------------------------------------------------------------- --}}
                            <div class="col-12">
                                <div class="row mb-3">
                                    <label for="example-number-input" class="col-sm-12 col-form-label">
                                        @lang('charityProject.target_price') : </label>
                                    <div class="col-sm-12">
                                        <input class="form-control" type="number" id="example-number-input" name="target_price" value="{{ $items->target_price }}" disabled>
                                    </div>
                                </div>
                            </div>
                            {{-- target_unit ------------------------------------------------------------------------------------- --}}
                            <div class="col-12">
                                <label class="col-sm-12 col-form-label" for="available">@lang('charityProject.target_unit') :</label>
                                <div class="col-sm-12">
                                    <input class="form-control" name="target_unit" type="text" value="{{ $items->target_unit }}" disabled>
                                </div>
                            </div>

                            {{-- unit_price ------------------------------------------------------------------------------------- --}}
                            @foreach ($languages as $key => $locale)
                            {{-- unit_price ------------------------------------------------------------------------------------- --}}
                            <div class="row mb-3">
                                <label for="example-text-input" class="col-sm-12 col-form-label">{{ trans('charityProject.unit_price_in') . trans('lang.' . Locale::getDisplayName($locale)) }}</label>
                                <div class="col-sm-12">
                                    <input class="form-control" type="text" name="{{ $locale }}[unit_price]" disabled value="{{ @$items->trans->where('locale', $locale)->first()->unit_price }} }}" id="unit_price{{ $key }}">
                                </div>
                                @if ($errors->has($locale . '.unit_price'))
                                <span class="missiong-spam">{{ $errors->first($locale . '.unit_price') }}</span>
                                @endif
                            </div>
                            @endforeach
                            {{-- fake_target ------------------------------------------------------------------------------------- --}}
                            <div class="col-12">
                                <label class="col-sm-12 col-form-label" for="available">@lang('charityProject.fake_target') :</label>
                                <div class="col-sm-12">
                                    <input class="form-control" name="fake_target" disabled type="number" value="{{ $items->fake_target }}">
                                </div>
                            </div>
                            {{-- --------------Payment Methoed----------------------------- --}}
                            @if(Route::is('admin.charity.single-projects.show'))
                            <div class="col-12">
                                <label class="col-sm-12 col-form-label" for="available">@lang('charityProject.payment_method')</label>
                                <div class="col-sm-10">
                                    <div class="form-check">
                                        @foreach ($payments as $key => $item)
                                        <div class="col-md-12">
                                            <input class="form-check-input" type="checkbox" value="{{ $item->id }}" id="flexCheckDefault{{ $key }}" name="payment_method[]" {{ in_array($item->id, $items->payment->pluck('payment_id')->toArray()) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="flexCheckDefault{{ $key }} ">{{ $item->trans->where('locale', $current_lang)->first()->title }}</label>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>

                    </div>
                </div>

                {{-- contact --}}
                <div class="accordion mt-4 mb-4" id="accordionExample">
                    <div class="accordion-item border rounded">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#contact" aria-expanded="true" aria-controls="contact">
                                {{ trans('charityProject.setting_contact') }}
                            </button>
                        </h2>
                        <div id="contact" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                            <div class="accordion-body">

                                {{-- mobile ------------------------------------------------------------------------------------- --}}
                                <div class="col-12">
                                    <div class="row mb-3">
                                        <label for="example-number-input" class="col-sm-12 col-form-label">
                                            @lang('charityProject.mobile') : </label>
                                        <div class="col-sm-12">
                                            <input class="form-control" type="text" id="example-number-input" name="mobile" disabled value="{{ $items->mobile }}"
                                                oninput="this.value = this.value.replace(/[^0-9]/g, '');" maxlength="9" >
                                        </div>
                                    </div>
                                </div>
                                {{-- whatsapp ------------------------------------------------------------------------------------- --}}
                                <div class="col-12">
                                    <label class="col-sm-12 col-form-label" for="available">@lang('charityProject.whatsapp') :</label>
                                    <div class="col-sm-12">
                                        <input class="form-control" name="whatsapp" disabled type="text" value="{{ $items->whatsapp }}">
                                    </div>
                                </div>

                                {{-- unit_price ------------------------------------------------------------------------------------- --}}
                                @foreach ($languages as $key => $locale)
                                {{-- unit_price ------------------------------------------------------------------------------------- --}}
                                <div class="row mt-3">

                                    <label for="example-text-input" class="col-sm-12 col-form-label">{{ trans('charityProject.sms_message_in') . trans('lang.' . Locale::getDisplayName($locale)) }}</label>
                                    <div class="form-group col-xs-12">
                                        <button type="button" class="btn btn-primary btn-sm mb-1" name="" onclick="$('#sms_message{{ $key }}').val($('#sms_message{{ $key }}').val() +'[[name]]') ;return false;" value="">{{ trans('charityProject.Attach_name') }}</button>
                                        <button type="button" class="btn btn-primary btn-sm" name="" onclick="$('#sms_message{{ $key }}').val($('#sms_message{{ $key }}').val() +'[[identifier]]') ;return false;" value="">{{ trans('charityProject.Attach_application_number') }}</button>
                                        <button type="button" class="btn btn-primary btn-sm mb-1" name="" onclick="$('#sms_message{{ $key }}').val($('#sms_message{{ $key }}').val() +'[[total]]') ;return false;" value="">{{ trans('charityProject.Attach_the_amount') }}</button>
                                        <button type="button" class="btn btn-primary btn-sm mb-1" name="" onclick="$('#sms_message{{ $key }}').val($('#sms_message{{ $key }}').val() +'[[project]]') ;return false;" value="">{{ trans('charityProject.Project_attachments') }}</button>
                                    </div>
                                    <div class="col-sm-12">
                                        <span>@lang('charityProject.message_Confirm')</span>
                                        <textarea name="{{ $locale }}[sms_message]" disabled id="sms_message{{ $key }}" class="form-control">{{ @$items->trans->where('locale', $locale)->first()->sms_message }}</textarea>
                                    </div>
                                    @if ($errors->has($locale . '.sms_message'))
                                    <span class="missiong-spam">{{ $errors->first($locale . '.sms_message') }}</span>
                                    @endif
                                </div>
                                @endforeach
                                @foreach ($languages as $key => $locale)
                                {{-- unit_price ------------------------------------------------------------------------------------- --}}
                                <div class="row mt-3">
                                    <label for="example-text-input" class="col-sm-12 col-form-label">{{ trans('charityProject.thank_message_in') . trans('lang.' . Locale::getDisplayName($locale)) }}</label>
                                    <div class="col-sm-12">

                                        <span>@lang('charityProject.sms_message')</span>
                                        <textarea name="{{ $locale }}[thank_message]" disabled id="thank_message{{ $key }}" class="form-control">{{ @$items->trans->where('locale', $locale)->first()->thank_message }}</textarea>
                                    </div>
                                    @if ($errors->has($locale . '.thank_message'))
                                    <span class="missiong-spam">{{ $errors->first($locale . '.thank_message') }}</span>
                                    @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
