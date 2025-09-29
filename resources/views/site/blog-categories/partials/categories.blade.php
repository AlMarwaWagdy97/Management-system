@foreach($categories as $category)
    <div class="col-lg-3 col-md-6 mb-6">
        <a href="{{ route('site.blog-categories.show', $category->transNow->slug ?? '') }}" 
           class="block bg-white rounded-lg shadow-lg p-8 transform transition duration-300 hover:scale-105 hover:z-20 relative text-center h-full flex flex-col justify-between">
            <div class="category-icon mb-6">
                @if($category->image)
                    <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->transNow->title ?? '' }}" 
                         class="mx-auto max-h-28 object-contain" />
                @else
                    <div class="flex items-center justify-center bg-gray-100 h-28">
                        <i class="fas fa-folder-open fa-3x text-gray-400"></i>
                    </div>
                @endif
            </div>
            <div class="category-content flex-grow">
                <h4 class="category-title text-green-600 font-bold text-xl mb-4">
                    {{ $category->transNow->title ?? '' }}
                </h4>
                <p class="category-description text-gray-700 text-base leading-relaxed">
                    {{ Str::limit($category->transNow->description ?? '', 140) }}
                </p>
            </div>
        </a>
    </div>
@endforeach
