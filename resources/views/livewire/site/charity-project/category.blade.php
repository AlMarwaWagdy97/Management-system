<div class="row d-flex justify-content-center align-items-center">
    @forelse ($projectCarousels as $key => $carousel)

        @forelse ($carousel as $key => $project)
            <div class="col-12 col-lg-3">
                <livewire:site.home.project :project="$project" :wire:key="$project['id']" />
            </div>
        @empty
        <h2 class="text-secondary text-center py-5 d-none">@lang('No projects available')</h2>
        @endforelse

    @empty
    <h2 class="text-secondary text-center py-5"> @lang('No_projects_available') </h2>
    @endforelse

    @if ($projectsCount - (count($projectCarousels) * 8) > 0)
        <a class="button-secandry d-inline-block projects-more text-decoration-none" role="button"> @lang('More') </a>
    @endif
    
    @livewire('site.carts.add-modal')

</div>



