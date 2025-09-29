<div class="info  px-5 bg-white m-md-4">
    <h1 class="fs-6 text-md-end text-center mt-4 pt-5 " dir="rtl">
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

            <div class="d-flex flex-column flex-md-row " dir="rtl">
                <div class="col-md-6 text-center text-md-end col-12">
                    <h1 class="fs-4"> @lang('Orders List') </h1>
                </div>

                <div class="col-md-3 text-center  col-12">
                    <div class="dropdown mx-auto ms-1">
                    
                        <select class="form-control" wire:model="selectedStatus" wire:change="updateSelectStatus">
                            <option value="">@lang('All')</option>
                            <option value="0" {{ '0' == $selectedStatus ? 'selected' : '' }}>@lang('Pending')</option>
                            <option value="1" {{ 1 == $selectedStatus ? 'selected' : '' }}>@lang('Confirmed')</option>
                            <option value="3" {{ 3 == $selectedStatus ? 'selected' : '' }}>@lang('Waiting')</option>
                            <option value="4" {{ 4 == $selectedStatus ? 'selected' : '' }}>@lang('Canceled')</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-3 text-center  col-12">
                    <div class="dropdown mx-auto">
                    
                        <select class="form-control" wire:model="selectedYear" wire:change="updateSelectStatus">
                            <option value="">@lang('All')</option>
                            <option value="{{ Date('Y') - 2 }}" {{ Date('Y') - 2 == $selectedYear ? 'selected' : '' }}> {{ Date('Y') - 2 }} </option>
                            <option value="{{ Date('Y') - 1 }}" {{ Date('Y') - 1  == $selectedYear ? 'selected' : '' }}> {{ Date('Y') - 1 }} </option>
                            <option value="{{ Date('Y') }}" {{ Date('Y') == $selectedYear ? 'selected' : '' }}> {{ Date('Y') }} </option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row mt-3 p-0 mx-0 text-center ">


                <div class="row text-center justify-content-center align-content-center" dir="rtl">

                    @forelse($items as $item)
                        <div class="col-6 col-md-4 text-center">
                            <div class="logo rounded-circle text-center bg-main">
                                <img src="{{ getImage($item->image) }}"  alt=" {{ $item->title }}" class="img-fluid rounded-circle" width="100%">
                            </div>
                            <p class="mt-3 fs-6"> {{ $item->title }} </p>
                            <p class="mt-2 fs-6"> {{ $item->total }} <small style="font-size: 15px;">S.R</small></p>
                        </div>
                    @empty
                    @endforelse


                </div>
            </div>
        </div>
    </div>


</div>
