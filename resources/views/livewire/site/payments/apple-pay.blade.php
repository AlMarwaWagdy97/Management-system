<div>
    <div class="container">
        <h5 class="fs-6 mb-3"> @lang('Pay From ApplePay') </h5>

        <div class="container">
            <button onclick="pay()" class="btn w-100 btn-success"> @lang('Pay')</button>
        </div>

        <form id="paymentForm" method="post" action="{{ $url }}">


            <input type="hidden" name="signature" id="signature">

            <INPUT type="hidden" NAME="command" value="PURCHASE">

            <INPUT type="hidden" NAME="merchant_identifier" value="{{ $mechant_identifier }}">
            <INPUT type="hidden" NAME="access_code" value="{{ $access_code }}">

            <INPUT type="hidden" NAME="amount" value="{{ $order->total * 100}}">

            <INPUT type="hidden" NAME="merchant_reference" value="{{ $order->id }}">
            <INPUT type="hidden" NAME="currency" value="SAR">
            <INPUT type="hidden" NAME="language" value="ar">
            <INPUT type="hidden" NAME="customer_email" value="{{ $order->donor?->mobile . "@handin.org.sa" }}">

            <input type="hidden" id="order_description" name="order_description" value="Test order">
            <INPUT type="hidden" NAME="return_url" value="{{ route('api.payfort-purchase') }}">

        </form>


    </div>

</div>
