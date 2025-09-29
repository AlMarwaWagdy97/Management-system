<div>
    <!--volunteer-->
<div class="Date my-5">
    <div class="container p-lg-5">
        <h5 class="text-end py-3">
            <a href="{{ route('site.volunteering.index') }}"> @lang('volunteers.volunteering')</a> /
            @lang('volunteers.volunteers') </a>
        </h5>
        <div class="Volunteer contant py-5">
            @if(session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show mt-1 mx-2" role="alert">
                <p class="text-center">{{ session('success') }} </p>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @else
            @endif
            <div class="Fliters">
                <div class="filter mx-3 d-flex flex-wrap justify-content-between align-items-center">
                    <select class="ps-5 pe-2 py-2  mb-2 mb-lg-0 " wire:model="filterMonth">
                        @forelse($months as $key => $month)
                            <option value="{{ $key }}"> {{ $month }} </option>
                        @empty
                        @endforelse
                    </select>

                    <div class="people d-flex align-items-center">
                        <div class="PeopleCheckbox ">
                            <input type="checkbox" wire:model="filterByTeam" id="team" value="team" />
                            <label for="team"> @lang('volunteers.team') </label>
                        </div>

                        <label data-toggle="tooltip" data-placement="top" title=" @lang('volunteers.most_hours') " class="bg-secondary rounded-6 d-flex flex-row gap-1 form-control {{ $sortByWorkingHours != '' ? 'active-sort' : '' }} ">
                            <input wire:model.live="sortByWorkingHours" type="checkbox" value="working_hours" class="checkbox-hidden">
                            <span> @lang('volunteers.most_hours') </span>
                        </label>
                    </div>
                    <div class="people my-3 d-flex align-items-center">
                        <div class="PeopleCheckbox">
                            <input type="checkbox" wire:model="filterByVolunteer" id="volunteer" value="volunteer" />
                            <label for="volunteer">@lang('volunteers.Individuals')</label>
                        </div>

                        <label data-toggle="tooltip" data-placement="top" title="@lang('volunteers.important_activities')" class="bg-secondary rounded-6 d-flex flex-row gap-1 form-control {{ $sortByEffective != '' ? 'active-sort' : '' }} ">
                            <input wire:model.live="sortByEffective" type="checkbox" value="working_hours" class="checkbox-hidden">
                            <span> @lang('volunteers.important_activities')</span>
                        </label>
                    </div>


                </div>

                <div class="Cards row px-lg-5 px-3 mt-3">

                    @forelse ($volunteerCarousels as $key => $carousel)
                    @forelse ($carousel as $key => $voluntree)
                    <div class="col-12 col-lg-2">
                        <div class="Card">
                            @switch($voluntree['medal'])
                                @case(1)
                                <img src="{{ site_path('/img/medals/gold.webp') }}" class="medal-top" alt="" />
                                @break
                                @case(2)
                                <img src="{{ site_path('/img/medals/sliver.webp') }}" class="medal-top" alt="" />
                                @break
                                @case(3)
                                <img src="{{ site_path('/img/medals/BronzeMedal.webp') }}/" class="medal-top" alt="" />
                                @break
                                @default
                            @endswitch

                            <img src="{{ getImage($voluntree['image']) }}" class="man mx-auto" alt="" />
                            <div class="text">
                                <span>@lang('volunteers.the_volunteer') </span>
                                <h5> {{ $voluntree['name'] }} </h5>
                                <p class="mt-3"> {{ $voluntree['activity'] }} </p>
                            </div>
                        </div>
                    </div>
                    @empty
                    @endforelse
                    @empty
                    @endforelse
                </div>

                @if ($volunteerCount - (count($volunteerCarousels) * $pageCount) > 0)
                <button class="btn btn-primay btn-more mt-4" wire:click="showMore">
                    <i class="icofont-caret-left"></i>
                    <span>@lang('More')</span>
                </button>
                @endif

            </div>
        </div>
    </div>
</div>
<!--volunteer-->
</div>
