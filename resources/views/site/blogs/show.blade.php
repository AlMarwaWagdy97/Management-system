@extends('site.app')

@section('title', $blog->transNow->title ?? '')
@section('meta_title', $blog->transNow->meta_title ?? $blog->transNow->title ?? '')
@section('meta_description', $blog->transNow->meta_description ?? $blog->transNow->description ?? '')
@section('meta_key', $blog->transNow->meta_key ?? '')

@section('content')
<link rel="stylesheet" href="{{ asset('assets/site/css/custom-blog.css') }}">
<!-- Page Header -->
<section class="page-header">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="page-header-content text-center">
                    <h1 class="page-title">{{ $blog->transNow->title ?? '' }}</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center">
                            <li class="breadcrumb-item">
                                <a href="{{ route('site.home') }}">{{ __('site.home') }}</a>
                                 &nbsp; / &nbsp;
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('site.blogs.index') }}">{{ __('site.blog') }}</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                {{ Str::limit($blog->transNow->title ?? '', 50) }}
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Blog Card Detail Section -->
<section class="blog-card-detail-section section-padding">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 blog-item">
<div class="card p-4 shadow-sm rounded" style="margin-top:30px;">
    @if($blog->image)
    <div class="image-wrapper position-relative mb-3" style="background-color: #10353c; border-radius: 20px; width: fit-content; padding: 20px; margin: 0 auto;">
        <img src="{{ asset('storage/' . $blog->image) }}" alt="{{ $blog->transNow->title ?? '' }}" class="img-fluid rounded" style="max-width: 400px; border-radius: 20px;">
    </div>
    @endif
{{-- <div class="image-wrapper position-relative mb-3" style="width: fit-content; padding: 0; margin: 0 auto;">
    @if($blog->categories && $blog->categories->image)
        <a href="{{ route('site.blog-categories.show', $blog->categories->transNow->slug ?? '') }}">
            <img src="{{ asset('storage/' . $blog->categories->image) }}" alt="{{ $blog->categories->transNow->title ?? '' }}" class="img-fluid rounded" style="max-width: 300px; border-radius: 20px;">
        </a>
    @endif
</div> --}}
                <h2 class="blog-title">
                    {{ $blog->transNow->title ?? '' }}
                </h2>
                    @if($blog->categories)
                        <h5 class="blog-category mb-3">
                            <a href="{{ route('site.blog-categories.show', $blog->categories->transNow->slug ?? '') }}">
                                {{ $blog->categories->transNow->title ?? '' }}
                            </a>
                        </h5>
                    @endif
                    <p class="blog-excerpt">
                        {{ Str::limit($blog->transNow->description ?? '', 500) }}
                    </p>
                </div>
            </div>
        </div>
</section>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const seeMoreBtn = document.getElementById('seeMoreBtn');
        const categories = document.querySelectorAll('.category-item');
        const increment = 6;
        let visibleCount = 6;

        function showMoreCategories() {
            let shown = 0;
            for (let i = visibleCount; i < categories.length; i++) {
                if (shown >= increment) break;
                categories[i].style.display = 'block';
                shown++;
            }
            visibleCount += shown;
            if (visibleCount >= categories.length) {
                seeMoreBtn.style.display = 'none';
            }
        }

        if (seeMoreBtn) {
            seeMoreBtn.addEventListener('click', function () {
                showMoreCategories();
            });
        }
    });
</script>

@push('styles')
<style>
.blog-card-detail-section {
    padding: 120px 0;
    margin-top: 60px;
}

.blog-item {
    margin-bottom: 80px;
}

.blog-title {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 15px;
    color: #4a2c6e;
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

.category-link {
    color: black;
    text-decoration: none;
    transition: color 0.3s ease;
}

.category-link:hover {
    color: #28a745;
    font-size: 1.1rem;
}

/* New styles for clickable category images with frame */
.image-wrapper img {
    transition: transform 0.3s ease;
    border-radius: 20px;
}

a:hover .image-wrapper img {
    transform: scale(1.05);
    cursor: pointer;
}

.moving-frame {
    background-color: #10353c;
    border-radius: 20px;
    padding: 20px;
    display: inline-block;
    position: relative;
    overflow: hidden;
}

.moving-frame::before {
    content: "";
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: linear-gradient(45deg, 
        rgba(193, 173, 123, 0.15), 
        rgba(0, 145, 116, 0.3),    
        rgba(193, 173, 123, 0.15)  
    );
    animation: moveFrame 3s linear infinite;
    border-radius: 20px;
    pointer-events: none;
    z-index: 1;
}

@keyframes moveFrame {
    0% {
        transform: rotate(0deg) translate(0, 0);
    }
    100% {
        transform: rotate(360deg) translate(0, 0);
    }
}
</style>
@endpush