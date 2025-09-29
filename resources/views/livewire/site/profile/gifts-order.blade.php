<div class="card my-4">
    <div class="card">
        <div class="card-body  search-group">

            <div class="d-flex flex-column flex-md-row">
                <div class="col-md-7 text-center text-md-end col-12 mt-4">
                    <h1 class="fs-4"> @lang('Orders List') </h1>
                </div>
            </div>

            @include('admin.layouts.message')

            <div class="row mt-3">
                <div class="col-md-3 mt-3">
                    <input type="text" wire:model="search_identifier" placeholder="@lang('Identifier')" class="form-control">
                    <select wire:model="search_status" class="form-control mt-2">
                        <option value=""> @lang('admin.status') </option>
                        <option value="1"> @lang('admin.active') </option>
                        <option value="0"> @lang('admin.dis_active') </option>
                    </select>
                </div>
                <div class="col-md-3 mt-3">
                    <input type="text" wire:model="search_title" placeholder="{{ trans('Name') }}" class="form-control">
                    <select class="form-select mt-2" wire:model="search_shipping">
                        <option selected value=""> @lang('settings.shipping_status') </option>
                        @forelse(App\Enums\ShippingStatusEnum::values() as $search_shipping)
                        <option value="{{ $search_shipping }}">{{ trans( $search_shipping) }}</option>
                        @empty
                        @endforelse
                    </select>
                </div>

                <div class="col-md-3 mt-3">
                    <input type="date" wire:model="search_created_from" placeholder="{{ trans('products.created_from') }}" class="form-control">
                    <input type="date" wire:model="search_created_to" placeholder="{{ trans('products.created_to') }}" class="form-control mt-2">
                </div>

            </div>
        </div>

        <div class="row m-5">
            <div class="col-12 col-md-6">
                <div class="card">
                    <div class="card-body text-center">
                        <p class="text-success fw-bold display-6"> @lang('admin.count'): {{ $ordersCount }} </p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="card">
                    <div class="card-body text-center">
                        <p class="text-success fw-bold display-6"> @lang('admin.total'): {{ $totalOrders }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="table-responsive mx-3">
            <table class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                <thead>
                    <tr class="align-content-center ">
                        <th> @lang('ID') </th>
                        <th> @lang('orders.identifier') </th>
                        <th> @lang('type') </th>
                        <th> @lang('tags.title') </th>
                        <th> @lang('quantity') </th>
                        <th> @lang('price') </th>
                        <th> @lang('gifts.card') </th>
                        <th> @lang('settings.giver_name') </th>
                        <th> @lang('settings.giver_mobile') </th>
                        <th> @lang('settings.giver_address') </th>
                        <th> @lang('admin.created_at') </th>
                        <th> @lang('admin.status') </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($orderCarousels as $ind => $carousel)
                    @forelse ($carousel as $key => $details)
                    <tr>
                
                        <td>{{ $details['id'] }}</td>
                        <td>{{ $details['order']['identifier'] }}</td>
                        <td>
                            <a href="{{ route('site.vendors.products.show', @$details['item']['id']) }}" target="_blank">
                                <img src="{{ getImage(@$details['item']['cover_image']) }}" width="30px" alt="" class="rounded">
                            </a>
                        </td>
                        <td> {{ $details['item_name'] }} </td>

                        <td> {{ $details['quantity'] }} </td>
                        <td> {{ $details['price'] }} </td>
                        <td>
                            <img src="{{ getImageThumb(@$details['giver']['card']['image']) }}" width="30px" alt="" class="rounded">
                        </td>
                        <td> {{ @$details['giver']['name'] }} </td>
                        <td> {{ @$details['giver']['mobile'] }} </td>
                 
                        <td class="text-center">
                            @if(@$details['giver']['address'])
                            <i type="button" class="icofont-location-pin text-success" data-bs-toggle="modal" data-bs-target="#location_view_{{ $key }}">
                            </i>
                            <div class="modal fade" id="location_view_{{ $key }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel"> @lang('settings.giver_address') </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            {{ @$details['giver']['address'] }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </td>
                        <td> {{ date('H:i:s d-m-Y', strtotime($details['created_at'])) }} </td>

                        <td>
                            <div class="d-flex justify-content-center bulk-order">
                                @switch ( $details['order']['status'])
                                @case('0')
                                <a class="btn btn-warning btn-sm order-action" data-toggle="tooltip" title="" data-original-title="@lang('Pending')">
                                    <i class="icofont-minus-circle text-white"></i>
                                </a>
                                @break

                                @case(1)
                                <a class="btn btn-success btn-sm  order-action" data-toggle="tooltip" title="" data-original-title="@lang('Confirmed')">
                                    <i class='icofont-check-circled text-white'></i>
                                </a>
                                @break

                                @case(3)
                                <a class="btn btn-info btn-sm  order-action" data-toggle="tooltip" title="" data-original-title="@lang('Waiting')" aria-describedby="tooltip358766">
                                    <i class='icofont-history text-white'></i>
                                </a>
                                @break

                                @case(4)
                                <a class="btn btn-danger btn-sm  order-action" data-toggle="tooltip" title="" data-original-title="@lang('Canceled')" aria-describedby="tooltip358766">
                                    <i class='icofont-close-squared-alt text-info'></i>
                                </a>
                                @break
                                @endswitch
                            </div>
                        </td>
                    
                    </tr>
                    @empty
                    @endforelse
                    @empty
                    @endforelse
                </tbody>
            </table>

            @if ($ordersCount - (count($orderCarousels) * $pageCount) > 0)
            <div class="text-center my-2">
                <button wire:click="showMore" class="btn btn-primary btn-sm mb-3">
                    @lang('More')
                </button>
            </div>
            @endif
        </div>

    </div>
</div>
