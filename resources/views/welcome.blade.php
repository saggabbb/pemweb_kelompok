<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Belantra Marketplace</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600,700&display=swap" rel="stylesheet" />
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="antialiased bg-slate-50 text-slate-900 font-['Figtree']">
        
        <header class="bg-white border-b border-slate-200 sticky top-0 z-50">
            <div class="max-w-7xl mx-auto flex justify-between items-center px-6 py-4">
                <div class="text-2xl font-bold tracking-tight">Belantra<span class="text-blue-600">.</span></div>
                
                <nav>
                    @if (Route::has('login'))
                        <div class="flex items-center gap-4">
                            @auth
                                <a href="{{ url('/dashboard') }}" class="text-sm font-semibold hover:text-blue-600">Dashboard</a>
                            @else
                                <a href="{{ route('login') }}" class="text-sm font-semibold hover:text-blue-600">Log in</a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="bg-blue-600 text-white px-5 py-2 rounded-lg text-sm font-semibold hover:bg-blue-700 transition shadow-sm">
                                        Register
                                    </a>
                                @endif
                            @endauth
                        </div>
                    @endif
                </nav>
            </div>
        </header>

        <main class="max-w-7xl mx-auto px-6 py-20 text-center">
            <h1 class="text-5xl md:text-6xl font-extrabold text-slate-900 mb-6 tracking-tight">
                Marketplace <span class="text-blue-600">Produk Lokal</span>
            </h1>
            <p class="text-xl text-slate-600 mb-10 max-w-2xl mx-auto">
                Temukan produk unik dari penjual lokal terpercaya.
            </p>

            <div class="flex flex-col sm:flex-row justify-center gap-4 mb-6">
                @auth
                    <a href="{{ url('/explore') }}" class="bg-blue-600 text-white px-8 py-4 rounded-xl font-bold shadow-lg hover:bg-blue-700 transition transform hover:-translate-y-1">
                        Mulai Belanja Sekarang
                    </a>
                @else
                    <a href="{{ route('login') }}" class="bg-blue-600 text-white px-8 py-4 rounded-xl font-bold shadow-lg hover:bg-blue-700 transition transform hover:-translate-y-1">
                        Login untuk Belanja
                    </a>
                    <a href="{{ route('register') }}" class="bg-white text-blue-600 border-2 border-blue-600 px-8 py-4 rounded-xl font-bold hover:bg-blue-50 transition">
                        Daftar Akun Baru
                    </a>
                @endauth
            </div>
            <p class="text-sm text-slate-400 font-medium">* Anda harus login untuk melihat katalog produk lengkap</p>
        </main>

        <section class="max-w-7xl mx-auto px-6 pb-24">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                
                <div class="bg-white p-8 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition">
                    <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mb-6 font-bold text-xl">1</div>
                    <h3 class="text-xl font-bold mb-3">Daftar & Pilih Role</h3>
                    <p class="text-slate-500 text-sm leading-relaxed">Daftar sebagai Pembeli, Penjual, atau Kurir sesuai kebutuhan Anda.</p>
                </div>

                <div class="bg-white p-8 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition">
                    <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mb-6 font-bold text-xl text-blue-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04kM12 21.48l-.392-.004z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Transaksi Aman</h3>
                    <p class="text-slate-500 text-sm leading-relaxed">Pilih metode pembayaran Transfer (QRIS) atau COD (Bayar di Tempat).</p>
                </div>

                <div class="bg-white p-8 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition">
                    <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mb-6 font-bold text-xl">3</div>
                    <h3 class="text-xl font-bold mb-3">Pengiriman Terpantau</h3>
                    <p class="text-slate-500 text-sm leading-relaxed">Lacak status pesanan Anda dari diproses hingga sampai di tujuan.</p>
                </div>

            </div>
        </section>

        <footer class="bg-white border-t border-slate-200 py-10">
            <div class="max-w-7xl mx-auto px-6 text-center text-slate-400 text-sm">
                &copy; 2026 Belantra Marketplace. Kelompok Pemweb.
            </div>
        </footer>

    </body>
</html>