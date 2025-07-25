<x-layout>
    <a href="{{ route('dashboard') }}" class="inline-block text-base text-[#00306D] font-medium hover:underline mb-10 ml-5">&larr; Go back to your dashboard</a>

    <div class="w-full flex justify-center">
        <div class="w-full max-w-xl bg-white p-6 rounded-xl shadow-md border border-[#00306D]/20">
            <h2 class="font-bold text-2xl text-[#00306D] mb-4">Update your Post</h2>

            <form action="{{ route('posts.update', $post) }}" method="post"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- Post Title --}}
                <div class="mb-4">
                    <label for="title" class="block mb-1 font-medium">Post Title</label>
                    <input type="text" name="title" value="{{ $post->title }}"
                        class="input @error('title') ring-1 ring-red-500 @enderror">
                    @error('title')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Post Body --}}
                <div class="mb-4">
                    <label for="body" class="block mb-1 font-medium">Post Content</label>
                    <textarea name="body" rows="5"
                        class="input @error('body') ring-1 ring-red-500 @enderror">{{ $post->body }}</textarea>
                    @error('body')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>

                {{--Current Image--}}
                @if ($post->image)
                    <div class="h-64 rounded-md mb-4 w-1/4 object-cover overflow-hidden">
                        <label>Current photo</label>
                        <img src="{{ asset('storage/' . $post->image) }}" alt="Post Image">
                    </div>
                @endif

                {{-- Post Image --}}
                <div class="mb-4">
                    <input type="file" name="image" id="image"
                        class="file:mr-4 file:py-2 file:px-4 file:border-0 file:text-sm file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    @error('image')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>


                {{-- Submit --}}
                <button class="btn w-full">Update</button>
            </form>
        </div>
    </div>
</x-layout>