<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-bold mb-4">Welcome, Admin!</h3>
                     <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                        <div class="bg-white dark:bg-gray-700 overflow-hidden shadow sm:rounded-lg p-6">
                            <div class="text-xl font-bold">Manage Orders</div>
                             <a href="{{ route('admin.orders.index') }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-300 dark:hover:text-indigo-500 text-sm mt-2 block">View All Orders &rarr;</a>
                        </div>
                         <!-- Add more stats or links here (Users, Products, etc if admin manages them) -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
