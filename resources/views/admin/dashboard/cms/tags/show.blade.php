@extends('admin.app')

@section('title', trans('tags.show'))
@section('title_page', trans('tags.tags'))
@section('title_route', route('admin.tag.index') )
@section('button_page')
<a href="{{ route('admin.tag.index') }}" class="btn btn-primary waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
@endsection

@section('content')

<div class="row">
    <div class="card">
        <div class="card-body">

            <form action="{{ route('admin.tag.update',$tag->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('put')
                <div class="row">
                    <div class="col-md-8">
                        @foreach ($languages as $key => $locale)
                        <div class="accordion mt-4 mb-4" id="accordionExampleTitle{{ $key }}">
                            <div class="accordion-item border rounded">
                                <h2 class="accordion-header" id="headingTitle{{ $key }}">
                                    <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTitle{{ $key }}" aria-expanded="true" aria-controls="collapseTitle{{ $key }}">
                                        {{ trans('lang.' .Locale::getDisplayName($locale)) }}
                                    </button>
                                </h2>
                                <div id="collapseTitle{{ $key }}" class="accordion-collapse collapse show mt-3" aria-labelledby="headingTitle{{ $key }}" data-bs-parent="#accordionExampleTitle{{ $key }}">
                                    <div class="accordion-body">



                                        {{-- title ------------------------------------------------------------------------------------- --}}
                                        <div class="row mb-3">
                                            <label for="example-text-input" class="col-sm-2 col-form-label">{{ trans('admin.title_in') .  trans('lang.' .Locale::getDisplayName($locale)) }}</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" type="text" name="{{ $locale }}[title]" disabled value="{{ $tag->trans->where('locale',$locale)->first()->title }}" id="title{{ $key }}">
                                            </div>
                                            @if($errors->has( $locale . '.title'))
                                            <span class="missiong-spam">{{ $errors->first( $locale . '.title') }}</span>
                                            @endif
                                        </div>

                                        {{-- slug ------------------------------------------------------------------------------------- --}}
                                        <div class="row mb-3 slug-section">
                                            <label for="example-text-input" class="col-sm-2 col-form-label">{{ trans('admin.slug_in') .  trans('lang.' .Locale::getDisplayName($locale))}}</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="{{ $locale }}[slug]" disabled value="{{ $tag->trans->where('locale',$locale)->first()->slug}}" id="slug{{ $key }}" class="form-control slug" required>
                                            </div>
                                            @if($errors->has( $locale . '.slug'))
                                            <span class="missiong-spam">{{ $errors->first( $locale . '.slug') }}</span>
                                            @endif
                                            <script>
                                                $(document).ready(function() {
                                                    $("#title" + {
                                                        {
                                                            $key
                                                        }
                                                    }).on('keyup', function() {
                                                        var Text = $(this).val();
                                                        Text = Text.toLowerCase();
                                                        Text = Text.replace(/[^a-zA-Z0-9ء-ي]+/g, '-');
                                                        $("#slug" + {
                                                            {
                                                                $key
                                                            }
                                                        }).val(Text);
                                                    });
                                                });

                                            </script>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>


                    <div class="col-md-4">
                        {{-- ------ Start Post Settings------ --}}
                        <div class="accordion mt-4 mb-4" id="accordionExampleSetting">
                            <div class="accordion-item border rounded">
                                <h2 class="accordion-header" id="headingSetting">
                                    <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSetting" aria-expanded="true" aria-controls="collapseSetting">
                                        {{ trans('tags.Post_settings') }}
                                    </button>
                                </h2>
                                <div id="collapseSetting" class="accordion-collapse collapse show" aria-labelledby="headingSetting" data-bs-parent="#accordionExampleSetting">
                                    <div class="accordion-body">
                                        <div class="row mb-3">
                                            <label for="example-number-input" col-form-label> @lang('admin.image')</label>
                                            <div class="col-sm-6">
                                                <a href="{{ getImage( $tag->image) }}" target="_blank">
                                                    <img src="{{ getImageThumb( $tag->image ) }}" alt="" style="width:100%">
                                                </a>
                                            </div>
                                        </div>
                                        {{-- image ------------------------------------------------------------------------------------- --}}

                                        {{-- sort ------------------------------------------------------------------------------------- --}}
                                        <div class="col-12">
                                            <div class="row mb-3">
                                                <label for="example-number-input" col-form-label>
                                                    @lang('articles.sort')</label>
                                                <div class="col-sm-10">
                                                    <input class="form-control" type="number" placeholder="@lang('articles.sort')" id="example-number-input" name="sort" value="{{ $tag->sort }}" disabled>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- feature ------------------------------------------------------------------------------------- --}}
                                        <div class="col-12">
                                            <label class="col-md-3 col-form-label" for="available">{{ trans('admin.feature') }}</label>
                                            @if($tag->feature == 1 )
                                            <span class="badge  bg-success">@lang("admin.yes")</span>
                                            @else
                                            <span class="badge  bg-danger">@lang("admin.no")</span>
                                            @endif
                                        </div>

                                        {{-- Status ------------------------------------------------------------------------------------- --}}
                                        <div class="col-12">
                                            <label class="col-md-3 col-form-label" for="available">{{ trans('admin.status') }}</label>
                                            @if($tag->status == 1 )
                                            <span class="badge  bg-success">@lang("admin.yes")</span>
                                            @else
                                            <span class="badge  bg-danger">@lang("admin.no")</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- ------ End Post Settings------ --}}
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection
