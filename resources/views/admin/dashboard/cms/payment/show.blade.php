@extends('admin.app')


@section('title', trans('payment.show_payment'))
@section('title_page', trans('payment.payment'))
@section('title_route', route('admin.payment-method.index') )
@section('button_page')
<a href="{{ route('admin.payment-method.index') }}" class="ml-3 btn btn-primary waves-effect waves-light">@lang('button.cancel')</a>
@endsection



@section('content')

<div class="container-fluid">


    <div class="row">

        <div class="col-md-8 mt-3">

            <div class="card">
                <div class="card-body">
                    @foreach ($languages as $key => $locale)
                    <h4 class="mt-3 card-title text-primary">{{ Locale::getDisplayName($locale) }}</h4>
                    <!-- Nav tabs -->
                    <ul class="mt-3 nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#title{{ $key }}" role="tab">
                                <span class="d-none d-md-block">{{ trans('admin.title') }}</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " data-bs-toggle="tab" href="#content{{ $key }}" role="tab">
                                <span class="d-none d-md-block">@lang('admin.content') </span>
                            </a>
                        </li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div class="p-3 tab-pane active" id="title{{ $key }}" role="tabpanel">
                            <p class="mb-0">
                                {{ @$paymentMethod->trans->where('locale', $locale)->first()->title }}
                            </p>
                        </div>
                        <div class="p-3 tab-pane" id="content{{ $key }}" role="tabpanel">
                            <p class="mb-0">
                                {!! @$paymentMethod->trans->where('locale', $locale)->first()->content !!}
                            </p>
                        </div>
                    </div>
                    @endforeach

                </div>

            </div>
        </div>

        <div class="col-md-4">
            <div class="accordion" id="accordionExample">
                @if ($paymentMethod->image != null)

                <div class="border rounded accordion-item">
                    <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            {{ trans('payment.images') }}
                        </button>
                    </h2>

                    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <div class="row">
                                <div class="col-md-6 col-lg-3">
                                    <div class="p-2 product-list-box card">
                                        <a href="javascript:void(0);">
                                            <a href="{{ getImage($paymentMethod->image) }}" target="_blank">
                                                <img src="{{ getImageThumb($paymentMethod->image) }}" alt="" style="width:100%">
                                            </a>
                                        </a>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                @endif
                <div class="mt-3 border rounded accordion-item">
                    <h2 class="accordion-header" id="headingTwo">
                        <button class="accordion-button collapsed fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            {{ trans('admin.settings') }}
                        </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            @if (@$paymentMethod->createdBy->name != null)
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <label>{{ trans('payment.created_by') }} : <span class="badge rounded-pill bg-success" style="font-size:14px">
                                            {{ @$paymentMethod->createdBy->name }}
                                        </span>
                                    </label>
                                </div>
                            </div>
                            @endif
                            @if (@$paymentMethod->updatedBy->name != null)
                            <div class="row mt-3">
                                <div class="col-md-4">
                                    <label>{{ trans('payment.updated_by') }} </label>
                                </div>
                                <div class="col-md-6">
                                    <span class="badge rounded-pill bg-warning">
                                        {{ @$paymentMethod->updatedBy->name }}
                                    </span>
                                </div>
                            </div>
                            @endif
                            <div class="row mt-3">
                                <div class="col-md-4">
                                    <label for="example-min_price-input" class="col-sm-12 col-form-label">
                                        @lang('payment.min_price') 
                                    </label>
                                </div>
                                <div class="col-sm-6">
                                    <input class="form-control" type="text" placeholder="@lang('payment.min_price')" readonly disabled name="min_price" value="{{ $paymentMethod->min_price }}">
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-4">
                                    <label for="example-number-input" class="col-sm-12 col-form-label">
                                        @lang('payment.payment_key') 
                                    </label>
                                </div>
                                <div class="col-sm-6">
                                    <input class="form-control" type="text" placeholder="@lang('payment.payment_key')" readonly disabled name="paument_key" value="{{ $paymentMethod->payment_key }}">
                                </div>
                            </div>
                            <div class="row mt-3">
                                {{-- news_ticker ------------------------------------------------------------------------------------- --}}
                                <div class="col-4">
                                    <label class="col-sm-12 col-form-label" for="available">{{ trans('admin.news_ticker') }}</label>
                                </div>
                                <div class="col-sm-6">
                                    @if ($paymentMethod->news_ticker == 1)
                                    <p class="badge rounded-pill bg-success" style="font-size:14px">
                                        @lang('admin.yes')</p>
                                    @else
                                    <p class="badge rounded-pill bg-danger" style="font-size:14px">
                                        @lang('admin.no')</p>
                                    @endif
                                </div>
                            </div>
                            <div class="row mt-3">
                                {{-- Status ------------------------------------------------------------------------------------- --}}
                                <div class="col-4">
                                    <label class="col-sm-12 col-form-label" for="available">{{ trans('admin.status') }}</label>
                                </div>
                                <div class="col-sm-6">
                                    @if ($paymentMethod->status == 1)
                                    <p class="badge bg-success" style="font-size:14px">
                                        @lang('admin.active')</p>
                                    @else
                                    <p class="badge bg-danger" style="font-size:14px">
                                        @lang('admin.dis_active')</p>
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

</div> <!-- container-fluid -->

@endsection


@section('script')

{{-- @vite(['resources/assets/admin/js/data-tables.js']) --}}
@endsection
