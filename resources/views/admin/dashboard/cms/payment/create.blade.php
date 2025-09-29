@extends('admin.app')

@section('title', trans('payment.create_payment'))
@section('title_page', trans('payment.payment'))
@section('title_route', route('admin.payment-method.index'))
@section('button_page')
<a href="{{ route('admin.payment-method.index') }}" class="ml-3 btn btn-primary waves-effect waves-light">@lang('button.cancel')</a>
@endsection
<style>
    .tableList {
        list-style-type: none;
        padding-bottom: 10px;
        margin: 0;
        display: flex;
    }

    .tabelItemList {
        margin-right: 10px;
        font-weight: bold;
    }

</style>
@section('content')


<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.payment-method.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-8">
                    @foreach ($languages as $key => $locale)
                    <div class="accordion" id="accordionExampleTitle{{ $key }}">
                        <div class="mb-3 border rounded accordion-item">
                            <h2 class="accordion-header" id="headingTitle{{ $key }}">
                                <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTitle{{ $key }}" aria-expanded="true" aria-controls="collapseTitle">
                                    {{ Locale::getDisplayName($locale) }}
                                </button>
                            </h2>
                            <div id="collapseTitle{{ $key }}" class="accordion-collapse collapse show" aria-labelledby="headingTitle{{ $key }}" data-bs-parent="#accordionExampleTitle{{ $key }}">
                                <div class="accordion-body">
                                    {{-- Start  title ------------------------------------------------------------------------------------- --}}
                                    <div class="mb-3 row">
                                        <label for="example-text-input" class="col-sm-12 col-form-label">{{ trans('admin.title_in') . Locale::getDisplayName($locale) }}</label>
                                        <div class="col-sm-12">
                                            <input class="form-control" type="text" name="{{ $locale }}[title]" value="{{ old($locale . '.title') }}" id="title{{ $key }}">
                                        </div>
                                        @if ($errors->has($locale . '.title'))
                                        <span class="missiong-spam">{{ $errors->first($locale . '.title') }}</span>
                                        @endif
                                    </div>
                                    {{-- End  title ------------------------------------------------------------------------------------- --}}

                                    {{-- Start content ------------------------------------------------------------------------------------- --}}
                                    <div class="mb-3 row">
                                        <label for="example-text-input" class="col-sm-12 col-form-label">
                                            @lang('admin.content_in')
                                            {{ Locale::getDisplayName($locale) }} </label>
                                        <div class="mb-2 col-sm-12">
                                            <textarea id="content{{ $key }}" name="{{ $locale }}[content]"> {{ old($locale . '.content') }} </textarea>
                                            @if ($errors->has($locale . '.content'))
                                            <span class="missiong-spam">{{ $errors->first($locale . '.content') }}</span>
                                            @endif
                                        </div>

                                        <script type="text/javascript">
                                            CKEDITOR.replace('content{{ $key }}', {
                                                filebrowserUploadUrl: "{{ route('admin.ckeditor.upload', ['_token' => csrf_token()]) }}"
                                                , filebrowserUploadMethod: 'form'
                                            });

                                        </script>
                                    </div>
                                    {{-- end content ------------------------------------------------------------------------------------- --}}

                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="col-md-4">
                    <div class="accordion" id="accordionExampleSetting">
                        <div class="border rounded accordion-item">
                            <h2 class="accordion-header" id="headingSetting">
                                <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSetting" aria-expanded="true" aria-controls="collapseSetting">
                                    {{ trans('admin.settings') }}
                                </button>
                            </h2>
                            <div id="collapseSetting" class="accordion-collapse collapse show" aria-labelledby="headingSetting" data-bs-parent="#accordionExampleSetting">
                                <div class="accordion-body">
                                    {{-- min price  ------------------------------------------------------------------------------------- --}}
                                    <div class="col-12">
                                        <div class="mb-3 row">
                                            <label for="example-min_price-input" col-form-label>
                                                @lang('payment.min_price') <span class="text-danger">*</span></label>
                                            <div class="col-sm-12">
                                                <input class="form-control" type="text" placeholder="@lang('payment.min_price')" id="example-min_price-input" name="min_price" value="{{ old('min_price') }}">
                                            </div>
                                        </div>
                                    </div>
                                    {{-- Payment Key ------------------------------------------------------------------------------------- --}}
                                    <div class="col-12">
                                        <div class="mb-3 row">
                                            <label for="example-text-input" col-form-label>
                                                @lang('payment.payment_key') <span class="text-danger">*</span></label>
                                            <div class="col-sm-12">
                                                <input class="form-control" type="text" placeholder="@lang('payment.payment_key')" id="example-text-input" name="payment_key" value="{{ old('payment_key') }}">
                                            </div>
                                        </div>
                                    </div>
                                    {{-- Payment name_holder ------------------------------------------------------------------------------------- --}}
                                    <div class="col-12">
                                        <div class="mb-3 row">
                                            <label for="example-name_holder-input" col-form-label>
                                                @lang('payment.name_holder') <span class="text-danger">*</span></label>
                                            <div class="col-sm-12">
                                                <input class="form-control" type="text" placeholder="@lang('payment.name_holder')" id="example-name_holder-input" name="name_holder" value="{{ old('name_holder') }}">
                                            </div>
                                        </div>
                                    </div>
                                    {{-- image ------------------------------------------------------------------------------------- --}}
                                    <div class="col-12">
                                        <div class="mb-3 row">
                                            <label for="example-file-input" col-form-label>
                                                @lang('admin.image')
                                            </label>
                                            <div class="col-sm-12">
                                                <input class="form-control" type="file" placeholder="@lang('admin.image')" id="example-file-input" name="image" value="{{ old('image') }}">
                                            </div>
                                        </div>
                                    </div>
                                    {{-- cart_show ------------------------------------------------------------------------------------- --}}
                                    <div class="row">
                                        <div class="col-12 mb-3">
                                            <div class="form-check form-switch form-check-success">
                                                <label class="form-check-label" for="flexSwitchCheckSuccessCart">@lang('payment.cart_show')</label>
                                                <input class="form-check-input" type="checkbox" role="switch" name="cart_show" {{ request('cart_show') == 1 ? 'checked' : '' }} id="flexSwitchCheckSuccessCart">
                                            </div>
                                        </div>
                                    </div>
                                    {{-- Status ------------------------------------------------------------------------------------- --}}
                                    <div class="row">
                                        <div class="col-12 mb-3">
                                            <div class="form-check form-switch form-check-success">
                                                <label class="form-check-label" for="flexSwitchCheckSuccessStatus">@lang('admin.status')</label>
                                                <input class="form-check-input" type="checkbox" role="switch" name="status" {{ request('status') == 1 ? 'checked' : '' }} id="flexSwitchCheckSuccessStatus">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="accordion" id="accordionExampleSetting">
                        <div class="border rounded accordion-item">
                            <h2 class="accordion-header" id="headingSetting">
                                <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSetting" aria-expanded="true" aria-controls="collapseSetting">
                                    {{ trans('payment.banks') }}
                                </button>
                            </h2>
                            <div id="collapseSetting" class="accordion-collapse collapse show" aria-labelledby="headingSetting" data-bs-parent="#accordionExampleSetting">
                                <div class="accordion-body">
                                    {{-- min price  ------------------------------------------------------------------------------------- --}}
                                    <div class="col-12">
                                        <div class="mb-3 row">
                                            <div id="collapseOne3" class="accordion-collapse collapse show mt-3" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    <div class="row">
                                                        <ul class="tableList">
                                                            <li class="col-md-2 position_center tabelItemList">
                                                                {{ __('payment.bank_name') }}</li>
                                                            <li class="col-md-2 position_center tabelItemList">
                                                                {{ __('payment.account_type') }}</li>
                                                            <li class="col-md-2 position_center tabelItemList">
                                                                {{ __('payment.iban') }}</li>
                                                            <li class="col-md-2 position_center tabelItemList">
                                                                {{ __('payment.payment_key') }}</li>
                                                            <li class="col-md-2 position_center tabelItemList">
                                                                {{ __('payment.bank_url') }}</li>
                                                            <li class="col-md-2 position_center tabelItemList">
                                                                {{ __('payment.image') }}</li>
                                                        </ul>
                                                        <div class="col-md-12" id="repeater">
                                                            <div class="clearfix"></div>
                                                            <!-- Repeater Items -->
                                                            <div class="items" data-group="banksList">
                                                                <!-- Repeater Content -->
                                                                <div class="col-md-12">
                                                                    <div class="item-content">
                                                                        <div class="row">
                                                                            <div class="col-md-2">
                                                                                <input type="text" class="form-control" data-name="bank_name" placeholder="{{ __('payment.bank_name') }}">
                                                                            </div>
                                                                            <div class="col-md-2">
                                                                                <input type="text" class="form-control" data-name="account_type" placeholder="{{ __('payment.account_type') }}">
                                                                            </div>
                                                                            <div class="col-md-2">
                                                                                <input type="text" class="form-control" data-name="iban" placeholder="{{ __('payment.iban') }}">
                                                                            </div>
                                                                            <div class="col-md-2">
                                                                                <input type="text" class="form-control" data-name="payment_key" placeholder="{{ __('payment.payment_key') }}">
                                                                            </div>
                                                                            <div class="col-md-2">
                                                                                <input type="text" class="form-control" data-name="bank_url" placeholder="{{ __('payment.bank_url') }}">
                                                                            </div>
                                                                            <div class="col-md-2">
                                                                                <input type="file" class="form-control" data-name="image">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- Repeater Remove Btn -->
                                                                <div class="pull-right repeater-remove-btn mt-2">
                                                                    <button class="btn btn-danger remove-btn">
                                                                        @lang('admin.delete')</button>
                                                                </div>
                                                                <hr>
                                                                <div class="clearfix"></div>
                                                            </div>
                                                        </div>
                                                        <!-- Repeater Heading -->
                                                        <div class="repeater-heading mt-4">
                                                            <div class="col-md-12">
                                                                <button type="button" class="btn btn-success form-control pull-right repeater-add-btn" id="buttons" id="donors_address">
                                                                    <i class="bx bx-plus"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-2 mb-3 row text-end">
                    <div>
                        <a href="{{ route('admin.payment-method.index') }}" class="ml-3 btn btn-primary waves-effect waves-light">@lang('button.cancel')</a>
                        <button type="submit" class="ml-3 btn btn-outline-success waves-effect waves-light">@lang('button.save')</button>
                        <button type="submit" name="submit" value="new" id="submit" class="btn btn-outline-success waves-effect waves-light">@lang('button.save_new')</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection


@section('style')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="{{ asset('site/js/ckeditor/ckeditor.js') }}"></script>
<script src="{{ asset('tell/intlTelInput.js') }}"></script>
@endsection
