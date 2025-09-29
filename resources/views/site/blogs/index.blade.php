@extends('site.app')

@section('title', __('site.blog'))
@section('meta_title', @$settings['blogs_meta_title_' . app()->getLocale()])
@section('meta_description', @$settings['blogs_meta_description_' . app()->getLocale()])
@section('meta_key', @$settings['blogs_meta_key_' . app()->getLocale()])

@section('content')
@php
use Illuminate\Support\Str;
@endphp
<!-- Page Header -->
<section class="page-header">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="page-header-content text-center">
                    <h1 class="page-title" style="margin-top: 24px;">{{ __('site.blog') }}</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center">
                            <li class="breadcrumb-item">
                                <a href="{{ route('site.home') }}">{{ __('site.home') }}</a>
                                 &nbsp; / &nbsp;
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                {{ __('site.blog') }}
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</section>

<br>
<br>

<!-- Blog Section -->
<section class="blog-section section-padding">
    <div class="container">
        @forelse($blogs as $blog)
            <div class="row mb-5 align-items-center blog-item">
                <div class="col-lg-6 {{ $loop->iteration % 2 == 1 ? 'order-lg-1' : 'order-lg-2' }}">
                    @if($blog->image)
                        <a href="{{ route('site.blogs.show', $blog->transNow->slug ?? $blog->id) }}">
                            <img src="{{ asset('storage/' . $blog->image) }}" alt="{{ $blog->transNow->title ?? '' }}" class="img-fluid rounded">
                        </a>
                    @endif
                </div>
                <div class="col-lg-6 {{ $loop->iteration % 2 == 1 ? 'order-lg-2' : 'order-lg-1' }}">
                    <h2 class="blog-title">
                        <a href="{{ route('site.blogs.show', $blog->transNow->slug ?? $blog->id) }}">
                            {{ $blog->transNow->title ?? '' }}
                        </a>
                    </h2>
                    @if($blog->categories)
                        <h5 class="blog-category">
                            <a href="{{ route('site.blog-categories.show', $blog->categories->transNow->slug ?? '') }}">
                                {{ $blog->categories->transNow->title ?? '' }}
                            </a>
                        </h5>
                    @endif
                    <p class="blog-excerpt">
                        {{ Str::limit($blog->transNow->description ?? '', 300) }}
                    </p>
                </div>
            </div>
        @empty
            <div class="no-content text-center">
                <i class="fas fa-newspaper"></i>
                <h4>{{ __('site.no_articles_found') }}</h4>
                <p>{{ __('site.no_articles_description') }}</p>
            </div>
        @endforelse

        <!-- Pagination -->
        @if($blogs->hasPages())
            <div class="pagination-wrapper text-center">
                {{ $blogs->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>
</section>
@endsection

@push('styles')
<style>
.page-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 80px 0 60px;
    position: relative;
}

.page-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0,0,0,0.3);
}

.page-header-content {
    position: relative;
    z-index: 2;
}

.page-title {
    font-size: 3rem;
    font-weight: 700;
    margin-bottom: 20px;
}

.breadcrumb {
    background: transparent;
    margin-bottom: 0;
}

.breadcrumb-item a {
    color: rgba(255,255,255,0.8);
    text-decoration: none;
}

.breadcrumb-item.active {
    color: white;
}

.section-padding {
    padding: 80px 0;
}

.blog-item {
    margin-bottom: 60px;
}

.blog-title {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 15px;
    color: #4a2c6e;
}

.blog-title a {
    color: #4a2c6e;
    text-decoration: none;
    transition: color 0.3s ease;
}

.blog-title a:hover {
    color: #764ba2;
}

.blog-category {
    font-size: 1.2rem;
    font-weight: 600;
    margin-bottom: 20px;
    color: #764ba2;
}

.blog-category a {
    color: #764ba2;
    text-decoration: none;
    border-bottom: 1px solid transparent;
    transition: border-color 0.3s ease;
}

.blog-category a:hover {
    border-bottom: 1px solid #764ba2;
}

.blog-excerpt {
    font-size: 1.1rem;
    color: #555;
    line-height: 1.6;
}

.img-fluid {
    max-width: 100%;
    height: auto;
    border-radius: 10px;
}

.pagination-wrapper {
    margin-top: 40px;
}

@media (max-width: 991px) {
    .blog-item {
        flex-direction: column !important;
    }
    .blog-title {
        font-size: 1.5rem;
    }
    .blog-category {
        font-size: 1rem;
    }
}

@media (max-width: 767px) {
    .page-title {
        font-size: 2rem;
    }
}
</style>
@endpush
