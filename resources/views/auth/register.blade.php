<x-layout>
    <h1 class="title">Register a new account</h1>

    <div class="mx-auto max-w-screen-sm card p-6 bg-white shadow rounded-md">

        <form action="{{ route('register') }}" method="post">
            @csrf

            {{-- Username --}}
            <div class="mb-4">
                <label for="name" class="block mb-1 font-medium">Username</label>
                <input type="text" name="name" value="{{old('name')}}"
                       class="input @error('name') ring-1 ring-red-500 @enderror">
                @error('name')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>

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

            {{-- Confirm Password --}}
            <div class="mb-8">
                <label for="password_confirmation" class="block mb-1 font-medium">Confirm Password</label>
                <input type="password" name="password_confirmation" 
                       class="input @error('password') ring-1 ring-red-500 @enderror">
            </div>

            {{-- Submit --}}
            <button class="btn">Register</button>
        </form>
    </div>
</x-layout>
