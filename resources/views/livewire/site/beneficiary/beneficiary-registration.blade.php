<main>
    <div class="registration-container">
        <div class="registration-content">
            <h1 class="registration-title">تسجيل حساب مستفيد جديد</h1>

            <div class="registration-notice">
                <p>لايمكنك التسجيل لأكثر من مرة. ولابد أن تتحرى الدقة في تسجيل البيانات. لا يمكن اعتمدنا بيانات مغلوطة
                    أو غير دقيقة. ولا تستحق باحد في ذلك. في حالة إذا استخدمت بيانات غير دقيقة أو مغلوطة فإنك تعرض نفسك
                    للجزاء القانوني. استخدامك بيانات غير صحيحة يعتبر تضليل.</p>
            </div>

            <form wire:submit.prevent="submit" class="registration-form">
                <div class="form-section">
                    <h2 class="section-title">المعلومات الشخصية</h2>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="form-group labeled-input">
                                <span class="field-label">الاسم الأول</span>
                                <input type="text" class="form-control" wire:model="first_name">
                            </div>
                            @error('first_name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror

                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="form-group labeled-input">
                                <span class="field-label">الاسم الأوسط</span>
                                <input type="text" class="form-control" wire:model="middle_name">
                            </div>
                            @error('middle_name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror

                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="form-group labeled-input">
                                <span class="field-label">الاسم الأخير</span>
                                <input type="text" class="form-control" wire:model="last_name">
                            </div>
                            @error('last_name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror

                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="form-group labeled-input">
                                <span class="field-label">الجنس</span>
                                <select class="form-select" wire:model="gender">
                                    <option value="">اختر</option>
                                    <option value="male">ذكر</option>
                                    <option value="female">أنثى</option>
                                </select>
                            </div>
                            @error('gender')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror

                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="form-group labeled-input">
                                <span class="field-label">الجنسية</span>
                                <select class="form-select" wire:model="nationality">
                                    <option value="">اختر</option>
                                    <option value="saudi">سعودي</option>
                                    <option value="eritrea">إرتريا</option>
                                    <option value="other">أخرى</option>
                                </select>
                            </div>
                            @error('nationality')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror

                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="form-group labeled-input">
                                <span class="field-label">الحالة الاجتماعية</span>
                                <select class="form-select" wire:model="marital_status">
                                    <option value="">اختر</option>
                                    <option value="single">أعزب</option>
                                    <option value="married">متزوج</option>
                                    <option value="divorced">مطلق</option>
                                    <option value="widowed">أرمل</option>
                                </select>
                            </div>
                            @error('marital_status')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror

                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="form-group labeled-input">
                                <span class="field-label">رقم الهاتف</span>
                                <input type="tel" class="form-control" wire:model="phone">
                            </div>
                            @error('phone')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror

                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="form-group labeled-input">
                                <span class="field-label">تاريخ الميلاد</span>
                                <input type="date" class="form-control" wire:model="date_of_birth">
                            </div>
                            @error('date_of_birth')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror

                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="form-group labeled-input">
                                <span class="field-label">عدد أفراد الأسرة</span>
                                <select class="form-select" wire:model="family_members">
                                    <option value="">اختر</option>
                                    @for ($i = 1; $i <= 10; $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                    <option value="10+">10+</option>
                                </select>
                            </div>
                            @error('family_members')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror

                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="form-group labeled-input">
                                <span class="field-label">المستوى التعليمي</span>
                                <select class="form-select" wire:model="education_level">
                                    <option value="">اختر</option>
                                    <option value="illiterate">أمي</option>
                                    <option value="primary">ابتدائي</option>
                                    <option value="intermediate">متوسط</option>
                                    <option value="secondary">ثانوي</option>
                                    <option value="university">جامعي</option>
                                </select>
                            </div>
                            @error('education_level')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror

                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="form-group labeled-input">
                                <span class="field-label">المدينة</span>
                                <input type="text" class="form-control" wire:model="city">
                            </div>
                            @error('city')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror

                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="form-group labeled-input">
                                <span class="field-label">الحي</span>
                                <input type="text" class="form-control" wire:model="district">
                            </div>
                            @error('district')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror

                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="form-group labeled-input">
                                <span class="field-label">رقم الهوية</span>
                                <input type="text" class="form-control" wire:model="id_number">
                            </div>
                            @error('id_number')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror

                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="form-group labeled-input">
                                <span class="field-label">السجل المدني</span>
                                <input type="text" class="form-control" wire:model="civil_register">
                            </div>
                            @error('civil_register')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror

                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="form-group labeled-input">
                                <span class="field-label">البريد الإلكتروني</span>
                                <input type="email" class="form-control" wire:model="email">
                            </div>
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror

                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <h2 class="section-title">الوضع الاجتماعي</h2>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="form-group labeled-input">
                                <span class="field-label">حالة السكن</span>
                                <select class="form-select" wire:model="housing_status">
                                    <option value="">اختر</option>
                                    <option value="owned">ملك</option>
                                    <option value="rented">إيجار</option>
                                    <option value="shared">مشترك</option>
                                </select>
                            </div>
                            @error('housing_status')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror

                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="form-group labeled-input">
                                <span class="field-label">نوع الوظيفة</span>
                                <input type="text" class="form-control" wire:model="job_type">
                            </div>
                            @error('job_type')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror

                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="form-group labeled-input">
                                <span class="field-label">الدخل الشهري</span>
                                <input type="text" class="form-control" wire:model="monthly_income">
                            </div>
                            @error('monthly_income')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror

                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="form-group labeled-input">
                                <span class="field-label">تسجيل سابق؟</span>
                                <select class="form-select" wire:model="previous_registration">
                                    <option value="">اختر</option>
                                    <option value="yes">نعم</option>
                                    <option value="no">لا</option>
                                </select>
                            </div>
                            @error('previous_registration')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror

                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="form-group labeled-input">
                                <span class="field-label">أمراض مزمنة؟</span>
                                <select class="form-select" wire:model="chronic_diseases">
                                    <option value="">اختر</option>
                                    <option value="yes">نعم</option>
                                    <option value="no">لا</option>
                                </select>
                            </div>
                            @error('chronic_diseases')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror

                        </div>

                        
                        <div class="col-md-4 mb-3">
                            <div class="form-group labeled-input">
                                <span class="field-label">احتياجات خاصة؟</span>
                                <select class="form-select" wire:model="special_needs">
                                    <option value="">اختر</option>
                                    <option value="yes">نعم</option>
                                    <option value="no">لا</option>
                                </select>
                            </div>
                            @error('special_needs')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror

                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group labeled-input">
                                <span class="field-label">دخل آخر</span>
                                <textarea class="form-control" wire:model="other_income"></textarea>
                            </div>
                            @error('other_income')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror

                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group labeled-input">
                                <span class="field-label">ملاحظات إضافية</span>
                                <textarea class="form-control" wire:model="additional_notes"></textarea>
                            </div>
                            @error('additional_notes')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror

                        </div>
                    </div>
                </div>

                <div class="form-check mb-4">
                    <input class="form-check-input" type="checkbox" wire:model="agreement" id="termsAgreement">
                    <label class="form-check-label" for="termsAgreement">
                        أتعهد بأن جميع البيانات المقدمة صحيحة و دقيقة و غير مغلوطة
                    </label>
                </div>
                @error('agreement')
                    <span class="text-danger">{{ $message }}</span>
                @enderror


                <div class="text-center">
                    <button type="submit" class="btn btn-primary submit-btn">الاستمرار</button>
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
