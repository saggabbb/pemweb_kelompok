<x-app-layout>
    <style>
        body {
        background-color: #f0f9ff !important; /* Warna blue-50 */
    }
    .min-h-screen {
        background-color: #f0f9ff !important;
    }

    </style>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Buyer Dashboard') }}
        </h2>
    </x-slot>

    <div class="pt-6 pb-12">
        <div class="py-12 bg-blue-50"> <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Welcome Section -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-bold mb-2">Welcome Back, {{ Auth::user()->name }}!</h3>
                    <p class="mb-4">Ready to find something new today?</p>
                    <div class="flex gap-4">
                        <a href="{{ url('/') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">
                            Browse Products
                        </a>
                        <a href="{{ route('buyer.orders.index') }}" class="bg-gray-200 text-gray-800 px-4 py-2 rounded-md hover:bg-gray-300 dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600">
                            View My Orders
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Stats -->
           <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="group bg-white dark:bg-gray-800 p-1 rounded-2xl shadow-sm hover:shadow-md transition-all duration-300 bg-gradient-to-br from-blue-500/10 to-transparent">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl flex items-center">
            <div class="p-4 bg-blue-500 text-white rounded-xl shadow-lg shadow-blue-200 dark:shadow-none mr-4 group-hover:scale-110 transition-transform">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
            </div>
            <div>
                <p class="text-xs font-bold text-blue-500 uppercase tracking-widest">Total Pesanan</p>
                <p class="text-3xl font-black text-gray-800 dark:text-white">{{ $orders->count() }}</p>
            </div>
        </div>
    </div>

    <div class="group bg-white dark:bg-gray-800 p-1 rounded-2xl shadow-sm hover:shadow-md transition-all duration-300 bg-gradient-to-br from-emerald-500/10 to-transparent">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl flex items-center">
            <div class="p-4 bg-emerald-500 text-white rounded-xl shadow-lg shadow-emerald-200 dark:shadow-none mr-4 group-hover:scale-110 transition-transform">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <p class="text-xs font-bold text-emerald-500 uppercase tracking-widest">Total Belanja</p>
                <p class="text-3xl font-black text-gray-800 dark:text-white">Rp {{ number_format($orders->sum('total_price'), 0, ',', '.') }}</p>
            </div>
        </div>
    </div>

    <div class="group bg-white dark:bg-gray-800 p-1 rounded-2xl shadow-sm hover:shadow-md transition-all duration-300 bg-gradient-to-br from-orange-500/10 to-transparent border border-orange-100 dark:border-orange-900/30">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl flex items-center">
            <div class="p-4 bg-orange-500 text-white rounded-xl shadow-lg shadow-orange-200 dark:shadow-none mr-4 group-hover:scale-110 transition-transform">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
            </div>
            <div>
                <p class="text-xs font-bold text-orange-600 uppercase tracking-widest">Saldo Aktif</p>
                <p class="text-3xl font-black text-gray-800 dark:text-white">Rp {{ number_format(Auth::user()->balance, 0, ',', '.') }}</p>
            </div>
        </div>
    </div>
</div>

            <!-- Recent Orders Snippet (Optional) -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-bold mb-4">Recent Orders</h3>
                    @if(isset($orders) && $orders->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead>
                                    <tr>
                                        <th class="px-6 py-3 bg-gray-50 dark:bg-gray-700 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Order ID</th>
                                        <th class="px-6 py-3 bg-gray-50 dark:bg-gray-700 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Date</th>
                                        <th class="px-6 py-3 bg-gray-50 dark:bg-gray-700 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Total</th>
                                        <th class="px-6 py-3 bg-gray-50 dark:bg-gray-700 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 bg-gray-50 dark:bg-gray-700 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach($orders->take(5) as $order)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">#{{ $order->id }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $order->created_at->format('d M Y') }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                    {{ $order->status === 'completed' ? 'bg-green-100 text-green-800' : 
                                                       ($order->status === 'cancelled' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                                    {{ ucfirst($order->status) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <a href="{{ route('buyer.orders.show', $order) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-600">Details</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-4">You haven't placed any orders yet.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
