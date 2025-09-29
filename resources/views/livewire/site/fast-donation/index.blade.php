   @if ($show_fast_donation)
   <div>
       <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
       <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css" />
       <style>
           .iti {
               width: 100%;
           }

           .iti-mobile .iti__country-list {
               width: 90%;
           }

           .iti__country-name {
               display: none;
           }

       </style>


       <!-- quick donation  -->
       <div class="fast-pay @if($open) expanded @endif">
           <div class="container bg-fast-pay  " wire:click="toogleOpen()">
               <div class="white-layer"></div>
               <span class="plus-btn">+</span>
               <h6> @lang('Fast Donation') </h6>
           </div>


           <div class="donation-form" style="{{ $open ? 'display:block, opacity: translateX(4.13568%); transform:0.958643' :'display:none, opacity: translateX(94.338%); transform:0.0566107' }}">
               <div class="form-title">اختر نوع التبرع</div>

               <div class="donation-options">
                   @forelse($categories as $key => $category)
                   <div class="donation-option @if($selectedCategory == $category->id) active @endif" wire:click="SelectCategory({{ $category->id }})" data-option="{{ $category->trans->where('locale', $current_lang)->first()->title }}">
                       {{ $category->trans->where('locale', $current_lang)->first()->title }}
                   </div>
                   @empty

                   @endforelse
               </div>

               <!-- Project selection groups - each for a specific donation type -->
               <div class="project-selection-container">
                   <!-- Projects for الإطعام -->
                   <div class="project-group">
                       <div class="form-group">
                           <select class="project-select" wire:model="selectedProject" wire:change="SelectProject()">
                               <option value="" selected>@lang('Choose a project')</option>
                               @forelse($projects as $key => $project)
                               <option value="{{ $project->id }}">
                                   {{ $project->trans->where('locale', $current_lang)->first()->title }}
                               </option>
                               @empty
                               @endforelse
                           </select>
                       </div>
                   </div>
               </div>

               <!-- Donation Amount Buttons - Initially Hidden -->
               <div class="donation-amounts d-flex align-items-center justify-content-center" id="donation-amounts">
                   <!-- Default amounts for الإطعام -->
                   <div class="amount-group" id="projects">
                       <div class="form-title">اختر مبلغ التبرع</div>
                       <div class="donations amount-buttons  d-flex align-items-center justify-content-center gap-1 mb-3 custom-card-btn-row">

                           @if (is_array($donation))
                           @switch($donation['type'])
                           @case('unit')
                           <div class="donation-amounts text-center">
                               @forelse (@$donation['data'] ?? [] as $key => $data)
                               <label data-toggle="tooltip" data-placement="top" title="{{ $data['name'] }}" style="background-color:{{ is_array($colors) && count($colors) > 0 ? $colors[$key % count($colors)] : '#ccc' }}" class="amount-btn {{ $unitValueRadio == json_encode($data) ? 'active' : null }} {{ $data['value'] == $donationAmt ? 'active' : null }}">
                                   <input wire:model.live="unitValueRadio" type="radio" value="{{ json_encode($data) }}" style="display: none">
                                   <div class="price">
                                       <span>{{ $data['value'] }}</span>
                                       {{-- <small class="large-screen"> &#65020;</small> --}}
                                   </div>
                               </label>
                               @empty
                               @endforelse
                           </div>
                           <div class="custom-amount">
                               <input type="number" wire:model.live="unitValueInput" min="0" placeholder="@lang('Another amount')" class="amount-input" />
                               <span class="currency">رس</span>
                           </div>
                           @break

                           @case('share')
                           <div class="donation-amounts text-center">
                               @forelse (@$donation['data']??[] as $key => $data)
                               <label data-toggle="tooltip" data-placement="top" title="{{ $data['name'] }}" for="ab-{{ $key }}" style="background-color:{{ is_array($colors) && count($colors) > 0 ? $colors[$key % (count($colors) ?? 0)] : '#ccc' }}" class="amount-btn  {{ $shareValue == json_encode($data) ? 'active' : null }}" {{ $shareValue == json_encode($data) ? 'active' : '' }}>
                                   <input wire:model.live="shareValue" type="radio" value="{{ json_encode($data) }}" id="ab-{{ $key }}" style="display: none">
                                   {{ $data['value'] }}
                               </label>
                               @empty
                               @endforelse
                           </div>
                           @break

                           @case('fixed')
                           <div class="donation-amounts text-center">
                               <button class="btn btn-primary amount-btn amount-btn-500" style="background-color:{{ @$colors[0] }}">
                                   {{ @$donation['data'] }} <span>رس</span>
                               </button>
                           </div>
                           @break

                           @case('open')
                           <div class="custom-amount">
                               <input type="number" wire:model="openValue" min="0" placeholder="@lang('Price')" class="amount-input" />
                               <span class="currency">رس</span>
                           </div>
                           @break

                           @default
                           <span>Something went wrong, please try again</span>
                           @endswitch
                           @endif
                       </div>
                   </div>
               </div>

               <div class="form-group mt-3">
                   <input type="text" wire:model="name" class="form-control" placeholder="@lang('Name')">
               </div>

               <div class="input-group" wire:ignore>
                   <input type="number" wire:ignore id="login-mobile" class="form-control iti-phone" wire:model="mobile" placeholder="@lang('Mobile')" style="direction: ltr" />
                   <input id="countryData-login" wire:ignore wire:model="mobileWithCode" value="{{ $mobileWithCode }}" type="hidden" />
                   <span class="text-danger" id="notification-login"></span>
               </div>

               <div class="form-title"> @lang('Payment Method') </div>

               @if($donationAmt <= 0 ) <span class="text-danger"> يجب اختيار التبرع </span>
                   @elseif ( $name == "" )<span class="text-danger">الاسم مطلوب </span>
                   @elseif ( $mobile == "" )<span class="text-danger"> الموبيل مطلوب </span>
                   @else

                   <div class="payment-methods">
                       <div class="img-container">
                            @if ($visaStatus)
                            <button wire:click="SelectPayment('visa')" @if(!$donationAmt) disabled @endif class="p-0 nav-link @if($paymentMethod == " visa") active @endif" data-bs-toggle="pill" data-bs-target="#visa-pay" type="button" aria-selected="true">
                                <span class="img">
                                    <img src="{{ site_path('img/pay-4.png') }}" alt="" />
                                </span>
                            </button>
                            @endif
                           @if ($applePayStatus && ($iphone || $safari))
                                <button wire:click="SelectPayment('applePay')" @if(!$donationAmt) disabled @endif class="p-0 nav-link @if($paymentMethod == " applePay") active @endif" data-bs-toggle="pill" data-bs-target="#apple-pay" type="button" aria-selected="true">
                                    <span class="img">
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
                           <button wire:click="SelectPayment('bankTransfer')" @if(!$donationAmt) disabled @endif class="p-0 nav-link @if($paymentMethod == " bankTransfer") active @endif" data-bs-toggle="pill" type="button" role="tab" aria-selected="true">
                               <span class="img">
                                   <img src="{{ site_path('img/pay-1.png') }}" alt="" />
                               </span>
                           </button>
                        @endif
                       </div>
                   </div>

                   @if($donationAmt > 0)
                   <div class="tab-content my-3" id="pills-tabContent2">

                       <!-- visa-pay-tab -->
                       @if($paymentMethod == "visa"  && $visaStatus)
                       @livewire('site.fast-donation.payments.visa')

                       <!-- apple-pay-tab -->
                       @elseif($paymentMethod == "applePay" && $applePayStatus)
                  
                       @livewire('site.fast-donation.payments.apple-pay', ['dataDonation' => $dataDonation])

                       <!-- transfer-pay-tab -->
                       @elseif($paymentMethod == "bankTransfer" && $banktransferStatus)
                       @livewire('site.fast-donation.payments.bank-transfer')

                       @endif
                   </div>
                   @endif
                   @endif

           </div>
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

       <!-- International Tel Input Script -->
       <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>

       <script>
           $(document).ready(function() {
               var phoneInputField = document.querySelector("#login-mobile");
               var phoneInput = window.intlTelInput(phoneInputField, {
                   preferredCountries: ['sa', 'ae', 'kw', 'qa', 'bh', 'om']
                   , separateDialCode: true
                   , utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js"
                   , initialCountry: "auto"
                   , geoIpLookup: function(success, failure) {
                       fetch("https://ipapi.co/json")
                           .then(function(res) {
                               return res.json();
                           })
                           .then(function(data) {
                               success(data.country_code);
                           })
                           .catch(function() {
                               failure();
                           });
                   }


               });

               phoneInputField.addEventListener('keyup', function() {
                var full_number = phoneInput.getNumber();
                $('#countryData-login').val(full_number);
                   console.log("Input changed!", full_number);
               });
             
           });

       </script>
   </div>

   @endif
