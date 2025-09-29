@extends('site.app')
@section('title', __('Orders List'))
@section('content')

<div class="profile">
    <div class="container bg-light mt-5 border-main">
        <div class="row gx-2">

            <x-site.manager.side-menu />

            <!--edit section -->
            <div class="col-12 order-lg-2 order-2 col-lg-9 mx-auto ">
                @livewire('site.manager.orders')
            </div>

        </div>
    </div>
</div>

@endsection
