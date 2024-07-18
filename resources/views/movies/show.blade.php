<x-app-layout>
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <div class="flex items-start">
            <div class="w-3xl sm:w-3xl mr-4">
                <img src="https://image.tmdb.org/t/p/w500{{ $movie->poster_path }}" alt="{{ $movie->title }} Poster" class="object-contain">
            </div>
            <div class="w-1/2 border border-red-500">
                <h2 class="text-2xl font-bold">{{ $movie->title }}</h2>
                <p class="text-gray-600">{{ $movie->overview }}</p>
            </div>
        </div>
        <div>
            <input type="text" name="new_tag" >
        </div>
    </div>
</x-app-layout>