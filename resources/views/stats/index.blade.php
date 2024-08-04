<x-app-layout>
    <div class=" max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-6">
        <div class="sm:flex sm:space-x-4">
            <x-stats-card title="レビュー件数" :content="$reviewCount" />
            <x-stats-card title="作成したタグ" :content="$tagCount" />
            <x-stats-card title="平均スコア" :content="$avgScore" />
        </div>
            <div class="bg-white rounded py-6 px-4 flex flex-wrap space-x-2">
                <h2 class="w-full mb-4">タグコレクション</h2>
                
                @foreach($userTags as $tag)
                    <div
                        class="tag cursor-pointer bg-gray-200 rounded-full px-4 py-2 mb-2"
                        data-tag="{{ $tag->name }}"
                    >
                        <a href="{{ route('movies.ranked', ['tags' => $tag->name]) }}">
                        {{ $tag->name }}:{{ $tag->review_count }}</a>
                    </div>
                @endforeach
        </div>
        
    </div>
</x-app-layout>
