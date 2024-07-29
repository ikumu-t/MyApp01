<x-app-layout>
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold mb-4">ランキング</h2>

        <!-- フィルタフォーム -->
        <form method="GET" action="{{ route('movies.ranked') }}" class="mb-6 bg-white p-4 rounded shadow-md">
            <div class="flex flex-col sm:flex-row items-center mb-4">
                <label for="tag" class="mr-2">タグでフィルタ：</label>
                <input type="text" name="tag" id="tag-search" value="{{ request('tag') }}" class="border border-gray-300 rounded px-2 py-1 mr-2 w-3/4">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">検索</button>
            </div>
            <div class="flex items-center mb-4">
                <input type="checkbox" name="my_score" id="my_score" value="yes" class="mr-2">
                <label for="my_score">Myスコア</label>
            </div>
            <!--ユーザーのタグ一覧-->
            <div class="flex flex-wrap space-x-2">
                @foreach($tags as $tag)
                    <div
                        class="tag cursor-pointer bg-gray-200 rounded-full px-4 py-2 mb-2"
                        data-tag="{{ $tag->name }}"
                    >
                        {{ $tag->name }}
                    </div>
                @endforeach
            </div>

        </form>

        <!-- 映画ランキング -->
        <div>
            <h3 class="text-2xl font-semibold mb-4">映画ランキング</h3>
            @if($movies->isEmpty())
                <p class="text-gray-700">ランキングはありません。</p>
            @else
                <ul>
                    @foreach ($movies as $movie)
                        <div class="mb-6 p-4 bg-white rounded shadow-md">
                            <h4 class="text-xl font-semibold mb-2">{{ $movie->title }}</h4>
                            <span class="flex">
                            <p class="text-gray-700 mr-2" style="width: 92px">スコア：{{ round($movie->reviews->avg('score'), 2) }}</p>
                                <svg width="24px" height="24px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M9.15316 5.40838C10.4198 3.13613 11.0531 2 12 2C12.9469 2 13.5802 3.13612 14.8468 5.40837L15.1745 5.99623C15.5345 6.64193 15.7144 6.96479 15.9951 7.17781C16.2757 7.39083 16.6251 7.4699 17.3241 7.62805L17.9605 7.77203C20.4201 8.32856 21.65 8.60682 21.9426 9.54773C22.2352 10.4886 21.3968 11.4691 19.7199 13.4299L19.2861 13.9372C18.8096 14.4944 18.5713 14.773 18.4641 15.1177C18.357 15.4624 18.393 15.8341 18.465 16.5776L18.5306 17.2544C18.7841 19.8706 18.9109 21.1787 18.1449 21.7602C17.3788 22.3417 16.2273 21.8115 13.9243 20.7512L13.3285 20.4768C12.6741 20.1755 12.3469 20.0248 12 20.0248C11.6531 20.0248 11.3259 20.1755 10.6715 20.4768L10.0757 20.7512C7.77268 21.8115 6.62118 22.3417 5.85515 21.7602C5.08912 21.1787 5.21588 19.8706 5.4694 17.2544L5.53498 16.5776C5.60703 15.8341 5.64305 15.4624 5.53586 15.1177C5.42868 14.773 5.19043 14.4944 4.71392 13.9372L4.2801 13.4299C2.60325 11.4691 1.76482 10.4886 2.05742 9.54773C2.35002 8.60682 3.57986 8.32856 6.03954 7.77203L6.67589 7.62805C7.37485 7.4699 7.72433 7.39083 8.00494 7.17781C8.28555 6.96479 8.46553 6.64194 8.82547 5.99623L9.15316 5.40838Z" fill="#eab308"/>
                                </svg>
                            </span>
                        </div>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const tags = document.querySelectorAll('.tag');
                const tagSearchInput = document.getElementById('tag-search');

                tags.forEach(tag => {
                    tag.addEventListener('click', function() {
                        const tagName = this.dataset.tag;
                        
                        let currentTags = tagSearchInput.value.split(',').map(t => t.trim()).filter(t => t !=='');
                        if (!currentTags.includes(tagName)) {
                            currentTags.push(tagName);
                        }
                        tagSearchInput.value = currentTags.join(', ');
                    });
                });
            });
        </script>
    @endpush
</x-app-layout>
