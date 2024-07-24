<x-app-layout>
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold mb-4">ランキング</h2>

        <!-- フィルタフォーム -->
        <form method="GET" action="{{ route('movies.ranked') }}" class="mb-6 bg-white p-4 rounded shadow-md">
            <div class="flex flex-col sm:flex-row items-center mb-4">
                <label for="tag" class="mr-2">タグでフィルタ：</label>
                <input type="text" name="tag" id="tag" value="{{ request('tag') }}" class="border border-gray-300 rounded px-2 py-1">
            </div>
            <div class="flex items-center mb-4">
                <input type="checkbox" name="my_score" id="my_score" value="yes" class="mr-2">
                <label for="my_score">Myスコア</label>
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">検索</button>
        </form>

        <!-- ユーザーのタグ一覧 -->
        <div class="mb-6 bg-white p-4 rounded shadow-md">
            <h3 class="text-2xl font-semibold mb-4">Your Tags</h3>
            <ul class="list-disc pl-5">
                @forelse ($tags as $tag)
                    <li class="mb-2">{{ $tag->name }}</li>
                @empty
                    <li>No Tags Found.</li>
                @endforelse
            </ul>
        </div>

        <!-- 映画ランキング -->
        <div>
            <h3 class="text-2xl font-semibold mb-4">Movie Rankings</h3>
            <ul>
                @foreach ($movies as $movie)
                    <li class="mb-6 p-4 bg-white rounded shadow-md">
                        <h4 class="text-xl font-semibold mb-2">{{ $movie->title }}</h4>
                        <p class="text-gray-700">スコア：{{ round($movie->reviews->avg('score'), 2) }}</p>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</x-app-layout>