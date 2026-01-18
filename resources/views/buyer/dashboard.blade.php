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

    <div class="bg-white overflow-hidden shadow-xl sm:rounded-3xl p-6 mb-6">
    <div class="flex justify-between items-center">
        <div>
            <p class="text-sm font-medium text-indigo-600 uppercase tracking-wider">Active Balance</p>
            <h3 class="text-3xl font-bold text-gray-900">Rp {{ number_format($user->balance, 0, ',', '.') }}</h3>
        </div>
        <button @click="showTopUp = !showTopUp" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-xl font-bold transition-all shadow-lg shadow-indigo-200">
            + Top Up
        </button>
    </div>

    <div x-show="showTopUp" x-transition class="mt-6 pt-6 border-t border-gray-100">
        <form action="{{ route('buyer.topup') }}" method="POST">
            @csrf
            <div class="flex flex-col sm:flex-row gap-3">
                <div class="relative flex-grow">
                    <span class="absolute left-4 top-2.5 text-gray-400">Rp</span>
                    <input type="number" name="amount" min="10000" placeholder="Minimal 10.000" 
                        class="w-full pl-10 pr-4 py-2 bg-gray-50 border-none rounded-xl focus:ring-2 focus:ring-indigo-500" required>
                </div>
                <button type="submit" class="bg-gray-900 text-white px-8 py-2 rounded-xl font-bold hover:bg-black transition-all">
                    Confirm Payment
                </button>
            </div>
        </form>
    </div>
</div>

            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
                
                <!-- Welcome Banner -->
                <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-indigo-600 to-purple-700 shadow-xl">
                    <!-- Decorative elements -->
                    <div class="absolute top-0 right-0 -mr-16 -mt-16 w-64 h-64 rounded-full bg-white/10 blur-3xl"></div>
                    <div class="absolute bottom-0 left-0 -ml-16 -mb-16 w-64 h-64 rounded-full bg-indigo-500/20 blur-3xl"></div>
                    
                    <div class="relative p-8 md:p-12 text-white">
                        <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                            <div>
                                <h3 class="text-3xl font-extrabold mb-2">Welcome Back, {{ Auth::user()->name }}! 👋</h3>
                                <p class="text-indigo-100 text-lg max-w-xl">Ready to find something new today? Check out our latest collections or track your active orders.</p>
                            </div>
                            <div class="flex flex-wrap gap-4">
                                <a href="{{ route('explore') }}" class="inline-flex items-center px-6 py-3 bg-white text-indigo-700 font-bold rounded-xl shadow-lg hover:bg-indigo-50 hover:scale-105 transition-all duration-300">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                    Browse Products
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Stats Grid -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Total Orders -->
                    <a href="{{ route('buyer.orders.index') }}" class="block">
                        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-lg border border-gray-100 dark:border-gray-700 relative overflow-hidden group hover:border-indigo-500/30 transition-all duration-300 h-full">
                            <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                                <svg class="w-24 h-24 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                </svg>
                            </div>
                            <div class="relative z-10">
                                <div class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Total Orders</div>
                                <div class="text-4xl font-extrabold text-gray-900 dark:text-white group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">
                                    {{ $orders->count() }}
                                </div>
                                <div class="mt-4 flex items-center text-sm text-green-600 dark:text-green-400 font-medium">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    View full history
                                </div>
                            </div>
                        </div>
                    </a>

                    <!-- Total Spent -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-lg border border-gray-100 dark:border-gray-700 relative overflow-hidden group hover:border-purple-500/30 transition-all duration-300">
                        <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                            <svg class="w-24 h-24 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="relative z-10">
                            <div class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Total Spent</div>
                            <div class="text-4xl font-extrabold text-gray-900 dark:text-white group-hover:text-purple-600 dark:group-hover:text-purple-400 transition-colors">
                                Rp {{ number_format($orders->sum('total_price'), 0, ',', '.') }}
                            </div>
                            <div class="mt-4 flex items-center text-sm text-purple-600 dark:text-purple-400 font-medium">
                                Lifetime value
                            </div>
                        </div>
                    </div>

                    <!-- Current Balance -->
                    <div class="bg-gradient-to-br from-amber-400 to-orange-500 rounded-2xl p-6 shadow-lg text-white relative overflow-hidden group transform hover:-translate-y-1 transition-all duration-300">
                        <div class="absolute top-0 right-0 p-4 opacity-20 group-hover:opacity-30 transition-opacity">
                            <svg class="w-24 h-24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                        <div class="relative z-10">
                            <div class="text-sm font-medium text-amber-100 uppercase tracking-wider mb-1">Current Balance</div>
                            <div class="text-4xl font-extrabold text-white">
                                Rp {{ number_format(Auth::user()->balance, 0, ',', '.') }}
                            </div>
                            <button @click="showTopUp = true" class="mt-4 px-4 py-1.5 bg-white/20 hover:bg-white/30 backdrop-blur-sm rounded-lg text-sm font-bold transition-colors">
                                Top Up Balance
                            </button>
                        </div>
                    </div>
                </div>

            <!-- Recent Orders Section -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden border border-gray-100 dark:border-gray-700">
                <div class="p-6 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center bg-gray-50/50 dark:bg-gray-800/50">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">Recent Orders</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Your latest 5 purchases</p>
                    </div>
                    <a href="{{ route('buyer.orders.index') }}" class="text-indigo-600 dark:text-indigo-400 text-sm font-medium hover:text-indigo-800 dark:hover:text-indigo-300 flex items-center">
                        View All Orders
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>

                @if(isset($orders) && $orders->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead>
                                <tr class="bg-gray-50 dark:bg-gray-700/50">
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Order ID</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Date</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Total</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Action</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($orders->take(5) as $order)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="font-mono text-sm text-indigo-600 dark:text-indigo-400 font-bold">#{{ $order->id }}</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300">
                                            <div class="flex items-center">
                                                <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                                {{ $order->created_at->format('d M Y') }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900 dark:text-white">
                                            Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @php
                                                $statusClasses = [
                                                    'pending' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                                                    'processing' => 'bg-blue-100 text-blue-800 border-blue-200',
                                                    'completed' => 'bg-green-100 text-green-800 border-green-200',
                                                    'cancelled' => 'bg-red-100 text-red-800 border-red-200',
                                                ];
                                                $currentClass = $statusClasses[$order->status] ?? 'bg-gray-100 text-gray-800 border-gray-200';
                                            @endphp
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full border {{ $currentClass }}">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                            <a href="{{ route('buyer.orders.show', $order) }}" class="inline-flex items-center text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 font-medium group">
                                                Details
                                                <svg class="w-4 h-4 ml-1 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                                </svg>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-12">
                        <div class="inline-block p-4 rounded-full bg-gray-100 dark:bg-gray-700 mb-4">
                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">No orders yet</h3>
                        <p class="text-gray-500 dark:text-gray-400 mt-1 mb-6">Start shopping to see your orders here.</p>
                        <a href="{{ route('explore') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Start Shopping
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
    </div>

    <!-- Top Up Modal -->
    <div x-show="showTopUp" 
         class="fixed inset-0 z-50 overflow-y-auto" 
         style="display: none;"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
        
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity" @click="showTopUp = false"></div>

        <!-- Modal Content -->
        <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-2xl bg-white dark:bg-gray-800 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg border border-gray-100 dark:border-gray-700"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                
                <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-4 py-6 sm:px-6">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xl font-bold leading-6 text-white" id="modal-title">Top Up Balance</h3>
                        <button @click="showTopUp = false" class="text-white hover:text-indigo-100 focus:outline-none">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
                
                <form action="{{ route('buyer.topup') }}" method="POST" class="p-6">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label for="amount" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Select Amount</label>
                            <div class="grid grid-cols-2 gap-3 mb-4">
                                <button type="button" @click="$refs.amountInput.value = 50000" class="py-2 px-4 border border-gray-200 dark:border-gray-600 rounded-lg hover:border-indigo-500 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors text-sm font-semibold dark:text-gray-300">Rp 50.000</button>
                                <button type="button" @click="$refs.amountInput.value = 100000" class="py-2 px-4 border border-gray-200 dark:border-gray-600 rounded-lg hover:border-indigo-500 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors text-sm font-semibold dark:text-gray-300">Rp 100.000</button>
                                <button type="button" @click="$refs.amountInput.value = 250000" class="py-2 px-4 border border-gray-200 dark:border-gray-600 rounded-lg hover:border-indigo-500 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors text-sm font-semibold dark:text-gray-300">Rp 250.000</button>
                                <button type="button" @click="$refs.amountInput.value = 500000" class="py-2 px-4 border border-gray-200 dark:border-gray-600 rounded-lg hover:border-indigo-500 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors text-sm font-semibold dark:text-gray-300">Rp 500.000</button>
                            </div>
                            
                            <div class="relative rounded-md shadow-sm">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                    <span class="text-gray-500 sm:text-sm">Rp</span>
                                </div>
                                <input type="number" name="amount" x-ref="amountInput" id="amount" class="block w-full rounded-lg border-gray-300 pl-10 focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm py-3" placeholder="0" min="10000" required>
                            </div>
                            <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">Minimum top up amount is Rp 10.000</p>
                        </div>
                    </div>
                    
                    <div class="mt-6 flex flex-col sm:flex-row-reverse gap-3">
                        <button type="submit" class="inline-flex w-full justify-center rounded-lg bg-indigo-600 px-3 py-3 text-sm font-bold text-white shadow-sm hover:bg-indigo-500 sm:w-auto min-w-[120px]">
                            Top Up Now
                        </button>
                        <button type="button" @click="showTopUp = false" class="inline-flex w-full justify-center rounded-lg bg-white dark:bg-gray-700 px-3 py-3 text-sm font-semibold text-gray-900 dark:text-gray-200 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600 sm:w-auto min-w-[100px]">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>
</x-app-layout>
