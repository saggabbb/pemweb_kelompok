<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Courier Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-bold mb-4">Assigned Deliveries</h3>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                        <div class="bg-blue-100 dark:bg-blue-900 p-4 rounded-lg">
                            <div class="font-bold text-xl">{{ $pendingDeliveries }}</div>
                            <div class="text-sm">Pending Delivery</div>
                        </div>
                         <div class="bg-purple-100 dark:bg-purple-900 p-4 rounded-lg">
                            <div class="font-bold text-xl">{{ $completedDeliveries }}</div>
                            <div class="text-sm">Delivered</div>
                        </div>
                        <div class="bg-yellow-100 dark:bg-yellow-900 p-4 rounded-lg">
                            <div class="font-bold text-xl">Rp {{ number_format(Auth::user()->balance, 0, ',', '.') }}</div>
                            <div class="text-sm">Current Balance</div>
                        </div>
                    </div>

                    <a href="{{ url('courier/orders') }}" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                        Manage Deliveries
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
