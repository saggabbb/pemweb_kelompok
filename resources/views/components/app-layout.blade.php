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
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
        
        <style>
            /* Responsive Navbar Styles */
            .mobile-menu {
                transform: translateX(100%);
                transition: transform 0.3s ease-in-out;
            }
            
            .mobile-menu.active {
                transform: translateX(0);
            }
            
            .overlay {
                opacity: 0;
                visibility: hidden;
                transition: opacity 0.3s ease-in-out, visibility 0.3s ease-in-out;
            }
            
            .overlay.active {
                opacity: 1;
                visibility: visible;
            }
        </style>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            
            <!-- Responsive Navigation -->
            <nav class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex items-center">
                            <!-- Logo -->
                            <a href="{{ url('/dashboard') }}" class="text-2xl font-bold text-indigo-600 dark:text-indigo-400">
                                Belantra.
                            </a>
                        </div>

                        <!-- Desktop Navigation -->
                        <div class="hidden md:flex md:items-center md:space-x-6">
                            <a href="{{ url('/dashboard') }}" class="text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400">
                                Dashboard
                            </a>
                            
                            <!-- Role Based Links -->
                            @if(auth()->user()->role->role_name === 'buyer')
                                <a href="{{ route('buyer.orders.index') }}" class="text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400">
                                    My Orders
                                </a>
                                <a href="{{ route('explore') }}" class="text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400">
                                    Browse Products
                                </a>
                                <a href="{{ route('buyer.cart.index') }}" class="text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400">
                                    Cart
                                </a>
                            @endif

                            @if(auth()->user()->role->role_name === 'seller')
                                <a href="{{ route('seller.products.index') }}" class="text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400">
                                    My Products
                                </a>
                                <a href="{{ route('seller.orders.index') }}" class="text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400">
                                    Incoming Orders
                                </a>
                            @endif

                            @if(auth()->user()->role->role_name === 'admin')
                                <a href="{{ route('admin.orders.index') }}" class="text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400">
                                    Manage Orders
                                </a>
                                <a href="{{ route('admin.users.index') }}" class="text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400">
                                    Manage Users
                                </a>
                            @endif

                            @if(auth()->user()->role->role_name === 'courier')
                                <a href="{{ route('courier.orders.index') }}" class="text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400">
                                    Delivery Tasks
                                </a>
                            @endif

                            <!-- Edit Profile Link -->
                            <a href="{{ route('profile.edit') }}" class="text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400">
                                Edit Profile
                            </a>

                            <!-- Logout -->
                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                @csrf
                                <button type="submit" class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300">
                                    Log Out
                                </button>
                            </form>
                        </div>

                        <!-- Mobile Hamburger Button -->
                        <div class="md:hidden flex items-center">
                            <button onclick="toggleMobileMenu()" class="text-gray-700 dark:text-gray-300 focus:outline-none">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Mobile Off-Canvas Menu -->
            <div id="mobileMenuOverlay" class="overlay fixed inset-0 bg-black bg-opacity-50 z-40" onclick="toggleMobileMenu()"></div>
            
            <div id="mobileMenu" class="mobile-menu fixed top-0 right-0 h-full w-64 bg-white dark:bg-gray-800 shadow-xl z-50 overflow-y-auto">
                <div class="p-6">
                    <!-- Close Button -->
                    <div class="flex justify-end mb-6">
                        <button onclick="toggleMobileMenu()" class="text-gray-700 dark:text-gray-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <!-- Mobile Menu Items -->
                    <div class="space-y-4">
                        <a href="{{ url('/dashboard') }}" class="block text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 py-2">
                            Dashboard
                        </a>
                        
                        @if(auth()->user()->role->role_name === 'buyer')
                            <a href="{{ route('buyer.orders.index') }}" class="block text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 py-2">
                                My Orders
                            </a>
                            <a href="{{ route('explore') }}" class="block text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 py-2">
                                Browse Products
                            </a>
                            <a href="{{ route('buyer.cart.index') }}" class="block text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 py-2">
                                Cart
                            </a>
                        @endif

                        @if(auth()->user()->role->role_name === 'seller')
                            <a href="{{ route('seller.products.index') }}" class="block text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 py-2">
                                My Products
                            </a>
                            <a href="{{ route('seller.orders.index') }}" class="block text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 py-2">
                                Incoming Orders
                            </a>
                        @endif

                        @if(auth()->user()->role->role_name === 'admin')
                            <a href="{{ route('admin.orders.index') }}" class="block text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 py-2">
                                Manage Orders
                            </a>
                            <a href="{{ route('admin.users.index') }}" class="block text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 py-2">
                                Manage Users
                            </a>
                        @endif

                        @if(auth()->user()->role->role_name === 'courier')
                            <a href="{{ route('courier.orders.index') }}" class="block text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 py-2">
                                Delivery Tasks
                            </a>
                        @endif

                        <a href="{{ route('profile.edit') }}" class="block text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 py-2">
                            Edit Profile
                        </a>

                        <div class="border-t border-gray-200 dark:border-gray-700 pt-4 mt-4">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 py-2">
                                    Log Out
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        <script>
            function toggleMobileMenu() {
                const menu = document.getElementById('mobileMenu');
                const overlay = document.getElementById('mobileMenuOverlay');
                
                menu.classList.toggle('active');
                overlay.classList.toggle('active');
            }

            // Close menu when clicking on a link
            document.querySelectorAll('#mobileMenu a').forEach(link => {
                link.addEventListener('click', () => {
                    toggleMobileMenu();
                });
            });
        </script>
    </body>
</html>
