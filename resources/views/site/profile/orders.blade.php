@extends('site.app')
@section('title', __('Orders List'))
@section('content')


<main>
    <div class="profile-container">
        <div class="container py-5 mt-3">
            <div class="row">
                <!-- Sidebar Navigation -->
                <x-site.profile.side-menu />

                <!-- Main Content -->
                <div class="col-md-8">
                    <!-- Personal Info Section (Hidden) -->
                    @livewire('site.profile.orders')

                </div>
            </div>
        </div>
    </div>
</main>

@endsection
