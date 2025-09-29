@extends('site.app')

@section('title', $category->transNow->title ?? '')
@section('meta_title', $category->transNow->meta_title ?? $category->transNow->title ?? '')
@section('meta_description', $category->transNow->meta_description ?? $category->transNow->description ?? '')
@section('meta_key', $category->transNow->meta_key ?? '')

@section('content')

<!-- Page Header -->
<section class="page-header">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12 text-center">
                <div class="page-header-content">
                    <h1 class="page-title">{{ $category->transNow->title ?? '' }}</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center">
                            <li class="breadcrumb-item">
                                <a href="{{ route('site.home') }}">{{ __('site.home') }}</a>
                                &nbsp; / &nbsp;
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('site.blog-categories.index') }}">{{ __('site.blog_categories') }}</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                {{ $category->transNow->title ?? '' }}
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Category Info Section -->
<section class="blog-card-detail-section section-padding">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 blog-item">
                <div class="card p-4 shadow-sm rounded" style="margin-top:30px;">
                    @if($category->image)
                    <div class="image-wrapper position-relative mb-3" style="background-color: #10353c; border-radius: 20px; width: fit-content; padding: 20px; margin: 0 auto;">
                        <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->transNow->title ?? '' }}" class="img-fluid rounded" style="max-width: 400px; border-radius: 20px;">
                    </div>
                    @endif
                    {{-- <div class="image-wrapper position-relative mb-3" style="width: fit-content; padding: 0; margin: 0 auto;">
                        @if($category->image)
                            <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->transNow->title ?? '' }}" class="img-fluid rounded" style="max-width: 300px; border-radius: 20px;">
                        @endif
                    </div> --}}
                    <h2 class="blog-title">
                        {{ $category->transNow->title ?? '' }}
                    </h2>
                    @if($category->transNow->description)
                    <p class="blog-excerpt">
                        {{ Str::limit($category->transNow->description ?? '', 500) }}
                    </p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Blog Articles Section -->
<section class="blog-section section-padding">
    <div class="container">
        <div class="category-info" style="margin-bottom: 40px;"></div>
        @if($blogs->count() > 0)
            <div class="row" id="blogsContainer">
                @foreach($blogs as $index => $blog)
                    <div class="col-lg-4 col-md-6 col-sm-12 blog-item mb-4 category-item" style="{{ $index >= 6 ? 'display:none;' : '' }}">
                        <div class="category-card p-3 rounded text-center d-flex flex-column" style="border: 1px solid #b0b0b0; height: 100%;">
                            <a href="{{ route('site.blogs.show', $blog->transNow->slug ?? $blog->id) }}" class="moving-frame" style="display: inline-block; margin-bottom: 15px; background-color: #10353c; border-radius: 20px; padding: 20px;">
                                <div class="image-wrapper position-relative" style="width: fit-content; margin: 0 auto;">
                                    @if($blog->image)
                                        <img src="{{ asset('storage/' . $blog->image) }}" alt="{{ $blog->transNow->title ?? '' }}" class="img-fluid rounded" style="max-width: 300px; border-radius: 20px; cursor: pointer;">
                                    @endif
                                </div>
                            </a>
                            <h4 class="category-title" style="color: black; margin-bottom: 5px;">
                                <a href="{{ route('site.blogs.show', $blog->transNow->slug ?? $blog->id) }}" class="category-link">
                                    {{ $blog->transNow->title ?? '' }}
                                </a>
                            </h4>
                            <hr style="border-color: #b0b0b0; width: 50%; margin: 0 auto 10px;">
                            <p class="category-description text-truncate" style="color: #8a8a8a; font-size: 1rem; line-height: 1.4; flex-grow: 1;">
                                {{ Str::limit($blog->transNow->description ?? '', 150) }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <div class="row">
                <div class="col-12 text-center mt-4">
                    <div>
                        <button id="seeMoreBtn" class="btn btn-primary btn-sm" style="padding: 8px 20px; font-size: 14px; background-color: #10353c; border: none;">
                            عرض المزيد
                        </button>
                    </div>
                    <div style="margin-top: 20px;">
                        <div style="display: inline-block; background-color: #f8f9fa; padding: 8px 15px; border: 1px solid #10353c; border-radius: 8px;">
                            <p style="margin: 0; color: #666; font-size: 14px;">
                                عدد المدونات: {{ $blogs->count() }}
                                @if(method_exists($blogs, 'total'))
                                    | العدد الكلي: {{ $blogs->total() }}
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            
        @else
            <div class="row">
                <div class="col-12">
                    <div class="no-content text-center" style="padding: 80px 20px; color: #666;">
                        <i class="fas fa-newspaper" style="font-size: 4rem; margin-bottom: 20px; color: #ddd;"></i>
                        <h4>{{ __('site.no_articles_in_category') }}</h4>
                        <p>{{ __('site.no_articles_category_description') }}</p>
                        <a href="{{ route('site.blogs.index') }}" class="btn btn-primary" style="margin-top: 30px;">
                            {{ __('site.view_all_blogs') }}
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const seeMoreBtn = document.getElementById('seeMoreBtn');
    if (seeMoreBtn) {
        let currentlyShown = 6;
        const itemsPerLoad = 6;
        const allItems = document.querySelectorAll('.category-item');
        const totalItems = allItems.length;

        seeMoreBtn.addEventListener('click', function() {
            const itemsToShow = Math.min(currentlyShown + itemsPerLoad, totalItems);
            
            for (let i = currentlyShown; i < itemsToShow; i++) {
                if (allItems[i]) {
                    allItems[i].style.display = 'block';
                }
            }
            
            currentlyShown = itemsToShow;
            
            if (currentlyShown >= totalItems) {
                seeMoreBtn.style.display = 'none';
            }
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

.blog-excerpt {
    font-size: 1.1rem;
    color: #555;
    line-height: 1.6;
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

/* Button hover effect */
#seeMoreBtn:hover {
    background-color: #0d2a2f !important;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(16, 53, 60, 0.3);
}
</style>
@endpush
@endsection