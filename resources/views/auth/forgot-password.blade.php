<x-layout>
    <div class="flex flex-col items-center justify-center min-h-screen font-sans">
        <div class="w-full max-w-md bg-white shadow-xl rounded-xl border border-[#00306D]/20 p-10">
            <h2 class="text-3xl font-extrabold text-[#00306D] mb-8 text-center">Reset Password</h2>

            <form action="" method="post" class="space-y-6">
                @csrf

                {{-- Token field --}}
                <input type="hidden" name="token" value="{{ $token ?? 'dummy-token' }}">

                {{-- Email --}}
                <div>
                    <label class="block mb-1 font-medium text-[#00306D]">Email</label>
                    <input type="email" name="email" class="input" required>
                </div>

                {{-- New Password --}}
                <div>
                    <label class="block mb-1 font-medium text-[#00306D]">New Password</label>
                    <input type="password" name="password" class="input" required>
                </div>

                {{-- Confirm Password --}}
                <div>
                    <label class="block mb-1 font-medium text-[#00306D]">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="input" required>
                </div>

                {{-- Submit Button --}}
                <button type="submit" class="w-full bg-[#00306D] hover:bg-blue-900 text-white px-4 py-2 rounded transition font-semibold">
                    Reset Password
                </button>
            </form>
        </div>
    </div>
</x-layout>