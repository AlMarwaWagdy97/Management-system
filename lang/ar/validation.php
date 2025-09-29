<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'             => 'يجب قبول :attribute.',
    'active_url'           => ':attribute لا يُمثّل رابطًا صحيحًا.',
    'after'                => 'يجب على :attribute أن يكون تاريخًا لاحقًا للتاريخ :date.',
    'after_or_equal'       => ':attribute يجب أن يكون تاريخاً لاحقاً أو مطابقاً للتاريخ :date.',
    'alpha'                => 'يجب أن لا يحتوي :attribute سوى على حروف.',
    'alpha_dash'           => 'يجب أن لا يحتوي :attribute سوى على حروف، أرقام ومطّات.',
    'alpha_num'            => 'يجب أن يحتوي :attribute على حروفٍ وأرقامٍ فقط.',
    'array'                => 'يجب أن يكون :attribute ًمصفوفة.',
    'before'               => 'يجب على :attribute أن يكون تاريخًا سابقًا للتاريخ :date.',
    'before_or_equal'      => ':attribute يجب أن يكون تاريخا سابقا أو مطابقا للتاريخ :date.',
    'between'              => [
        'numeric' => 'يجب أن تكون قيمة :attribute بين :min و :max.',
        'file'    => 'يجب أن يكون حجم الملف :attribute بين :min و :max كيلوبايت.',
        'string'  => 'يجب أن يكون عدد حروف النّص :attribute بين :min و :max.',
        'array'   => 'يجب أن يحتوي :attribute على عدد من العناصر بين :min و :max.',
    ],
    'boolean'              => 'يجب أن تكون قيمة :attribute إما true أو false .',
    'confirmed'            => 'حقل التأكيد غير مُطابق للحقل :attribute.',
    'date'                 => ':attribute ليس تاريخًا صحيحًا.',
    'date_equals'          => 'يجب أن يكون :attribute مطابقاً للتاريخ :date.',
    'date_format'          => 'لا يتوافق :attribute مع الشكل :format.',
    'different'            => 'يجب أن يكون الحقلان :attribute و :other مُختلفين.',
    'digits'               => 'يجب أن يحتوي :attribute على :digits رقمًا/أرقام.',
    'digits_between'       => 'يجب أن يحتوي :attribute بين :min و :max رقمًا/أرقام .',
    'dimensions'           => 'الـ :attribute يحتوي على أبعاد صورة غير صالحة.',
    'distinct'             => 'للحقل :attribute قيمة مُكرّرة.',
    'email'                => 'يجب أن يكون :attribute عنوان بريد إلكتروني صحيح البُنية.',
    'ends_with'            => 'يجب أن ينتهي :attribute بأحد القيم التالية: :values',
    'exists'               => 'القيمة المحددة :attribute غير موجودة.',
    'file'                 => 'الـ :attribute يجب أن يكون ملفا.',
    'filled'               => ':attribute إجباري.',
    'gt'                   => [
        'numeric' => 'يجب أن تكون قيمة :attribute أكبر من :value.',
        'file'    => 'يجب أن يكون حجم الملف :attribute أكبر من :value كيلوبايت.',
        'string'  => 'يجب أن يكون طول النّص :attribute أكثر من :value حروفٍ/حرفًا.',
        'array'   => 'يجب أن يحتوي :attribute على أكثر من :value عناصر/عنصر.',
    ],
    'gte'                  => [
        'numeric' => 'يجب أن تكون قيمة :attribute مساوية أو أكبر من :value.',
        'file'    => 'يجب أن يكون حجم الملف :attribute على الأقل :value كيلوبايت.',
        'string'  => 'يجب أن يكون طول النص :attribute على الأقل :value حروفٍ/حرفًا.',
        'array'   => 'يجب أن يحتوي :attribute على الأقل على :value عُنصرًا/عناصر.',
    ],
    'image'                => 'يجب أن يكون :attribute صورةً.',
    'in'                   => ':attribute غير موجود.',
    'in_array'             => ':attribute غير موجود في :other.',
    'integer'              => 'يجب أن يكون :attribute عددًا صحيحًا.',
    'ip'                   => 'يجب أن يكون :attribute عنوان IP صحيحًا.',
    'ipv4'                 => 'يجب أن يكون :attribute عنوان IPv4 صحيحًا.',
    'ipv6'                 => 'يجب أن يكون :attribute عنوان IPv6 صحيحًا.',
    'json'                 => 'يجب أن يكون :attribute نصًا من نوع JSON.',
    'lt'                   => [
        'numeric' => 'يجب أن تكون قيمة :attribute أصغر من :value.',
        'file'    => 'يجب أن يكون حجم الملف :attribute أصغر من :value كيلوبايت.',
        'string'  => 'يجب أن يكون طول النّص :attribute أقل من :value حروفٍ/حرفًا.',
        'array'   => 'يجب أن يحتوي :attribute على أقل من :value عناصر/عنصر.',
    ],
    'lte'                  => [
        'numeric' => 'يجب أن تكون قيمة :attribute مساوية أو أصغر من :value.',
        'file'    => 'يجب أن لا يتجاوز حجم الملف :attribute :value كيلوبايت.',
        'string'  => 'يجب أن لا يتجاوز طول النّص :attribute :value حروفٍ/حرفًا.',
        'array'   => 'يجب أن لا يحتوي :attribute على أكثر من :value عناصر/عنصر.',
    ],
    'max'                  => [
        'numeric' => 'يجب أن تكون قيمة :attribute مساوية أو أصغر من :max.',
        'file'    => 'يجب أن لا يتجاوز حجم الملف :attribute :max كيلوبايت.',
        'string'  => 'يجب أن لا يتجاوز طول النّص :attribute :max حروفٍ/حرفًا.',
        'array'   => 'يجب أن لا يحتوي :attribute على أكثر من :max عناصر/عنصر.',
    ],
    'mimes'                => 'يجب أن يكون ملفًا من نوع : :values.',
    'mimetypes'            => 'يجب أن يكون ملفًا من نوع : :values.',
    'min'                  => [
        'numeric' => 'يجب أن تكون قيمة :attribute مساوية أو أكبر من :min.',
        'file'    => 'يجب أن يكون حجم الملف :attribute على الأقل :min كيلوبايت.',
        'string'  => 'يجب أن يكون طول النص :attribute على الأقل :min حروفٍ/حرفًا.',
        'array'   => 'يجب أن يحتوي :attribute على الأقل على :min عُنصرًا/عناصر.',
    ],
    'multiple_of'          => ':attribute يجب أن يكون من مضاعفات :value',
    'not_in'               => 'العنصر :attribute غير صحيح.',
    'not_regex'            => 'صيغة :attribute غير صحيحة.',
    'numeric'              => 'يجب على :attribute أن يكون رقمًا.',
    'password'             => 'كلمة المرور غير صحيحة.',
    'present'              => 'يجب تقديم :attribute.',
    'regex'                => 'صيغة :attribute .غير صحيحة.',
    'required'             => ':attribute مطلوب.',
    'required_if'          => ':attribute مطلوب في حال ما إذا كان :other يساوي :value.',
    'required_unless'      => ':attribute مطلوب في حال ما لم يكن :other يساوي :values.',
    'required_with'        => ':attribute مطلوب إذا توفّر :values.',
    'required_with_all'    => ':attribute مطلوب إذا توفّر :values.',
    'required_without'     => ':attribute مطلوب إذا لم يتوفّر :values.',
    'required_without_all' => ':attribute مطلوب إذا لم يتوفّر :values.',
    'same'                 => 'يجب أن يتطابق :attribute مع :other.',
    'size'                 => [
        'numeric' => 'يجب أن تكون قيمة :attribute مساوية لـ :size.',
        'file'    => 'يجب أن يكون حجم الملف :attribute :size كيلوبايت.',
        'string'  => 'يجب أن يحتوي النص :attribute على :size حروفٍ/حرفًا بالضبط.',
        'array'   => 'يجب أن يحتوي :attribute على :size عنصرٍ/عناصر بالضبط.',
    ],
    'starts_with'          => 'يجب أن يبدأ :attribute بأحد القيم التالية: :values',
    'string'               => 'يجب أن يكون :attribute نصًا.',
    'timezone'             => 'يجب أن يكون :attribute نطاقًا زمنيًا صحيحًا.',
    'unique'               => 'قيمة :attribute مُستخدمة من قبل.',
    'uploaded'             => 'فشل في تحميل الـ :attribute.',
    'url'                  => 'صيغة الرابط :attribute غير صحيحة.',
    'uuid'                 => ':attribute يجب أن يكون بصيغة UUID سليمة.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [
        'name'                  => 'الاسم',
        'username'              => 'اسم المُستخدم',
        'email'                 => 'البريد الالكتروني',
        'first_name'            => 'الاسم الأول',
        'last_name'             => 'اسم العائلة',
        'password'              => 'كلمة المرور',
        'password_confirmation' => 'تأكيد كلمة المرور',
        'city'                  => 'المدينة',
        'country'               => 'الدولة',
        'address'               => 'العنوان',
        'phone'                 => 'الهاتف',
        'mobile'                => 'الجوال',
        'age'                   => 'العمر',
        'sex'                   => 'الجنس',
        'gender'                => 'الجنس',
        'day'                   => 'اليوم',
        'month'                 => 'الشهر',
        'year'                  => 'السنة',
        'hour'                  => 'ساعة',
        'minute'                => 'دقيقة',
        'second'                => 'ثانية',
        'title'                 => 'العنوان',
        'content'               => 'المُحتوى',
        'description'           => 'الوصف',
        'excerpt'               => 'المُلخص',
        'date'                  => 'التاريخ',
        'time'                  => 'الوقت',
        'available'             => 'مُتاح',
        'size'                  => 'الحجم',
    
        'slug'                  => 'رابط البحث',
        'meta_title'            => 'meta title',
        'meta_description'      => 'meta description',
        'meta_key'              => 'meta key',
        'en.title'              => 'العنوان في الإنجليزية ',
        'ar.title'              => 'العنوان في العربية ',
        'en.slug'               => ' رابط البحث  في الإنجليزية',
        'ar.slug'               => 'رابط البحث في العربية',
        'en.description'        => 'الوصف  في الإنجليزية',
        'ar.description'        => 'الوصف  في العربية',
        'en.content'            => 'الوصف  في الإنجليزية',
        'ar.content'            => 'الوصف  في العربية',
        'en.meta_title'         => 'meta title in English',
        'ar.meta_title'         => 'meta title in Arabic',
        'en.meta_description'   => 'meta description in English',
        'ar.meta_description'   => 'meta description in Arabic',
        'en.meta_key'           => 'meta key in English',
        'ar.meta_key'           => 'meta key in Arabic',
        'en.unit_price'         => 'سعر الوحدة في الإنجليزية',
        'ar.unit_price'         => 'سعر الوحدة في عربي',
        'unit_price'            => 'سعر الوحدة ',
        'number'                => 'الرقم',
        'beneficiary'           => 'المستفيد',
        'category_id'           => 'القسم',
        'image'                 => 'الصورة',
        'images'                => 'الصور',
        'cover_image'           => 'صورة الغلاف',
        'background_image'      => 'الصورة الخلفية',
        'background_color'      => 'لون الخلفية',
        'sort'                  => 'الترتيب',
        'feature'               => 'مميزة',
        'news_ticker'           => 'news ticker',
        'start_date'            => 'تاريخ البدء',
        'end_date'              => 'تاريخ الانتهاء',
        'status'                => 'الحالة',
        'type'                  => 'النوع',
        'donation_type'         => 'نوع التبرع ',
        'target_price'          => 'المبلغ المستهدف',
        'target_unit'           => 'الوحدة المستهدفة',
        'fake_target'           => 'القيم المؤقته',
        'payment_method'        => 'وسائل الدفع',
        'deceased_id'           => 'مشروع متوفي',
        'share_name'            => ' اسم الفئة',
        'share_value'           => 'قيمه الفئة',
        'fixed_value'           => 'قيمه ثابته',
        'donation_name'         => 'اسم الفئة ',
        'donation_value'        => 'الفئة الفئة',
        'tags'                  => 'الوسوم ',
        'tag_id'                => 'الوسوم ',
        'project_types'         => 'نوع المشروع',
        'parent_id'             => 'القسم الرئيسي ',
        'full_name'             => 'الأسم بالكامل ',
        'email'                 => 'البريد الاكتروني',
        'password'              => 'الرقم السري',
        'mobile'                => 'الموبيل',
        'mobile_confirm'        => 'تأكيد المزبيل',
        'whatsapp'              => 'whatsapp',
        'addressList'           => 'عرض كل عناوين',
        'url'                   => 'اللينك',
        'position'              => 'مكان',
        'bcakground_image'      => 'صوره الخلفيه',
        'sku'                   => 'sku',
        'quantity'              => 'الكمية',
        'price'                 => 'السعر',
        'start_at'              => 'بداء من ',
        'end_at'                => 'ينتهي من ',
        'vendor_id'             => 'البائع',
        'cover_image'           => 'صورة الغلاف',
        'portfolio_id'          => 'برتفوليو',
        'project_id'            => 'مشروع',
        'proof'                 => 'إثبات',
        'permissions'           => 'الأذونات',
        'employee_name'         => 'اسم الموظف',
        'employee_number'       => 'رقم الموظف',
        'employee_image'        => 'صورة الموظف',
        'department'            => 'قسم',
        'jop'                   => 'وظيفة',
        'location'              => 'الموقع',
        'roles'                 => 'الصلاحيات',
        'logo'                  => 'لوجو',
        'responsible_person'    => 'شخص مسؤول',
        'nationality'           => 'nationality',
        'amount'                => 'المبلغ',
        'giver_name'            => 'اسم المهدي اليه',
        'giver_mobile'          => 'جوال المهدي اليه',
        'giver_email'           => 'البريد الاكتروني المهدي اليه',
        'giver_address'         => 'عنوان المهدي اليه',
        'donation_amt'          => 'مبلغ التبرع',
        'selectedCard'          => 'بطاقات الأهداء',
        'money'                 => 'المبلغ',
        'zakatGold_gm'          => 'جرام زكاة الذهب',
        'zakatGold_amount'      => 'مبلغ زكاة الذهب',
        'zakatSilver_gm'        => 'جرام زكاة الفضة',
        'zakatSilver_amount'    => 'مبلغ زكاة الفضة',
        'zakatInvestment_gm'    => 'جرام زكاة الاسهم والصناديق الاستثمارية',
        'zakatInvestment_amount'=> 'مبلغ زكاة الاسهم والصناديق الاستثمارية',
        'deceased_name'         => 'اسم المتوفي',
        'relative_relation'     => 'صله القرابة',
        'deceased_image'        => 'صورة للمتوفي',
        'account_id'            => 'المستخدم',

    ],





];
