<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Order Details #' . $order->id) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Order status & QR -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <!-- Info -->
                <div class="md:col-span-2 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <div class="flex justify-between border-b pb-4 mb-4 border-gray-200 dark:border-gray-700">
                            <div>
                                <h3 class="text-lg font-bold">Order Information</h3>
                                <p class="text-sm text-gray-500">Date: {{ $order->created_at->format('d M Y H:i') }}</p>
                            </div>
                            <div class="text-right">
                                <span class="px-3 py-1 text-sm font-semibold rounded-full 
                                    {{ match($order->status) {
                                        'completed', 'delivered' => 'bg-green-100 text-green-800',
                                        'processing', 'shipped' => 'bg-blue-100 text-blue-800',
                                        'cancelled' => 'bg-red-100 text-red-800',
                                        default => 'bg-yellow-100 text-yellow-800'
                                    } }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <h4 class="font-semibold text-sm text-gray-500 uppercase">Seller</h4>
                                <p>{{ $order->seller->name ?? 'Unknown' }}</p>
                                <p class="text-sm text-gray-500">{{ $order->seller->email ?? '' }}</p>
                            </div>
                            <div>
                                <h4 class="font-semibold text-sm text-gray-500 uppercase">Courier</h4>
                                <p>{{ $order->courier->name ?? 'Not assigned yet' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- QR Code -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg flex items-center justify-center p-6">
                    <div class="text-center">
                        <h3 class="text-lg font-bold mb-4 text-gray-900 dark:text-gray-100">Order QR Code</h3>
                        <div class="bg-white p-2 inline-block rounded-lg">
                            {!! $qrCode !!}
                        </div>
                        <p class="text-xs text-gray-500 mt-2">Show this to the courier</p>
                    </div>
                </div>
            </div>

            <!-- Products -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-bold mb-4">Items Ordered</h3>
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
                                                    <div class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $detail->product->product_name ?? 'Item Deleted' }}</div>
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
