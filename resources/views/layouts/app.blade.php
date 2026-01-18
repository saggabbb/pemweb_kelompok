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
    <body class="font-sans antialiased bg-gray-50 dark:bg-gray-900 transition-colors duration-300">
        <div class="min-h-screen bg-gray-50 dark:bg-gray-900">
            
            <!-- Navigation with Hamburger Menu (All Devices) - Sticky -->
            <nav class="sticky top-0 z-50 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 shadow-sm">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center h-16">
                        <!-- Logo -->
                        <a href="{{ url('/') }}" class="text-2xl font-bold text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300 transition">
                            Belantra.
                        </a>

                        <!-- Search Bar (Browse Products) - Hidden on Homepage -->
                        @if(!request()->is('/'))
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
                                           class="block w-full pl-10 pr-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                                </div>
                            </form>
                        </div>
                        @endif

                        <!-- Hamburger Button (Always Visible) -->
                        <button onclick="toggleMobileMenu()" class="text-gray-700 dark:text-gray-300 focus:outline-none hover:text-indigo-600">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>
                    </div>
            </nav>

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white dark:bg-gray-800 shadow relative z-30">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Mobile Off-Canvas Menu -->
            <div id="mobileMenuOverlay" class="overlay fixed inset-0 bg-black bg-opacity-50 z-40" onclick="toggleMobileMenu()"></div>
            
            <div id="mobileMenu" class="mobile-menu fixed top-0 right-0 h-full w-80 bg-white dark:bg-gray-800 shadow-2xl z-50 overflow-hidden transform transition-transform duration-300 ease-in-out">
                <!-- Premium Header -->
                <div class="relative bg-gradient-to-r from-indigo-600 to-purple-700 p-5 text-white">
                    <div class="absolute top-0 right-0 -mr-8 -mt-8 w-24 h-24 rounded-full bg-white/10 blur-2xl"></div>
                    <div class="flex justify-between items-center relative z-10">
                        <h2 class="text-xl font-bold">Menu</h2>
                        <button onclick="toggleMobileMenu()" class="p-2 rounded-full bg-white/10 hover:bg-white/20 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Scrollable Content -->
                <div class="overflow-y-auto h-[calc(100%-120px)] py-4 px-4">
                    @auth
                    <!-- User Profile Section -->
                    <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-4 mb-4 border border-gray-100 dark:border-gray-700">
                        <div class="flex items-center gap-4">
                            <div class="relative">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=4F46E5&color=ffffff&size=64" 
                                     alt="Profile" 
                                     class="w-14 h-14 rounded-full border-2 border-indigo-500 shadow-sm">
                                <a href="{{ route('profile.edit') }}" class="absolute -bottom-1 -right-1 bg-indigo-600 text-white p-1 rounded-full hover:bg-indigo-700 shadow-lg transition-transform hover:scale-110" title="Edit Profile">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                    </svg>
                                </a>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="text-sm font-bold text-gray-900 dark:text-gray-100 truncate">{{ Auth::user()->name }}</h3>
                                <p class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ Auth::user()->email }}</p>
                                <span class="mt-1 inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800 dark:bg-indigo-900/50 dark:text-indigo-300">
                                    {{ ucfirst(Auth::user()->role->role_name) }}
                                </span>
                            </div>
                        </div>
                    </div>
                    @else
                    <!-- Guest State -->
                    <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-4 mb-4 text-center border border-gray-100 dark:border-gray-700">
                        <div class="w-12 h-12 bg-gray-200 dark:bg-gray-600 rounded-full mx-auto flex items-center justify-center mb-2">
                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <h3 class="text-gray-900 dark:text-white font-bold text-sm">Guest User</h3>
                        <div class="grid grid-cols-2 gap-2 mt-3">
                            <a href="{{ route('login') }}" class="flex justify-center items-center px-3 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-xs font-semibold transition-colors">Login</a>
                            <a href="{{ route('register') }}" class="flex justify-center items-center px-3 py-1.5 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200 rounded-lg text-xs font-semibold transition-colors">Register</a>
                        </div>
                    </div>
                    @endauth

                    <!-- Navigation Links -->
                    <div class="space-y-1">
                        <h4 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2 px-2">Navigation</h4>
                        
                        <a href="{{ url('/dashboard') }}" class="group flex items-center p-2.5 text-sm font-medium rounded-lg text-gray-700 dark:text-gray-200 hover:text-indigo-600 hover:bg-indigo-50 dark:hover:bg-white/5 transition-all">
                            <div class="mr-3 p-1.5 rounded-lg bg-gray-100 dark:bg-gray-700 group-hover:bg-indigo-100 dark:group-hover:bg-indigo-500/20 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                </svg>
                            </div>
                            Dashboard
                        </a>

                        @auth
                            @if(auth()->user()->role->role_name === 'buyer')
                            <a href="{{ route('buyer.orders.index') }}" class="group flex items-center p-2.5 text-sm font-medium rounded-lg text-gray-700 dark:text-gray-200 hover:text-indigo-600 hover:bg-indigo-50 dark:hover:bg-white/5 transition-all">
                                <div class="mr-3 p-1.5 rounded-lg bg-gray-100 dark:bg-gray-700 group-hover:bg-indigo-100 dark:group-hover:bg-indigo-500/20 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                    </svg>
                                </div>
                                My Orders
                            </a>
                            <a href="{{ route('buyer.cart.index') }}" class="group flex items-center p-2.5 text-sm font-medium rounded-lg text-gray-700 dark:text-gray-200 hover:text-indigo-600 hover:bg-indigo-50 dark:hover:bg-white/5 transition-all">
                                <div class="mr-3 p-1.5 rounded-lg bg-gray-100 dark:bg-gray-700 group-hover:bg-indigo-100 dark:group-hover:bg-indigo-500/20 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                </div>
                                Shopping Cart
                            </a>
                            @endif

                            @if(auth()->user()->role->role_name === 'seller')
                            <a href="{{ route('seller.products.index') }}" class="group flex items-center p-2.5 text-sm font-medium rounded-lg text-gray-700 dark:text-gray-200 hover:text-indigo-600 hover:bg-indigo-50 dark:hover:bg-white/5 transition-all">
                                <div class="mr-3 p-1.5 rounded-lg bg-gray-100 dark:bg-gray-700 group-hover:bg-indigo-100 dark:group-hover:bg-indigo-500/20 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                    </svg>
                                </div>
                                My Products
                            </a>
                            <a href="{{ route('seller.orders.index') }}" class="group flex items-center p-2.5 text-sm font-medium rounded-lg text-gray-700 dark:text-gray-200 hover:text-indigo-600 hover:bg-indigo-50 dark:hover:bg-white/5 transition-all">
                                <div class="mr-3 p-1.5 rounded-lg bg-gray-100 dark:bg-gray-700 group-hover:bg-indigo-100 dark:group-hover:bg-indigo-500/20 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                Incoming Orders
                            </a>
                            @endif

                            @if(auth()->user()->role->role_name === 'admin')
                            <a href="{{ route('admin.orders.index') }}" class="group flex items-center p-2.5 text-sm font-medium rounded-lg text-gray-700 dark:text-gray-200 hover:text-indigo-600 hover:bg-indigo-50 dark:hover:bg-white/5 transition-all">
                                <div class="mr-3 p-1.5 rounded-lg bg-gray-100 dark:bg-gray-700 group-hover:bg-indigo-100 dark:group-hover:bg-indigo-500/20 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                    </svg>
                                </div>
                                Manage Orders
                            </a>
                            <a href="{{ route('admin.users.index') }}" class="group flex items-center p-2.5 text-sm font-medium rounded-lg text-gray-700 dark:text-gray-200 hover:text-indigo-600 hover:bg-indigo-50 dark:hover:bg-white/5 transition-all">
                                <div class="mr-3 p-1.5 rounded-lg bg-gray-100 dark:bg-gray-700 group-hover:bg-indigo-100 dark:group-hover:bg-indigo-500/20 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                    </svg>
                                </div>
                                Manage Users
                            </a>
                            <a href="{{ route('admin.categories.index') }}" class="group flex items-center p-2.5 text-sm font-medium rounded-lg text-gray-700 dark:text-gray-200 hover:text-indigo-600 hover:bg-indigo-50 dark:hover:bg-white/5 transition-all">
                                <div class="mr-3 p-1.5 rounded-lg bg-gray-100 dark:bg-gray-700 group-hover:bg-indigo-100 dark:group-hover:bg-indigo-500/20 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                    </svg>
                                </div>
                                Categories
                            </a>
                            @endif

                            @if(auth()->user()->role->role_name === 'courier')
                            <a href="{{ route('courier.orders.index') }}" class="group flex items-center p-2.5 text-sm font-medium rounded-lg text-gray-700 dark:text-gray-200 hover:text-indigo-600 hover:bg-indigo-50 dark:hover:bg-white/5 transition-all">
                                <div class="mr-3 p-1.5 rounded-lg bg-gray-100 dark:bg-gray-700 group-hover:bg-indigo-100 dark:group-hover:bg-indigo-500/20 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"></path>
                                    </svg>
                                </div>
                                Delivery Tasks
                            </a>
                            @endif
                        @endauth

                        <a href="{{ route('explore') }}" class="group flex items-center p-2.5 text-sm font-medium rounded-lg text-gray-700 dark:text-gray-200 hover:text-indigo-600 hover:bg-indigo-50 dark:hover:bg-white/5 transition-all">
                            <div class="mr-3 p-1.5 rounded-lg bg-gray-100 dark:bg-gray-700 group-hover:bg-indigo-100 dark:group-hover:bg-indigo-500/20 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            Browse Products
                        </a>
                    </div>
                </div>

                <!-- Fixed Footer -->
                <div class="absolute bottom-0 left-0 right-0 p-3 bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 space-y-2">
                    <!-- Theme Toggle -->
                    <div class="flex items-center justify-between p-2 rounded-lg bg-gray-50 dark:bg-gray-700">
                        <div class="flex items-center text-xs font-medium text-gray-600 dark:text-gray-300">
                            <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                            </svg>
                            Dark Mode
                        </div>
                        <button id="theme-toggle" type="button" class="relative inline-flex h-5 w-9 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none" style="background-color: rgb(229, 231, 235);">
                            <span class="sr-only">Toggle theme</span>
                            <span id="theme-toggle-dot" class="pointer-events-none inline-block h-4 w-4 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out" style="transform: translateX(0px);"></span>
                        </button>
                    </div>

                    @auth
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="flex w-full items-center justify-center p-2 rounded-lg bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-400 hover:bg-red-100 dark:hover:bg-red-900/40 transition-colors text-xs font-semibold">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                            Sign Out
                        </button>
                    </form>
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
