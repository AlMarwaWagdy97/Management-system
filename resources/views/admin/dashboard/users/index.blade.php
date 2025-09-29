@extends('admin.app')

@section('title', trans('users.show_user'))
@section('title_page', trans('admin.users'))
@section('title_route', route('admin.users.index') )
@section('button_page')
<a href="{{ route('admin.users.create') }}" class="btn btn-success btn-sm">@lang('admin.create')</a>
@endsection

@section('style')
<link rel="stylesheet" href="{{ asset('tell/intlTelInput.css') }}" />
@endsection


@section('content')

<div class="row">

    <div class="card">
        <div class="card-body  search-group">
            {{-- Start Form Search User Search By name,email,role,status --}}
            <form action="{{ route('admin.users.index') }}" method="get">

                <div class="row mt-3">
                    <div class="col-md-2 mt-1">
                        <input type="text" value="{{ request()->name != '' ? request()->name : '' }}" name="user_name" placeholder="{{ trans('pages.search_name') }}" class="form-control">
                    </div>
                    <div class="col-md-2 mt-1">
                        <input type="text" value="{{ request()->email != '' ? request()->email : '' }}" name="email" placeholder="{{ trans('pages.search_email') }}" class="form-control">
                    </div>
                    <div class="col-md-2 mt-1">
                        <input type="text" value="{{ request()->mobile != '' ? request()->mobile : '' }}" name="mobile" placeholder="{{ trans('pages.search_mobile') }}" class="form-control"
                        oninput="this.value = this.value.replace(/[^0-9]/g, '');" maxlength="9">
                    </div>
                    <div class="col-md-2 mt-1">
                        <select class="select form-control select2 " name="role">
                            <option selected value="">{{ trans('pages.search_role') }}</option>
                            @foreach ($roles as $role)
                            <option {{ $role->id ==   request()->role  ? 'selected' : '' }} value="{{ $role->id }}"> {{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 mt-1">
                        <select class="select form-control" name="status">
                            <option selected value=""> @lang('admin.status') </option>
                            <option value="1" {{ old('status', request()->input('status')) == 1 ? 'selected' : '' }}>
                                @lang('admin.active') </option>
                            <option value="0" {{ old('status', request()->input('status')) != 1 && old('status', request()->input('status')) != null ? 'selected' : '' }}>
                                @lang('admin.dis_active') </option>

                        </select>
                    </div>
                    <div class="search-input col-md-2 mt-1">
                        <button class="btn btn-primary btn-sm" type="submit" data-hover="{{ trans('pages.search') }}"><i class="bx bx-search-alt"> </i></button>
                        <a class="btn btn-success btn-sm" href="{{route('admin.users.index')}}" data-hover="{{ trans('button.reset') }}"><i class="bx bx-refresh"></i></a>
                    </div>
                </div>
            </form>
            {{-- End Form Search User Search By name,email,role,status --}}

        </div>
    </div>

    <div class="card">
        <div class="card-body">
           
            <form id="update-pages" action="{{ route('admin.users.actions') }}" method="post">
                @csrf
            </form>
            <div class=" table-responsive">
                <table id="main-datatable" class="table table-bordered table-striped table-table-success table-hover" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr class="bluck-actions" style="display: none" scope="row">
                            <td colspan="8">
                                <div class="col-md-12 mt-0 mb-0 text-center ">
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
                            <th>#</th>
                            <th>@lang('users.name')</th>
                            <th>@lang('users.email')</th>
                            <th>@lang('users.mobile')</th>
                            <th>@lang('users.image')</th>
                            <th>@lang('users.role')</th>
                            <th>@lang('users.action')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $key => $item)
                        <tr>
                            <td>
                                @if ($key != 0)
                                <input form="update-pages" class="checkbox-check" type="checkbox" name="record[{{ $item->id }}]" value={{ $item->id }}>
                                @endif
                            </td>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->user_name }}</td>
                            <td>{{ $item->email }}</td>
                            <td>{{ $item->mobile }}</td>
                            <td> <a href="{{ getImage($item->image) }}" target="_blank"> <img src="{{ getImageThumb($item->image) }}" alt="" style="width: 50px"></a>
                            </td>
                            <td>
                                @foreach ($item->roles as $role)
                                <span class="badge bg-success">{{ $role->name }}</span>
                                @endforeach
                            </td>
                            <td>

                                <div class="d-flex justify-content-center">
                                    @if ($key != 0)
                                    @if ($item->status == 1)
                                    <a href="{{ route('admin.users.update-status', $item->id) }}" class="btn btn-neutral text-success" data-hover="{{ trans('button.active') }}"> <i class="bx bxs-check-square"></i></a>
                                    @else
                                    <a href="{{ route('admin.users.update-status', $item->id) }}" class="btn btn-neutral text-warning" data-hover="{{ trans('button.unactive') }}"> <i class='bx bx-no-entry'></i> </a>
                                    @endif
                                    <a href="{{ route('admin.users.edit', $item->id) }}" class="btn btn-neutral  text-primary" data-hover="{{ trans('button.edit') }}"><i class="bx bxs-edit"></i></a>
                                    <a type="button" class="btn btn-neutral text-danger" data-hover="{{ trans('button.delete') }}" class="color-red" data-bs-toggle="modal" data-bs-target="#exampleModal{{ $item->id }}">
                                        <i class="bx bxs-trash"></i>
                                    </a>
                                    @endif
                                </div>
                        </tr>
                        @include('admin.layouts.delete', ['route'=> 'admin.users.destroy'])
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="col-md-12 text-center mt-3">
                {{ $users->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>


@endsection


@section('script')

@endsection
