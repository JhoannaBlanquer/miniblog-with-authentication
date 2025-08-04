<x-layout>
    <div class="mt-6 pl-6">
        <a href="{{ route('dashboard') }}" 
           class="inline-flex items-center px-4 py-2 rounded-lg bg-blue-50 text-blue-700 hover:bg-blue-100 transition text-sm font-semibold shadow-sm border border-blue-200">
            <svg xmlns="http://www.w3.org/2000/svg" 
                 fill="none" 
                 viewBox="0 0 24 24" 
                 stroke-width="1.5" 
                 stroke="currentColor" 
                 class="w-4 h-4 mr-2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
            </svg>
            Back to Dashboard
        </a>
    </div>

    <div class="w-full flex justify-center px-4">
        <div class="w-full max-w-2xl bg-white p-6 rounded-2xl shadow-md border border-[#00306D]/20 space-y-6">
            <h2 class="font-bold text-2xl text-[#00306D]">Update Your Post</h2>

            <form action="{{ route('posts.update', $post) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                @method('PUT')

                {{-- Title --}}
                <div>
                    <label for="title" class="block mb-1 text-sm font-semibold text-gray-700">Post Title</label>
                    <input 
                        type="text" 
                        name="title" 
                        value="{{ old('title', $post->title) }}" 
                        class="input w-full @error('title') ring-1 ring-red-500 @enderror"
                    >
                    @error('title')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Body --}}
                <div>
                    <label for="body" class="block mb-1 text-sm font-semibold text-gray-700">Post Content</label>
                    <textarea 
                        name="body" 
                        rows="5"
                        class="input w-full @error('body') ring-1 ring-red-500 @enderror"
                    >{{ old('body', $post->body) }}</textarea>
                    @error('body')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Current Image --}}
                @if ($post->image)
                    <div class="mb-4">
                        <label class="block mb-1 text-sm font-semibold text-gray-700">Current Photo</label>
                        <div class="rounded-md overflow-hidden w-full max-w-xs">
                            <img src="{{ asset('storage/' . $post->image) }}" alt="Post Image" class="object-cover w-full h-48 rounded-md border border-gray-200">
                        </div>
                    </div>
                @endif

                {{-- Upload New Image --}}
                <div>
                    <label for="image" class="block mb-1 text-sm font-semibold text-gray-700">Upload New Image</label>
                    <input 
                        type="file" 
                        name="image" 
                        id="image"
                        class="file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                    >
                    @error('image')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Submit --}}
                <div>
                    <button class="btn w-full">Update</button>
                </div>
            </form>
        </div>
    </div>
</x-layout>