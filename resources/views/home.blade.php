<x-app-layout>
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <div class="w-full mb-4" >
            <x-search />
        </div>
        <h2 class="text-2xl font-bold mb-4">人気の映画</h2>
        <div class="flex overflow-x-auto space-x-4 bg-gray-100 p-4">
            @foreach($popularMovies as $movie)
                <x-movie-card :movie="$movie" :iteration="$loop->iteration" />
            @endforeach
        </div>
        <h2 class="text-2xl font-bold mb-4">最新レビュー</h2>
        <div class="bg-gray-100 p-4 rounded-lg">
            @foreach($latestReviews as $review)
                <div class="flex flex-col sm:flex-row mb-4 bg-white rounded-lg p-4 shadow">
                    <img src="https://image.tmdb.org/t/p/w500{{ $review->movies->poster_path }}" alt="{{ $review->movies->title }} Poster" class="w-32 h-36 sm:w-24 sm:h-18 mr-4 rounded-lg">
                    <div class="flex flex-col flex-grow">
                        <div class="justify-between items-start mb-2">
                            <p class="w-48 font-semibold text-gray-800">{{ $review->movies->title }}</p>
                            <p class="text-sm test-gray-600 text-right">{{ $review->updated_at}}</p>
                        </div>
                        <p class="text-sm text-gray-500 mb-2">投稿者：{{ $review->users->name }}</p>
                        <p class="text-gray-700 mb-2">{{ $review->comment }}</p>
                        <p class="font-bold text-yellow-500">SCORE：{{ $review->score }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>