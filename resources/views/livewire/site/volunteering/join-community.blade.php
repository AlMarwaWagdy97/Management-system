<main>
    <div class="registration-container">
        <div class="registration-content">
            <h1 class="registration-title">تسجيل متطوع جديد</h1>

            <div class="registration-notice">
                <p>لايمكنك التسجيل لأكثر من مرة. ولابد أن تتحرى الدقة في تسجيل البيانات. لا يمكن اتمامنا بيانات مغلوطة
                    أو غير دقيقة. ولا تستعن بأحد في ذلك. في حالة إذا استخدمت بيانات غير دقيقة أو مغلوطة فإنك تعرض نفسك
                    للجزاء القانوني. استخدامك بيانات غير صحيحة يعتبر تضليل.</p>
            </div>

            <form wire:submit.prevent="submit">
                <!-- Personal Information Section -->
                <div class="form-section personal-info">
                    <h2 class="section-title">المعلومات الشخصية</h2>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="form-group labeled-input">
                                    <span class="field-label">الاسم الكامل</span>
                                    <input type="text" class="form-control" wire:model="name" >
                                

                            </div>
                            @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                        </div>
                             <div class="col-md-4 mb-3">
                            <div class="form-group labeled-input">
                                    <span class="field-label">البريد الإلكتروني</span>
                                    <input type="email" class="form-control" wire:model="email" >
                               

                            </div>
                             @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                        </div>
                                <div class="col-md-4 mb-3">
                            <div class="form-group labeled-input">
                                    <span class="field-label">رقم الجوال</span>
                                    <input type="tel" class="form-control" wire:model="mobile" >
                               

                            </div>
                             @error('mobile')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="form-group labeled-input">
                                    <span class="field-label">تاريخ الميلاد</span>
                                    <input type="date" class="form-control" wire:model="date_of_birth" >
                                

                            </div>
                            @error('date_of_birth')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="form-group labeled-input">
                                    <span class="field-label">الجنس</span>
                                    <select class="form-select" wire:model="gender" >
                                        <option value="">اختر</option>
                                        <option value="ذكر">ذكر</option>
                                        <option value="أنثى">أنثى</option>
                                    </select>
                                

                            </div>
                            @error('gender')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="form-group labeled-input">
                                    <span class="field-label">الجنسية</span>
                                    <select class="form-select" wire:model="nationality" >
                                        <option value="">اختر</option>
                                        <option value="السعودية">السعودية</option>
                                        <option value="مصر">مصر</option>
                                        <option value="الأردن">الأردن</option>
                                        <option value="الإمارات">الإمارات</option>
                                    </select>
                               

                            </div>
                             @error('nationality')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                        </div>
                    </div>

                    <div class="row">
                
                        <div class="col-md-4 mb-3">
                            <div class="form-group labeled-input">
                                    <span class="field-label">المؤهل الدراسي</span>
                                    <select class="form-select" wire:model="educational_qualification" >
                                        <option value="">اختر</option>
                                        <option value="متوسطة">متوسطة</option>
                                        <option value="ثانوية">ثانوية</option>
                                        <option value="بكالوريوس">بكالوريوس</option>
                                        <option value="ماجستير">ماجستير</option>
                                        <option value="دكتوراه">دكتوراه</option>
                                    </select>
                               

                            </div>
                             @error('educational_qualification')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                        </div>
                         <div class="col-md-4 mb-3">
                            <div class="form-group labeled-input">
                                    <span class="field-label">رقم السجل المدني</span>
                                    <input type="text" class="form-control" wire:model="identity">
                                
                            </div>
                            @error('identity')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror

                        </div>
                   
                    </div>

                    <div class="row">
                       
                        {{-- <div class="col-md-4 mb-3">
                            <div class="form-group">
                                <div class="labeled-input">
                                    <span class="field-label">الصورة الشخصية</span>
                                    <input type="file" class="form-control" wire:model="image">
                                </div>
                                @error('image')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror

                            </div>
                        </div> --}}
                    </div>
                </div>

                <!-- Preferences Section -->
                <div class="form-section preferences">
                    <h2 class="section-title">التفضيلات</h2>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="form-group form-group-v px-4">
                                <h5 class="mb-3">المجالات التي ترغب بالتطوع فيها:</h5>
                                @foreach (['ميداني', 'اداري', 'اعلامي', 'علاقات عامة', 'تقني', 'تسويق رقمي', 'تصميم', 'خدمة المستفيدين', 'أخرى'] as $field)
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" wire:model="preferred_fields"
                                            value="{{ $field }}" id="field-{{ $field }}">
                                        <label class="form-check-label"
                                            for="field-{{ $field }}">{{ $field }}</label>
                                    </div>
                                @endforeach
                            </div>
                            @error('preferred_fields')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror

                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="form-group form-group-v">
                                <h5 class="mb-3">الفترة المفضلة:</h5>
                                @foreach (['صباحية', 'مسائية', 'نهاية الأسبوع', 'خلال موسم معين مثل رمضان الحج أو غيره'] as $time)
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" wire:model="preferred_times"
                                            value="{{ $time }}" id="time-{{ $time }}">
                                        <label class="form-check-label"
                                            for="time-{{ $time }}">{{ $time }}</label>
                                    </div>
                                @endforeach
                            </div>
                            @error('preferred_times')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror

                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="form-group form-group-v">
                                <h5 class="mb-3">الهدف من التطوع:</h5>
                                <textarea class="form-control" rows="10" wire:model="goal" placeholder="سجل ملاحظاتك هنا"></textarea>
                            </div>
                            @error('goal')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror

                        </div>
                    </div>
                </div>

                <div class="form-group mt-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" wire:model="agreement" id="agreement"
                            >
                        <label class="form-check-label" for="agreement">
                            أتعهد بأن جميع البيانات للخدمة صحيحة ودقيقة وغير مغلوطة
                        </label>
                    </div>
                    @error('agreement')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror

                </div>

                <div class="text-center mt-4">
                    <button type="submit" class="submit-btn">الاستمرار</button>
                </div>
            </form>

            @if (session()->has('success'))
                <div class="alert alert-success mt-3">
                    {{ session('success') }}
                </div>
            @endif
        </div>
    </div>
</main>
