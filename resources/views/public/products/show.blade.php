<x-app-layout>
    <div class="py-8 bg-gradient-to-b from-gray-50 to-white dark:from-gray-900 dark:to-gray-800 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Breadcrumb -->
            <nav class="flex mb-8" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ url('/') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-indigo-600 dark:text-gray-400 dark:hover:text-white">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                            </svg>
                            Home
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <a href="{{ route('explore') }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-indigo-600 dark:text-gray-400 dark:hover:text-white md:ml-2">Products</a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="ml-1 text-sm font-medium text-gray-500 dark:text-gray-400 md:ml-2">{{ $product->product_name }}</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <!-- Product Detail Section -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden border border-gray-100 dark:border-gray-700">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 p-8">
                    
                    <!-- Product Image -->
                    <div class="relative">
                        <div class="sticky top-24">
                            <div class="aspect-square bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-800 rounded-2xl overflow-hidden shadow-lg">
                                @if($product->image)
                                    <img src="{{ Storage::url($product->image) }}" 
                                         alt="{{ $product->product_name }}" 
                                         class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <svg class="w-32 h-32 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Category Badge -->
                            <div class="absolute top-4 left-4">
                                <span class="inline-flex items-center px-4 py-2 bg-white/95 dark:bg-gray-900/95 backdrop-blur-sm rounded-full text-sm font-semibold text-indigo-600 dark:text-indigo-400 shadow-lg">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                    </svg>
                                    {{ $product->category->category_name }}
                                </span>
                            </div>

                            <!-- Stock Badge -->
                            @if($product->stock > 0 && $product->stock < 10)
                                <div class="absolute top-4 right-4">
                                    <span class="inline-flex items-center px-4 py-2 bg-red-500/95 backdrop-blur-sm rounded-full text-sm font-semibold text-white shadow-lg animate-pulse">
                                        🔥 Only {{ $product->stock }} left!
                                    </span>
                                </div>
                            @elseif($product->stock == 0)
                                <div class="absolute top-4 right-4">
                                    <span class="inline-flex items-center px-4 py-2 bg-gray-500/95 backdrop-blur-sm rounded-full text-sm font-semibold text-white shadow-lg">
                                        Out of Stock
                                    </span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Product Info -->
                    <div class="flex flex-col">
                        <div class="flex-1">
                            <!-- Product Name -->
                            <h1 class="text-4xl font-extrabold text-gray-900 dark:text-white mb-4 leading-tight">
                                {{ $product->product_name }}
                            </h1>

                            <!-- Seller Info -->
                            <div class="flex items-center gap-4 mb-6 p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
                                <div class="flex-shrink-0">
                                    <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full flex items-center justify-center">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Sold by</p>
                                    <p class="font-semibold text-gray-900 dark:text-white">{{ $product->seller->name }}</p>
                                </div>
                            </div>

                            <!-- Price -->
                            <div class="mb-8">
                                <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">Price</p>
                                <p class="text-5xl font-extrabold bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 to-purple-600">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </p>
                            </div>

                            <!-- Description -->
                            <div class="mb-8">
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                                    <svg class="w-6 h-6 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Product Details
                                </h3>
                                <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                                    {{ $product->description }}
                                </p>
                            </div>

                            <!-- Stock Info -->
                            <div class="mb-8 p-4 bg-gradient-to-r from-indigo-50 to-purple-50 dark:from-indigo-900/20 dark:to-purple-900/20 rounded-xl border border-indigo-100 dark:border-indigo-800">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 mr-2 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                        </svg>
                                        <span class="font-semibold text-gray-900 dark:text-white">Stock Available</span>
                                    </div>
                                    <span class="text-2xl font-bold text-indigo-600 dark:text-indigo-400">{{ $product->stock }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Add to Cart Section -->
                        @if($product->stock > 0)
                            <form action="{{ route('buyer.cart.store') }}" method="POST" class="space-y-6">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                
                                <!-- Quantity Selector -->
                                <div>
                                    <label for="quantity" class="block text-sm font-semibold text-gray-900 dark:text-white mb-3">
                                        Quantity
                                    </label>
                                    <div class="flex items-center gap-4">
                                        <button type="button" onclick="decreaseQuantity()" class="w-12 h-12 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-xl font-bold text-gray-700 dark:text-gray-300 transition">
                                            -
                                        </button>
                                        <input type="number" 
                                               name="quantity" 
                                               id="quantity" 
                                               min="1" 
                                               max="{{ $product->stock }}" 
                                               value="1" 
                                               class="w-24 h-12 text-center text-xl font-bold border-2 border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-4 focus:ring-indigo-500 focus:border-indigo-500">
                                        <button type="button" onclick="increaseQuantity({{ $product->stock }})" class="w-12 h-12 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-xl font-bold text-gray-700 dark:text-gray-300 transition">
                                            +
                                        </button>
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="flex gap-4">
                                    @auth
                                        <button type="submit" class="flex-1 group flex items-center justify-center px-8 py-4 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl font-bold text-lg hover:from-indigo-700 hover:to-purple-700 transition-all duration-300 shadow-lg hover:shadow-2xl hover:-translate-y-1">
                                            <svg class="w-6 h-6 mr-2 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                            </svg>
                                            Add to Cart
                                        </button>
                                    @else
                                        <a href="{{ route('login') }}" class="flex-1 flex items-center justify-center px-8 py-4 bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-white rounded-xl font-bold text-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition-all duration-300 shadow-lg">
                                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                                            </svg>
                                            Login to Purchase
                                        </a>
                                    @endauth
                                </div>
                            </form>
                        @else
                            <div class="p-6 bg-red-50 dark:bg-red-900/20 border-2 border-red-200 dark:border-red-800 rounded-xl text-center">
                                <svg class="w-16 h-16 mx-auto mb-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <p class="text-xl font-bold text-red-600 dark:text-red-400">Out of Stock</p>
                                <p class="text-sm text-red-500 dark:text-red-300 mt-2">This product is currently unavailable</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function increaseQuantity(max) {
            const input = document.getElementById('quantity');
            if (parseInt(input.value) < max) {
                input.value = parseInt(input.value) + 1;
            }
        }

        function decreaseQuantity() {
            const input = document.getElementById('quantity');
            if (parseInt(input.value) > 1) {
                input.value = parseInt(input.value) - 1;
            }
        }
    </script>
</x-app-layout>
