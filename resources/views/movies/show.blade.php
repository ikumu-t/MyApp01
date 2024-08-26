<x-app-layout>
    <div class="container mx-auto px-4 py-8">
        <!-- 戻るボタン -->
        @php
            $previousPage = session('previous_page', route('home')); // デフォルトは人気映画の一覧ページ
        @endphp
        <a href="{{ $previousPage }}" class="absolute top-4 left-4 bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">
            ← Back
        </a>
        
        <!-- 映画情報ブロック -->
        <div class="flex flex-col md:flex-row md:space-x-8 bg-white p-6 rounded-lg shadow-md">
            <!-- ポスター -->
            <div class="flex-shrink-0">
                <img src="https://image.tmdb.org/t/p/w500{{ $movie->poster_path }}" alt="{{ $movie->title }} Poster" class="object-contain h-72 rounded-lg shadow-md"> <!-- サイズを小さく調整 -->
            </div>
            
            <!-- 映画情報 -->
            <div class="mt-6 md:mt-0 flex-1">
                <h2 class="text-3xl font-bold">{{ $movie->title }}</h2>
                <p class="text-gray-500 text-lg">({{ \Carbon\Carbon::parse($movie->release_date)->format('Y') }})</p>

                <!-- ジャンル -->
                <div class="flex flex-wrap mt-4">
                    @foreach($movie->genres as $genre)
                        <a href="{{ route('movies.by_genre', ['genre' => $genre]) }}" class="bg-gray-300 text-gray-700 rounded-lg px-3 py-1 m-1">{{ $genre->name }}</a>
                    @endforeach
                </div>

                <!-- 概要 -->
                <div class="mt-6">
                    <h3 class="text-xl font-semibold">Overview</h3>
                    <p class="mt-2 text-gray-700">{{ $movie->overview }}</p>
                </div>

                <!-- 監督 -->
                <div class="mt-6">
                    <h3 class="text-xl font-semibold">Director</h3>
                    @if ($director->person_id)
                    <a href="{{ route('casts.show', ['cast' => $director]) }}"class="mt-2 text-gray-700">
                        {{ $director->name }}
                    </a>
                    @else
                        <span class="mt-2 text-gray-700">{{ $director->name }}</span>
                    @endif
                </div>

                <!-- レビューフォームへのリンク -->
                <div class="mt-6">
                    <a href="{{ route('reviews.create', ['movie' => $movie]) }}" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">Write a Review</a>
                </div>
            </div>
        </div>

        <!-- キャスト情報 -->
        <div class="mt-8">
            <h3 class="text-2xl font-semibold">Cast</h3>
            <div class="grid grid-cols-2 md:grid-cols-10 gap-4 mt-4">
                @foreach($movie->casts as $cast)
                    <div class="flex flex-col items-center">
                        <img src="https://image.tmdb.org/t/p/w500{{ $cast->profile_path }}" alt="{{ $cast->name }} Image" class="object-contain h-48 w-full rounded-lg shadow-md"> <!-- 縦長に表示 -->
                        <a href="{{ route('casts.show', ['cast' => $cast]) }}" class="mt-2 text-sm font-medium">{{ $cast->name }}</a> <!-- テキストサイズを小さく調整 -->
                        <p class="text-gray-500 text-sm">{{ $cast->pivot->character }}</p> <!-- テキストサイズを小さく調整 -->
                    </div>
                @endforeach
            </div>

            <!-- 全キャスト表示へのリンク -->
            <div class="mt-4 text-right">
                <a href="{{ route('movies.casts', ['movie' => $movie]) }}" class="text-blue-500 hover:underline">View all cast ({{ $movie->casts()->count() }} members)</a>
            </div>
        </div>
        <!-- 最新のレビュー表示 -->
        <div class="bg-gray-100 p-4 rounded-lg">
            @if($reviews)
                @foreach($reviews as $review)
                    <div class="flex flex-col sm:flex-row mb-4 bg-white rounded-lg p-4 shadow">
                        <div class="flex flex-col flex-grow">
                            <div class="justify-between items-start mb-2">
                                <p class="text-sm test-gray-600 text-right">{{ $review->updated_at}}</p>
                            </div>
                            <p class="text-sm text-gray-500 mb-2">投稿者：{{ $review->users->name }}</p>
                            <p class="text-gray-700 mb-2">{{ $review->comment }}</p>
                            <p class="font-bold text-yellow-500">SCORE：{{ $review->score }}</p>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</x-app-layout>
