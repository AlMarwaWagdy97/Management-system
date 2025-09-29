@extends('admin.app')

@section('title', trans('settings.edit', ['name' =>  $settingMain->title]) )
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

                {{-- Email Setting  --}}
                <div class="accordion mt-4 mb-4" id="accordionEmail">
                    <div class="accordion-item border rounded">
                        <h2 class="accordion-header" id="headingEmail">
                            <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseEmail" aria-expanded="true" aria-controls="collapseEmail">
                                @lang('settings.email')
                            </button>
                        </h2>
                        <div id="collapseEmail" class="accordion-collapse collapse show mt-3" aria-labelledby="headingEmail" data-bs-parent="#accordionEmail">
                            <div class="accordion-body">
                                <div class="row">
                                    {{-- Host  --}}
                                    <div class="col-12 col-md-6">
                                        <div class="row mb-3">
                                            <label class="col-sm-2 col-form-label"> @lang('settings.email_host') </label>
                                            <div class="col-sm-9">
                                                <input class="form-control" type="text" name="email_host" value="{{ @$settings['email_host'] }}">
                                            </div>
                                        </div>
                                    </div>
                                    {{-- Port STMP  --}}
                                    <div class="col-12 col-md-6">
                                        <div class="row mb-3">
                                            <label class="col-sm-2 col-form-label"> @lang('settings.email_port_SMTP') </label>
                                            <div class="col-sm-9">
                                                <input class="form-control" type="number" name="email_port" value="{{ @$settings['email_port'] }}">
                                            </div>
                                        </div>
                                    </div>
                                    {{-- Username --}}
                                    <div class="col-12 col-md-6">
                                        <div class="row mb-3">
                                            <label class="col-sm-2 col-form-label"> @lang('settings.email_user') </label>
                                            <div class="col-sm-9">
                                                <input class="form-control" type="text" name="email_user" value="{{ @$settings['email_user'] }}">
                                            </div>
                                        </div>
                                    </div>
                                    {{-- Password  --}}
                                    <div class="col-12 col-md-6">
                                        <div class="row mb-3">
                                            <label class="col-sm-2 col-form-label"> @lang('settings.email_password_SMTP') </label>
                                            <div class="col-sm-9">
                                                <input class="form-control" type="text" name="email_password" value="{{ @$settings['email_password'] }}">
                                            </div>
                                        </div>
                                    </div>
                                    {{-- sending email  --}}
                                    <div class="col-12 col-md-6">
                                        <div class="row mb-3">
                                            <label class="col-sm-2 col-form-label"> @lang('settings.email_sending_email') </label>
                                            <div class="col-sm-9">
                                                <input class="form-control" type="email" name="email_sending_email" value="{{ @$settings['email_sending_email'] }}">
                                            </div>
                                        </div>
                                    </div>
                                    {{-- sending name  --}}
                                    <div class="col-12 col-md-6">
                                        <div class="row mb-3">
                                            <label class="col-sm-2 col-form-label"> @lang('settings.email_sending_name') </label>
                                            <div class="col-sm-9">
                                                <input class="form-control" type="text" name="email_sending_name" value="{{ @$settings['email_sending_name'] }}">
                                            </div>
                                        </div>
                                    </div>

                                    {{-- donation email  --}}
                                    <div class="col-12 col-md-6">
                                        <div class="row mb-3">
                                            <label class="col-sm-2 col-form-label"> @lang('settings.email_donation_email') </label>
                                            <div class="col-sm-9">
                                                <input class="form-control" type="email" name="email_donation_email" value="{{ @$settings['email_donation_email'] }}">
                                            </div>
                                        </div>
                                    </div>
                                    {{-- email_smtp_status  --}}
                                    <div class="col-12 col-md-6">
                                        <div class="row mb-3">
                                            <label class="col-sm-4 col-form-label"> @lang('settings.email_smtp_status') </label>
                                            <div class="col-sm-5">
                                                <div class="form-check form-switch form-check-success mt-1">
                                                    <input type="hidden" name="email_smtp_status" value="0">
                                                    <input class="form-check-input" type="checkbox" name="email_smtp_status" {{ @$settings['email_smtp_status'] == 1 ? 'checked' : '' }} id="email_smtp_status">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{--  SMS Setting  --}}
                <div class="accordion mt-4 mb-4" id="accordionSMS">
                    <div class="accordion-item border rounded">
                        <h2 class="accordion-header" id="headingSMS">
                            <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSMS" aria-expanded="true" aria-controls="collapseSMS">
                                @lang('settings.sms')
                            </button>
                        </h2>
                        <div id="collapseSMS" class="accordion-collapse collapse show mt-3" aria-labelledby="headingSMS" data-bs-parent="#accordionSMS">
                            <div class="accordion-body">
                                <div class="row">
                                    {{-- SMS gateurl  --}}
                                    <div class="col-12 col-md-6">
                                        <div class="row mb-3">
                                            <label class="col-sm-2 col-form-label"> @lang('settings.sms_gateurl') </label>
                                            <div class="col-sm-9">
                                                <input class="form-control" type="text" name="sms_gateurl" value="{{ @$settings['sms_gateurl'] }}">
                                            </div>
                                        </div>
                                    </div>
                                    {{-- SMS sender_name  --}}
                                    <div class="col-12 col-md-6">
                                        <div class="row mb-3">
                                            <label class="col-sm-2 col-form-label"> @lang('settings.sms_sender_name') </label>
                                            <div class="col-sm-9">
                                                <input class="form-control" type="text" name="sms_sender_name" value="{{ @$settings['sms_sender_name'] }}">
                                            </div>
                                        </div>
                                    </div>
                                    {{-- SMS Username --}}
                                    <div class="col-12 col-md-6">
                                        <div class="row mb-3">
                                            <label class="col-sm-2 col-form-label"> @lang('settings.sms_username') </label>
                                            <div class="col-sm-9">
                                                <input class="form-control" type="text" name="sms_username" value="{{ @$settings['sms_username'] }}">
                                            </div>
                                        </div>
                                    </div>
                                    {{-- SMS Password  --}}
                                    <div class="col-12 col-md-6">
                                        <div class="row mb-3">
                                            <label class="col-sm-2 col-form-label"> @lang('settings.sms_password') </label>
                                            <div class="col-sm-9">
                                                <input class="form-control" type="text" name="sms_password" value="{{ @$settings['sms_password'] }}">
                                            </div>
                                        </div>
                                    </div>
                                
                                    {{-- SMS gateway status  --}}
                                    <div class="col-12 col-md-6">
                                        <div class="row mb-3">
                                            <label class="col-sm-2 col-form-label"> @lang('settings.sms_gateway_status') </label>
                                            <div class="col-sm-5">
                                                <div class="form-check form-switch form-check-success mt-1">
                                                    <input type="hidden" name="sms_gateway_status" value="0">
                                                    <input class="form-check-input" type="checkbox" name="sms_gateway_status" {{ @$settings['sms_gateway_status'] == 1 ? 'checked' : '' }} id="sms_gateway_status">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- SMS  status  --}}
                                    <div class="col-12 col-md-6">
                                        <div class="row mb-3">
                                            <label class="col-sm-2 col-form-label"> @lang('settings.sms_status') </label>
                                            <div class="col-sm-5">
                                                <div class="form-check form-switch form-check-success mt-1">
                                                    <input type="hidden" name="sms_status" value="0">
                                                    <input class="form-check-input" type="checkbox" name="sms_status" {{ @$settings['sms_status'] == 1 ? 'checked' : '' }} id="sms_status">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{--  WhatsApp Setting  --}}
                <div class="accordion mt-4 mb-4" id="accordionWhatsApp">
                    <div class="accordion-item border rounded">
                        <h2 class="accordion-header" id="headingWhatsApp">
                            <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseWhatsApp" aria-expanded="true" aria-controls="collapseWhatsApp">
                                @lang('settings.WhatsApp')
                            </button>
                        </h2>
                        <div id="collapseWhatsApp" class="accordion-collapse collapse show mt-3" aria-labelledby="headingWhatsApp" data-bs-parent="#accordionWhatsApp">
                            <div class="accordion-body">
                                <div class="row">
                                    {{-- WhatsApp gateurl  --}}
                                    <div class="col-12">
                                        <div class="row mb-3">
                                            <label class="col-sm-2 col-form-label"> @lang('settings.whatsapp_gateurl') </label>
                                            <div class="col-sm-9">
                                                <input class="form-control" type="text" name="whatsapp_gateurl" value="{{ @$settings['whatsapp_gateurl'] }}">
                                            </div>
                                        </div>
                                    </div>
                                    {{-- WhatsApp accessToken  --}}
                                    <div class="col-12">
                                        <div class="row mb-3">
                                            <label class="col-sm-2 col-form-label"> @lang('settings.whatsapp_accessToken') </label>
                                            <div class="col-sm-9">
                                                <textarea class="form-control" name="whatsapp_accessToken" id="" cols="30" rows="8">
                                                    {{ @$settings['whatsapp_accessToken'] }}
                                                </textarea>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- WhatsApp broadcast name  --}}
                                    <div class="col-12">
                                        <div class="row mb-3">
                                            <label class="col-sm-2 col-form-label"> @lang('settings.whatsapp_broadcast_name') </label>
                                            <div class="col-sm-9">
                                                <input class="form-control" type="text" name="whatsapp_broadcast_name" value="{{ @$settings['whatsapp_broadcast_name'] }}">
                                            </div>
                                        </div>
                                    </div>
                                    {{-- WhatsApp status  --}}
                                    <div class="col-12">
                                        <div class="row mb-3">
                                            <label class="col-sm-2 col-form-label"> @lang('settings.whatsapp_status') </label>
                                            <div class="col-sm-5">
                                                <div class="form-check form-switch form-check-success mt-1">
                                                    <input type="hidden" name="whatsapp_status" value="0">
                                                    <input class="form-check-input" type="checkbox" name="whatsapp_status" {{ @$settings['whatsapp_status'] == 1 ? 'checked' : '' }} id="whatsapp_status">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                {{--  finantioal accounts Setting  --}}
                <div class="accordion mt-4 mb-4" id="accordionFinantioal">
                    <div class="accordion-item border rounded">
                        <h2 class="accordion-header" id="headingFinantioal">
                            <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFinantioal" aria-expanded="true" aria-controls="collapseFinantioal">
                                @lang('settings.FinantioalAccounts')
                            </button>
                        </h2>
                        <div id="collapseFinantioal" class="accordion-collapse collapse show mt-3" aria-labelledby="headingFinantioal" data-bs-parent="#accordionFinantioal">
                            <div class="accordion-body">
                                <div class="row">
                                    {{-- api_user  --}}
                                    <div class="col-12 col-md-6">
                                        <div class="row mb-3">
                                            <label class="col-sm-3 col-form-label"> @lang('settings.api_user') </label>
                                            <div class="col-sm-8">
                                                <input class="form-control" type="text" name="api_user" value="{{ @$settings['api_user'] }}">
                                            </div>
                                        </div>
                                    </div>
                                    {{-- api_key --}}
                                    <div class="col-12 col-md-6">
                                        <div class="row mb-3">
                                            <label class="col-sm-3 col-form-label"> @lang('settings.api_key') </label>
                                            <div class="col-sm-8">
                                                <input class="form-control" type="text" name="api_key" value="{{ @$settings['api_key'] }}">
                                            </div>
                                        </div>
                                    </div>
                                
                                    {{-- api status  --}}
                                    <div class="col-12 col-md-6">
                                        <div class="row mb-3">
                                            <label class="col-sm-3 col-form-label"> @lang('settings.api_enable') </label>
                                            <div class="col-sm-5">
                                                <div class="form-check form-switch form-check-success mt-1">
                                                    <input type="hidden" name="api_enable" value="0">
                                                    <input class="form-check-input" type="checkbox" name="api_enable" {{ @$settings['api_enable'] == 1 ? 'checked' : '' }} id="api_enable">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
