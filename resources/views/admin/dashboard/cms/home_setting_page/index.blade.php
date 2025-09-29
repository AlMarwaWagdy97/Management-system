@extends('admin.app')
@section('title', trans('settings.setting_home'))
@section('title_page', trans('settings.setting_home'))
@section('style')
    {{-- @vite(['resources/assets/admin/css/data-tables.js']) --}}
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body mt-0 pt-0">
                        <div class="table-responsive">
                            <table id="main-datatable"
                                class="table table-bordered  dt-responsive nowrap table-striped table-table-success table-hover"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>@lang('admin.title')</th>
                                        <th>@lang('admin.actions')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    ?>
                                    @foreach ($items as $item)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>
                                                {{ $item->title_section }}
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-center">
                                                    @if ($item->status == 1)
                                                        <a href="{{ route('admin.home-settings.update-status',$item->id) }}"
                                                            data-hover="@lang('admin.active')"
                                                            class="btn btn-xs btn-success btn-sm m-1"><i
                                                                class="bx bxs-check-square"></i></a>
                                                    @else
                                                        <a href="{{ route('admin.home-settings.update-status',$item->id) }}"
                                                            data-hover="@lang('admin.dis_active')"
                                                            class="btn btn-xs btn-outline-secondary btn-sm m-1"><i
                                                                class="bx bx-no-entry"></i></a>
                                                    @endif
                                                    <a href="{{ route('admin.home-settings.edit', $item->id) }}"
                                                        data-hover="@lang('admin.edit')"
                                                        class="btn btn-outline-primary btn-sm m-1"><i
                                                            class="bx bxs-edit"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>

            </div>
        </div> <!-- container-fluid -->
    @endsection
    @section('script')
        {{-- @vite(['resources/assets/admin/js/data-tables.js']) --}}
    @endsection
