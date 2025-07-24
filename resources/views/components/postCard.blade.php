@props(['post', 'full' => false])

<div class="{{ $full ? 'max-w-3xl mx-auto bg-white p-8 rounded-xl shadow-md' : 'bg-white rounded-xl shadow-md border border-[#00306D]/20 p-6 w-full h-full flex flex-col justify-between transition hover:shadow-lg' }}">
    
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


    {{-- Slot Area --}}
    <div class="flex items-center justify-end gap-4 mt-auto">
        {{ $slot }}
    </div>
</div>
