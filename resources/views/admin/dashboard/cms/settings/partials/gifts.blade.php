@extends('admin.app')

@section('title', trans('settings.edit', ['name' => $settingMain->title]))
@section('title_page', trans('settings.settings'))
@section('title_route', route('admin.settings.index'))
@section('button_page')
    <a href="{{ route('admin.settings.index') }}"
        class="btn btn-outline-primary waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
@endsection

@section('content')

    <form class="form-horizontal" action="{{ route('admin.settings.update-custom', $settingMain->key) }}" method="POST"
        enctype="multipart/form-data" role="form">
        @csrf

        <input type="hidden" id="deleted_items" name="deleted_items" value="">

        <div class="row text-center mt-5 mb-3">
            <label class="col-sm-2 col-form-label"> @lang('settings.title_setting') </label>
            <div class="col-sm-10">
                <input class="form-control" type="text" name="title" value="{{ @$settings['title'] }}" required>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="accordion mt-4 mb-4" id="accordionExample">
                    <div class="accordion-item border rounded">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                @lang('settings.information')
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse show mt-3" aria-labelledby="headingOne"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                @foreach ($languages as $key => $locale)
                                    {{-- meta_title_ ------------------------------------------------------------------------------------- --}}
                                    <div class="row mb-3">
                                        <label for="example-text-input"
                                            class="col-sm-2 col-form-label">{{ trans('admin.title') . trans('lang.' . Locale::getDisplayName($locale)) }}</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" type="text" name="gift_title_{{ $locale }}"
                                                value="{{ @$settings['gift_title_' . $locale] }}"
                                                id="title{{ $key }}">
                                        </div>
                                    </div>

                                    {{-- meta_description_ ------------------------------------------------------------------------------------- --}}
                                    <div class="row">
                                        <div class="col-2"></div>
                                        <div class="form-group col-10 mb-3">
                                            <br>
                                            <button type="button" class="btn btn-primary"
                                                onclick="$('#msg{{ $key }}').val($('#msg{{ $key }}').val() +'[[giver_name]]') ;return false;"
                                                value=""> @lang('settings.giver_name') </button>
                                            <button type="button" class="btn btn-primary"
                                                onclick="$('#msg{{ $key }}').val($('#msg{{ $key }}').val() +'[[from_name]]') ;return false;"
                                                value=""> @lang('settings.given_name') </button>
                                            <button type="button" class="btn btn-primary"
                                                onclick="$('#msg{{ $key }}').val($('#msg{{ $key }}').val() +'[[giver_group]]') ;return false;"
                                                value=""> @lang('settings.gift_type') </button>
                                            <button type="button" class="btn btn-primary"
                                                onclick="$('#msg{{ $key }}').val($('#msg{{ $key }}').val() +'[[card]]') ;return false;"
                                                value=""> @lang('settings.attach_card') </button>
                                            <button type="button" class="btn btn-primary"
                                                onclick="$('#msg{{ $key }}').val($('#msg{{ $key }}').val() +'[[project]]') ;return false;"
                                                value=""> @lang('settings.attach_project') </button>
                                            <small class="red "> @lang('settings.change_description_value') </small>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="example-text-input" class="col-sm-2 col-form-label">
                                            {{ trans('settings.gift_description') . trans('lang.' . Locale::getDisplayName($locale)) }}
                                        </label>
                                        <div class="col-sm-10 mb-2">
                                            <textarea name="gift_description_{{ $locale }}" class="form-control" rows="9" id="msg{{ $key }}"> {{ @$settings['gift_description_' . $locale] }} </textarea>
                                        </div>
                                    </div>

                                    <hr>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <div class="accordion mt-4 mb-4 " id="accordionExampletypes">
                    <div class="accordion-item border rounded ">
                        <h2 class="accordion-header" id="headingTypes">
                            <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseTypes" aria-expanded="true" aria-controls="collapseTypes">
                                {{ trans('settings.gift_categories') }}
                            </button>
                        </h2>

                        <div id="collapseTypes" class="accordion-collapse collapse show mt-3" aria-labelledby="headingTypes"
                            data-bs-parent="#accordionExampletypes">
                            <div class="accordion-body">
                                <div class="row">
                                   <div id="gift-filed">
                                    @php $index = 0; @endphp
    @if (@$settings['gift_category'])
        @forelse (json_decode(@$settings['gift_category']) as $key => $item)
        @php $index ++ @endphp
            <div class="row gift-field-item mb-2 item_{{ $key }}" data-original-key="{{ $key }}">
                <div class="col-md-3">
                    <label for="example-email-input" class="col-form-label">
                        {{ trans('settings.category_title') . trans('lang.' . Locale::getDisplayName('en')) }}
                    </label>
                    <input type="text" class="form-control"
                        name="gift_category[{{ $key }}][title_en]"
                        value="{{ @$item->title_en }}">
                </div>
                <div class="col-md-3">
                    <label for="example-email-input" class="col-form-label">
                        {{ trans('settings.category_title') . trans('lang.' . Locale::getDisplayName('ar')) }}
                    </label>
                    <input type="text" class="form-control"
                        name="gift_category[{{ $key }}][title_ar]"
                        value="{{ @$item->title_ar }}">
                </div>
                <div class="col-md-5">
                    <label class="control-label col-form-label"
                        for="imageUpload">@lang('admin.images') </label>
                    <div class="">
                        <input type="file" id="gift_category{{ $key }}"
                            name="gift_category[{{ $key }}][newimages][]"
                            accept="image/*" multiple class="form-control">
                        <div id="imagePreviews{{ $key }}"></div>

                        <input type="hidden"
                            name="gift_category[{{ $key }}][images]"
                            value="{{ @$item->images }}">
                    </div>
                </div>
                @if($index != 1)
                <div class="col-md-1 mt-5">
                    <a href="#" class="text-danger h3 fa-lg remove-row" 
                        data-item-id="{{ $key }}"> 
                        <i class="bx bx-trash"></i>
                    </a>
                </div>
                @endif
                <div class="col-md-10 mb-2">
                    <div class="row">
                        @forelse(json_decode(@$item->images) ?? [] as $img)
                            <div class="col-md-1">
                                <a href="{{ getImage($img) }}" target="_blank">
                                    <img class="img-fluid"
                                        src="{{ asset(getImage($img)) }}"
                                        alt="" width="">
                                </a>
                            </div>
                        @empty
                        @endforelse
                    </div>
                </div>
                <hr />
            </div>
        @empty
        @endforelse
    @endif
</div>
                                </div>
                                <div class="row">
                                    <button type="button" class="add-gift-filed btn btn-success">اضافة فئة جديدة</button>
                                </div>
                                <div class="row mb-3">
                                    <label for="sender_x" class="col-sm-2 col-form-label">موقع اسم المرسل أفقيًا
                                        (%)</label>
                                    <div class="col-sm-10">
                                        <input type="number" name="sender_x" class="form-control"
                                            value="{{ @$settings['sender_x'] }}" min="0" max="100">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="sender_y" class="col-sm-2 col-form-label">موقع اسم المرسل عموديًا
                                        (%)</label>
                                    <div class="col-sm-10">
                                        <input type="number" name="sender_y" class="form-control"
                                            value="{{ @$settings['sender_y'] }}" min="0" max="100">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="recipient_x" class="col-sm-2 col-form-label">موقع اسم المستقبل أفقيًا
                                        (%)</label>
                                    <div class="col-sm-10">
                                        <input type="number" name="recipient_x" class="form-control"
                                            value="{{ @$settings['recipient_x'] }}" min="0" max="100">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="recipient_y" class="col-sm-2 col-form-label">موقع اسم المستقبل عموديًا
                                        (%)</label>
                                    <div class="col-sm-10">
                                        <input type="number" name="recipient_y" class="col-sm-10 form-control"
                                            value="{{ @$settings['recipient_y'] }}" min="0" max="100">
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
                <a href="{{ route('admin.settings.index') }}"
                    class="btn btn-outline-primary waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
                <button type="submit"
                    class="btn btn-outline-success waves-effect waves-light ml-3 btn-sm">@lang('button.save')</button>
            </div>
        </div>
    </form>

@endsection

@section('script')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
      $(document).ready(function() {
    var max_fields = 20;
    var giftSection = $("#gift-filed");
    var add_button = $(".add-gift-filed");
    var uniqueId = Date.now();
    var deletedItems = [];

    bindRemoveEvents();

    function bindRemoveEvents() {
        $('.remove-row').off('click');
        
        $('.remove-row').on('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            console.log('تم النقر على زر الحذف');
            
            var itemId = $(this).data('item-id');
            var itemElement = null;
            
            var searchPatterns = [
                '.item_' + itemId,           
                '[class*="item_' + itemId + '"]', 
                '.gift-field-item[data-original-key="' + itemId + '"]',  
                '.row[data-original-key="' + itemId + '"]'
            ];
            
            for (var i = 0; i < searchPatterns.length; i++) {
                itemElement = $(searchPatterns[i]);
                if (itemElement.length > 0) {
                    console.log('تم العثور على العنصر باستخدام:', searchPatterns[i]);
                    break;
                }
            }
            
            if (!itemElement || itemElement.length === 0) {
                itemElement = $(this).closest('.row').filter(function() {
                    return $(this).find('input[name*="gift_category"]').length > 0;
                });
                
                if (itemElement.length === 0) {
                    itemElement = $(this).parents('.row').filter(function() {
                        return $(this).find('input[name*="gift_category"]').length > 0;
                    }).first();
                }
            }
            
            console.log('العنصر المراد حذفه:', itemElement);
            console.log('عدد العناصر الموجودة:', itemElement.length);
            
            if (!itemElement || itemElement.length === 0) {
                console.error('لم يتم العثور على العنصر المراد حذفه');
                return false;
            }
            
            // الحصول على المفاتيح
            var originalKey = itemElement.attr('data-original-key') || itemId;
            var isNew = itemElement.attr('data-is-new');
            
            console.log('بيانات العنصر:', {
                originalKey: originalKey,
                isNew: isNew,
                itemId: itemId,
                element: itemElement[0]
            });
            
            if (originalKey && isNew !== 'true') {
                if (deletedItems.indexOf(originalKey) === -1) {
                    deletedItems.push(originalKey);
                }
                $('#deleted_items').val(JSON.stringify(deletedItems));
                console.log('تم إضافة للحذف:', originalKey);
                console.log('قائمة المحذوفات:', deletedItems);
            }
            
            itemElement.fadeOut(300, function() {
                $(this).remove();
                console.log('تم حذف العنصر من الواجهة');
                
                setTimeout(function() {
                    bindRemoveEvents();
                }, 100);
            });
            
            return false;
        });
    }

    $(add_button).click(function(e) {
        e.preventDefault();
        
        var currentCount = $('#gift-filed').find('input[name*="gift_category"][name*="title_en"]').length;
        
        console.log('عدد العناصر الحالي:', currentCount);
        
        if (currentCount < max_fields) {
            uniqueId++;
            
            const newField = `
            <div class="row gift-field-item mb-2 item_${uniqueId}" data-is-new="true" data-original-key="${uniqueId}" style="display: none;">
               <div class="col-md-3">
                   <label class="col-form-label">{{ trans('settings.category_title') . trans('lang.' . Locale::getDisplayName('en')) }}</label>
                   <input type="text" class="form-control" name="gift_category[${uniqueId}][title_en]">
               </div>
               <div class="col-md-3">
                   <label class="col-form-label">{{ trans('settings.category_title') . trans('lang.' . Locale::getDisplayName('ar')) }}</label>
                   <input type="text" class="form-control" name="gift_category[${uniqueId}][title_ar]">
               </div>
               <div class="col-md-5"> 
                   <label class="control-label">@lang('admin.images')</label> 
                   <input type="file" id="gift_category${uniqueId}" name="gift_category[${uniqueId}][newimages][]" accept="image/*" multiple class="form-control">
                   <div id="imagePreviews${uniqueId}"></div>
               </div>
               <div class="col-md-1 mt-5">
                   <a href="#" class="text-danger h3 fa-lg remove-row" data-item-id="${uniqueId}">
                       <i class="bx bx-trash"></i>
                   </a>
               </div>
               <div class="col-md-10 mb-2">
                   <div class="row" id="existingImages${uniqueId}">
                       <!-- الصور الموجودة ستظهر هنا -->
                   </div>
               </div>
               <hr/>
            </div>`;
            
            var newElement = $(newField);
            $(giftSection).append(newElement);
            
            newElement.fadeIn(300, function() {
                setupImagePreview(uniqueId);
                bindRemoveEvents();
            });
            
        } else {
            alert('لا يمكن إضافة أكثر من ' + max_fields + ' فئة');
        }
    });

    function setupImagePreview(id) {
        $(`#gift_category${id}`).off('change').on('change', function() {
            const files = this.files;
            const previewsContainer = $(`#imagePreviews${id}`);
            previewsContainer.html('');
            
            if (files && files.length > 0) {
                for (let i = 0; i < files.length; i++) {
                    const file = files[i];
                    if (file.type.startsWith('image/')) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            const img = $('<img>');
                            img.attr('src', e.target.result);
                            img.css({
                                'max-width': '100px',
                                'max-height': '100px',
                                'margin-right': '5px',
                                'margin-top': '10px',
                                'border': '1px solid #ddd',
                                'border-radius': '4px',
                                'object-fit': 'cover'
                            });
                            previewsContainer.append(img);
                        }
                        reader.readAsDataURL(file);
                    }
                }
            }
        });
    }

    @if (@$settings['gift_category'])
        @foreach (json_decode(@$settings['gift_category']) as $key => $item)
            setupImagePreview('{{ $key }}');
        @endforeach
    @endif

    $('form').on('submit', function() {
        $('#deleted_items').val(JSON.stringify(deletedItems));
        console.log('إرسال النموذج مع العناصر المحذوفة:', deletedItems);
        return true;
    });

    window.debugGiftFields = function() {
        console.log('=== Debug Gift Fields ===');
        console.log('Total rows in gift-filed:', $('#gift-filed .row').length);
        console.log('Rows with gift_category inputs:', $('#gift-filed').find('input[name*="gift_category"][name*="title_en"]').length);
        console.log('Remove buttons:', $('.remove-row').length);
        console.log('Deleted items:', deletedItems);
        
        $('.remove-row').each(function(index, element) {
            var $el = $(element);
            console.log('Remove button', index, ':', {
                'data-item-id': $el.data('item-id'),
                'closest row classes': $el.closest('.row').attr('class')
            });
        });
    };
    
    $(document).on('error', function(e) {
        console.error('خطأ في الصفحة:', e);
    });
    
    console.log('تم تحميل JavaScript بنجاح');
});
    </script>
@endsection