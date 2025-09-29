@extends('site.app')
@section('title', __('Checkout'))
@section('content')
        




<div class="container">
    <!-- Categories -->
    <section id="categories">
        <div class="row m-3 d-flex justify-content-center">
            <div class="col-12 card">
                <div class="text-center my-3">
                    <input hidden type="number" id="amount" name="amount" value="{{ $order->total}}">
                    <input hidden type="number" id="order" name="amount" value="{{ $order->id}}">
                    <h4 class="text-success my-2">  مبلغ التبرع : {{ $order->total }} </h4>

                   <div class="d-flex justify-content-center my-3">
                        <button type="button" id="applePay" class="btn bg-main w-5 mx-3" style="display: none"> @lang('Pay')</button>
                   </div>

                    <p style="display:none" id="got_notactive">ApplePay is possible on this browser, but not currently activated.</p>
                    <p style="display:none" id="notgot">ApplePay is not available on this browser</p>
                    <p style="display:none" id="success">Transaction completed, thanks. <a href="{{ $_SERVER["HTTP_HOST"]}}">reset</a></p>
                    <p style="display:none" id="failed">Transaction failed</p>
                </div>
            </div>
        </div>
    </section>
    <!-- end Categories -->


    <script src="{{ asset('site/js/jquery.min.js') }}"></script>

    <script>
        /**applepay js */
        var totalAmount = $('#amount').val();
        var order_id = $('#order').val();

        var merchant = '{{ openssl_x509_parse(file_get_contents(asset( env('CERTIFICATE_PATH') ) )['subject']['UID']) }}';

        var debug = false;
        if (window.ApplePaySession) {
            var merchantIdentifier = merchant;
            var promise = ApplePaySession.canMakePaymentsWithActiveCard(merchantIdentifier);
            promise.then(function(canMakePayments) {
                if (canMakePayments) {
                    document.getElementById("applePay").style.display = "block";
                    logit('hi, I can do ApplePay');
                } else {
                    document.getElementById("got_notactive").style.display = "block";
                    logit('ApplePay is possible on this browser, but not currently activated.');
                }
            });
        } else {
            logit('ApplePay is not available on this browser');
            document.getElementById("notgot").style.display = "block";
        }

        document.getElementById("applePay").onclick = function(evt) {
        $('#success').html('Transaction completed with SR ' + totalAmount + ', thanks.');

        // dataLayer.push({
        //     event: "purchase",
        //     ecommerce: {
        //         currency: "SAR",
        //         value: totalAmount,
        //         paymentMethod: 'ApplePay', 
        //     }
        // });
        
        var shippingOption = "";
        var subTotalDescr = "Test Goodies";
        var paymentRequest = {
            currencyCode: '{{ config('applepay.PRODUCTION_CURRENCYCODE') }}',
            countryCode: '{{ config('applepay.PRODUCTION_COUNTRYCODE') }}',
            total: {
                label: '{{ config('applepay.PRODUCTION_DISPLAYNAME') }}',
                amount: totalAmount
            },
            supportedNetworks: ['masterCard', 'visa', 'mada'],
            merchantCapabilities: ['supports3DS']
        };
        var session = new ApplePaySession(1, paymentRequest);
        // Merchant Validation
        session.onvalidatemerchant = function(event) {
            logit(event);
            var promise = performValidation(event.validationURL);
            promise.then(function(merchantSession) {
                session.completeMerchantValidation(merchantSession);
            });
        }

        function performValidation(valURL) {
            return new Promise(function(resolve, reject) {
                var xhr = new XMLHttpRequest();
                xhr.onload = function() {
                    var data = JSON.parse(this.responseText);
                    logit(data);
                    resolve(data);
                };
                xhr.onerror = reject;
                xhr.open('GET', '{{ asset("site/applepay/apple_pay_comm.php") }}?u=' + valURL);
                xhr.send();
            });
        }
        session.onshippingcontactselected = function(event) {
            logit('starting session.onshippingcontactselected');
            logit('NB: At this stage, apple only reveals the Country, Locality and 4 characters of the PostCode to protect the privacy of what is only a *prospective* customer at this point. This is enough for you to determine shipping costs, but not the full address of the customer.');
            logit(event);
            var status = ApplePaySession.STATUS_SUCCESS;
            var newTotal = {
                type: 'final',
                label: '{{ config('applepay.PRODUCTION_DISPLAYNAME') }}',
                amount: totalAmount
            };
            var newLineItems = [{
                type: 'final',
                label: subTotalDescr,
                amount: totalAmount
            }];
            session.completeShippingContactSelection(status);
        }
        session.onshippingmethodselected = function(event) {
            logit('starting session.onshippingmethodselected');
            logit(event);
            var status = ApplePaySession.STATUS_SUCCESS;
            var newTotal = {
                type: 'final',
                label: '{{ config('applepay.PRODUCTION_DISPLAYNAME') }}',
                amount: totalAmount
            };
            var newLineItems = [{
                type: 'final',
                label: subTotalDescr,
                amount: totalAmount
            }];
            session.completeShippingMethodSelection(status, newTotal, newLineItems);
        }
        session.onpaymentmethodselected = function(event) {
            logit('starting session.onpaymentmethodselected');
            logit(event);
            var newTotal = {
                type: 'final',
                label: '{{ config('applepay.PRODUCTION_DISPLAYNAME') }}',
                amount: totalAmount
            };
            var newLineItems = [{
                type: 'final',
                label: subTotalDescr,
                amount: totalAmount
            }];
            session.completePaymentMethodSelection(newTotal, newLineItems);
        }
        session.onpaymentauthorized = function(event) {
            logit('starting session.onpaymentauthorized');
            logit('NB: This is the first stage when you get the *full shipping address* of the customer, in the event.payment.shippingContact object');
            logit(event);
            var promise = sendPaymentToken(event.payment.token);
            promise.then(function(success) {
                var status;
                console.log(success);
                if (success) {
                    status = ApplePaySession.STATUS_SUCCESS;
                    document.getElementById("applePay").style.display = "none";
                    session.completePayment(status);
                    document.getElementById("success").style.display = "block";
                } else {
                    status = ApplePaySession.STATUS_FAILURE;
                    session.completePayment(status);
                    document.getElementById("failed").style.display = "block";
                }
            });
        }

        function sendPaymentToken(paymentToken) {
            return new Promise(function(resolve, reject) {
                logit('starting function sendPaymentToken()');
                logit(paymentToken);
                $.ajax({
                    type: 'POST',
                    url: '{{ route("site.payments.applepay") }}',
                    data: {
                        order_id: order_id,
                        apple_data: paymentToken.paymentData.data,
                        apple_signature: paymentToken.paymentData.signature,
                        apple_transactionId: paymentToken.paymentData.header.transactionId,
                        apple_ephemeralPublicKey: paymentToken.paymentData.header.ephemeralPublicKey,
                        apple_publicKeyHash: paymentToken.paymentData.header.publicKeyHash,
                        apple_displayName: paymentToken.paymentMethod.displayName,
                        apple_network: paymentToken.paymentMethod.network,
                        apple_type: paymentToken.paymentMethod.type,
                        amount: totalAmount
                    },
                    dataType: "JSON",
                    success: function(data) {
                        var parsed_json = JSON.parse(data);
                        var status = parsed_json.status;
                        if (status == 14) {
                            resolve(true);
                        } else {
                            resolve(false);
                        }

                    }
                });


                logit("this is where you would pass the payment token to your third-party payment provider to use the token to charge the card. Only if your provider tells you the payment was successful should you return a resolve(true) here. Otherwise reject;");
                logit("defaulting to resolve(true) here, just to show what a successfully completed transaction flow looks like");

            });
        }
        session.oncancel = function(event) {
            logit('starting session.cancel');
            logit(event);
        }
        session.begin();
    }


    function logit(data) {
        if (debug == true) {
            console.log(data);
        }
    }

        /**end of applepay */

    </script>
</div>



@endsection

