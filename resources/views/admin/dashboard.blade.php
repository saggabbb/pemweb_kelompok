<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100 dark:bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Top Section: 2 Cards Split -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                
                <!-- Left: Welcome Card -->
                <div class="relative bg-gradient-to-br from-indigo-600 to-purple-700 rounded-xl shadow-lg p-8 flex flex-col justify-center overflow-hidden">
                    <!-- Decorative Circle -->
                    <div class="absolute top-0 right-0 -mr-8 -mt-8 w-32 h-32 rounded-full bg-white/10 blur-xl"></div>
                    <div class="absolute bottom-0 left-0 -ml-8 -mb-8 w-24 h-24 rounded-full bg-white/10 blur-xl"></div>
                    
                    <h3 class="relative text-2xl font-bold text-white mb-2">Welcome Back, Admin!</h3>
                    <p class="relative text-indigo-100 mb-6">Here's what's happening in your store today.</p>
                    
                    <div class="relative bg-white/10 backdrop-blur-sm rounded-lg p-4 border border-white/20 hover:bg-white/20 transition-colors">
                        <div class="flex justify-between items-center">
                            <div>
                                <h4 class="text-lg font-bold text-white">Manage Orders</h4>
                                <a href="{{ route('admin.orders.index') }}" class="text-indigo-200 hover:text-white font-medium text-sm mt-1 inline-block transition-colors">
                                    View All Orders &rarr;
                                </a>
                            </div>
                            <div class="p-3 bg-white/20 rounded-full text-white shadow-inner">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right: Manage Orders Stats -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-8">
                    <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100 mb-6">Manage Orders</h3>
                    
                    <div class="flex items-end justify-between mb-8">
                        <div>
                            <span class="text-5xl font-bold text-gray-900 dark:text-white">{{ $totalOrders }}</span>
                            <span class="text-gray-500 dark:text-gray-400 ml-2">(Total)</span>
                        </div>
                        <div class="text-right">
                             <div class="text-sm text-gray-500 dark:text-gray-400">Completed (Total)</div>
                        </div>
                    </div>

                    <div class="grid grid-cols-3 gap-4 border-t border-gray-100 dark:border-gray-700 pt-6">
                        <div class="text-center p-2 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                            <div class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-1 font-semibold">Orders</div>
                            <div class="text-xl font-bold text-indigo-600 dark:text-indigo-400">{{ $totalOrders }}</div>
                        </div>
                        <div class="text-center border-l border-gray-100 dark:border-gray-700 p-2 rounded-lg hover:bg-orange-50 dark:hover:bg-orange-900/10 transition-colors">
                            <div class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-1 font-semibold">Processing</div>
                            <div class="text-xl font-bold text-orange-600">{{ $processingOrders }}</div>
                        </div>
                        <div class="text-center border-l border-gray-100 dark:border-gray-700 p-2 rounded-lg hover:bg-green-50 dark:hover:bg-green-900/10 transition-colors">
                            <div class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-1 font-semibold">Completed</div>
                            <div class="text-xl font-bold text-green-600">{{ $completedOrders }}</div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Bottom Section: Recent Orders & Chart -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <!-- Recent Transactions -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
                    <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100 mb-6">Recent Transactions</h3>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="text-xs text-gray-500 dark:text-gray-400 border-b border-gray-100 dark:border-gray-700">
                                    <th class="pb-3 font-medium">Order ID</th>
                                    <th class="pb-3 font-medium">Customer</th>
                                    <th class="pb-3 font-medium text-right">Total</th>
                                </tr>
                            </thead>
                            <tbody class="text-sm">
                                @forelse($recentOrders as $order)
                                <tr class="border-b border-gray-50 dark:border-gray-700/50 last:border-0 hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors">
                                    <td class="py-4 font-medium text-gray-900 dark:text-gray-100">#{{ $order->id }}</td>
                                    <td class="py-4 text-gray-600 dark:text-gray-300">{{ $order->buyer->name ?? 'Guest' }}</td>
                                    <td class="py-4 text-right font-bold text-gray-900 dark:text-white">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="py-4 text-center text-gray-500">No recent orders found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Key Metrics (Simple CSS Bar Chart) -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
                    <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100 mb-2">Key Metrics</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">Monthly Sales Summary</p>
                    
                    <div class="flex items-end space-x-4 h-64 w-full pt-4">
                        @if($monthlySales->isEmpty())
                           <div class="w-full h-full flex items-center justify-center text-gray-400">No data available for chart</div>
                        @else
                            @php $maxTotal = $monthlySales->max('total'); @endphp
                            @foreach($monthlySales as $sale)
                                @php 
                                    $height = $maxTotal > 0 ? ($sale->total / $maxTotal) * 100 : 0; 
                                    $height = max($height, 5); // Minimum % height for visibility
                                @endphp
                                <div class="flex-1 flex flex-col items-center group">
                                    <div class="relative w-full bg-gray-100 dark:bg-gray-700 rounded-lg overflow-hidden flex items-end h-full">
                                        <!-- Gradient Bar -->
                                        <div class="w-full bg-gradient-to-t from-indigo-600 to-purple-500 rounded-t-lg hover:from-indigo-500 hover:to-purple-400 transition-all duration-500 relative group shadow-md" style="height: {{ $height }}%">
                                            <!-- Tooltip -->
                                            <div class="absolute bottom-full mb-2 left-1/2 transform -translate-x-1/2 opacity-0 group-hover:opacity-100 transition-opacity bg-gray-900 text-white text-xs rounded py-1 px-2 whitespace-nowrap z-10">
                                                Rp {{ number_format($sale->total, 0, ',', '.') }}
                                            </div>
                                        </div>
                                    </div>
                                    <span class="text-xs text-gray-500 dark:text-gray-400 mt-2">{{ $sale->month_name }}</span>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
