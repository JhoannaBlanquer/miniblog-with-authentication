<x-layout>
    <h1 class="title">Welcome back</h1>

    <div class="mx-auto max-w-screen-sm card p-6 bg-white shadow rounded-md">

        <form action="{{ route('login') }}" method="post">
            @csrf

            {{-- Email --}}
            <div class="mb-4">
                <label for="email" class="block mb-1 font-medium">Email</label>
                <input type="text" name="email" value="{{old('email')}}"
                       class="input @error('email') ring-1 ring-red-500 @enderror">
                @error('email')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>

            {{-- Password --}}
            <div class="mb-4">
                <label for="password" class="block mb-1 font-medium">Password</label>
                <input type="password" name="password" 
                       class="input @error('password') ring-1 ring-red-500 @enderror">
                @error('password')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>

            {{-- Remember me --}}
            <div class="mb-4">
                <input type="checkbox" name="remember" id="remember">
                <label for="remember"> Remember me</label>
            </div>
            @error('failed')
                    <p class="error">{{ $message }}</p>
                @enderror


            {{-- Submit --}}
            <button class="btn">Login</button>
        </form>
    </div>
</x-layout>
