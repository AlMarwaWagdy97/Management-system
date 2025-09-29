@extends('admin.errors.error')

@section('title', __('errors.forbidden'))
@section('code', '403')
@section('error_title', __('errors.forbidden'))
@section('message', __("errors.forbidden_message"))
@section('image', admin_path('images/errors-images/403-error.webp'))

