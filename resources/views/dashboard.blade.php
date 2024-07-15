<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <div>
    @include('components.search')
    </div>
    <div>
        <h2>Popular</h2>
        <ul>
            @foreach($movies as $movie)
                <li>{{ $movie->title }}</li>
            @endforeach
        </ul>
    </div>
</x-app-layout>
