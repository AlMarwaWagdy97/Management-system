@extends('site.app')

@section('content')
    @livewire('site.fast-donation.index')

    <main>

        <x-site.home.sliders />

        <x-site.home.category />

        @livewire('site.home.projects')

        @livewire('site.home.requested-projects')

        <x-site.home.statistics />

        <x-site.home.banars />

    </main>
@endsection

