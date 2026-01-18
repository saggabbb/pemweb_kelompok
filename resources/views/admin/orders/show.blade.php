<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Admin: Manage Order #' . $order->id) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Order Logic & Actions -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="text-lg font-bold mb-4">Actions</h3>

                        <!-- 1. Confirm Order (Auto-assigns courier) -->
                        <div class="mb-6 border-b border-gray-200 dark:border-gray-700 pb-6">
                            <h4 class="font-semibold mb-2">Confirm Order</h4>
                            @if($order->status === 'pending')
                                <p class="text-sm text-yellow-600 mb-3">Order pending confirmation. Click below to confirm and auto-assign courier.</p>
                                <form action="{{ route('admin.orders.update-status', $order) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="confirmed">
                                    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 text-sm w-full">
                                        ✓ Confirm Order & Assign Courier
                                    </button>
                                </form>
                            @elseif($order->courier_id)
                                <!-- Courier Assigned -->
                                <div class="bg-green-900 bg-opacity-30 border border-green-600 rounded p-4">
                                    <div class="flex items-center mb-2">
                                        <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span class="text-green-400 font-semibold">Order Confirmed & Courier Assigned!</span>
                                    </div>
                                    <div class="text-white">
                                        <p class="text-sm text-gray-400 mb-1">Courier:</p>
                                        <p class="font-bold">{{ $order->courier->name }}</p>
                                        @if($order->courier->address)
                                            <p class="text-sm text-gray-400 mt-2">{{ $order->courier->address }}</p>
                                        @endif
                                        <p class="text-sm text-gray-400 mt-2">Status: <span class="text-white font-semibold">{{ ucfirst($order->status) }}</span></p>
                                    </div>
                                </div>
                            @else
                                <p class="text-sm text-gray-500">Order confirmed but no courier available.</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Basic Info -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                         <h3 class="text-lg font-bold mb-4">Order Summary</h3>
                         <div class="space-y-2 text-sm">
                            <p><span class="font-semibold">ID:</span> #{{ $order->id }}</p>
                            <p><span class="font-semibold">Buyer:</span> {{ $order->buyer->name }}</p>
                            <p><span class="font-semibold">Seller:</span> {{ $order->seller->name ?? 'Unknown' }}</p>
                            <p><span class="font-semibold">Payment:</span> 
                                <span class="{{  $order->payment_method === 'transfer' ? 'text-blue-500' : 'text-orange-500' }} font-semibold">
                                    {{ strtoupper($order->payment_method) }}
                                </span>
                            </p>
                            <p><span class="font-semibold">Status:</span> 
                                <span class="text-yellow-500 font-semibold">{{ ucfirst($order->status) }}</span>
                            </p>
                            <p><span class="font-semibold">Total:</span> Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                         </div>

                         <h4 class="font-bold mt-4 mb-2">Items</h4>
                         <ul class="list-disc list-inside text-sm">
                            @foreach($order->details as $detail)
                                <li>
                                    {{ $detail->product->product_name ?? 'Item' }} x {{ $detail->quantity }} 
                                    (Rp {{ number_format($detail->subtotal, 0, ',', '.') }})
                                </li>
                            @endforeach
                         </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
