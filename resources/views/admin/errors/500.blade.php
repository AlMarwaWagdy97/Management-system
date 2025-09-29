@extends('admin.errors.error')

@section('title', __('errors.Server_Error'))
@section('code', '500')
@section('error_title', __('errors.Sorry_unexpected_error'))
@section('message', __("errors.Server_Error_message"))
@section('image', admin_path('images/errors-images/505-error.png'))
