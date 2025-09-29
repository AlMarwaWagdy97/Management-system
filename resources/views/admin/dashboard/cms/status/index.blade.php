@extends('admin.app')

@section('title', trans('status.show_status'))
@section('title_page', trans('status.status'))
@section('title_route', route('admin.status.index') )
@section('button_page')
<a href="{{ route('admin.status.create') }}" class="btn btn-outline-success">@lang('admin.create')</a>
@endsection


@section('content')


<div class="card">
    <div class="card-body search-group">

        {{-- Start Form search --}}
        <form action="{{route('admin.status.index')}}" method="get">
            @csrf
            <div class="row">
                <div class="mb-2 col-md-3">
                    <input type="text" value="{{ old('title', request()->input('title')) }}" name="title" placeholder="{{ trans('admin.title') }}" class="form-control">
                </div>
                <div class="mb-2 col-md-3">
                    <input type="text" value="{{ old('description', request()->input('description')) }}" name="description" placeholder="{{ trans('admin.description') }}" class="form-control">
                </div>
                <div class="mb-2 col-md-3">
                    <select class="form-select" name="status" aria-label=".form-select-sm example">
                        <option selected value=""> @lang('admin.status') </option>
                        <option value="1" {{ old('status', request()->input('status')) == 1? "selected":"" }}>@lang('admin.active') </option>
                        <option value="0" {{ old('status', request()->input('status')) != 1 && old('status', request()->input('status')) != null? "selected":"" }}> @lang('admin.dis_active') </option>

                    </select>
                </div>

                <div class="search-input col-md-2">
                    <a class="btn btn-sm btn-warning" href="{{route('admin.status.index')}}" data-hover="{{ trans('button.reset') }}"><i class="bx bx-refresh"></i></a>
                    <button class="btn btn-sm btn-primary" type="submit" data-hover="{{ trans('button.search') }}"><i class="bx bx-search-alt"> </i></button>
                </div>
            </div>
        </form>
        {{-- End Form search --}}
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form id="update-pages" action="{{route('admin.status.actions')}}" method="post">
            @csrf
        </form>
        <div class="table-responsive">
            <table id="main-datatable" class="table table-bordered dt-responsive nowrap table-striped table-table-success table-hover" style="border-collapse: collapse; border-spacing: 0; width: 100%;">

                <thead>
                    <tr class="bluck-actions" style="display: none" scope="row">
                        <td colspan="8">
                            <div class="mt-0 mb-0 text-center col-md-12">
                                <button form="update-pages" class="btn btn-neutral text-success" type="submit" name="publish" value="1"> <i class="bx bxs-check-square"></i></button>
                                <button form="update-pages" class="btn btn-neutral text-warning" type="submit" name="unpublish" value="1"> <i class="bx bx-no-entry"></i></button>
                                <button form="update-pages" class="btn btn-neutral text-danger" type="submit" name="delete_all" value="1"> <i class="bx bxs-trash"></i></button>
                            </div>
                        </td>

                    </tr>
                    <tr>
                        <th tyle="width: 1px">
                            <input form="update-pages" class="checkbox-check flat" type="checkbox" name="check-all" id="check-all">
                        </th>
                        <th>#</th>
                        <th>@lang('admin.title')</th>
                        <th>@lang('admin.description')</th>
                        <th>@lang('articles.sort')</th>
                        <th>@lang('admin.created_at')</th>
                        <th>@lang('admin.updated_at')</th>
                        <th>@lang('articles.actions')</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($items as $key => $item)
                    <tr>
                        <td>
                            <input form="update-pages" class="checkbox-check" type="checkbox" name="record[{{$item->id}}]" value={{ $item->id }}>
                        </td>
                        <td>{{ $items->firstItem() + $key  }}</td>
                        <td>
                            @foreach($languages as $local)
                            {!! @$item->trans->where('locale',$local)->first()->title !!} <br>
                            @endforeach
                        </td>
                        <td>
                            {{ substr(removeHTML( @$item->trans->where('locale',$current_lang)->first()->description),0,30) }}
                        </td>
                        <td>{{ $item->sort }}</td>
                        <td>{{ $item->created_at }}</td>
                        <td>{{ $item->updated_at }}</td>
                        <td>
                            <div class="d-flex justify-content-center">
                                @if($item->status == 1)
                                <a href="{{ route('admin.status.update-status',$item->id) }}" data-hover="@lang('admin.active')" class="btn btn-neutral text-success"><i class="bx bxs-check-square"></i></a>
                                @else
                                <a href="{{ route('admin.status.update-status',$item->id) }}" data-hover="@lang('admin.dis_active')" class="btn btn-neutral text-warning"><i class="bx bx-no-entry"></i></a>
                                @endif
                                <a href="{{ route('admin.status.show',$item->id) }}" data-hover="@lang('admin.show')" class="btn btn-neutral text-info"><i class="bx bxs-show"></i></a>
                                <a href="{{ route('admin.status.edit',$item->id) }}" data-hover="@lang('admin.edit')" class="btn btn-neutral text-primary"><i class="bx bxs-edit"></i></a>
                                <a class="btn btn-neutral text-danger" data-hover="@lang('admin.delete')" data-bs-toggle="modal" data-bs-target="#exampleModal{{ $item->id }}">
                                    <i class="bx bxs-trash"> </i>
                                </a>

                            </div>
                        </td>


                    </tr>
                    @include('admin.layouts.delete', ['route'=> 'admin.status.destroy'])
                    @endforeach

                </tbody>


            </table>
        </div>


        <div class="text-center col-md-12">
            {{ $items->links('pagination::bootstrap-5') }}
        </div>

        </form>
    </div>

</div>

</div>

</div> <!-- container-fluid -->

@endsection


@section('script')

{{-- @vite(['resources/assets/admin/js/data-tables.js']) --}}
@endsection
