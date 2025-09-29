@extends('admin.app')

@section('title', trans('projectTags.tags'))
@section('title_page', trans('projectTags.show_tags'))

@section('style')
    {{-- @vite(['resources/assets/admin/css/data-tables.js']) --}}
@endsection
@section('content')

<div class="container-fluid">


    <div class="row">
        <div class="col-12">
            <div class="card">
                
            <div class="card-body  search-group">
                <div class="row">
                    <div class="col-md-12 text-end mb-2">
                        <a href="{{ route('admin.project-tags.create') }}" class="btn btn-outline-success btn-sm">@lang('admin.create')</a>
                    </div>
                </div>
                {{-- Start Form search --}}
                <form action="{{route('admin.project-tags.index')}}" method="get">
                    <div class="row mb-3">
                        <div class="col-md-3 mb-2">
                            <input type="text"  value="{{ old('title', request()->input('title')) }}" name="title" placeholder="{{ trans('admin.title') }}" class="form-control">
                        </div>
                        <div class="col-md-3 mb-2">
                            <input type="text"  value="{{ old('description', request()->input('description')) }}" name="description" placeholder="{{ trans('admin.description') }}" class="form-control">
                        </div>
                        <div class="col-md-3 mb-2">
                            <select class="form-select" name="status"  aria-label=".form-select-sm example">
                                <option selected value=""> @lang('admin.status')  </option>
                                <option value="1"{{ old('status', request()->input('status')) == 1? "selected":"" }}>@lang('admin.active') </option>
                                <option value="0" {{ old('status', request()->input('status')) != 1 && old('status', request()->input('status')) != null? "selected":"" }}> @lang('admin.dis_active') </option>

                            </select>   
                        </div>

                        <div class="search-input col-md-2">
                            <button class="btn btn-primary btn-sm" type="submit" data-hover="{{ trans('pages.search') }}"><i class="bx bx-search-alt"> </i></button>
                            <a class="btn btn-warning btn-sm" href="{{route('admin.project-tags.index')}}" data-hover="{{ trans('button.reset') }}"><i class="bx bx-refresh"></i></a>
                        </div>
                    </div>
                </form>
                {{-- End Form search --}}
            </div>

               


                <div class="card-body mt-0 pt-0">
                    <form id="update-pages" action="{{route('admin.project-tags.actions')}}" method="post">
                        @csrf
                    </form>
                    <div class="table-responsive">
                        <table id="main-datatable" class="table table-bordered  dt-responsive nowrap table-striped table-table-success table-hover" style="border-collapse: collapse; border-spacing: 0; width: 100%;">

                            <thead>
                                <tr class="bluck-actions" style="display: none" scope="row">
                                    <td colspan="8">
                                        <div class="col-md-12 mt-0 mb-0 text-center" >
                                            <button form="update-pages" class="btn btn-success btn-sm" type="submit" name ="publish" value="1"> <i class="bx bxs-check-square"></i></button>
                                            <button form="update-pages" class="btn btn-warning btn-sm" type="submit" name ="unpublish" value="1">  <i class="bx bx-no-entry"></i></button>
                                            <button form="update-pages" class="btn btn-danger btn-sm" type="submit" name ="delete_all" value="1">  <i class="bx bxs-trash"></i></button>
                                        </div>
                                    </td>

                                </tr>
                            <tr>
                                <th tyle="width: 1px"> 
                                    <input form="update-pages"  class="checkbox-check flat" type="checkbox" name="check-all"  id="check-all">
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
                                          {{-- @foreach($languages as $local)
                                            {!!   @$item->trans->where('locale',$local)->first()->title   !!} <br>
                                            @endforeach  --}}
                                        {{   @$item->trans->where('locale',$current_lang)->first()->title }}
                                    </td>
                                    <td>
                                        {{  substr(removeHTML(  @$item->trans->where('locale',$current_lang)->first()->description),0,30) }}
                                    </td>
                                    <td>{{ $item->sort }}</td>
                                    <td>{{ $item->created_at }}</td>
                                    <td>{{ $item->updated_at }}</td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            @if($item->status == 1)
                                                <a href="{{ route('admin.project-tags.update-status',$item->id) }}" data-hover="@lang('admin.active')" class="btn btn-xs btn-success btn-sm m-1"><i class="bx bxs-check-square"></i></a>
                                            @else 
                                                <a href="{{ route('admin.project-tags.update-status',$item->id) }}" data-hover="@lang('admin.dis_active')"  class="btn btn-xs btn-outline-secondary btn-sm m-1"><i class="bx bx-no-entry"></i></a>
                                            @endif

                                            @if($item->feature == 1)
                                                <a href="{{ route('admin.project-tags.update-featured',$item->id) }}}" data-hover="@lang('admin.feature')"  class="btn btn-xs btn-warning btn-sm m-1"><i class="bx bxs-star"></i></a>
                                            @else 
                                                <a href="{{ route('admin.project-tags.update-featured',$item->id) }}" data-hover="@lang('admin.feature')"  class="btn btn-xs btn-outline-secondary btn-sm m-1"><i class="bx bxs-star"></i></a>
                                            @endif

                                            <a href="{{ route('admin.project-tags.show', $item->id) }}" data-hover="@lang('admin.show')" class="btn btn-xs btn-outline-info btn-sm m-1"><i class="bx bxs-show"></i></a>
                                            <a href="{{ route('admin.project-tags.edit', $item->id) }}" data-hover="@lang('admin.edit')" class="btn btn-outline-primary btn-sm m-1"><i class="bx bxs-edit"></i></a>
                                            <a class="btn btn-outline-danger btn-sm m-1" data-hover="@lang('admin.delete')" data-bs-toggle="modal" data-bs-target="#exampleModal{{ $item->id }}">
                                                <i class="bx bxs-trash"> </i>
                                            </a>
                                        
                                        </div>
                                    </td>
                            
                                    
                                </tr>
                                
                                @include('admin.layouts.delete', ['route'=> 'admin.project-tags.destroy'])

                                @endforeach
                        
                            </tbody>

                        
                        </table>
                    </div>

                        
                    <div class="col-md-12 text-center">
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