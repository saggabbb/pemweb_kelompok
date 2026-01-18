<x-app-layout>
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            @if($mode === 'search')
                {{-- Search Results --}}
                <div class="mb-12">
                    <div class="flex items-center mb-8">
                        <div class="flex-shrink-0 mr-4">
                            <svg class="w-12 h-12 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
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
                        <a href="{{ route('explore') }}" class="inline-flex items-center px-6 py-3 bg-indigo-600 text-white rounded-xl hover:bg-indigo-700 transition">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                            Browse All Categories
                        </a>
                    </div>
                @else
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
                                        
                                        <div class="flex items-center justify-between mb-3">
                                            <div class="text-2xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 to-purple-600 dark:from-indigo-400 dark:to-purple-400">
                                                Rp {{ number_format($product->price, 0, ',', '.') }}
                                            </div>
                                        </div>

                                        <div class="flex items-center justify-between text-sm">
                                            <div class="flex items-center text-gray-600 dark:text-gray-400">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                                </svg>
                                                <span class="font-medium">{{ $product->seller->name }}</span>
                                            </div>
                                            <div class="text-gray-500 dark:text-gray-500">
                                                Stock: {{ $product->stock }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>

                    {{-- Pagination --}}
                    <div class="mt-8">
                        {{ $products->links() }}
                    </div>
                @endif

            @else
                {{-- Browse by Category --}}
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
                            // Category-specific gradients and colors
                            $categoryStyles = [
                                'Elektronik' => ['gradient' => 'from-blue-500 to-cyan-600', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>', 'glow' => 'group-hover:shadow-blue-500/50'],
                                'Fashion' => ['gradient' => 'from-pink-500 to-rose-600', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>', 'glow' => 'group-hover:shadow-pink-500/50'],
                                'Ibu & Bayi' => ['gradient' => 'from-red-400 to-pink-500', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>', 'glow' => 'group-hover:shadow-red-500/50'],
                                'Rumah Tangga' => ['gradient' => 'from-green-500 to-emerald-600', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>', 'glow' => 'group-hover:shadow-green-500/50'],
                                'Olahraga' => ['gradient' => 'from-orange-500 to-red-600', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>', 'glow' => 'group-hover:shadow-orange-500/50'],
                                'Kesehatan & Kecantikan' => ['gradient' => 'from-purple-500 to-pink-600', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>', 'glow' => 'group-hover:shadow-purple-500/50'],
                                'Makanan & Minuman' => ['gradient' => 'from-yellow-500 to-orange-600', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>', 'glow' => 'group-hover:shadow-yellow-500/50'],
                                'Buku' => ['gradient' => 'from-indigo-500 to-blue-600', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>', 'glow' => 'group-hover:shadow-indigo-500/50'],
                                'Hobi & Koleksi' => ['gradient' => 'from-amber-500 to-yellow-600', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>', 'glow' => 'group-hover:shadow-amber-500/50'],
                                'Otomotif' => ['gradient' => 'from-gray-600 to-slate-700', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>', 'glow' => 'group-hover:shadow-gray-500/50'],
                            ];
                            
                            $style = $categoryStyles[$category->category_name] ?? ['gradient' => 'from-indigo-500 to-purple-600', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>', 'glow' => 'group-hover:shadow-indigo-500/50'];
                        @endphp
                        
                        <a href="{{ route('explore', ['category' => $category->id]) }}" class="group">
                            <div class="relative bg-gradient-to-br {{ $style['gradient'] }} rounded-2xl overflow-hidden shadow-xl hover:shadow-2xl {{ $style['glow'] }} transition-all duration-500 transform hover:-translate-y-3 hover:scale-105">
                                {{-- Decorative elements --}}
                                <div class="absolute inset-0 bg-white/5 backdrop-blur-sm"></div>
                                <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -mr-16 -mt-16 group-hover:scale-150 transition-transform duration-700"></div>
                                <div class="absolute bottom-0 left-0 w-24 h-24 bg-white/10 rounded-full -ml-12 -mb-12 group-hover:scale-150 transition-transform duration-700"></div>
                                
                                {{-- Content --}}
                                <div class="relative h-64 flex flex-col items-center justify-center p-6 text-white">
                                    {{-- Icon with glow --}}
                                    <div class="mb-6 transform group-hover:scale-110 group-hover:rotate-6 transition-all duration-500">
                                        <div class="relative">
                                            <div class="absolute inset-0 bg-white/20 rounded-full blur-2xl group-hover:bg-white/40 transition-all duration-500"></div>
                                            <svg class="relative w-24 h-24 drop-shadow-2xl" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                {!! $style['icon'] !!}
                                            </svg>
                                        </div>
                                    </div>
                                    
                                    {{-- Category info --}}
                                    <div class="text-center">
                                        <h3 class="font-bold text-2xl mb-2 drop-shadow-lg group-hover:scale-105 transition-transform">
                                            {{ $category->category_name }}
                                        </h3>
                                        <div class="inline-flex items-center px-4 py-1.5 bg-white/20 backdrop-blur-md rounded-full">
                                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                            </svg>
                                            <span class="text-sm font-semibold">{{ $category->products_count ?? 0 }} Products</span>
                                        </div>
                                    </div>
                                    
                                    {{-- Arrow indicator --}}
                                    <div class="absolute bottom-4 right-4 transform translate-x-2 opacity-0 group-hover:translate-x-0 group-hover:opacity-100 transition-all duration-500">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                        </svg>
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
