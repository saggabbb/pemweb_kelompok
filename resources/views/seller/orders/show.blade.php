<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Manage Order #' . $order->id) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                 <!-- Order Info -->
                 <div class="md:col-span-2 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <div class="flex justify-between border-b pb-4 mb-4 border-gray-200 dark:border-gray-700">
                            <div>
                                <h3 class="text-lg font-bold">Buyer Information</h3>
                                <p class="text-sm font-semibold">{{ $order->buyer->name }}</p>
                                <p class="text-sm text-gray-500">{{ $order->buyer->email }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm text-gray-500">Order Date</p>
                                <p class="font-semibold">{{ $order->created_at->format('d M Y H:i') }}</p>
                            </div>
                        </div>

                         <div class="mb-4">
                            <h4 class="font-semibold text-sm text-gray-500 uppercase mb-2">Delivery Address</h4>
                            <p class="text-sm">
                                {{-- Assuming address is stored somewhere, otherwise just mock or use user address --}}
                                {{ $order->buyer->address ?? 'No address provided (Mock)' }}
                            </p>
                        </div>

                         <div>
                            <h4 class="font-semibold text-sm text-gray-500 uppercase mb-2">Courier Status</h4>
                             <p class="text-sm">
                                @if($order->courier)
                                    Assigned to: <span class="font-semibold">{{ $order->courier->name }}</span>
                                @else
                                    <span class="text-yellow-600">Waiting for Courier Assignment (Admin)</span>
                                @endif
                            </p>
                        </div>
                    </div>
                 </div>

                 <!-- Status Update Action -->
                 <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="text-lg font-bold mb-4">Update Status</h3>
                        <form action="{{ route('seller.orders.update', $order) }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <div class="mb-4">
                                <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Order Status</label>
                                <select id="status" name="status" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                    {{-- Options based on logical flow --}}
                                    <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                                    <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped (Ready to Pickup)</option>
                                    <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                            </div>

                            <button type="submit" class="w-full bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">
                                Update Status
                            </button>
                        </form>
                    </div>
                 </div>
            </div>

            <!-- Products -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-bold mb-4">Ordered Items</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Product</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Price</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Qty</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($order->details as $detail)
                                    <tr>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center">
                                                @if($detail->product->image)
                                                    <img class="h-10 w-10 rounded-full object-cover mr-3" src="{{ Storage::url($detail->product->image) }}" alt="">
                                                @endif
                                                <div>
                                                    <div class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $detail->product->product_name ?? 'Deleted' }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-right text-sm text-gray-500 dark:text-gray-400">
                                            Rp {{ number_format($detail->price, 0, ',', '.') }}
                                        </td>
                                        <td class="px-6 py-4 text-right text-sm text-gray-500 dark:text-gray-400">
                                            {{ $detail->quantity }}
                                        </td>
                                        <td class="px-6 py-4 text-right text-sm text-gray-900 dark:text-gray-100 font-semibold">
                                            Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="px-6 py-4 text-right font-bold text-gray-900 dark:text-gray-100 uppercase">Total</td>
                                    <td class="px-6 py-4 text-right font-bold text-gray-900 dark:text-gray-100 text-lg">
                                        Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
