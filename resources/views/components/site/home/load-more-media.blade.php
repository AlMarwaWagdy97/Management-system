<div class="row">
@forelse ($items as $item)
        <div class="col-6 col-lg-3">
            <div class="card">
                <img src="{{asset( getImage($item->image)) }}" class="card-img-top" alt="{{ $item->trans->first()->title }}" />
                <div class="card-body">
                    <h5 class="card-title"> {{ $item->trans->first()->title }} </h5>
                </div>
            </div>
            <div class="infobox p-3">
                <p class="mb-3"> {!! substr($item->trans->first()->description, 0, 200) !!} </p>
                <a href="{{ route('site.media.show', $item->trans->first()->slug) }}" class="button-secandry btn-small d-inline-block">
                    عرض
                </a>
            </div>
        </div>
    @empty
        <div class="alert alert-info text-center" role="alert">
            No More Items
        </div>
    @endforelse
</div>
@if ($items->count())
    <div id="loadMore" class="text-center my-2">
        <a hx-get="{{ route('site.media.loadMore', ['start' => $start + $count, 'count' => $count, 'search' => request()->search]) }}"
            hx-indicator="#loading" hx-target="#loadMore" hx-swap="outerHTML"
            class="btn px-5 py-2 mx-auto bg-success">المزيد</a>
    </div>
@endif