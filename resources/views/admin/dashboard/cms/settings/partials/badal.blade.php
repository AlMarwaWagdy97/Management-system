@extends('admin.app')

@section('title', trans('settings.edit', ['name' => $settingMain->title]) )
@section('title_page', trans('settings.settings'))
@section('title_route', route('admin.settings.index') )
@section('button_page')
<a href="{{ route('admin.settings.index') }}" class="btn btn-outline-primary waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
@endsection


@section('content')

<form class="form-horizontal" action="{{route('admin.settings.update-custom', $settingMain->key)}}" method="POST" enctype="multipart/form-data" role="form">
    @csrf

    <div class="row text-center mt-5 mb-3">
        <label class="col-sm-2 col-form-label"> @lang('settings.title_setting') </label>
        <div class="col-sm-10">
            <input class="form-control" type="text" name="title" value="{{ @$settings['title'] }}" required>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">

            {{-- information form ------------------------------------------------------------------------------------------------------------------ --}}
            <div class="accordion mt-4 my-5 " id="accordionExampletypes">
                <div class="accordion-item border rounded ">
                    <h2 class="accordion-header" id="headingTypes">
                        <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTypes" aria-expanded="true" aria-controls="collapseTypes">
                            {{ trans('settings.information') }}
                        </button>
                    </h2>
                    <div id="collapseTypes" class="accordion-collapse collapse show mt-3" aria-labelledby="headingTypes" data-bs-parent="#accordionExampletypes">
                        <div class="accordion-body">
                            <div class="row">

                                {{-- relations-------------------- --}}
                                <div class="col-12 col-md-5 col-lg-5 border p-3 m-3">
                                    <label for="example-email-input" class="col-form-label"> {{ trans("settings.relations") }} </label>
                                    <div class="row">
                                        <div id="relations-filed">
                                            @if(@$settings['relations'])
                                            @forelse (json_decode(@$settings['relations']) as $key => $item)
                                            <div class="new-relation-field mb-2 item_relation_{{ $loop->index }}">
                                                <div class="row">

                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control" name="relations[{{ $loop->index }}]" value="{{ @$item}}">
                                                    </div>

                                                    <div class="col-md-1">
                                                        <a class="text-danger h3 fa-lg remove-row" onclick="removeRelationItem({{ $loop->index }})" data-key="{{ $loop->index }}"> <i class="bx bx-trash"></i></a>
                                                    </div>
                                                </div>

                                            </div>
                                            @empty
                                            @endforelse
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row d-flex justify-content-center">
                                        <button type="button" class="col-6  text-center add-relations-filed btn btn-success">اضافة فئة جديدة</button>
                                    </div>
                                </div>

                                {{-- gender-------------------- --}}
                                <div class="col-12 col-md-5 col-lg-5 border p-3 m-3">
                                    <label for="example-email-input" class="col-form-label"> {{ trans("settings.gender") }} </label>
                                    <div class="row">
                                        <div id="gender-filed">
                                            @if(@$settings['gender'])
                                            @forelse (json_decode(@$settings['gender']) as $key => $item)
                                            <div class="new-gender-field mb-2 item_gender_{{  $loop->index }}">
                                                <div class="row">
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control" name="gender[{{  $loop->index }}]" value="{{ @$item}}">
                                                    </div>
    
                                                    <div class="col-md-1">
                                                        <a class="text-danger h3 fa-lg remove-row" onclick="removeGenderItem({{  $loop->index }})" data-key="{{  $loop->index }}"> <i class="bx bx-trash"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                            @empty
                                            @endforelse
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row d-flex justify-content-center mt-3">
                                        <button type="button" class="col-6  text-center add-gender-filed btn btn-success">اضافة فئة جديدة</button>
                                    </div>
                                </div>

                                {{-- languages-------------------- --}}
                                <div class="col-12 col-md-5 col-lg-5 border p-3 m-3">
                                    <label for="example-email-input" class="col-form-label"> {{ trans("settings.languages") }} </label>
                                    <div class="row">
                                        <div id="languages-filed">
                                            @if(@$settings['languages'])
                                            
                                            @forelse (json_decode(@$settings['languages']) as $key => $item)
                                            <div class="new-languages-field mb-2 item_languages_{{ $key }}">
                                                <div class="row">
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control" name="languages[{{ $loop->index }}]" value="{{ @$item}}">
                                                    </div>
    
                                                    <div class="col-md-1">
                                                        <a class="text-danger h3 fa-lg remove-row" onclick="removeLanguagesItem({{ $loop->index }})" data-key="{{ $loop->index }}"> <i class="bx bx-trash"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                            @empty
                                            @endforelse
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row d-flex justify-content-center mt-3">
                                        <button type="button" class="col-6  text-center add-languages-filed btn btn-success">اضافة فئة جديدة</button>
                                    </div>
                                </div>

                                {{-- nationality-------------------- --}}
                                <div class="col-12 col-md-5 col-lg-5 border p-3 m-3">
                                    <label for="example-email-input" class="col-form-label"> {{ trans("settings.nationality") }} </label>
                                    <div class="row">
                                        <div id="nationality-filed">
                                            @if(@$settings['nationality'])
                                            @forelse (json_decode(@$settings['nationality']) as $key => $item)
                                            <div class="new-nationality-field mb-2 item_national_{{ $key }}">
                                                <div class="row">
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control" name="nationality[{{ $loop->index }}]" value="{{ @$item}}">
                                                    </div>
    
                                                    <div class="col-md-1">
                                                        <a class="text-danger h3 fa-lg remove-row" onclick="removeItemNationality({{ $loop->index }})" data-key="{{ $loop->index }}"> <i class="bx bx-trash"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                            @empty
                                            @endforelse
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row d-flex justify-content-center mt-3">
                                        <button type="button" class="col-6  text-center add-nationality-filed btn btn-success">اضافة فئة جديدة</button>
                                    </div>
                                </div>

                                {{-- late hours ----------------- --}}
                                <div class="row">
                                    <div class="col-12 col-md-5 col-lg-5 p-3 m-3">
                                        <label for="" class="form-label">@lang('settings.offers_duration')</label>
                                        <input type="number" name="offer_time" value="{{  @$settings['offer_time'] }}" class="form-control col-md-6">
                                    </div>

                                    <div class="col-12 col-md-5 col-lg-5 p-3 m-3">
                                        <label for="" class="form-label"> @lang('settings.delay_hours_order') </label>
                                        <input type="number" name="late_time" value="{{  @$settings['late_time'] }}" class="form-control col-md-6">
                                        <span class="text-danger h6"> (عندما الطلب يتاخر , سيتم الغاءه واضافه الحج او العمره من جديد)</span>
                                    </div>
                                </div>

                                {{-- new_license_img ---------------------------------------------------- --}}
                                <div class="row">
                                    <div class="col-12 col-md-5 col-lg-5 p-3 m-3">
                                        <label for="" class="form-label">@lang('settings.offers_duration')</label>
                                        <input class="form-control" type="file" name="new_license_img">
                                    </div>
                                    <div class="col-12 col-md-5 col-lg-5 p-3 m-3">
                                        @if(isset($settings['new_license_img']))
                                        <div class="col-sm-6">
                                            <a href="{{ getImage(@$settings['new_license_img'])}}">
                                                <img src="{{ getImageThumb(@$settings['new_license_img'])}}" width="100" class="rounded bg-light" />
                                            </a>
                                        </div>
                                        @else
                                        <div class="col-sm-3">
                                            <img src="{{ admin_path('images/notfound.jpg') }}" width="50" class="rounded" />
                                        </div>
                                        @endif
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- badal project information ------------------------------------------------------------------------------------------------------------------ --}}
            <div class="accordion mt-4 my-5" id="accordionIntiative">
                <div class="accordion-item border rounded ">
                    <h2 class="accordion-header" id="headingInitiative">
                        <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseInitiative" aria-expanded="true" aria-controls="collapseInitiative">
                            {{ trans('settings.projects_info') }}
                        </button>
                    </h2>

                    <div id="collapseInitiative" class="accordion-collapse collapse show mt-3" aria-labelledby="headingInitiative" data-bs-parent="#accordionIntiative">
                        <div class="accordion-body">
                            <div class="row">
                                {{-- haij --------------------------------------------------------- --}}
                                <div class="row haij my-5">
                                    <div class="col-md-2">
                                        <label for="" class="form-label"> اسم الحج </label>
                                        <input type="text" name="haij_text" value="{{ @$settings['haij_text'] }}" class="form-control col-md-6">
                                    </div>
                                    <div class="col-md-2">
                                        <label for="" class="form-label"> ايكون الحج </label>
                                        <input type="file" name="haij_icon" class="form-control col-md-6">
                                    </div>
                                    <div class="col-md-2">
                                        @if(isset($settings['haij_icon']))
                                        <div class="col-sm-6">
                                            <a href="{{ getImage(@$settings['haij_icon'])}}">
                                                <img src="{{ getImageThumb(@$settings['haij_icon'])}}" width="100" class="rounded" />
                                            </a>
                                        </div>
                                        @else
                                        <div class="col-sm-2">
                                            <img src="{{ admin_path('images/notfound.jpg') }}" width="100" class="rounded" />
                                        </div>
                                        @endif
                                    </div>
                                    <div class="col-md-2">
                                        <label for="" class="form-label"> صوره الحج </label>
                                        <input type="file" name="haij_image" class="form-control col-md-6">

                                    </div>
                                    <div class="col-md-2">
                                        @if(isset($settings['haij_image']))
                                        <div class="col-sm-6">
                                            <a href="{{ getImage(@$settings['haij_image'])}}">
                                                <img src="{{ getImageThumb(@$settings['haij_image'])}}" width="100" class="rounded" />
                                            </a>
                                        </div>
                                        @else
                                        <div class="col-sm-2">
                                            <img src="{{ admin_path('images/notfound.jpg') }}" width="100" class="rounded" />
                                        </div>
                                        @endif
                                    </div>

                                    <div class="col-md-2">
                                        <label for="" class="form-label"> حالة الحج </label>
                                        <div class="form-check form-switch form-check-success mt-1">
                                            <input type="hidden" name="haij_status" value="0">
                                            <input class="form-check-input" type="checkbox" name="haij_status" @if(@$settings['haij_status'] ==1 ) checked @endif id="haij_status">
                                        </div>
                                    </div>
                                </div>

                                <hr>

                                {{-- umrah --------------------------------------------------------- --}}
                                <div class="row umrah mt-5">
                                    <div class="col-md-2">
                                        <label for="" class="form-label"> اسم العمرة </label>
                                        <input type="text" name="umrah_text" value="{{ @$settings['umrah_text'] }}" class="form-control col-md-6">
                                    </div>
                                    <div class="col-md-2">
                                        <label for="" class="form-label"> ايكون العمرة </label>
                                        <input type="file" name="umrah_icon" class="form-control col-md-6">
                                    </div>
                                    <div class="col-md-2">
                                        @if(isset($settings['umrah_icon']))
                                        <div class="col-sm-6">
                                            <a href="{{ getImage(@$settings['umrah_icon'])}}">
                                                <img src="{{ getImageThumb(@$settings['umrah_icon'])}}" width="100" class="rounded" />
                                            </a>
                                        </div>
                                        @else
                                        <div class="col-sm-2">
                                            <img src="{{ admin_path('images/notfound.jpg') }}" width="100" class="rounded" />
                                        </div>
                                        @endif
                                    </div>
                                    <div class="col-md-2">
                                        <label for="" class="form-label"> صوره العمرة </label>
                                        <input type="file" name="umrah_image" class="form-control col-md-6">

                                    </div>
                                    <div class="col-md-2">
                                        @if(isset($settings['umrah_image']))
                                        <div class="col-sm-6">
                                            <a href="{{ getImage(@$settings['umrah_image'])}}">
                                                <img src="{{ getImageThumb(@$settings['umrah_image'])}}" width="100" class="rounded" />
                                            </a>
                                        </div>
                                        @else
                                        <div class="col-sm-2">
                                            <img src="{{ admin_path('images/notfound.jpg') }}" width="100" class="rounded" />
                                        </div>
                                        @endif
                                    </div>

                                    <div class="col-md-2">
                                        <label for="" class="form-label"> حالة العمرة </label>
                                        <div class="form-check form-switch form-check-success mt-1">
                                            <input type="hidden" name="umrah_status" value="0">
                                            <input class="form-check-input" type="checkbox" name="umrah_status" @if(@$settings['umrah_status']==1) checked @endif id="umrah_status">
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            {{-- badal site project afer order ------------------------------------------------------------------------------------------------------------------ --}}
            <div class="accordion mt-4 my-5" id="accordionProjects">
                <div class="accordion-item border rounded ">
                    <h2 class="accordion-header" id="headingProjects">
                        <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseProjects" aria-expanded="true" aria-controls="collapseProjects">
                            {{ trans('admin.projects') }}
                        </button>
                    </h2>

                    <div id="collapseProjects" class="accordion-collapse collapse show mt-3" aria-labelledby="headingProjects" data-bs-parent="#accordionProjects">
                        <div class="accordion-body">
                            <div class="row">
                                {{-- projects ---------------------------------------------------------------------------------    --}}
                                <div class="row">
                                    <div class="col-md-12 col-12 mb-3">
                                        <label> @lang('settings.choose_projectFinsiedOrder')</label>
                                    </div>

                                    @php
                                    $projectsIds = @$settings['projects'] ? json_decode( @$settings['projects'] ?? [] ) : [];
                                    @endphp

                                    <select class="form-select form-select-sm select2 {{ (empty($errors->first('projects'))) ?: 'has-error'  }}" multiple name="projects[]">
                                        <option value="" disabled> @lang('charityProject.choose_tag')</option>
                                        @forelse ($projects as $key => $project)
                                        <option value="{{ $project->id }}" {{ in_array($project->id, $projectsIds)  ?? [] ?  'selected' : '' }}>
                                            {{ $project->trans->where('locale', $current_lang)->first()->title }}
                                        </option>
                                        @empty
                                        @endforelse
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">

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
    </div>
</form>

@endsection


@section('script')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="{{ asset('backend/js/select2.js') }}"></script>

<script>
    // relations -----------------------------
    var max_fields = 20; //maximum input boxes allowed

    var relationsection = $("#relations-filed"); //Fields giftSection
    var add_button = $(".add-relations-filed"); //Add button class
    var countRelation = $('#relations-filed .new-relation-field').length; //initlal text box count
console.log("countRelation", countRelation);
    //adding new bank account
    $(add_button).click(function(e) { //on add input button click
        e.preventDefault();
        if (countRelation < max_fields) { //max input box allowed
            countRelation++; //text box increment
            $(relationsection).append(
                `<div class="row new-relation-field mb-2 item_relation_${countRelation}">
                    <div class="col-md-9">
                       <input type="text" class="form-control" name="relations[${countRelation}]">
                   </div>
                   <div class="col-md-1">
                       <a class="text-danger h3 fa-lg remove-row" onclick="removeRelationItem(${countRelation})"> <i class="bx bx-trash"></i></a>
                   </div>
                </div>`
            );
        }
    });
    
    function removeRelationItem(id) {
        $('.item_relation_' + id).remove();
    }


    // gender -----------------------------
    var genderSection = $("#gender-filed"); //Fields giftSection
    var addGenderButton = $(".add-gender-filed"); //Add button class
    var countGender = $('#gender-filed .new-gender-field').length; //initlal text box count
    console.log("countGender", countGender);

    //adding new bank account
    $(addGenderButton).click(function(e) { //on add input button click
        e.preventDefault();
        if (countGender < max_fields) { //max input box allowed
            countGender++; //text box increment
            $(genderSection).append(
                `<div class="row new-relation-field mb-2 item_gender_${countGender}">
                    <div class="col-md-9">
                       <input type="text" class="form-control" name="gender[${countGender}]">
                   </div>
                   <div class="col-md-1">
                       <a class="text-danger h3 fa-lg remove-row" onclick="removeGenderItem(${countGender})"> <i class="bx bx-trash"></i></a>
                   </div>
                </div>`
            );
        }
    });
    function removeGenderItem(id) {
        $('.item_gender_' + id).remove();
    }


    // languages -----------------------------
    var languagesSection = $("#languages-filed"); //Fields giftSection
    var addLanguagesButton = $(".add-languages-filed"); //Add button class
    var countLanguage = $('#languages-filed .new-languages-field').length; //initlal text box count
    console.log("countLanguage", countLanguage);
    //adding new bank account
    $(addLanguagesButton).click(function(e) { //on add input button click
        e.preventDefault();
        if (countLanguage < max_fields) { //max input box allowed
            countLanguage++; //text box increment
            $(languagesSection).append(
                `<div class="row new-relation-field mb-2 item_languages_${countLanguage}">
                    <div class="col-md-9">
                       <input type="text" class="form-control" name="languages[${countLanguage}]">
                   </div>
                   <div class="col-md-1">
                       <a class="text-danger h3 fa-lg remove-row" onclick="removeLanguagesItem(${countLanguage})"> <i class="bx bx-trash"></i></a>
                   </div>
                </div>`
            );
        }
    });
    function removeLanguagesItem(id) {
        $('.item_languages_' + id).remove();
    }
    

    // nationality -----------------------------
    var nationalitySection = $("#nationality-filed"); //Fields giftSection
    var addNationalityButton = $(".add-nationality-filed"); //Add button class
    var countNational = $('#nationality-filed .new-nationality-field').length; //initlal text box count
    console.log("countNational", countNational);
    //adding new bank account
    $(addNationalityButton).click(function(e) { //on add input button click
        e.preventDefault();
        if (countNational < max_fields) { //max input box allowed
            countNational++; //text box increment
            $(nationalitySection).append(
                `<div class="row new-relation-field mb-2 item_national_${countNational}">
                    <div class="col-md-9">
                       <input type="text" class="form-control" name="nationality[${countNational}]">
                   </div>
                   <div class="col-md-1">
                       <a class="text-danger h3 fa-lg remove-row" onclick="removeItemNationality(${countNational})"> <i class="bx bx-trash"></i></a>
                   </div>
                </div>`
            );
        }
    });
    function removeItemNationality(id) {
        $('.item_national_' + id).remove();
    }


</script>
@endsection
