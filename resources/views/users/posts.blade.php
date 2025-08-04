<x-layout>
    <h1 class="text-3xl font-extrabold text-[#00306D] pt-serif mb-10 text-center mt-12">
        Posts by {{ $user->name }}
        <span class="text-lg font-normal block mt-2 text-slate-700">
            Explore their latest thoughts and stories.
        </span>
    </h1>

    {{-- User's posts --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8 max-w-7xl mx-auto mb-20 px-4">
        @foreach ($posts as $post)
            <x-postCard :post="$post" class="min-h-[320px] rounded-2xl shadow-xl border border-[#00306D]/10 bg-white px-6 py-6" />
        @endforeach
    </div>
</x-layout>