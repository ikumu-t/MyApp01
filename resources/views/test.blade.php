<x-app-layout>
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <!-- Popular Movies Section -->
        <div class="mb-8">
            <h2 class="text-2xl font-bold mb-4">Popular Movies</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($popularMovies as $movie)
                    <div class="bg-white shadow-md rounded-lg overflow-hidden">
                        <img src="https://image.tmdb.org/t/p/w500{{ $movie->poster_path }}" alt="{{ $movie->title }}" class="w-full h-64 object-cover">
                        <div class="p-4">
                            <h3 class="text-lg font-semibold">{{ $movie->title }}</h3>
                            <p class="text-gray-600">{{ $movie->release_date }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Latest Reviews Section -->
        <div class="mb-8">
            <h2 class="text-2xl font-bold mb-4">Latest Reviews</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($latestReviews as $review)
                    <div class="bg-white shadow-md rounded-lg overflow-hidden p-4">
                        <h3 class="text-lg font-semibold">{{ $review->movie->title }}</h3>
                        <p class="text-gray-600">{{ $review->created_at->format('Y-m-d') }}</p>
                        <p class="mt-2">{{ $review->comment }}</p>
                        <p class="mt-2 font-bold">Score: {{ $review->score }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Popular Tags Section -->
        <div class="mb-8">
            <h2 class="text-2xl font-bold mb-4">Popular Tags</h2>
            <div class="flex flex-wrap gap-2">
                @foreach($popularTags as $tag)
                    <a href="{{ route('tags.show', $tag->id) }}" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                        {{ $tag->name }} ({{ $tag->reviews_count }})
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
