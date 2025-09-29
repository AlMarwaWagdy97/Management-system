@extends('admin.app')

@section('title', trans('admin.roles'))
@section('title_page', trans('admin.roles_show'))
@section('title_route', route('admin.roles.index') )
@section('button_page')
<a href="{{ route('admin.roles.create') }}" class="btn btn-success btn-sm">@lang('admin.create')</a>
@endsection

@section('content')




<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table id="main-datatable" class="table table-bordered text-center table-striped table-table-success table-hover table-sm" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>@lang('admin.name')</th>
                        <th>@lang('admin.actions')</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($items as $key => $item)
                    <tr>
                        <th>{{$items->firstItem() +$key}}</th>
                        <td>
                            {{$item->name}}
                        </td>
                        <td class="text-center">
                            <a href="{{ route('admin.roles.edit',$item->id) }}" data-hover="@lang('admin.edit')" class="btn btn-neutral text-primary"><i class="bx bxs-edit"></i></a>
                            <a href="{{ route('admin.roles.show', $item->id) }}" data-hover="@lang('admin.show')" class="btn btn-neutral text-info"><i class="bx bxs-show"></i></a>
                            @if ($item->id != 1)
                            <!-- Button trigger modal -->
                            <a type="button" class="btn btn-neutral text-danger" data-hover="{{ trans('button.delete') }}" class="color-red" data-bs-toggle="modal" data-bs-target="#exampleModal{{ $item->id }}">
                                <i class="bx bxs-trash"></i>
                            </a>
                            @endif
                        </td>
    
                    </tr>
                    @include('admin.layouts.delete', ['route'=> 'admin.roles.destroy'])
    
                    @empty
    
                    @endforelse
    
                </tbody>
    
    
            </table>
        </div>
     

    </div>
    <div class="col-md-12 text-center">
        {{ $items->links('pagination::bootstrap-5') }}
    </div>
</div>

@endsection
