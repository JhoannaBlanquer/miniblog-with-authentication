<x-layout>
    <h1 class="text-3xl font-extrabold text-[#00306D] pt-serif mb-6 text-center mt-8">
        Hello {{ auth()->user()->name }}! <br>
            <span class="text-lg font-normal block mt-2 text-slate-700">
        Welcome to your dashboard. Ready to share a new adventure?
            </span>
    </h1>


    {{-- Create Post --}}
    <div class="w-full flex justify-center mb-10">
        <div class="w-full max-w-4xl bg-white shadow-xl rounded-xl border border-[#00306D]/20 p-10 space-y-6">

            <h2 class="text-2xl font-semibold text-[#00306D] mb-6">Create a new post</h2>

            {{-- Session Message --}}
            @if (session('success'))
                <x-flashMsg msg="{{ session('success') }}" />
            @elseif (session('delete'))
                <x-flashMsg msg="{{ session('delete') }}" bg="bg-red-500" />
            @endif

            <form action="{{ route('posts.store') }}" method="post">
                @csrf

                {{-- Post Title --}}
                <div class="mb-4">
                    <label for="title" class="block mb-1 font-medium text-[#00306D]">Post Title</label>
                    <input type="text" name="title" value="{{ old('title') }}"
                           class="input @error('title') ring-1 ring-red-500 @enderror">
                    @error('title')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Post Body --}}
                <div class="mb-4">
                    <label for="body" class="block mb-1 font-medium text-[#00306D]">Post Content</label>
                    <textarea name="body" rows="5"
                              class="input @error('body') ring-1 ring-red-500 @enderror">{{ old('body') }}</textarea>
                    @error('body')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Submit --}}
                <button class="btn">Create Post</button>
            </form>
        </div>
    </div>

    {{-- User Posts --}}
    <h2 class="text-2xl font-semibold text-[#00306D] mb-6">Your Latest Posts</h2>

    <div class="grid grid-cols-2 gap-6">
        @foreach ($posts as $post)
            <x-postCard :post="$post">
                {{-- Update post --}}
                <a href="{{ route('posts.edit', $post) }}"
                   class="bg-green-500 text-white px-2 py-1 text-xs rounded-md hover:bg-green-600 transition">
                    Update
                </a>

                {{-- Delete post --}}
                <form action="{{ route('posts.destroy', $post) }}" method="post" class="inline">
                    @csrf
                    @method('DELETE')
                    <button class="bg-red-500 text-white px-2 py-1 text-xs rounded-md hover:bg-red-600 transition">
                        Delete
                    </button>
                </form>
            </x-postCard>
        @endforeach
    </div>
</x-layout>