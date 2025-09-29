<div>
    <section class="RamdanProjects mt-5">
        <div class="container pb-2 text-center">
            <h2> {{ $category->transNow->title }} </h2>

            <div class="Ramdan position-relative" id="projects">
                @forelse ($projectCarousels as $key => $carousel)
                    <div class="row">
                        {{-- <div class="swiper-wrapper"> --}}
                            @forelse ($carousel as $key => $project)
                                    <livewire:site.home.project :project="$project"  :wire:key="$project['id']" />
                            @empty
                                <h2 class="text-secondary text-center py-5 d-none">@lang('No projects available')</h2>
                            @endforelse
                        {{-- </div> --}}
                    </div>
              
                @empty
                    <h2 class="text-secondary text-center py-5"> @lang('No_projects_available') </h2>
                @endforelse
            </div>

            @if ($projectsCount - (count($projectCarousels) * 3) > 0)
                <div class="infoBox text-center mt-3">
                    <a wire:click="loadProjects" class="button-more d-inline-block"> @lang('More') </a>
                </div>
            @endif

        </div>

    </section>

    @livewire('site.carts.add-modal')
</div>
