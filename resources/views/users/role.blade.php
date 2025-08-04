<x-layout>
    <div class="flex flex-col items-center justify-center min-h-screen font-sans">
        <div class="w-full max-w-md bg-white shadow-xl rounded-xl border border-[#00306D]/20 p-10">
            <h1 class="text-2xl font-bold text-[#00306D] mb-6 text-center">Assign Role to {{ $user->name }}</h1>

            <form method="POST" action="{{ route('users.role.update', $user->id) }}" class="space-y-6">
                @csrf

                <div>
                    <label for="role" class="block mb-1 font-medium text-[#00306D]">Role</label>
                    <select name="role" id="role"
                        class="input w-full @error('role') ring-1 ring-red-500 @enderror">
                        <option value="user" {{ $user->hasRole('user') ? 'selected' : '' }}>User</option>
                        <option value="admin" {{ $user->hasRole('admin') ? 'selected' : '' }}>Admin</option>
                    </select>
                    @error('role')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit"
                    class="w-full bg-[#00306D] hover:bg-blue-900 text-white px-4 py-2 rounded transition font-semibold">
                    Save Role
                </button>
            </form>
        </div>
    </div>
</x-layout>