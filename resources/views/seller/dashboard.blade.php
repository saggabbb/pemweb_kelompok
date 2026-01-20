<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Seller Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Welcome Section -->
            <div class="relative bg-gradient-to-r from-indigo-600 to-purple-700 rounded-xl shadow-lg p-8 mb-8 overflow-hidden text-white">
                <div class="absolute top-0 right-0 -mr-8 -mt-8 w-32 h-32 rounded-full bg-white/10 blur-xl"></div>
                <h3 class="relative text-2xl font-bold mb-2">Welcome Back, {{ Auth::user()->name }}!</h3>
                <p class="relative text-indigo-100">Track your sales performance and manage incoming orders.</p>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <!-- Total Orders -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border-l-4 border-blue-500">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Total Orders</p>
                            <h4 class="text-3xl font-bold text-gray-900 dark:text-white mt-1">{{ $totalOrders }}</h4>
                        </div>
                        <div class="p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg text-blue-600 dark:text-blue-400">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Total Revenue -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border-l-4 border-purple-500">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Total Revenue</p>
                            <h4 class="text-3xl font-bold text-gray-900 dark:text-white mt-1">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h4>
                        </div>
                        <div class="p-3 bg-purple-50 dark:bg-purple-900/20 rounded-lg text-purple-600 dark:text-purple-400">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Line Chart Section -->
                <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
                    <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100 mb-6">Sales Performance</h3>
                    
                    @if($monthlySales->isEmpty())
                        <div class="h-64 flex items-center justify-center text-gray-400">
                            No sales data available yet.
                        </div>
                    @else
                        @php
                            $maxTotal = $monthlySales->max('total');
                            $points = [];
                            $labels = [];
                            $count = $monthlySales->count();
                            $width = 1000;
                            $height = 300;
                            $padding = 20;
                            
                            foreach($monthlySales->values() as $index => $sale) {
                                $x = ($index / max(1, $count - 1)) * ($width - 2 * $padding) + $padding;
                                // Invert Y (SVG 0 is top)
                                $y = $height - (($sale->total / max(1, $maxTotal)) * ($height - 2 * $padding)) - $padding;
                                $points[] = "$x,$y";
                                $labels[] = ['x' => $x, 'text' => $sale->month_name, 'val' => $sale->total];
                            }
                            $pointsString = implode(' ', $points);
                        @endphp
                        
                        <div class="relative w-full overflow-hidden">
                            <svg viewBox="0 0 1000 350" preserveAspectRatio="none" class="w-full h-64">
                                <!-- Grid Lines -->
                                <line x1="0" y1="{{ $height - $padding }}" x2="1000" y2="{{ $height - $padding }}" stroke="#e5e7eb" stroke-width="1" />
                                <line x1="0" y1="{{ $padding }}" x2="1000" y2="{{ $padding }}" stroke="#e5e7eb" stroke-width="1" stroke-dasharray="4" />
                                
                                <!-- The Line -->
                                <polyline fill="none" stroke="#8b5cf6" stroke-width="3" points="{{ $pointsString }}" />
                                
                                <!-- Area under the line (Gradient) -->
                                <defs>
                                    <linearGradient id="gradient" x1="0" x2="0" y1="0" y2="1">
                                        <stop offset="0%" stop-color="#8b5cf6" stop-opacity="0.2"/>
                                        <stop offset="100%" stop-color="#8b5cf6" stop-opacity="0"/>
                                    </linearGradient>
                                </defs>
                                <polyline fill="url(#gradient)" stroke="none" points="{{ $points[0] }} {{ $pointsString }} {{ explode(',', end($points))[0] }},{{ $height }} {{ explode(',', $points[0])[0] }},{{ $height }}" />

                                <!-- Points and Tooltips Wrapper -->
                                @foreach($labels as $label)
                                    <circle cx="{{ $label['x'] }}" cy="{{ $height - (($label['val'] / max(1, $maxTotal)) * ($height - 2 * $padding)) - $padding }}" r="5" fill="#8b5cf6" class="hover:r-7 transition-all cursor-pointer">
                                        <title>Rp {{ number_format($label['val'], 0, ',', '.') }}</title>
                                    </circle>
                                    <text x="{{ $label['x'] }}" y="{{ $height + 25 }}" text-anchor="middle" font-size="12" fill="#6b7280">{{ $label['text'] }}</text>
                                @endforeach
                            </svg>
                        </div>
                    @endif
                </div>

                <!-- Recent Orders -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100">Recent Orders</h3>
                        <a href="{{ route('seller.orders.index') }}" class="text-sm text-purple-600 hover:text-purple-700 font-medium">View All</a>
                    </div>

                    <div class="space-y-4">
                        @forelse($recentOrders->take(5) as $order)
                        <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                            <div>
                                <div class="text-sm font-bold text-gray-900 dark:text-white">#{{ $order->id }} - {{ $order->buyer->name }}</div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">{{ $order->created_at->diffForHumans() }}</div>
                            </div>
                            <div class="text-right">
                                <div class="text-sm font-bold text-purple-600">Rp {{ number_format($order->total_price, 0, ',', '.') }}</div>
                                <span class="inline-block px-2 py-0.5 text-[10px] rounded-full 
                                    {{ match($order->status) {
                                        'completed' => 'bg-green-100 text-green-800',
                                        'processing' => 'bg-blue-100 text-blue-800',
                                        default => 'bg-gray-100 text-gray-800'
                                    } }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </div>
                        </div>
                        @empty
                        <p class="text-gray-500 text-sm text-center py-4">No recent orders found.</p>
                        @endforelse
                    </div>
                    
                    <div class="mt-6 pt-6 border-t border-gray-100 dark:border-gray-700">
                        <a href="{{ route('seller.products.create') }}" class="block w-full py-2 bg-purple-600 hover:bg-purple-700 text-white text-center rounded-lg text-sm font-medium transition-colors">
                            + Add New Product
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
