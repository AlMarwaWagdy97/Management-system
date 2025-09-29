<div>
    <div id="gift-block" class="my-3">
        <label class="form-check-label checkbox-label">
            <input class="form-check-input" wire:model="giftStatus" type="checkbox" data-bs-toggle="collapse" data-bs-target="#gift-body">
            <span class="checkbox"></span>
            @lang('Donate on behalf of your family or friends and share the reward with them')
        </label>

        <div class="collapse py-3 {{  $giftStatus == 1 ? 'show': 'hide' }}" id="gift-body">
            {{-- Given info ---------------------------------- --}}
            <div class="gift-info">
                <h5 class="fs-6 text-center my-3"> @lang('The information of then given') </h5>

                <div class="row">
                    <div class="col-2">
                        <h6 class="fs-6 my-2 text-body-secondary"> @lang('Donation Amount')</h6>

                    </div>
                    <div class="col-10 gift-donation">
                        @if(is_array($donation))
                        @switch($donation['type'])
                        @case('unit')
                        <div class="options my-3">
                            @foreach ($donation['data'] as $key => $data)
                            <div class="option-item">
                                <label data-toggle="tooltip" data-placement="top" title="{{ $project->name }}" class="{{ $colorsAmount[$key % count($colorsAmount ?? [])] }} {{ $unitValueRadio == json_encode($data) ? 'active' : null }} {{ $data['value'] == $donationAmt ? 'active' : null }}
                                                    @if($donation_status == 1) input-disable @endif">
                                    <input wire:model.live="unitValueRadio" type="radio" value="{{ json_encode($data) }}" @if($donation_status==1) disabled @endif>
                                    <h6 class="title">{{ $project['title'] }} </h6>
                                    <div class="price">
                                        {{ $data['value'] }}
                                        <small> &#65020;</small>
                                    </div>
                                </label>
                            </div>
                            @endforeach
                            <div class="mx-2">
                                <input type="number" wire:model.live="unitValueInput" min="0" class="form-control" placeholder="@lang('Another amount')" @if($donation_status==1) disabled @endif>
                            </div>
                        </div>
                        @break

                        @case('share')
                        <div class="options my-3">
                            @foreach ($donation['data'] as $key => $data)
                            <div class="option-item">
                                <label data-toggle="tooltip" data-placement="top" title="{{ $data['name'] }}" class="{{ $colorsAmount[$key % count($colorsAmount ??[])] }}  rounded-6 d-flex flex-row gap-1 {{ @$shareValue == json_encode($data) ? 'active' : null }} {{ $data['value'] == $donationAmt ? 'active' : null }}
                                                            @if($donation_status == 1) input-disable @endif">
                                    <input wire:model.live="shareValue" type="radio" value="{{ json_encode($data) }}" @if($donation_status==1) disabled @endif>
                                    <h6 class="title">{{ $data['name'] }}</h6>
                                    <div class="price">
                                        <span>{{ $data['value'] }}</span>
                                        <small> &#65020;</small>
                                    </div>
                                </label>
                            </div>
                            @endforeach
                        </div>
                        @break

                        @case('fixed')
                        <div class="options my-3">
                            <div class="option-item">
                                <label title="{{ $project['title'] }}" class="bg-secound active @if($donation_status == 1) input-disable @endif">
                                    <h6 class="title">{{ $project['title'] }} </h6>
                                    <div class="price">
                                        {{ $donation['data'] }}
                                        <small> &#65020;</small>
                                    </div>
                                </label>
                            </div>
                        </div>
                        @break

                        @case('open')
                        <div class="options my-3">
                            <div class="option-item">
                                <input type="number" wire:model="openValue" min="0" class="form-control amount" placeholder="@lang('Donation Amount')" @if($donation_status==1) disabled @endif>
                            </div>
                        </div>
                        @break
                        @default
                        <span>Something went wrong, please try again</span>
                        @endswitch
                        @endif
                    </div>
                </div>

                <div class="mb-3 row">
                    <div class="col-sm-4">
                        <input type="text" wire:model="giver_name" class="form-control" placeholder="@lang('Name')">
                    </div>
                    <div class="col-sm-4">
                        <input type="tel" wire:model="giver_mobile" class="form-control" placeholder="@lang('Mobile')">
                    </div>
                    <div class="col-sm-4">
                        <input type="email" wire:model="giver_email" class="form-control" placeholder="@lang('Email')">
                    </div>
                </div>

                <div class="mb-3 row">
                    <div class="col-sm-3">
                        <select wire:model="giftType" class="form-control">
                            <option value=""> @lang('Choose the gifting category') </option>
                            @forelse ( json_decode($cards, true) as $keyCard => $cardtitle)
                            <option value="{{ $keyCard }}"> {{ $cardtitle['title_' . app()->getLocale()] }} </option>
                            @empty
                            @endforelse
                        </select>
                    </div>
                    <div class="col-md-9">
                        @if($cardImages !="")
                        <div class="gifts owl-carousel owl-rtl owl-loaded owl-drag">
                            <div class="row">
                                @forelse(json_decode($cardImages, true) as $keyImg => $img)
                                <div class="gift-item col-md-3 mb-1">
                                    <a href="{{ getImageFileManger($img) }}" target="_blank">
                                        <img src="{{ getImageFileManger($img) }}" alt="">
                                    </a>
                                    <label for="gift-{{ $keyImg }}" class="radio-label">
                                        <input type="radio" id="gift-{{ $keyImg }}" value="{{ $img }}" wire:model.live="selectedCardImage" required="">
                                        <span class="radio"></span>
                                    </label>
                                </div>
                                @empty
                                @endforelse
                            </div>
                            @endif
                        </div>
                    </div>
                    {{-- cards-------------------------------------------------- --}}


                    <label class="form-check-label checkbox-label">
                        <input wire:model="sendCopy" class="form-check-input" type="checkbox">
                        <span class="checkbox"></span>
                        @lang('Send a copy of the card to my mobile phone')
                    </label>
                </div>

            </div>
            @if($giftStatus == 1)
            @livewire('site.gifts.add-gifts', [
            'cards' => $cards,
            'donation' => $donation,
            'colorsAmount' => $colorsAmount,
            'project' => $project,
            ]
            )
            @endif

        </div>






    </div>
