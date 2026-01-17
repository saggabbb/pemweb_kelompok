<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $seller->name }}'s Store
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <!-- Store Header -->
                <div class="mb-8 pb-6 border-b border-gray-200 dark:border-gray-700">
                    <h1 class="text-3xl font-bold mb-3 text-gray-900 dark:text-gray-100">{{ $seller->name }}</h1>
                    <p class="text-gray-600 dark:text-gray-400">
                        <svg class="inline w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        {{ $seller->address }}
                    </p>
                    <div class="mt-4">
                        <span class="text-sm text-gray-500 dark:text-gray-400">Total Products: <strong>{{ $products->total() }}</strong></span>
                    </div>
                </div>

                <!-- Product Catalog -->
                @if($products->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                        @foreach($products as $product)
                            <div class="border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden hover:shadow-lg transition">
                                <a href="{{ route('products.show', $product) }}">
                                    <div class="h-48 bg-gray-100 dark:bg-gray-700 flex items-center justify-center">
                                        @if($product->image)
                                            <img src="{{ Storage::url($product->image) }}" alt="{{ $product->product_name }}" class="h-full object-contain">
                                        @else
                                            <span class="text-gray-500">No Image</span>
                                        @endif
                                    </div>
                                </a>
                                <div class="p-4">
                                    <a href="{{ route('products.show', $product) }}" class="hover:text-indigo-600">
                                        <h4 class="font-bold text-lg mb-1 text-gray-900 dark:text-gray-100">{{ $product->product_name }}</h4>
                                    </a>
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">{{ $product->category->category_name }}</p>
                                    <p class="font-bold text-indigo-600 mb-3">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                                    
                                    @auth
                                        @if(auth()->user()->role->role_name === 'buyer')
                                            <form action="{{ route('buyer.cart.store') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                <input type="hidden" name="quantity" value="1">
                                                <button type="submit" class="w-full bg-indigo-600 text-white py-2 rounded hover:bg-indigo-700 text-sm">
                                                    Add to Cart
                                                </button>
                                            </form>
                                        @endif
                                    @else
                                        <a href="{{ route('login') }}" class="block text-center w-full bg-gray-200 text-gray-800 py-2 rounded text-sm hover:bg-gray-300">
                                            Login to Buy
                                        </a>
                                    @endauth
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $products->links() }}
                    </div>
                @else
                    <div class="text-center py-10">
                        <p class="text-gray-500 dark:text-gray-400">This seller has no products yet.</p>
                    </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>
