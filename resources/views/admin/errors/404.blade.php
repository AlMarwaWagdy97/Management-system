@extends('admin.errors.error')

@section('title', __('errors.Not_Found'))
@section('code', '404')
@section('error_title', __('errors.Lost_Space'))
@section('message', __("errors.Not_Found_message"))
@section('image', admin_path('images/errors-images/404-error.png'))

