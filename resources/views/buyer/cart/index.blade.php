<x-app-layout>
    <div class="py-12 bg-blue-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">Shopping Cart</h1>

            @if(session('error'))
                <div class="mb-4 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 shadow-sm">
                    {{ session('error') }}
                </div>
            @endif

            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            @if($cartItems->isEmpty())
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-8 text-center">
                    <p class="text-gray-500 dark:text-gray-400 mb-4">Your cart is empty.</p>
                    <a href="{{ route('explore') }}" class="text-indigo-600 hover:text-indigo-500 font-medium">Start Shopping</a>
                </div>
            @else
                <form action="{{ route('buyer.cart.checkout') }}" method="POST">
                    @csrf
                    
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        <div class="lg:col-span-2 space-y-6">
                            @foreach($groupedItems as $sellerId => $items)
                                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm overflow-hidden border border-gray-200 dark:border-gray-700">
                                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50">
                                        <h3 class="font-semibold text-gray-900 dark:text-white flex items-center">
                                            <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                            {{ $items->first()->product->seller->name ?? 'Unknown Seller' }}
                                        </h3>
                                    </div>
                                    <div class="divide-y divide-gray-200 dark:divide-gray-700">
                                        @foreach($items as $item)
                                            <div class="p-6 flex items-center">
                                                <div class="h-20 w-20 flex-shrink-0 overflow-hidden rounded-md border border-gray-200 dark:border-gray-700">
                                                    @if($item->product->image)
                                                        <img src="{{ Storage::url($item->product->image) }}" class="h-full w-full object-cover">
                                                    @else
                                                        <div class="h-full w-full bg-gray-100 flex items-center justify-center text-gray-400">
                                                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="ml-4 flex-1 flex flex-col">
                                                    <div class="flex justify-between text-base font-medium text-gray-900">
                                                        <h3>{{ $item->product->product_name }}</h3>
                                                        <p class="ml-4">Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}</p>
                                                    </div>
                                                    <div class="flex-1 flex items-end justify-between text-sm">
                                                        <p class="text-gray-500">Qty: {{ $item->quantity }}</p>
                                                        <button type="button" onclick="document.getElementById('delete-form-{{ $item->id }}').submit();" class="text-red-600 hover:text-red-500">
                                                            Remove
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="lg:col-span-1">
                            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 border border-gray-200 sticky top-24">
                                <h2 class="text-lg font-medium text-gray-900 mb-4">Order Summary</h2>
                                
                                <div class="flow-root">
                                    <dl class="-my-4 text-sm divide-y divide-gray-200">
                                        <div class="py-4 flex justify-between">
                                            <dt class="text-gray-600">Total Items</dt>
                                            <dd class="font-medium text-gray-900">{{ $cartItems->sum('quantity') }}</dd>
                                        </div>
                                        
                                        <div class="py-4">
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Payment Method</label>
                                            <div class="space-y-2">
                                                <label class="flex items-center space-x-3 p-3 border rounded-md cursor-pointer hover:bg-gray-50">
                                                    <input type="radio" name="payment_method" value="transfer" checked class="h-4 w-4 text-indigo-600">
                                                    <span class="text-sm font-medium">Bank Transfer (QRIS)</span>
                                                </label>
                                                <label class="flex items-center space-x-3 p-3 border rounded-md cursor-pointer hover:bg-gray-50">
                                                    <input type="radio" name="payment_method" value="cod" class="h-4 w-4 text-indigo-600">
                                                    <span class="text-sm font-medium">Cash on Delivery (COD)</span>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="py-4 flex justify-between">
                                            <dt class="text-base font-bold">Order Total</dt>
                                            <dd class="text-base font-bold text-indigo-600">
                                                Rp {{ number_format($cartItems->sum(fn($item) => $item->product->price * $item->quantity), 0, ',', '.') }}
                                            </dd>
                                        </div>
                                    </dl>
                                </div>
                                
                                <button type="submit" class="mt-6 w-full bg-indigo-600 text-white py-3 px-4 rounded-md font-medium hover:bg-indigo-700 transition-colors">
                                    Checkout Now
                                </button>
                            </div>
                        </div>
                    </div>
                </form>

                {{-- Hidden Delete Forms --}}
                @foreach($cartItems as $item)
                    <form id="delete-form-{{ $item->id }}" action="{{ route('buyer.cart.destroy', $item->id) }}" method="POST" style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>
                @endforeach
            @endif
        </div>
    </div>
</x-app-layout>