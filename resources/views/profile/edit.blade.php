<x-app-layout>
    <div class="py-12 bg-blue-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-10">
                <h2 class="text-3xl font-black text-gray-900 tracking-tight">Profil Information</h2>
                <p class="text-gray-500">Update your personal details and security settings.</p>
            </div>

            <div class="flex flex-col md:flex-row gap-8">
                
                <div class="w-full md:w-1/3 space-y-6">
                    <div class="bg-white border border-gray-200 p-6 rounded-2xl shadow-sm">
                        <div class="flex items-center gap-4 mb-6">
                            <div class="h-14 w-14 bg-indigo-600 rounded-full flex items-center justify-center text-white text-xl font-bold">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900">{{ $user->name }}</h4>
                                <span class="text-xs font-bold text-indigo-600 uppercase">{{ $user->role->role_name }}</span>
                            </div>
                        </div>
                        
                        <div class="space-y-4">
                            <div class="p-4 bg-gray-50 rounded-xl border border-gray-100">
                                <div class="inline-block px-2 py-0.5 bg-indigo-600 rounded-md mb-2">
                                    <p class="text-[10px] font-black text-white uppercase tracking-widest">Active Balance</p>
                                </div>
                                <p class="text-xl font-bold text-gray-900 leading-none">Rp {{ number_format($user->balance, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="hidden md:block p-4">
                        <p class="text-sm text-gray-400">Pastikan data yang kamu masukkan valid untuk keperluan transaksi di Belantra.</p>
                    </div>
                </div>

                <div class="w-full md:w-2/3 space-y-8">
                    
                    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
                        <div class="px-8 py-5 border-b border-gray-100 font-bold text-gray-800 bg-gray-50/50 flex items-center gap-2">
                            <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                            </svg>
                            General Information
                        </div>
                        <div class="p-8">
                            <form method="POST" action="{{ route('profile.update') }}" class="space-y-6">
                                @csrf
                                @method('PATCH')
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1 block">Full Name</label>
                                        <input type="text" name="name" value="{{ old('name', $user->name) }}" 
                                            class="w-full border-gray-200 rounded-xl bg-gray-100 focus:bg-white focus:ring-indigo-500 focus:border-indigo-500 transition-all px-4 py-3">
                                    </div>
                                    <div>
                                        <label class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1 block">Email Address</label>
                                        <input type="email" name="email" value="{{ old('email', $user->email) }}" 
                                            class="w-full border-gray-200 rounded-xl bg-gray-100 focus:bg-white focus:ring-indigo-500 focus:border-indigo-500 transition-all px-4 py-3">
                                    </div>
                                </div>

                                <div>
                                    <label class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1 block">Home Address</label>
                                    <textarea name="address" rows="3" 
                                        class="w-full border-gray-200 rounded-xl bg-gray-100 focus:bg-white focus:ring-indigo-500 focus:border-indigo-500 transition-all px-4 py-3">{{ old('address', $user->address) }}</textarea>
                                </div>

                                <div class="flex justify-end pt-2">
                                    <button type="submit" class="bg-gray-900 text-white px-8 py-2.5 rounded-xl font-bold hover:bg-black transition-all shadow-md">
                                        Save Changes
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
                        <div class="px-8 py-5 border-b border-gray-100 font-bold text-gray-800 bg-gray-50/50 flex items-center gap-2">
                            <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                            Security Settings
                        </div>
                        <div class="p-8">
                            <form method="POST" action="{{ route('profile.update') }}" class="space-y-6">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="name" value="{{ $user->name }}">
                                <input type="hidden" name="email" value="{{ $user->email }}">
                                <input type="hidden" name="address" value="{{ $user->address }}">

                                <div>
                                    <label class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1 block">Current Password</label>
                                    <input type="password" name="current_password" 
                                        class="w-full border-gray-200 rounded-xl bg-gray-100 focus:bg-white focus:ring-red-500 focus:border-red-500 transition-all px-4 py-3">
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1 block">New Password</label>
                                        <input type="password" name="new_password" 
                                            class="w-full border-gray-200 rounded-xl bg-gray-100 focus:bg-white focus:ring-indigo-500 focus:border-indigo-500 transition-all px-4 py-3">
                                    </div>
                                    <div>
                                        <label class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1 block">Confirm New Password</label>
                                        <input type="password" name="new_password_confirmation" 
                                            class="w-full border-gray-200 rounded-xl bg-gray-100 focus:bg-white focus:ring-indigo-500 focus:border-indigo-500 transition-all px-4 py-3">
                                    </div>
                                </div>

                                <div class="flex justify-end pt-2 text-indigo-600 font-bold">
                                    <button type="submit">Update Password →</button>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>