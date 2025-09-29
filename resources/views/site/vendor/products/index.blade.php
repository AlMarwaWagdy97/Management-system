@extends('site.app')

@section('title', __('Vendor Dashboard'))

@section('content')

<div class="profile">
    <div class="container bg-light mt-5 border-main">
        <div class="row gx-2">

            <x-site.vendors.side-menu />

            <!--index section -->
            <div class="col-12 order-lg-2 order-2 mx-auto">
                @livewire('site.vendor.products.index')
            </div>
            <!--index section -->

        </div>
    </div>
</div>

@endsection
