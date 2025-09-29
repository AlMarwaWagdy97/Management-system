@extends('site.app')


@section('content')

<section>
    <div class="container mt-3">
        <div class="Media-center">
            <h2 class="text-center my-5">
              المركز الاعلامي
            </h2>
            <div class="row">
                @forelse ($items as $media)
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
                            عرض
                        </a>
                    </div>
                </div>
                @empty
                @endforelse
            </div>
            @if ($items->count())
            <div id="loadMore" class="text-center my-2">
                <a hx-get="{{ route('site.media.loadMore', [ 'start' => @request()->key ??8, 'count' => 8]) }}"
                    hx-indicator="#loading" hx-target="#loadMore" hx-swap="outerHTML"
                    class="btn px-5 py-2 mx-auto bg-success">
                    المزيد
                </a>
            </div>
        @endif
        </div>
    </div>
</section>

@endsection
