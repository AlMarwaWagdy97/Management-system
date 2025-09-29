<div>
    @if(session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show mt-3 mx-2" role="alert">
        <p class="text-center">{{ session('success') }} </p>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <form wire:submit.prevent="send" class="">
        <div class="form-group mt-2">
            <label class="form-label">@lang('Full Name')</label>
            <input type="text" wire:model="full_name" class="form-control" value="">
            @error('full_name')
                <span class="text-danger">{{ $message }}</span>
            @enderror 
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group mt-2">
                    <label class="form-label">@lang('Phone')</label>
                    <input type="text" wire:model="phone" class="form-control">
                    @error('phone')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror 
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mt-2">
                    <label class="form-label">@lang('Email')</label>
                    <input type="email" wire:model="email" class="form-control">
                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group mt-2">
                    <label class="form-label">@lang('Type message')</label>
                    <select wire:model="type" class="form-control">
                        <option value=""> @lang('Choose the purpose of the message.')</option>
                        <option value="شكوى"> @lang('Complaint')  </option>
                        <option value="اقتراح"> @lang('Suggestion') </option>
                        <option value="استفسار"> @lang('Inquiry') </option>
                    </select>
                    @error('type')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mt-2">
                    <label class="form-label">@lang('Topic')</label>
                    <input type="text" wire:model="title" class="form-control">
                    @error('title')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        <div class="form-group mt-2">
            <label class="form-label">@lang('City')</label>
            <input type="text" wire:model="city" class="form-control">
            @error('city')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>


        <button type="submit" class="btn bg-main my-2"> @lang('Send') </button>
      </form>
</div>
