<x-layout>
    <h1 class="title"> Hello {{auth()->user()->name}}</h1>

    {{--Create Post--}}
    <div class="card mb-4">
        <h2 class="font-bold mb-4"> Create a new post</h2>

        {{--Session Message--}}
        @if (session('success'))
                <x-flashMsg msg="{{session('success')}}"/>
            @elseif (session('delete'))
                <x-flashMsg msg="{{session('delete')}}" bg="bg-red-500"/>
        @endif

        <form action="{{route('posts.store')}}" method="post">
        @csrf

        {{--Post Title--}}
        <div class="mb-4">
                <label for="title" class="block mb-1 font-medium">Post Title</label>
                <input type="text" name="title" value="{{old('title')}}"
                       class="input @error('title') ring-1 ring-red-500 @enderror">
                @error('title')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>

        {{--Post Body--}}
        <div class="mb-4">
                <label for="body" class="block mb-1 font-medium">Post Content</label>
                <textarea name="body" rows="5" class="input @error('title') ring-1 ring-red-500 @enderror">{{old('body')}}</textarea>
                
                @error('body')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>

        {{--Submit--}}
        <button class="btn">Create Post</button>

        </form>
    </div>

        {{--User Posts--}}
        <h2 class="font-bold mb-4"> Your Latest Posts</h2>

        <div class="grid grid-cols-2 gap-6">
        @foreach ( $posts as $post )
            <x-postCard :post="$post">
                {{--Update post--}}
                <a href="{{route('posts.edit', $post)}}" class="bg-green-500 text-white px-2 py-1 text-xs rounded-md">Update</a>

                {{--Delete post--}}
                <form action="{{route('posts.destroy', $post)}}" method="post">
                    @csrf
                    @method('DELETE')
                    <button class="bg-red-500 text-white px-2 py-1 text-xs rounded-md"> Delete</button>
                </form>
                </x-postCard>
        @endforeach
    </div>

</x-layout>

