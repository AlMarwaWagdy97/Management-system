@extends('site.app')
@section('title', "volunteers")


@section('content')

<!--IdeasPage-->
<div class="Ideas my-5">
    <div class="container justify-content-center align-items-center align-contenet-center text-center">

        <div class="Farm mx-auto px-4 py-4 border-R-15">
            <h5 class="text-end me-lg-5">
                <a  class="text-gray fw-bold" href="{{ route('site.volunteering.index') }}"> @lang('volunteers.volunteering')</a> /
                @lang('volunteers.interactive_idea_bank') </a>
            </h5>

            @livewire('site.volunteering.idea')

        </div>
    </div>
</div>

<!--IdeasPage-->

@endsection
