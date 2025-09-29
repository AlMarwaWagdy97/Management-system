<div>
    {{-- Setting ------------------------------------------------------------------------------ --}}
    <div class="mt-4 mb-4 accordion" id="accordionExampleSetting">
        <div class="border rounded accordion-item">
            <h2 class="accordion-header" id="headingSetting">
                <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSetting" aria-expanded="true" aria-controls="collapseOne">
                    {{ trans('admin.settings') }}
                </button>
            </h2>
            <div id="collapseSetting" class="accordion-collapse collapse show" aria-labelledby="headingSetting" data-bs-parent="#accordionExampleSetting">
                <div class="accordion-body">
                    {{-- number  ------------------------------------------------------------------------------------- --}}
                    <div class="col-12">
                        <div class="mb-3 row">
                            <label for="example-number-input" class="col-sm-12 col-form-label">
                                @lang('charityProject.number') </label>
                            <div class="col-sm-12">
                                <input class="form-control {{ (empty($errors->first('number'))) ?: 'has-error'  }}" type="text" id="example-number-input" name="number" value="{{ old('number') }}">
                                @if ($errors->has('number'))
                                <span class="missiong-spam">{{ $errors->first('number') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    {{-- beneficiary ------------------------------------------------------------------------------------- --}}
                    <div class="col-12">
                        <label class="col-sm-12 col-form-label" for="available">@lang('charityProject.beneficiary') </label>
                        <div class="col-sm-12">
                            <input class="form-control {{ (empty($errors->first('beneficiary'))) ?: 'has-error'  }}" name="beneficiary" type="text" value="{{ old('beneficiary') }}">
                            @if ($errors->has('beneficiary'))
                            <span class="missiong-spam">{{ $errors->first('beneficiary') }}</span>
                            @endif
                        </div>
                    </div>
                    {{-- category ------------------------------------------------------------------------------------- --}}
                    <div class="mb-3 row title-section">
                        <label for="example-text-input" class="col-sm-12 col-form-label">
                            @lang('charityProject.category')
                            <span class="text-danger">*</span>
                        </label>
                        <div class="col-sm-12">
                            <select class="form-select form-select-sm select2 {{ (empty($errors->first('category_id'))) ?: 'has-error'  }}" name="category_id" aria-label=".form-select-sm example">
                                <option value="" selected disabled>@lang('charityProject.choose_category')
                                </option>
                                @foreach ($categories as $item)
                                <option value="{{ $item->id }}" {{ old('category_id')==$item->id ? 'selected' : '' }}>
                                    {{ $item->trans->where('locale', $current_lang)->first()->title }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        @if ($errors->has('category_id'))
                        <span class="missiong-spam">{{ $errors->first('category_id') }}</span>
                        @endif
                    </div>
                    {{-- tags ------------------------------------------------------------------------------------- --}}
                    <div class="mb-3 row title-section">
                        <label for="example-text-input" class="col-sm-12 col-form-label">@lang('charityProject.tags')</label>
                        <div class="col-sm-12">
                            <select class="form-select form-select-sm select2 {{ (empty($errors->first('tags'))) ?: 'has-error'  }}" multiple name="tags[]" aria-label=".form-select-sm example">
                                <option value="" disabled>@lang('charityProject.choose_tag')</option>
                                @foreach ($tags as $item)
                                <option value="{{ $item->id }}" {{ in_array($item->id, old('tags') ?? []) ?
                                            'selected' : '' }}>
                                    {{ $item->trans->where('locale', $current_lang)->first()->title }}
                                </option>
                                @endforeach
                            </select>
                            @if ($errors->has('tags'))
                            <span class="missiong-spam">{{ $errors->first('tags') }}</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Setting Post ------------------------------------------------------------------------- --}}
    <div class="mt-4 mb-4 accordion" id="accordionExamplePublish">
        <div class="border rounded accordion-item">
            <h2 class="accordion-header" id="headingPublish">
                <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#settings_post" aria-expanded="true" aria-controls="settings_post">
                    {{ trans('charityProject.settings_post') }}
                </button>
            </h2>
            <div id="settings_post" class="accordion-collapse collapse " aria-labelledby="headingPublish" data-bs-parent="#accordionExamplePublish">
                <div class="accordion-body">
                    <div class="row">
                        {{-- sort  -------------------------------------------------------------------------------------     --}}
                        <div class="col-12">
                            <div class="mb-3 row">
                                <label for="example-number-input" class="col-sm-12 col-form-label">
                                    @lang('charityProject.sort')</label>
                                <div class="col-sm-12">
                                    <input class="form-control {{ (empty($errors->first('sort'))) ?: 'has-error'}}" type="number" id="example-number-input" name="sort" value="{{ old('sort') ?? 0 }}">
                                    @if ($errors->has('sort'))
                                    <span class="missiong-spam">{{ $errors->first('sort') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- Start Date -------------------------------------------------------------------------------------   --}}
                        <div class="col-12 ">
                            <div class="mb-3 row">
                                <label for="example-number-input" class="col-sm-12 col-form-label">
                                    @lang('charityProject.start_date') </label>
                                <div class="col-sm-12">
                                    <input class="form-control {{ (empty($errors->first('start_date'))) ?: 'has-error'}}" type="date" id="example-number-input" name="start_date" value="{{ date('Y-m-d') }}">
                                    @if ($errors->has('start_date'))
                                    <span class="missiong-spam">{{ $errors->first('start_date') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        {{-- End  Date-------------------------------------------------------------------------------------     --}}
                        <div class="col-12">
                            <div class="mb-3 row">
                                <label for="example-number-input" class="col-sm-12 col-form-label">
                                    @lang('charityProject.end_date') </label>
                                <div class="col-sm-12">
                                    <input class="form-control {{ (empty($errors->first('end_date'))) ?: 'has-error'}}" type="date" id="example-number-input" name="end_date" value="{{ now()->addYears(15)->format('Y-m-d') }}">
                                    @if ($errors->has('end_date'))
                                    <span class="missiong-spam">{{ $errors->first('end_date') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="m-auto row ">
                        {{-- -------------------status------------------------------ --}}
                        <div class="col-sm-6 mt-3">
                            <label class="form-check-label" for="flexSwitchCheckSuccessStatus">@lang('admin.status')</label>
                            <div class="form-check form-switch form-check-success">
                                <input class="form-check-input {{ (empty($errors->first('status'))) ?: 'has-error'}}" type="checkbox" role="switch" name="status" {{  request('status') == 1 ? 'checked' : '' }} id="flexSwitchCheckSuccessStatus">
                                @if ($errors->has('status'))
                                <span class="missiong-spam">{{ $errors->first('status') }}</span>
                                @endif
                            </div>
                        </div>
                        {{-- ----------------------featuer------------------------ --}}
                        <div class="col-sm-6 mt-3">
                            <label class="form-check-label" for="flexSwitchCheckSuccessFeatuer">@lang('charityProject.featuer')</label>
                            <div class="form-check form-switch form-check-success">
                                <input class="form-check-input {{ (empty($errors->first('featuer'))) ?: 'has-error'}}" type="checkbox" role="switch" name="featuer" {{  request('featuer') == 1 ? 'checked' : '' }} id="flexSwitchCheckSuccessFeatuer">
                                @if ($errors->has('featuer'))
                                <span class="missiong-spam">{{ $errors->first('featuer') }}</span>
                                @endif
                            </div>
                        </div>

                        {{-- ----------------------finished------------------------ --}}
                        <div class="col-sm-6 mt-3">
                            <label class="form-check-label" for="flexSwitchCheckSuccessFinished">@lang('charityProject.finished')</label>
                            <div class="form-check form-switch form-check-success">
                                <input class="form-check-input {{ (empty($errors->first('finished'))) ?: 'has-error'}}" type="checkbox" role="switch" name="finished" {{  request('finished') == 1 ? 'checked' : '' }} id="flexSwitchCheckSuccessFinished">
                                @if ($errors->has('finished'))
                                <span class="missiong-spam">{{ $errors->first('finished') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Payments ------------------------------------------------------------------------------ --}}
    <div class="mt-4 mb-4 accordion" id="accordionExamplePayments">
        <div class="border rounded accordion-item">
            <h2 class="accordion-header" id="headingPayments">
                <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#payment_method" aria-expanded="true" aria-controls="payment_method">
                    {{ trans('charityProject.payment_method') }}
                </button>
            </h2>
            <div id="payment_method" class="accordion-collapse collapse show" aria-labelledby="headingPayments" data-bs-parent="#accordionExamplePayments">
                <div class="accordion-body">
                    {{-- donation_type  ------------------------------------------------------------------------------------- --}}
                    <div class="mb-3 row title-section">
                        <label for="example-text-input" class="col-sm-12 col-form-label">
                            @lang('charityProject.donation_type') <span class="text-danger">*</span>
                        </label>
                        <div class="col-sm-12">
                            <select class="form-select form-select-sm" name="donation_type" aria-label=".form-select-sm example" id="denation-type">
                                <option value="" selected disabled> @lang('charityProject.donation_type') </option>
                                @foreach (App\Enums\DonationTypeEnum::values() as $key => $value)
                                <option value="{{ $value }}" {{ $value == old('donation_type') ? 'selected' : '' }}>
                                    {{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                        <span class="missiong-spam">{{ $errors->first('donation_type') }}</span>
                        <span class="missiong-spam">{{ $errors->first('share_name') }}</span>
                        <span class="missiong-spam">{{ $errors->first('share_value') }}</span>
                        <span class="missiong-spam">{{ $errors->first('donation_name') }}</span>
                        <span class="missiong-spam">{{ $errors->first('donation_value') }}</span>
                        <span class="missiong-spam">{{ $errors->first('fixed_value') }}</span>
                    </div>
                    {{-- ------------------ Start forms donation_type ------------------- --}}
                    {{-- Start input share Value --}}
                    <div class="row mb-3  {{ old('donation_type') == 'share' ? '' : 'd-none' }}" id="section-share-value">
                        <div id="ads_section">
                            @if (@old('donation_type') == 'share' && old('share_name') != null)
                            @foreach (@old('share_name') as $key => $value)
                            <div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="example-number-input"> @lang('charityProject.donation_name_share')</label>
                                            <div class="col-sm-12">
                                                <input type="text" name="share_name[]" class="form-control" required value="{{ $value }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="example-number-input"> @lang('charityProject.donation_value_share')</label>
                                            <div class="col-sm-12">
                                                <input type="number" name="share_value[]" class="form-control" required value="{{ @old('share_value')[$key] }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <button class="btn btn-danger delete_ads form-control"><i class="fadeIn animated bx bx-x-circle"></i></button>
                                    </div>
                                    <hr>
                                </div>
                            </div>
                            @endforeach
                            @endif
                        </div>
                        <button type="button" class="mt-2 btn btn-success form-control  btn-sm" id="add_ads_section">
                            <i class="bx bx-plus-medical fs-5"></i>
                        </button>

                    </div>
                    {{-- End input share Value --}}

                    {{-- Start input Fixed Value --}}
                    <div class="mb-3 d-none" id="section-fixed-value">
                        <div class="col-12">
                            <label for="example-number-input" class="col-sm-12 col-form-label">
                                @lang('charityProject.fiexd_value')</label>
                            <div class="col-sm-12">
                                <input class="form-control" type="number" id="fixed-value" name="fixed_value" value="{{ old('fixed_value') }}" min="0">
                            </div>
                        </div>
                    </div>
                    {{-- End input Fixed Value --}}


                    {{-- Start input donation Value --}}
                    <div class="row mb-3 {{ old('donation_type') == 'unit' ? '' : 'd-none' }}" id="section-donation-value">
                        <div id="donation_section">
                            @if (old('donation_type') == 'unit' && old('donation_name') != null)
                            @foreach (old('donation_name') as $key => $value)
                            <div>
                                <div class="ads">
                                    <div class="col-12">
                                        <div class="mb-3 row">
                                            <label for="example-number-input">
                                                @lang('charityProject.donation_name')</label>
                                            <div class="col-sm-12">
                                                <input type="text" name="donation_name[]" class="form-control" required value="{{ $value }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="mb-3 row">
                                            <label for="example-number-input">
                                                @lang('charityProject.donation_value')</label>
                                            <div class="col-sm-12">
                                                <input type="number" name="donation_value[]" class="form-control" required value="{{ @old('donation_value')[$key] }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <button class="btn btn-danger delete_ads form-control"><i class="fadeIn animated bx bx-x-circle"></i></button>
                                    </div>
                                    <hr>
                                </div>
                            </div>
                            @endforeach
                            @endif
                        </div>
                        <button type="button" class="btn btn-success form-control btn-sm" id="add_donation_section">
                            <i class="bx bx-plus-medical fs-5"></i>
                        </button>
                    </div>
                    {{-- ------------------ End forms donation_type ------------------- --}}

                    {{-- target_price ------------------------------------------------------------------------------------- --}}
                    <div class="mb-3 mt-3 row">
                        <div class="col-12">
                            <label for="example-number-input" class="col-sm-12 col-form-label">
                                @lang('charityProject.target_price')</label>
                            <div class="col-sm-12">
                                <input class="form-control {{ (empty($errors->first('target_price'))) ?: 'has-error'}}" type="number" id="example-number-input" name="target_price" value="{{ old('target_price') ?? 0 }}">
                                @if ($errors->has('target_price'))
                                <span class="missiong-spam">{{ $errors->first('target_price') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- target_unit   ------------------------------------------------------------------------------------- --}}
                    <div class="col-12">
                        <label class="col-sm-12 col-form-label" for="available">@lang('charityProject.target_unit')
                            :</label>
                        <div class="col-sm-12">
                            <input class="form-control {{ (empty($errors->first('target_unit'))) ?: 'has-error'}}" name="target_unit" type="text" value="{{ old('target_unit') }}">
                            @if ($errors->has('target_unit'))
                            <span class="missiong-spam">{{ $errors->first('target_unit') }}</span>
                            @endif
                        </div>
                    </div>

                    {{-- unit_price  ------------------------------------------------------------------------------------- --}}
                    @foreach ($languages as $key => $locale)
                    <div class="mb-3 row">
                        <label for="example-text-input" class="col-sm-12 col-form-label">{{
                                    trans('charityProject.unit_price_in') . trans('lang.' .
                                    Locale::getDisplayName($locale)) }}</label>
                        <div class="col-sm-12">
                            <input class="form-control {{ (empty($errors->first('unit_price'))) ?: 'has-error'}}" type="text" name="{{ $locale }}[unit_price]" value="{{ old($locale . '.unit_price') }}" id="unit_price{{ $key }}">
                        </div>
                        @if ($errors->has('unit_price'))
                        <span class="missiong-spam">{{ $errors->first($locale . '.unit_price') }}</span>
                        @endif
                    </div>
                    @endforeach

                    {{-- fake_target------------------------------------------------------------------------------------- --}}
                    <div class="col-12">
                        <label class="col-sm-12 col-form-label" for="available">@lang('charityProject.fake_target')</label>
                        <div class="col-sm-12">
                            <input class="form-control {{ (empty($errors->first('fake_target'))) ?: 'has-error'}}" name="fake_target" type="number" value="{{ old('fake_target') ?? 0 }}">
                            @if ($errors->has('fake_target'))
                            <span class="missiong-spam">{{ $errors->first($locale . '.fake_target') }}</span>
                            @endif
                        </div>
                    </div>
                    {{-- --------------Payment Methoed----------------------------- --}}
                    @if(Route::is('admin.charity.single-projects.create'))
                    <div class="row mt-3">
                        <label class="col-sm-12 col-form-label" for="available">
                            @lang('charityProject.payment_method') <span class="text-danger">*</span>
                        </label>
                        <div class="col-sm-10">
                            <div class="form-check">
                                @foreach ($payments as $key => $item)
                                <div class="col-md-6">
                                    <input class="form-check-input" type="checkbox" value="{{ $item->id }}" id="flexCheckDefault{{ $key }}" name="payment_method[]" {{ (in_array($item->id, old('payment_method')??[]))?'checked    ': '' }}>
                                    <label class="form-check-label" for="flexCheckDefault{{ $key }} ">{{
                                                $item->trans->where('locale', $current_lang)->first()->title }}</label>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @if ($errors->has('payment_method'))
                        <span class="missiong-spam">{{ $errors->first('payment_method') }}</span>
                        @endif
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
