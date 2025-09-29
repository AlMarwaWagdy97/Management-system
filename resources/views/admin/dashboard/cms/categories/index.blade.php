@extends('admin.app')

@section('title', trans('categories.show_all'))
@section('title_page', trans('categories.categories'))
@section('title_route', route('admin.categories.index') )
@section('button_page')
<a href="{{ route('admin.categories.index') }}" class="btn btn-outline-primary waves-effect waves-light ml-3">@lang('button.cancel')</a>
@endsection

@section('style')
{{-- @vite(['resources/assets/admin/css/data-tables.js']) --}}
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
                        <form action="{{ route('admin.categories.show_tree') }}" method="GET">
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
                        <a href="{{ route('admin.categories.create') }}" data-hover="@lang('admin.create')" class="btn btn-success"> @lang('admin.create')</i></a>
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
                        @include('admin/dashboard/categories/tree')

                        {{-- <li class="todo-plus">
                                <a href="{{ route('admin.menus.create', 0) }}" data-hover="@lang('admin.create')" class="text-success" ><i class="fas fa-plus"></i></a>
                        </li> --}}
                    </ul>
                </div>
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
    $(document).ready(function() {
        $("#collapse-all").on('click', function() {
            if (!$(this).hasClass('active')) {
                $("li").addClass("active");
                $(".toggler").addClass("active");
                $(".toggler-target").addClass("active");
                $(this).addClass('active')
            } else {
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
    $(document).ready(function() {
        $("#type").on('change', function() {
            var val = $(this).val();
            console.log(val, val == "static");
            if (val == "static") {
                $('#static-url').show();
                $('#dynamic-url').hide();

                $("#static_url").prop('required', true);
                $("#dynamic-type").prop('required', false);
                $("#get-dynamic-urls").prop('required', false);

            } else {
                $('#static-url').hide();
                $('#dynamic-url').show();
                $('#get-dynamic-urls').find('option').remove().end();

                $("#static_url").prop('required', false);
                $("#dynamic-type").prop('required', true);
                $("#get-dynamic-urls").prop('required', true);
            }
        });

        $("#dynamic-type").on('change', function() {
            let val = $(this).val();
            $.ajax({
                type: 'GET'
                , url: '/admin/menus/urls/' + val
                , success: function(data) {
                    $('#get-dynamic-urls').find('option').remove().end();
                    $("#get-dynamic-urls").append('<option value=""></option>');

                    $.each(data, function(key, value) {
                        $("#get-dynamic-urls").append('<option value="' + value + '">' + value + '</option>');
                    });
                }
            });
        });
    });

</script>

@endsection
