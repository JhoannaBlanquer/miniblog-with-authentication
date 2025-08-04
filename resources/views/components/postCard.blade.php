@props(['post', 'full' => false])

<div class="{{ $full 
    ? 'max-w-3xl mx-auto bg-white p-8 rounded-xl shadow-md border border-[#00306D]/30 flex flex-col space-y-4' 
    : 'relative bg-white rounded-xl shadow-md border border-[#00306D]/100 p-6 w-full h-full flex flex-col justify-between transition hover:shadow-lg space-y-3' }}">

    {{-- Image --}}
    @if ($post->image)
        <img 
            src="{{ asset('storage/' . $post->image) }}" 
            alt="Post Image" 
            class="rounded-lg w-full mb-2
                {{ $full ? 'object-contain max-h-[400px] mx-auto' : 'h-48 object-cover' }}">
    @endif

    {{-- Title --}}
    <h2 class="font-bold text-xl text-[#00306D] leading-tight">{{ $post->title }}</h2>

    {{-- Author and Date --}}
    <div class="text-xs text-gray-600 mb-2">
        <span>Posted {{ $post->created_at->diffForHumans() }} by </span>
        <a href="{{ route('posts.user', $post->user) }}" class="text-blue-600 font-medium hover:underline">
            {{ $post->user->name }}
        </a>
    </div>

    {{-- Body --}}
    <div class="text-gray-800 text-sm">
        @if ($full)
            <div class="whitespace-pre-line leading-relaxed break-words">
                {{ $post->body }}
            </div>
        @else
            <div class="line-clamp-4">
                {{ Str::words($post->body, 30) }}
            </div>
        @endif
    </div>

    {{-- Read More --}}
    @unless($full)
        <div class="flex justify-end">
            <a href="{{ route('posts.show', $post) }}"
                class="text-sm text-blue-700 font-semibold hover:underline">
                Read more →
            </a>
        </div>
    @endunless

    {{-- Like Button --}}
    <div class="{{ $full ? 'mt-4' : 'absolute bottom-4 left-4' }}">
        <form action="{{ route('posts.like', $post) }}" method="POST" class="inline-block">
            @csrf
            <button type="submit" class="text-blue-600 hover:text-blue-800 text-sm font-semibold">
                ❤️ Like ({{ $post->likes()->count() }})
            </button>
        </form>
    </div>

    {{-- Comments --}}
    @if ($full)
        <div class="mt-6 space-y-4">
            <form action="{{ route('posts.comment', $post) }}" method="POST">
                @csrf
                <textarea name="body" rows="2" class="w-full p-2 border border-gray-300 rounded" placeholder="Leave a comment..."></textarea>
                <button type="submit" class="btn mt-2">Comment</button>
            </form>

            <div class="space-y-2">
                @foreach ($post->comments as $comment)
                    <div class="border border-gray-200 p-3 rounded bg-gray-50">
                        <p class="text-sm text-gray-800">
                            <strong>{{ $comment->user?->name ?? 'Guest' }}:</strong> {{ $comment->body }}
                        </p>
                        <p class="text-xs text-gray-500">{{ $comment->created_at->diffForHumans() }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    {{-- Slot --}}
    <div class="flex items-center justify-end gap-4 mt-auto pt-4">
        {{ $slot }}
    </div>
</div>