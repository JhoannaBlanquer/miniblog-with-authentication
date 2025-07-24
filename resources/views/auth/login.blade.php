<x-layout>
    <div class="flex flex-col items-center justify-center min-h-[80vh] pt-8 px-4">
        <h1 class="text-4xl font-extrabold text-[#00306D] pt-serif mb-6">Welcome back</h1>

        <div class="w-full max-w-xl bg-white shadow-xl rounded-xl border border-[#00306D]/20 p-10">
            <form action="{{ route('login') }}" method="post" class="space-y-6">
                @csrf

                {{-- Email --}}
                <div>
                    <label for="email" class="block mb-1 font-medium text-[#00306D]">Email</label>
                    <input type="text" name="email" value="{{ old('email') }}"
                           class="input @error('email') ring-1 ring-red-500 @enderror">
                    @error('email')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password --}}
                <div>
                    <label for="password" class="block mb-1 font-medium text-[#00306D]">Password</label>
                    <input type="password" name="password"
                           class="input @error('password') ring-1 ring-red-500 @enderror">
                    @error('password')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Remember me --}}
                <div class="mb-4 flex justify-between iteams-center">
                    <div>
                    <input type="checkbox" name="remember" id="remember" class="accent-[#00306D]">
                    <label for="remember" class="text-sm text-slate-700">Remember me</label>
                    </div>

                <a href="{{ route('password.request') }}" class="text-[#00306D] hover:underline">Forgot your password?</a>
                </div>

                @error('failed')
                    <p class="error">{{ $message }}</p>
                @enderror

                {{-- Submit --}}
                <button class="btn">Login</button>
            </form>
        </div>
    </div>
</x-layout>
