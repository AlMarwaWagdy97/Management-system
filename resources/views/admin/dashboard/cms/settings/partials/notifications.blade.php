@extends('admin.app')

@section('title', trans('settings.edit', ['name' => $settingMain->title]) )
@section('title_page', trans('settings.settings'))
@section('title_route', route('admin.settings.index') )
@section('button_page')
<a href="{{ route('admin.settings.index') }}" class="btn btn-outline-primary waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
@endsection


@section('style')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="{{ asset('site/js/ckeditor/ckeditor.js') }}"></script>
@endsection

@section('content')
<form class="form-horizontal" action="{{route('admin.settings.update-custom', $settingMain->key)}}" method="POST" enctype="multipart/form-data" role="form">
    @csrf

    <div class="row  mt-5 mb-3">
        <label class="col-sm-2 text-center col-form-label"> @lang('settings.title_setting') </label>
        <div class="col-sm-10 text-center">
            <input class="form-control" type="text" name="title" value="{{ @$settings['title'] }}" required>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">

            {{-- Email  --}}
            <div class="accordion mt-4 mb-4" id="accordionEmail">
                <div class="accordion-item border rounded">
                    <h2 class="accordion-header" id="headingEmail">
                        <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseEmail" aria-expanded="true" aria-controls="collapseEmail">
                            @lang('settings.email')
                        </button>
                    </h2>
                    <div id="collapseEmail" class="accordion-collapse collapse  mt-3" aria-labelledby="headingEmail" data-bs-parent="#accordionEmail">
                        <div class="accordion-body collapsed">
                            <div class="row bg-light rounded p-3 m-3">
                                <h4 class="text-primary"> @lang('settings.receive_order') </h4>
                                {{-- receive  status --}}
                                <div class="col-12 mt-3">
                                    <div class="row mb-3">
                                        <label class="col-sm-2 col-form-label"> @lang('settings.status') </label>
                                        <div class="col-sm-5">
                                            <div class="form-check form-switch form-check-success mt-1">
                                                <input type="hidden" name="email_receive_status" value="0">
                                                <input class="form-check-input" type="checkbox" name="email_receive_status" {{ @$settings['email_receive_status'] == 1 ? 'checked' : '' }} id="email_receive_status">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- receive  subject --}}
                                <div class="col-12">
                                    <div class="row mb-3">
                                        <label class="col-sm-2 col-form-label"> @lang('settings.subject') </label>
                                        <div class="col-sm-9">
                                            <input class="form-control" type="text" name="email_receive_subject" value="{{ @$settings['email_receive_subject'] }}">
                                        </div>
                                    </div>
                                </div>
                                {{--  receive message  --}}
                                <div class="col-12">
                                    <div class="row mb-3">
                                        <label class="col-sm-2 col-form-label"> @lang('settings.message') </label>
                                        <div class="col-sm-9">
                                            <div class="form-group mb-2">
                                                <br>
                                                <button type="button" class="btn btn-primary" onclick="$('#email_receive_message').val($('#email_receive_message').val() +'[[name]]') ;return false;" value=""> @lang('settings.attach_name') </button>
                                                <button type="button" class="btn btn-primary" onclick="$('#email_receive_message').val($('#email_receive_message').val() +'[[identifier]]') ;return false;" value=""> @lang('settings.attach_identifier') </button>
                                                <button type="button" class="btn btn-primary" onclick="$('#email_receive_message').val($('#email_receive_message').val() +'[[total]]') ;return false;" value=""> @lang('settings.attach_amount') </button>
                                                <button type="button" class="btn btn-primary" onclick="$('#email_receive_message').val($('#email_receive_message').val() +'[[project]]') ;return false;" value=""> @lang('settings.attach_project_name') </button>
                                                <small class="red "> @lang('settings.replace_message')</small>
                                            </div>
                                            <textarea class="form-control" name="email_receive_message" rows="6" id="email_receive_message"> {{ @$settings['email_receive_message'] }} </textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row bg-light rounded p-3 m-3">
                                <h4 class="text-primary"> @lang('settings.confirm_order') </h4>
                                {{-- receive status --}}
                                <div class="col-12 mt-3">
                                    <div class="row mb-3">
                                        <label class="col-sm-2 col-form-label"> @lang('settings.status') </label>
                                        <div class="col-sm-5">
                                            <div class="form-check form-switch form-check-success mt-1">
                                                <input type="hidden" name="email_confirm_status" value="0">
                                                <input class="form-check-input" type="checkbox" name="email_confirm_status" {{ @$settings['email_confirm_status'] == 1 ? 'checked' : '' }} id="email_confirm_status">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- receive subject --}}
                                <div class="col-12">
                                    <div class="row mb-3">
                                        <label class="col-sm-2 col-form-label"> @lang('settings.subject') </label>
                                        <div class="col-sm-9">
                                            <input class="form-control" type="text" name="email_confirm_subject" value="{{ @$settings['email_confirm_subject'] }}">
                                        </div>
                                    </div>
                                </div>
                                {{-- receive message  --}}
                                <div class="col-12">
                                    <div class="row mb-3">
                                        <label class="col-sm-2 col-form-label"> @lang('settings.message') </label>
                                        <div class="col-sm-9">
                                            <div class="form-group mb-2">
                                                <br>
                                                <button type="button" class="btn btn-primary" onclick="$('#email_confirm_message').val($('#email_confirm_message').val() +'[[name]]') ;return false;" value=""> @lang('settings.attach_name') </button>
                                                <button type="button" class="btn btn-primary" onclick="$('#email_confirm_message').val($('#email_confirm_message').val() +'[[identifier]]') ;return false;" value=""> @lang('settings.attach_identifier') </button>
                                                <button type="button" class="btn btn-primary" onclick="$('#email_confirm_message').val($('#email_confirm_message').val() +'[[total]]') ;return false;" value=""> @lang('settings.attach_amount') </button>
                                                <button type="button" class="btn btn-primary" onclick="$('#email_confirm_message').val($('#email_confirm_message').val() +'[[project]]') ;return false;" value=""> @lang('settings.attach_project_name') </button>
                                                <small class="red "> @lang('settings.replace_message')</small>
                                            </div>
                                            <textarea class="form-control" name="email_confirm_message" rows="6" id="email_confirm_message"> {{ @$settings['email_confirm_message'] }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- SMS Setting  --}}
            <div class="accordion mt-4 mb-4" id="accordionSMS">
                <div class="accordion-item border rounded">
                    <h2 class="accordion-header" id="headingSMS">
                        <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSMS" aria-expanded="true" aria-controls="collapseSMS">
                            @lang('settings.sms')
                        </button>
                    </h2>
                    <div id="collapseSMS" class="accordion-collapse collapse  mt-3" aria-labelledby="headingSMS" data-bs-parent="#accordionSMS">
                        <div class="accordion-body collapsed">
                            <div class="row bg-light rounded p-3 m-3">
                                <h4 class="text-primary"> @lang('settings.receive_order') </h4>
                                {{-- receive  status --}}
                                <div class="col-12 mt-3">
                                    <div class="row mb-3">
                                        <label class="col-sm-2 col-form-label"> @lang('settings.status') </label>
                                        <div class="col-sm-5">
                                            <div class="form-check form-switch form-check-success mt-1">
                                                <input type="hidden" name="sms_receive_status" value="0">
                                                <input class="form-check-input" type="checkbox" name="sms_receive_status" {{ @$settings['sms_receive_status'] == 1 ? 'checked' : '' }} id="sms_receive_status">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{--  receive message  --}}
                                <div class="col-12">
                                    <div class="row mb-3">
                                        <label class="col-sm-2 col-form-label"> @lang('settings.message') </label>
                                        <div class="col-sm-9">
                                            <div class="form-group mb-2">
                                                <br>
                                                <button type="button" class="btn btn-primary" onclick="$('#sms_receive_message').val($('#sms_receive_message').val() +'[[name]]') ;return false;" value=""> @lang('settings.attach_name') </button>
                                                <button type="button" class="btn btn-primary" onclick="$('#sms_receive_message').val($('#sms_receive_message').val() +'[[identifier]]') ;return false;" value=""> @lang('settings.attach_identifier') </button>
                                                <button type="button" class="btn btn-primary" onclick="$('#sms_receive_message').val($('#sms_receive_message').val() +'[[total]]') ;return false;" value=""> @lang('settings.attach_amount') </button>
                                                <button type="button" class="btn btn-primary" onclick="$('#sms_receive_message').val($('#sms_receive_message').val() +'[[project]]') ;return false;" value=""> @lang('settings.attach_project_name') </button>
                                                <small class="red "> @lang('settings.replace_message')</small>
                                            </div>
                                            <textarea class="form-control" name="sms_receive_message" rows="6" id="sms_receive_message"> {{ @$settings['sms_receive_message'] }} </textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row bg-light rounded p-3 m-3">
                                <h4 class="text-primary"> @lang('settings.confirm_order') </h4>
                                {{-- receive status --}}
                                <div class="col-12 mt-3">
                                    <div class="row mb-3">
                                        <label class="col-sm-2 col-form-label"> @lang('settings.status') </label>
                                        <div class="col-sm-5">
                                            <div class="form-check form-switch form-check-success mt-1">
                                                <input type="hidden" name="sms_confirm_status" value="0">
                                                <input class="form-check-input" type="checkbox" name="sms_confirm_status" {{ @$settings['sms_confirm_status'] == 1 ? 'checked' : '' }} id="sms_confirm_status">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- receive message  --}}
                                <div class="col-12">
                                    <div class="row mb-3">
                                        <label class="col-sm-2 col-form-label"> @lang('settings.message') </label>
                                        <div class="col-sm-9">
                                            <div class="form-group mb-2">
                                                <br>
                                                <button type="button" class="btn btn-primary" onclick="$('#sms_confirm_message').val($('#sms_confirm_message').val() +'[[name]]') ;return false;" value=""> @lang('settings.attach_name') </button>
                                                <button type="button" class="btn btn-primary" onclick="$('#sms_confirm_message').val($('#sms_confirm_message').val() +'[[identifier]]') ;return false;" value=""> @lang('settings.attach_identifier') </button>
                                                <button type="button" class="btn btn-primary" onclick="$('#sms_confirm_message').val($('#sms_confirm_message').val() +'[[total]]') ;return false;" value=""> @lang('settings.attach_amount') </button>
                                                <button type="button" class="btn btn-primary" onclick="$('#sms_confirm_message').val($('#sms_confirm_message').val() +'[[project]]') ;return false;" value=""> @lang('settings.attach_project_name') </button>
                                                <small class="red "> @lang('settings.replace_message')</small>
                                            </div>
                                            <textarea class="form-control" name="sms_confirm_message" rows="6" id="sms_confirm_message"> {{ @$settings['sms_confirm_message'] }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- WhatsApp Setting  --}}
            <div class="accordion mt-4 mb-4" id="accordionWhatsApp">
                <div class="accordion-item border rounded">
                    <h2 class="accordion-header" id="headingWhatsApp">
                        <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseWhatsApp" aria-expanded="true" aria-controls="collapseWhatsApp">
                            @lang('settings.WhatsApp')
                        </button>
                    </h2>
                    <div id="collapseWhatsApp" class="accordion-collapse collapse mt-3" aria-labelledby="headingWhatsApp" data-bs-parent="#accordionWhatsApp">
                        <div class="accordion-body collapsed">
                            <div class="row d-flex justify-content-center">
                                {{-- receive  status --}}
                                <div class="col-12 col-md-5 bg-light rounded p-3 m-3">
                                    <h4 class="text-primary"> @lang('settings.receive_order') </h4>
                                    <div class="row mb-3">
                                        <label class="col-sm-4 col-form-label"> @lang('settings.status') </label>
                                        <div class="col-sm-5">
                                            <div class="form-check form-switch form-check-success mt-1">
                                                <input type="hidden" name="whatsapp_receive_status" value="0">
                                                <input class="form-check-input" type="checkbox" name="whatsapp_receive_status" {{ @$settings['whatsapp_receive_status'] == 1 ? 'checked' : '' }} id="whatsapp_receive_status">
                                            </div>
                                        </div>
                                    </div>
                                     {{-- receive  template --}}
                                    <div class="col-12">
                                        <div class="row mb-3">
                                            <label class="col-sm-2 col-form-label"> @lang('settings.template_name') </label>
                                            <div class="col-sm-9">
                                                <input class="form-control" type="text" name="whatsapp_receive_template" value="{{ @$settings['whatsapp_receive_template'] }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                 {{-- receive  status --}}
                                 <div class="col-12 col-md-5 bg-light rounded p-3 m-3">
                                    <h4 class="text-primary"> @lang('settings.confirm_order') </h4>
                                    <div class="row mb-3">
                                        <label class="col-sm-2 col-form-label"> @lang('settings.status') </label>
                                        <div class="col-sm-5">
                                            <div class="form-check form-switch form-check-success mt-1">
                                                <input type="hidden" name="sms_confirm_status" value="0">
                                                <input class="form-check-input" type="checkbox" name="whatsapp_confirm_status" {{ @$settings['whatsapp_confirm_status'] == 1 ? 'checked' : '' }} id="whatsapp_confirm_status">
                                            </div>
                                        </div>
                                    </div>
                                     {{-- confirm  template --}}
                                    <div class="col-12">
                                        <div class="row mb-3">
                                            <label class="col-sm-2 col-form-label"> @lang('settings.template_name') </label>
                                            <div class="col-sm-9">
                                                <input class="form-control" type="text" name="whatsapp_confirm_template" value="{{ @$settings['whatsapp_confirm_template'] }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
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
