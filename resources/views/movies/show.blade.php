<x-app-layout>
    @if(session('success'))
    <div class="bg-green-500 text-white p-4 rounded-lg mb-6">
        {{ session('success') }}
    </div>
    @endif 
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <div class="flex items-start p-4 rounded-lg bg-white shadow-md">
            <div class="w-1/3 flex items-center justify-center h-48">
                <img src="https://image.tmdb.org/t/p/w500{{ $movie->poster_path }}" alt="{{ $movie->title }} Poster" class="object-contain h-full rounded-lg">
            </div>
            <div class="w-2/3 p-4 rounded-lg bg-white h-48 overflow-y-auto">
                <div class="flex">
                <h2 class="text-2xl font-bold mb-2">{{ $movie->title }}</h2>
                <h2 class="text-gray-700 mb-4">({{ \Carbon\Carbon::parse($movie->release_date)->format('Y') }})</h2>
                @foreach($movie->genres as $genre)
                    <h2 class="bg-gray-300 rounded-lg p-1 m-1 y-6 items-center ">{{ $genre->name }}</h2>
                @endforeach
                </div>
                <p class="text-gray-600">{{ $movie->overview }}</p>
            </div>

        </div>
        <!--レビューフォームセクション-->
        <div class="mt-6">
            <form action="{{ route('reviews.store') }}" method="POST">
                @csrf
                <x-tag-input :tags="old('tags', isset($review) ? $review->tags->pluck('name')->implode(', ') : '')" />
                <div class="mt-4">
                    <label for="comment" class="block text-gray-700">Comment</label>
                    <textarea name="comment" id="comment" rows="4" class="w-full border rounded-lg p-2" placeholder="255文字以内で入力">{{ old('comment', isset($review) ? $review->comment : '') }}</textarea>
                    @error('comment')
                        <div class="text-red-600 mt-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mt-4">
                    <label for="score" class="block text-gray-700">Score</label>
                    <input type="number" name="score" id="score" min="0" max="100" class="w-full border rounded-lg p-2" placeholder="１〜１００の範囲内で入力" value="{{ old('score', isset($review) ? $review->score : '') }}">
                    @error('score')
                        <div class="text-red-600 mt-2">{{ $message }}</div>
                    @enderror
                </div>
                <input type="hidden" name="movie_id" value="{{ $movie->id }}">
                <div class="mt-6">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Submit</button>
                </div>
            </form>
            @if(isset($review))
                <div class="mt-4">
                    <form action="{{ route('reviews.destroy', $review->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-900">
                            削除
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
