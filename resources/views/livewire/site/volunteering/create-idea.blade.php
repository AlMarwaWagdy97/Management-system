<div>


    <div class="AdeaInfo my-5 border-R-15 row justify-content-evenly align-items-center">

        <div class="col-12 col-lg-5 p-lg-5 border-R-15 ">
            @if(session()->has('success'))
            <div class="row">
                <div class="alert alert-success alert-dismissible fade show mx-2" role="alert">
                    <p class="text-center">{{ session('success') }} </p>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
            @endif
            <div class="row px-2 mt-2">
                {{-- <label for="exampleInputIdentify" class="form-label col-12 mt-1 text-end"> @lang('volunteers.name') </label> --}}
                <input type="text" wire:model="name" class="form-control" id="exampleInputName" placeholder="@lang('volunteers.name')" />
                @error('name')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="mt-3 px-2 row">
                {{-- <label for="exampleInputIdentify" class="form-label col-12 mt-1 text-end"> @lang('volunteers.subject') </label> --}}
                <input type="text" wire:model="subject" class="form-control" id="exampleInputSubject" placeholder="@lang('volunteers.subject')" />
                @error('subject')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="mt-3 row">
                {{-- <label class="form-label col-12 mt-1 text-end"> @lang('volunteers.idea') </label> --}}
                <div class="WriteArea mx-auto border-R-15">
                    <textarea wire:model="message" class="form-control p-3" placeholder=" @lang('volunteers.addIdea') "></textarea>
                </div>
                @error('message')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class=" text-center text-lg-center ms-3 mt-3 mt-lg-5 mb-3">
                <button type="button" wire:click="submit" class="btn rounded-pill bg-success text-white px-5">
                    <span> @lang('Send') </span>
                </button>
            </div>

        </div>
    </div>
</div>
