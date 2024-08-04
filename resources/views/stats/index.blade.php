<x-app-layout>
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-6">
        <div class="sm:flex sm:space-x-4">
            <x-stats-card title="レビュー件数" :content="$reviewCount" />
            <x-stats-card title="作成したタグ" :content="$tagCount" />
            <x-stats-card title="平均スコア" :content="$avgScore" />
        </div>
        <div class="bg-white rounded py-6 px-4 flex flex-wrap space-x-4 relative">
            <div class="w-full flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold">タグコレクション</h2>
                <div class="flex items-center space-x-4">
                    <input type="checkbox" name="enableDelete" id="enableDelete" class="form-checkbox h-5 w-5 text-red-600">
                    <label for="enableDelete" class="text-gray-700">Delete</label>
                </div>
            </div>
            @foreach($userTags as $tag)
                <div
                    class="tag cursor-pointer bg-gray-200 rounded-full px-4 py-2 mb-2"
                    data-tag="{{ $tag->name }}"
                >
                    <a href="{{ route('movies.ranked', ['tags' => $tag->name]) }}" 
                       data-delete-url="{{ route('tags.destroy', $tag->id) }}"
                       class="tag-link">
                        {{ $tag->name }}:{{ $tag->review_count }}
                    </a>
                    <form id="delete-form-{{ $tag->id }}" action="{{ route('tags.destroy', $tag->id) }}" method="POST" style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
            @endforeach
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const enableDeleteCheckbox = document.getElementById('enableDelete');
            const tagLinks = document.querySelectorAll('.tag-link');
            const tags = document.querySelectorAll('.tag');

            function updateTagBackground() {
                tags.forEach(tag => {
                    if (enableDeleteCheckbox.checked) {
                        tag.classList.add('bg-red-300', 'text-white');
                        tag.classList.remove('bg-gray-200');
                    } else {
                        tag.classList.remove('bg-red-300', 'text-white');
                        tag.classList.add('bg-gray-200');
                    }
                });
            }

            enableDeleteCheckbox.addEventListener('change', function() {
                updateTagBackground();
            });

            tagLinks.forEach(tagLink => {
                tagLink.addEventListener('click', function(event) {
                    if (enableDeleteCheckbox.checked) {
                        event.preventDefault();
                        const deleteForm = document.getElementById('delete-form-' + this.dataset.deleteUrl.split('/').pop());
                        if (confirm('このタグを削除してもよろしいですか？')) {
                            deleteForm.submit();
                        }
                    }
                });
            });

            // 初期状態の背景色を設定
            updateTagBackground();
        });
    </script>
</x-app-layout>
