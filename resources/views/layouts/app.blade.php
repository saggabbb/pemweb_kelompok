<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            // Configure Tailwind dark mode
            tailwind.config = {
                darkMode: 'class'
            }
        </script>
        
        <!-- Dark Mode Script - Load ASAP to prevent flash -->
        <script>
            // Apply theme immediately before page renders
            (function() {
                const theme = localStorage.getItem('theme') || 'light';
                if (theme === 'dark') {
                    document.documentElement.classList.add('dark');
                } else {
                    document.documentElement.classList.remove('dark');
                }
            })();
        </script>
        
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
            
            <!-- Navigation with Hamburger Menu (All Devices) -->
            <nav class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center h-16">
                        <!-- Logo -->
                        <a href="{{ url('/') }}" class="text-2xl font-bold text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300 transition">
                            Belantra.
                        </a>

                        <!-- Search Bar (Browse Products) -->
                        <div class="flex-1 max-w-2xl mx-4">
                            <form action="{{ route('explore') }}" method="GET" class="relative">
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                        </svg>
                                    </div>
                                    <input type="text" 
                                           name="search" 
                                           placeholder="Search products..." 
                                           value="{{ request('search') }}"
                                           class="block w-full pl-10 pr-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg leading-5 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                </div>
                            </form>
                        </div>

                        <!-- Hamburger Button (Always Visible) -->
                        <button onclick="toggleMobileMenu()" class="text-gray-700 dark:text-gray-300 focus:outline-none hover:text-indigo-600">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </nav>

            <!-- Mobile Off-Canvas Menu -->
            <div id="mobileMenuOverlay" class="overlay fixed inset-0 bg-black bg-opacity-50 z-40" onclick="toggleMobileMenu()"></div>
            
            <div id="mobileMenu" class="mobile-menu fixed top-0 right-0 h-full w-80 bg-white dark:bg-gray-800 shadow-xl z-50 overflow-y-auto">
                <div class="p-6">
                    <!-- Close Button -->
                    <div class="flex justify-end mb-4">
                        <button onclick="toggleMobileMenu()" class="text-gray-700 dark:text-gray-300 hover:text-red-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    @auth
                    <!-- User Profile Photo & Info -->
                    <div class="flex flex-col items-center mb-6 pb-6 border-b border-gray-200 dark:border-gray-700">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=4F46E5&color=ffffff&size=128" 
                             alt="Profile Photo" 
                             class="w-24 h-24 rounded-full border-4 border-indigo-600 mb-3">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100">{{ Auth::user()->name }}</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ Auth::user()->email }}</p>
                        <span class="mt-2 px-3 py-1 bg-indigo-100 dark:bg-indigo-900 text-indigo-800 dark:text-indigo-200 text-xs font-semibold rounded-full uppercase">
                            {{ Auth::user()->role->role_name }}
                        </span>
                    </div>

                    <!-- Edit Profile - FIRST -->
                    <div class="mb-4">
                        <a href="{{ route('profile.edit') }}" class="flex items-center text-gray-700 dark:text-gray-300 hover:bg-indigo-50 dark:hover:bg-indigo-900 hover:text-indigo-600 dark:hover:text-indigo-400 py-3 px-4 rounded-lg transition">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Edit Profile
                        </a>
                    </div>

                    <div class="border-t border-gray-200 dark:border-gray-700 pt-4 mb-4"></div>
                    @else
                    <!-- Guest User -->
                    <div class="flex flex-col items-center mb-6 pb-6 border-b border-gray-200 dark:border-gray-700">
                        <div class="w-24 h-24 rounded-full bg-gray-300 dark:bg-gray-600 flex items-center justify-center mb-3">
                            <svg class="w-12 h-12 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100">Guest</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Please login to continue</p>
                    </div>

                    <!-- Login/Register Links -->
                    <div class="mb-4 space-y-2">
                        <a href="{{ route('login') }}" class="flex items-center text-gray-700 dark:text-gray-300 hover:bg-indigo-50 dark:hover:bg-indigo-900 hover:text-indigo-600 dark:hover:text-indigo-400 py-3 px-4 rounded-lg transition">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                            </svg>
                            Login
                        </a>
                        <a href="{{ route('register') }}" class="flex items-center text-gray-700 dark:text-gray-300 hover:bg-indigo-50 dark:hover:bg-indigo-900 hover:text-indigo-600 dark:hover:text-indigo-400 py-3 px-4 rounded-lg transition">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                            </svg>
                            Register
                        </a>
                    </div>

                    <div class="border-t border-gray-200 dark:border-gray-700 pt-4 mb-4"></div>
                    @endauth

                    <!-- Theme Toggle with Dynamic Text -->
                    <div class="mb-4 p-4 bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 rounded-lg transition-all duration-300">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <!-- Animated Icon Container -->
                                <div class="relative w-8 h-8 flex items-center justify-center">
                                    <!-- Sun Icon (Light Mode) -->
                                    <svg id="sun-icon" class="absolute w-5 h-5 text-amber-500 transition-all duration-300 transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                    </svg>
                                    <!-- Moon Icon (Dark Mode) -->
                                    <svg id="moon-icon" class="absolute w-5 h-5 text-indigo-400 transition-all duration-300 transform opacity-0 scale-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                                    </svg>
                                </div>
                                <!-- Dynamic Text -->
                                <span id="theme-text" class="text-sm font-semibold text-gray-700 dark:text-gray-200 transition-all duration-300">
                                    Light Mode
                                </span>
                            </div>
                            <!-- Toggle Switch -->
                            <button id="theme-toggle" type="button" class="relative inline-flex h-7 w-12 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-all duration-300 ease-in-out focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 shadow-md hover:shadow-lg" style="background-color: rgb(229, 231, 235);">
                                <span class="sr-only">Toggle theme</span>
                                <span id="theme-toggle-dot" class="pointer-events-none inline-block h-6 w-6 transform rounded-full bg-white shadow-lg ring-0 transition-all duration-300 ease-in-out" style="transform: translateX(0px);"></span>
                            </button>
                        </div>
                    </div>

                    <div class="border-t border-gray-200 dark:border-gray-700 pt-4 mb-4"></div>

                    <div class="space-y-2">
                        <a href="{{ url('/dashboard') }}" class="flex items-center text-gray-700 dark:text-gray-300 hover:bg-indigo-50 dark:hover:bg-indigo-900 hover:text-indigo-600 dark:hover:text-indigo-400 py-3 px-4 rounded-lg transition">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                            Dashboard
                        </a>
                        
                        @auth
                        @if(auth()->user()->role->role_name === 'buyer')
                            <a href="{{ route('buyer.orders.index') }}" class="flex items-center text-gray-700 dark:text-gray-300 hover:bg-indigo-50 dark:hover:bg-indigo-900 hover:text-indigo-600 dark:hover:text-indigo-400 py-3 px-4 rounded-lg transition">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                                My Orders
                            </a>
                            <a href="{{ route('buyer.cart.index') }}" class="flex items-center text-gray-700 dark:text-gray-300 hover:bg-indigo-50 dark:hover:bg-indigo-900 hover:text-indigo-600 dark:hover:text-indigo-400 py-3 px-4 rounded-lg transition">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                Cart
                            </a>
                        @endif

                        @if(auth()->user()->role->role_name === 'seller')
                            <a href="{{ route('seller.products.index') }}" class="flex items-center text-gray-700 dark:text-gray-300 hover:bg-indigo-50 dark:hover:bg-indigo-900 hover:text-indigo-600 dark:hover:text-indigo-400 py-3 px-4 rounded-lg transition">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                                My Products
                            </a>
                            <a href="{{ route('seller.orders.index') }}" class="flex items-center text-gray-700 dark:text-gray-300 hover:bg-indigo-50 dark:hover:bg-indigo-900 hover:text-indigo-600 dark:hover:text-indigo-400 py-3 px-4 rounded-lg transition">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                                Incoming Orders
                            </a>
                        @endif

                        @if(auth()->user()->role->role_name === 'admin')
                            <a href="{{ route('admin.orders.index') }}" class="flex items-center text-gray-700 dark:text-gray-300 hover:bg-indigo-50 dark:hover:bg-indigo-900 hover:text-indigo-600 dark:hover:text-indigo-400 py-3 px-4 rounded-lg transition">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                                Manage Orders
                            </a>
                            <a href="{{ route('admin.users.index') }}" class="flex items-center text-gray-700 dark:text-gray-300 hover:bg-indigo-50 dark:hover:bg-indigo-900 hover:text-indigo-600 dark:hover:text-indigo-400 py-3 px-4 rounded-lg transition">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                                Manage Users
                            </a>
                        @endif

                        @if(auth()->user()->role->role_name === 'courier')
                            <a href="{{ route('courier.orders.index') }}" class="flex items-center text-gray-700 dark:text-gray-300 hover:bg-indigo-50 dark:hover:bg-indigo-900 hover:text-indigo-600 dark:hover:text-indigo-400 py-3 px-4 rounded-lg transition">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"></path>
                                </svg>
                                Delivery Tasks
                            </a>
                        @endif
                        @endauth
                    </div>

                    @auth
                    <!-- Logout -->
                    <div class="border-t border-gray-200 dark:border-gray-700 pt-4 mt-4">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="flex items-center w-full text-red-600 hover:bg-red-50 dark:hover:bg-red-900 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 py-3 px-4 rounded-lg transition">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                </svg>
                                Log Out
                            </button>
                        </form>
                    </div>
                    @endauth
                </div>
            </div>

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        <script>
            // Mobile Menu Toggle
            function toggleMobileMenu() {
                const menu = document.getElementById('mobileMenu');
                const overlay = document.getElementById('mobileMenuOverlay');
                
                menu.classList.toggle('active');
                overlay.classList.toggle('active');
            }

            // Theme Toggle - Run after DOM loaded
            document.addEventListener('DOMContentLoaded', function() {
                const themeToggle = document.getElementById('theme-toggle');
                const themeToggleDot = document.getElementById('theme-toggle-dot');
                const themeText = document.getElementById('theme-text');
                const sunIcon = document.getElementById('sun-icon');
                const moonIcon = document.getElementById('moon-icon');
                const htmlElement = document.documentElement;
                
                // Function to update UI based on theme
                function updateThemeUI(isDark) {
                    if (isDark) {
                        // Dark mode active
                        themeToggle.style.backgroundColor = 'rgb(79, 70, 229)'; // indigo-600
                        themeToggleDot.style.transform = 'translateX(20px)';
                        themeText.textContent = 'Dark Mode';
                        
                        // Icons transition
                        sunIcon.style.opacity = '0';
                        sunIcon.style.transform = 'scale(0) rotate(-180deg)';
                        moonIcon.style.opacity = '1';
                        moonIcon.style.transform = 'scale(1) rotate(0deg)';
                    } else {
                        // Light mode active
                        themeToggle.style.backgroundColor = 'rgb(229, 231, 235)'; // gray-200
                        themeToggleDot.style.transform = 'translateX(0px)';
                        themeText.textContent = 'Light Mode';
                        
                        // Icons transition
                        sunIcon.style.opacity = '1';
                        sunIcon.style.transform = 'scale(1) rotate(0deg)';
                        moonIcon.style.opacity = '0';
                        moonIcon.style.transform = 'scale(0) rotate(180deg)';
                    }
                }
                
                // Check for saved theme preference
                const currentTheme = localStorage.getItem('theme') || 'light';
                const isDarkMode = currentTheme === 'dark';
                
                // Apply initial theme
                if (isDarkMode) {
                    htmlElement.classList.add('dark');
                }
                updateThemeUI(isDarkMode);
                
                // Toggle theme on button click
                if (themeToggle) {
                    themeToggle.addEventListener('click', function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                        
                        const isDark = htmlElement.classList.contains('dark');
                        
                        if (isDark) {
                            // Switch to light mode
                            htmlElement.classList.remove('dark');
                            localStorage.setItem('theme', 'light');
                            updateThemeUI(false);
                            console.log('Theme toggled to: light');
                        } else {
                            // Switch to dark mode
                            htmlElement.classList.add('dark');
                            localStorage.setItem('theme', 'dark');
                            updateThemeUI(true);
                            console.log('Theme toggled to: dark');
                        }
                    });
                } else {
                    console.error('Theme toggle button not found');
                }
            });

            // Close menu when clicking on a link
            document.querySelectorAll('#mobileMenu a').forEach(link => {
                link.addEventListener('click', () => {
                    toggleMobileMenu();
                });
            });
        </script>
    </body>
</html>
