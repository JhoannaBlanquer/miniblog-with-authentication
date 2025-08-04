<x-layout>
    <div class="flex flex-col items-center justify-center min-h-screen bg-blue-100 font-sans">
        <div class="w-full max-w-md bg-white shadow-xl rounded-xl border border-[#00306D]/20 p-10">
            <h1 class="text-3xl font-extrabold text-[#00306D] mb-8 text-center">Welcome back</h1>
            <form action="{{ route('login') }}" method="post" class="space-y-6">
                @csrf

                {{-- Email --}}
                <div>
                    <label for="email" class="block mb-1 font-medium text-[#00306D]">Email</label>
                    <input type="text" name="email" value="{{ old('email') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 @error('email') ring-1 ring-red-500 @enderror"
                        required autofocus>
                    @error('email')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password --}}
                <div>
                    <label for="password" class="block mb-1 font-medium text-[#00306D]">Password</label>
                    <input type="password" name="password"
                        class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 @error('password') ring-1 ring-red-500 @enderror"
                        required>
                    @error('password')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Remember me & Forgot --}}
                <div class="flex items-center justify-between mb-2">
                    <div class="flex items-center">
                        <input type="checkbox" name="remember" id="remember" class="accent-[#00306D] mr-2">
                        <label for="remember" class="text-sm text-slate-700">Remember me</label>
                    </div>
                    <a href="{{ route('password.request') }}" class="text-[#00306D] hover:underline text-sm">Forgot your password?</a>
                </div>

                @error('failed')
                    <p class="text-red-600 text-sm text-center">{{ $message }}</p>
                @enderror

                {{-- Submit --}}
                <button type="submit" class="w-full bg-[#00306D] hover:bg-blue-900 text-white px-4 py-2 rounded transition font-semibold">
                    Login
                </button>
            </form>
        </div>
    </div>
</x-layout>