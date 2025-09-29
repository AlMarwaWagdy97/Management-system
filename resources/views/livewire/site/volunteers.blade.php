<div class="col-12 col-md-6 m-3 p-3">
    @if(session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show mt-3 mx-2" role="alert">
        <p class="text-center">{{ session('success') }} </p>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <form wire:submit.prevent="send" class="">
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label" dir="rtl"> @lang('Volunteer Name'):</label>
            <input type="text" wire:model="name" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="@lang('Full Name')"/>
            @error('name')
                <span class="text-danger">{{ $message }}</span>
            @enderror 
        </div>

        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label" dir="rtl"> @lang('National Id'):</label>
            <input type="text" wire:model="identity" class="form-control numberInput" aria-describedby="emailHelp" placeholder="@lang('National Id')"/>
            @error('identity')
                <span class="text-danger">{{ $message }}</span>
            @enderror 
        </div>

        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">@lang('Mobile number'):</label>
            <input type="text" wire:model="mobile" class="form-control numberInput" aria-describedby="emailHelp" placeholder="@lang('Mobile number')"
            oninput="this.value = this.value.replace(/[^0-9]/g, '');" maxlength="9" />
            @error('mobile')
                <span class="text-danger">{{ $message }}</span>
            @enderror 
        </div>

        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">@lang('Nationality') :</label>
            <input type="text" wire:model="nationality" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="@lang('Nationality')"/>
            @error('nationality')
                <span class="text-danger">{{ $message }}</span>
            @enderror 
        </div>

        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label"> @lang('Gender'):</label>
            <select class="form-control" wire:model="gender" id="gender">
                <option value="ذكر">ذكر</option>
                <option value="انثي">انثي</option>
            </select>
            @error('gender')
                <span class="text-danger">{{ $message }}</span>
            @enderror 
        </div>

        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">@lang('Email'):</label>
            <input type="email" wire:model="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="@lang('Email')"/>
            @error('email')
                <span class="text-danger">{{ $message }}</span>
            @enderror 
        </div>
        <div class="col-12 text-center">
            <button type="submit" class="btn btn-main bg-main px-5 py-2">
                @lang('Send')
            </button>
        </div>
    </form>
</div>
