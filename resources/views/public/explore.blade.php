<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Explore Products') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900 dark:text-gray-100">
                
                <!-- SEARCH BAR -->
                <div class="mb-8 border-b border-gray-200 dark:border-gray-700 pb-6">
                    <form action="{{ route('explore') }}" method="GET" class="flex gap-4">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search products..." class="flex-1 rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-md hover:bg-indigo-700">Search</button>
                    </form>
                </div>

                @if(request('search'))
                    <!-- SEARCH RESULTS -->
                    <h3 class="text-lg font-bold mb-4">Search Results for: "{{ request('search') }}"</h3>
                    @if($products->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                            @foreach($products as $product)
                                <div class="border border-gray-200 dark:border-gray-700 p-4 rounded-lg">
                                    <a href="{{ route('products.show', $product) }}">
                                        <div class="h-40 bg-gray-100 dark:bg-gray-700 mb-4 flex items-center justify-center rounded">
                                            @if($product->image)
                                                <img src="{{ Storage::url($product->image) }}" alt="{{ $product->product_name }}" class="h-full object-contain">
                                            @else
                                                <span class="text-gray-500">No Image</span>
                                            @endif
                                        </div>
                                        <h4 class="font-bold text-lg mb-1">{{ $product->product_name }}</h4>
                                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">{{ $product->category->category_name }}</p>
                                        <p class="font-bold text-indigo-600 mb-4">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                                    </a>
                                    
                                    @auth
                                        <form action="{{ route('buyer.cart.store') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                            <input type="hidden" name="quantity" value="1">
                                            <button type="submit" class="w-full bg-indigo-600 text-white py-2 rounded hover:bg-indigo-700 text-sm">Add to Cart</button>
                                        </form>
                                    @else
                                        <a href="{{ route('login') }}" class="block text-center w-full bg-gray-200 text-gray-800 py-2 rounded text-sm hover:bg-gray-300">Login to Buy</a>
                                    @endauth
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-6">
                            {{ $products->links() }}
                        </div>
                    @else
                        <p class="text-red-500">No products found.</p>
                    @endif
                @else
                    <!-- CATEGORIES LIST -->
                    <h3 class="text-lg font-bold mb-4">Categories</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        @foreach($categories as $category)
                            <div class="border border-gray-200 dark:border-gray-700 p-6 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700">
                                <h4 class="font-bold text-lg mb-2">{{ $category->name }}</h4>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">{{ $category->products_count ?? 0 }} Products</p>
                                <a href="{{ route('explore', ['search' => $category->name]) }}" class="text-indigo-600 hover:underline text-sm">Browse Category &rarr;</a>
                            </div>
                        @endforeach
                    </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>
