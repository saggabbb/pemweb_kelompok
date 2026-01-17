<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Belantra') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            
            <!-- HEADER / NAVIGATION FRAMEWORK -->
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
                    <h1 class="text-3xl font-bold text-gray-900">
                        Belantra.
                    </h1>
                    
                    <nav class="space-x-4">
                        <a href="{{ url('/dashboard') }}" class="text-gray-700 hover:underline">Dashboard</a>
                        
                        <!-- Role Based Links -->
                        @if(auth()->user()->role->role_name === 'buyer')
                            <a href="{{ route('buyer.orders.index') }}" class="text-blue-600 hover:underline">My Orders</a>
                            <a href="{{ route('explore') }}" class="text-blue-600 hover:underline">Browse Products</a>
                            <a href="{{ route('buyer.cart.index') }}" class="text-blue-600 hover:underline">Cart</a>
                        @endif

                        @if(auth()->user()->role->role_name === 'seller')
                            <a href="{{ route('seller.products.index') }}" class="text-green-600 hover:underline">My Products</a>
                            <a href="{{ route('seller.orders.index') }}" class="text-green-600 hover:underline">Incoming Orders</a>
                        @endif

                        @if(auth()->user()->role->role_name === 'admin')
                            <a href="{{ route('admin.orders.index') }}" class="text-red-600 hover:underline">Manage Orders</a>
                        @endif

                        @if(auth()->user()->role->role_name === 'courier')
                            <a href="{{ route('courier.orders.index') }}" class="text-orange-600 hover:underline">Delivery Tasks</a>
                        @endif

                        <!-- Logout Form -->
                        <form method="POST" action="{{ route('logout') }}" class="inline-block ml-4">
                            @csrf
                            <button type="submit" class="text-gray-500 hover:text-gray-700 underline">
                                Log Out
                            </button>
                        </form>
                    </nav>
                </div>
            </header>

            <!-- MAIN CONTENT FRAMEWORK -->
            <main>
                <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
                    <!-- Flash Message -->
                     @if (session('success'))
                        <div class="bg-green-200 text-green-800 p-4 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif
                    
                    @if (session('error'))
                         <div class="bg-red-200 text-red-800 p-4 rounded mb-4">
                            {{ session('error') }}
                        </div>
                    @endif

                    <!-- Content Slot -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        {{ $slot }}
                    </div>
                </div>
            </main>
            
            <!-- FOOTER FRAMEWORK -->
            <footer class="bg-gray-200 py-4 mt-8">
                <div class="max-w-7xl mx-auto text-center text-gray-500">
                    &copy; 2026 Belantra Marketplace.
                </div>
            </footer>

        </div>
    </body>
</html>
