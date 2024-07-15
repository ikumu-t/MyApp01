<x-app-layout>
    <div class="max-w-4xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <h2>{{ $movie->title }}</h2>
        <div class="w-24 sm:w-64">
            <img src="https://image.tmdb.org/t/p/w500{{ $movie->poster_path }}" alt="{{ $movie->title }} Poster"　class="w-full object-contain">
        </div>
        
        <p>{{ $movie->overview }}</p>
    </div>
</x-app-layout>