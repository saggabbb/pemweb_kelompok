<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Explore - {{ config('app.name', 'Belantra') }}</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-gray-50 dark:bg-gray-950 text-gray-900 dark:text-gray-100 font-sans selection:bg-indigo-500 selection:text-white">
    <div class="min-h-screen">
        <!-- Minimalist Navbar -->
        <nav class="bg-white/80 dark:bg-gray-900/80 backdrop-blur-md border-b border-gray-100 dark:border-gray-800 sticky top-0 z-50 transition-all duration-300">
            <div class="max-w-7xl mx-auto px-6 sm:px-8">
                <div class="flex justify-between items-center h-20">
                    <div class="flex items-center gap-8">
                        <a href="{{ url('/') }}" class="text-xl font-bold tracking-tight text-gray-900 dark:text-white">Belantra.</a>
                        
                        <!-- Search Bar -->
                        <form action="{{ route('explore') }}" method="GET" class="hidden md:block w-96 relative group">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search products, brands, etc..." 
                                   class="w-full rounded-full border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-400 focus:border-indigo-500 focus:bg-white dark:focus:bg-gray-900 focus:ring-0 transition-all text-sm pl-11 py-2.5 shadow-sm group-hover:shadow-md">
                            <span class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-indigo-500 transition-colors">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </span>
                        </form>
                    </div>

                    <div class="flex items-center gap-4">
                        <button onclick="toggleDarkMode()" class="p-2 text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white transition-colors focus:outline-none">
                            <svg class="hidden w-5 h-5 dark:block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            <svg class="w-5 h-5 dark:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
                        </button>
                        
                        @auth
                            <a href="{{ url('/dashboard') }}" class="text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">Log in</a>
                            <a href="{{ route('register') }}" class="px-5 py-2 text-sm font-medium text-white bg-gray-900 dark:bg-white dark:text-gray-900 rounded-full hover:bg-gray-800 dark:hover:bg-gray-100 transition-all shadow-sm">Sign Up</a>
                        @endauth
                    </div>
                </div>
                
                <!-- Mobile Search -->
                <div class="md:hidden py-4 border-t border-gray-100 dark:border-gray-800">
                    <form action="{{ route('explore') }}" method="GET" class="relative">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search products..." 
                               class="w-full rounded-full border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-400 focus:border-indigo-500 focus:ring-0 text-sm pl-11 py-2.5">
                         <span class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </span>
                    </form>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="max-w-7xl mx-auto px-6 sm:px-8 py-10">
            
            @if(isset($mode) && $mode === 'search')
                <!-- SEARCH RESULTS MODE -->
                <div class="mb-10 flex items-end justify-between">
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400 uppercase tracking-wider font-medium mb-1">Results for</p>
                        <h2 class="text-3xl font-bold text-gray-900 dark:text-white">"{{ $search }}"</h2>
                    </div>
                    <span class="text-sm font-medium px-3 py-1 bg-gray-100 dark:bg-gray-800 rounded-full text-gray-600 dark:text-gray-400">
                        {{ $products->total() }} items
                    </span>
                </div>

                @if($products->count() > 0)
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-x-8 gap-y-10">
                        @foreach($products as $product)
                            <div class="group relative">
                                <div class="aspect-[4/5] bg-gray-100 dark:bg-gray-800 rounded-2xl overflow-hidden relative mb-4">
                                    @if($product->image)
                                        <img src="{{ Storage::url($product->image) }}" alt="{{ $product->product_name }}" class="h-full w-full object-cover group-hover:scale-105 transition-transform duration-500 ease-out">
                                    @else
                                        <div class="flex items-center justify-center h-full text-gray-300 dark:text-gray-700">
                                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        </div>
                                    @endif
                                    
                                    <!-- Quick Action -->
                                    <div class="absolute bottom-4 right-4 translate-y-4 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-300">
                                         @auth
                                            <form action="{{ route('buyer.orders.store') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="items[0][product_id]" value="{{ $product->id }}">
                                                <input type="hidden" name="items[0][quantity]" value="1">
                                                <button type="submit" class="w-10 h-10 flex items-center justify-center bg-white dark:bg-gray-900 text-gray-900 dark:text-white rounded-full shadow-lg hover:bg-black hover:text-white dark:hover:bg-white dark:hover:text-black transition-colors">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                                </button>
                                            </form>
                                        @else
                                            <a href="{{ route('login') }}" class="w-10 h-10 flex items-center justify-center bg-white dark:bg-gray-900 text-gray-900 dark:text-white rounded-full shadow-lg hover:bg-black hover:text-white dark:hover:bg-white dark:hover:text-black transition-colors">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                            </a>
                                        @endauth
                                    </div>
                                </div>
                                
                                <div>
                                    <h3 class="font-semibold text-gray-900 dark:text-white text-lg leading-tight mb-1 truncate hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors cursor-pointer">{{ $product->product_name }}</h3>
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">{{ $product->category->category_name }}</p>
                                    <p class="font-bold text-gray-900 dark:text-white">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-12">
                        {{ $products->links() }}
                    </div>
                @else
                    <div class="text-center py-24">
                        <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-gray-50 dark:bg-gray-800 mb-6 text-gray-400">
                             <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">No products found</h3>
                        <p class="text-gray-500 dark:text-gray-400 max-w-sm mx-auto">We couldn't find any products matching your search. Try different keywords.</p>
                        <a href="{{ route('explore') }}" class="mt-8 inline-flex items-center px-6 py-3 border border-gray-300 dark:border-gray-700 shadow-sm text-sm font-medium rounded-full text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-900 hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                            Clear Search
                        </a>
                    </div>
                @endif

            @else
                <!-- CATEGORIES MODE (Default) -->
                <div class="text-center max-w-3xl mx-auto mb-16">
                     <h2 class="text-4xl font-bold tracking-tight text-gray-900 dark:text-white mb-4">
                        Explore Collections
                    </h2>
                    <p class="text-lg text-gray-500 dark:text-gray-400">
                        Dive into our curated categories to find exactly what you're looking for.
                    </p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($categories as $category)
                        <a href="{{ route('explore', ['search' => $category->category_name]) }}" class="group relative rounded-3xl overflow-hidden h-96 block">
                            <!-- Background Image -->
                            @php
                                $coverProduct = $category->products->first();
                                $bgImage = $coverProduct && $coverProduct->image ? Storage::url($coverProduct->image) : 'https://placehold.co/600x800/e2e8f0/64748b?text=' . urlencode($category->category_name);
                            @endphp
                            
                            <div class="absolute inset-0 bg-cover bg-center transition-transform duration-700 group-hover:scale-110" style="background-image: url('{{ $bgImage }}');"></div>
                            
                            <!-- Overlay Gradient -->
                            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent group-hover:from-black/90 transition-all duration-300"></div>
                            
                            <!-- Content -->
                            <div class="absolute bottom-0 left-0 p-8 w-full">
                                <h3 class="text-2xl font-bold text-white mb-2 translate-y-2 group-hover:translate-y-0 transition-transform duration-300">{{ $category->category_name }}</h3>
                                <div class="flex items-center text-white/80 text-sm font-medium opacity-0 group-hover:opacity-100 translate-y-4 group-hover:translate-y-0 transition-all duration-300 delay-75">
                                    <span>Browse Collection</span>
                                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif

        </main>
    </div>
</body>
</html>
