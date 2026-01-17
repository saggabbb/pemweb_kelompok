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

                        <!-- 1. Assign Courier -->
                        <div class="mb-6 border-b border-gray-200 dark:border-gray-700 pb-6">
                            <h4 class="font-semibold mb-2">Assign Courier</h4>
                            @if($order->courier)
                                <p class="text-sm text-green-600 mb-2">Currently assigned to: <strong>{{ $order->courier->name }}</strong></p>
                            @else
                                <p class="text-sm text-yellow-600 mb-2">Not assigned yet.</p>
                            @endif

                            <form action="{{ route('admin.orders.assign-courier', $order) }}" method="POST">
                                @csrf
                                <div class="flex gap-2">
                                    <select name="courier_id" class="rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 text-sm w-full">
                                        <option value="">Select Courier...</option>
                                        @foreach($couriers as $courier)
                                            <option value="{{ $courier->id }}" {{ ($order->courier_id == $courier->id) ? 'selected' : '' }}>
                                                {{ $courier->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="bg-blue-600 text-white px-3 py-2 rounded-md hover:bg-blue-700 text-sm">
                                        Assign
                                    </button>
                                </div>
                            </form>
                        </div>

                         <!-- 2. Confirm Payment -->
                         @if($order->payment && $order->payment->status === 'pending')
                            <div class="mb-6 border-b border-gray-200 dark:border-gray-700 pb-6">
                                <h4 class="font-semibold mb-2">Payment Verification</h4>
                                <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded mb-2">
                                    <p class="text-sm">Method: {{ $order->payment->payment_method }}</p>
                                    @if($order->payment->payment_proof)
                                        <a href="{{ Storage::url($order->payment->payment_proof) }}" target="_blank" class="text-indigo-600 text-sm underline">View Proof</a>
                                    @else
                                        <p class="text-sm text-red-500">No proof uploaded.</p>
                                    @endif
                                </div>
                                <form action="{{ route('admin.orders.confirm-payment', $order) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full bg-green-600 text-white px-3 py-2 rounded-md hover:bg-green-700 text-sm">
                                        Confirm Payment
                                    </button>
                                </form>
                            </div>
                        @elseif($order->payment && $order->payment->status === 'paid')
                             <div class="mb-6 border-b border-gray-200 dark:border-gray-700 pb-6">
                                <p class="text-green-600 font-bold">Payment Verified</p>
                             </div>
                        @else
                             <div class="mb-6 border-b border-gray-200 dark:border-gray-700 pb-6">
                                <p class="text-gray-500">No Payment record found or unknown status.</p>
                             </div>
                        @endif
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
                            <p><span class="font-semibold">Status:</span> {{ ucfirst($order->status) }}</p>
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
