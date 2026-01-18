<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('My Deliveries') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if($orders->count() > 0)
                        <div class="grid gap-6">
                            @foreach($orders as $order)
                                <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 flex flex-col md:flex-row justify-between items-start md:items-center">
                                    <div class="mb-4 md:mb-0">
                                        <h3 class="font-bold text-lg">Order #{{ $order->id }}</h3>
                                        <p class="text-sm text-gray-500">Buyer: {{ $order->buyer->name }}</p>
                                        <p class="text-sm text-gray-500">Address: {{ $order->buyer->address ?? 'N/A' }}</p>
                                        <div class="mt-2">
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                                {{ match($order->status) {
                                                    'delivered', 'completed' => 'bg-green-100 text-green-800',
                                                    'shipped' => 'bg-blue-100 text-blue-800',
                                                    default => 'bg-gray-100 text-gray-800'
                                                } }}">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </div>
                                    </div>
                                    
                                    <div>
                                        @if($order->status === 'shipped')
                                            <form action="{{ url('courier/orders/'.$order->id.'/complete') }}" method="POST" enctype="multipart/form-data" class="flex flex-col gap-2">
                                                @csrf
                                                <input type="file" name="delivery_proof" required class="text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                                                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 text-sm">
                                                    Mark Delivered
                                                </button>
                                            </form>
                                        @elseif($order->status === 'delivered' || $order->status === 'completed')
                                             <button disabled class="bg-gray-300 text-gray-500 px-4 py-2 rounded cursor-not-allowed text-sm">
                                                Delivered
                                            </button>
                                        @else
                                            <span class="text-sm text-yellow-600">Waiting for Seller to Ship</span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-center py-4 text-gray-500">No deliveries assigned.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
