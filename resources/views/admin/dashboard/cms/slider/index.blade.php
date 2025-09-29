@extends('admin.app')

@section('title', trans('slider.slider_show'))
@section('title_page', trans('slider.sliders'))
@section('title_route', route('admin.slider.index') )
@section('button_page')
<a href="{{ route('admin.slider.create') }}" class="btn btn-outline-success btn-sm">@lang('admin.create')</a>
@endsection


@section('content')



<div class="card">
    <div class="card-body  search-group">
        <form action="{{route('admin.slider.index')}}" method="get">
            <div class="row">
                <div class="col-md-3 mb-2">
                    <input type="text" value="" name="title" placeholder="{{ trans('pages.search_title') }}" class="form-control">
                </div>
                <div class="search-input col-md-2">
                    <button class="btn btn-primary btn-sm" type="submit" data-hover="{{ trans('button.search') }}"><i class="bx bx-search-alt"> </i></button>
                    <a class="btn btn-warning btn-sm" href="{{route('admin.slider.index')}}" data-hover="{{ trans('button.reset') }}"><i class="bx bx-refresh"></i></a>
                </div>
            </div>
        </form>
    </div>
</div>


<div class="card">
    <div class="card-body">
        <form id="update-pages" action="{{route('admin.slider.actions')}}" method="post">
            @csrf
        </form>
        <table id="main-datatable" class="table table-striped table-bordered " style="border-collapse: collapse; border-spacing: 0; width: 100%;">
            <thead>
                <tr class="bluck-actions" style="display: none" scope="row">
                    <td colspan="8">
                        <div class="col-md-12 mt-0 mb-0 text-center">
                            <button form="update-pages" class="btn btn-neutral text-success btn-sm" type="submit" name="publish" value="1" data-hover="{{ trans('button.active') }}"> <i class="bx bxs-check-square"></i></button>
                            <button form="update-pages" class="btn btn-neutral text-warning btn-sm" type="submit" name="unpublish" value="1" data-hover="{{ trans('button.unactive') }}"> <i class="bx bx-no-entry"></i></button>
                            <button form="update-pages" class="btn btn-neutral text-danger btn-sm" type="submit" name="delete_all" value="1" data-hover="{{ trans('button.delete_all') }}"> <i class="bx bxs-trash"></i></button>
                        </div>
                    </td>
                </tr>
                <tr class="text-center table-active">
                    <th style="width: 1px">
                        <input form="update-pages" class="checkbox-check flat" type="checkbox" name="check-all" id="check-all">
                    </th>
                    <th style="width: 2px">#</th>
                    <th>@lang('slider.image')</th>
                    <th>@lang('slider.title')</th>
                    <th>@lang('slider.url')</th>
                    <th>@lang('slider.created_at')</th>
                    <th>@lang('slider.updated_at')</th>

                    <th>@lang('slider.actions')</th>
                </tr>
            </thead>
            <tbody class="text-center">
                @foreach ($sliders as $item)
                <tr>
                    <td>
                        <input form="update-pages" class="checkbox-check" type="checkbox" name="record[{{$item->id}}]" value={{ $item->id }}>
                    </td>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        <a href="{{getImage($item->image)}}" target="_blank"> <img src="{{getImageThumb($item->image)}}" alt="" style="width: 50px"></a>
                    </td>
                    <td>
                        {{ @$item->trans?->where('locale',$current_lang)->first()->title}}
                    </td>
                    <td>{{ $item->url == 'javascript:void(0)'?'': $item->url  }}</td>
                    <td>{{ $item->created_at }}</td>
                    <td>{{ $item->updated_at  }}</td>
                    <td>
                        <div class="d-flex justify-content-center">
                            @if($item->status == 1)
                            <a href="{{ route('admin.slider.update-status', $item->id )}}" class="btn btn-neutral text-success btn-sm m-1" data-hover="{{ trans('button.active') }}"><i class="bx bxs-check-square"></i></a>
                            @else
                            <a href="{{ route('admin.slider.update-status', $item->id )}}" class="btn btn-neutral text-secondary btn-sm m-1" data-hover="{{ trans('button.unactive') }}"><i class="bx bx-no-entry"></i></a>
                            @endif
                            <a href="{{ route('admin.slider.show', $item->id) }}" class="btn btn-neutral text-info btn-sm m-1" data-hover="{{ trans('button.show') }}"><i class="bx bxs-show"></i></a>
                            <a href="{{ route('admin.slider.edit',$item->id) }}" class="btn btn-neutral text-primary btn-sm m-1" data-hover="{{ trans('button.edit') }}"><i class="bx bxs-edit"></i></a>
                            <a class="btn btn-neutral text-danger btn-sm m-1" data-bs-toggle="modal" data-bs-target="#exampleModal{{ $item->id }}" data-hover="{{ trans('button.delete') }}">
                                <i class="bx bxs-trash"> </i>
                            </a>

                        </div>
                    </td>
                </tr>
                @include('admin.layouts.delete', ['route'=> 'admin.slider.destroy'])
                @endforeach
            </tbody>
        </table>

        <div class="col-md-12 text-center mt-3">
            {{ $sliders->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>


@endsection
