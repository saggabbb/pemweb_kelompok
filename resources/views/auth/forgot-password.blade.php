<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div class="mb-4">
            <label for="email" class="block font-medium text-sm text-gray-700">Email</label>
            <input id="email" class="block mt-1 w-full border p-2 rounded" type="email" name="email" value="{{ old('email') }}" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded">
                Email Password Reset Link
            </button>
        </div>
    </form>
</x-guest-layout>
