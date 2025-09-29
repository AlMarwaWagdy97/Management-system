<div>
{{-- Setting ---------------------------------------------------------------------------------------------------------- --}}
<div class="mt-4 mb-4 accordion" id="accordionExampleSetting">
    <div class="border rounded accordion-item">
        <h2 class="accordion-header" id="headingSetting">
            <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                {{ trans('admin.settings') }}
            </button>
        </h2>
        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingSetting" data-bs-parent="#accordionExampleSetting">
            <div class="accordion-body">
                {{-- number   ------------------------------------------------------------------------------------- --}}
                <div class="col-12">
                    <div class="mb-3 row">
                        <label for="example-number-input" class="col-sm-12 col-form-label" l>
                            @lang('charityProject.number') </label>
                        <div class="col-sm-12">
                            <input class="form-control {{ (empty($errors->first('number'))) ?: 'has-error'  }}" type="text" id="example-number-input" name="number" value="{{ $charityProject->number }}">
                            @if ($errors->has('number'))
                            <span class="missiong-spam">{{ $errors->first('number') }}</span>
                            @endif
                        </div>
                    </div>
                </div>
                {{-- beneficiary ------------------------------------------------------------------------------------- --}}
                <div class="col-12">
                    <label class="col-sm-12 col-form-label" for="available">@lang('charityProject.beneficiary')  </label>
                    <div class="col-sm-12">
                        <input class="form-control {{ (empty($errors->first('beneficiary'))) ?: 'has-error'  }}" name="beneficiary" type="text" value="{{ $charityProject->beneficiary }}">
                        @if ($errors->has('beneficiary'))
                        <span class="missiong-spam">{{ $errors->first('beneficiary') }}</span>
                        @endif
                    </div>
                </div>
                {{-- project Type ------------------------------------------------------------------------------------- --}}
                <div class="row mb-3">
                    <label for="example-text-input" class="col-sm-12 col-form-label"> @lang('categories.project_type') <span class="text-danger">*</span> </label> 
                    <div class="col-sm-12">
                        <select class="form-select " name="project_types" required wire:model="project_types" wire:change.prevent="updateProjectTypes($event.target.value)">
                            <option value=""> {{ trans('charityProject.select_project_type') }}</option>
                            @foreach (App\Enums\ProjectTypesEnum::labels() as $key => $type)
                            <option value="{{ $type}}" {{ $project_types ?? old('project_types') == $type ? 'selected': '' }}>
                                {{ $type }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    @error('project_types')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                {{-- category -------------------------------------------------------------------------------------   --}}
                <div class="mb-3 row title-section">
                    <label for="example-text-input" class="col-sm-12 col-form-label">@lang('charityProject.category')</label>
                    <div class="col-sm-12">
                        <select class="form-select form-select-sm select2 {{ (empty($errors->first('category_id'))) ?: 'has-error'  }}" required name="category_id" wire:model.prevent="category_id" aria-label=".form-select-sm example">
                            <option value="">@lang('charityProject.choose_category')</option>
                            @foreach ($categories as $item)
                            <option value="{{ $item->id }}" {{ $charityProject->category_id == $item->id ? 'selected' : ''  }}>
                                {{ $item->trans->where('locale', $current_lang)->first()->title }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    @if ($errors->has('category_id'))
                    <span class="missiong-spam">{{ $errors->first('category_id') }}</span>
                    @endif
                </div>
                {{-- tags ------------------------------------------------------------------------------------- --}}
                <div class="mb-3 row title-section">
                    <label for="example-text-input" class="col-sm-12 col-form-label">@lang('charityProject.tags')</label>
                    <div wire:ignore class="col-sm-12">
                        <select class="form-select form-select-sm select2 {{ (empty($errors->first('tags'))) ?: 'has-error'  }}" multiple name="tags[]" aria-label=".form-select-sm example">
                            @foreach ($projectTags as $item)
                            <option value="{{ $item->id }}" {{ in_array($item->id,
                                $charityProject->tags->pluck('tag_id')->toArray()) ? 'selected' : '' }}>
                                {{ $item->trans->where('locale', $current_lang)->first()->title }}
                            </option>
                            @endforeach
                        </select>
                        @if ($errors->has('tags'))
                        <span class="missiong-spam">{{ $errors->first('tags') }}</span>
                        @endif
                    </div>
                </div>
                {{-- Extra fields ------------------------------------------------------------------------------------- --}}
                @if($project_types == $charityProject->project_types)
                    @forelse($charityProject->extraFields as $key=> $extra)
                        @if($extra->field->type == "INPUT")
                            <div class="mb-3 row">
                                <div class="col-12">
                                    <label for="example-extrafieldsvalues[{{  $extra->field->title }}]-input" class="col-sm-12 col-form-label"> @lang('charityProject.' .  $extra->field->title) </label>
                                    <div class="col-sm-12">
                                        <input class="form-control {{ (empty($errors->first($extra->field->title))) ?: 'has-error'  }}"  {{ $extra->field->is_required? 'required':'' }} type="text" name="extrafieldsvalues_old[{{ $extra->id }}]" value="{{ $extra->value }}" >
                                    </div>
                                </div>
                            </div>
                        @elseif($extra->field->type == "INPUT_NUMBER")
                            <div class="col-12">
                                <div class="mb-3 row">
                                    <label for="extrafieldsvalues[{{ $extra->field->title }}]" class="col-sm-12 col-form-label"> @lang('charityProject.' . $extra->field->title) </label>
                                    <div class="col-sm-12">
                                        <input class="form-control {{ (empty($errors->first($extra->field->title))) ?: 'has-error'  }}"  {{ $extra->field->is_required? 'required':'' }} type="number" step="any" name="extrafieldsvalues_old[{{ $extra->id  }}]"  value="{{ $extra->value }}" >
                                        @if ($errors->has($extra->field->title))
                                        <span class="missiong-spam">{{ $errors->first($extra->field->title) }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @elseif($extra->field->type == "TEXTAREA")
                            <div class="col-12">
                                <div class="mb-3 row">
                                    <label for="extrafieldsvalues[{{ $extra->field->title }}]" class="col-sm-12 col-form-label"> @lang('charityProject.' . $extra->field->title) </label>
                                    <div class="col-sm-12">
                                        <textarea  name="extrafieldsvalues_old[{{ $extra->id }}]" {{ $extra->field->is_required? 'required':'' }} cols="30" rows="10" class="form-control {{ (empty($errors->first($extra->field->title))) ?: 'has-error'  }}">{{ @$extra->value  }}</textarea>
                                        @if ($errors->has($extra->field->title))
                                        <span class="missiong-spam">{{ $errors->first($extra->field->title) }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @elseif($extra->field->type == "SELECT_INPUT")
                            <div class="col-12">
                                <div class="mb-3 row">
                                    <label for="extrafieldsvalues-{{ $extra->field->title }}-input" class="col-sm-12 col-form-label"> @lang('charityProject.' . $extra->field->title) </label>
                                    <div class="col-sm-12">
                                        <select name="extrafieldsvalues_old[{{ $extra->id }}]"   {{ $extra->field->is_required? 'required':'' }} class="form-control select2 {{ (empty($errors->first($extra->field->title))) ?: 'has-error'  }}">
                                            <option value=""></option>
                                            @foreach( resolve($extra->field->description)->get() as $key => $value)
                                                <option value="{{ $value->id }}" {{$value->id == $extra->value ? 'selected':''}}>{{ $value->title }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has($extra->field->title))
                                        <span class="missiong-spam">{{ $errors->first($extra->field->title) }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @elseif($extra->field->type == "IMAGE")
                            <div class="col-12">
                                <div class="mb-3 row">
                                    <label for="example-extrafieldsvalues-{{$extra->field->title}}-input" class="col-sm-12 col-form-label"> @lang('charityProject.' . $extra->field->title) </label>
                                    <div class="col-9">
                                        <input type="hidden" name="extrafieldsvalues_old[{{ $extra->id }}]"  value="{{ $extra->value }}" >
                                        <input class="form-control {{ (empty($errors->first($extra->field->title))) ?: 'has-error'  }}"  {{ $extra->field->is_required &&  $extra->value =="" ? 'required':'' }} type="file" name="extrafieldsvalues_old[{{ $extra->id }}]"  value="{{ $extra->value }}" >
                                        @if ($errors->has($extra->field->title))
                                        <span class="missiong-spam">{{ $errors->first($extra->field->title) }}</span>
                                        @endif
                                    </div>
                                    <div class="col-3">
                                        <a href="{{ asset($extra->value ) }}" target="_blank">
                                            <img src="{{ getImage($extra->value ) }}" alt="{{ $extra->field->title }}" width="50">
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @elseif($extra->field->type == "CHECKBOX")
                            <div class="col-12">
                                <div class="mb-3 row">
                                    <label for="example-extrafieldsvalues-input" class="col-sm-12 col-form-label"> @lang('charityProject.' . $extra->field->title) </label>
                                    <div class="col-sm-12">
                                        @forelse(json_decode($extra->field->description) as $value)
                                            <div>
                                                <input type="radio" id="{{ $value }}" value="{{ $value }}" {{ $value ==  $extra->value ? 'checked' :'' }} name="extrafieldsvalues_old[{{ $extra->id }}]" />
                                                <label for="{{ $value }}">@lang('charityProject.' . $value)</label>
                                            </div>
                                        @empty
                                        @endforelse
                                        @if ($errors->has($extra->field->title))
                                        <span class="missiong-spam">{{ $errors->first($extra->field->title) }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif
                    @empty
                    @endforelse
                @endif

                @if($project_types != $charityProject->project_types)
                    @forelse($extrafields as $key=> $field)
                        @if($field->type == "INPUT")
                            <div class="col-12">
                                <div class="mb-3 row">
                                    <label for="example-extrafieldsvalues[{{ $field->title }}]-input" class="col-sm-12 col-form-label"> @lang('charityProject.' . $field->title) </label>
                                    <div class="col-sm-12">
                                        <input class="form-control {{ (empty($errors->first($field->title))) ?: 'has-error'  }}"  {{ $field->is_required? 'required':'' }} type="text" name="extrafieldsvalues[{{ $field->title }}]" wire:model="extrafieldsvalues.{{ $field->title }}" value="{{ @$extrafieldsvalues[ $field->title ] }}" >
                                        @if ($errors->has($field->title))
                                        <span class="missiong-spam">{{ $errors->first($field->title) }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @elseif($field->type == "INPUT_NUMBER")
                            <div class="col-12">
                                <div class="mb-3 row">
                                    <label for="extrafieldsvalues[{{ $field->title }}]" class="col-sm-12 col-form-label"> @lang('charityProject.' . $field->title) </label>
                                    <div class="col-sm-12">
                                        <input class="form-control {{ (empty($errors->first($field->title))) ?: 'has-error'  }}"  {{ $field->is_required? 'required':'' }} type="number" step="any" name="extrafieldsvalues[{{ $field->title }}]" wire:model="extrafieldsvalues.{{ $field->title }}" value="{{ @$extrafieldsvalues[ $field->title ] }}" >
                                        @if ($errors->has($field->title))
                                        <span class="missiong-spam">{{ $errors->first($field->title) }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @elseif($field->type == "TEXTAREA")
                            <div class="col-12">
                                <div class="mb-3 row">
                                    <label for="extrafieldsvalues[{{ $field->title }}]" class="col-sm-12 col-form-label"> @lang('charityProject.' . $field->title) </label>
                                    <div class="col-sm-12">
                                        <textarea  name="extrafieldsvalues[{{ $field->title }}]"  wire:model="extrafieldsvalues.{{ $field->title }}" value="{{ @$extrafieldsvalues[ $field->title ] }}"  {{ $field->is_required? 'required':'' }} cols="30" rows="10" class="form-control {{ (empty($errors->first($field->title))) ?: 'has-error'  }}">{{ @$extrafieldsvalues[ $field->title ]  }}</textarea>
                                        @if ($errors->has($field->title))
                                        <span class="missiong-spam">{{ $errors->first($field->title) }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @elseif($field->type == "SELECT_INPUT")
                            <div class="col-12">
                                <div class="mb-3 row">
                                    <label for="extrafieldsvalues-{{ $field->title }}-input" class="col-sm-12 col-form-label"> @lang('charityProject.' . $field->title) </label>
                                    <div class="col-sm-12">
                                        <select name="extrafieldsvalues[{{ $field->title }}]" wire:model="extrafieldsvalues.{{ $field->title }}"  {{ $field->is_required? 'required':'' }} class="form-control select2 {{ (empty($errors->first($field->title))) ?: 'has-error'  }}">
                                            <option value=""></option>
                                            @foreach( resolve($field->description)->get() as $key => $value)
                                                <option value="{{ $value->id }}">{{ $value->title }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has($field->title))
                                        <span class="missiong-spam">{{ $errors->first($field->title) }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @elseif($field->type == "IMAGE")
                            <div class="col-12">
                                <div class="mb-3 row">
                                    <label for="example-extrafieldsvalues-{{$field->title}}-input" class="col-sm-12 col-form-label"> @lang('charityProject.' . $field->title) </label>
                                    <div class="col-sm-12">
                                        <input class="form-control {{ (empty($errors->first($field->title))) ?: 'has-error'  }}"  {{ $field->is_required? 'required':'' }} type="file" name="extrafieldsvalues[{{ $field->title }}]" wire:model="extrafieldsvalues.{{ $field->title }}" value="{{ @$extrafieldsvalues[ $field->title ] }}" >
                                        @if ($errors->has($field->title))
                                        <span class="missiong-spam">{{ $errors->first($field->title) }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @elseif($field->type == "CHECKBOX")
                            <div class="col-12">
                                <div class="mb-3 row">
                                    <label for="example-extrafieldsvalues-input" class="col-sm-12 col-form-label"> @lang('charityProject.' . $field->title) </label>
                                    <div class="col-sm-12">
                                        @forelse(json_decode($field->description) as $value)
                                            <div>
                                                <input type="radio" id="{{ $value }}" value="{{ $value }}" name="extrafieldsvalues[{{ $field->title }}]" wire:model="extrafieldsvalues.{{ $field->title }}"/>
                                                <label for="{{ $value }}">@lang('charityProject.' . $value)</label>
                                            </div>
                                        @empty
                                        @endforelse
                                        @if ($errors->has($field->title))
                                        <span class="missiong-spam">{{ $errors->first($field->title) }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif
                    @empty
                    @endforelse
                @endif

                {{-- Type ------------------------------------------------------------------------------------- --}}
                <div class="row mb-3">
                    <label for="example-text-input" class="col-sm-12 col-form-label"> @lang('charityProject.type')  <span class="text-danger">*</span></label>
                    <div class="col-sm-12">
                        <select class="form-select " name="type" required wire:model="type" wire:change.prevent="updateType($event.target.value)" required>
                            <option value=""> {{ trans('charityProject.select_type') }}</option>
                            @foreach (App\Enums\LocationTypeEnum::labels() as $key => $type)
                            <option value="{{$type}}" {{ $type  == $key ? 'selected': '' }}>
                                {{ $type }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    @error('type')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                {{-- --------------Payment Methoed----------------------------- --}}
                @if($paymentExist)
                    <div class="row mt-3">
                        <label class="col-sm-12 col-form-label" for="available">
                            @lang('charityProject.payment_method') <span class="text-danger">*</span>
                        </label>
                        <div class="col-sm-10">
                            <div class="form-check">
                                @foreach ($payments as $key => $item)
                                <div class="col-md-6">
                                    <input class="form-check-input" type="checkbox" value="{{ $item->id }}" id="flexCheckDefault{{ $key }}" name="payment_method[]" {{ in_array($item->id, $charityProject->payment?->pluck('payment_id')->toArray()??[]) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="flexCheckDefault{{ $key }} ">{{ $item->trans->where('locale', $current_lang)->first()->title }}</label>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @if ($errors->has('payment_method'))
                        <span class="missiong-spam">{{ $errors->first('payment_method') }}</span>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- Setting Post   ------------------------------------------------------------------------------------------------------ --}}
<div class="mt-4 mb-4 accordion" id="accordionExamplePost">
    <div class="border rounded accordion-item">
        <h2 class="accordion-header" id="headingPost">
            <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#settings_post" aria-expanded="true" aria-controls="settings_post">
                {{ trans('charityProject.settings_post') }}
            </button>
        </h2>
        <div id="settings_post" class="accordion-collapse collapse " aria-labelledby="headingPost" data-bs-parent="#accordionExamplePost">
            <div class="accordion-body">
                <div class="row">
                    {{-- sort -------------------------------------------------------------------------------------  --}}
                    <div class="col-12">
                        <div class="mb-3 row">
                            <label for="example-number-input" class="col-sm-12 col-form-label">
                                @lang('charityProject.sort') </label>
                            <div class="col-sm-12">
                                <input class="form-control  {{ (empty($errors->first('sort'))) ?: 'has-error'}}" type="number" id="example-number-input" name="sort" value="{{ $charityProject->sort }}">
                                @if ($errors->has('sort'))
                                <span class="missiong-spam">{{ $errors->first('sort') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    {{-- Start Date   ------------------------------------------------------------------------------------- --}}
                    <div class="col-12 ">
                        <div class="mb-3 row">
                            <label for="example-number-input" class="col-sm-12 col-form-label">
                                @lang('charityProject.start_date') </label>
                            <div class="col-sm-12">
                                <input class="form-control  {{ (empty($errors->first('start_date'))) ?: 'has-error'}}" type="date" id="example-number-input" name="start_date" value="{{ $charityProject->start_date }}">
                                @if ($errors->has('start_date'))
                                <span class="missiong-spam">{{ $errors->first('start_date') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    {{-- End Date ------------------------------------------------------------------------------------- --}}
                    <div class="col-12">
                        <div class="mb-3 row">
                            <label for="example-number-input" class="col-sm-12 col-form-label">
                                @lang('charityProject.end_date') : </label>
                            <div class="col-sm-12">
                                <input class="form-control {{ (empty($errors->first('end_date'))) ?: 'has-error'}}" type="date" id="example-number-input" name="end_date" value="{{ $charityProject->end_date }}">
                                @if ($errors->has('end_date'))
                                <span class="missiong-spam">{{ $errors->first('end_date') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="m-auto row ">
                    {{-- -------------------status------------------------------ --}}
                    <div class="col-sm-6 mt-3">
                        <label class="form-check-label" for="flexSwitchCheckSuccessStatus">@lang('admin.status')</label>
                        <div class="form-check form-switch form-check-success">
                            <input class="form-check-input {{ (empty($errors->first('status'))) ?: 'has-error'}}" type="checkbox" role="switch" name="status" {{  $charityProject->status == 1 ? 'checked' : '' }} id="flexSwitchCheckSuccessStatus">
                            @if ($errors->has('status'))
                            <span class="missiong-spam">{{ $errors->first('status') }}</span>
                            @endif
                        </div>
                    </div>
                    {{-- ----------------------featuer------------------------ --}}
                    <div class="col-sm-6 mt-3">
                        <label class="form-check-label" for="flexSwitchCheckSuccessFeatuer">@lang('charityProject.featuer')</label>
                        <div class="form-check form-switch form-check-success">
                            <input class="form-check-input {{ (empty($errors->first('featuer'))) ?: 'has-error'}}" type="checkbox" role="switch" name="featuer" {{  $charityProject->featuer == 1 ? 'checked' : '' }} id="flexSwitchCheckSuccessFeatuer">
                            @if ($errors->has('featuer'))
                            <span class="missiong-spam">{{ $errors->first('featuer') }}</span>
                            @endif
                        </div>
                    </div>
                    {{-- ----------------------finished------------------------ --}}
                    <div class="col-sm-6 mt-3">
                        <label class="form-check-label" for="flexSwitchCheckSuccessFinished">@lang('charityProject.finished')</label>
                        <div class="form-check form-switch form-check-success">
                            <input class="form-check-input {{ (empty($errors->first('finished'))) ?: 'has-error'}}" type="checkbox" role="switch" name="finished" {{  $charityProject->finished  == 1 ? 'checked' : '' }} id="flexSwitchCheckSuccessFinished">
                            @if ($errors->has('finished'))
                            <span class="missiong-spam">{{ $errors->first('finished') }}</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Payment method  --------------------------------------------------------------------------------------------------- --}}
<div class="mt-4 mb-4 accordion" id="accordionExamplePayments">
    <div class="border rounded accordion-item">
        <h2 class="accordion-header" id="headingPayments">
            <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#payment_method" aria-expanded="true" aria-controls="payment_method">
                {{ trans('charityProject.payment_method') }}
            </button>
        </h2>
        <div id="payment_method" class="accordion-collapse collapse show" aria-labelledby="headingPayments" data-bs-parent="#accordionExamplePayments">
            <div class="accordion-body">
                {{-- donation_type   ------------------------------------------------------------------------------------- --}}
                <div class="mb-3 row title-section">
                    <label for="example-text-input" class="col-sm-12 col-form-label">@lang('charityProject.donation_type')</label>
                    <div class="col-sm-12">
                        <select class="form-select form-select-sm" name="donation_type" wire:model="donation_type" aria-label=".form-select-sm example" id="denation-type">
                            <option value="">@lang('charityProject.donation_type')</option>
                            @foreach (App\Enums\DonationTypeEnum::values() as $key => $value)
                            <option value="{{ $key }}" {{ $key==@$donation['type'] ? 'selected' : '' }}> {{ $value  }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                {{-- ------------------ Start forms donation_type ------------------- --}}
                 {{-- Start input share Value --}}
                 <div class="row mb-3  {{ $donation_type == 'share' ? '' : 'd-none' }}" id="section-share-value">
                    <div>
                        @foreach ($inputsShare as $key => $value)
                        <div>
                            <div class="row">
                                <div class="col-5">
                                    <div class="mb-3">
                                        <label for="example-share_name{{ $key }}-input"> @lang('charityProject.donation_name_share')</label>
                                        <div class="col-sm-12">
                                            <input type="text" name="share_name[{{ $key }}]" wire:model="share_name.{{ $key }}" class="form-control" required value="{{ @$share_name[$key] }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-5">
                                    <div class="mb-3">
                                        <label for="example-share_value{{ $key }}-input"> @lang('charityProject.donation_value_share')</label>
                                        <div class="col-sm-12">
                                            <input type="number" name="share_value[{{ $key }}]" wire:model="share_value.{{ $key }}" class="form-control" required value="{{ @$share_value[$key] }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <button type="button" class="delete_ads btn btn-neutral text-danger btn-sm mt-3" wire:click="removeShareInput({{ $key }})"><i class="fadeIn animated bx bx-x-circle"></i></button>
                                </div>
                                <hr>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <button type="button" class="mt-2 btn btn-success form-control  btn-sm" wire:click="addShareInput">
                        <i class="bx bx-plus-medical fs-5"></i>
                    </button>
                </div>
                {{-- End input share Value --}}
                {{-- Start input Fixed Value --}}
                <div class="mb-3 {{ $donation_type == 'fixed' ? '' : 'd-none' }}" id="section-fixed-value">
                    <div class="col-12">
                        <label for="example-fixed_value-input" class="col-sm-12 col-form-label">
                            @lang('charityProject.fiexd_value')</label>
                        <div class="col-sm-12">
                            <input class="form-control" type="number" id="fixed-value" name="fixed_value" value="{{ $fixed_value }}" min="0">
                        </div>
                    </div>
                </div>
                {{-- End input Fixed Value --}}
                {{-- Start input donation Value --}}
                <div class="row mb-3 {{  $donation_type  == 'unit' ? '' : 'd-none' }}" id="section-donation-value">
                    <div id="donation_section">
                        <div>
                            @foreach ($inputsUnit as $key => $value)
                            <div>
                                <div class="row">
                                    <div class="col-5">
                                        <div class="mb-3">
                                            <label for="example-donation_name{{ $key }}-input"> @lang('charityProject.donation_name')</label>
                                            <div class="col-sm-12">
                                                <input type="text" name="donation_name[{{ $key }}]" wire:model="donation_name.{{ $key }}" class="form-control" required value="{{ @$donation_name[$key] }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-5">
                                        <div class="mb-3">
                                            <label for="example-donation_value{{ $key }}-input"> @lang('charityProject.donation_value')</label>
                                            <div class="col-sm-12">
                                                <input type="number" name="donation_value[{{ $key }}]" wire:model="donation_value.{{ $key }}" class="form-control" required value="{{ @$donation_value[$key]  }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <button type="button" class="delete_ads btn btn-neutral text-danger btn-sm mt-3" wire:click="removeUnitInput({{ $key }})"><i class="fadeIn animated bx bx-x-circle"></i></button>
                                    </div>
                                    <hr>
                                </div>
                            </div>
                            @endforeach
                            <button type="button" class="mt-2 btn btn-success form-control  btn-sm" wire:click="addUnitInput" id="add_ads_section">
                                <i class="bx bx-plus-medical fs-5"></i>
                            </button>
                        </div>
                    </div>
                </div>
                {{-- ------------------ End forms donation_type ------------------- --}}

                {{-- target_price  ------------------------------------------------------------------------------------- --}}
                <div class="col-12">
                    <div class="mb-3 row">
                        <label for="example-number-input" class="col-sm-12 col-form-label">
                            @lang('charityProject.target_price') </label>
                        <div class="col-sm-12">
                            <input class="form-control {{ (empty($errors->first('target_price'))) ?: 'has-error'}}" type="number" id="example-number-input" name="target_price" value="{{ $charityProject->target_price }}">
                            @if ($errors->has('target_price'))
                            <span class="missiong-spam">{{ $errors->first('target_price') }}</span>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- target_unit  ------------------------------------------------------------------------------------- --}}
                <div class="col-12">
                    <label class="col-sm-12 col-form-label" for="available">@lang('charityProject.target_unit')
                    </label>
                    <div class="col-sm-12">
                        <input class="form-control  {{ (empty($errors->first('target_unit'))) ?: 'has-error'}}" name="target_unit" type="text" value="{{ $charityProject->target_unit }}">
                        @if ($errors->has('target_unit'))
                        <span class="missiong-spam">{{ $errors->first('target_unit') }}</span>
                        @endif
                    </div>
                </div>

                {{-- unit_price  ------------------------------------------------------------------------------------- --}}
                @foreach ($languages as $key => $locale)
                <div class="mb-3 row">
                    <label for="example-text-input" class="col-sm-12 col-form-label">{{ trans('charityProject.unit_price_in') . trans('lang.' . Locale::getDisplayName($locale)) }}</label>
                    <div class="col-sm-12">
                        <input class="form-control  {{ (empty($errors->first('unit_price'))) ?: 'has-error'}}" type="text" name="{{ $locale }}[unit_price]" value="{{ @$charityProject->trans->where('locale', $locale)->first()->unit_price }}" id="unit_price{{ $key }}">
                    </div>
                    @if ($errors->has($locale . '.unit_price'))
                    <span class="missiong-spam">{{ $errors->first($locale . '.unit_price') }}</span>
                    @endif
                </div>
                @endforeach

                {{-- fake_target ------------------------------------------------------------------------------------- --}}
                <div class="col-12">
                    <label class="col-sm-12 col-form-label" for="available"> @lang('charityProject.fake_target') </label>
                    <div class="col-sm-12">
                        <input class="form-control {{ (empty($errors->first('fake_target'))) ?: 'has-error'}}" name="fake_target" type="number" value="{{ $charityProject->fake_target }}">
                        @if ($errors->has('fake_target'))
                        <span class="missiong-spam">{{ $errors->first($locale . '.fake_target') }}</span>
                        @endif
                    </div>
                </div>

                {{-- --------------Payment Methoed----------------------------- --}}
                @if(Route::is('admin.charity.single-projects.edit'))
                <div class="col-12">
                    <label class="col-sm-12 col-form-label" for="available">@lang('charityProject.payment_method')</label>
                    <div class="col-sm-10">
                        <div class="form-check">
                            @foreach ($payments as $key => $item)
                            <div class="col-md-12">
                                <input class="form-check-input" type="checkbox" value="{{ $item->id }}" id="flexCheckDefault{{ $key }}" name="payment_method[]" {{ in_array($item->id,$charityProject->payment->pluck('payment_id')->toArray()) ? 'checked' : '' }}>
                                <label class="form-check-label" for="flexCheckDefault{{ $key }} ">{{
                                        $item->trans->where('locale', $current_lang)->first()->title }}</label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @if ($errors->has('payment_method'))
                    <span class="missiong-spam">{{ $errors->first('payment_method') }}</span>
                    @endif
                </div>
                @endif

            </div>
        </div>
    </div>
</div></div>
