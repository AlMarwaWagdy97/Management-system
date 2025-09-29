@extends('site.app')

@section('title', __('Vendor Login'))

@section('content')

<!--Login-->
<div class="Login">
    <div class="container text-center">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="title d-flex justify-content-center align-items-center my-md-4 my-1">
                    <h1 class="mx-md-3 mx-1"> @lang('Login') </h1>
                    <img class="img-fuild login-icon" src="{{ site_path('img/icon.gif') }}" alt="@lang('Login')" />
                </div>
            </div>

            <livewire:site.vendor.login />

        </div>
    </div>
</div>
<!--Login-->

@endsection
