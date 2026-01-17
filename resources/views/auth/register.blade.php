<x-guest-layout>
    <h2 class="text-xl font-bold mb-4">Register</h2>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div class="mb-4">
            <label for="name" class="block font-medium text-sm text-gray-700">Name</label>
            <input id="name" class="block mt-1 w-full border p-2 rounded" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2 text-red-500" />
        </div>

        <!-- Email Address -->
        <div class="mb-4">
            <label for="email" class="block font-medium text-sm text-gray-700">Email</label>
            <input id="email" class="block mt-1 w-full border p-2 rounded" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500" />
        </div>

        <!-- Role Selection -->
        <div class="mb-4">
            <label for="role_id" class="block font-medium text-sm text-gray-700">Register as</label>
            <select id="role_id" name="role_id" class="block mt-1 w-full border p-2 rounded border-gray-300">
                <option value="2">Buyer (Pembeli)</option>
                <option value="3">Seller (Penjual)</option>
                <option value="4">Courier (Kurir)</option>
            </select>
            <x-input-error :messages="$errors->get('role_id')" class="mt-2 text-red-500" />
        </div>

        <!-- Password -->
        <div class="mb-4">
            <label for="password" class="block font-medium text-sm text-gray-700">Password</label>
            <input id="password" class="block mt-1 w-full border p-2 rounded" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500" />
        </div>

        <!-- Confirm Password -->
        <div class="mb-4">
            <label for="password_confirmation" class="block font-medium text-sm text-gray-700">Confirm Password</label>
            <input id="password_confirmation" class="block mt-1 w-full border p-2 rounded" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-500" />
        </div>

        <div class="flex items-center justify-end mt-4 gap-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                Already registered?
            </a>

            <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded">
                Register
            </button>
        </div>
    </form>
</x-guest-layout>
