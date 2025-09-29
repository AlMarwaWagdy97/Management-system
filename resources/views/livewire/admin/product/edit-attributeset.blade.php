<div>
    <div class="modal-body d-flex justify-content-center grid gap-3">
        <input type="hidden" id="att_set" value="{{ $attributeSet }}">
        @foreach($attributeSet as $item)
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="options[]" wire:model.prevent="attributes.{{ $item->id }}"  id="option{{ $item->id }}">
            <label class="form-check-label" for="option{{ $item->id }}">  {{ $item->trans->where('locale',$current_lang)->first()->title }}  </label>
            @if ($errors->has('attributes'))
            <div class="alert alert-danger">
                {{ $errors->first('attributes') }}
            </div>
            @endif
        </div>
        @endforeach

    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">@lang('button.close')</button>
        <button type="button" class="btn btn-success" wire:click="save" class="btn btn-danger save-attr-set close-modal"
            data-bs-dismiss="modal">
            @lang('button.save')
        </button>
    </div>
</div>


{{-- <script>
    $(".save-attr-set").on("click", function(event){
        var $attr = $("#att_set").val();
      Livewire.emit('updateAttForm', ['unique_attributeSet'=>  $attr]);
      })
</script> --}}