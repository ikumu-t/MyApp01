<x-app-layout>
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        @include('components.search')
        <h2 class="text-2xl font-bold mb-4">Searching Results</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
            @foreach($searchResults as $movie)
                <x-movie-card :movie="$movie" :iteration="$loop->iteration" />
            @endforeach
        </div>
    </div>
</x-app-layout>