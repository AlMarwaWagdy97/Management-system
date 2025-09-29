@extends('site.app')

@php
    $settings = App\Charity\Settings\SettingSingleton::getInstance();
@endphp
@section('content')
    <div class="container py-5">
        <h2 class="mb-4 text-center">تواصل معنا</h2>



        <div class="row d-flex pt-4 justify-content-center align-items-center ">

            <div class="col-md-6">
                <div class="text-center mb-4">
                    <img src="{{ asset(getImage($settings->getItem('logo')) ?? site_path('img/logo.png')) }}"
                        class="img-fluid w-50 h-50 " alt="" />

                </div>
                <div class="contact-icons pt-3 d-flex flex-column justify-content-start align-items-center h-100">
                    <div class="fristrow socialIncons  d-flex justify-content-center align-items-center ">
                        <a class=" icon" href="tel:{{ $settings->getContactInformationData('mobile') }}">
                            <span>{{ $settings->getContactInformationData('mobile') }}</span>
                            <i class="fa-solid fa-phone"></i>
                        </a>
                        <a class="contact" href="https://wa.me/{{ $settings->getContactInformationData('whatsapp') }}">
                            <span>{{ $settings->getContactInformationData('whatsapp') }}</span>
                            <i class="fa-solid fa-blender-phone"></i>
                        </a>
                    </div>
                    <div class="contact-icons  my-3">
                        <div class="socialIncons">
                            <a class="icon" href="mailto:{{ $settings->getContactInformationData('email') }}"
                                class="d-inline-block">
                                <span>
                                    {{ $settings->getContactInformationData('email') }}
                                </span>
                                <i id="email-icon" class="fa-solid fa-envelope"></i>
                            </a>
                        </div>

                    </div>
                </div>
                <div class="contact-icons text-center">
                    <div class="first p-3">
                        <div class="socialIncons d-flex justify-content-center align-items-center mt-4">
                            @if ($settings->getContactInformationData('instagram'))
                                <a class="icon" href="{{ $settings->getContactInformationData('instagram') }}">
                                    <i class="fa-brands fa-instagram"></i>
                                </a>
                            @endif

                            @if ($settings->getContactInformationData('instagram'))
                                <a class="icon" href="{{ $settings->getContactInformationData('facebook') }}">
                                    <i class="fa-brands fa-facebook"></i>
                                </a>
                            @endif

                            @if ($settings->getContactInformationData('youtube'))
                                <a class="icon" href="{{ $settings->getContactInformationData('youtube') }}">
                                    <i class="fa-brands fa-youtube"></i>
                                </a>
                            @endif

                            @if ($settings->getContactInformationData('twitter'))
                                <a class="icon" href="{{ $settings->getContactInformationData('twitter') }}">
                                    <i class="fa-brands fa-x-twitter"></i>
                                </a>
                            @endif

                            @if ($settings->getContactInformationData('snapchat'))
                                <a class="icon" href="{{ $settings->getContactInformationData('snapchat') }}">
                                    <i class="fa-brands fa-snapchat"></i>
                                </a>
                            @endif

                            @if ($settings->getContactInformationData('whatsapp'))
                                <a class="icon" href="{{ $settings->getContactInformationData('whatsapp') }}">
                                    <i class="fa-brands fa-whatsapp"></i>
                                </a>
                            @endif
                        </div>
                        <p class="mt-3 text-center d-none d-md-block">
                            جميع الحقوق محفوظة {{ date('Y') }} &#169;
                        </p>
                    </div>
                </div>




            </div>
            <div class="col-md-6">

                <form action="{{ route('site.contact-us.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="full_name" class="form-label">الاسم الكامل</label>
                        <input type="text" name="full_name" id="full_name"
                            class="form-control @error('full_name') is-invalid @enderror" value="{{ old('full_name') }}">
                        @error('full_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">البريد الإلكتروني</label>
                        <input type="email" name="email" id="email"
                            class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label">الهاتف</label>
                        <input type="text" name="phone" id="phone"
                            class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}">
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="city" class="form-label">المدينة</label>
                        <input type="text" name="city" id="city"
                            class="form-control @error('city') is-invalid @enderror" value="{{ old('city') }}">
                        @error('city')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>



                    <div class="mb-3">
                        <label for="title" class="form-label">عنوان الرساله</label>
                        <textarea name="title" id="title" rows="5" class="form-control @error('title') is-invalid @enderror">{{ old('title') }}</textarea>
                        @error('title')
                            <div class="invalid-feedback">{{ $title }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="message" class="form-label">الرسالة</label>
                        <textarea name="message" id="message" rows="5" class="form-control @error('message') is-invalid @enderror">{{ old('message') }}</textarea>
                        @error('message')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary px-4">إرسال</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
@endsection
<style>
    .contact-icons {
        background-color: #f8f9fa;
        border-radius: 10px;
      
    }

    .contact-icons .socialIncons a {
        color: #015263;
        font-size: 24px;
        margin: 0 10px;
    }

    .contact-icons .socialIncons a:hover {
        color: #015263;
    }

    .contact-icons p {
        color: #6c757d;
    }
</style>
