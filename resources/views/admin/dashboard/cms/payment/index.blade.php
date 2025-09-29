@extends('admin.app')

@section('title', trans('payment.show_payment'))
@section('title_page', trans('payment.payment'))
@section('title_route', route('admin.payment-method.index'))
@section('button_page')
    <a href="{{ route('admin.payment-method.create') }}" class="btn btn-outline-success">@lang('admin.create')</a>
@endsection


@section('content')
    <div class="card">
        <div class="card-body  search-group">
            {{-- Start Form Search User Search By name,email,role,status --}}
            <form action="{{ route('admin.payment-method.index') }}" method="get">

                <div class="row mt-3">
                    <div class="col-md-2 mb-2">
                        <input type="text" value="{{ request()->title != '' ? request()->title : '' }}" name="title"
                            placeholder="{{ trans('pages.search_name') }}" class="form-control">
                    </div>

                    <div class="col-md-2 mb-2">
                        <select class="select form-control" name="status">
                            <option selected value="" disabled> @lang('admin.status') </option>
                            <option value="1" {{ old('status', request()->input('status')) == 1 ? 'selected' : '' }}>
                                @lang('admin.active') </option>
                            <option value="0"
                                {{ old('status', request()->input('status')) != 1 && old('status', request()->input('status')) != null ? 'selected' : '' }}>
                                @lang('admin.dis_active') </option>

                        </select>
                    </div>
                    <div class="col-md-2">
                        <a class="btn btn-sm btn-warning" href="{{ route('admin.payment-method.index') }}"><i
                                class="bx bx-refresh" data-hover="{{ trans('button.reset') }}"></i></a>
                        <button class="btn btn-primary btn-sm" type="submit" data-hover="{{ trans('pages.search') }}"><i
                                class="bx bx-search-alt"> </i></button>

                    </div>
                </div>
            </form>
            {{-- End Form Search User Search By name,email,role,status --}}
        </div>
    </div>



    <div class="card">
        <div class="card-body">
            <form id="update-pages" action="{{ route('admin.payment.actions') }}" method="post">
                @csrf
            </form>
            <div class="table-responsive">
                <table id="main-datatable"
                    class="table table-bordered  dt-responsive nowrap table-striped table-table-success table-hover table-sm"
                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">

                    <thead>
                        <tr class="bluck-actions" style="display: none" scope="row">
                            <td colspan="8">
                                <div class="col-md-12 mt-0 mb-0 text-center">
                                    <button form="update-pages" class="btn btn-neutral text-success" type="submit"
                                        name="publish" value="1" data-hover="{{ trans('payment.status_active') }}"> <i
                                            class="bx bxs-check-square"></i></button>
                                    <button form="update-pages" class="btn btn-neutral text-warning" type="submit"
                                        name="unpublish" value="1"
                                        data-hover="{{ trans('payment.status_desactive') }}"> <i
                                            class="bx bx-no-entry"></i></button>
                                    <button form="update-pages" class="btn btn-neutral text-danger" type="submit"
                                        name="delete_all" value="1" data-hover="{{ trans('button.delete') }}">
                                        <i class="bx bxs-trash"></i></button>
                                </div>
                            </td>

                        </tr>
                        <tr>
                            <th tyle="width: 1px">
                                <input form="update-pages" class="checkbox-check flat" type="checkbox" name="check-all"
                                    id="check-all">
                            </th>
                            <th>#</th>
                            <th>@lang('admin.title')</th>
                            <th>@lang('admin.created_at')</th>
                            <th>@lang('admin.updated_at')</th>
                            <th>@lang('admin.actions')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($payments as $item)
                            <tr>
                                <td>
                                    <input form="update-pages" class="checkbox-check" type="checkbox"
                                        name="record[{{ $item->id }}]" value={{ $item->id }}>
                                </td>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    @foreach ($languages as $local)
                                        {{ @$item->trans->where('locale', $local)->first()->title }} <br>
                                    @endforeach
                                </td>
                                <td>{{ $item->created_at }}</td>
                                <td>{{ $item->updated_at }}</td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        @if ($item->status == 1)
                                            <a href="{{ route('admin.payment.update-status', $item->id) }}"
                                                class="btn btn-neutral text-success"
                                                data-hover="{{ trans('payment.status_active') }}"><i
                                                    class="bx bxs-check-square"></i></a>
                                        @else
                                            <a href="{{ route('admin.payment.update-status', $item->id) }}"
                                                class="btn btn-neutral text-warning"
                                                data-hover="{{ trans('payment.status_desactive') }}"><i
                                                    class="bx bx-no-entry"></i></a>
                                        @endif
                                        <a href="{{ route('admin.payment-method.show', $item->id) }}"
                                            class="btn btn-neutral text-info" data-hover="{{ trans('payment.show') }}"><i
                                                class="bx bxs-show"></i></a>

                                        <a href="{{ route('admin.payment-method.edit', $item->id) }}"
                                            class="btn btn-neutral text-primary" data-hover="{{ trans('button.edit') }}"><i
                                                class="bx bxs-edit"></i></a>

                                        {{-- <a class="btn btn-neutral text-danger" data-bs-toggle="modal"
                                            data-bs-target="#exampleModal{{ $item->id }}"
                                            data-hover="{{ trans('button.delete') }}">
                                            <i class="bx bxs-trash"> </i>
                                        </a> --}}

                                    </div>
                                </td>

                            </tr>

                            {{-- @include('admin.layouts.delete', ['route' => 'admin.payment-method.destroy']) --}}
                        @endforeach

                    </tbody>


                </table>
            </div>


            <div class="col-md-12 text-center">
                {{ $payments->links('pagination::bootstrap-5') }}
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
