<div>
    <div class="card">
        <div class="card-body">
            {{-- Start Form search --}}
            <div class="card-body  search-group">
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
                        <input type="text" wire:model="search_title" class="form-control"  placeholder="@lang('Name')" >
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

                    <div class="col-md-3 mt-3">
                        <select wire:model="search_vendor" class="form-control mt-2">
                            <option value=""> @lang('vendor.vendor') </option>
                            @forelse($vendors as $key => $vendor)
                                <option value="{{ $vendor->id }}"> {{ $vendor->responsible_person }} </option>
                            @empty
                            @endforelse
                        </select>
                    </div>

                </div>
            </div>
        </div>
        {{-- end Form search --}}
    </div>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="card">
                        <div class="card-body text-center">
                            <p class="text-success fw-bold display-6"> @lang('admin.count'): {{ $order_number }} </p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="card">
                        <div class="card-body text-center">
                            <p class="text-success fw-bold display-6"> @lang('admin.total'): {{ $order_total }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table id="main-datatable" class="table table-striped table-bordered " style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr class="align-content-center ">
                            <th> # </th>
                            <th> @lang('ID') </th>
                            <th>@lang('vendor.vendor') </th>
                            <th> @lang('orders.identifier') </th>
                            <th> @lang('type') </th>
                            <th> @lang('tags.title') </th>
                            <th> @lang('quantity') </th>
                            <th> @lang('price') </th>
                            <th> @lang('gifts.card') </th>
                            <th> @lang('settings.giver_name') </th>
                            <th> @lang('settings.giver_mobile') </th>
                            <th> @lang('settings.giver_address') </th>
                            {{-- <th> @lang('settings.giver_message') </th> --}}
                            <th> @lang('admin.created_at') </th>
                            <th> @lang('admin.review') </th>
                            <th> @lang('admin.status') </th>
                            <th> @lang('settings.shipping_status') </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($items as $key => $item)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $item->id }}</td>
                            <td>
                                <a href="{{ route('admin.eccommerce.vendors.show', @$item->vendor->id) }}" target="_blank">
                                    {{ @$item->vendor->responsible_person }}
                                </a> 
                            </td>
                            <td>{{ $item->order->identifier }}</td>
                            <td>
                                <a href="{{ route('site.vendors.products.show', @$item->item->id) }}" target="_blank">
                                    <img src="{{ getImage(@$item->item->cover_image) }}" width="30px" alt="" class="rounded">
                                </a>
                            </td>
                            <td> {{ $item->item_name }} </td>

                            <td> {{ $item->quantity }} </td>
                            <td> {{ $item->price }} </td>
                            <td>
                                <img src="{{ getImageThumb(@$item->giver->card->image) }}" width="30px" alt="" class="rounded">
                            </td>
                            <td> {{ @$item->giver->name }} </td>
                            <td> {{ @$item->giver->mobile }} </td>
                            <td class="text-center">
                                @if(@$item->giver->address)
                                <i type="button" class="bx bx-map h4" data-bs-toggle="modal" data-bs-target="#location_view_{{ $key }}">
                                </i>
                                <div class="modal fade" id="location_view_{{ $key }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel"> @lang('settings.giver_address') </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                {{ @$item->giver->address }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif

                            </td>

                            <td> {{ @$item->created_at }} </td>

                            <td class="text-center">
                                @if( @$item->rate )
                                <p type="button" class="star-rating" data-bs-toggle="modal" data-bs-target="#review_{{ $key }}">
                                    {{ str_repeat('★', @$item->rate) }}
                                </p>
                                <div class="modal fade" id="review_{{ $key }}" tabindex="-1" aria-labelledby="exampleModalReview" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel"> @lang('admin.review') </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                               <p> <span class="star-rating"> {{ str_repeat('★', @$item->rate) }} </span></p>
                                               <p> التعليق :  {{ @$item->review }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </td>

                            <td>
                                <div class="d-flex justify-content-center bulk-order">
                                    @switch (@$item->order->status)
                                    @case('0')
                                    <a data-hover="@lang('Pending')" class="btn btn-neutral text-warning order-action" data-toggle="tooltip" title="" data-original-title="@lang('Pending')">
                                        <i class="bx bx-no-entry"></i>
                                    </a>
                                    @break

                                    @case(1)
                                    <a data-hover="@lang('Confirmed')" class="btn btn-neutral text-success order-action" data-toggle="tooltip" title="" data-original-title="@lang('Confirmed')">
                                        <i class='bx bx-check-circle'></i>
                                    </a>
                                    @break

                                    @case(3)
                                    <a data-hover="@lang('Waiting')" class="btn btn-neutral text-info order-action" data-toggle="tooltip" title="" data-original-title="@lang('Waiting')" aria-describedby="tooltip358766">
                                        <i class='bx bx-history'></i>
                                    </a>
                                    @break

                                    @case(4)
                                    <a data-hover="@lang('Canceled')" class="btn btn-neutral text-danger order-action" data-toggle="tooltip" title="" data-original-title="@lang('Canceled')" aria-describedby="tooltip358766">
                                        <i class='bx bx-window-close'></i>
                                    </a>
                                    @break
                                    @endswitch
                            </td>
                            <td>
                                <select class="form-control" wire:change="changeShippingStatus({{ $item->id }}, $event.target.value )">
                                    @forelse(App\Enums\ShippingStatusEnum::values() as $status)
                                    <option value="{{ $status }}" @if( $item->shipping_status == $status) selected @endif>
                                        {{ trans( $status) }}
                                    </option>
                                    @empty
                                    @endforelse
                                </select>
                            </td>
                           
                        </tr>
                        @empty
                        @endforelse
                       
                    </tbody>
                </table>
            </div>
            <div class="col-md-12 text-center mt-3">
                {{ $links->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
