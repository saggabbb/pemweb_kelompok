<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $product->product_name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                    <!-- Product Image -->
                    <div>
                        <div class="bg-gray-100 dark:bg-gray-700 rounded-lg p-4 flex items-center justify-center" style="min-height: 400px;">
                            @if($product->image)
                                <img src="{{ Storage::url($product->image) }}" alt="{{ $product->product_name }}" class="max-h-96 object-contain">
                            @else
                                <span class="text-gray-500">No Image</span>
                            @endif
                        </div>
                    </div>

                    <!-- Product Info -->
                    <div class="text-gray-900 dark:text-gray-100">
                        <h1 class="text-3xl font-bold mb-4">{{ $product->product_name }}</h1>
                        
                        <div class="mb-4">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Category:</span>
                            <span class="bg-gray-200 dark:bg-gray-700 px-3 py-1 rounded text-sm ml-2">{{ $product->category->category_name }}</span>
                        </div>

                        <div class="text-3xl font-bold text-indigo-600 mb-4">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </div>

                        <div class="mb-4">
                            <span class="text-sm">Stock: <strong>{{ $product->stock }}</strong> available</span>
                        </div>

                        <div class="mb-6">
                            <h3 class="font-semibold mb-2">Description</h3>
                            <p class="text-gray-700 dark:text-gray-300">{{ $product->description }}</p>
                        </div>

                        <!-- Add to Cart Form -->
                        @auth
                            @if(auth()->user()->role->role_name === 'buyer')
                                <form action="{{ route('buyer.cart.store') }}" method="POST" class="mb-6">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    
                                    <div class="flex items-center gap-4 mb-4">
                                        <label for="quantity" class="font-semibold">Quantity:</label>
                                        <input type="number" id="quantity" name="quantity" value="1" min="1" max="{{ $product->stock }}" class="border rounded px-3 py-2 w-20 dark:bg-gray-900 dark:border-gray-700">
                                    </div>

                                    <button type="submit" class="bg-indigo-600 text-white px-8 py-3 rounded-lg hover:bg-indigo-700 font-semibold">
                                        Add to Cart
                                    </button>
                                </form>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="inline-block bg-gray-200 text-gray-800 px-8 py-3 rounded-lg hover:bg-gray-300">
                                Login to Buy
                            </a>
                        @endauth

                        <!-- Seller Info Card -->
                        <div class="border-t pt-6 mt-6">
                            <h3 class="font-semibold mb-3">Seller Information</h3>
                            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                <p class="font-bold text-lg mb-2">{{ $product->seller->name }}</p>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">{{ $product->seller->address }}</p>
                                <a href="{{ route('store.show', $product->seller) }}" class="text-indigo-600 hover:underline">
                                    Visit Store →
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Related Products -->
                @if($relatedProducts->count() > 0)
                    <div class="border-t pt-8">
                        <h2 class="text-2xl font-bold mb-6 text-gray-900 dark:text-gray-100">More from this seller</h2>
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                            @foreach($relatedProducts as $related)
                                <a href="{{ route('products.show', $related) }}" class="border border-gray-200 dark:border-gray-700 p-4 rounded-lg hover:shadow-lg transition">
                                    <div class="h-40 bg-gray-100 dark:bg-gray-700 mb-4 flex items-center justify-center rounded">
                                        @if($related->image)
                                            <img src="{{ Storage::url($related->image) }}" alt="{{ $related->product_name }}" class="h-full object-contain">
                                        @else
                                            <span class="text-gray-500">No Image</span>
                                        @endif
                                    </div>
                                    <h4 class="font-bold mb-1 text-gray-900 dark:text-gray-100">{{ $related->product_name }}</h4>
                                    <p class="text-indigo-600 font-semibold">Rp {{ number_format($related->price, 0, ',', '.') }}</p>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>
