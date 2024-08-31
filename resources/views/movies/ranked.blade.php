<x-app-layout>
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">

        <!-- フィルタフォーム -->
        <form method="GET" action="{{ route('movies.ranked') }}" class="max-w-7xl mx-auto mb-6 bg-white p-4 rounded shadow-md">
            <div class="flex flex-col sm:flex-row items-center mb-4">
                <label for="tag" class="mr-2">タグでフィルタ：</label>
                <input type="text" name="tags" id="tag-search" value="{{ request('tags') }}" class="border border-gray-300 rounded px-2 py-1 mr-2 w-3/4" placeholder="例: アクション,ドラマ">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">
                    <svg class="fill-current h-6 w-6" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 56.966 56.966" style="enable-background:new 0 0 56.966 56.966;" xml:space="preserve" width="512px" height="512px">
                    <path d="M55.146,51.887L41.588,37.786c3.486-4.144,5.396-9.358,5.396-14.786c0-12.682-10.318-23-23-23s-23,10.318-23,23  s10.318,23,23,23c4.761,0,9.298-1.436,13.177-4.162l13.661,14.208c0.571,0.593,1.339,0.92,2.162,0.92  c0.779,0,1.518-0.297,2.079-0.837C56.255,54.982,56.293,53.08,55.146,51.887z M23.984,6c9.374,0,17,7.626,17,17s-7.626,17-17,17  s-17-7.626-17-17S14.61,6,23.984,6z" />
                    </svg>
                </button>
            </div>
  
        <!--ユーザーのタグ一覧-->
            <div class="flex flex-wrap space-x-2">
                @foreach($tagIndex as $tag)
                    <div
                        class="tag cursor-pointer bg-gray-200 rounded-full px-4 py-2 mb-2"
                        data-tag="{{ $tag->name }}"
                    >
                        {{ $tag->name }} : 
                        {{ $tag->reviews_count }}
                    </div>
                @endforeach
            </div>
        
            @auth
                <div class="flex items-center mb-4">
                    <input type="checkbox" name="my_score" id="my_score" value="yes" class="mr-2"
                        {{ request('my_score') == 'yes' ? 'checked' : '' }}>
                    <label for="my_score">Myスコア</label>
                </div>  
            @endauth
        </form>

        <!-- 映画ランキング -->
        <div>
            <div>
                <h3 class="text-2xl font-semibold mb-4">映画ランキング</h3>
                @if($movies->isEmpty())
                    <p class="text-gray-700">ランキングはありません。</p>
                @else
                    <ul>
                        @foreach ($movies as $index => $movie)
                            <div class="mb-6 p-4 bg-white rounded shadow-md flex items-center">
                                <div class="mr-4 text-lg font-bold">{{ $index + 1 }}</div>
                                <div class="w-12 mr-4 flex items-center justify-center h-20">
                                    <img src="https://image.tmdb.org/t/p/w500{{ $movie->poster_path }}" alt="{{ $movie->title }} Poster" class="object-contain h-full rounded-lg">
                                </div>
                                <a href="{{ route('movies.show', $movie->tmdb_id) }}" class="text-xl flex items-center font-semibold mb-2" style="min-height: 4rem;">
                                    {{ $movie->title }}
                                </a>
                                <div class="ml-auto text-gray-700">
                                    スコア：{{ round($movie->custom_score, 2) ?? 'N/A' }}
                                </div>
                                <svg width="24px" height="24px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M9.15316 5.40838C10.4198 3.13613 11.0531 2 12 2C12.9469 2 13.5802 3.13612 14.8468 5.40837L15.1745 5.99623C15.5345 6.64193 15.7144 6.96479 15.9951 7.17781C16.2757 7.39083 16.6251 7.4699 17.3241 7.62805L17.9605 7.77203C20.4201 8.32856 21.65 8.60682 21.9426 9.54773C22.2352 10.4886 21.3968 11.4691 19.7199 13.4299L19.2861 13.9372C18.8096 14.4944 18.5713 14.773 18.4641 15.1177C18.357 15.4624 18.393 15.8341 18.465 16.5776L18.5306 17.2544C18.7841 19.8706 18.9109 21.1787 18.1449 21.7602C17.3788 22.3417 16.2273 21.8115 13.9243 20.7512L13.3285 20.4768C12.6741 20.1755 12.3469 20.0248 12 20.0248C11.6531 20.0248 11.3259 20.1755 10.6715 20.4768L10.0757 20.7512C7.77268 21.8115 6.62118 22.3417 5.85515 21.7602C5.08912 21.1787 5.21588 19.8706 5.4694 17.2544L5.53498 16.5776C5.60703 15.8341 5.64305 15.4624 5.53586 15.1177C5.42868 14.773 5.19043 14.4944 4.71392 13.9372L4.2801 13.4299C2.60325 11.4691 1.76482 10.4886 2.05742 9.54773C2.35002 8.60682 3.57986 8.32856 6.03954 7.77203L6.67589 7.62805C7.37485 7.4699 7.72433 7.39083 8.00494 7.17781C8.28555 6.96479 8.46553 6.64194 8.82547 5.99623L9.15316 5.40838Z" fill="#eab308"/>
                                </svg>
                            </div>
                        @endforeach

                    </ul>
                @endif
            </div>
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
                let currentTags = tagSearchInput.value ? tagSearchInput.value.split(',').map(t => t.trim()) : [];
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
