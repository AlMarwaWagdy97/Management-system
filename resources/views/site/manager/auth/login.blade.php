@extends('site.app')

@section('title', __('Manager Login'))

@section('content')

    <!--Login-->
    <div class="login-container">
        <div class="container">
            <div class="sub row justify-content-center align-items-center min-vh-100">
                <div class="col-lg-5 col-md-8 col-sm-10">
                    <div class="login-card">
                        <div class="login-header text-center mb-4">
                            <i class="fas fa-handshake fa-5x"></i>
                            <h2 class="mt-3"> @lang('Login') </h2>
                        </div>
                        <livewire:site.manager.login />
                    </div>

                </div>
            </div>
        </div>
        </div>
        <!--Login-->

    @endsection
