<x-app-layout>
    
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        @include('components.search')
        <h2 class="text-2xl font-bold mb-4">Searching Results</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
            @foreach($movies as $movie)
                <div class="bg-white shadow-md rounded-lg overflow-hidden">
                    <img src="https://image.tmdb.org/t/p/w500{{ $movie->poster_path }}" alt="{{ $movie->title }} Poster" class="object-contain">
                    <div class="p-4">
                        <a href="{{ route('movies.show', $movie->id) }}" class="block text-lg font-bold text-gray-800 mt-2">{{ $movie->title }}</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>