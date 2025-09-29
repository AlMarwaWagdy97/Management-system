@extends('admin.app')

@section('title', trans('dashboard.dashboard'))

@section('content')


{{-- filter -------------------------------------------------------------------------------------------------------------------- --}}
@php 
 $search = request('start_date') != null || request('end_date') != null || request('order_status') != null;
@endphp
<div class="row mb-3 ">
    <div class="accordion accordion-flush" id="accordionExample">
        <div class="accordion-item">
            <h2 class="accordion-header" id="accordionFlushExample">
                <button class="accordion-button @if(!$search) collapsed @endif" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFilter" aria-expanded="false" aria-controls="collapseFilter">
                    @lang('dashboard.filter')
                </button>
            </h2>
            <div id="collapseFilter" class="accordion-collapse collapse @if($search) show @endif" aria-labelledby="headingFilter" data-bs-parent="#accordionFlushExample">
                <div class="accordion-body">
                    <form action="{{ route('admin.home') }}">
                        <div class="row my-3">
                            <div class="col-12 col-md-3">
                                <label for="start_date"> @lang('dashboard.start_date') </label>
                                <input type="date" name="start_date" value="{{ request('start_date') }}" class="form-control">
                            </div>
                            <div class="col-12 col-md-3">
                                <label for="start_date"> @lang('dashboard.end_date') </label>
                                <input type="date" name="end_date" value="{{ request('end_date') }}" class="form-control">
                            </div>
                            <div class="col-12 col-md-3">
                                <label for="start_date"> @lang('dashboard.order_status') </label>
                                <select class="form-control" name="order_status" value="{{ request('order_status') }}">
                                    <option value="">@lang('All')</option>
                                    <option value="0" {{ '0' ==  request('order_status') ? 'selected' : '' }}>@lang('Pending')</option>
                                    <option value="1" {{ 1 ==  request('order_status') ? 'selected' : '' }}>@lang('Confirmed')</option>
                                    <option value="3" {{ 3 ==  request('order_status') ? 'selected' : '' }}>@lang('Waiting')</option>
                                    <option value="4" {{ 4 ==  request('order_status') ? 'selected' : '' }}>@lang('Canceled')</option>
                                </select>
                            </div>
                            <div class="col-12 col-md-3">
                                <button type="submit" class="btn btn-primary btn-sm mt-4">@lang('button.save')</button>
                                <a href="{{ route('admin.home') }}" class="btn btn-danger btn-sm mt-4" data-hover="@lang('button.reset')"> <i class="bx bx-refresh"></i> </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Multi-Store Statistics -------------------------------------------------------------------------------------------------------------------- --}}
@if(isset($multiStoreStats) && $multiStoreStats['stores_count'] > 0)
<div class="row mb-3">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">@lang('dashboard.multi_store_statistics')</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="text-center">
                            <h3 class="text-primary">{{ $multiStoreStats['total_orders'] }}</h3>
                            <p class="text-muted">@lang('dashboard.total_orders')</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-center">
                            <h3 class="text-success">{{ number_format($multiStoreStats['total_amount'], 2) }} @lang('dashboard.currency')</h3>
                            <p class="text-muted">@lang('dashboard.total_amount')</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-center">
                            <h3 class="text-warning">{{ $multiStoreStats['stores_count'] }}</h3>
                            <p class="text-muted">@lang('dashboard.stores_count')</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Stores Details Table --}}
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">@lang('dashboard.stores_details')</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>@lang('dashboard.store_name')</th>
                                <th>@lang('dashboard.orders_count')</th>
                                <th>@lang('dashboard.orders_total')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($multiStoreStats['stores_details'] as $store)
                            <tr>
                                <td>{{ $store['store_name'] }}</td>
                                <td>{{ $store['orders_count'] }}</td>
                                <td>{{ number_format($store['orders_total'], 2) }} @lang('dashboard.currency')</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center">@lang('dashboard.no_data_available')</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

@endsection
