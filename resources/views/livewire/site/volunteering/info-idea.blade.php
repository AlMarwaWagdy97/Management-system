<div>
    <div class="AdeaInfo border-R-15 row justify-content-evenly align-items-center">

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



        <div class="col-12 col-lg-12 p-lg-4 border-R-15 mt-3 py-3 rounded">
            <div class="WriteArea mx-auto border border-R-15 p-3 text-center rounded">

                <h2 class="text-primary my-2 me-3 fw-bold">
                    {{ $idea->subject }}
                </h2>

                <div class="form-control p-3 text-center">
                    <h5 class="text-end  text-black"> {{ $idea->name }}</h5>
                    <p>
                        {{ $idea->message  }}
                    </p>
                </div>

                <div class="icons my-3 d-flex justify-content-start">

                    <div class="i like rounded-circle mx-3" wire:click="loves">
                        <span>
                            {{ count($idea['loves']) }}
                        </span>
                        <i class="icofont-heart"></i>
                    </div>
                    
                    <div class="i comment rounded-circle" wire:click="showCommentModel()" class="btn" data-bs-toggle="modal" data-bs-target="#addComment">
                        <span>
                            {{ count($idea->comments) }}
                        </span>
                        <i class="icofont-speech-comments mt-1"></i>
                    </div>

                    <!-- Modal -->
                    @if(@$showModalComent)
                        <div class="modal fade show" id="addComment" style="display: block;" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel"> @lang('volunteers.add_comment_in') {{ $idea->subject }} </h5>
                                        <button type="button" class="btn-close" wire:click="closeCommentModel()" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="">
                                            <div class="row px-2 mt-2">
                                                {{-- <label for="exampleInputIdentify" class="form-label col-12 mt-1 text-end"> @lang('volunteers.name') </label> --}}
                                                <input type="text" wire:model="name" class="form-control" id="exampleInputName" placeholder="@lang('volunteers.name')" required />
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
                                        <button type="button" class="btn btn-primary btn-sm" wire:click="addComment()">@lang('Send')</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                   


                </div>

                @if($idea->comments)
                    <h4 class="text-black d-flex justify-content-start pt-3">@lang('volunteers.comments'):</h4>
                    @forelse ($idea->comments as $comment)
                    <div class="row m-3">
                        <div class="col-12 bg-light p-3 text-end rounded-6">
                            <p>
                                <span class="text-primary fw-bold">{{ $comment->name }} : </span>
                                <span>{{ $comment->comment }}</span>
                            </p>
                        </div>
                    </div>

                    @empty

                    @endforelse
                @endif

            </div>
        </div>

    </div>



</div>
