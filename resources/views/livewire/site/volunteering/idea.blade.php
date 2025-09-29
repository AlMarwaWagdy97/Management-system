<div>
    <div class="AddIdea text-center text-lg-start ms-3 mt-3 mt-lg-0">
        <a href="{{ route('site.volunteering.create-ideas') }}" class="btn rounded-pill">
            <i class="fa-solid fa-plus mx-1"></i>
            <span> @lang('volunteers.add_idea') </span>
        </a>
    </div>

    <div class="row mx-auto">
        @if(session()->has('success'))
        <div class="row">
            <div class="alert alert-success alert-dismissible fade show m-2" role="alert">
                <p class="text-center">{{ session('success') }} </p>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
        @endif
    </div>
    
    <div class="AdeaInfo border-R-15 row justify-content-evenly align-items-center">
        @forelse ($ideaCarousels as $ind => $carousel)
        @forelse ($carousel as $key => $idea)
        <div class="col-12 col-lg-5 p-lg-4 border-R-15 mt-3 py-3 rounded">
            <div class="WriteArea mx-auto border border-R-15 p-3 text-center rounded">

                <h4 class="text-primary my-2 me-3 fw-bold">
                    {{ $idea['subject'] }}
                </h4>

                <div class="form-control p-3 text-center">
                    <h5 class="text-end text-black"> {{ $idea['name'] }}</h5>
                    <p>
                        {{ substr($idea['message'],0 , 600 ) }}
                    </p>
                </div>

                <div class="icons my-3 d-flex justify-content-end">

                    <div class="i comment rounded-circle" wire:click="showCommentModel({{ $idea['id'] }})" class="btn" data-bs-toggle="modal" data-bs-target="#addComment_{{ $ind }}_{{ $key }}">
                        <i class="icofont-speech-comments mt-1"></i>
                    </div>

                    <!-- Modal -->
                    @if(@$showModalComent[$idea['id']])
                    <div class="modal fade show" id="addComment_{{ $ind }}_{{ $key }}" style="display: block;" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel"> @lang('volunteers.add_comment_in') {{ $idea['subject'] }} </h5>
                                    <button type="button" class="btn-close" wire:click="closeCommentModel({{ $idea['id'] }})" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="">
                                        <div class="row px-2 mt-2">
                                            {{-- <label for="exampleInputIdentify" class="form-label col-12 mt-1 text-end"> @lang('volunteers.name') </label> --}}
                                            <input type="text" wire:model="name" class="form-control" id="exampleInputName" required placeholder="@lang('volunteers.name')" />
                                            @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="mt-3 row">
                                            {{-- <label class="form-label col-12 mt-1 text-end"> @lang('volunteers.comment') </label> --}}
                                            <div class="WriteArea mx-auto border-R-15">
                                                <textarea wire:model="comment" class="form-control p-3" required placeholder="@lang('volunteers.comment')"></textarea>
                                            </div>
                                            @error('comment')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary btn-sm" wire:click="addComment({{ $idea['id'] }})">@lang('Send')</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif



                    <div class="i like rounded-circle mx-3" wire:click="updateLoves({{ $ind }}, {{ $key }}, {{ $idea['id'] }})">
                        <span>
                            {{ @$loves[$ind][$key] ? $loves[$ind][$key] : count($idea['loves']) }}
                        </span>
                        <i class="icofont-heart"></i>
                    </div>

                    <a href="{{ route('site.volunteering.info-ideas', $idea['id']) }}" class="i info rounded-circle">
                        <i class="icofont-info-circle"></i>
                    </a>
                </div>
            </div>
        </div>
        @empty
        @endforelse
        @empty
        @endforelse
    </div>

    @if ($ideasCount - (count($ideaCarousels) * $pageCount) > 0)
        <div class="text-center my-2">
            <button wire:click="showMore" class="btn btn-primary btn-sm mb-3 btn-more m-2">
                @lang('More')
                <i class="fa-solid icofont-caret-down p-1"></i>
            </button>
        </div>
    @endif

</div>
