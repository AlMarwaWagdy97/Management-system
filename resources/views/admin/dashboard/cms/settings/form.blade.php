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

<div class="card py-3 card-gray-dark">
    <form class="form-horizontal" action="{{route('admin.settings.update', $settingMain->id)}}" method="POST" enctype="multipart/form-data" role="form">
        @csrf
        <div class="card-body">
            @foreach($settings as $key => $setting)
            @if($setting->type == 0)
            <div class="row mb-3">
                <label for="{{ $key }}"> {{trans('settings.'.$setting->key)}} </label>
                <div class="col-sm-10">
                    <input class="form-control" type="text" name="{{$setting->key}}" value="{{$setting->value}}">
                </div>
            </div>
            @elseif($setting->type == 1)
            <div class="row mb-3">
                <div class="col-md-2">
                    <label for="{{ $key }}" col-form-label> {{trans('settings.'.$setting->key)}} :</label>
                </div>
                <div class="col-sm-4">
                    <input class="form-control" type="file" placeholder="@lang('admin.image')" id="{{ $key }}" name="{{$setting->key}}">
                </div>
                @if($setting->value)
                <div class="col-sm-4" style="max-width: 200px; max-height: 150px; background-color: #e7e7e7;">
                    <img style="width: 100px;height:100px" src="{{ getImageThumb($setting->value)}}" alt="" />
                </div>
                @else
                <div class="col-sm-4" style="width: 200px; height: 150px;">
                    <img src="{{ admin_path('images/not_found.PNG') }}" width="150" height="150" alt="" />
                </div>
                @endif
            </div>
            @elseif($setting->type == 2)
            <div class="row mb-3">
                <label for="{{ $key }}" class="col-sm-2 col-form-label"> {{trans('settings.'.$setting->key)}} </label>
                <div class="col-sm-10">
                    <textarea id="content{{ $setting->key }}" name="{{$setting->key}}" class="form-control"> {{$setting->value}} </textarea>
                </div>
            </div>
            @elseif($setting->type == 3)
            <div class="form-group">
                <label class="col-sm-2 control-label" for="{{ $key }}">
                    {{trans('settings.'.$setting->key)}}
                </label>
                <div class="col-sm-10">
                    <input type="text" id="{{ $key }}" placeholder="{{trans('settings.'.$setting->key)}}" name="{{$setting->key}}" class="form-control" value="{{$setting->value}}" />
                    <iframe style="margin-top: 10px" src="{{ $setting->value }}" frameborder="0"></iframe>
                </div>
            </div>
            @elseif($setting->type == 4)
            <div class="row mb-3">
                <label for="{{ $key }}" class="col-sm-2 col-form-label"> {{trans('settings.'.$setting->key)}} </label>
                <div class="col-sm-10">
                    <textarea id="content{{ $setting->key }}" name="{{$setting->key}}" class="form-control"> {{$setting->value}} </textarea>
                </div>
            </div>
            @elseif($setting->type == 5)
            <div class="row mb-3">
                <label for="{{ $key }}" class="col-sm-2 col-form-label"> {{trans('settings.'.$setting->key)}} </label>
                <div class="col-sm-10">
                    <input class="form-control" type="number" name="{{$setting->key}}" value="{{$setting->value}}">
                </div>
            </div>
            @elseif($setting->type == 6)
                <div class="row mb-3">
                    <label for="{{ $key }}" class="col-sm-2 col-form-label">
                        {{ trans('settings.' . $setting->key) }} </label>
                    <div class="col-sm-2">
                        <input class="" type="radio" name="{{ $setting->key }}"
                            value="0" {{ $setting->value == 0 ? 'checked' : '' }}>
                        <strong>
                            {{ __('admin.hide') }}
                        </strong>
                    </div>
                    <div class="col-sm-2">
                        <input class="" type="radio" name="{{ $setting->key }}"
                            value="1" {{ $setting->value == 1 ? 'checked' : '' }}>
                        <strong>
                            {{ __('admin.show') }}
                        </strong>
                    </div>
                </div>
            @endif
            @endforeach

            <div class="row mb-3 text-end">
                <div>
                    <a href="{{ route('admin.settings.index') }}" class="btn btn-outline-primary waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
                    <button type="submit" class="btn btn-outline-success waves-effect waves-light ml-3 btn-sm">@lang('button.save')</button>
                </div>
            </div>
        </div>
    </form>
</div>

@endsection
