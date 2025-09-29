<div wire:keydown.escape="keyUp()">
    <i class='bx bx-loader-alt bx-spin bx-sm text-secondary position-fixed top-25 start-50 ' wire:loading></i>
    {{-- <i class='bx bx-loader-alt bx-spin' ></i> --}}
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-info btn-sm py-0" data-bs-toggle="modal" wire:click="toggleModal()" data-bs-target="#order-details{{ $order_id}}">
        @lang('Show')
    </button>
    @if ($show_details)
    <div class="modal fade show" id="order-details{{ $order_id }}" tabindex="-1" role="dialog" aria-modal="true" style="display: block;">
        <div class="modal-dialog modal-xl pt-5" role="document">
            <div class="modal-content mt-5 shadow">
                <div class="modal-header">
                    <h5 class="modal-title py-1" id="modalTitleId">
                        @lang('Order')
                    </h5>
                    <button type="button" class="btn-close float-left" data-bs-dismiss="modal" aria-label="Close" wire:click="toggleModal()"></button>
                </div>

                <div class="modal-body">

                    @php
                    $Orderdetails = $order->details->groupBy('item_type');
                    @endphp

                    <table id="" class="table table-sm table-striped ">
                        <tr>
                            <th>ID</th>
                            <td>{{ $order->id }}</td>
                        </tr>
                        <tr>
                            <th>@lang('orders.identifier') </th>
                            <td>{{ $order->identifier }}</td>
                        </tr>
                        <tr>
                            <th>@lang('orders.total') </th>
                            <td>{{ $order->total }}</td>
                        </tr>
                       
                        <tr>
                            <th>@lang('orders.source') </th>
                            <td>{{ trans($order->source) }}</td>
                        </tr>
                        
                        <tr>
                            <th>@lang('orders.payment_methods') </th>
                            <td>
                                @switch($order->payment_method_id)
                                @case(3)
                                <a href="{{ getImage($order->banktransferproof) }}" target="_blank" class="btn btn-primary btn-sm text-white py-0 p-">
                                    {{ $order->paymentMethod?->trans_ar->title }}
                                    <i class="fa fa-download bx-xs text-white"></i>
                                </a>
                                <span class="btn btn-info btn-sm py-0">{{ @$order->payment_method_key }}</span>
                                @break

                                @case(2)
                                <a>
                                    {{ $order->paymentMethod?->trans_ar->title }}<i class="bx bx-credit-card bx-xs"></i>
                                </a>
                                @break

                                @default
                                {{ $order->paymentMethod?->trans_ar->title }}
                                @endswitch
                            </td>
                        </tr>
                    
                        @if (@isset($Orderdetails['App\Models\Product']))
                        <tr>
                            <th> @lang('admin.shippingStatus') </th>
                            <td>
                                @switch($order->shipping_status)
                                @case('pending')
                                @case('picking')
                                @case('picked')
                                <span class="btn btn-info btn-sm text-white py-0"> {{ $order->shipping_status }} </span>
                                @break

                                @case('delivering')
                                <span class="btn btn-primary btn-sm text-white py-0"> {{ $order->shipping_status }} </span>
                                @break

                                @case('delivered')
                                <span class="btn btn-success btn-sm text-white py-0"> {{ $order->shipping_status }} </span>
                                @break

                                @case('canceled')
                                <span class="btn btn-danger btn-sm text-white py-0"> {{ $order->shipping_status }} </span>
                                @break

                                @default
                                @endswitch
                            </td>
                        </tr>
                        @endif
                        <tr>
                            <th>@lang('admin.created_at') </th>
                            <td> {{ date('H:i:s d-m-Y', strtotime($order->created_at)) }} </td>
                        </tr>
                        <tr>
                            <th>@lang('refer.status') </th>
                            <td>
                                <div class="d-flex justify-content-center bulk-order">
                                    @switch ($order->status)
                                    @case('0')
                                    <a class="btn btn-warning btn-sm order-action" data-toggle="tooltip" title="" data-original-title="@lang('Pending')">
                                        <i class="fa fa-ban text-white"></i>
                                    </a>
                                    @break

                                    @case(1)
                                    <a class="btn btn-success btn-sm  order-action" data-toggle="tooltip" title="" data-original-title="@lang('Confirmed')">
                                        <i class='fa fa-check-circle text-white'></i>
                                    </a>
                                    @break

                                    @case(3)
                                    <a class="btn btn-info btn-sm  order-action" data-toggle="tooltip" title="" data-original-title="@lang('Waiting')" aria-describedby="tooltip358766">
                                        <i class='fa fa-history text-white'></i>
                                    </a>
                                    @break

                                    @case(4)
                                    <a class="btn btn-danger btn-sm  order-action" data-toggle="tooltip" title="" data-original-title="@lang('Canceled')" aria-describedby="tooltip358766">
                                        <i class='fa fa-times-circle text-info'></i>
                                    </a>
                                    @break
                                    @endswitch
                                </div>
                            </td>
                        </tr>

                        @if($order->status == 1)
                        <tr>
                            <th> @lang('admin.invoices') </th>
                            <td>
                                <a href="{{ route("site.invoices",@$order->id ) }}" target="_blank">
                                    <i class='fa fa-file fs-4'></i>
                                </a>
                            </td>
                        </tr>
                        @endif
                    </table>




                    {{-- Project ----------------------------------------------------- --}}
                    @if ( @$Orderdetails['App\Models\CharityProject'] )
                    <div class="row justify-content-center align-items-center ">
                        <div class="col h5">@lang('refer.detailsProjects')</div>
                    </div>

                    <div class="table-responsive-lg table-responsive">
                        <table class="table table-striped table-hover table-bordered table-light align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>@lang('ID')</th>
                                    <th>@lang('type')</th>
                                    <th>@lang('tags.title')</th>
                                    <th> @lang('item_sub_type')</th>
                                    <th> @lang('quantity')</th>
                                    <th> @lang('price')</th>
                                    <th> @lang('Total')</th>
                                    <th> @lang('settings.gift')</th>

                                </tr>

                            </thead>
                            <tbody>
                                @forelse ( $Orderdetails['App\Models\CharityProject'] as $details)
                                @php
                                $giftCard = $details->gift_details != null ? json_decode($details->gift_details) : "";
                                @endphp
                                <tr>
                                    <td>{{ $details->id }}</td>
                                    <td>
                                        <a href="{{ route('site.charity-project.show', @$details->item?->trans->where('locale', $current_lang)->first()->slug) }}" target="_blank">
                                            <img src="{{ getImage(@$details->item->background_image) }}" width="30px" alt="" class="rounded"   style="max-width: 20%">
                                        </a>
                                    </td>
                                    <td>{{ $details->item_name }}</td>
                                    <td>{{ $details->item_sub_type == "Gift Product" ? trans('Gift Product'): $details->item_sub_type }}</td>
                                    <td>{{ $details->quantity }}</td>
                                    <td>{{ $details->price }}</td>
                                    <td>{{ $details->total }}</td>
                                    <td> 
                                        @if(@$giftCard->giver_name)
                                            @if(@$showGift[$details->id] == 0 ) 
                                                <i wire:click="showGiftCart({{ $details->id }})" class='fa fa-plus-square bx-tada bx-flip-horizontal fs-5 text-info'></i>
                                            @elseif(@$showGift[$details->id] == 1 )
                                                <i wire:click="showGiftCart({{ $details->id }})" class='fa fa-minus-square fs-5'></i>
                                            @endif
                                        @endif
                                    </td>
                                </tr>
                                @if(@$showGift[$details->id] == 1)
                                    <tr class="bg-lightBlue">
                                        <td></td>
                                        <td></td>
                                        <td> @lang('gifts.card')</td>
                                        <td> @lang('settings.giver_name')</td>
                                        <td> @lang('settings.giver_mobile')</td>
                                        <td> @lang('settings.giver_email')</td>
                                        <td> @lang('settings.gift_type')</td>
                                    </tr>
                                    <tr class="bg-lightBlue">
                                        <td></td>
                                        <td></td>
                                        <td>
                                            <a href="{{ getImageThumb( @$giftCard->image ) }}" target="_blank">
                                                <img src="{{ getImageThumb( @$giftCard->image ) }}" width="30px" alt="" class="rounded" style="max-width: 20%">
                                            </a>
                                        </td>
                                        <td>{{ @$giftCard->giver_name }}</td>
                                        <td>{{ @$giftCard->giver_mobile }}</td>
                                        <td>{{ @$giftCard->giver_email }}</td>
                                        <td>{{ @$giftCard->cardTitle }}</td>
                                    </tr>
                                @endif
                                </tr>

                                @empty
                                @endforelse
                            </tbody>
                            <tfoot>

                            </tfoot>
                        </table>
                    </div>
                    @endif


                    {{-- Product ----------------------------------------------------- --}}
                    @if (@isset($Orderdetails['App\Models\Product']))
                    <div class="row justify-content-center align-items-center ">
                        <div class="col h5">@lang('refer.detailsProducts')</div>
                    </div>

                    <div class="table-responsive-lg table-responsive">
                        <table class="table table-striped table-hover table-bordered table-light align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th> @lang('ID') </th>
                                    <th> @lang('type') </th>
                                    <th> @lang('tags.title') </th>
                                    <th> @lang('quantity') </th>
                                    <th> @lang('price') </th>
                                    <th> @lang('Total') </th>
                                    <th> @lang('gifts.card') </th>
                                    <th> @lang('settings.giver_name') </th>
                                    <th> @lang('settings.giver_mobile') </th>
                                    <th> @lang('settings.giver_address') </th>
                                    <th> @lang('settings.giver_message') </th>
                                </tr>
                            </thead>
                            <tbody class="">
                                @forelse ( $Orderdetails['App\Models\Product'] as $details)
                                <tr class="">
                                    <td>{{ $details->id }}</td>
                                    <td>
                                        <a href="{{ route('site.charity-product.show', @$details->item->id) }}" target="_blank">
                                            <img src="{{ getImage(@$details->item->cover_image) }}" width="30px" alt="" class="rounded">
                                        </a>

                                    </td>
                                    <td>{{ $details->item_name }}</td>
                                
                                    <td>{{ $details->quantity }}</td>
                                    <td>{{ $details->price }}</td>
                                    <td>{{ $details->total }}</td>
                                    {{-- <td>{{ $details->is_gifts }}</td> --}}
                                    <td>
                                        <img src="{{ getImageThumb(@$details->giver?->card->image) }}" width="30px" alt="" class="rounded">
                                    </td>
                                    <td>{{ @$details->giver->name }}</td>
                                    <td>{{ @$details->giver->mobile }}</td>
                                    <td>{{ @$details->giver->address }}</td>
                                    <td>{{ @$details->giver->message }}</td>
                                </tr>
                                @empty
                                @endforelse
                            </tbody>
                            <tfoot>

                            </tfoot>
                        </table>
                    </div>
                    @endif

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal" wire:click="toggleModal()">
                        @lang('Close')
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
