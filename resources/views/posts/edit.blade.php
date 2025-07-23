<x-layout>

    <a href="{{route('dashboard')}}" class="block mb-2 text-xs text-blue-500">&larr; Go back to your dashboard</a>

    <div class="card">
        <h2 class="font-bold mb-4">Update your Post</h2>

        <form action="{{route('posts.update', $post)}}" method="post">
            @csrf
            @method('PUT')

            {{-- Post Title --}}
            <div class="mb-4">
                <label for="title" class="block mb-1 font-medium">Post Title</label>
                <input type="text" name="title" value="{{$post->title}}"
                       class="input @error('title') ring-1 ring-red-500 @enderror">
                @error('title')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>

            {{-- Post Body --}}
            <div class="mb-4">
                <label for="body" class="block mb-1 font-medium">Post Content</label>
                <textarea name="body" rows="5" class="input @error('title') ring-1 ring-red-500 @enderror">{{$post->body}}</textarea>
                @error('body')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>

            {{-- Submit --}}
            <button class="btn w-full">Update</button>
        </form>
    </div>

</x-layout>
