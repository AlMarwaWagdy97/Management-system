@extends('site.app')
@section('title', __('personal account information'))
@section('content')

<main>
    <div class="profile-container ">
        <div class="container card p-5 py-5 mt-3">
            <div class="row">
                <!-- Sidebar Navigation -->
                <x-site.profile.side-menu />

                <!-- Main Content -->
                <div class="col-md-8">
                    @livewire('site.profile.edit')
                </div>
            </div>
        </div>
    </div>
</main>

@endsection
