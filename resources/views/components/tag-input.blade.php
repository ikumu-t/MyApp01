<div class="mt-4">
    <label for="tags" class="block text-gray-700">Tags</label>
    <div id="tag-container" class="w-full border rounded-lg p-2 flex flex-wrap">
        <!-- ここに動的にタグを追加する -->
    </div>
    <input type="text" id="tag-input" class="w-full border rounded-lg p-2 mt-2" placeholder="タグを入力">
    <input type="hidden" name="tags" id="tags" value="{{ $tags }}">
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const tagInput = document.getElementById('tag-input');
    const tagContainer = document.getElementById('tag-container');
    const hiddenTagInput = document.getElementById('tags');

    // 既存のタグを画面に表示
    const existingTags = hiddenTagInput.value ? hiddenTagInput.value.split(',') : [];
    existingTags.forEach(tag => {
        if (tag.trim() !== '') {
            addTag(tag.trim());
        }
    });

    function addTag(tag) {
        const tagElement = document.createElement('div');
        tagElement.classList.add('bg-blue-500', 'text-white', 'rounded', 'p-1', 'm-1', 'flex', 'items-center');
        tagElement.innerText = tag;

        const removeButton = document.createElement('button');
        removeButton.classList.add('ml-2', 'text-xs', 'text-red-500');
        removeButton.innerText = 'x';
        removeButton.onclick = () => {
            tagContainer.removeChild(tagElement);
            updateHiddenInput();
        };

        tagElement.appendChild(removeButton);
        tagContainer.appendChild(tagElement);
        updateHiddenInput();
    }

    function updateHiddenInput() {
        const tags = Array.from(tagContainer.children).map(el => el.textContent.replace('x', '').trim());
        hiddenTagInput.value = tags.join(',');
    }

    tagInput.addEventListener('keypress', function (event) {
        if (event.key === 'Enter' && tagInput.value.trim() !== '') {
            event.preventDefault();
            addTag(tagInput.value.trim());
            tagInput.value = '';
        }
    });
});
</script>
