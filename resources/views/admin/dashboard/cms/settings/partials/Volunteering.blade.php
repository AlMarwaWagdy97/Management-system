@extends('admin.app')

@section('title', trans('settings.edit', ['name' => $settingMain->title]) )
@section('title_page', trans('settings.settings'))
@section('title_route', route('admin.settings.index') )
@section('button_page')
<a href="{{ route('admin.settings.index') }}" class="btn btn-outline-primary waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
@endsection


@section('content')

<form class="form-horizontal" action="{{route('admin.settings.volunteer', $settingMain->key)}}" method="POST" enctype="multipart/form-data" role="form">
    @csrf

    <div class="row text-center mt-5 mb-3">
        <label class="col-sm-2 col-form-label"> @lang('settings.title_setting') </label>
        <div class="col-sm-10">
            <input class="form-control" type="text" name="title" value="{{ @$settings['title'] }}" required>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">

            {{-- achievements ------------------------------------------------------------------------------------------------------------------ --}}
            <div class="accordion mt-4 my-5 " id="accordionExampletypes">
                <div class="accordion-item border rounded ">
                    <h2 class="accordion-header" id="headingTypes">
                        <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTypes" aria-expanded="true" aria-controls="collapseTypes">
                            {{ trans('settings.achievements') }}
                        </button>
                    </h2>

                    <div id="collapseTypes" class="accordion-collapse collapse show mt-3" aria-labelledby="headingTypes" data-bs-parent="#accordionExampletypes">
                        <div class="accordion-body">
                            <div class="row">
                                <div id="gift-filed">
                                    @if(@$settings['achievements'])
                                    @forelse (json_decode(@$settings['achievements']) as $key => $item)
                                    <div class="row new-gift-field mb-2 item_{{ $key }}">

                                        <div class="col-md-3">
                                            <label for="example-email-input" class="col-form-label"> {{ trans("settings.title")  . trans("lang." .Locale::getDisplayName("ar"))}} </label>
                                            <input type="text" class="form-control" name="achievements[{{ $key }}][title_ar]" value="{{ @$item->title_ar }}">
                                        </div>

                                        <div class="col-md-2">
                                            <label for="example-email-input" class="col-form-label"> {{ trans("settings.number")  . trans("lang." .Locale::getDisplayName("ar"))}} </label>
                                            <input type="text" class="form-control" name="achievements[{{ $key }}][number]" value="{{ @$item->number }}">
                                        </div>
                                        <div class="col-md-2">
                                            <label for="example-email-input" class="col-form-label"> {{ trans("settings.item")  . trans("lang." .Locale::getDisplayName("ar"))}} </label>
                                            <input type="text" class="form-control" name="achievements[{{ $key }}][item]" value="{{ @$item->item }}">
                                        </div>
                                        <div class="col-md-2">
                                            <label for="example-email-input" class="col-form-label"> {{ trans("settings.image")  . trans("lang." .Locale::getDisplayName("ar"))}} </label>
                                            @if(isset($item->image))
                                            <input type="hidden" class="form-control" name="achievements[{{ $key }}][image]" value="{{ @$item->image }}">
                                            <a href="{{ getImage($item->image ) }}" target="_blank">
                                                <img class="img-fluid" src="{{ getImage($item->image ) }}" alt="" width="75px">
                                            </a>
                                            @endif
                                            <input type="file" class="form-control my-2" name="achievements[{{ $key }}][image]">
                                        </div>

                                        <div class="col-md-1 mt-5">
                                            <a class="text-danger h3 fa-lg remove-row" onclick="removeItem({{ $key }})" data-key="{{ $key }}"> <i class="bx bx-trash"></i></a>
                                        </div>

                                        <hr class="my-3" />
                                    </div>
                                    @empty
                                    @endforelse
                                    @endif
                                </div>
                            </div>
                            <div class="row d-flex justify-content-center">
                                <button type="button" class="col-6  text-center add-gift-filed btn btn-success">اضافة فئة جديدة</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- initiative ------------------------------------------------------------------------------------------------------------------ --}}
            <div class="accordion mt-4 my-5" id="accordionIntiative">
                <div class="accordion-item border rounded ">
                    <h2 class="accordion-header" id="headingInitiative">
                        <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseInitiative" aria-expanded="true" aria-controls="collapseInitiative">
                            {{ trans('settings.initiative') }}
                        </button>
                    </h2>

                    <div id="collapseInitiative" class="accordion-collapse collapse show mt-3" aria-labelledby="headingInitiative" data-bs-parent="#accordionIntiative">
                        <div class="accordion-body">
                            <div class="row">
                                <div id="initiative-filed">
                                    @if(@$settings['initiative'])
                                    @forelse (json_decode(@$settings['initiative']) as $key => $item)
                                    <div class="row new-initiative-field mb-2 item_{{ $key }}">

                                        <div class="col-md-5">
                                            <label for="example-email-input" class="col-form-label"> {{ trans("settings.title")  . trans("lang." .Locale::getDisplayName("ar"))}} </label>
                                            <input type="text" class="form-control" name="initiative[{{ $key }}][title_ar]" value="{{ @$item->title_ar }}">
                                        </div>

                                        <div class="col-md-5">
                                            <label for="example-email-input" class="col-form-label"> {{ trans("settings.link")  . trans("lang." .Locale::getDisplayName("ar"))}} </label>
                                            <input type="link" class="form-control" name="initiative[{{ $key }}][link]" value="{{ @$item->link }}">
                                        </div>

                                        <div class="col-md-1 mt-5">
                                            <a class="text-danger h3 fa-lg remove-row" onclick="removeItem({{ $key }})" data-key="{{ $key }}"> <i class="bx bx-trash"></i></a>
                                        </div>

                                        <hr class="my-3 py-1" />
                                    </div>
                                    @empty
                                    @endforelse
                                    @endif
                                </div>
                            </div>
                            <div class="row d-flex justify-content-center">
                                <button type="button" class="col-6  text-center add-initiative-filed btn btn-success">اضافة فئة جديدة</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="row mb-3">
                        <label class="col-sm-1 col-form-label"> @lang('settings.whatsapp') </label>
                        <div class="col-sm-3">
                            <input type="number" class="form-control" name="whatsapp" value="{{ @$settings['whatsapp'] }}">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-1 col-form-label"> @lang('settings.status') </label>
                        <div class="col-sm-3">
                            <div class="form-check form-switch form-check-success mt-1">
                                <input type="hidden" name="status" value="0">
                                <input class="form-check-input" type="checkbox" name="status" {{ @$settings['status'] == 1 ? 'checked' : '' }} id="status">
                            </div>
                        </div>
                    </div>
                </div>


            </div>

        </div>
        <div class="row mb-3 text-end">
            <div>
                <a href="{{ route('admin.settings.index') }}" class="btn btn-outline-primary waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
                <button type="submit" class="btn btn-outline-success waves-effect waves-light ml-3 btn-sm">@lang('button.save')</button>
            </div>
        </div>
</form>

@endsection


@section('script')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    var max_fields = 20; //maximum input boxes allowed
    var giftSection = $("#gift-filed"); //Fields giftSection
    var add_button = $(".add-gift-filed"); //Add button class
    var count = $('#gift-filed .new-gift-field').length; //initlal text box count
    //adding new bank account
    $(add_button).click(function(e) { //on add input button click
        e.preventDefault();
        if (count < max_fields) { //max input box allowed
            count++; //text box increment
            $(giftSection).append(
                `<div class="row new-gift-field mb-2 item_${count}">
                    <div class="col-md-3">
                       <label for="example-email-input" class="col-form-label"> {{ trans("settings.title")  . trans("lang." .Locale::getDisplayName("ar"))}} </label>
                       <input type="text" class="form-control" name="achievements[${count}][title_ar]">
                   </div>
                   <div class="col-md-2">
                       <label for="example-email-input" class="col-form-label"> {{ trans("settings.number") }} </label>
                       <input type="number" class="form-control" name="achievements[${count}][number]">
                   </div>
                   <div class="col-md-2">
                       <label for="example-email-input" class="col-form-label"> {{ trans("settings.item") }} </label>
                       <input type="number" class="form-control" name="achievements[${count}][item]">
                   </div>
                   <div class="col-md-2">
                       <label for="example-email-input" class="col-form-label"> {{ trans("settings.image") }} </label>
                       <input type="file" class="form-control" name="achievements[${count}][image]">
                   </div>
                   <div class="col-md-1">
                       <a class="text-danger h3 fa-lg remove-row" onclick="removeItem(${count})"> <i class="bx bx-trash mt-4 pt-3"></i></a>
                   </div>
                <hr class="my-3"/>
                </div>`
            );
        }
    });


    var max_fields = 20; //maximum input boxes allowed
    var initiativeSection = $("#initiative-filed"); //Fields giftSection
    var add_button = $(".add-initiative-filed"); //Add button class
    var count = $('#initiative-filed .new-initiative-field').length; //initlal text box count
    //adding new bank account
    $(add_button).click(function(e) { //on add input button click
        e.preventDefault();
        if (count < max_fields) { //max input box allowed
            count++; //text box increment
            $(initiativeSection).append(
                `<div class="row new-initiative-field mb-2 initiative_${count}">
                    <div class="col-md-5">
                       <label for="example-email-input" class="col-form-label"> {{ trans("settings.title")  . trans("lang." .Locale::getDisplayName("ar"))}} </label>
                       <input type="text" class="form-control" name="initiative[${count}][title_ar]">
                   </div>
                   <div class="col-md-5">
                       <label for="example-email-input" class="col-form-label"> {{ trans("settings.link") }} </label>
                       <input type="link" class="form-control" name="initiative[${count}][link]">
                   </div>
                   <div class="col-md-1">
                       <a class="text-danger h3 fa-lg remove-initiative-row" onclick="removeInitiativeItem(${count})"> <i class="bx bx-trash mt-4 pt-3"></i></a>
                   </div>
                <hr class="my-3"/>
                </div>`
            );
        }
    });

    // remove row
    $('.remove-initiative-row').click(function() {
        $(this).parent().parent().remove();
    })

    $('.remove-row').click(function() {
        $(this).parent().parent().remove();
    })

    function removeInitiativeItem(id) {
        $('.initiative_' + id).remove();
    }

    function removeItem(id) {
        $('.item_' + id).remove();
    }

</script>
@endsection
