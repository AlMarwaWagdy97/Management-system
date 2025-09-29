@extends('admin.app')

@section('title', trans('admin.roles_edit'))
@section('title_page', trans('admin.roles_edit'))



@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="row">
                <div class="col-12 m-3">
                    <div class="card">
                        <div class="card-body">
                                <div class="row mb-3">
                                    <label for="example-text-input"
                                        class="col-sm-2 col-form-label">@lang('admin.name')</label>
                                    <div class="col-sm-10">
                                        <h3>{{ $Role->name}}</h3>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="example-text-input"
                                        class="col-sm-2 col-form-label">@lang('admin.permissions')</label>
                                    <div class="col-md-10">
                                        @foreach($Role->permissions as $key => $permission)
                                            <span class="badge bg-success">{{ transPermission($permission->name) }}</span>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="row mb-3 text-end">
                                    <div>
                                        <a href="{{ route('admin.roles.index') }}"
                                            class="btn btn-primary waves-effect waves-light ml-3">@lang('button.cancel')</a>
                                    </div>
                                </div>

                            </form>

                        </div>
                    </div>
                </div> <!-- end col -->
            </div>
        </div> <!-- end row-->

    </div> <!-- container-fluid -->

@endsection


