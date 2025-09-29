<div id="payment-methods">
    <div class="TotalCard">
        @if(@auth('account')->user()?->types->where('type', 'donor')->first() == null)
            <span class="text-danger">من فضلك قم بتسجيل الدخول لاستكمال عملية الدفع </span>
        @else

        <div class="payment-methods">
            <div class="img-container">
                @if ($visaStatus)
                <button type="button" wire:click="SelectPayment('visa')" id="visa" class="button payment-items  @if($paymentMethod == 'visa') active @endif">
                    <span>
                        <img src="{{ site_path('img/pay-4.png') }}" alt="" />
                    </span>
                </button>
                @endif
                @if ($applePayStatus && ($iphone || $safari))
                    <button type="button" wire:click="SelectPayment('applePay')" id="apple-pay" class="button payment-items @if($paymentMethod == 'applePay') active @endif">
                        <span>
                            <img src="{{ site_path('img/pay-2.png') }}" alt="" />
                        </span>
                    </button>

                    @if(!config("app.TEST_MODE"))
                        <input type="hidden" id="SHARequestPhrase" value="{{config("payfort.SHARequestPhrase")}}">
                        @else
                        <input type="hidden" id="SHARequestPhrase" value="96o0CiKlNkSJO7/OJH8ALl$+">
                    @endif
                @endif
                @if ($banktransferStatus)
                <button type="button" wire:click="SelectPayment('bankTransfer')" id="bank" class="button payment-items @if($paymentMethod == 'bankTransfer') active @endif">
                    <span>
                        <img src="{{ site_path('img/pay-1.png') }}" alt="" />
                    </span>
                </button>
                @endif
            </div>

            <div class="label">

              <p>
                وسيلة الدفع
              </p>
            </div>

          </div>

            <!-- visa -->
            @if($paymentMethod == "visa" && $visaStatus)
                @livewire('site.payments.visa')
            <!-- apple-pay-tab -->
            @elseif($paymentMethod == "applePay" && $applePayStatus)
                @livewire('site.payments.apple-pay')
            <!-- transfer-pay-tab -->
            @elseif($paymentMethod == "bankTransfer" && $banktransferStatus)
                @livewire('site.payments.bank-transfer')
            @endif

        @endif
    </div>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.1.1/crypto-js.min.js"></script>
    <script>
        function pay() {
            CalculateSignature();
            document.getElementById("paymentForm").submit();

        }

        function CalculateSignature() {
            // const requestShaPhrase = "96o0CiKlNkSJO7/OJH8ALl$+"; // Set your request SHA phrase here.
            const requestShaPhrase = document.getElementById("SHARequestPhrase").value; // "737LIJbY2e1b5sTd0.8iPE+_"; // Set your request SHA phrase here.

            let signatureString = requestShaPhrase;

            // Get form data
            const formData = new FormData(document.getElementById("paymentForm"));

            // Convert formData to object for easy sorting
            const formDataObject = {};
            formData.forEach((value, key) => {
                formDataObject[key] = value;
            });

            // Sort formDataObject by keys
            const sortedFormDataObject = Object.fromEntries(
                Object.entries(formDataObject).sort(([keyA], [keyB]) => keyA.localeCompare(keyB))
            );

            // Construct sorted signatureString
            for (const [key, value] of Object.entries(sortedFormDataObject)) {
                if (key !== 'signature') {
                    signatureString += key + '=' + value;
                }
            }

            signatureString += requestShaPhrase;

            // Calculate SHA256 signature
            const calculatedSignature = CryptoJS.SHA256(signatureString).toString();

            // Set signature value in the form
            document.getElementById("signature").value = calculatedSignature;
            // Submit the form
            document.getElementById("paymentForm").submit();
        }

    </script>
</div>
