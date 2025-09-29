@extends('admin.app')
@section('title', trans('menus.show_menus'))
@section('title_page', trans('admin.menus'))
@section('title_route', route('admin.menus.index') )
@section('button_page')
<a href="{{ route('admin.menus.index') }}" class="btn btn-outline-primary waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
@endsection


@if (\Route::current()->getName() == 'admin.menus.edit')
    @section('title', trans('menus.show_menus'))
    @section('title_page', trans('pages.edit', ['name' => @$menu->title]) )
@elseif (\Route::current()->getName() == 'admin.menus.create')
    @section('title', trans('menus.create_menus'))
    @section('title_page', trans('menus.create_menus'))
@else 
    @section('title', trans('menus.show_menus'))
    @section('title_page', trans('menus.show_menus'))
@endif

@section('style')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
@endsection

@section('content')


    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <div class="row">

                    {{-- Tree ---------------------------------------------------- --}}
                    <div class="col-md-4">

                        <div class="actions-tree mb-3">
                            <form action="{{ route('admin.menus.show_tree') }}" method="GET">
                                <input type="hidden" name="position" value="{{ request()->position }}">
                                <div class="row">{{-- Bettie Ankunding --}}
                                    <div class="col-md-6 mt-2">
                                        <input type="text" name="title" value="{{ request()->title }}" class="form-controle">
                                    </div>
                                    <div class="col-md-6 mt-2">
                                        <button type="submit" class="btn btn-primary btn-sm"> @lang('admin.search') </button>
                                    </div>
                                </div>
                            </form>
                            <br>
                            <button class="btn btn-primary" id="collapse-all"> @lang('admin.collapse')</button>
                            <a href="{{ route('admin.menus.create') }}" data-hover="@lang('admin.create')" class="btn btn-success" > @lang('admin.create')</i></a>
                        </div>
                        @php 
                            if(@$menu != null)@$menu_parent_ids = getPathTree(@$menu);
                            if(@$item_parent_id != null ){
                                @$menu_parent_ids = getPathTree(@App\Models\Menue::find(@$item_parent_id));
                                @$menu_parent_ids[] = (int)$item_parent_id;
                            } 
                            $first = true;
                        @endphp
                        <ul class="todos" id="todos">
                            @include('admin/dashboard/cms/menus/tree')
                            {{-- <li class="todo-plus">
                                <a href="{{ route('admin.menus.create', 0) }}" data-hover="@lang('admin.create')" class="text-success" ><i class="fas fa-plus"></i></a>
                            </li> --}}
                        </ul>
                    </div>

                    {{-- Create -- Edit  ---------------------------------------------------- --}}
                    @if(@$createMode == true || @$EditMode == true)
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-12 m-3">
                                    <div class="card">
                                        <div class="card-body">
                                            {{--  Destroy Form ---------------------------------------------- --}}
                                            @if( @$createMode != true && (@$menu->children == null ||  @$menu->children ->first() == null) )
                                                <div class="destroy text-end">
                                                    <a class="btn btn-danger btn-sm m-1" data-bs-toggle="modal" data-bs-target="#exampleModal{{ @$menu->id }}">
                                                        @lang('admin.delete')
                                                    </a>
                                                    <div class="modal fade" id="exampleModal{{ @$menu->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">@lang('admin.delete_item')</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                {{-- <div class="swal2-icon-content text-warning h1">!</div> --}}
                                                                <h2 class="swal2-title" id="swal2-title" style="display: flex;">  @lang('admin.are_you_sure')</h2>
                                                            <div class="modal-footer">
                                                                <form  action="{{ route('admin.menus.destroy' , @$menu->id) }}" method="POST">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="button" class="btn btn-primary" data-dismiss="modal">@lang('admin.no')</button>
                                                                    <button type="submit" class="btn btn-danger">@lang('admin.yes')</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif


                                            {{--  Edir or Create  ---------------------------------------------- --}}
                                            @if(@$createMode == true)
                                            
                                                <form action="{{ route('admin.menus.store') }}" method="post">
                                                    <input type="hidden" name="parent_id" value="{{ @$item_parent_id == 0? NULL:  @$item_parent_id }}">
                                            @else
                                                <form action="{{ route('admin.menus.update', $menu->id) }}" method="post">
                                                    <input type="hidden" name="parent_id" value="{{ @$menu->parent_id }}">
                                                    @method('put')
                                            @endif

                                                @csrf
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        @foreach ($languages as $key => $locale)
                                                            <div class="accordion mt-4 mb-4" id="accordionExample">
                                                                <div class="accordion-item border rounded">
                                                                    <h2 class="accordion-header" id="headingOne{{ $key }}">
                                                                        <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne{{ $key }}" aria-expanded="true" aria-controls="collapseOne{{ $key }}">
                                                                        {{ Locale::getDisplayName($locale) }}
                                                                        </button>
                                                                    </h2>
                                                                    <div id="collapseOne{{ $key }}" class="accordion-collapse collapse show mt-3" aria-labelledby="headingOne{{ $key }}" data-bs-parent="#accordionExample">
                                                                        <div class="accordion-body">
                        
                                                                            {{-- title ------------------------------------------------------------------------------------- --}}
                                                                                <div class="row mb-3">
                                                                                    <label for="example-text-input"
                                                                                        class="col-sm-2 col-form-label">{{ trans('admin.title_in') .  Locale::getDisplayName($locale)}}</label> 
                                                                                    <div class="col-sm-10">
                                                                                        <input type="text" id="title{{ $key }}" name="{{ $locale }}[title]" value="{{ @$menu != null ? optional( $menu->trans)->where('locale', $locale)->first()->title : old($locale . '.title') }}" class="form-control title" required>
                                                                                    </div>
                                                                                    @if($errors->has($locale . '.title'))
                                                                                        <span class="missiong-spam">{{ $errors->first($locale . '.title') }}</span>
                                                                                    @endif
                                                                                </div>
                        
                                                                            {{-- slug ------------------------------------------------------------------------------------- --}}
                                                                                <div class="row mb-3 slug-section">
                                                                                    <label for="example-text-input"
                                                                                        class="col-sm-2 col-form-label">{{ trans('admin.slug_in') .  Locale::getDisplayName($locale)}}</label>
                                                                                    <div class="col-sm-10">
                                                                                        <input type="text" id="slug{{ $key }}" name="{{ $locale }}[slug]" value="{{ @$menu != null ? optional( $menu->trans)->where('locale', $locale)->first()->slug : old($locale . '.slug') }}" class="form-control slug" required>
                                                                                    </div>
                                                                                    @if($errors->has($locale . '.slug'))
                                                                                    <span class="missiong-spam">{{ $errors->first($locale . '.slug') }}</span>
                                                                                    @endif
                        
                                                                                    @include('admin.layouts.scriptSlug')

                                                                                </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>


                                                    <div class="col-md-12">
                                                        <div class="accordion mt-4 mb-4" id="accordionExample">
                                                            <div class="accordion-item border rounded">
                                                            <h2 class="accordion-header" id="headingOne">
                                                                <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOn" aria-expanded="true" aria-controls="collapseOne{{ $key }}">
                                                                    {{ trans('menus.Settings') }}
                                                                </button>
                                                            </h2>
                                                            <div id="collapseOne" class="accordion-collapse collapse show mt-3" aria-labelledby="headingOn" data-bs-parent="#accordionExample">
                                                                <div class="accordion-body">
                                                                    
                                                                    <div class="row mb-3 title-section">
                                                                        <label for="example-text-input"  class="col-sm-2 col-form-label">{{  trans('menus.type')}}</label>
                                                                        <div class="col-sm-10">
                                                                            <select class="form-select form-select-sm" name="type" id="type" aria-label=".form-select-sm example">
                                                                                <option selected>@lang('menus.type') </option>
                                                                                @foreach (App\Enums\MunesEnum::values() as $ee)
                                                                                    <option {{  $ee == @$menu->type ? "selected":"" }}>{{ $ee }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                            @if('type')
                                                                                <span class="missiong-spam">{{ $errors->first('type') }}</span>
                                                                            @endif
                                                                        </div>            
                                                                    </div>

                                                                    <div class="row mb-3 title-section" id="static-url"  @if( @$menu->type != App\Enums\MunesEnum::STATIC) style="display: none;"  @endif>
                                                                        <label for="example-text-input"  class="col-sm-2 col-form-label">{{  trans('menus.url') }}</label>
                                                                        <div class="col-sm-10">
                                                                            <input class="form-control" id="static_url" type="text" name="url" value="{{  @$menu->url ?? old('url') }}">
                                                                            @if('url')
                                                                                <span class="missiong-spam">{{ $errors->first('url') }}</span>
                                                                            @endif
                                                                        </div>            
                                                                    </div>


                                                                    <div id="dynamic-url" @if( @$menu->type != App\Enums\MunesEnum::DYNAMIC) style="display: none;"  @endif>
                                                                        <div class="row mb-3 title-section"  >
                                                                            <label for="example-text-input"  class="col-sm-2 col-form-label">{{  trans('menus.type_url') }}</label>
                                                                            <div class="col-sm-10">
                                                                                <select class="form-select form-select-sm" id="dynamic-type" name="dynamic_table" aria-label=".form-select-sm example">
                                                                                    <option value=""> @lang('menus.select_url') </option>
                                                                                    @foreach(App\Enums\UrlTypesEnum::values() as $enumTypes)
                                                                                        <option value="{{ $enumTypes }}" {{  $enumTypes == @$menu->dynamic_table ? "selected":"" }}>{{ $enumTypes }}</option>
                                                                                    @endforeach
                                                                                </select>
                                                                                @if('type')
                                                                                    <span class="missiong-spam">{{ $errors->first('dynamic_table') }}</span>
                                                                                @endif
                                                                            </div>                      
                                                                        </div>

                                                                        <div class="row mb-3 title-section"  >
                                                                            <label for="example-text-input"  class="col-sm-2 col-form-label">{{  trans('menus.url') }}</label>
                                                                            <div class="col-sm-10">
                                                                                <select class="form-select form-select-sm" name="dynamic_url" id="get-dynamic-urls" aria-label=".form-select-sm example">
                                                                                    <option value="{{ @$menu->dynamic_url }}">{{ @$menu->dynamic_url }}</option>
                                                                                </select>
                                                                                @if('type')
                                                                                    <span class="missiong-spam">{{ $errors->first('dynamic_url') }}</span>
                                                                                @endif
                                                                            </div>                      
                                                                        </div>
                                                                    </div>
                                                                    

                                                                    <div class="row mb-3 title-section">
                                                                        <label for="example-text-input"  class="col-sm-2 col-form-label">{{  trans('menus.status') }}</label>
                                                                        <div class="col-sm-10">
                                                                            <input class="form-check form-switch" name="status" type="checkbox" id="switch4" switch="success"  {{ @$menu->status == 1 || old('url') ==1 ?'checked':'' }} value="1">
                                                                            <label class="form-label" for="switch4" data-on-label="{{ trans('admin.yes') }}" data-off-label="{{ trans('admin.no') }}"></label>
                                                                            @if('status')
                                                                                <span class="missiong-spam">{{ $errors->first('status') }}</span>
                                                                            @endif
                                                                        </div>            
                                                                    </div>
                                                                
                                                                
                                                                </div>
                                                            </div>
                                                            </div>
                                                        </div>
                                                    </div>




                                                    <div class="row mb-3 text-end">
                                                        <div>
                                                            <a href="{{ route('admin.menus.index') }}"
                                                                class="btn btn-outline-danger waves-effect waves-light ml-3">@lang('button.cancel')</a>
                                                            <button type="reset"
                                                                class="btn btn-outline-warning waves-effect waves-light ml-3">@lang('button.reset')</button>
                                                            <button type="submit"
                                                                class="btn btn-outline-success waves-effect waves-light ml-3">@lang('button.save')</button>
                                                        </div>
                                                    </div>

                                                </div>
                    
                                            </form>
                    
                                        </div>
                                    </div>
                                </div> <!-- end col -->
                            </div>
                        </div>
                    @endif



                </div>
            </div>
        </div>

    </div> <!-- container-fluid -->

@endsection


@section('script')
      
    {{-- @vite(['resources/assets/admin/js/data-tables.js']) --}}
    <script>
        const todos = document.querySelectorAll(".todo");
        const togglers = document.querySelectorAll(".toggler");

        todos.forEach((todo) => {
            todo.addEventListener("click", () => {
                todo.classList.toggle("active");
            });
        });

        togglers.forEach((toggler) => {
            toggler.addEventListener("click", () => {
                toggler.classList.toggle("active");
                toggler.nextElementSibling.classList.toggle("active");
            });
        });
    </script>

    <script>
        $(document).ready(function(){
            $("#collapse-all").on('click', function(){
                if(!$(this).hasClass('active')){
                    $("li").addClass("active");   
                    $(".toggler").addClass("active");   
                    $(".toggler-target").addClass("active");   
                    $(this).addClass('active')
                }
                else{
                    $("li").removeClass("active");   
                    $(".toggler").removeClass("active");   
                    $(".toggler-target").removeClass("active");  
                    $(this).removeClass('active')
                }
                 
            });


            // $("#collapse-all").toggle(
            //     function(){
            //         $("li").addClass("active");   
            //         $(".toggler").addClass("active");   
            //         $(".toggler-target").addClass("active");  
            //     },
            //     function(){
            //         $("li").removeClass("active");   
            //         $(".toggler").removeClass("active");   
            //         $(".toggler-target").removeClass("active");
            // });
        });
        
    </script>


    <script>
        $(document).ready(function(){
            $("#type").on('change', function(){
                var val = $(this).val();
                console.log(val, val == "static");
                if(val == "static"){
                    $('#static-url').show();
                    $('#dynamic-url').hide();

                    $("#static_url").prop('required',true);
                    $("#dynamic-type").prop('required',false);
                    $("#get-dynamic-urls").prop('required',false);

                }
                else{
                    $('#static-url').hide();
                    $('#dynamic-url').show();
                    $('#get-dynamic-urls').find('option').remove().end();

                    $("#static_url").prop('required',false);
                    $("#dynamic-type").prop('required',true);
                    $("#get-dynamic-urls").prop('required',true);
                }
            });

            $("#dynamic-type").on('change', function(){
                let val = $(this).val();
                $.ajax({
                type:'GET',
                url:'/admin/menus/urls/' + val ,
                success:function(data) {
                    $('#get-dynamic-urls').find('option').remove().end();
                    $("#get-dynamic-urls").append( '<option value=""></option>');

                    $.each(data, function(key, value){
                        $("#get-dynamic-urls").append('<option value="' + value + '">' + value + '</option>');
                    });
                }
                });
            });
        });
    </script>

@endsection
