<div class="div">
    <!--edit section -->
    <div class="table bg-white border-main">
        <div class="info  m-md-4">
            <h1 class="fs-6 text-md-end text-center mt-4 pt-5" dir="rtl">
                @lang('Statistics')
            </h1>

            <div class="numbers row py-2" dir="rtl">
                <div class="numerOfdonamtion col-md-5 col-12 me-1 bg-main rounded-3 text-center">
                    <h1 class="fs-1 mt-3"> {{ $ordersCount }} </h1>
                    <p class="fs-4" dir="rtl"> @lang('Number of donates') </p>
                </div>

                <div class="col-1">
                    <!--extra div-->
                </div>

                <div class="totalAmount col-md-5 col-12 mt-3 mt-md-0 bg-main rounded-3 text-center">
                    <h1 class="fs-1 mt-3"> {{ $totalOrders }} </h1>
                    <p class="fs-4" dir="rtl"> @lang('Total Amount') </p>
                </div>
            </div>

            <hr class="spater my-2" />

            <div class="donation">
                <div class="px-0 mx-0">

                    <div class="d-flex flex-column flex-md-row" dir="rtl">
                        <div class="col-md-7 text-center text-md-end col-12">
                            <h1 class="fs-4"> @lang('Orders List') </h1>
                        </div>

                        <div class=" row col-md-3 text-center col-12">
                            <div class=" col-6 dropdown mx-auto">
                                <select class="form-control" wire:model="selectedStatus"
                                    wire:change="updateSelectStatus">
                                    <option value="">@lang('All')</option>
                                    <option value="0" {{ '0' == $selectedStatus ? 'selected' : '' }}>
                                        @lang('Pending')</option>
                                    <option value="1" {{ 1 == $selectedStatus ? 'selected' : '' }}>
                                        @lang('Confirmed')</option>
                                    <option value="3" {{ 3 == $selectedStatus ? 'selected' : '' }}>
                                        @lang('Waiting')</option>
                                    <option value="4" {{ 4 == $selectedStatus ? 'selected' : '' }}>
                                        @lang('Canceled')</option>
                                </select>
                            </div>

                        </div>
                        <select class="form-control" wire:model="selectedRefer" wire:change="updateSelectRefer">
                            <option value="All"> @lang('All') </option>
                            @foreach ($refersList as $ref)
                                <option value="{{ $ref['id'] }}"> {{ $ref['name'] ?? ($ref['employee_name'] ?? 'Refer #' . $ref['id']) }} </option>
                            @endforeach
                        </select>
                    </div>

                    <!--Table itSelf-->
                    <div class="row mt-3 p-0 mx-0 text-center mb-2" dir="rtl">

                        <table
                            class="col-12 shadow table text-center align-content-center table-striped table-bordered">
                            <thead>
                                <tr class="align-content-center ">
                                    <th scope="col " dir="rtl"> @lang('Identifier') </th>
                                    <th scope="col" dir="rtl"> @lang('Quantity') </th>
                                    <th scope="col" dir="rtl"> @lang('Total') </th>
                                    <th scope="col" dir="rtl"> @lang('Referer') </th>
                                    {{-- <th scope="col" dir="rtl"> @lang('Projects') </th> --}}
                                    <th scope="col" dir="rtl"> @lang('Payment Method') </th>
                                    <th scope="col" dir="rtl"> @lang('Donation date') </th>
                                    <th scope="col" dir="rtl"> @lang('Order Status') </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($orderCarousels as $key => $carousel)
                                    @forelse ($carousel as $key => $order)
                                        <tr>
                                            <th scope="row">{{ $order['identifier'] }}</th>
                                            <td>{{ $order['quantity'] }}</td>
                                            <td>{{ $order['total'] }}</td>
                                            <td>{{ $order['refer'] }}</td>
                                            {{-- <td>test1</td> --}}
                                            <td>{{ $order['payment_method_' . app()->getLocale()] }}</td>
                                            <td>{{ date('H:i:s d-m-Y', strtotime($order['created_at'])) }} </td>
                                            <td dir="rtl" class="text-center  ">
                                                <x-icofont-link status="{{ $order['status'] }}" />
                                            </td>
                                            <td>
                                                @livewire('site.refer.orders-items', ['order_id' => $order['id']], key($order['id']))
                                            </td>
                                        </tr>
                                    @empty
                                    @endforelse
                                @empty
                                @endforelse

                            </tbody>
                        </table>
                    </div>
                    <!--Table itSelf-->
                </div>
            </div>
            @if ($ordersCount - count($orderCarousels) * $pageCount > 0)
                <div class="text-center my-2">
                    <button wire:click="showMore" class="btn text-black btn-primary btn-sm mb-3">
                        @lang('More')
                    </button>
                </div>
            @endif

        </div>
    </div>
    <!--edit section -->
</div>
