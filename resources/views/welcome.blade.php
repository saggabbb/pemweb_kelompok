<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Belantra') }}</title>
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased bg-white dark:bg-gray-950 text-gray-900 dark:text-gray-100 font-sans selection:bg-indigo-500 selection:text-white">
        <div class="min-h-screen flex flex-col">
            <!-- Navbar -->
            <nav class="absolute top-0 w-full z-10 bg-transparent">
                <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-12">
                    <div class="flex justify-between h-20 items-center">
                        <div class="flex items-center">
                            <a href="{{ url('/') }}" class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white hover:opacity-80 transition-opacity">
                                Belantra.
                            </a>
                        </div>
                        <div class="flex items-center gap-6">
                            <!-- Dark Mode Toggle -->
                            <button onclick="toggleDarkMode()" class="p-2 text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white transition-colors focus:outline-none">
                                <svg class="hidden w-5 h-5 dark:block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                <svg class="w-5 h-5 dark:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
                            </button>

                            @if (Route::has('login'))
                                <div class="hidden sm:flex items-center gap-4">
                                    @auth
                                        <a href="{{ url('/dashboard') }}" class="text-sm font-medium text-gray-900 dark:text-white hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">Dashboard</a>
                                    @else
                                        <a href="{{ route('login') }}" class="text-sm font-medium text-gray-900 dark:text-white hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">Log in</a>
                                        @if (Route::has('register'))
                                            <a href="{{ route('register') }}" class="px-5 py-2.5 text-sm font-medium text-white bg-gray-900 dark:bg-white dark:text-gray-900 rounded-full hover:bg-gray-800 dark:hover:bg-gray-100 transition-all shadow-sm hover:shadow-md">Sign Up</a>
                                        @endif
                                    @endauth
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Hero Section -->
            <div class="flex-grow flex items-center justify-center relative overflow-hidden pt-20">
                <!-- Background decorative elements -->
                <div class="absolute top-0 left-0 w-full h-full overflow-hidden -z-10 pointer-events-none opacity-40 dark:opacity-20">
                    <div class="absolute -top-1/2 -right-1/4 w-[800px] h-[800px] rounded-full bg-indigo-50 dark:bg-indigo-900/30 blur-3xl"></div>
                    <div class="absolute top-1/2 -left-1/4 w-[600px] h-[600px] rounded-full bg-pink-50 dark:bg-pink-900/30 blur-3xl"></div>
                </div>

                <div class="text-center px-6 max-w-4xl mx-auto">
                    <span class="inline-block px-3 py-1 mb-6 text-xs font-semibold tracking-wider text-indigo-600 dark:text-indigo-400 uppercase bg-indigo-50 dark:bg-indigo-900/50 rounded-full">
                        New Collection 2026
                    </span>
                    <h1 class="text-5xl sm:text-7xl font-bold tracking-tight text-gray-900 dark:text-white mb-6 leading-tight">
                        Discover <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-purple-600 dark:from-indigo-400 dark:to-purple-400">Unique</span><br> Local Products.
                    </h1>
                    <p class="text-lg sm:text-xl text-gray-600 dark:text-gray-400 mb-10 max-w-2xl mx-auto leading-relaxed">
                        Curated marketplace for authentic local brands. Minimalist style, maximum quality.
                    </p>
                    
                    <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                        <a href="{{ route('explore') }}" class="w-full sm:w-auto px-8 py-4 text-base font-semibold text-white bg-gray-900 dark:bg-white dark:text-gray-900 rounded-full hover:bg-gray-800 dark:hover:bg-gray-100 transition-all shadow-lg hover:shadow-xl hover:-translate-y-0.5 flex items-center justify-center">
                            Start Exploring
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                        </a>
                        <a href="#features" class="w-full sm:w-auto px-8 py-4 text-base font-semibold text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-full hover:bg-gray-50 dark:hover:bg-gray-700 transition-all shadow-sm hover:shadow-md flex items-center justify-center">
                            Learn More
                        </a>
                    </div>
                </div>
            </div>

            <!-- Minimalist Features Section -->
            <div id="features" class="bg-white dark:bg-gray-950 py-24 border-t border-gray-100 dark:border-gray-900">
                 <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-12">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-12 text-left">
                        <div class="group p-6 rounded-2xl bg-gray-50 dark:bg-gray-900/50 hover:bg-white dark:hover:bg-gray-900 border border-transparent hover:border-gray-100 dark:hover:border-gray-800 transition-all duration-300">
                            <div class="w-12 h-12 flex items-center justify-center rounded-xl bg-indigo-100 dark:bg-indigo-900/50 text-indigo-600 dark:text-indigo-400 mb-6 group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                            </div>
                            <h3 class="text-xl font-bold mb-3 text-gray-900 dark:text-white">Secure & Trusted</h3>
                            <p class="text-gray-600 dark:text-gray-400 leading-relaxed text-sm">Every transaction is protected with state-of-the-art security systems and verified details.</p>
                        </div>
                        <div class="group p-6 rounded-2xl bg-gray-50 dark:bg-gray-900/50 hover:bg-white dark:hover:bg-gray-900 border border-transparent hover:border-gray-100 dark:hover:border-gray-800 transition-all duration-300">
                             <div class="w-12 h-12 flex items-center justify-center rounded-xl bg-purple-100 dark:bg-purple-900/50 text-purple-600 dark:text-purple-400 mb-6 group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                            </div>
                            <h3 class="text-xl font-bold mb-3 text-gray-900 dark:text-white">Fast Delivery</h3>
                            <p class="text-gray-600 dark:text-gray-400 leading-relaxed text-sm">Optimized logistics network ensures your products arrive safely and on time, every time.</p>
                        </div>
                         <div class="group p-6 rounded-2xl bg-gray-50 dark:bg-gray-900/50 hover:bg-white dark:hover:bg-gray-900 border border-transparent hover:border-gray-100 dark:hover:border-gray-800 transition-all duration-300">
                            <div class="w-12 h-12 flex items-center justify-center rounded-xl bg-pink-100 dark:bg-pink-900/50 text-pink-600 dark:text-pink-400 mb-6 group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                            </div>
                            <h3 class="text-xl font-bold mb-3 text-gray-900 dark:text-white">Curated Local</h3>
                            <p class="text-gray-600 dark:text-gray-400 leading-relaxed text-sm">Discover hidden gems from the best local artisans and small businesses around you.</p>
                        </div>
                    </div>
                 </div>
            </div>

            <!-- Simple Footer -->
            <footer class="bg-gray-50 dark:bg-gray-950 border-t border-gray-100 dark:border-gray-900 py-12">
                <div class="max-w-7xl mx-auto px-6 text-center">
                    <p class="text-gray-900 dark:text-white font-bold text-lg mb-4">Belantra.</p>
                    <p class="text-gray-500 dark:text-gray-500 text-sm">
                        &copy; {{ date('Y') }} Belantra Marketplace. Designed with precision.
                    </p>
                </div>
            </footer>
        </div>
    </body>
</html>
