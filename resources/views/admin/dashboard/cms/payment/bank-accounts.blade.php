<div class="col-md-12">
    <div class="accordion" id="accordionExampleSetting">
        <div class="border rounded accordion-item">
            <h2 class="accordion-header" id="headingSetting">
                <button class="accordion-button fw-medium" type="button"
                    data-bs-toggle="collapse" data-bs-target="#collapseSetting"
                    aria-expanded="true" aria-controls="collapseSetting">
                    {{ trans('payment.banks') }}
                </button>
            </h2>
            <div id="collapseSetting" class="accordion-collapse collapse show"
                aria-labelledby="headingSetting" data-bs-parent="#accordionExampleSetting">
                <div class="accordion-body">
                    {{-- min price  ------------------------------------------------------------------------------------- --}}
                    <div class="col-12">
                        <div class="mb-3 row">
                            <div id="collapseOne3" class="accordion-collapse collapse show mt-3"
                                aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <div class="row">
                                        <ul class="tableList">
                                            <li class="col-md-2 position_center tabelItemList">
                                                {{ __('payment.bank_name') }}</li>
                                            <li class="col-md-2 position_center tabelItemList">
                                                {{ __('payment.account_type') }}</li>
                                            <li class="col-md-2 position_center tabelItemList">
                                                {{ __('payment.iban') }}</li>
                                            <li class="col-md-2 position_center tabelItemList">
                                                {{ __('payment.payment_key') }}</li>
                                            <li class="col-md-2 position_center tabelItemList">
                                                {{ __('payment.bank_url') }}</li>
                                            <li class="col-md-2 position_center tabelItemList">
                                                {{ __('payment.image') }}</li>
                                        </ul>
                                        @forelse ($paymentMethod->banks as $key => $bank)
                            
                                            <div class="old_items" data-group="banksList">
                                                <input type="hidden" data-type="old_id"
                                                    value="{{ $bank->id }}" name="old[id][]">
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <input type="hidden" data-name="id"
                                                            value="{{ $bank->id }}">
                                                        <input type="text" class="form-control" data-name="bank_name" placeholder="{{ __('payment.bank_name') }}" value="{{ $bank->bank_name }}" name="old[bank_name][]">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <input type="text" class="form-control"
                                                            data-name="account_type" placeholder="{{ __('payment.account_type') }}"   value="{{ $bank->account_type }}"   name="old[account_type][]">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <input type="text" class="form-control" data-name="iban" placeholder="{{ __('payment.iban') }}" name="old[iban][]" value="{{ $bank->iban }}">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <input type="text" class="form-control" data-name="payment_key" placeholder="{{ __('payment.payment_key') }}" value="{{ $bank->payment_key }}" name="old[payment_key][]">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <input type="text" class="form-control" data-name="bank_url" placeholder="{{ __('payment.bank_url') }}" value="{{ $bank->bank_url }}" name="old[bank_url][]">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <input type="file" class="form-control" data-name="image" value="{{ $bank->image }}" name="old[image][]">
                                                        @if ($bank->image != null)
                                                            <div class="col-12">
                                                                <div class="mb-3 row">
                                                                    <div class="col-sm-12">
                                                                        <a href="{{ getImage($bank->image) }}"
                                                                            target="_blank">
                                                                            <img src="{{ getImageThumb($bank->image) }}" alt="" width="100">
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <!-- Repeater Remove Btn -->
                                                    <div
                                                        class="pull-right repeater-remove-btn mt-2">
                                                        <button class="btn btn-danger old_remove-btn"  type="button">
                                                            @lang('admin.delete')
                                                        </button>
                                                    </div>
                                                </div>
                                                <hr>
                                            </div> <!-- //end forelse -->
                                        @empty
                                        @endforelse
                                        <!-- Repeater Heading -->
                                        <!---  Repeater Section Content --->
                                        <div class="repeater-section" style="display: none">
                                            <div class="col-md-12" id="repeater">
                                                <div class="clearfix"></div>
                                                <!-- Repeater Items -->
                                                <div class="items" data-group="banksList">
                                                    <!-- Repeater Content -->
                                                    <div class="col-md-12">
                                                        {{-- <div class="item-content"> --}}
                                                        <div class="row">
                                                            <div class="col-md-2">
                                                                <input type="text" class="form-control"  data-name="bank_name" placeholder="{{ __('payment.bank_name') }}">
                                                            </div>
                                                            <div class="col-md-2">
                                                                <input type="text" class="form-control" data-name="account_type" placeholder="{{ __('payment.account_type') }}">
                                                            </div>
                                                            <div class="col-md-2">
                                                                <input type="text" class="form-control" data-name="iban" placeholder="{{ __('payment.iban') }}">
                                                            </div>
                                                            <div class="col-md-2">
                                                                <input type="text" class="form-control" data-name="payment_key" placeholder="{{ __('payment.payment_key') }}">
                                                            </div>
                                                            <div class="col-md-2">
                                                                <input type="text" class="form-control" data-name="bank_url" placeholder="{{ __('payment.bank_url') }}">
                                                            </div>
                                                            <div class="col-md-2">
                                                                <input type="file" class="form-control" data-name="image">
                                                            </div>
                                                        </div>
                                                        {{-- </div> --}}
                                                    </div>
                                                    <!-- Repeater Remove Btn -->
                                                    <div class="pull-right repeater-remove-btn mt-2">
                                                        <button class="btn btn-danger remove-btn">
                                                            @lang('admin.delete')</button>
                                                    </div>
                                                    <hr>
                                                </div>
                                            </div>
                                        </div>
                                        <!--- /Repeater Section Content --->
                                        <div class="repeater-heading mt-3 d-none">
                                            <div class="col-md-12">
                                                <button type="button"class="btn btn-success form-control pull-right repeater-add-btn pt-3" id="buttons" id="donors_address">
                                                    <i class="bx bx-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="repeater-show-heading mt-3">
                                            <div class="col-md-12">
                                                <button type="button"
                                                    class="btn btn-success form-control pull-right repeater-show-btn pt-3 "
                                                    id="buttons" id="donors_address">
                                                    <i class="bx bx-plus"></i>
                                                </button>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>