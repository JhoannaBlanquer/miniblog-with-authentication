<x-layout>
    <h1 class="title">Posts by {{ $user->name }}</h1>

    {{-- User's posts --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 max-w-7xl mx-auto">
        @foreach ($posts as $post)
            <x-postCard :post="$post"/>
        @endforeach
    </div>
</x-layout>
