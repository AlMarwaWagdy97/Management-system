
@if($showSection)
    <section class="RamdanProjects high-sales-projects mt-5">
        <div class="container pb-2 text-center">
            {{-- <p class="title">المشاريع الأكثر طلبا</p> --}}
            <h2> المشاريع الأكثر طلبا </h2>
            </br>
            <div class="Ramdan position-relative">
                <div class="swiper RamdanProjectSwiper projectsSlider">
                    <!-- Additional required wrapper -->
                    <div class="swiper-wrapper">
                        @forelse ($projects as $key => $project)
                        <div class="swiper-slide">
                            <!-- Card with input for amount only -->
                            <livewire:site.home.requested-project :project="$project" :wire:key="$project['id']" />
                        </div>
                        @empty
                        @endforelse
                    </div>
                </div>
                <div class="swiper-button-next projectSwiper-button-next"></div>
                <div class="swiper-button-prev projectSwiper-button-prev"></div>
            </div>
        </div>
    </section>
@endif
