<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class RealisticProductSeeder extends Seeder
{
    public function run(): void
    {
        // Get seller role
        $sellerRole = Role::where('role_name', 'seller')->first();
        
        // Get all categories
        $categories = Category::all();
        
        // Create sellers with realistic data
        $sellers = [
            [
                'name' => 'Toko Elektronik Jaya',
                'email' => 'elektronik@belantra.com',
                'address' => 'Jl. Mangga Dua No. 123, Jakarta Pusat',
            ],
            [
                'name' => 'Fashion Store Indo',
                'email' => 'fashion@belantra.com',
                'address' => 'Jl. Thamrin City No. 45, Jakarta Pusat',
            ],
            [
                'name' => 'Rumah Furniture',
                'email' => 'furniture@belantra.com',
                'address' => 'Jl. Pramuka Raya No. 78, Jakarta Timur',
            ],
            [
                'name' => 'Toko Buku Gramedia',
                'email' => 'buku@belantra.com',
                'address' => 'Jl. Sudirman No. 56, Jakarta Selatan',
            ],
            [
                'name' => 'Sport Station',
                'email' => 'sport@belantra.com',
                'address' => 'Jl. Senayan No. 12, Jakarta Selatan',
            ],
        ];

        $sellerUsers = [];
        foreach ($sellers as $sellerData) {
            $sellerUsers[] = User::create([
                'name' => $sellerData['name'],
                'email' => $sellerData['email'],
                'password' => Hash::make('password123'),
                'role_id' => $sellerRole->id,
                'balance' => rand(5000000, 20000000),
                'address' => $sellerData['address'],
            ]);
        }

        // Products data per category
        $productsData = [
            'Elektronik' => [
                ['name' => 'iPhone 15 Pro Max 256GB', 'price' => 18999000, 'stock' => 15, 'desc' => 'iPhone terbaru dengan chip A17 Pro, kamera 48MP, dan layar Super Retina XDR. Garansi resmi Apple Indonesia 1 tahun.'],
                ['name' => 'Samsung Galaxy S24 Ultra 512GB', 'price' => 19999000, 'stock' => 12, 'desc' => 'Flagship Android terbaik dengan S Pen, kamera 200MP, dan prosesor Snapdragon 8 Gen 3.'],
                ['name' => 'MacBook Air M3 13-inch', 'price' => 16999000, 'stock' => 8, 'desc' => 'Laptop tipis dan ringan dengan performa luar biasa. RAM 16GB, SSD 512GB, cocok untuk profesional.'],
                ['name' => 'Sony WH-1000XM5 Headphones', 'price' => 5499000, 'stock' => 25, 'desc' => 'Headphone noise cancelling terbaik dengan kualitas audio premium dan baterai 30 jam.'],
                ['name' => 'iPad Pro 12.9 inch M2', 'price' => 17999000, 'stock' => 10, 'desc' => 'Tablet pro dengan layar Liquid Retina XDR dan chip M2 yang powerful untuk kreator konten.'],
                ['name' => 'Apple Watch Series 9', 'price' => 6499000, 'stock' => 20, 'desc' => 'Smartwatch dengan sensor kesehatan lengkap, GPS, dan integrasi sempurna dengan iPhone.'],
                ['name' => 'Dell XPS 15 i7 16GB', 'price' => 24999000, 'stock' => 6, 'desc' => 'Laptop premium untuk developer dengan layar 4K, RAM 16GB, dan RTX 4050.'],
                ['name' => 'AirPods Pro 2nd Gen', 'price' => 3799000, 'stock' => 30, 'desc' => 'TWS earbuds dengan active noise cancellation dan spatial audio. Charging case USB-C.'],
            ],
            'Fashion' => [
                ['name' => 'Kaos Polo Ralph Lauren Original', 'price' => 850000, 'stock' => 50, 'desc' => 'Kaos polo premium 100% cotton dengan logo kuda khas Ralph Lauren. Tersedia berbagai warna.'],
                ['name' => 'Celana Jeans Levi\'s 501 Original', 'price' => 1250000, 'stock' => 40, 'desc' => 'Jeans klasik dengan potongan regular fit. Denim berkualitas tinggi dan tahan lama.'],
                ['name' => 'Sepatu Nike Air Max 270', 'price' => 2199000, 'stock' => 35, 'desc' => 'Sneakers casual dengan cushioning Air Max yang nyaman untuk aktivitas sehari-hari.'],
                ['name' => 'Tas Ransel Herschel Little America', 'price' => 1599000, 'stock' => 25, 'desc' => 'Backpack stylish dengan kapasitas besar dan laptop sleeve. Cocok untuk kuliah atau traveling.'],
                ['name' => 'Jaket Bomber Uniqlo Premium', 'price' => 699000, 'stock' => 45, 'desc' => 'Jaket bomber dengan material berkualitas, windproof dan water resistant.'],
                ['name' => 'Kemeja Flanel Uniqlo', 'price' => 399000, 'stock' => 60, 'desc' => 'Kemeja flanel dengan bahan lembut dan hangat. Perfect untuk casual style.'],
                ['name' => 'Dress Casual Zara Summer Collection', 'price' => 899000, 'stock' => 30, 'desc' => 'Dress cantik untuk acara kasual dengan motif floral. Bahan adem dan nyaman.'],
                ['name' => 'Sandal Adidas Adilette Cloudfoam', 'price' => 449000, 'stock' => 55, 'desc' => 'Sandal super nyaman dengan teknologi Cloudfoam. Perfect untuk santai di rumah.'],
            ],
            'Ibu & Bayi' => [
                ['name' => 'Stroller Bayi Joie Signature', 'price' => 4599000, 'stock' => 15, 'desc' => 'Stroller premium dengan fitur safety lengkap, dapat dilipat kompak, dan roda suspensi.'],
                ['name' => 'Car Seat Maxi-Cosi Pebble 360', 'price' => 5999000, 'stock' => 12, 'desc' => 'Car seat dengan fitur 360° rotasi dan standar keamanan Eropa. Cocok dari newborn.'],
                ['name' => 'Baby Monitor Motorola MBP36XL', 'price' => 2799000, 'stock' => 20, 'desc' => 'Baby monitor dengan kamera HD, two-way talk, dan night vision. Pantau bayi dari smartphone.'],
                ['name' => 'Popok Pampers Premium Care NB 72', 'price' => 159000, 'stock' => 100, 'desc' => 'Popok bayi dengan lapisan super soft dan penyerapan extra. Cocok untuk kulit sensitif.'],
                ['name' => 'Breast Pump Spectra S1+', 'price' => 3299000, 'stock' => 18, 'desc' => 'Pompa AS I elektrik double dengan baterai built-in dan suction adjustable.'],
                ['name' => 'Baby Swing Fisher Price', 'price' => 1899000, 'stock' => 22, 'desc' => 'Ayunan bayi otomatis dengan berbagai speed dan lullaby music untuk menenangkan bayi.'],
            ],
            'Rumah Tangga' => [
                ['name' => 'Rice Cooker Zojirushi 1.8L', 'price' => 6999000, 'stock' => 10, 'desc' => 'Rice cooker Jepang premium dengan teknologi fuzzy logic dan menu masak beragam.'],
                ['name' => 'Vacuum Cleaner Dyson V15 Detect', 'price' => 13999000, 'stock' => 8, 'desc' => 'Vacuum cordless dengan laser detection dan powerful suction untuk membersihkan rumah.'],
                ['name' => 'Air Fryer Philips XXL 7.3L', 'price' => 3599000, 'stock' => 25, 'desc' => 'Air fryer berkapasitas besar dengan teknologi Rapid Air untuk masak sehat tanpa minyak.'],
                ['name' => 'Blender Vitamix E310', 'price' => 7499000, 'stock' => 12, 'desc' => 'Blender professional grade dengan motor powerful untuk smoothies dan soup.'],
                ['name' => 'Microwave Panasonic Inverter 31L', 'price' => 2899000, 'stock' => 18, 'desc' => 'Microwave dengan teknologi inverter untuk memasak lebih cepat dan merata.'],
                ['name' => 'Dispenser Miyako Hot & Cold', 'price' => 1299000, 'stock' => 30, 'desc' => 'Dispenser dengan fitur hot & cold water, hemat energi dan mudah dibersihkan.'],
            ],
            'Olahraga' => [
                ['name' => 'Treadmill Elektrik i-Sports IS-6105', 'price' => 8999000, 'stock' => 5, 'desc' => 'Treadmill untuk home gym dengan motor 2HP, LCD display, dan program workout otomatis.'],
                ['name' => 'Dumbbell Set 20kg Chrome', 'price' => 899000, 'stock' => 25, 'desc' => 'Set dumbbell adjustable dengan plate chrome berkualitas. Perfect untuk home workout.'],
                ['name' => 'Yoga Mat TPE 6mm Premium', 'price' => 349000, 'stock' => 50, 'desc' => 'Matras yoga anti-slip dengan bahan eco-friendly dan cushioning yang nyaman.'],
                ['name' => 'Sepatu Lari Adidas Ultraboost 23', 'price' => 2899000, 'stock' => 20, 'desc' => 'Running shoes dengan teknologi Boost untuk energi return maksimal saat berlari.'],
                ['name' => 'Raket Badminton Yonex Astrox 99', 'price' => 2599000, 'stock' => 15, 'desc' => 'Raket badminton professional untuk smash powerful dengan head heavy balance.'],
                ['name' => 'Jersey Bola Nike Dri-FIT', 'price' => 549000, 'stock' => 40, 'desc' => 'Jersey olahraga dengan teknologi Dri-FIT untuk menyerap keringat. Berbagai tim tersedia.'],
            ],
        ];

        // Seed products
        foreach ($categories as $category) {
            if (isset($productsData[$category->category_name])) {
                // Randomly assign seller
                $seller = $sellerUsers[array_rand($sellerUsers)];
                
                foreach ($productsData[$category->category_name] as $product) {
                    Product::create([
                        'seller_id' => $seller->id,
                        'category_id' => $category->id,
                        'product_name' => $product['name'],
                        'price' => $product['price'],
                        'stock' => $product['stock'],
                        'description' => $product['desc'],
                        'status' => 'active',
                    ]);
                }
            }
        }

        $this->command->info('✅ Realistic product data seeded successfully!');
        $this->command->info('📦 Created ' . Product::count() . ' products across ' . $categories->count() . ' categories');
        $this->command->info('👥 Created ' . count($sellerUsers) . ' seller accounts');
    }
}
