@props(['post', 'full' => false])

<div class="{{ $full ? 'max-w-3xl mx-auto bg-white p-8 rounded-xl shadow-md' : 'relative bg-white rounded-xl shadow-md border border-[#00306D]/20 p-6 w-full h-full flex flex-col justify-between transition hover:shadow-lg' }}">
    
    {{-- Image --}}
    @if ($post->image)
        <img 
            src="{{ asset('storage/' . $post->image) }}" 
            alt="Post Image" 
            class="rounded-md mb-4 w-full 
                {{ $full ? 'object-contain max-h-[600px] mx-auto' : 'h-48 object-cover' }}">
    @endif

    {{-- Title --}}
    <h2 class="font-bold text-xl text-[#00306D]">{{ $post->title }}</h2>

    {{-- Author and Date --}}
    <div class="text-xs font-light mb-4 text-gray-600">
        <span>Posted {{ $post->created_at->diffForHumans() }} by </span>
        <a href="{{ route('posts.user', $post->user) }}" class="text-blue-500 font-medium">
            {{ $post->user->name }}
        </a>
    </div>

    {{-- Body --}}
    <div class="text-sm text-gray-800 {{ !$post->image ? 'mt-10 text-center' : '' }}">
        @if ($full)
            <div class="whitespace-pre-line leading-relaxed break-words max-w-full mb-4">
                {{ $post->body }}
            </div>
        @else
            <div class="line-clamp-5 mb-4">
                {{ Str::words($post->body, 30) }}
            </div>

            <div class="flex justify-end">
                <a href="{{ route('posts.show', $post) }}"
                    class="text-sm text-blue-600 font-medium hover:underline">
                    Read more &rarr;
                </a>
            </div>
        @endif
    </div>

    {{-- Like Button (fixed bottom-left, only for cards) --}}
    @if (!$full)
        <div class="absolute bottom-4 left-4">
            <form action="{{ route('posts.like', $post) }}" method="POST" class="inline-block">
                @csrf
                <button type="submit" class="text-blue-500 hover:text-blue-700 text-sm">
                    ❤️ Like ({{ $post->likes()->count() }})
                </button>
            </form>
        </div>
    @else
        {{-- Like Button for full post --}}
        <div class="mt-4">
            <form action="{{ route('posts.like', $post) }}" method="POST" class="inline-block">
                @csrf
                <button type="submit" class="text-blue-500 hover:text-blue-700 text-sm">
                    ❤️ Like ({{ $post->likes()->count() }})
                </button>
            </form>
        </div>
    @endif


    {{-- Display Comments in Full View --}}
    @if ($full)
    <div class="mt-4">
        <form action="{{ route('posts.comment', $post) }}" method="POST">
            @csrf
            <textarea name="body" rows="2" class="w-full p-2 border rounded" placeholder="Leave a comment..."></textarea>
            <button type="submit" class="btn mt-2">Comment</button>
        </form>

        <div class="mt-4 space-y-2">
            @foreach ($post->comments as $comment)
                <div class="border p-2 rounded bg-gray-50">
                    <p class="text-sm text-gray-800">
                        <strong>
                            {{ $comment->user ? $comment->user->name : 'Guest' }}:
                        </strong> {{ $comment->body }}
                    </p>
                    <p class="text-xs text-gray-500">{{ $comment->created_at->diffForHumans() }}</p>
                </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- Slot Area --}}
    <div class="flex items-center justify-end gap-4 mt-auto">
        {{ $slot }}
    </div>
</div>
