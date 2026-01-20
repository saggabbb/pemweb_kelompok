<x-app-layout>
    <div class="py-12 bg-[#0d1117] min-h-screen text-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="mb-8 p-8 bg-[#161b22] rounded-2xl border border-gray-800 shadow-2xl">
                <h1 class="text-4xl font-extrabold text-white tracking-tight">Shopping Cart</h1>
                <p class="mt-2 text-gray-400">Manaage your items and proceed to checkout.</p>
            </div>

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
                <div class="bg-[#1c2128] border border-gray-700/50 rounded-2xl shadow-2xl p-16 text-center">
                    <div class="mb-6 inline-flex p-5 rounded-full bg-indigo-500/10 text-indigo-400">
                        <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                    </div>
                    <p class="text-2xl font-bold text-white mb-3">Your cart is empty.</p>
                    <p class="text-gray-400 mb-10 max-w-md mx-auto">Looks like you haven't added anything to your cart yet. Explore our products to find something you love!</p>
                    <a href="{{ route('explore') }}" class="inline-flex items-center justify-center px-10 py-4 border border-transparent text-lg font-bold rounded-xl text-white bg-indigo-600 hover:bg-indigo-500 shadow-lg shadow-indigo-600/30 transition-all duration-300 transform hover:-translate-y-1">
                        Start Shopping
                    </a>
                </div>
            @else
                <form action="{{ route('buyer.cart.checkout') }}" method="POST">
                    @csrf
                    
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        <div class="lg:col-span-2 space-y-6">
                            @foreach($groupedItems as $sellerId => $items)
                                <div class="bg-[#161b22] rounded-xl overflow-hidden border border-gray-800 shadow-lg">
                                    <div class="px-6 py-4 border-b border-gray-800 bg-[#1c2128]">
                                        <h3 class="font-bold text-indigo-400 flex items-center">
                                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                            {{ $items->first()->product->seller->name ?? 'Unknown Seller' }}
                                        </h3>
                                    </div>
                                    <div class="divide-y divide-gray-800">
                                        @foreach($items as $item)
                                            <div class="p-6 flex items-center hover:bg-white/[0.02] transition-colors">
                                                <div class="h-24 w-24 flex-shrink-0 overflow-hidden rounded-xl border border-gray-800 shadow-inner">
                                                    @if($item->product->image)
                                                        <img src="{{ Storage::url($item->product->image) }}" class="h-full w-full object-cover">
                                                    @else
                                                        <div class="h-full w-full bg-gray-800 flex items-center justify-center text-gray-600">
                                                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="ml-6 flex-1 flex flex-col">
                                                    <div class="flex justify-between text-lg font-bold text-white">
                                                        <h3>{{ $item->product->product_name }}</h3>
                                                        <p class="ml-4 text-indigo-400">Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}</p>
                                                    </div>
                                                    <div class="mt-2 flex-1 flex items-end justify-between">
                                                        <p class="text-gray-400 font-medium">Quantity: <span class="text-gray-200">{{ $item->quantity }}</span></p>
                                                        <button type="button" onclick="document.getElementById('delete-form-{{ $item->id }}').submit();" class="text-red-400 hover:text-red-300 font-bold text-sm uppercase tracking-wider transition-colors">
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
                            <div class="bg-[#161b22] rounded-2xl shadow-2xl p-8 border border-gray-800 sticky top-24">
                                <h2 class="text-xl font-bold text-white mb-6 flex items-center">
                                    <svg class="w-5 h-5 mr-3 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                                    Order Summary
                                </h2>
                                
                                <div class="flow-root">
                                    <dl class="-my-4 divide-y divide-gray-800">
                                        <div class="py-4 flex justify-between">
                                            <dt class="text-gray-400 font-medium">Total Items</dt>
                                            <dd class="font-bold text-white">{{ $cartItems->sum('quantity') }}</dd>
                                        </div>
                                        
                                        <div class="py-6">
                                            <label class="block text-sm font-bold text-gray-400 uppercase tracking-widest mb-4">Payment Method</label>
                                            <div class="space-y-3">
                                                <label class="flex items-center space-x-4 p-4 border border-gray-800 rounded-xl cursor-pointer hover:bg-gray-800/50 transition-all group">
                                                    <input type="radio" name="payment_method" value="transfer" checked class="h-5 w-5 text-indigo-600 bg-gray-900 border-gray-700 focus:ring-offset-gray-900">
                                                    <span class="text-sm font-bold text-gray-200 group-hover:text-white">Bank Transfer (QRIS)</span>
                                                </label>
                                                <label class="flex items-center space-x-4 p-4 border border-gray-800 rounded-xl cursor-pointer hover:bg-gray-800/50 transition-all group">
                                                    <input type="radio" name="payment_method" value="cod" class="h-5 w-5 text-indigo-600 bg-gray-900 border-gray-700 focus:ring-offset-gray-900">
                                                    <span class="text-sm font-bold text-gray-200 group-hover:text-white">Cash on Delivery (COD)</span>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="py-6 flex justify-between items-center border-t border-gray-800">
                                            <dt class="text-lg font-bold text-white">Order Total</dt>
                                            <dd class="text-2xl font-black text-indigo-400">
                                                Rp {{ number_format($cartItems->sum(fn($item) => $item->product->price * $item->quantity), 0, ',', '.') }}
                                            </dd>
                                        </div>
                                    </dl>
                                </div>
                                
                                <button type="submit" class="mt-8 w-full bg-indigo-600 text-white py-4 px-6 rounded-xl font-black uppercase tracking-widest hover:bg-indigo-500 shadow-lg shadow-indigo-600/30 transition-all duration-300 transform hover:-translate-y-1">
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