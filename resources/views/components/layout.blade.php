<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ env('APP_NAME') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=PT+Serif&display=swap" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-100 text-slate-900 flex flex-col min-h-screen">

    {{-- Header --}}
    <header class="bg-[#00306D] shadow-lg">
        <nav class="flex justify-between items-center px-6 py-4 text-white">
            <a href="{{ route('posts.index') }}" class="nav-link">Home</a>

            @auth
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="round-btn overflow-hidden p-0 w-10 h-10 rounded-full">
                        <img src="{{ asset('images/profile.jpg') }}" alt="Profile" class="w-full h-full object-cover rounded-full" />
                    </button>

                    <div x-show="open" x-transition @click.outside="open = false"
                         class="absolute top-12 right-0 w-48 bg-white border border-[#00306D]/20 rounded-xl shadow-xl z-50 py-3 px-4 space-y-2 text-sm text-[#00306D]">
                        <p class="font-semibold">{{ auth()->user()->name }}</p>
                        <a href="{{ route('dashboard') }}" class="block rounded-md px-3 py-2 hover:bg-[#00306D]/10 transition">Dashboard</a>
                        <form action="{{ route('logout') }}" method="post">
                            @csrf
                            <button type="submit" class="w-full text-left px-3 py-2 hover:bg-red-100 transition">Logout</button>
                        </form>
                    </div>
                </div>
            @else
                <div class="flex items-center gap-4">
                    <a href="{{ route('login') }}" class="nav-link">Login</a>
                    <a href="{{ route('register') }}" class="nav-link">Register</a>
                </div>
            @endauth
        </nav>
    </header>

    {{-- Main content --}}
    <main class="flex-1">
        {{ $slot }}
    </main>

    {{-- Footer --}}
    <footer class="bg-[#00306D] text-white py-4 text-center text-sm mt-10">
        &copy; {{ date('Y') }} {{ env('APP_NAME') }}. All rights reserved.
    </footer>

</body>
</html>
