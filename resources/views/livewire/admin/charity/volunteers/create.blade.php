<div>
    <div class="row mb-3">
        <div class="alert alert-primary" role="alert">{{ $msg }} </div>

        <label for="example-text-input" class="col-sm-3 col-form-label">{{ trans('admin.volunteers') }}</label>
        <div class="col-sm-9">
            <input class="form-control" wire:model='search_users' wire:keydown.escape="reseting()" type="text">
            @error('name')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <ul class="list-group list-group-numbered">
            @if ($users)
                @forelse ($users as $user)
                    <li class="list-group-item d-flex justify-content-between align-items-start" wire:click="Selectuser({{ $user }})">
                        <div class="text-start col-10">{{ $user->user_name }}</div>
                        <span class="badge bg-primary rounded-pill">@lang('Add')</span>
                    </li>

                @empty
                    <li class="list-group-item d-flex justify-content-between align-items-start" wire:click="NewUser()">
                        <div class="text-start col-10">@lang('New Account')</div>
                    </li>
                @endforelse

            @endif
        </ul>

    </div>

    @if ($new)
        <div class="accordion mt-4 mb-4 " id="accordionExample">
            <div class="accordion-item border rounded ">
                <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne1" aria-expanded="true" aria-controls="collapseOne1">
                        {{ trans('volunteers.info') }}
                    </button>
                </h2>
                <div id="collapseOne1" class="accordion-collapse collapse show mt-3" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                    <div class="accordion-body">

                        <div class="row mb-3">
                            <label for="example-text-input" class="col-sm-3 col-form-label">{{ trans('volunteers.name') }}</label>
                            <div class="col-sm-9">
                                <input class="form-control @error('name') is-invalid @enderror" type="text" name="name" value="{{ old('name') }}">
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="example-tel-input" class="col-sm-3 col-form-label">{{ trans('volunteers.identity') }}</label>
                            <div class="col-sm-9">
                                <input class="form-control @error('identity') is-invalid @enderror" type="text" value="{{ old('identity') }}" name="identity">
                                @error('identity')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="example-tel-input" class="col-sm-3 col-form-label">{{ trans('volunteers.mobile') }}</label>
                            <div class="col-sm-9">
                                <div class="iti form-control">
                                    <input type="tel" id="phone" name="mobile" class="form-control @error('mobile') is-invalid @enderror " value="{{ old('mobile') }}" style="border:none" />
                                </div>
                                <span id="valid-msg" class="hide" style="color:green"></span>
                                <span id="error-msg" class="hide" style="color:red"></span>
                                @error('mobile')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="example-email-input" class="col-sm-3 col-form-label">{{ trans('volunteers.email') }}</label>
                            <div class="col-sm-9">
                                <input class="form-control @error('email') is-invalid @enderror" type="email" value="{{ old('email') }}" name="email">
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="example-tel-input" class="col-md-3 col-form-label">{{ trans('volunteers.nationality') }}</label>
                            <div class="col-md-9">
                                <input class="form-control @error('nationality') is-invalid @enderror" type="text" value="{{ old('nationality') }}" name="nationality">
                                @error('nationality')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        {{ $volunteer }}
    @endif

</div>
