@extends('site.app')

@section('content')
<div class="container mt-4">
    <div class="text-center">
        <h2 class="my-5"> تتبع الطلب </h2>
    </div>
    <div class="row">
        <div class="col-lg-12 my-lg-0 my-1">
            <div id="main-content" class="bg-white border">
                <div class="text-uppercase"> رقم العملية : #{{ $order->identifier }}</div>
                <br>
                <div class="text-uppercase"> المنتجات : </div>
                <div class="d-flex my-4 flex-wrap">
                    @forelse($products as $key => $product)
                    <div class="box me-4 my-1 text-center bg-light">
                        <img src="{{ getImage(@$product->item->cover_image) }}" alt="" width="30px" alt="" class="rounded">
                        <div class="text-center mt-2">
                            <div class="tag">{{ $product->item_name  }}</div>
                        </div>
                    </div>
                    @empty
                    @endforelse
                </div>

                <div class="text-uppercase"> بيانات الطلب </div>

                <div class="order my-3 bg-light rounded">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="d-flex flex-column justify-content-between order-summary">
                                <div class="fs-8"> اسم المتبرع : {{ $order->donor->full_name  }} </div>
                                <div class="fs-8"> طريقه الدفع : <span class="green-label ms-auto text-uppercase"> {{ $order->paymentMethod->payment_key }}</span> </div>
                                <div class="fs-8"> السعر: {{ $order->total }} </div>
                                <div class="fs-8"> التاريخ: {{ date('d-m-Y', $order->create_date) }} | {{ date('H:i:s', $order->create_date) }} </div>
                            </div>
                        </div>
                        <div class="col-lg-8 d-flex justify-content-center align-items-center">
                            <div class="status h4 mt-3">الحاله :  {{ trans($order->shipping_status) }} </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>


<style>
    #main-content {
        padding: 30px;
        border-radius: 15px;
    }

    #main-content .h5,
    #main-content .text-uppercase {
        font-weight: 600;
        margin-bottom: 0;
    }

    #main-content .box {
        padding: 10px;
        border-radius: 6px;
        width: 170px;
        height: 90px;
    }

    #main-content .box img {
        width: 40px;
        height: 40px;
        object-fit: contain;
    }

    #main-content .box .tag {
        font-size: 0.9rem;
        color: #000;
        font-weight: 500;
    }

    #main-content .box .number {
        font-size: 1.5rem;
        font-weight: 600;
    }

    .order {
        padding: 10px 30px;
        height: 100%;
    }

    .order .order-summary {
        height: 100%;
    }

    .order .blue-label {
        background-color: #aeaeeb;
        color: #0046dd;
        font-size: 0.9rem;
        padding: 0px 3px;
    }

    .order .green-label {
        background-color: #a8e9d0;
        color: #008357;
        font-size: 0.9rem;
        padding: 0px 3px;
    }

    .order .fs-8 {
        font-size: 1rem;
        padding: 7px;
    }

    .order .rating img {
        width: 20px;
        height: 20px;
        object-fit: contain;
    }

    .order .rating .fas,
    .order .rating .far {
        font-size: 0.9rem;
    }

    .order .rating .fas {
        color: #daa520;
    }

    .order .status {
        font-weight: 600;
    }

    .order .btn.btn-primary {
        background-color: #fff;
        color: #4e2296;
        border: 1px solid #4e2296;
    }

    .order .btn.btn-primary:hover {
        background-color: #4e2296;
        color: #fff;
    }

    .order .progressbar-track {
        margin-top: 20px;
        margin-bottom: 20px;
        position: relative;
    }

    .order .progressbar-track .progressbar {
        list-style: none;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding-left: 0rem;
    }

    .order .progressbar-track .progressbar li {
        font-size: 1.5rem;
        border: 1px solid #333;
        padding: 5px 10px;
        border-radius: 50%;
        background-color: #dddddd;
        z-index: 100;
        position: relative;
    }

    .order .progressbar-track .progressbar li.green {
        border: 1px solid #007965;
        background-color: #d5e6e2;
    }

    .order .progressbar-track .progressbar li::after {
        position: absolute;
        font-size: 0.9rem;
        top: 50px;
        left: 0px;
    }

    @media(max-width: 500px) {
        .order .progressbar-track .progressbar li {
            font-size: 1rem;
        }

        .order .progressbar-track .progressbar li::after {
            font-size: 0.8rem;
            top: 35px;
        }
    }

    @media(max-width: 440px) {
        #main-content {
            padding: 20px;
        }

        .order {
            padding: 20px;
        }
    }

    @media(max-width: 395px) {
        .order .progressbar-track .progressbar li {
            font-size: 0.8rem;
        }

        .order .progressbar-track .progressbar li::after {
            font-size: 0.7rem;
            top: 35px;
        }

        .order .btn.btn-primary {
            font-size: 0.85rem;
        }
    }

    @media(max-width: 355px) {
        #main-content {
            padding: 15px;
        }

        .order {
            padding: 10px;
        }
    }

</style>
@endsection
