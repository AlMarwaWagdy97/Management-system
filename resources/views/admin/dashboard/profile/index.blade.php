@extends('admin.app')

@section('title', trans('users.profile'))
@section('title_page', trans('users.profile'))

@section('content')




<div class="container">
    <div class="main-body">
        <form action="{{ route('admin.profile.update') }}" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="{{ $user->id }}">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex flex-column align-items-center text-center">
                                <img src="{{ auth()->user()->image ? asset(auth()->user()->image) : admin_path('images/avatars/avatar-1.png') }}" alt="{{ $user->name }}" class="rounded-circle p-1 bg-primary" width="110">
                                <div class="mt-3">
                                    <h4> {{ $user->user_name }}</h4>
                                    @forelse ($user->roles as $role)
                                    <p class="text-secondary mb-1">{{ $role->name }}</p>
                                    @empty

                                    @endforelse

                                    {{-- <button class="btn btn-primary">Follow</button> --}}
                                    {{-- <button class="btn btn-outline-primary">Message</button> --}}
                                </div>
                            </div>
                            <hr class="my-4" />
                            {{-- image ------------------------------------------------------------------------------------- --}}
                            <div class="col-12">
                                <div class="row mb-3">
                                    <div class="col-sm-12">
                                        <input class="form-control" type="file" placeholder="@lang('admin.image')" id="example-number-input" name="image" value="{{ old('image') }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">@lang('users.name')</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <input type="text" class="form-control" name="name" value="{{ $user->user_name }}" />
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">@lang('users.email')</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <input type="text" class="form-control" name="email" value="{{ $user->email }}" />
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">@lang('users.mobile')</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <input type="text" class="form-control" name="mobile" value="{{ $user->mobile }}" />
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">@lang('admin.password')</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <input type="password" name="password" class="form-control" />
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">@lang('admin.confirm_password')</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <input type="password" name="password_confirmation" class="form-control" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3"></div>
                                <div class="col-sm-9 text-secondary">
                                    <input type="submit" class="btn btn-primary px-4" value="Save Changes" />
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </form>
    </div>
</div>

@endsection
