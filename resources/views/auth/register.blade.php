<x-layout>
    <div class="flex flex-col items-center justify-center min-h-screen font-sans">
        <div class="w-full max-w-md bg-white shadow-xl rounded-xl border border-[#00306D]/20 p-10">
            <h1 class="text-3xl font-extrabold text-[#00306D] mb-8 text-center">Register a new account</h1>
            <form action="{{ route('register') }}" method="post" class="space-y-6">
                @csrf

                {{-- Username --}}
                <div>
                    <label for="name" class="block mb-1 font-medium text-[#00306D]">Username</label>
                    <input type="text" name="name" value="{{ old('name') }}"
                        class="input @error('name') ring-1 ring-red-500 @enderror" required>
                    @error('name')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email --}}
                <div>
                    <label for="email" class="block mb-1 font-medium text-[#00306D]">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                        class="input @error('email') ring-1 ring-red-500 @enderror" required>
                    @error('email')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password --}}
                <div>
                    <label for="password" class="block mb-1 font-medium text-[#00306D]">Password</label>
                    <input type="password" name="password"
                        class="input @error('password') ring-1 ring-red-500 @enderror" required>
                    @error('password')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Confirm Password --}}
                <div>
                    <label for="password_confirmation" class="block mb-1 font-medium text-[#00306D]">Confirm Password</label>
                    <input type="password" name="password_confirmation"
                        class="input @error('password_confirmation') ring-1 ring-red-500 @enderror" required>
                </div>

                {{-- Submit --}}
                <button type="submit" class="w-full bg-[#00306D] hover:bg-blue-900 text-white px-4 py-2 rounded transition font-semibold">
                    Register
                </button>
            </form>
        </div>
    </div>
</x-layout>