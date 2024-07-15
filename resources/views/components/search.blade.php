<form action="{{ route('search') }}" method="GET" class="relative flex items-center">
        <input type="text" name="query" placeholder="Search..." class="w-full py-2 px-4 rounded-lg border-2 border-gray-200 focus:outline-none focus:border-blue-500" />
        <button type="submit" class="ml-2" >
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a8 8 0 111 1l5 5-1 1-5-5a8 8 0 11-1-1m-7-3a6 6 0 11-1 1l-5 5 1 1 5-5a6 6 0 011-1m8.14-4.26a8 8 0 001.41 10.06l4.95 4.95-1.42 1.42-4.95-4.95a8 8 0 10-10.07-1.41l-1.42 1.42-1.41-1.42 1.42-1.42 1.41-1.42 1.42-1.42-1.42-1.41-1.42 1.41-1.42 1.42-1.42 1.42 1.42 1.41 1.42-1.41 1.42-1.42zM11 15a4 4 0 100-8 4 4 0 000 8z" />
            </svg>
        </button>
</form>