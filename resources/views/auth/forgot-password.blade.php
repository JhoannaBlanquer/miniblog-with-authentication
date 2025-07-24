<x-layout>
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="w-full max-w-md bg-white p-6 rounded-xl shadow-md border border-[#00306D]/20">
            <h2 class="text-2xl font-bold text-[#00306D] mb-6 text-center">Reset Password</h2>

            <form action="" method="get" class="space-y-6">
                @csrf

                {{-- Token field (mock value for preview) --}}
                <input type="hidden" name="token" value="{{ $token ?? 'dummy-token' }}">

                {{-- Email --}}
                <div class="mb-4">
                    <label class="block mb-1 font-medium text-[#00306D]">Email</label>
                    <input type="email" name="email" class="input" required>
                </div>

                {{-- New Password --}}
                <div class="mb-4">
                    <label class="block mb-1 font-medium text-[#00306D]">New Password</label>
                    <input type="password" name="password" class="input" required>
                </div>

                {{-- Confirm Password --}}
                <div class="mb-6">
                    <label class="block mb-1 font-medium text-[#00306D]">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="input" required>
                </div>

                {{-- Submit Button --}}
                <button type="submit" class="btn w-full">Reset Password</button>
            </form>
        </div>
    </div>
</x-layout>
