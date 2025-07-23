<x-layout>
    <h1 class="title">Posts by {{ $user->name }}</h1>

    {{--User's posts--}}
        <div class="grid grid-cols-2 gap-6">
        @foreach ( $posts as $post )
            <x-postCard :post="$post"/>
        @endforeach
    </div>
</x-layout>