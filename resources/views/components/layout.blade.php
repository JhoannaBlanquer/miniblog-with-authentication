<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ env('APP_NAME') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=PT+Serif&display=swap" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
@vite(['resources/css/app.css', 'resources/js/app.js'])
  </head>
  <body class="bg-slate-100 text-slate-900">
    <header class="bg-[#00306D] shadow-lg">
        <nav>
            <a href="{{ route('posts.index') }}" class="nav-link">Home</a>

            @auth
                <div class="relative grid place-items-center"
                x-data="{open:false}">
                    {{--Dropdown menu button--}}
                    <button @click="open = !open" type="button" class="round-btn">
                        <img src="https://static.vecteezy.com/system/resources/previews/028/171/245/non_2x/pink-flower-icon-free-png.png" alt="">
                    </button>

                    {{--Dropdown menu--}}
                    <div x-show="open"
                        x-transition
                        @click.outside="open=false"
                        class="absolute top-12 right-0 w-48 bg-white border border-[#00306D]/20 rounded-xl shadow-xl z-50 py-3 px-4 space-y-2 text-sm" >
                        <p class="font-semibold text-[#00306D] mb-1">{{ auth()->user()->name }}</p>

                        <a href="{{ route('dashboard') }}"
                        class="block rounded-md px-3 py-2 text-[#00306D] hover:bg-[#00306D]/10 transition-colors">Dashboard</a>

                        <form action="{{ route('logout') }}" method="post">
                            @csrf
                            <button type="submit"
                                class="w-full text-left rounded-md px-3 py-2 text-[#00306D] hover:bg-red-100 transition-colors">
                                Logout
                            </button>
                        </form>
                    </div>

                </div>
            @endauth

            @guest
            <div class="flex items-center gap-4">
                <a href="{{ route('login') }}" class="nav-link">Login</a>
                <a href="{{ route('register') }}" class="nav-link">Register</a>
            </div>
            @endguest
        </nav>
    </header>

    <main>
        {{$slot}}
    </main>

  </body>
</html>