<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $product->product_name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Success Message -->
            @if(session('success'))
                <div class="mb-6 bg-green-100 dark:bg-green-900 border border-green-400 dark:border-green-700 text-green-800 dark:text-green-200 px-4 py-3 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Product Detail -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        
                        <!-- Product Image -->
                        <div>
                            <div class="aspect-square bg-gray-100 dark:bg-gray-700 rounded-lg overflow-hidden flex items-center justify-center">
                                @if($product->image)
                                    <img src="{{ Storage::url($product->image) }}" 
                                         alt="{{ $product->product_name }}" 
                                         class="w-full h-full object-cover">
                                @else
                                    <div class="text-center">
                                        <svg class="mx-auto h-24 w-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <p class="mt-2 text-gray-500 dark:text-gray-400">No Image</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Product Info -->
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
                                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            <button type="submit" 
                                                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 px-6 rounded-lg transition flex items-center justify-center gap-2">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                                </svg>
                                                Add to Cart
                                            </button>
                                        </form>
                                    @else
                                        <div class="bg-red-100 dark:bg-red-900 border border-red-400 dark:border-red-700 text-red-800 dark:text-red-200 px-4 py-3 rounded-lg">
                                            Out of Stock
                                        </div>
                                    @endif
                                @else
                                    <div class="bg-yellow-100 dark:bg-yellow-900 border border-yellow-400 dark:border-yellow-700 text-yellow-800 dark:text-yellow-200 px-4 py-3 rounded-lg">
                                        Only buyers can add products to cart
                                    </div>
                                @endif
                            @else
                                <div class="bg-blue-100 dark:bg-blue-900 border border-blue-400 dark:border-blue-700 text-blue-800 dark:text-blue-200 px-4 py-3 rounded-lg">
                                    <a href="{{ route('login') }}" class="font-semibold underline">Login</a> to add this product to your cart
                                </div>
                            @endauth
                        </div>
                    </div>

                    <!-- Product Description -->
                    <div class="mt-8 pt-8 border-t border-gray-200 dark:border-gray-700">
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-4">Product Description</h2>
                        <p class="text-gray-700 dark:text-gray-300 whitespace-pre-line">{{ $product->description }}</p>
                    </div>
                </div>
            </div>

            <!-- Related Products -->
            @if($relatedProducts->count() > 0)
                <div class="mt-8">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-6">More from this Seller</h2>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                        @foreach($relatedProducts as $related)
                            <a href="{{ route('products.show', $related) }}" class="bg-white dark:bg-gray-800 rounded-lg shadow hover:shadow-lg transition">
                                <div class="h-48 bg-gray-100 dark:bg-gray-700 rounded-t-lg overflow-hidden">
                                    @if($related->image)
                                        <img src="{{ Storage::url($related->image) }}" alt="{{ $related->product_name }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="flex items-center justify-center h-full text-gray-400">No Image</div>
                                    @endif
                                </div>
                                <div class="p-4">
                                    <h3 class="font-semibold text-gray-900 dark:text-gray-100 mb-2">{{ $related->product_name }}</h3>
                                    <p class="text-indigo-600 dark:text-indigo-400 font-bold">Rp {{ number_format($related->price, 0, ',', '.') }}</p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
