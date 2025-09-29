@extends('admin.app')

@section('title', trans('pages.pages_show'))
@section('title_page', trans('admin.pages'))
@section('title_route', route('admin.pages.index') )
@section('button_page')
<a href="{{ route('admin.pages.create') }}" class="btn btn-outline-success btn-sm">@lang('admin.create')</a>
@endsection



@section('content')

<div class="card">
    <div class="card-body  search-group">
        <form action="{{route('admin.pages.index')}}" method="get">
            <div class="row">
                <div class="col-md-3 mb-2">
                    <input type="text" value="{{ request()->title != '' ? request()->title : ''}}" name="title" placeholder="{{ trans('pages.search_title') }}" class="form-control">
                </div>
                <div class="search-input col-md-2">
                    <button class="btn btn-primary btn-sm" type="submit" data-hover="{{ trans('button.search') }}"><i class="bx bx-search-alt"> </i></button>
                    <a class="btn btn-success btn-sm" href="{{route('admin.pages.index')}}" data-hover="{{ trans('button.reset') }}"><i class="bx bx-refresh"></i></a>
                </div>
            </div>
        </form>
    </div>
</div>



<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <form id="update-pages" action="{{route('admin.pages.actions')}}" method="post">
                @csrf
            </form>
            <div class="table-responsive">
                <table id="main-datatable" class="table table-bordered text-center table-striped table-table-success table-hover" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr class="bluck-actions" style="display: none" scope="row">
                            <td colspan="8">
                                <div class="col-md-12 mt-0 mb-0 text-center">
                                    <button form="update-pages" class="btn btn-neutral text-success" type="submit" name="publish" value="1"> <i class="bx bxs-check-square"></i></button>
                                    <button form="update-pages" class="btn btn-neutral text-warning" type="submit" name="unpublish" value="1"> <i class="bx bx-no-entry"></i></button>
                                    <button form="update-pages" class="btn btn-neutral text-danger" type="submit" name="delete_all" value="1"> <i class="bx bxs-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th style="width: 1px">
                                <input form="update-pages" class="checkbox-check flat" type="checkbox" name="check-all" id="check-all">
                            </th>
                            <th style="width: 2px">#</th>
                            <th>@lang('admin.title')</th>
                            <th>@lang('admin.content')</th>
                            <th>@lang('admin.image')</th>
                            <th>@lang('admin.actions')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($items as $key => $item)
                        <tr>
                            <td>
                                <input form="update-pages" class="checkbox-check" type="checkbox" name="record[{{$item->id}}]" value={{ $item->id }}>
                            </td>

                            <th scope="row">{{$items->firstItem() +$key}}</th>
                            <td>
                                {{ $item->trans->where('locale',$current_lang)->first()->title}}
                            </td>

                            <td>
                                {{ substr(removeHTML( @$item->trans->where('locale',$current_lang)->first()->content),0,30) }}
                            </td>
                            <td>
                                <a href="{{getImage($item->image)}}" target="_blank"> <img src="{{getImageThumb($item->image)}}" alt="" style="width: 50px"></a>
                            </td>

                            <td>

                                <div class="d-flex justify-content-center">
                                    @if($item->status == 1)
                                    <a href="{{ route('admin.pages.update-status', $item->id) }}" class="btn btn-neutral text-success" data-hover="{{ trans('button.active') }}"><i class="bx bxs-check-square"></i></a>
                                    @else
                                    <a href="{{ route('admin.pages.update-status', $item->id) }}" class="btn btn-neutral text-secondary" data-hover="{{ trans('button.unactive') }}"><i class="bx bx-no-entry"></i></a>
                                    @endif

                                    <a href="{{ route('admin.pages.show', $item->id) }}" class="btn btn-neutral text-info" data-hover="{{ trans('button.show') }}"><i class="bx bxs-show"></i></a>

                                    <a href="{{ route('admin.pages.edit', $item->id) }}" class="btn btn-neutral text-primary" data-hover="{{ trans('button.edit') }}"><i class="bx bxs-edit"></i></a>

                                    <a class="btn btn-neutral text-danger" data-bs-toggle="modal" data-bs-target="#exampleModal{{ $item->id }}" data-hover="{{ trans('button.delete') }}">
                                        <i class="bx bxs-trash"> </i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @include('admin.layouts.delete', ['route'=> 'admin.pages.destroy'])

                        @empty

                        @endforelse

                    </tbody>
                </table>
            </div>

            <div class="col-md-12 text-center mt-3">
                {{ $items->links('pagination::bootstrap-5') }}
            </div>

        </div>
    </div>
</div>


@endsection
