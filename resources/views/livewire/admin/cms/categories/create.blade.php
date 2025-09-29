<div>
    <div class="container-fluid">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="{{ asset('site/js/ckeditor/ckeditor.js') }}"></script>
        {{-- <script src="https://cdn.ckeditor.com/4.18.0/standard/ckeditor.js"></script> --}}

        <div class="row">
            <div class="col-12 m-3">
                <div class="card">
                    <div class="card-body">

                        @include('admin.layouts.message')


                        <div class="row">
                            <div class="col-md-9">
                                @foreach ($languages as $key => $locale)
                                    <div class="accordion mt-4 mb-4" id="accordionExample">
                                        <div class="accordion-item border rounded">
                                            <h2 class="accordion-header" id="headingOne{{ $key }}">
                                                <button class="accordion-button fw-medium" type="button"
                                                    data-bs-toggle="collapse"
                                                    data-bs-target="#collapseOne{{ $key }}"
                                                    aria-expanded="true" aria-controls="collapseOne{{ $key }}">
                                                    {{ Locale::getDisplayName($locale) }}
                                                </button>
                                            </h2>
                                            <div id="collapseOne{{ $key }}"
                                                class="accordion-collapse collapse show mt-3"
                                                aria-labelledby="headingOne{{ $key }}"
                                                data-bs-parent="#accordionExample">
                                                <div class="accordion-body">



                                                    {{-- title ------------------------------------------------------------------------------------- --}}
                                                    <div class="row mb-3">
                                                        <label for="example-text-input"
                                                            class="col-sm-2 ">{{ trans('admin.title_in') . Locale::getDisplayName($locale) }}</label>
                                                        <div class="col-sm-10">
                                                            <input class="form-control" type="text"
                                                                wire:model='title.{{ $locale }}'
                                                                wire:keyup="generateSlug('{{ $locale }}')"
                                                                @if (@$showMode == true) disabled @endif required>
                                                        </div>
                                                        @error('title.{{ $locale }}')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                        @error('title.{{ $locale }}')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>

                                                    {{-- slug ------------------------------------------------------------------------------------- --}}
                                                    <div class="row mb-3 slug-section">
                                                        <label for="example-text-input"
                                                            class="col-sm-2 ">{{ trans('admin.slug_in') . Locale::getDisplayName($locale) }}</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" wire:model="slug.{{ $locale }}"
                                                                class="form-control slug"
                                                                @if (@$showMode == true) disabled @endif>
                                                        </div>
                                                        @error('slug.{{ $locale }}')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror

                                                    </div>


                                                    {{-- description ------------------------------------------------------------------------------------- --}}
                                                    <div class="row mb-3">
                                                        <label for="example-text-input" class="col-sm-2 ">
                                                            @lang('admin.description_in') {{ Locale::getDisplayName($locale) }}
                                                        </label>
                                                        <div class="col-sm-10 mb-2"  wire:ignore>
                                                        
                                                            <textarea id="my-ckeditor{{ $key }}" class="form-control"  wire:model="description.{{ $locale }}"   @if (@$showMode == true) disabled @endif></textarea>
                                                            @error('description.{{ $locale }}')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                        @if (@$showMode != true)
                                                            <script type="text/javascript">
                                                                $(document).ready(function() {
                                                                    const editor = CKEDITOR.replace('my-ckeditor{{ $key }}');
                                                                    editor.on('change', function(event) {
                                                                            @this.set('description.{{ $locale }}', event.editor.getData());
                                                                        })
                                                                        window.addEventListener('storeCategory', event => {
                                                                            CKEDITOR.instances['my-ckeditor{{ $key }}'].setData('');
                                                                            $('#my-ckeditor{{ $key }}').val("");
                                                                        })
                                                                })
                                                            </script>
                                                        @endif
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach


                                <div class="accordion mt-4 mb-4" id="accordionExample">
                                    <div class="accordion-item border rounded">
                                        <h2 class="accordion-header" id="headingTwo{{ $key }}">
                                            <button class="accordion-button fw-medium" type="button"
                                                data-bs-toggle="collapse"
                                                data-bs-target="#collapseTwo{{ $key }}" aria-expanded="true"
                                                aria-controls="collapseTwo{{ $key }}">
                                                @lang('admin.meta')
                                            </button>
                                        </h2>
                                        <div id="collapseTwo{{ $key }}"
                                            class="accordion-collapse collapse show mt-3"
                                            aria-labelledby="headingTwo{{ $key }}"
                                            data-bs-parent="#accordionExample">
                                            <div class="accordion-body">

                                                @foreach ($languages as $key => $locale)
                                                    {{-- meta_title_ ------------------------------------------------------------------------------------- --}}
                                                    <div class="row mb-3">
                                                        <label for="example-text-input"
                                                            class="col-sm-2 ">{{ trans('admin.meta_title_in') . Locale::getDisplayName($locale) }}</label>
                                                        <div class="col-sm-10">
                                                            <input class="form-control" type="text"
                                                                wire:model="meta_title.{{ $locale }}"
                                                                id="title{{ $key }}"
                                                                @if (@$showMode == true) disabled @endif>
                                                        </div>
                                                        @error('meta_title.{{ $locale }}')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>

                                                    {{-- meta_description_ ------------------------------------------------------------------------------------- --}}
                                                    <div class="row mb-3">
                                                        <label for="example-text-input" class="col-sm-2 ">
                                                            @lang('admin.meta_description_in') {{ Locale::getDisplayName($locale) }}
                                                        </label>
                                                        <div class="col-sm-10 mb-2">
                                                            <textarea wire:model="meta_description.{{ $locale }}" class="form-control description"
                                                                @if (@$showMode == true) disabled @endif>  </textarea>
                                                            @error('meta_description.{{ $locale }}')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    {{-- meta_key_ ------------------------------------------------------------------------------------- --}}
                                                    <div class="row mb-3">
                                                        <label for="example-text-input" class="col-sm-2 ">
                                                            @lang('admin.meta_key_in') {{ Locale::getDisplayName($locale) }}
                                                        </label>
                                                        <div class="col-sm-10 mb-2">
                                                            <textarea wire:model="meta_key.{{ $locale }}" class="form-control description"
                                                                @if (@$showMode == true) disabled @endif> {{ @$meta_key[$locale] }} </textarea>
                                                            @error('meta_key.{{ $locale }}')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <hr>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>





                            </div>


                            <div class="col-md-3">

                                <div class="accordion mt-4 mb-4" id="accordionExample">
                                    <div class="accordion-item border rounded">
                                        <h2 class="accordion-header" id="headingOne">
                                            <button class="accordion-button fw-medium" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#collapseOne"
                                                aria-expanded="true" aria-controls="collapseOne">
                                                {{ trans('admin.settings') }}
                                            </button>
                                        </h2>
                                        <div id="collapseOne" class="accordion-collapse collapse show"
                                            aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">

                                                {{-- image ------------------------------------------------------------------------------------- --}}

                                                @if (@$imageExist != null)
                                                    <div class="col-12">
                                                        <div class="row mb-3">
                                                            <div class="col-sm-12">
                                                                <a href="{{ asset(@$imageExist) }}" target="_blank">
                                                                    <img src="{{ asset(@$imageExist) }}"
                                                                        alt="" style="width:100%">
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif

                                                @if (@$showMode != true)
                                                    <div class="col-12">
                                                        <div class="row mb-3">
                                                            <label for="example-number-input">
                                                                @lang('admin.image')</label>
                                                            <div class="col-sm-12">
                                                                <input class="form-control" type="file"
                                                                    wire:model="image">
                                                            </div>
                                                            @error('image')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                @endif


                                                {{-- parent Category ------------------------------------------------------------------------------------- --}}
                                                <div class="col-12">
                                                    <div class="row mb-3">
                                                        <label for="example-number-input"> @lang('categories.parent')</label>
                                                        <div class="col-sm-10">
                                                            <select class="form-select form-select-sm select2"
                                                                wire:model="parent_id"
                                                                @if (@$showMode == true) disabled @endif >
                                                                <option value="{{ null }}" selected>
                                                                    {{ trans('categories.select_parent') }}</option>
                                                                @foreach (App\Models\Categories::query()->get() as $category)
                                                                    <option value="{{ $category->id }}"
                                                                        {{ $parent_id != '' && $parent_id == $category->id ? 'selected' : '' }}>
                                                                        {{  str_repeat('ـــ ', $category->level - 1) }}  {{ @$category->trans->where('locale',$current_lang)->first()->title }} </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        @error('parent_id')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                {{-- sort ------------------------------------------------------------------------------------- --}}
                                                <div class="col-12">
                                                    <div class="row mb-3">
                                                        <label> @lang('categories.sort')</label>
                                                        <div class="col-sm-10">
                                                            <input class="form-control" type="number"
                                                                wire:model="sort"
                                                                @if (@$showMode == true) disabled @endif>
                                                        </div>
                                                        @error('sort')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                {{-- feature ------------------------------------------------------------------------------------- --}}
                                                    @if (@$showMode != true)
                                                    <div class="col-12">
                                                        <label class="col-sm-12 "
                                                            for="available">{{ trans('categories.feature') }}</label>
                                                        <div class="col-sm-10">
                                                            <input class="form-check form-switch" wire:model="feature"
                                                                type="checkbox" id="switch1" switch="success"
                                                                {{ @$feature == 1 ? 'checked' : '' }} value="1">
                                                            <label class="form-label" for="switch1"
                                                                data-on-label=" @lang('admin.yes') "
                                                                data-off-label=" @lang('admin.no')"></label>
                                                            @error('feature')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    @else
                                                    <div class="col-12 ">
                                                        <label class="col-md-3 col-form-label"
                                                            for="available">{{ trans('categories.feature') }}</label>
                                                        @if ($feature == 1)
                                                            <p class="badge  bg-success h5" style="font-size:20px">
                                                                @lang('admin.yes')</p>
                                                        @else
                                                            <p class="badge  bg-danger h5" style="font-size:20px">
                                                                @lang('admin.no')</p>
                                                        @endif
                                                    </div>
                                                    @endif
                                        {{-- Status ------------------------------------------------------------------------------------- --}}
                                        @if (@$showMode != true)
                                                <div class="col-12">
                                                    <label class="col-sm-12 "
                                                        for="available">{{ trans('admin.status') }}</label>
                                                    <div class="col-sm-10">
                                                        <input class="form-check form-switch" wire:model="status"
                                                            type="checkbox" id="switch3" switch="success"
                                                            {{ @$status == 1 ? 'checked' : '' }} value="1">
                                                        <label class="form-label" for="switch3"
                                                            data-on-label=" @lang('admin.yes') "
                                                            data-off-label=" @lang('admin.no')"></label>
                                                    </div>
                                                    @error('status')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                        </div>
                                        @else
                                            <div class="col-12 ">
                                                <label class="col-md-3 col-form-label"
                                                    for="available">{{ trans('admin.status') }}</label>
                                                @if ($status == 1)
                                                    <p class="badge  bg-success h5" style="font-size:20px">
                                                        @lang('admin.yes')</p>
                                                @else
                                                    <p class="badge  bg-danger h5" style="font-size:20px">
                                                        @lang('admin.no')</p>
                                                @endif
                                            </div>
                                        @endif

                                        
                                      
                                        </div>
                                    </div>
                                </div>

                           
                             

                            </div>
                        </div>


                        {{-- Buttoooons ------------------------------------------------------------------------- --}}
                        @if (@$showMode != true)
                            <div class="row mb-3 text-end">
                                <div>
                                    <a href="{{ route('admin.categories.index') }}"
                                        class="btn btn-outline-danger waves-effect waves-light ml-3">@lang('button.cancel')</a>
                                    {{-- <button  wire:click="clearForm()" type="button" class="btn btn-outline-warning waves-effect waves-light ml-3">@lang('button.reset')</button> --}}
                                    @if ($editMode == true)
                                        <button wire:click.prevent="updateCategory({{ $categoryID }})"
                                            type="button"
                                            class="btn btn-outline-success waves-effect waves-light ml-3">@lang('button.update')</button>
                                    @else
                                        <button wire:click.prevent="storeCategory()" type="button" id="mysbmit"
                                            class="btn btn-outline-success waves-effect waves-light ml-3">@lang('button.save')</button>
                                    @endif
                                </div>
                            </div>
                        @endif


          

                    </div>
                </div>
            </div> <!-- end col -->
        </div>

    </div> <!-- container-fluid -->
</div>
