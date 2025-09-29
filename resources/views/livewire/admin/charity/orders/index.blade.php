<div>
    <div class="card">
        <div class="card-body">
            {{-- Start Form search --}}
            <div class="card-body  search-group">
                <form wire:submit.prevent="filters">
                    <div class="row" wire:ignore>
                        <div class="col-md-2 mb-3">
                            <input type="text" value="{{ $search_identifier ?? '' }}" wire:model.lazy="search_identifier" placeholder="{{ trans('orders.identifier') }}" class="form-control">
                        </div>
                        <div class="col-md-2 mb-3">
                            <input type="text" value="{{ $search_name ?? '' }}" wire:model.lazy="search_name" placeholder="@lang('contact_us.search_name')" class="form-control">
                        </div>
                        <div class="col-md-2 mb-3">
                            <input type="text" value="{{ $search_email ?? '' }}" wire:model.lazy="search_email" placeholder="@lang('contact_us.search_email')" class="form-control">
                        </div>
                        <div class="col-md-2 ">
                            <input type="text" value="{{ $search_mobile ?? '' }}" wire:model.lazy="search_mobile" placeholder="@lang('contact_us.search_phone')" class="form-control">
                        </div>

                        <div class="col-md-2 ">
                            <select wire:model="search_source" class="form-control">
                                <option value=""> @lang('orders.source') </option>
                                @forelse (App\Enums\SourcesEnum::values() as $source)
                                <option value="{{ $source }}">{{ $source }}</option>
                                @empty
                                @endforelse
                            </select>
                        </div>
                        <div class="col-md-2 ">
                            <select wire:model="search_payment_id" class="form-control">
                                <option value=""> @lang('orders.payment_methods') </option>
                                @forelse ($paymentMethods as $payment)
                                <option value="{{ $payment->id }}">
                                    {{ $payment->trans_ar->title }}
                                </option>
                                @empty
                                @endforelse
                            </select>
                        </div>
                        <div class="col-md-2 ">
                            <select wire:model="search_status_id" class="form-control">
                                <option value=""> @lang('dashboard.order_status') </option>
                                @forelse ($orderStatus as $status)
                                <option value="{{ $status->id }}">
                                    {{ $status->trans_ar->title }}
                                </option>
                                @empty
                                @endforelse
                            </select>
                        </div>

                        <div class="col-md-2 ">
                            <select wire:model="search_status" class="form-control">
                                <option value=""> @lang('admin.status') </option>
                                <option value="1"> @lang('admin.active') </option>
                                <option value="0"> @lang('admin.dis_active') </option>
                            </select>
                        </div>

                        <div class="col-md-2">
                            <input type="number" step="any" wire:model="search_price_from" placeholder="{{ trans('orders.price_from') }}" class="form-control">
                        </div>
                        <div class="col-md-2">
                            <input type="number" step="any" wire:model="search_price_to" placeholder="{{ trans('orders.price_to') }}" class="form-control">
                        </div>

                        <div class="col-md-2">
                            <input type="date" wire:model="search_created_from" placeholder="{{ trans('orders.created_from') }}" class="form-control">
                        </div>
                        <div class="col-md-2">
                            <input type="date" wire:model="search_created_to" placeholder="{{ trans('orders.created_to') }}" class="form-control">
                        </div>
                        <div class="text-end mt-2">
                            <span class="">
                                <button class="btn-info btn-sm btn text-white" type="submit">@lang('admin.search')</button>
                            </span>
                            <span class="">
                                <button class="btn-danger btn-sm btn text-white" wire:click="clearSearch">@lang('admin.delete')</button>
                            </span>
                              <span class="">
                                <button class="btn-success btn-sm btn text-white" wire:click="exportExcel()"> Excel </button>
                            </span>
                        </div>
                        <div class="col-md-2 ">
                            <select wire:model="search_refer" class="form-control">
                                <option value=""> @lang('admin.refer') </option>
                                @forelse ($refers as $refer)
                                <option value="{{ $refer->id }}">
                                    {{ $refer->name }}
                                </option>
                                @empty
                                @endforelse
                            </select>
                        </div>

                    </div>
                </form>
            </div>
        </div>
        {{-- end Form search --}}
    </div>
    @if ($message)
    <div class="alert alert-{{ $msg_type }} alert-dismissible fade show" role="alert">
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>{{ $message }}
    </div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="main-datatable" class="table table-striped table-bordered " style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr class="bluck-actions bulk-action-order" @if (empty($mySelected)) style="display: none" @endif scope="row">
                            <td colspan="16">
                                <div class="col-md-12 mt-0 mb-0 text-center">
                                    <button wire:click.prevent="unpublishSelected" @if (empty($mySelected)) disabled @endif class="btn btn-warning btn-sm my-2" type="submit">@lang('button.pending') </button>
                                    <button wire:click.prevent="publishSelected" @if (empty($mySelected)) disabled @endif class="btn btn-success btn-sm my-2" type="submit">@lang('button.confirmed') </button>
                                    <button wire:click.prevent="waitingSelected" @if (empty($mySelected)) disabled @endif class="btn btn-info  btn-sm my-2" type="submit">@lang('button.waiting') </button>
                                    <button wire:click.prevent="cancelSelected" @if (empty($mySelected)) disabled @endif class="btn btn-primary  btn-sm my-2" type="submit">@lang('button.cancele') </button>
                                    <button wire:click.prevent="deleteSelected" @if (empty($mySelected)) disabled @endif class="btn btn-danger btn-sm my-2" type="submit"> @lang('button.delete')</button>

                                    <div class="btn-group d-inline">
                                        <span class="control-label">@lang('admin.status') : </span>
                                        <select class="btn btn-info btn-xs" style="padding:2px 0px;margin: 0 10px " wire:model="selectOrderStatus">
                                            <option value="">@lang('admin.status')</option>
                                            @forelse ($orderStatus as $status)
                                            <option value="{{ $status->id }}">
                                                {{ $status->trans->where('locale', app()->getLocale())->first()->title }}
                                            </option>
                                            @empty
                                            @endforelse
                                            <option value=""> </option>
                                        </select>
                                    </div>
                                </div>
                            </td>

                        </tr>
                        <tr class="text-center">
                            <th style="width: 1px">
                                <input type="checkbox" id="check-all" wire:model="selectAll">
                            </th>
                            <th>رقم التبرع</th>
                            <th>@lang('orders.identifier') </th>
                            <th>@lang('orders.total') </th>
                            <th>@lang('orders.name') </th>
                            <th>@lang('orders.mobile') </th>
                            <th>@lang('orders.email') </th>
                            <th>@lang('orders.source') </th>
                            <th>@lang('orders.payment_methods') </th>
                            <th>@lang('refer.refers')</th>
                            <th>@lang('admin.status') </th>
                            <th>@lang('admin.created_at') </th>
                            <th>@lang('admin.actions') </th>
                            <th>@lang('refer.details') </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($items as $key => $item)
                        <tr class="text-center">
                            <td>
                                <input type="checkbox" class="checkbox-check" wire:model.ignore="mySelected" value="{{ $item->id }}" {{ in_array($mySelected, [$item->id]) ? 'selected' : '' }}>
                            </td>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->identifier }}</td>
                            <td>{{ $item->total }}</td>
                            <td>{{ $item->full_name }}</td>
                            <td>{{ $item->donor_mobile }}</td>
                        
                            <td>{{ $item->donor_email }}</td>
                            <td>{{ $item->source }}</td>
                            <td>
                                @switch($item->payment_method_id)
                                @case(3)
                                <a href="{{ (getImage($item->banktransferproof)) }}" target="_blank" class="d-block btn btn-outline-primary btn-sm py-0">
                                    {{ $item->payment_method_ar }}
                                    <i class="bx bx-download bx-xs"></i>
                                </a>
                                @break

                                @case(2)
                                <!-- Button trigger modal -->
                                <a type="button" class="d-block btn btn-outline-success btn-sm py-0" data-bs-toggle="modal" data-bs-target="#payment-details{{ $item->id }}">
                                    {{ $item->payment_method_ar }}<i class="bx bx-credit-card bx-xs"></i>
                                </a>
                                <div class="modal fade" id="payment-details{{ $item->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content p-3">
                                            <h4 class="text-center h5">@lang('payment.payment_details')</h4>
                                            @if ($item->payment_proof)
                                            <div class="table-responsive ">
                                                <table class="table table-striped table-bordered" dir="ltr">
                                                    @foreach (json_decode($item->payment_proof) as $index => $payment_proof)
                                                    <tr class="text-end">
                                                        <td>{{ $index }}</td>
                                                        <td>{{ $payment_proof }}</td>
                                                    </tr>
                                                    @endforeach
                                                </table>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                @break

                                @default
                                {{ $item->payment_method_ar }}
                                @endswitch
                            </td>
                            <td>{{ $item->refer }}</td>
                            
                            <td>
                                @if(@$item->status_order_ar)
                                <a data-hover="{{ @$item->status_order_ar }}" class="btn btn-neutral text-info"><i class="bx bxs-info-square bx-tada bx-flip-horizontal"></i></a>
                                @endif
                            </td>
                            <td> {{ date('H:i:s d-m-Y', strtotime($item->created_at)) }} </td>
                            <td>
                                <div class="d-flex justify-content-center bulk-order">
                                    @switch ($item->status)
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
                                    <button type="button" data-hover="@lang('admin.delete')" class="btn btn-neutral text-danger" data-bs-toggle="modal" data-bs-target="#delete{{ $item->id }}">
                                        <i class="bx bxs-trash"></i>
                                    </button>
                                    <div wire:ignore.self class="modal fade" id="delete{{ $item->id }}" tabindex="-1" aria-labelledby="delete{{ $item->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-body">
                                                    <h4 class="swal2-title py-3" id="swal2-title" style="display: flex;"> @lang('admin.are_you_sure')</h4>
                                                    <div class="modal-footer p-1">
                                                        <button type="button" class="btn btn-sm p-1 btn-secondary" data-bs-dismiss="modal">@lang('button.cancel')</button>
                                                        <button type="button" wire:click="delete({{$item->id}})" class="btn btn-sm p-1 btn-danger close-modal" data-bs-dismiss="modal">
                                                            @lang('button.delete')
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </td>
                            <td>
                                @livewire('admin.charity.orders.show', ['order_id' => $item->id], key($item->id))
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <th colspan="12">
                                <div class="alert alert-danger d-flex align-items-center " role="alert">
                                    <div class="text-center">
                                        {{ trans('message.admin.no_date') }}
                                    </div>
                                </div>
                            </th>
                        </tr>
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
