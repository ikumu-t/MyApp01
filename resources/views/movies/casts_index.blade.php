<x-app-layout>

<div class="container mx-auto px-4 py-8">
    <div class="mt-8">
        <h3 class="text-2xl font-semibold">Cast</h3>
        <div class="grid grid-cols-2 md:grid-cols-10 gap-4 mt-4">
            @foreach($movie->casts as $cast)
                <div class="flex flex-col items-center">
                    <img src="https://image.tmdb.org/t/p/w500{{ $cast->profile_path }}" alt="{{ $cast->name }} Image" class="object-contain h-48 w-full rounded-lg shadow-md"> <!-- 縦長に表示 -->
                    <p class="mt-2 text-sm font-medium">{{ $cast->name }}</p> <!-- テキストサイズを小さく調整 -->
                    <p class="text-gray-500 text-sm">{{ $cast->pivot->character }}</p> <!-- テキストサイズを小さく調整 -->
                </div>
            @endforeach
        </div>
    </div>
</div>
</x-app-layout>