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

            <form action="{{ route('posts.store') }}" method="post" enctype="multipart/form-data">
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

                {{-- Post Image --}}
                <div class="mb-4">
                    <input type="file" name="image" id="image"
                        class="file:mr-4 file:py-2 file:px-4 file:border-0 file:text-sm file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    @error('image')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Submit --}}
                <button class="btn">Create Post</button>
            </form>
        </div>
    </div>

    {{-- User Posts --}}
    <h2 class="text-2xl font-semibold text-[#00306D] mb-6 text-center">Your Latest Posts</h2>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 max-w-7xl mx-auto">
        @foreach ($posts as $post)
            <x-postCard :post="$post">
                {{-- Buttons inside postCard slot, bottom-left --}}
                <div class="mt-auto flex gap-2 pt-4">
                    <a href="{{ route('posts.edit', $post) }}"
                        class="bg-green-500 text-white px-2 py-1 text-xs rounded-md hover:bg-green-600 transition">
                        Update
                    </a>

                    <form action="{{ route('posts.destroy', $post) }}" method="post" class="inline">
                        @csrf
                        @method('DELETE')
                        <button class="bg-red-500 text-white px-2 py-1 text-xs rounded-md hover:bg-red-600 transition">
                            Delete
                        </button>
                    </form>
                </div>
            </x-postCard>
        @endforeach
    </div>
</x-layout>