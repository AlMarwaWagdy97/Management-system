@extends('site.app')

@section('title', __('site.blog_categories'))
@section('meta_title', __('site.blog_categories'))
@section('meta_description', __('site.blog_categories_description'))

@section('content')
<!-- Page Header -->
<section class="page-header" style="background-color: #f0f0f0; padding: 60px 0;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12 text-center">
                <h1 style="font-weight: 700; font-size: 2.5rem; color: #1a2a5a; text-transform: uppercase; letter-spacing: 3px;">
                     <span style="color: #3dbb3d;">الأقسام</span>
                </h1>
            </div>
        </div>
    </div>
</section>

<!-- Categories Section -->
<section class="categories-section section-padding" style="padding: 40px 0;">
    <div class="container">
        <div class="row g-4" id="categories-container">
            @include('site.blog-categories.partials.categories-list', ['categories' => $categories])
        </div>
        <div class="text-center mt-4">
            <button id="load-more-btn" class="btn btn-success" style="background-color: #3dbb3d; border: none; padding: 12px 30px; font-weight: 600; font-size: 1rem; border-radius: 5px;">
                عرض المزيد 
            </button>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="cta-section" style="padding: 60px 0; text-align: center;">
    <div class="container">
        <a href="{{ route('site.blogs.index') }}" class="btn btn-primary btn-lg" style="background-color: #3dbb3d; border: none; padding: 15px 40px; font-weight: 700; font-size: 1.2rem; border-radius: 5px;">
            عرض كل المدونات
        </a>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let currentPage = 1;
    const loadMoreBtn = document.getElementById('load-more-btn');
    const categoriesContainer = document.getElementById('categories-container');

    loadMoreBtn.addEventListener('click', function() {
        currentPage++;
        fetch(`{{ route('site.blog-categories.index') }}?page=${currentPage}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if(data.html.trim() === '') {
                loadMoreBtn.textContent = 'لايوجد أقسام اخري ';
                loadMoreBtn.disabled = true;
                return;
            }
            categoriesContainer.insertAdjacentHTML('beforeend', data.html);
            loadMoreBtn.scrollIntoView({ behavior: 'smooth' });
        })
        .catch(error => {
            console.error('Error loading more categories:', error);
        });
    });
});
</script>
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

.section-header {
    margin-bottom: 60px;
}

.section-title {
    font-size: 2.5rem;
    font-weight: 700;
    color: #333;
    margin-bottom: 20px;
    text-transform: uppercase;
    letter-spacing: 2px;
}

.section-subtitle {
    font-size: 1.2rem;
    color: #666;
    max-width: 600px;
    margin: 0 auto;
}

.categories-section .row.g-4 {
    gap: 1.5rem;
}

.category-card {
    background: white;
    border-radius: 20px;
    padding: 30px 20px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
    align-items: center;
    text-align: center;
}

.category-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.15);
}

.category-icon img,
.category-icon i {
    max-height: 80px;
    margin: 0 auto;
    display: block;
}

.category-title {
    font-size: 1.5rem;
    font-weight: 700;
    margin-bottom: 15px;
    color: #2a7a2a; /* green color similar to reference */
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

.category-title a {
    color: inherit;
    text-decoration: none;
    transition: color 0.3s ease;
}

.category-title a:hover {
    color: #4caf50;
}

.category-description {
    color: #555;
    font-size: 1rem;
    line-height: 1.5;
    margin-bottom: 25px;
    flex-grow: 1;
}

.category-link {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    color: #2a7a2a;
    font-weight: 600;
    text-decoration: none;
    border: 2px solid #2a7a2a;
    padding: 10px 20px;
    border-radius: 30px;
    transition: all 0.3s ease;
    justify-content: center;
    width: 100%;
}

.category-link:hover {
    background: #2a7a2a;
    color: white;
    gap: 12px;
}

.cta-section {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 80px 0;
    position: relative;
}

.cta-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0,0,0,0.2);
}

.cta-content {
    position: relative;
    z-index: 2;
}

.cta-content h3 {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 20px;
}

.cta-content p {
    font-size: 1.2rem;
    margin-bottom: 30px;
    opacity: 0.9;
}

.btn-primary {
    background: white;
    color: #007bff;
    border: none;
    padding: 15px 30px;
    border-radius: 30px;
    font-weight: 600;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 10px;
}

.btn-primary:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.2);
    color: #0056b3;
    gap: 15px;
}

.no-content {
    padding: 80px 20px;
    color: #666;
}

.no-content i {
    font-size: 4rem;
    margin-bottom: 20px;
    color: #ddd;
}

@media (max-width: 991px) {
    .page-title {
        font-size: 2.5rem;
    }
    
    .section-title {
        font-size: 2rem;
    }
    
    .cta-content h3 {
        font-size: 2rem;
    }
}

@media (max-width: 767px) {
    .page-title {
        font-size: 2rem;
    }
    
    .section-title {
        font-size: 1.8rem;
    }
    
    .cta-content h3 {
        font-size: 1.8rem;
    }
    
    .category-card {
        padding: 20px 15px;
    }
    
    .section-padding {
        padding: 60px 0;
    }
    
    .cta-section {
        padding: 60px 0;
    }
}
</style>
@endpush
