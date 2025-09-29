@extends('admin.app')


@section('title', trans('payment.edit_payment'))
@section('title_page', trans('payment.payment'))
@section('title_route', route('admin.payment-method.index'))
@section('button_page')
    <a href="{{ route('admin.payment-method.index') }}"
        class="ml-3 btn btn-primary waves-effect waves-light">@lang('button.cancel')</a>
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
            <form action="{{ route('admin.payment-method.update', $paymentMethod->id) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-8">
                        @foreach ($languages as $key => $locale)
                            <div class="accordion" id="accordionExampleTitle">
                                <div class="mb-3 border rounded accordion-item">
                                    <h2 class="accordion-header" id="headingTitle{{ $key }}">
                                        <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseTitle{{ $key }}" aria-expanded="true"
                                            aria-controls="collapseTitle">
                                            {{ Locale::getDisplayName($locale) }}
                                        </button>
                                    </h2>
                                    <div id="collapseTitle{{ $key }}" class="accordion-collapse collapse show"
                                        aria-labelledby="headingTitle{{ $key }}"
                                        data-bs-parent="#accordionExampleTitle">
                                        <div class="accordion-body">
                                            {{-- Start  title ------------------------------------------------------------------------------------- --}}
                                            <div class="mb-3 row">
                                                <label for="example-text-input"
                                                    class="col-sm-2 col-form-label">{{ trans('admin.title_in') . Locale::getDisplayName($locale) }}</label>
                                                <div class="col-sm-10">
                                                    <input class="form-control" type="text"
                                                        name="{{ $locale }}[title]"
                                                        value="{{ @$paymentMethod->trans->where('locale', $locale)->first()->title }}"
                                                        id="title{{ $key }}">
                                                </div>
                                                @if ($errors->has($locale . '.title'))
                                                    <span
                                                        class="missiong-spam">{{ $errors->first($locale . '.title') }}</span>
                                                @endif
                                            </div>
                                            {{-- End  title ------------------------------------------------------------------------------------- --}}

                                            {{-- Start content ------------------------------------------------------------------------------------- --}}
                                            <div class="mb-3 row">
                                                <label for="example-text-input" class="col-sm-2 col-form-label">
                                                    @lang('admin.content_in')
                                                    {{ Locale::getDisplayName($locale) }} </label>
                                                <div class="mb-2 col-sm-10">
                                                    <textarea id="content{{ $key }}" name="{{ $locale }}[content]"> {{ @$paymentMethod->trans->where('locale', $locale)->first()->content }} </textarea>
                                                    @if ($errors->has($locale . '.content'))
                                                        <span
                                                            class="missiong-spam">{{ $errors->first($locale . '.content') }}</span>
                                                    @endif
                                                </div>

                                                <script type="text/javascript">
                                                    CKEDITOR.replace('content{{ $key }}', {
                                                        filebrowserUploadUrl: "{{ route('admin.ckeditor.upload', ['_token' => csrf_token()]) }}",
                                                        filebrowserUploadMethod: 'form'
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
                                <h2 class="accordion-header" id="headingBanks">
                                    <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseBanks" aria-expanded="true" aria-controls="collapseBanks">
                                        {{ trans('admin.settings') }}
                                    </button>
                                </h2>
                                <div id="collapseBanks" class="accordion-collapse collapse show"
                                    aria-labelledby="headingBanks" data-bs-parent="#accordionExampleSetting">
                                    <div class="accordion-body">
                                        {{-- min price ------------------------------------------------------------------------------------- --}}
                                        <div class="col-12">
                                            <div class="mb-3 row">
                                                <label for="example-min_price-input" col-form-label>
                                                    @lang('payment.min_price') <span class="text-danger">*</span></label>
                                                <div class="col-sm-12">
                                                    <input class="form-control" type="text"
                                                        placeholder="@lang('payment.min_price')" id="example-min_price-input"
                                                        name="min_price" value="{{ $paymentMethod->min_price }}">
                                                </div>
                                            </div>
                                        </div>
                                        {{-- Payment Key ------------------------------------------------------------------------------------- --}}
                                        <div class="col-12">
                                            <div class="mb-3 row">
                                                <label for="example-text-input" col-form-label>
                                                    @lang('payment.payment_key') <span class="text-danger">*</span></label>
                                                <div class="col-sm-12">
                                                    <input class="form-control" type="text"
                                                        placeholder="@lang('payment.payment_key')" id="example-text-input"
                                                        name="paument_key" value="{{ $paymentMethod->payment_key }}">
                                                </div>
                                            </div>
                                        </div>
                                    {{-- Payment name_holder ------------------------------------------------------------------------------------- --}}
                                    <div class="col-12">
                                        <div class="mb-3 row">
                                            <label for="example-name_holder-input" col-form-label>
                                                @lang('payment.name_holder') <span class="text-danger">*</span></label>
                                            <div class="col-sm-12">
                                                <input class="form-control" type="text" placeholder="@lang('payment.name_holder')" id="example-name_holder-input" name="name_holder" value="{{ $paymentMethod->name_holder }}">
                                            </div>
                                        </div>
                                    </div>
                                        @if ($paymentMethod->image != null)
                                            <div class="col-12">
                                                <div class="mb-3 row">
                                                    <div class="col-sm-12">
                                                        <a href="{{ getImage($paymentMethod->image) }}" target="_blank">
                                                            <img src="{{ asset(getImageThumb($paymentMethod->image)) }}"
                                                                alt="" style="width:25%">
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        {{-- image ------------------------------------------------------------------------------------- --}}
                                        <div class="col-12">
                                            <div class="mb-3 row">
                                                <label for="example-file-input" col-form-label>
                                                    @lang('admin.image')</label>
                                                <div class="col-sm-12">
                                                    <input class="form-control" type="file"
                                                        placeholder="@lang('admin.image')" id="example-number-input"
                                                        name="image" value="{{ old('image') }}">
                                                </div>
                                            </div>
                                        </div>
                                        {{-- cart_show ------------------------------------------------------------------------------------- --}}
                                        <div class="row">
                                            <div class="col-12 mb-3">
                                                <div class="form-check form-switch form-check-success">
                                                    <label class="form-check-label"
                                                        for="flexSwitchCheckSuccesscart_show">@lang('payment.cart_show')</label>
                                                    <input class="form-check-input" type="checkbox" role="switch"
                                                        name="cart_show"
                                                        {{ $paymentMethod->cart_show == 1 ? 'checked' : '' }}
                                                        id="flexSwitchCheckSuccesscart_show">
                                                </div>
                                            </div>
                                        </div>
                                        {{-- Status ------------------------------------------------------------------------------------- --}}
                                        <div class="row">
                                            <div class="col-12 mb-3">
                                                <div class="form-check form-switch form-check-success">
                                                    <label class="form-check-label"
                                                        for="flexSwitchCheckSuccessStatus">@lang('admin.status')</label>
                                                    <input class="form-check-input" type="checkbox" role="switch"
                                                        name="status" {{ $paymentMethod->status == 1 ? 'checked' : '' }}
                                                        id="flexSwitchCheckSuccessStatus">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    @if (count($paymentMethod->banks) > 0 || $paymentMethod->id == 3)
                        @include('admin.dashboard.cms.payment.bank-accounts')
                    @endif

                    <div class="mt-2 mb-3 row text-end">
                        <div>
                            <a href="{{ route('admin.payment-method.index') }}"
                                class="ml-3 btn btn-primary waves-effect waves-light">@lang('button.cancel')</a>
                            <button type="submit"
                                class="ml-3 btn btn-outline-success waves-effect waves-light">@lang('button.save')</button>
                            <button type="submit" name="submit" value="update"
                                class="btn btn-outline-success waves-effect waves-light">@lang('button.save_update')</button>
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

@endsection
