@extends('admin.app')


@section('title', trans('project.show_project'))
@section('title_page', trans('project.project'))
@section('title_route', route('admin.projects.index') )
@section('button_page')
<a href="{{ route('admin.projects.index') }}" class="btn btn-outline-primary waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
@endsection

@section('content')


<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-8">
                <div class="accordion mt-4 mb-4" id="accordionExample">
                    <div class="accordion-item border rounded">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                {{ trans('admin.title')  }}
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse show mt-3" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                            <div class="accordion-body">

                                @foreach ($languages as $key => $locale)
                                {{-- title ------------------------------------------------------------------------------------- --}}
                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">{{ trans('admin.title_in') .   trans('lang.' .Locale::getDisplayName($locale)) }}</label>
                                    <div class="col-sm-10">
                                        <input class="form-control" type="text" name="{{ $locale }}[title]" disabled value="{{ @$project->trans->where('locale', $locale)->first()->title }}" id="title{{ $key }}">
                                    </div>

                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                </div>

                {{-- images Gellary  --}}
                <div class="accordion mt-4 mb-4" id="accordionExample">
                    <div class="accordion-item border rounded">
                        <h2 class="accordion-header" id="headingImage">
                            <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseImage" aria-expanded="true" aria-controls="collapseOne">
                                @lang('admin.gallerys')
                            </button>
                        </h2>
                        <div id="collapseImage" class="accordion-collapse collapse show mt-3" aria-labelledby="headingImage" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <div class="row">
                                    @forelse($project->images as $key => $img)
                                    <div class="col-md-3 image-select mt-2">
                                        <a href="{{getImage(@$img->url)}}" target="_blank">
                                            <img src="{{getImageThumb(@$img->url)}}" class="rounded-3" alt="" width="100%">
                                        </a>
                                    </div>
                                    @empty
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="col-md-4">
                <div class="accordion mt-4 mb-4" id="accordionExample">
                    <div class="accordion-item border rounded">
                        <h2 class="accordion-header" id="headingTwo">
                            <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                                {{ trans('admin.settings') }}
                            </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse show" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <div class="row mb-3">

                                    <div class="col-sm-3 col-md-6 mb-3">
                                        <a href="{{ getImage($project->image) }}">
                                            <img src="{{ getImageThumb($project->image) }}" alt="" class="rounded-3" style="width:100%">
                                        </a>
                                    </div>
                                </div>

                                {{-- portfolio  ------------------------------------------------------------------------------- --}}
                                <div class="row mb-3">
                                    <div class="col-12">
                                        <label for="example-number-input" class="col-form-label col-md-6 col"> @lang('project.portfolio') </label>
                                        <span class="text-primary col-md-6 col"> {{ @$project->portfolio ? @$project->portfolio->trans->where('locale',$current_lang)->first()->title : "__"  }}</span>
                                    </div>
                                </div>

                                {{-- sort ------------------------------------------------------------------------------------- --}}
                                <div class="row mb-3">
                                    <div class="col-12">
                                        <label for="example-number-input" class="col-form-label col-md-6 col"> @lang('project.sort')</label>
                                        <span>{{ $project->sort }}</p>
                                    </div>
                                </div>
                                {{-- feature ------------------------------------------------------------------------------------- --}}
                                <div class="row mb-3">

                                    <div class="col-12 ">
                                        <label class="col-md-6 col-form-label" for="available">{{ trans('admin.feature') }}</label>
                                        @if($project->feature == 1 )
                                        <span class="badge bg-success">@lang("admin.yes")</span>
                                        @else
                                        <span class="badge bg-danger">@lang("admin.no")</span>
                                        @endif
                                    </div>
                                </div>
                                {{-- Status ------------------------------------------------------------------------------------- --}}
                                <div class="row mb-3">

                                    <div class="col-12">
                                        <label class="col-sm-6 col-form-label" for="available">{{ trans('admin.status') }}</label>
                                        @if($project->status == 1 )
                                        <span class="badge bg-success">@lang("admin.active")</span>
                                        @else
                                        <span class="badge bg-danger">@lang("admin.dis_active")</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



            </div>

            {{-- Butoooons ------------------------------------------------------------------------- --}}
            <div class="row mb-3 text-end">
                <div>
                    <a href="{{ route('admin.projects.index') }}" class="btn btn-outline-danger waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
