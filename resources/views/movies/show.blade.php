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
            <form action="{{ route('review.store') }}" method="POST">
                @csrf
                <div class="mt-4">
                    <label for="tags">Tags</label>
                    <input type="text" name="tags" id="tags" value="{{ isset($review) ? $review->tags->pluck('name')->implode(', ') : '' }}">
                </div>
                <div class="mt-4">
                    <label for="comment">Comment</label>
                    <textarea name="comment" id="comment" rows="4">{{ isset($review) ? $review->comment : ''}}</textarea>
                </div>
                <div class="mt-4">
                    <label for="score">Score</label>
                    <input tyoe="number" name="score" id="score" min="0" max="100" value="{{ isset($review) ? $review->score : '' }}">
                </div>
                <div class="mt-4">
                    <input type="hidden" name="movie_id" value="{{ $movie->id }}">
                </div>
                <div class="mt-6">
                    <button type="submit">Submit</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>