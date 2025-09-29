<div>
    <!--Zakat -->
    <div class="Zakat" class="mt-5">
        <div class="container">
            <!-- Zakat Btns-->
            <div class="btns-Zakat row">
                <div class="col-12 col-md-6 text-md-start text-center">
                    <button type="button" class="btn btn-out fs-1 text-white p-5 my-5 text-center @if(!$calcZakat) active @endif" wire:click="calculatorZakah(0)" id="Zakatout">
                        @lang('Paying zakat')
                    </button>
                </div>
                <div class="col-12 col-md-6 text-md-end text-center mb-md-0 mb-4">
                    <button type="button" class="btn btn-out fs-1 text-white p-5 my-md-5 text-center @if($calcZakat) active @endif" wire:click="calculatorZakah(1)" id="calcZakat">
                        @lang('Zakat calculator')
                    </button>
                </div>
            </div>
            <!-- Zakat Btns-->
            <!------------------------------------------------------------------------------------------------------------------>

            @if(!$calcZakat)
            <!--Zakat-out-->
            <div class="Zakat-out" id="Zakat-out">
                <!--text -->
                <div class="text-Zakat row">
                    <div class="row">
                        <div class="col-12">
                            <p  class="fs-4">
                                <span class="aya">
                                    وَيُقِيمُونَ الصَّلَاةَ وَيُؤْتُونَ الزَّكَاةَ وَيُطِيعُونَ
                                    اللَّهَ وَرَسُولَهُ ۚ أُولَٰئِكَ سَيَرْحَمُهُمُ اللَّهُ ۗ
                                    إِنَّ اللَّهَ عَزِيزٌ حَكِيمٌ
                                </span>
                                <br />
                                تخرج جمعية البر زكاتك لمستحقيها من الاسر المحتاجة(أكثر من 24
                                الف أسرة من الارامل والايتام وكبار السن والعجزة والحالات
                                الطارئة المستحقة للزكاة)
                            </p>
                            <p class="text-start ms-5"><a href="">مزيدا من التفاصيل</a></p>
                        </div>
                    </div>
                </div>
                <!--text -->

                <!--opeartion-->
                <div class="oparation row m-5">
                    <!--Img-->
                    <div class="col-12 col-md-6">
                        <img src="{{ asset(site_path('img/plant.jpg')) }}" alt="" />
                    </div>
                    <!--Img-->

                    <div class="col-12 col-md-6 d-flex flex-column justify-content-center mt-3 mt-md-0">
                        <!--text-->
                        <label  for="money" class="form-label">@lang('Determine the amount of zakat')</label>
                        <input type="number" min="0" step="any" wire:model="amount" id="money" class="form-control {{ (empty($errors->first('amount'))) ?: 'has-error'  }}" placeholder="@lang('Price')"  />
                        @if ($errors->has('amount'))
                        <span class="missiong-spam">{{ $errors->first('amount') }}</span>
                        @endif
                        <!--text-->

                        <!--btns-->
                        <div class="button row">
                            <div class="col-12 col-md-8">
                                <button type="button" wire:click="submit" class="btn bg-main fs-4 text-white px-lg-5 my-5 text-center w-100">
                                    @lang('Continue Payment')
                                </button>
                            </div>

                            <div class="col-12 col-md-4">
                                <button type="button" wire:click="addToCart" class="btn bg-secound fs-4 text-white px-5 my-5 text-center w-100">
                                    <i class="icofont-cart-alt"></i>
                                </button>
                            </div>

                            {{-- <div class="col-12 col-md-4">
                                <button type="button" wire:click="close" class="btn bg-danger fs-4 text-white px-5 my-5 text-center w-100">
                                  @lang('Cancel')
                                </button>
                            </div> --}}
                        </div>
                        <!--btns-->
                    </div>
                </div>
                <!--opeartion-->
            </div>
            <!--Zakat-out-->
            @else
            <!---Zakat-calc -->
            <div class="Zakat-calc" id="Zakat-calc">
                <div class="container">
                    <!--text-->
                    <div class="row">
                        <div class="col-12 text-center">
                            <p class="text-main fs-5" >
                                حاسبةالزكا تمكنك من حساب قيمة الزكاة الخاصة بك بعد كتابة المال
                                أو المبلغ الذي تملكه بعد تحقق نصاب الزكاة , وكما يمكنك أيضا من
                                حساب قيمة زكاة الذهب من خلال إدخال مقدار الذهب وبالتالي تتعرف
                                علي قيمة الزكاة الواجبة عليها . ويمكنك حساب الزكاة للمتلكات
                                الخاصة بك أو الاسهم أو السندات بكتابة قيمة السهم او السند ,
                                وبعد ذلك يظهر لك قيمة الزكاة الخاصة بها
                            </p>
                        </div>
                    </div>
                    <!--text-->

                    <!--Calc-->
                    <div class="Calc row gy-4 mt-lg-5">
                        <div class="col-md-6 col-12 d-flex flex-column">
                            <!--money-->
                            <div class="Zakat-money mt-lg-5 mt-2 w-100">
                                <div class="cup bg-main w-25 text-center px-2 py-2 me-md-2" >
                                    @lang('Zakat on money')
                                </div>
                                <div class="row gx-2">
                                    <input type="number" min="0" step="any" wire:model="money" id="" placeholder="@lang('Enter the amount of money you own and pass the year on it')"  class="bg-light p-3 px-4 col-12 col-md-8 rounded-2 border-0" />
                                    <button wire:click="calculateMoney" class="btn bg-main col-12 col-md-3 p-3 mt-2 mx-2" >
                                        @lang('Calculate')
                                    </button>
                                    @error('money')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    @if($zakatMonyMessage)
                                        <span class="text-danger">{{ $zakatMonyMessage }}</span>
                                    @endif
                                </div>
                            </div>
                            <!--money-->

                            <!--Gold-->
                            <div class="Zakat-gold mt-lg-5 mt-2 w-100">
                                <div class="cup bg-main w-25 text-center px-2 py-2 me-md-2">
                                    @lang('Zakat on gold')
                                </div>
                                <form wire:submit.prevent="calculateGold()" class="">
                                    <div class="row gx-2">
                                        <input type="number" min="0" step="any" wire:model="zakatGold_gm" placeholder="@lang('Enter the number of grams')" class="bg-light p-3 px-4 col-12 col-md-4 rounded-2 border-0" />

                                        <input type="number" min="0" step="any" wire:model="zakatGold_amount" id="" placeholder="@lang('Enter the gram value')" class="bg-light col-12 col-md-4 p-3 px-4 mt-3 mt-md-0 rounded-2 border-0" />

                                        <button type="submit" class="btn bg-main col-12 col-md-3 p-3 mt-3 mt-md-0 mx-2">
                                            @lang('Calculate')
                                        </button>

                                        <div class="col-12 col-md-4">
                                            @error('zakatGold_gm')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-12 col-md-4">
                                            @error('zakatGold_amount')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!--Gold-->

                            <!--Silver-->
                            <div class="Zakat-sliver mt-lg-5 mt-2 w-100">
                                <div class="cup bg-main w-25 text-center px-2 py-2 me-md-2" >
                                    @lang('Zakat on silver')
                                </div>
                                <form wire:submit.prevent="calculateSilver()" class="">

                                    <div class="row gx-2">
                                        <input type="number" min="0" step="any" wire:model="zakatSilver_gm" placeholder="@lang('Enter the number of grams')" class="bg-light p-3 px-4 col-12 col-md-4 rounded-2 border-0" />

                                        <input type="number" min="0" step="any" wire:model="zakatSilver_amount" id="" placeholder="@lang('Enter the gram value')" class="bg-light col-12 col-md-4 p-3 px-4 mt-3 mt-md-0 rounded-2 border-0" />

                                        <button type="submit" class="btn bg-main col-12 col-md-3 p-3 mt-3 mt-md-0 mx-2">
                                            @lang('Calculate')
                                        </button>

                                        <div class="col-12 col-md-4">
                                            @error('zakatSilver_gm')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-12 col-md-4">
                                            @error('zakatSilver_amount')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!--Silver-->

                            <!--Investment-->
                            <div class="Zakat-sliver mt-lg-5 mt-2 w-100">
                                <div class="cup bg-main w-50 text-center px-2 py-2 me-md-2" >
                                    @lang('Zakat on stocks and investment funds')
                                </div>
                                <form wire:submit.prevent="calculateInvestment()" class="">

                                    <div class="row gx-2">
                                        <input type="number" min="0" step="any" wire:model="zakatInvestment_gm"  placeholder="@lang('Enter the number of shares')" class="bg-light p-3 px-4 col-12 col-md-4 rounded-2 border-0" />

                                        <input type="number" min="0" step="any" wire:model="zakatInvestment_amount" id="" placeholder="@lang('Enter the stock value')" class="bg-light col-12 col-md-4 p-3 px-4 mt-3 mt-md-0 rounded-2 border-0" />

                                        <button type="submit" class="btn bg-main col-12 col-md-3 p-3 mt-3 mt-md-0 mx-2">
                                            @lang('Calculate')
                                        </button>

                                        <div class="col-12 col-md-4">
                                            @error('zakatInvestment_gm')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-12 col-md-4">
                                            @error('zakatInvestment_amount')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!--arrows-->
                        </div>

                        <div class="col-12 col-md-6">
                            @if($amountZakah)
                                <div class="row gx-2 bg-light py-2 text-center align-content-center">
                                    <div class="col-4">
                                        <p class="text-primary me-2 m-md-0" >
                                            @lang('Zakat on money')
                                        </p>
                                    </div>
                                    <div class="col-4">
                                        <p class="text-primary" >{{ $amountZakah }} @lang('SAR')</p>
                                    </div>
                                    <div class="col-4">
                                        <i class="icofont-trash text-danger" wire:click="deleteZakah({{ $amountZakah }})"></i>
                                    </div>
                                </div>
                            @endif

                            @forelse ($zakatGoldFields as $index => $goldValue)
                                <div class="row gx-2 mt-3 bg-light py-2 text-center align-content-center">
                                    <div class="col-4">
                                        <p class="text-primary" > @lang('Zakat on gold') {{ $index + 1 }}</p>
                                    </div>
                                    <div class="col-4">
                                        <p class="text-primary" >{{ $goldValue['total'] }} @lang('SAR')</p>
                                    </div>
                                    <div class="col-4">
                                        <i class="icofont-trash text-danger" wire:click="deleteZakah({{ $goldValue['total'] }}, {{  $index }}, 'Gold')"></i>
                                    </div>
                                </div>
                            @empty
                            @endforelse

                            @forelse ($zakatSilverFields as $index => $silverValue)
                                <div class="row gx-2 mt-3 bg-light py-2 text-center align-content-center">
                                    <div class="col-4">
                                        <p class="text-primary"> @lang('Zakat on silver') {{ $index +1 }}</p>
                                    </div>
                                    <div class="col-4">
                                        <p class="text-primary" >{{ $silverValue['total'] }} @lang('SAR') </p>
                                    </div>
                                    <div class="col-4">
                                        <i class="icofont-trash text-danger" wire:click="deleteZakah({{ $silverValue['total'] }}, {{  $index }}, 'Silver')"></i>
                                    </div>
                                </div>
                            @empty
                            @endforelse

                            @forelse ($zakatInvestmentFields as $index => $InvestmentValue)
                                <div class="row gx-2 mt-3 bg-light py-2 text-center align-content-center">
                                    <div class="col-4">
                                        <p class="text-primary" >  @lang('Zakat on stocks and investment funds') {{ $index + 1 }}</p>
                                    </div>
                                    <div class="col-4">
                                        <p class="text-primary" >{{ $InvestmentValue['total'] }} @lang('SAR') </p>
                                    </div>
                                    <div class="col-4">
                                        <i class="icofont-trash text-danger" wire:click="deleteZakah({{ $InvestmentValue['total'] }}, {{  $index }}, 'Investment')"></i>
                                    </div>
                                </div>
                            @empty
                            @endforelse


                            <div class="mt-5">
                                <p class="text-primary fs-4 me-4" >
                                    @lang('The total value of your zakat due')
                                </p>
                                <div class="bg-light p-3 text-center text-primary fs-2 rounded-2" >
                                    <input type="text" wire:model="amount" value="" placeholder="@lang('Total')" class="bg-white p-2 px-5 mt-4 col-12 col-md-8 rounded-2 border-0" />
                                    @error('amount')
                                        <div class="row">
                                            <span class="text-danger fs-6">{{ $message }}</span>
                                        </div>
                                    @enderror
                                    <!--btns-->
                                    <div class="button row">
                                        <div class="col-12 col-md-6">
                                            <button type="button" wire:click="submit" class="btn bg-main fs-5 text-white px-lg-5 my-lg-4 my-2 text-center w-100">
                                                @lang('Continue Payment')
                                            </button>
                                        </div>

                                        <div class="col-12 col-md-4">
                                            <button type="button" wire:click="addToCart" class="btn bg-secound fs-5 text-white px-4 my-lg-4 my-2 text-center w-100">
                                                <i class="icofont-cart-alt"></i>
                                            </button>
                                        </div>

                                        <div class="col-12 col-md-2">
                                            <button type="button" wire:click="close" class="btn bg-danger fs-5 text-white px-4 my-lg-4 my-2 text-center w-100">
                                                @lang('Cancel')
                                            </button>
                                        </div>
                                    </div>
                                    <!--btns-->
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Calc-->
                </div>
            </div>
            <!---Zakat-calc -->
            @endif
        </div>
    </div>
    @livewire('site.carts.add-modal')

</div>
