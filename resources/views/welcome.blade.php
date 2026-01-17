<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Belantra Marketplace</title>
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        
        <!-- Styles (Minimal) -->
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="antialiased bg-gray-50 text-black">
        
        <!-- HEADER / NAVBAR -->
        <header class="bg-white border-b p-6">
            <div class="max-w-7xl mx-auto flex justify-between items-center">
                <div class="text-2xl font-bold">Belantra.</div>
                
                <nav>
                    @if (Route::has('login'))
                        <div class="space-x-4">
                            @auth
                                <a href="{{ url('/dashboard') }}" class="font-semibold hover:underline">Dashboard</a>
                            @else
                                <a href="{{ route('login') }}" class="font-semibold hover:underline">Log in</a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="font-semibold hover:underline border border-black px-4 py-2 rounded">Register</a>
                                @endif
                            @endauth
                        </div>
                    @endif
                </nav>
            </div>
        </header>

        <!-- HERO SECTION (Landing Information) -->
        <main class="max-w-7xl mx-auto p-6 py-20 text-center">
            
            <h1 class="text-5xl font-bold mb-6">Marketplace Produk Lokal</h1>
            <p class="text-xl mb-10">Temukan produk unik dari penjual lokal terpercaya.</p>

            <div class="space-y-4">
                @auth
                    <a href="{{ route('explore') }}" class="inline-block bg-blue-600 text-white px-8 py-3 rounded text-lg">
                        Mulai Belanja (Ke Halaman Explore)
                    </a>
                @else
                    <div class="space-x-4">
                        <a href="{{ route('login') }}" class="inline-block bg-blue-600 text-white px-8 py-3 rounded text-lg">
                            Login untuk Belanja
                        </a>
                        <a href="{{ route('register') }}" class="inline-block border border-blue-600 text-blue-600 px-8 py-3 rounded text-lg">
                            Daftar Akun Baru
                        </a>
                    </div>
                    <p class="mt-4 text-sm text-gray-500">*Anda harus login untuk melihat katalog produk lengkap</p>
                @endauth
            </div>

        </main>

        <!-- FEATURES / INFO SECTION -->
        <section class="bg-white py-20 border-t">
            <div class="max-w-7xl mx-auto p-6 grid grid-cols-1 md:grid-cols-3 gap-10 text-center">
                
                <div class="border p-6 rounded">
                    <h3 class="text-xl font-bold mb-2">1. Daftar & Pilih Role</h3>
                    <p>Daftar sebagai Pembeli, Penjual, atau Kurir sesuai kebutuhan Anda.</p>
                </div>

                <div class="border p-6 rounded">
                    <h3 class="text-xl font-bold mb-2">2. Transaksi Aman</h3>
                    <p>Pilih metode pembayaran Transfer (QRIS) atau COD (Bayar di Tempat).</p>
                </div>

                <div class="border p-6 rounded">
                    <h3 class="text-xl font-bold mb-2">3. Pengiriman Terpantau</h3>
                    <p>Lacak status pesanan Anda dari diproses hingga sampai di tujuan.</p>
                </div>

            </div>
        </section>

        <!-- FOOTER -->
        <footer class="bg-gray-100 py-10 border-t mt-auto">
            <div class="max-w-7xl mx-auto text-center p-6">
                <p>&copy; 2026 Belantra Marketplace. Kelompok Pemweb.</p>
            </div>
        </footer>

    </body>
</html>
