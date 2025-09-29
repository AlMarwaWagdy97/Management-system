@extends('admin.errors.error')

@section('title', __('errors.Unauthorized'))
@section('code', '401')
@section('error_title', __('errors.Unauthorized'))
@section('message', __("errors.Unauthorized_message"))
@section('image', admin_path('images/errors-images/401-error.png'))
