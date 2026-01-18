<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <h2 class="text-xl font-bold mb-4">Log in</h2>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div class="mb-4">
            <label for="email" class="block font-medium text-sm text-gray-700">Email</label>
            <input id="email" class="block mt-1 w-full border p-2 rounded" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500" />
        </div>

        <!-- Password -->
        <div class="mb-4">
            <label for="password" class="block font-medium text-sm text-gray-700">Password</label>
            <input id="password" class="block mt-1 w-full border p-2 rounded" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500" />
        </div>

        <!-- Remember Me -->
        <div class="block mb-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">Remember me</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4 gap-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                    Forgot your password?
                </a>
            @endif

            <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded">
                Log in
            </button>
        </div>

        <!-- Social Login Skeleton -->
        <div class="mt-6 border-t pt-4">
            <p class="text-center text-sm text-gray-500 mb-4">Or continue with</p>
            <div class="flex gap-2 justify-center">
                <a href="{{ route('social.redirect', 'google') }}" class="border px-4 py-2 rounded bg-white text-black hover:bg-gray-50">
                    Login with Google
                </a>
                <a href="{{ route('social.redirect', 'github') }}" class="border px-4 py-2 rounded bg-white text-black hover:bg-gray-50">
                    Login with GitHub
                </a>
            </div>
            
            <div class="mt-4 text-center">
                <a href="{{ route('register') }}" class="text-blue-600 underline text-sm">Don't have an account? Register</a>
            </div>
        </div>
    </form>
</x-guest-layout>
