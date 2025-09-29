<div wire:keydown.escape="keyUp()">
    <i class='bx bx-loader-alt bx-spin bx-sm text-secondary position-fixed top-25 start-50 ' wire:loading></i>
    {{-- <i class='bx bx-loader-alt bx-spin' ></i> --}}
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary btn-sm py-0" data-bs-toggle="modal" wire:click="toggleModal()"
        data-bs-target="#order-details{{ $order_id }}">
        @lang('Show')
    </button>
    @if ($show_details && $order)
        <div class="modal fade show" id="order-details{{ $order_id }}" tabindex="-1" role="dialog" aria-modal="true"
            style="display: block;">
            <div class="modal-dialog modal-xl pt-5" role="document">
                <div class="modal-content mt-5 shadow">


                    <div class="modal-body">

                        @php
                            $Orderdetails = $order->details->groupBy('item_type');
                        @endphp


                        {{-- Project ----------------------------------------------------- --}}
                        @if (@$Orderdetails['App\Models\CharityProject'])
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
                                        @forelse ($Orderdetails['App\Models\CharityProject'] as $details)
                                            @php
                                                $giftCard =
                                                    $details->gift_details != null
                                                        ? json_decode($details->gift_details)
                                                        : '';
                                            @endphp
                                            <tr>
                                                <td>{{ $details->id }}</td>
                                                <td>
                                                    <a href="{{ route('site.charity-project.show', @$details->item?->trans->where('locale', $current_lang)->first()->slug) }}"
                                                        target="_blank">
                                                        <img src="{{ getImage(@$details->item->background_image) }}"
                                                            width="30px" alt="" class="rounded">
                                                    </a>
                                                </td>
                                                <td>{{ $details->item_name }}</td>
                                                <td>{{ $details->item_sub_type == 'Gift Product' ? trans('Gift Product') : $details->item_sub_type }}
                                                </td>
                                                <td>{{ $details->quantity }}</td>
                                                <td>{{ $details->price }}</td>
                                                <td>{{ $details->total }}</td>
                                                <td>
                                                    @if (@$giftCard->giver_name)
                                                        @if (@$showGift[$details->id] == 0)
                                                            <i wire:click="showGiftCart({{ $details->id }})"
                                                                class='bx bxs-plus-square bx-tada bx-flip-horizontal fs-3 text-info'></i>
                                                        @elseif(@$showGift[$details->id] == 1)
                                                            <i wire:click="showGiftCart({{ $details->id }})"
                                                                class='bx bxs-minus-square  fs-3'></i>
                                                        @endif
                                                    @endif
                                                </td>
                                            </tr>
                                            @if (@$showGift[$details->id] == 1)
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
                                                        <a href="{{ getImageThumb(@$giftCard->image) }}"
                                                            target="_blank">
                                                            <img src="{{ getImageThumb(@$giftCard->image) }}"
                                                                width="30px" alt="" class="rounded">
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
                                            <th> @lang('item_sub_type') </th>
                                            <th> @lang('Vendor') </th>
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
                                        @forelse ($Orderdetails['App\Models\Product'] as $details)
                                            <tr class="">
                                                <td>{{ $details->id }}</td>
                                                <td>
                                                    <a href="{{ route('admin.eccommerce.products.show', @$details->item->id) }}"
                                                        target="_blank">
                                                        <img src="{{ getImage(@$details->item->cover_image) }}"
                                                            width="30px" alt="" class="rounded">
                                                    </a>

                                                </td>
                                                <td>{{ $details->item_name }}</td>
                                                <td>{{ $details->item_sub_type == 'Gift Product' ? trans('Gift Product') : $details->item_sub_type }}
                                                </td>
                                                <td>
                                                    <a href="{{ route('admin.eccommerce.vendors.show', $details->item->vendor?->id ?? 0) }}"
                                                        target="_blank">
                                                        {{ @$details->vendor ? @$details->vendor->trans?->where('locale', $current_lang)->first()->title : @$details->item->vendor?->trans?->where('locale', $current_lang)->first()->title }}
                                                    </a>
                                                </td>
                                                <td>{{ $details->quantity }}</td>
                                                <td>{{ $details->price }}</td>
                                                <td>{{ $details->total }}</td>
                                                {{-- <td>{{ $details->is_gifts }}</td> --}}
                                                <td>
                                                    <a href="{{ route('admin.gifts.cards.show', @$details->giver?->card->id ?? 0) }}"
                                                        target="_blank">
                                                        <img src="{{ getImageThumb(@$details->giver?->card->image) }}"
                                                            width="30px" alt="" class="rounded">
                                                    </a>
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
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal"
                            wire:click="toggleModal()">
                            @lang('Close')
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @elseif ($show_details && !$order)
        <div class="modal fade show" id="order-details{{ $order_id }}" tabindex="-1" role="dialog"
            aria-modal="true" style="display: block;">
            <div class="modal-dialog modal-xl pt-5" role="document">
                <div class="modal-content mt-5 shadow">
                    <div class="modal-header">
                        <h5 class="modal-title py-1" id="modalTitleId">
                            @lang('Order')
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                            wire:click="toggleModal()"></button>
                    </div>

                    <div class="modal-body">
                        <div class="alert alert-info">
                            @lang('No orders found for this donor')
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal"
                            wire:click="toggleModal()">
                            @lang('Close')
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
