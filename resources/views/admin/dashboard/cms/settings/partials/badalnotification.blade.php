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
               
            {{-- new Order ------------------------------------------------------------------------------------- --}}
            <div class="accordion mt-4 mb-4" id="accordionNewOrder">
                <div class="accordion-item border rounded">
                    <h2 class="accordion-header" id="headingNewOrder">
                        <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseNewOrder" aria-expanded="true" aria-controls="collapseNewOrder">
                            @lang('settings.notify_new_order') 
                        </button>
                    </h2>
                    <div id="collapseNewOrder" class="accordion-collapse collapse  mt-3" aria-labelledby="headingNewOrder" data-bs-parent="#accordionNewOrder">
                        <div class="accordion-body collapsed">
                            {{-- email ----------------------------------------------------------------------- --}}
                            <div class="row bg-light rounded p-3 m-3">
                                <h4 class="text-primary"> @lang('settings.email')</h4>
                                {{-- new Order  status --}}
                                <div class="col-12 mt-3">
                                    <div class="row mb-3">
                                        <label class="col-sm-2 col-form-label"> @lang('settings.status') </label>
                                        <div class="col-sm-5">
                                            <div class="form-check form-switch form-check-success mt-1">
                                                <input type="hidden" name="email_newOrder_enabled" value="0">
                                                <input class="form-check-input" type="checkbox" name="email_newOrder_enabled" {{ @$settings['email_newOrder_enabled'] == 1 ? 'checked' : '' }} id="email_newOrder_enabled">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- new Order  subject --}}
                                <div class="col-12">
                                    <div class="row mb-3">
                                        <label class="col-sm-2 col-form-label"> @lang('settings.subject') </label>
                                        <div class="col-sm-9">
                                            <input class="form-control" type="text" name="email_newOrder_subject" value="{{ @$settings['email_newOrder_subject'] }}">
                                        </div>
                                    </div>
                                </div>
                                {{-- new Order message  --}}
                                <div class="col-12">
                                    <div class="row mb-3">
                                        <label class="col-sm-2 col-form-label"> @lang('settings.message') </label>
                                        <div class="col-sm-9">
                                            <div class="form-group mb-2">
                                                <br>
                                                <button type="button" class="btn btn-primary" onclick="$('#email_newOrder_msg').val($('#email_newOrder_msg').val() +'[[name]]') ;return false;" value=""> @lang('settings.attach_name') </button>
                                                <button type="button" class="btn btn-primary" onclick="$('#email_newOrder_msg').val($('#email_newOrder_msg').val() +'[[identifier]]') ;return false;" value=""> @lang('settings.attach_identifier') </button>
                                                <button type="button" class="btn btn-primary" onclick="$('#email_newOrder_msg').val($('#email_newOrder_msg').val() +'[[total]]') ;return false;" value=""> @lang('settings.attach_amount') </button>
                                                <button type="button" class="btn btn-primary" onclick="$('#email_newOrder_msg').val($('#email_newOrder_msg').val() +'[[project]]') ;return false;" value=""> @lang('settings.attach_project_name') </button>
                                                <small class="red "> @lang('settings.replace_message')</small>
                                            </div>
                                            <textarea class="form-control" name="email_newOrder_msg" rows="6" id="email_newOrder_msg"> {{ @$settings['email_newOrder_msg'] }} </textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            {{-- sms ----------------------------------------------------------------------- --}}
                            <div class="row bg-light rounded p-3 m-3">
                                <h4 class="text-primary"> @lang('settings.sms') </h4>
                                {{-- receive  status --}}
                                <div class="col-12 mt-3">
                                    <div class="row mb-3">
                                        <label class="col-sm-2 col-form-label"> @lang('settings.status') </label>
                                        <div class="col-sm-5">
                                            <div class="form-check form-switch form-check-success mt-1">
                                                <input type="hidden" name="sms_newOrder_enabled" value="0">
                                                <input class="form-check-input" type="checkbox" name="sms_newOrder_enabled" {{ @$settings['sms_newOrder_enabled'] == 1 ? 'checked' : '' }} id="sms_newOrder_enabled">
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
                                                <button type="button" class="btn btn-primary" onclick="$('#sms_newOrder_msg').val($('#sms_newOrder_msg').val() +'[[name]]') ;return false;" value=""> @lang('settings.attach_name') </button>
                                                <button type="button" class="btn btn-primary" onclick="$('#sms_newOrder_msg').val($('#sms_newOrder_msg').val() +'[[identifier]]') ;return false;" value=""> @lang('settings.attach_identifier') </button>
                                                <button type="button" class="btn btn-primary" onclick="$('#sms_newOrder_msg').val($('#sms_newOrder_msg').val() +'[[total]]') ;return false;" value=""> @lang('settings.attach_amount') </button>
                                                <button type="button" class="btn btn-primary" onclick="$('#sms_newOrder_msg').val($('#sms_newOrder_msg').val() +'[[project]]') ;return false;" value=""> @lang('settings.attach_project_name') </button>
                                                <small class="red "> @lang('settings.replace_message')</small>
                                            </div>
                                            <textarea class="form-control" name="sms_newOrder_msg" rows="6" id="sms_newOrder_msg"> {{ @$settings['sms_newOrder_msg'] }} </textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- new Request ------------------------------------------------------------------------------------- --}}
            <div class="accordion mt-4 mb-4" id="accordionNewRequest">
                <div class="accordion-item border rounded">
                    <h2 class="accordion-header" id="headingNewRequest">
                        <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseNewRequest" aria-expanded="true" aria-controls="collapseNewRequest">
                            @lang('settings.notify_new_request') 
                        </button>
                    </h2>
                    <div id="collapseNewRequest" class="accordion-collapse collapse  mt-3" aria-labelledby="headingNewRequest" data-bs-parent="#accordionNewRequest">
                        <div class="accordion-body collapsed">
                            {{-- email ----------------------------------------------------------------------- --}}
                            <div class="row bg-light rounded p-3 m-3">
                                <h4 class="text-primary"> @lang('settings.email')</h4>
                                {{-- new Request status --}}
                                <div class="col-12 mt-3">
                                    <div class="row mb-3">
                                        <label class="col-sm-2 col-form-label"> @lang('settings.status') </label>
                                        <div class="col-sm-5">
                                            <div class="form-check form-switch form-check-success mt-1">
                                                <input type="hidden" name="email_newRequest_enabled" value="0">
                                                <input class="form-check-input" type="checkbox" name="email_newRequest_enabled" {{ @$settings['email_newRequest_enabled'] == 1 ? 'checked' : '' }} id="email_newRequest_enabled">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- new Request subject --}}
                                <div class="col-12">
                                    <div class="row mb-3">
                                        <label class="col-sm-2 col-form-label"> @lang('settings.subject') </label>
                                        <div class="col-sm-9">
                                            <input class="form-control" type="text" name="email_newRequest_subject" value="{{ @$settings['email_newRequest_subject'] }}">
                                        </div>
                                    </div>
                                </div>
                                {{-- new Request message  --}}
                                <div class="col-12">
                                    <div class="row mb-3">
                                        <label class="col-sm-2 col-form-label"> @lang('settings.message') </label>
                                        <div class="col-sm-9">
                                            <div class="form-group mb-2">
                                                <br>
                                                <button type="button" class="btn btn-primary" onclick="$('#email_newRequest_msg').val($('#email_newRequest_msg').val() +'[[name]]') ;return false;" value=""> @lang('settings.attach_name') </button>
                                                <button type="button" class="btn btn-primary" onclick="$('#email_newRequest_msg').val($('#email_newRequest_msg').val() +'[[identifier]]') ;return false;" value=""> @lang('settings.attach_identifier') </button>
                                                <button type="button" class="btn btn-primary" onclick="$('#email_newRequest_msg').val($('#email_newRequest_msg').val() +'[[total]]') ;return false;" value=""> @lang('settings.attach_amount') </button>
                                                <button type="button" class="btn btn-primary" onclick="$('#email_newRequest_msg').val($('#email_newRequest_msg').val() +'[[project]]') ;return false;" value=""> @lang('settings.attach_project_name') </button>
                                                <small class="red "> @lang('settings.replace_message')</small>
                                            </div>
                                            <textarea class="form-control" name="email_newRequest_msg" rows="6" id="email_newRequest_msg"> {{ @$settings['email_newRequest_msg'] }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>

                            {{-- sms ----------------------------------------------------------------------- --}}
                            <div class="row bg-light rounded p-3 m-3">
                                <h4 class="text-primary"> @lang('settings.sms') </h4>
                                {{-- receive  status --}}
                                <div class="col-12 mt-3">
                                    <div class="row mb-3">
                                        <label class="col-sm-2 col-form-label"> @lang('settings.status') </label>
                                        <div class="col-sm-5">
                                            <div class="form-check form-switch form-check-success mt-1">
                                                <input type="hidden" name="sms_newRequest_enabled" value="0">
                                                <input class="form-check-input" type="checkbox" name="sms_newRequest_enabled" {{ @$settings['sms_newRequest_enabled'] == 1 ? 'checked' : '' }} id="sms_newRequest_enabled">
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
                                                <button type="button" class="btn btn-primary" onclick="$('#sms_newRequest_msg').val($('#sms_newRequest_msg').val() +'[[name]]') ;return false;" value=""> @lang('settings.attach_name') </button>
                                                <button type="button" class="btn btn-primary" onclick="$('#sms_newRequest_msg').val($('#sms_newRequest_msg').val() +'[[identifier]]') ;return false;" value=""> @lang('settings.attach_identifier') </button>
                                                <button type="button" class="btn btn-primary" onclick="$('#sms_newRequest_msg').val($('#sms_newRequest_msg').val() +'[[total]]') ;return false;" value=""> @lang('settings.attach_amount') </button>
                                                <button type="button" class="btn btn-primary" onclick="$('#sms_newRequest_msg').val($('#sms_newRequest_msg').val() +'[[project]]') ;return false;" value=""> @lang('settings.attach_project_name') </button>
                                                <small class="red "> @lang('settings.replace_message')</small>
                                            </div>
                                            <textarea class="form-control" name="sms_newRequest_msg" rows="6" id="sms_newRequest_msg"> {{ @$settings['sms_newRequest_msg'] }} </textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Select Request ------------------------------------------------------------------------------------- --}}
            <div class="accordion mt-4 mb-4" id="accordionSelectRequest">
                <div class="accordion-item border rounded">
                    <h2 class="accordion-header" id="headingSelectRequest">
                        <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSelectRequest" aria-expanded="true" aria-controls="collapseSelectRequest">
                            @lang('settings.notify_select_request') 
                        </button>
                    </h2>
                    <div id="collapseSelectRequest" class="accordion-collapse collapse  mt-3" aria-labelledby="headingSelectRequest" data-bs-parent="#accordionSelectRequest">
                        <div class="accordion-body collapsed">
                            {{-- email ----------------------------------------------------------------------- --}}
                            <div class="row bg-light rounded p-3 m-3">
                                <h4 class="text-primary"> @lang('settings.email')</h4>
                                {{-- Select Request status --}}
                                <div class="col-12 mt-3">
                                    <div class="row mb-3">
                                        <label class="col-sm-2 col-form-label"> @lang('settings.status') </label>
                                        <div class="col-sm-5">
                                            <div class="form-check form-switch form-check-success mt-1">
                                                <input type="hidden" name="email_selectRequest_enabled" value="0">
                                                <input class="form-check-input" type="checkbox" name="email_selectRequest_enabled" {{ @$settings['email_selectRequest_enabled'] == 1 ? 'checked' : '' }} id="email_selectRequest_enabled">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- Select Request subject --}}
                                <div class="col-12">
                                    <div class="row mb-3">
                                        <label class="col-sm-2 col-form-label"> @lang('settings.subject') </label>
                                        <div class="col-sm-9">
                                            <input class="form-control" type="text" name="email_selectRequest_subject" value="{{ @$settings['email_selectRequest_subject'] }}">
                                        </div>
                                    </div>
                                </div>
                                {{-- Select Request message  --}}
                                <div class="col-12">
                                    <div class="row mb-3">
                                        <label class="col-sm-2 col-form-label"> @lang('settings.message') </label>
                                        <div class="col-sm-9">
                                            <div class="form-group mb-2">
                                                <br>
                                                <button type="button" class="btn btn-primary" onclick="$('#email_SelectRequest_msg').val($('#email_SelectRequest_msg').val() +'[[name]]') ;return false;" value=""> @lang('settings.attach_name') </button>
                                                <button type="button" class="btn btn-primary" onclick="$('#email_SelectRequest_msg').val($('#email_SelectRequest_msg').val() +'[[identifier]]') ;return false;" value=""> @lang('settings.attach_identifier') </button>
                                                <button type="button" class="btn btn-primary" onclick="$('#email_SelectRequest_msg').val($('#email_SelectRequest_msg').val() +'[[total]]') ;return false;" value=""> @lang('settings.attach_amount') </button>
                                                <button type="button" class="btn btn-primary" onclick="$('#email_SelectRequest_msg').val($('#email_SelectRequest_msg').val() +'[[project]]') ;return false;" value=""> @lang('settings.attach_project_name') </button>
                                                <small class="red "> @lang('settings.replace_message')</small>
                                            </div>
                                            <textarea class="form-control" name="email_SelectRequest_msg" rows="6" id="email_SelectRequest_msg"> {{ @$settings['email_SelectRequest_msg'] }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>

                            {{-- sms ----------------------------------------------------------------------- --}}
                            <div class="row bg-light rounded p-3 m-3">
                                <h4 class="text-primary"> @lang('settings.sms') </h4>
                                {{-- receive  status --}}
                                <div class="col-12 mt-3">
                                    <div class="row mb-3">
                                        <label class="col-sm-2 col-form-label"> @lang('settings.status') </label>
                                        <div class="col-sm-5">
                                            <div class="form-check form-switch form-check-success mt-1">
                                                <input type="hidden" name="sms_selectRequest_enabled" value="0">
                                                <input class="form-check-input" type="checkbox" name="sms_selectRequest_enabled" {{ @$settings['sms_selectRequest_enabled'] == 1 ? 'checked' : '' }} id="sms_selectRequest_enabled">
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
                                                <button type="button" class="btn btn-primary" onclick="$('#sms_SelectRequest_msg').val($('#sms_SelectRequest_msg').val() +'[[name]]') ;return false;" value=""> @lang('settings.attach_name') </button>
                                                <button type="button" class="btn btn-primary" onclick="$('#sms_SelectRequest_msg').val($('#sms_SelectRequest_msg').val() +'[[identifier]]') ;return false;" value=""> @lang('settings.attach_identifier') </button>
                                                <button type="button" class="btn btn-primary" onclick="$('#sms_SelectRequest_msg').val($('#sms_SelectRequest_msg').val() +'[[total]]') ;return false;" value=""> @lang('settings.attach_amount') </button>
                                                <button type="button" class="btn btn-primary" onclick="$('#sms_SelectRequest_msg').val($('#sms_SelectRequest_msg').val() +'[[project]]') ;return false;" value=""> @lang('settings.attach_project_name') </button>
                                                <small class="red "> @lang('settings.replace_message')</small>
                                            </div>
                                            <textarea class="form-control" name="sms_SelectRequest_msg" rows="6" id="sms_SelectRequest_msg"> {{ @$settings['sms_SelectRequest_msg'] }} </textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- cancel Request ------------------------------------------------------------------------------------- --}}
            <div class="accordion mt-4 mb-4" id="accordionCancelRequest">
                <div class="accordion-item border rounded">
                    <h2 class="accordion-header" id="headingCancelRequest">
                        <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCancelRequest" aria-expanded="true" aria-controls="collapseCancelRequest">
                            @lang('settings.notify_cancel_request') 
                        </button>
                    </h2>
                    <div id="collapseCancelRequest" class="accordion-collapse collapse  mt-3" aria-labelledby="headingCancelRequest" data-bs-parent="#accordionCancelRequest">
                        <div class="accordion-body collapsed">
                            {{-- email ----------------------------------------------------------------------- --}}
                            <div class="row bg-light rounded p-3 m-3">
                                <h4 class="text-primary"> @lang('settings.email')</h4>
                                {{-- email status --}}
                                <div class="col-12 mt-3">
                                    <div class="row mb-3">
                                        <label class="col-sm-2 col-form-label"> @lang('settings.status') </label>
                                        <div class="col-sm-5">
                                            <div class="form-check form-switch form-check-success mt-1">
                                                <input type="hidden" name="email_cancelRequest_enabled" value="0">
                                                <input class="form-check-input" type="checkbox" name="email_cancelRequest_enabled" {{ @$settings['email_cancelRequest_enabled'] == 1 ? 'checked' : '' }} id="email_cancelRequest_enabled">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- email subject --}}
                                <div class="col-12">
                                    <div class="row mb-3">
                                        <label class="col-sm-2 col-form-label"> @lang('settings.subject') </label>
                                        <div class="col-sm-9">
                                            <input class="form-control" type="text" name="email_cancelRequest_subject" value="{{ @$settings['email_cancelRequest_subject'] }}">
                                        </div>
                                    </div>
                                </div>
                                {{-- email message  --}}
                                <div class="col-12">
                                    <div class="row mb-3">
                                        <label class="col-sm-2 col-form-label"> @lang('settings.message') </label>
                                        <div class="col-sm-9">
                                            <div class="form-group mb-2">
                                                <br>
                                                <button type="button" class="btn btn-primary" onclick="$('#email_cancelRequest_msg').val($('#email_cancelRequest_msg').val() +'[[name]]') ;return false;" value=""> @lang('settings.attach_name') </button>
                                                <button type="button" class="btn btn-primary" onclick="$('#email_cancelRequest_msg').val($('#email_cancelRequest_msg').val() +'[[identifier]]') ;return false;" value=""> @lang('settings.attach_identifier') </button>
                                                <button type="button" class="btn btn-primary" onclick="$('#email_cancelRequest_msg').val($('#email_cancelRequest_msg').val() +'[[total]]') ;return false;" value=""> @lang('settings.attach_amount') </button>
                                                <button type="button" class="btn btn-primary" onclick="$('#email_cancelRequest_msg').val($('#email_cancelRequest_msg').val() +'[[project]]') ;return false;" value=""> @lang('settings.attach_project_name') </button>
                                                <small class="red "> @lang('settings.replace_message')</small>
                                            </div>
                                            <textarea class="form-control" name="email_cancelRequest_msg" rows="6" id="email_cancelRequest_msg"> {{ @$settings['email_cancelRequest_msg'] }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>

                            {{-- sms ----------------------------------------------------------------------- --}}
                            <div class="row bg-light rounded p-3 m-3">
                                <h4 class="text-primary"> @lang('settings.sms') </h4>
                                {{-- sms  status --}}
                                <div class="col-12 mt-3">
                                    <div class="row mb-3">
                                        <label class="col-sm-2 col-form-label"> @lang('settings.status') </label>
                                        <div class="col-sm-5">
                                            <div class="form-check form-switch form-check-success mt-1">
                                                <input type="hidden" name="sms_cancelRequest" value="0">
                                                <input class="form-check-input" type="checkbox" name="sms_cancelRequest" {{ @$settings['sms_cancelRequest'] == 1 ? 'checked' : '' }} id="sms_cancelRequest">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- sms message  --}}
                                <div class="col-12">
                                    <div class="row mb-3">
                                        <label class="col-sm-2 col-form-label"> @lang('settings.message') </label>
                                        <div class="col-sm-9">
                                            <div class="form-group mb-2">
                                                <br>
                                                <button type="button" class="btn btn-primary" onclick="$('#sms_cancelRequest_msg').val($('#sms_cancelRequest_msg').val() +'[[name]]') ;return false;" value=""> @lang('settings.attach_name') </button>
                                                <button type="button" class="btn btn-primary" onclick="$('#sms_cancelRequest_msg').val($('#sms_cancelRequest_msg').val() +'[[identifier]]') ;return false;" value=""> @lang('settings.attach_identifier') </button>
                                                <button type="button" class="btn btn-primary" onclick="$('#sms_cancelRequest_msg').val($('#sms_cancelRequest_msg').val() +'[[total]]') ;return false;" value=""> @lang('settings.attach_amount') </button>
                                                <button type="button" class="btn btn-primary" onclick="$('#sms_cancelRequest_msg').val($('#sms_cancelRequest_msg').val() +'[[project]]') ;return false;" value=""> @lang('settings.attach_project_name') </button>
                                                <small class="red "> @lang('settings.replace_message')</small>
                                            </div>
                                            <textarea class="form-control" name="sms_cancelRequest_msg" rows="6" id="sms_cancelRequest_msg"> {{ @$settings['sms_cancelRequest_msg'] }} </textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Start Order ------------------------------------------------------------------------------------- --}}
            <div class="accordion mt-4 mb-4" id="accordionStartOrder">
                <div class="accordion-item border rounded">
                    <h2 class="accordion-header" id="headingStartOrder">
                        <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseStartOrder" aria-expanded="true" aria-controls="collapseStartOrder">
                            @lang('settings.notify_start_order') 
                        </button>
                    </h2>
                    <div id="collapseStartOrder" class="accordion-collapse collapse  mt-3" aria-labelledby="headingStartOrder" data-bs-parent="#accordionStartOrder">
                        <div class="accordion-body collapsed">
                            {{-- email ----------------------------------------------------------------------- --}}
                            <div class="row bg-light rounded p-3 m-3">
                                <h4 class="text-primary"> @lang('settings.email') رسالة بداء طلب ( ترسل للمتبرع ) </h4>
                                {{-- Start Order status --}}
                                <div class="col-12 mt-3">
                                    <div class="row mb-3">
                                        <label class="col-sm-2 col-form-label"> @lang('settings.status') </label>
                                        <div class="col-sm-5">
                                            <div class="form-check form-switch form-check-success mt-1">
                                                <input type="hidden" name="email_start_order_enabled" value="0">
                                                <input class="form-check-input" type="checkbox" name="email_start_order_enabled" {{ @$settings['email_start_order_enabled'] == 1 ? 'checked' : '' }} id="email_start_order_enabled">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- Start Order subject --}}
                                <div class="col-12">
                                    <div class="row mb-3">
                                        <label class="col-sm-2 col-form-label"> @lang('settings.subject') </label>
                                        <div class="col-sm-9">
                                            <input class="form-control" type="text" name="email_start_order_subject" value="{{ @$settings['email_start_order_subject'] }}">
                                        </div>
                                    </div>
                                </div>
                                {{-- Start Order message  --}}
                                <div class="col-12">
                                    <div class="row mb-3">
                                        <label class="col-sm-2 col-form-label"> @lang('settings.message') </label>
                                        <div class="col-sm-9">
                                            <div class="form-group mb-2">
                                                <br>
                                                <button type="button" class="btn btn-primary" onclick="$('#email_start_order_msg').val($('#email_start_order_msg').val() +'[[name]]') ;return false;" value=""> @lang('settings.attach_name') </button>
                                                <button type="button" class="btn btn-primary" onclick="$('#email_start_order_msg').val($('#email_start_order_msg').val() +'[[identifier]]') ;return false;" value=""> @lang('settings.attach_identifier') </button>
                                                <button type="button" class="btn btn-primary" onclick="$('#email_start_order_msg').val($('#email_start_order_msg').val() +'[[total]]') ;return false;" value=""> @lang('settings.attach_amount') </button>
                                                <button type="button" class="btn btn-primary" onclick="$('#email_start_order_msg').val($('#email_start_order_msg').val() +'[[project]]') ;return false;" value=""> @lang('settings.attach_project_name') </button>
                                                <small class="red "> @lang('settings.replace_message')</small>
                                            </div>
                                            <textarea class="form-control" name="email_start_order_msg" rows="6" id="email_start_order_msg"> {{ @$settings['email_start_order_msg'] }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>

                            {{-- sms ----------------------------------------------------------------------- --}}
                            <div class="row bg-light rounded p-3 m-3">
                                <h4 class="text-primary"> @lang('settings.sms') </h4>
                                {{-- receive  status --}}
                                <div class="col-12 mt-3">
                                    <div class="row mb-3">
                                        <label class="col-sm-2 col-form-label"> @lang('settings.status') </label>
                                        <div class="col-sm-5">
                                            <div class="form-check form-switch form-check-success mt-1">
                                                <input type="hidden" name="sms_start_order_enabled" value="0">
                                                <input class="form-check-input" type="checkbox" name="sms_start_order_enabled" {{ @$settings['sms_start_order_enabled'] == 1 ? 'checked' : '' }} id="sms_start_order_enabled">
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
                                                <button type="button" class="btn btn-primary" onclick="$('#sms_start_order_msg').val($('#sms_start_order_msg').val() +'[[name]]') ;return false;" value=""> @lang('settings.attach_name') </button>
                                                <button type="button" class="btn btn-primary" onclick="$('#sms_start_order_msg').val($('#sms_start_order_msg').val() +'[[identifier]]') ;return false;" value=""> @lang('settings.attach_identifier') </button>
                                                <button type="button" class="btn btn-primary" onclick="$('#sms_start_order_msg').val($('#sms_start_order_msg').val() +'[[total]]') ;return false;" value=""> @lang('settings.attach_amount') </button>
                                                <button type="button" class="btn btn-primary" onclick="$('#sms_start_order_msg').val($('#sms_start_order_msg').val() +'[[project]]') ;return false;" value=""> @lang('settings.attach_project_name') </button>
                                                <small class="red "> @lang('settings.replace_message')</small>
                                            </div>
                                            <textarea class="form-control" name="sms_start_order_msg" rows="6" id="sms_start_order_msg"> {{ @$settings['sms_start_order_msg'] }} </textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- complete order ------------------------------------------------------------------------------------- --}}
            <div class="accordion mt-4 mb-4" id="accordionCompleteOrder">
                <div class="accordion-item border rounded">
                    <h2 class="accordion-header" id="headingCompleteOrder">
                        <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCompleteOrder" aria-expanded="true" aria-controls="collapseCompleteOrder">
                            @lang('settings.notify_complete_order') 
                        </button>
                    </h2>
                    <div id="collapseCompleteOrder" class="accordion-collapse collapse  mt-3" aria-labelledby="headingCompleteOrder" data-bs-parent="#accordionCompleteOrder">
                        <div class="accordion-body collapsed">
                            {{-- email ----------------------------------------------------------------------- --}}
                            <div class="row bg-light rounded p-3 m-3">
                                <h4 class="text-primary"> @lang('settings.email') </h4>
                                {{-- complete order (rites) status --}}
                                <div class="col-12 mt-3">
                                    <div class="row mb-3">
                                        <label class="col-sm-2 col-form-label"> @lang('settings.status') </label>
                                        <div class="col-sm-5">
                                            <div class="form-check form-switch form-check-success mt-1">
                                                <input type="hidden" name="email_complete_order_enabled" value="0">
                                                <input class="form-check-input" type="checkbox" name="email_complete_order_enabled" {{ @$settings['email_complete_order_enabled'] == 1 ? 'checked' : '' }} id="email_complete_order_enabled">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- complete order (rites) subject --}}
                                <div class="col-12">
                                    <div class="row mb-3">
                                        <label class="col-sm-2 col-form-label"> @lang('settings.subject') </label>
                                        <div class="col-sm-9">
                                            <input class="form-control" type="text" name="email_complete_order_subject" value="{{ @$settings['email_complete_order_subject'] }}">
                                        </div>
                                    </div>
                                </div>
                                {{-- complete order (rites) message  --}}
                                <div class="col-12">
                                    <div class="row mb-3">
                                        <label class="col-sm-2 col-form-label"> @lang('settings.message') </label>
                                        <div class="col-sm-9">
                                            <div class="form-group mb-2">
                                                <br>
                                                <button type="button" class="btn btn-primary" onclick="$('#email_complete_order_msg').val($('#email_complete_order_msg').val() +'[[name]]') ;return false;" value=""> @lang('settings.attach_name') </button>
                                                <button type="button" class="btn btn-primary" onclick="$('#email_complete_order_msg').val($('#email_complete_order_msg').val() +'[[identifier]]') ;return false;" value=""> @lang('settings.attach_identifier') </button>
                                                <button type="button" class="btn btn-primary" onclick="$('#email_complete_order_msg').val($('#email_complete_order_msg').val() +'[[total]]') ;return false;" value=""> @lang('settings.attach_amount') </button>
                                                <button type="button" class="btn btn-primary" onclick="$('#email_complete_order_msg').val($('#email_complete_order_msg').val() +'[[project]]') ;return false;" value=""> @lang('settings.attach_project_name') </button>
                                                <small class="red "> @lang('settings.replace_message')</small>
                                            </div>
                                            <textarea class="form-control" name="email_complete_order_msg" rows="6" id="email_complete_order_msg"> {{ @$settings['email_complete_order_msg'] }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>

                            {{-- sms ----------------------------------------------------------------------- --}}
                            <div class="row bg-light rounded p-3 m-3">
                                <h4 class="text-primary"> @lang('settings.sms') </h4>
                                {{-- complete order  status --}}
                                <div class="col-12 mt-3">
                                    <div class="row mb-3">
                                        <label class="col-sm-2 col-form-label"> @lang('settings.status') </label>
                                        <div class="col-sm-5">
                                            <div class="form-check form-switch form-check-success mt-1">
                                                <input type="hidden" name="sms_complete_order_enabled" value="0">
                                                <input class="form-check-input" type="checkbox" name="sms_complete_order_enabled" {{ @$settings['sms_complete_order_enabled'] == 1 ? 'checked' : '' }} id="sms_start_order_enabled">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- complete order message  --}}
                                <div class="col-12">
                                    <div class="row mb-3">
                                        <label class="col-sm-2 col-form-label"> @lang('settings.message') </label>
                                        <div class="col-sm-9">
                                            <div class="form-group mb-2">
                                                <br>
                                                <button type="button" class="btn btn-primary" onclick="$('#sms_complete_order_msg').val($('#sms_complete_order_msg').val() +'[[name]]') ;return false;" value=""> @lang('settings.attach_name') </button>
                                                <button type="button" class="btn btn-primary" onclick="$('#sms_complete_order_msg').val($('#sms_complete_order_msg').val() +'[[identifier]]') ;return false;" value=""> @lang('settings.attach_identifier') </button>
                                                <button type="button" class="btn btn-primary" onclick="$('#sms_complete_order_msg').val($('#sms_complete_order_msg').val() +'[[total]]') ;return false;" value=""> @lang('settings.attach_amount') </button>
                                                <button type="button" class="btn btn-primary" onclick="$('#sms_complete_order_msg').val($('#sms_complete_order_msg').val() +'[[project]]') ;return false;" value=""> @lang('settings.attach_project_name') </button>
                                                <small class="red "> @lang('settings.replace_message')</small>
                                            </div>
                                            <textarea class="form-control" name="sms_complete_order_msg" rows="6" id="sms_complete_order_msg"> {{ @$settings['sms_complete_order_msg'] }} </textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- notify order today  ------------------------------------------------------------------------------------- --}}
            <div class="accordion mt-4 mb-4" id="accordionNotifyOrder">
                <div class="accordion-item border rounded">
                    <h2 class="accordion-header" id="headingNotifyOrder">
                        <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseNotifyOrder" aria-expanded="true" aria-controls="collapseNotifyOrder">
                            @lang('settings.notify_today_notify_order') 
                        </button>
                    </h2>
                    <div id="collapseNotifyOrder" class="accordion-collapse collapse  mt-3" aria-labelledby="headingNotifyOrder" data-bs-parent="#accordionNotifyOrder">
                        <div class="accordion-body collapsed">
                            {{-- email ----------------------------------------------------------------------- --}}
                            <div class="row bg-light rounded p-3 m-3">
                                <h4 class="text-primary"> @lang('settings.email')</h4>
                                {{-- email status --}}
                                <div class="col-12 mt-3">
                                    <div class="row mb-3">
                                        <label class="col-sm-2 col-form-label"> @lang('settings.status') </label>
                                        <div class="col-sm-5">
                                            <div class="form-check form-switch form-check-success mt-1">
                                                <input type="hidden" name="email_lateRequest_enabled" value="0">
                                                <input class="form-check-input" type="checkbox" name="email_notify_order_enabled" {{ @$settings['email_notify_order_enabled'] == 1 ? 'checked' : '' }} id="email_cancelRequest_enabled">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- email subject --}}
                                <div class="col-12">
                                    <div class="row mb-3">
                                        <label class="col-sm-2 col-form-label"> @lang('settings.subject') </label>
                                        <div class="col-sm-9">
                                            <input class="form-control" type="text" name="email_notify_order_subject" value="{{ @$settings['email_notify_order_subject'] }}">
                                        </div>
                                    </div>
                                </div>
                                {{-- email message  --}}
                                <div class="col-12">
                                    <div class="row mb-3">
                                        <label class="col-sm-2 col-form-label"> @lang('settings.message') </label>
                                        <div class="col-sm-9">
                                            <div class="form-group mb-2">
                                                <br>
                                                <button type="button" class="btn btn-primary" onclick="$('#email_notify_order_msg').val($('#email_notify_order_msg').val() +'[[name]]') ;return false;" value=""> @lang('settings.attach_name') </button>
                                                <button type="button" class="btn btn-primary" onclick="$('#email_notify_order_msg').val($('#email_notify_order_msg').val() +'[[identifier]]') ;return false;" value=""> @lang('settings.attach_identifier') </button>
                                                <button type="button" class="btn btn-primary" onclick="$('#email_notify_order_msg').val($('#email_notify_order_msg').val() +'[[total]]') ;return false;" value=""> @lang('settings.attach_amount') </button>
                                                <button type="button" class="btn btn-primary" onclick="$('#email_notify_order_msg').val($('#email_notify_order_msg').val() +'[[project]]') ;return false;" value=""> @lang('settings.attach_project_name') </button>
                                                <small class="red "> @lang('settings.replace_message')</small>
                                            </div>
                                            <textarea class="form-control" name="email_notify_order_msg" rows="6" id="email_notify_order_msg"> {{ @$settings['email_notify_order_msg'] }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>

                            {{-- sms ----------------------------------------------------------------------- --}}
                            <div class="row bg-light rounded p-3 m-3">
                                <h4 class="text-primary"> @lang('settings.sms') </h4>
                                {{-- sms  status --}}
                                <div class="col-12 mt-3">
                                    <div class="row mb-3">
                                        <label class="col-sm-2 col-form-label"> @lang('settings.status') </label>
                                        <div class="col-sm-5">
                                            <div class="form-check form-switch form-check-success mt-1">
                                                <input type="hidden" name="sms_notify_order" value="0">
                                                <input class="form-check-input" type="checkbox" name="sms_notify_order" {{ @$settings['sms_notify_order'] == 1 ? 'checked' : '' }} id="sms_notify_order">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- sms message  --}}
                                <div class="col-12">
                                    <div class="row mb-3">
                                        <label class="col-sm-2 col-form-label"> @lang('settings.message') </label>
                                        <div class="col-sm-9">
                                            <div class="form-group mb-2">
                                                <br>
                                                <button type="button" class="btn btn-primary" onclick="$('#sms_notify_order_msg').val($('#sms_notify_order_msg').val() +'[[name]]') ;return false;" value=""> @lang('settings.attach_name') </button>
                                                <button type="button" class="btn btn-primary" onclick="$('#sms_notify_order_msg').val($('#sms_notify_order_msg').val() +'[[identifier]]') ;return false;" value=""> @lang('settings.attach_identifier') </button>
                                                <button type="button" class="btn btn-primary" onclick="$('#sms_notify_order_msg').val($('#sms_notify_order_msg').val() +'[[total]]') ;return false;" value=""> @lang('settings.attach_amount') </button>
                                                <button type="button" class="btn btn-primary" onclick="$('#sms_notify_order_msg').val($('#sms_notify_order_msg').val() +'[[project]]') ;return false;" value=""> @lang('settings.attach_project_name') </button>
                                                <small class="red "> @lang('settings.replace_message')</small>
                                            </div>
                                            <textarea class="form-control" name="sms_notify_order_msg" rows="6" id="sms_notify_order_msg"> {{ @$settings['sms_notify_order_msg'] }} </textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- late order request   ------------------------------------------------------------------------------------- --}}
            <div class="accordion mt-4 mb-4" id="accordionLateOrder">
                <div class="accordion-item border rounded">
                    <h2 class="accordion-header" id="headingLateOrder">
                        <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseLateOrder" aria-expanded="true" aria-controls="collapseLateOrder">
                            @lang('settings.notify_cancel_late_order') 
                        </button>
                    </h2>
                    <div id="collapseLateOrder" class="accordion-collapse collapse  mt-3" aria-labelledby="headingLateOrder" data-bs-parent="#accordionLateOrder">
                        <div class="accordion-body collapsed">
                            {{-- email ----------------------------------------------------------------------- --}}
                            <div class="row bg-light rounded p-3 m-3">
                                <h4 class="text-primary"> @lang('settings.email')</h4>
                                {{-- email status --}}
                                <div class="col-12 mt-3">
                                    <div class="row mb-3">
                                        <label class="col-sm-2 col-form-label"> @lang('settings.status') </label>
                                        <div class="col-sm-5">
                                            <div class="form-check form-switch form-check-success mt-1">
                                                <input type="hidden" name="email_lateRequest_enabled" value="0">
                                                <input class="form-check-input" type="checkbox" name="email_lateRequest_enabled" {{ @$settings['email_lateRequest_enabled'] == 1 ? 'checked' : '' }} id="email_cancelRequest_enabled">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- email subject --}}
                                <div class="col-12">
                                    <div class="row mb-3">
                                        <label class="col-sm-2 col-form-label"> @lang('settings.subject') </label>
                                        <div class="col-sm-9">
                                            <input class="form-control" type="text" name="email_lateRequest_subject" value="{{ @$settings['email_lateRequest_subject'] }}">
                                        </div>
                                    </div>
                                </div>
                                {{-- email message  --}}
                                <div class="col-12">
                                    <div class="row mb-3">
                                        <label class="col-sm-2 col-form-label"> @lang('settings.message') </label>
                                        <div class="col-sm-9">
                                            <div class="form-group mb-2">
                                                <br>
                                                <button type="button" class="btn btn-primary" onclick="$('#email_lateRequest_msg').val($('#email_lateRequest_msg').val() +'[[name]]') ;return false;" value=""> @lang('settings.attach_name') </button>
                                                <button type="button" class="btn btn-primary" onclick="$('#email_lateRequest_msg').val($('#email_lateRequest_msg').val() +'[[identifier]]') ;return false;" value=""> @lang('settings.attach_identifier') </button>
                                                <button type="button" class="btn btn-primary" onclick="$('#email_lateRequest_msg').val($('#email_lateRequest_msg').val() +'[[total]]') ;return false;" value=""> @lang('settings.attach_amount') </button>
                                                <button type="button" class="btn btn-primary" onclick="$('#email_lateRequest_msg').val($('#email_lateRequest_msg').val() +'[[project]]') ;return false;" value=""> @lang('settings.attach_project_name') </button>
                                                <small class="red "> @lang('settings.replace_message')</small>
                                            </div>
                                            <textarea class="form-control" name="email_lateRequest_msg" rows="6" id="email_lateRequest_msg"> {{ @$settings['email_lateRequest_msg'] }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>

                            {{-- sms ----------------------------------------------------------------------- --}}
                            <div class="row bg-light rounded p-3 m-3">
                                <h4 class="text-primary"> @lang('settings.sms') </h4>
                                {{-- sms  status --}}
                                <div class="col-12 mt-3">
                                    <div class="row mb-3">
                                        <label class="col-sm-2 col-form-label"> @lang('settings.status') </label>
                                        <div class="col-sm-5">
                                            <div class="form-check form-switch form-check-success mt-1">
                                                <input type="hidden" name="sms_lateRequest_enable" value="0">
                                                <input class="form-check-input" type="checkbox" name="sms_lateRequest_enable" {{ @$settings['sms_lateRequest_enable'] == 1 ? 'checked' : '' }} id="sms_lateRequest_enable">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- sms message  --}}
                                <div class="col-12">
                                    <div class="row mb-3">
                                        <label class="col-sm-2 col-form-label"> @lang('settings.message') </label>
                                        <div class="col-sm-9">
                                            <div class="form-group mb-2">
                                                <br>
                                                <button type="button" class="btn btn-primary" onclick="$('#sms_lateRequest_msg').val($('#sms_lateRequest_msg').val() +'[[name]]') ;return false;" value=""> @lang('settings.attach_name') </button>
                                                <button type="button" class="btn btn-primary" onclick="$('#sms_lateRequest_msg').val($('#sms_lateRequest_msg').val() +'[[identifier]]') ;return false;" value=""> @lang('settings.attach_identifier') </button>
                                                <button type="button" class="btn btn-primary" onclick="$('#sms_lateRequest_msg').val($('#sms_lateRequest_msg').val() +'[[total]]') ;return false;" value=""> @lang('settings.attach_amount') </button>
                                                <button type="button" class="btn btn-primary" onclick="$('#sms_lateRequest_msg').val($('#sms_lateRequest_msg').val() +'[[project]]') ;return false;" value=""> @lang('settings.attach_project_name') </button>
                                                <small class="red "> @lang('settings.replace_message')</small>
                                            </div>
                                            <textarea class="form-control" name="sms_lateRequest_msg" rows="6" id="sms_lateRequest_msg"> {{ @$settings['sms_lateRequest_msg'] }} </textarea>
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

                                {{-- arrive_order  --}}
                                <div class="col-12 col-md-5 bg-light rounded p-3 m-3">
                                    <h4 class="text-primary"> @lang('settings.notify_new_order')</h4>
                                    <div class="row mb-3">
                                        <label class="col-sm-4 col-form-label"> @lang('settings.status') </label>
                                        <div class="col-sm-5">
                                            <div class="form-check form-switch form-check-success mt-1">
                                                <input type="hidden" name="whatsapp_arrive_order_status" value="0">
                                                <input class="form-check-input" type="checkbox" name="whatsapp_arrive_order_status" {{ @$settings['whatsapp_arrive_order_status'] == 1 ? 'checked' : '' }} id="whatsapp_arrive_order_status">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="row mb-3">
                                            <label class="col-sm-2 col-form-label"> @lang('settings.template_name') </label>
                                            <div class="col-sm-9">
                                                <input class="form-control" type="text" name="whatsapp_arrive_order_template" value="{{ @$settings['whatsapp_arrive_order_template'] }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- new request   --}}
                                <div class="col-12 col-md-5 bg-light rounded p-3 m-3">
                                    <h4 class="text-primary"> @lang('settings.notify_new_request') </h4>
                                    <div class="row mb-3">
                                        <label class="col-sm-2 col-form-label"> @lang('settings.status') </label>
                                        <div class="col-sm-5">
                                            <div class="form-check form-switch form-check-success mt-1">
                                                <input type="hidden" name="sms_new_request_status" value="0">
                                                <input class="form-check-input" type="checkbox" name="whatsapp_new_request_status" {{ @$settings['whatsapp_new_request_status'] == 1 ? 'checked' : '' }} id="whatsapp_new_request_status">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="row mb-3">
                                            <label class="col-sm-2 col-form-label"> @lang('settings.template_name') </label>
                                            <div class="col-sm-9">
                                                <input class="form-control" type="text" name="whatsapp_new_request_template" value="{{ @$settings['whatsapp_new_request_template'] }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- select request   --}}
                                <div class="col-12 col-md-5 bg-light rounded p-3 m-3">
                                    <h4 class="text-primary"> @lang('settings.notify_select_request')  </h4>
                                    <div class="row mb-3">
                                        <label class="col-sm-2 col-form-label"> @lang('settings.status') </label>
                                        <div class="col-sm-5">
                                            <div class="form-check form-switch form-check-success mt-1">
                                                <input type="hidden" name="sms_select_request_status" value="0">
                                                <input class="form-check-input" type="checkbox" name="whatsapp_select_request_status" {{ @$settings['whatsapp_select_request_status'] == 1 ? 'checked' : '' }} id="whatsapp_select_request_status">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="row mb-3">
                                            <label class="col-sm-2 col-form-label"> @lang('settings.template_name') </label>
                                            <div class="col-sm-9">
                                                <input class="form-control" type="text" name="whatsapp_select_request_template" value="{{ @$settings['whatsapp_select_request_template'] }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- cancel request  --}}
                                <div class="col-12 col-md-5 bg-light rounded p-3 m-3">
                                    <h4 class="text-primary"> @lang('settings.notify_cancel_request') </h4>
                                    <div class="row mb-3">
                                        <label class="col-sm-2 col-form-label"> @lang('settings.status') </label>
                                        <div class="col-sm-5">
                                            <div class="form-check form-switch form-check-success mt-1">
                                                <input type="hidden" name="sms_cancel_request_status" value="0">
                                                <input class="form-check-input" type="checkbox" name="whatsapp_cancel_request_status" {{ @$settings['whatsapp_cancel_request_status'] == 1 ? 'checked' : '' }} id="whatsapp_cancel_request_status">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="row mb-3">
                                            <label class="col-sm-2 col-form-label"> @lang('settings.template_name') </label>
                                            <div class="col-sm-9">
                                                <input class="form-control" type="text" name="whatsapp_cancel_request_template" value="{{ @$settings['whatsapp_cancel_request_template'] }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- start order  --}}
                                <div class="col-12 col-md-5 bg-light rounded p-3 m-3">
                                    <h4 class="text-primary"> @lang('settings.notify_start_order')  </h4>
                                    <div class="row mb-3">
                                        <label class="col-sm-2 col-form-label"> @lang('settings.status') </label>
                                        <div class="col-sm-5">
                                            <div class="form-check form-switch form-check-success mt-1">
                                                <input type="hidden" name="sms_start_order_status" value="0">
                                                <input class="form-check-input" type="checkbox" name="whatsapp_start_order_status" {{ @$settings['whatsapp_start_order_status'] == 1 ? 'checked' : '' }} id="whatsapp_start_order_status">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="row mb-3">
                                            <label class="col-sm-2 col-form-label"> @lang('settings.template_name') </label>
                                            <div class="col-sm-9">
                                                <input class="form-control" type="text" name="whatsapp_start_order_template" value="{{ @$settings['whatsapp_start_order_template'] }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- complete order  --}}
                                <div class="col-12 col-md-5 bg-light rounded p-3 m-3">
                                    <h4 class="text-primary"> @lang('settings.notify_complete_order')  </h4>
                                    <div class="row mb-3">
                                        <label class="col-sm-2 col-form-label"> @lang('settings.status')</label>
                                        <div class="col-sm-5">
                                            <div class="form-check form-switch form-check-success mt-1">
                                                <input type="hidden" name="sms_complete_order_status" value="0">
                                                <input class="form-check-input" type="checkbox" name="whatsapp_complete_order_status" {{ @$settings['whatsapp_complete_order_status'] == 1 ? 'checked' : '' }} id="whatsapp_complete_order_status">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="row mb-3">
                                            <label class="col-sm-2 col-form-label"> @lang('settings.template_name') </label>
                                            <div class="col-sm-9">
                                                <input class="form-control" type="text" name="whatsapp_complete_order_template" value="{{ @$settings['whatsapp_complete_order_template'] }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- notify order   --}}
                                <div class="col-12 col-md-5 bg-light rounded p-3 m-3">
                                    <h4 class="text-primary"> @lang('settings.notify_today_notify_order')  </h4>
                                    <div class="row mb-3">
                                        <label class="col-sm-2 col-form-label"> @lang('settings.status') </label>
                                        <div class="col-sm-5">
                                            <div class="form-check form-switch form-check-success mt-1">
                                                <input type="hidden" name="sms_notify_order_status" value="0">
                                                <input class="form-check-input" type="checkbox" name="whatsapp_notify_order_status" {{ @$settings['whatsapp_notify_order_status'] == 1 ? 'checked' : '' }} id="whatsapp_notify_order_status">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="row mb-3">
                                            <label class="col-sm-2 col-form-label"> @lang('settings.template_name') </label>
                                            <div class="col-sm-9">
                                                <input class="form-control" type="text" name="whatsapp_notify_order_template" value="{{ @$settings['whatsapp_notify_order_template'] }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- late request  --}}
                                <div class="col-12 col-md-5 bg-light rounded p-3 m-3">
                                    <h4 class="text-primary"> @lang('settings.notify_cancel_late_order') </h4>
                                    <div class="row mb-3">
                                        <label class="col-sm-2 col-form-label"> @lang('settings.status') </label>
                                        <div class="col-sm-5">
                                            <div class="form-check form-switch form-check-success mt-1">
                                                <input type="hidden" name="sms_late_request_status" value="0">
                                                <input class="form-check-input" type="checkbox" name="whatsapp_late_request_status" {{ @$settings['whatsapp_late_request_status'] == 1 ? 'checked' : '' }} id="whatsapp_late_request_status">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="row mb-3">
                                            <label class="col-sm-2 col-form-label"> @lang('settings.template_name') </label>
                                            <div class="col-sm-9">
                                                <input class="form-control" type="text" name="whatsapp_late_request_template" value="{{ @$settings['whatsapp_late_request_template'] }}">
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
