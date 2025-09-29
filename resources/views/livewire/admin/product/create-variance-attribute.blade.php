<div class="col-lg-4 col-md-6">
    <label for="example-text-input"
        class="col-sm-12 col-form-label">{{ $item->trans->where('locale', $current_lang)->first()->title }}
        <span class="text-danger">*</span></label>
    <select class="form-select form-select-sm attribute-set"  wire:model="attributesvalue_id"  aria-label=".form-select-sm example">
        <option value=""></option>
        @foreach ($item->attribute as $index=> $value)
            <option value="{{$value->id }}">
                {{ $value->trans->where('locale', $current_lang)->first()->title }}
            </option>

        @endforeach

    </select>
    {{-- @dd($item->attribute) --}}
</div>


