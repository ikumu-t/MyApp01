<x-app-layout>

    <div>
        <form action="{{ route('search') }}" method="GET">
            <input type="text" name="query" placeholder="Search movies...">
            <button type="submit">Search</button>
        </form>

        <h2>Searching Results</h2>
        <ul>
            @foreach($movies as $movie)
                <li>{{ $movie->title }}</li>
            @endforeach
        </ul>
    </div>

</x-app-layout>