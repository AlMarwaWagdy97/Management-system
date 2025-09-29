<div>
    <div class="col-12 col-md-6 mx-md-auto">
        <div class="login_form rounded mx-auto text-center mb-5 border p-3 ">
            <div class="head py-3 rounded-3">
                <h4> @lang('Vendor') </h4>
            </div>
     
            <form wire:submit.prevent="login" class="">
                <div class="body my-2 d-flex flex-column align-items-center">
                    @if($errorMessage)
                        <div class="alert alert-danger my-3 w-75" id="emptyInputAlert" role="alert">
                            {{ $errorMessage }}
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-12 my-3">
                            <label for="" class="text-end col-12">@lang('Email')</label>
                            <input type="text" wire:model="email" class="form-control p-2 my-1" required />
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-12 my-2">
                            <label for="" class="text-end col-12">@lang('Password')</label>
                            <input type="password" wire:model="password" class="form-control p-2 my-1" required />
                            @error('password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    
                    <button type="submit" class="btn d-block my-2 px-5 py-2 btn-send">
                        @lang('Login')
                    </button>
                    
                </div>
            </form>
        </div>
    </div>

   
</div>

