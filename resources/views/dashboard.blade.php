<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <div>
    <h2>Popular</h2>
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            @include('components.search')
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
</div>
</x-app-layout>
