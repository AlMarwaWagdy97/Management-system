<div class="Media-center">
    <h4 class="my-5">المركز الاعلامي</h4>
    <div class="row">
        @forelse ($mediaItems as $media)
        <div class="col-6 col-lg-3">
            <div class="card">
                <img src="{{asset( getImage($media->image)) }}" class="card-img-top" alt="{{ $media->trans->first()->title }}" />
                <div class="card-body">
                    <h5 class="card-title"> {{ $media->trans->first()->title }} </h5>
                </div>
            </div>
            <div class="infobox p-3">
                <p class="mb-3"> {!! substr($media->trans->first()->description, 0, 200) !!} </p>
                <a href="{{ route('site.media.show', $media->trans->first()->slug) }}" class="button-secandry btn-small d-inline-block">
                    المزيـــــــــد
                </a>
            </div>
        </div>
        @empty
            
        @endforelse
    
    </div>

    <a href="{{ route("site.media.index") }}" class="btn bg-success"> عرض الكل</a>
</div>
