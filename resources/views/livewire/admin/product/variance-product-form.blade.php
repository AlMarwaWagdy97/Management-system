<div>


    <input type="hidden" wire:model="product_id" id="product_id">
    <div class="row  gy-4 d-flex justify-content-start">
        {{-- Start Attribute Set And Value  --}}
        @foreach ($unique_attributeSet as $key => $item)
        <div class="col-lg-4 col-md-6">
            <label for="example-text-input" class="col-sm-12 col-form-label">{{ $item->trans->where('locale', $current_lang)->first()->title }}
                <span class="text-danger">*</span></label>
            <select class="form-select form-select-sm attribute-set @error('attributes') is-invalid @enderror" wire:model.prevent="attributes.{{ $item->id }}" aria-label=".form-select-sm example" >
                <option value=""></option>
                @foreach ($item->attribute as $index => $value)
                <option value="{{ $value->id }}">
                    {{ $value->trans->where('locale', $current_lang)->first()->title }}
                </option>
                @endforeach

            </select>

        </div>
        @endforeach


    </div>
    <div class="row mt-3">
        <div class="col">
            <!-- Name input -->
            <div class="form-outline">
                <label class="form-label" for="form8Example1">@lang('products.sku')</label>
                <input type="text" class="form-control  mb-1 @error('sku') is-invalid @enderror"  id="sku" wire:model="sku" />
                    @if ($errors->has('sku'))
                    <p style="color: red;">{{$errors->first('sku')}}</p>
                @endif
            </div>
        </div>
        <div class="col-md-6">
            <!-- Name input -->
            <div class="form-outline">
                <label class="form-label" for="form8Example1">@lang('products.quantity')</label>
                <input type="number" class="form-control  mb-1 @error('quantity') is-invalid @enderror"  id="sku"  wire:model="quantity" />
                @if ($errors->has('quantity'))
                <p style="color: red;">{{$errors->first('quantity')}}</p>
            @endif
            </div>
        </div>
        <div class="col-md-6">
            <!-- Email input -->
            <div class="form-outline">
                <label class="form-label" for="form8Example2">@lang('products.price')
                </label>
                <input type="number" class="form-control  mb-1 @error('price') is-invalid @enderror"   wire:model="price" id="price" />
                @if ($errors->has('price'))
                <p style="color: red;">{{$errors->first('price')}}</p>
            @endif
            </div>
        </div>

        <div class="col-md-6">
            <!-- Email input -->
            <div class="form-outline">
                <label for="example-number-input" col-form-label class="mb-2">
                    @lang('products.sale_price') <a href="javascript:;" id="addTime_variance">@lang('products.addTime')</a><a href="javascript:;" id="cancel_variance" class="d-none">@lang('products.cancel')</a></label>
                <input type="number" class="form-control mb-1 @error('sale_price') is-invalid @enderror" wire:model="sale_price" id="sale_price" />
                @if ($errors->has('sale_price'))
                <p style="color: red;">{{$errors->first('sale_price')}}</p>
            @endif
            </div>
        </div>
    </div>
    <div class="row d-none mt-5" id="dateForm_variance">
        <div class="col-md-6">
            <div class="row mb-3">
                <label for="example-number-input" col-form-label>
                    @lang('products.start_at')</label>
                <div class="col-sm-12">
                    <input class="form-control" type="date" wire:model="start_at" id="start_at">
                </div>
            </div>
        </div>
        {{-- end_at ------------------------------------------------------------------------------------- --}}
        <div class="col-md-6">
            <div class="row mb-3">
                <label for="example-number-input" col-form-label>
                    @lang('products.end_at')</label>
                <div class="col-sm-12">
                    <input class="form-control" type="date" wire:model="end_at"  id="end_at">
                </div>
            </div>
        </div>

    </div>

    {{-- Button save --}}
    <button type="button" class="btn btn-success add_variance"
    wire:click="save()">@lang('button.save')</button>
</div>
