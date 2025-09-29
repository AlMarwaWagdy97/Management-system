@foreach($categories as $category)
    <div class="col-lg-4 col-md-6">
        <a href="{{ route('site.blog-categories.show', $category->transNow->slug ?? '') }}" 
           class="block bg-white rounded-lg shadow-md overflow-hidden transform transition duration-300 hover:scale-105 hover:z-10 relative text-center">
            <div class="relative h-64 flex flex-col justify-end p-6">
                @if($category->image)
                    <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->transNow->title ?? '' }}" 
                         class="absolute inset-0 w-full h-full object-cover" />
                @else
                    <div class="absolute inset-0 flex items-center justify-center bg-gray-100">
                        <i class="fas fa-folder-open fa-5x text-gray-400"></i>
                    </div>
                @endif
                <div class="relative bg-white bg-opacity-90 p-4 rounded-md shadow-lg">
                    <h4 class="text-green-600 font-semibold text-lg mb-2">
                        {{ $category->transNow->title ?? '' }}
                    </h4>
                    <p class="text-gray-700 text-sm">
                        {{ Str::limit($category->transNow->description ?? '', 140) }}
                    </p>
                </div>
            </div>
        </a>
    </div>
@endforeach
