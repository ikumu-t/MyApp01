<x-app-layout>
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-md overflow-hidden flex">
            <img src="https://image.tmdb.org/t/p/w500{{ $cast->profile_path }}" 
                alt="{{ $cast->name }} Image" 
                class="object-cover w-64 h-64"
            >
            <div class="p-6 flex flex-col justify-center">
                <h3 class="text-2xl font-semibold mb-2">{{ $cast->name }}</h3>
    
                @isset($age)
                    <p class="text-gray-700"><strong>Age:</strong> {{ $age }}</p>
                @endisset
    
                <p class="text-gray-700"><strong>Place of Birth:</strong> {{ $castDetail->place_of_birth }}</p>
            </div>
        </div>
    
        <h2 class="text-lg font-semibold mt-6">Cast</h2>
        <div class="flex overflow-x-auto space-x-4 bg-gray-100 p-4">
        @if ($moviesAsCast->isNotEmpty())
            @foreach($moviesAsCast as $movie)
                <x-movie-card :movie="$movie" :iteration="$loop->iteration" />
            @endforeach
        @else
            <p>None</p>
        @endif
        </div>
    
        <h2 class="text-lg font-semibold mt-6">Director</h2>
        <div class="flex overflow-x-auto space-x-4 bg-gray-100 p-4">
        @if ($moviesAsDirector->isNotEmpty())
            @foreach($moviesAsDirector as $movie)
                <x-movie-card :movie="$movie" :iteration="$loop->iteration" />
            @endforeach
        @else
            <p>None</p>
        @endif
        </div>
    </div>
</x-app-layout>
