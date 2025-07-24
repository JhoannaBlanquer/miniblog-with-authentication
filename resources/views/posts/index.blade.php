<x-layout>
    <!-- Banner -->
    <div class="relative w-full h-[500px] mb-8">
        <img src="{{ asset('images/banner.jpg') }}" alt="Banner" class="w-full h-full object-cover rounded-lg shadow">
        <div class="absolute inset-0 flex flex-col items-center justify-center bg-black bg-opacity-40 rounded-lg text-center px-4">
            <h2 class="text-white text-6xl font-extrabold pt-serif mb-6">
                Life is full of adventure.
            </h2>
            <button onclick="document.getElementById('latest-posts').scrollIntoView({ behavior: 'smooth' });"
                class="bg-[#00306D] text-white font-semibold px-6 py-3 rounded-lg shadow-md hover:bg-[#002550] transition">
                Explore Now
            </button>
        </div>
    </div>

    <!-- Page Title -->
    <h1 id="latest-posts" class="title text-center text-[#00306D]">Latest Posts</h1>

    <!-- Posts Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 max-w-6xl mx-auto">
        @foreach ($posts as $post)
            <x-postCard :post="$post" />
        @endforeach
    </div>
</x-layout>
