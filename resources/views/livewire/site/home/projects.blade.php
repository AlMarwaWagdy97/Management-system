@if($showSection)
<section class="RamdanProjects mt-5">
    <div class="container pb-2 text-center">
        <h2>برامج متنوعة تستحق عطائكم و دعمكم</h2>
        </br>
        <div class="Ramdan position-relative">
            <div class="swiper RamdanProjectSwiper">
                <!-- Additional required wrapper -->
                <div class="swiper-wrapper">
                    @forelse ($projects as $key => $project)
                    <div class="swiper-slide">
                        <!-- Card with input for amount only -->
                        <livewire:site.home.project :project="$project" :wire:key="$project['id']" />
                    </div>
                    @empty
                    @endforelse
                </div>

            </div>
            <div class="swiper-button-next RamdanProject-button-next"></div>
            <div class="swiper-button-prev RamdanProject-button-prev"></div>
        </div>
    </div>
    @livewire('site.carts.add-modal')
</section>
@endif
