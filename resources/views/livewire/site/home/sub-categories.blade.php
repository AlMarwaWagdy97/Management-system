<div>
@if ($selectedCategory == 'zakah')
    <livewire:site.home.charity-zakah />
@elseif($selectedCategory == 'gifts')
    <livewire:site.home.charity-gifts />
@else
<!-- projects -->
    <section id="projects">
        <div class="container mt-md-5">
            <div class="categories-nav">
                <ul class="navbar-nav">
                    @if($subcategories->count() > 1 )
                    <li class="nav-item" wire:click="selectSubcategory(0)">
                        <a class="nav-link {{  $selectedSubcategory == 0 ? 'active' : null  }}" aria-current="page"> @lang('All') </a>
                    </li>
                    @endif
                    @if ($subcategories && $subcategories->count() <= 3) 
                        @forelse ($subcategories as $subcategory) <li class="nav-item" wire:click="selectSubcategory({{ $subcategory->id }})">
                        <a class="nav-link {{ $selectedSubcategory == $subcategory->id ? 'active' : null }} " aria-current="page" role="button">
                            {{ $subcategory->trans->where('locale', $current_lang)->first()->title }}
                        </a>
                        </li>
                        @empty
                        @endforelse
                    @else
                        <!-- 0, 1, 2 indeces -->
                        <li class="nav-item" wire:click="selectSubcategory({{ $subcategories[0]->id }})">
                            <a class="nav-link {{ $selectedSubcategory == $subcategories[0]->id ? 'active' : null }}" aria-current="page" role="button">{{ $subcategories[0]->trans->where('locale', $current_lang)->first()->title }}</a>
                        </li>
                        <li class="nav-item" wire:click="selectSubcategory({{ $subcategories[1]->id }})">
                            <a class="nav-link {{ $selectedSubcategory == $subcategories[1]->id ? 'active' : null }}" aria-current="page" role="button">{{ $subcategories[1]->trans->where('locale', $current_lang)->first()->title }}</a>
                        </li>
                        <li class="nav-item" wire:click="selectSubcategory({{ $subcategories[2]->id }})">
                            <a class="nav-link {{ $selectedSubcategory == $subcategories[2]->id ? 'active' : null }}" aria-current="page" role="button">{{ $subcategories[2]->trans->where('locale', $current_lang)->first()->title }}</a>
                        </li>
                        <!-- show the reminder indeces in a dropdown -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle
                                {{ !in_array($selectedSubcategory, [0, $subcategories[0]->id, $subcategories[1]->id, $subcategories[2]->id]) ? 'active' : null }}" role="button" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                أخـــــــرى
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                @forelse ($subcategories as $key => $subcategory)
                                    @if ($key < 3) @continue @endif <!-- skip index 0, 1, 2 -->
                                    <li wire:click="selectSubcategory({{ $subcategory->id }})">
                                        <a class="dropdown-item {{ $selectedSubcategory == $subcategory->id ? 'active' : null }} " {{ $selectedSubcategory == $subcategory->id ? 'style=color:white!important;' : null }} role="button"> {{ $subcategory->trans->where('locale', $current_lang)->first()->title }}</a>
                                    </li>
                                @empty
                                @endforelse
                            </ul>
                        </li>
                        @endif
                </ul>
            </div>

            <div class="row projects-body g-3">
                <!-- PROJECT CLUSTERS (start) -->
                @forelse ($projectCarousels as $key => $carousel)

                <div class="projects-body {{  $key % 2 == 0? 'wow bounceInLeft' : ' wow bounceInRight' }}">
                    <div class="">
                        <div class="row">
                            @forelse ($carousel as $key => $project)
                            <livewire:site.home.project :project="$project" :wire:key="$project['id']" />
                            @empty
                            <h2 class="text-secondary text-center py-5 d-none">@lang('No projects available')</h2>
                            @endforelse
                        </div>
                    </div>
                </div>
                @empty
                <h2 class="text-secondary text-center py-5"> @lang('No_projects_available') </h2>
                @endforelse
                <!-- PROJECT CLUSTERS (end) -->
            </div>
            
            @if ($projectsCount - (count($projectCarousels) * 3) > 0)
            <div class="text-center my-2">
                <a wire:click="loadProjects" class="projects-more text-decoration-none" role="button"> @lang('More') </a>
            </div>
            @endif
        </div>
    </section> 

    @livewire('site.carts.add-modal')


@endif


