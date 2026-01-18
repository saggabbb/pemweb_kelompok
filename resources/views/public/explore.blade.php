<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Explore Products') }}
        </h2>
    </x-slot>
    <div class="py-8 bg-gradient-to-b from-gray-50 to-white dark:from-gray-900 dark:to-gray-800 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            @if(isset($mode) && $mode === 'search')
                {{-- SEARCH MODE: Display Products --}}
                <div class="mb-8">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <div>
                            <h2 class="text-3xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 to-purple-600 dark:from-indigo-400 dark:to-purple-400">
                                Search Results
                            </h2>
                            <p class="text-gray-600 dark:text-gray-400 mt-1">
                                Found <span class="font-semibold text-indigo-600 dark:text-indigo-400">{{ $products->total() }}</span> products for "{{ $search }}"
                            </p>
                        </div>
                    </div>
                </div>

                @if($products->isEmpty())
                    <div class="text-center py-20">
                        <div class="inline-block p-6 bg-gray-100 dark:bg-gray-800 rounded-full mb-6">
                            <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">No products found</h3>
                        <p class="text-gray-600 dark:text-gray-400 mb-6">Try searching with different keywords</p>
                        <a href="{{ route('explore') }}" class="inline-flex items-center px-6 py-3 bg-indigo-600 text-white rounded-xl font-semibold hover:bg-indigo-700 transition">
                            Browse All Categories
                        </a>
                    </div>
                @else
                    {{-- Product Grid --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        @foreach($products as $product)
                            <a href="{{ route('products.show', $product) }}" class="group">
                                <div class="bg-white dark:bg-gray-800 rounded-2xl overflow-hidden shadow-md hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 border border-gray-100 dark:border-gray-700">
                                    {{-- Product Image --}}\r
                                    <div class=\"relative h-56 bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-800 overflow-hidden\">\r
                                        @if($product->image)\r
                                            @php\r
                                                // Check if it's a URL or storage path\r
                                                $productImageUrl = (strpos($product->image, 'http') === 0) \r
                                                    ? $product->image \r
                                                    : Storage::url($product->image);\r
                                            @endphp\r
                                            <img src=\"{{ $productImageUrl }}\" \r
                                                 alt=\"{{ $product->product_name }}\" \r
                                                 class=\"w-full h-full object-cover group-hover:scale-110 transition-transform duration-500\">\r
                                        @else\r
                                            <div class="w-full h-full flex items-center justify-center">
                                                <svg class="w-20 h-20 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                            </div>
                                        @endif
                                        {{-- Category Badge --}}
                                        <div class="absolute top-3 left-3">
                                            <span class="px-3 py-1 bg-white/90 dark:bg-gray-900/90 backdrop-blur-sm rounded-full text-xs font-semibold text-indigo-600 dark:text-indigo-400">
                                                {{ $product->category->category_name }}
                                            </span>
                                        </div>
                                        {{-- Stock Badge --}}
                                        @if($product->stock < 10)
                                            <div class="absolute top-3 right-3">
                                                <span class="px-3 py-1 bg-red-500/90 backdrop-blur-sm rounded-full text-xs font-semibold text-white">
                                                    Only {{ $product->stock }} left!
                                                </span>
                                            </div>
                                        @endif
                                    </div>

                                    {{-- Product Info --}}
                                    <div class="p-5">
                                        <h3 class="font-bold text-lg text-gray-900 dark:text-white mb-2 line-clamp-2 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">
                                            {{ $product->product_name }}
                                        </h3>
                                        
                                        {{-- Seller --}}
                                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-3 flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                            </svg>
                                            {{ $product->seller->name }}
                                        </p>

                                        {{-- Price and Stock --}}
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <p class="text-2xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 to-purple-600">
                                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                                </p>
                                            </div>
                                            <div class="text-right">
                                                <p class="text-xs text-gray-500 dark:text-gray-400">Stock</p>
                                                <p class="text-sm font-semibold text-gray-700 dark:text-gray-300">{{ $product->stock }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>

                    {{-- Pagination --}}
                    <div class="mt-12">
                        {{ $products->links() }}
                    </div>
                @endif

            @else
                {{-- BROWSE MODE: Display Categories --}}
                <div class="mb-12 text-center">
                    <h1 class="text-4xl md:text-5xl font-extrabold bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 to-purple-600 dark:from-indigo-400 dark:to-purple-400 mb-4">
                        Browse by Category
                    </h1>
                    <p class="text-xl text-gray-600 dark:text-gray-400">
                        Discover amazing products in your favorite categories
                    </p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($categories as $category)
                        @php
                            $coverProduct = $category->products->first();
                        @endphp
                        
                        <a href="{{ route('explore', ['category' => $category->id]) }}" class="group">
                            <div class="bg-white dark:bg-gray-800 rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 border border-gray-100 dark:border-gray-700">
                                {{-- Category Cover Image --}}
                                <div class="relative h-64 bg-gradient-to-br from-indigo-100 to-purple-100 dark:from-indigo-900/50 dark:to-purple-900/50 overflow-hidden">
                                    @if($coverProduct && $coverProduct->image)
                                        @php
                                            // Check if it's a URL or storage path
                                            $coverImageUrl = (strpos($coverProduct->image, 'http') === 0) 
                                                ? $coverProduct->image 
                                                : Storage::url($coverProduct->image);
                                        @endphp
                                        <img src="{{ $coverImageUrl }}" 
                                             alt="{{ $category->category_name }} cover" 
                                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center">
                                            <svg class="w-24 h-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                            </svg>
                                        </div>
                                    @endif
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                                    <div class="absolute bottom-0 left-0 right-0 p-6 text-white">
                                        <h3 class="font-bold text-2xl mb-1 group-hover:text-indigo-200 transition-colors">{{ $category->category_name }}</h3>
                                        <p class="text-sm text-gray-200">{{ $category->products_count ?? 0 }} Products</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
