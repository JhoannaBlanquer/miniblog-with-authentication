<x-layout>
    <h1 class="text-3xl font-extrabold text-[#00306D] pt-serif mb-6 text-center mt-8">
        Posts by {{ $user->name }}
        <span class="text-lg font-normal block mt-2 text-slate-700">
            Explore their latest thoughts and stories.
        </span>
    </h1>

    {{-- User's posts --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 max-w-7xl mx-auto">
        @foreach ($posts as $post)
            <x-postCard :post="$post" />
        @endforeach
    </div>
</x-layout>
