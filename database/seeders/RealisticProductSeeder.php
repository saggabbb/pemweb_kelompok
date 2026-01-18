<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Role;

class RealisticProductSeeder extends Seeder
{
    public function run(): void
    {
        // Get existing sellers (already created by UserSeeder)
        $sellerRole = Role::where('role_name', 'seller')->first();
        $sellerUsers = User::where('role_id', $sellerRole->id)->get();
        
        if ($sellerUsers->count() === 0) {
            $this->command->error('❌ No sellers found! Please run UserSeeder first.');
            return;
        }
        
        // Get all categories
        $categories = Category::all();
        
        // Products data per category
        $productsData = [
            'Elektronik' => [
                ['name' => 'iPhone 15 Pro Max 256GB', 'price' => 18999000, 'stock' => 15, 'desc' => 'iPhone terbaru dengan chip A17 Pro, kamera 48MP, dan layar Super Retina XDR. Garansi resmi Apple Indonesia 1 tahun.', 'image' => 'https://picsum.photos/seed/iphone15/800/800'],
                ['name' => 'Samsung Galaxy S24 Ultra 512GB', 'price' => 19999000, 'stock' => 12, 'desc' => 'Flagship Android terbaik dengan S Pen, kamera 200MP, dan prosesor Snapdragon 8 Gen 3.', 'image' => 'https://picsum.photos/seed/samsung24/800/800'],
                ['name' => 'MacBook Air M3 13-inch', 'price' => 16999000, 'stock' => 8, 'desc' => 'Laptop tipis dan ringan dengan performa luar biasa. RAM 16GB, SSD 512GB, cocok untuk profesional.', 'image' => 'https://picsum.photos/seed/macbook/800/800'],
                ['name' => 'Sony WH-1000XM5 Headphones', 'price' => 5499000, 'stock' => 25, 'desc' => 'Headphone noise cancelling terbaik dengan kualitas audio premium dan baterai 30 jam.', 'image' => 'https://picsum.photos/seed/sony-headphone/800/800'],
                ['name' => 'iPad Pro 12.9 inch M2', 'price' => 17999000, 'stock' => 10, 'desc' => 'Tablet pro dengan layar Liquid Retina XDR dan chip M2 yang powerful untuk kreator konten.', 'image' => 'https://picsum.photos/seed/ipad/800/800'],
                ['name' => 'Apple Watch Series 9', 'price' => 6499000, 'stock' => 20, 'desc' => 'Smartwatch dengan sensor kesehatan lengkap, GPS, dan integrasi sempurna dengan iPhone.', 'image' => 'https://picsum.photos/seed/applewatch/800/800'],
                ['name' => 'Dell XPS 15 i7 16GB', 'price' => 24999000, 'stock' => 6, 'desc' => 'Laptop premium untuk developer dengan layar 4K, RAM 16GB, dan RTX 4050.', 'image' => 'https://picsum.photos/seed/dellxps/800/800'],
                ['name' => 'AirPods Pro 2nd Gen', 'price' => 3799000, 'stock' => 30, 'desc' => 'TWS earbuds dengan active noise cancellation dan spatial audio. Charging case USB-C.', 'image' => 'https://picsum.photos/seed/airpods/800/800'],
            ],
            'Fashion' => [
                ['name' => 'Kaos Polo Ralph Lauren Original', 'price' => 850000, 'stock' => 50, 'desc' => 'Kaos polo premium 100% cotton dengan logo kuda khas Ralph Lauren. Tersedia berbagai warna.', 'image' => 'https://picsum.photos/seed/polo/800/800'],
                ['name' => 'Celana Jeans Levi\'s 501 Original', 'price' => 1250000, 'stock' => 40, 'desc' => 'Jeans klasik dengan potongan regular fit. Denim berkualitas tinggi dan tahan lama.', 'image' => 'https://picsum.photos/seed/jeans/800/800'],
                ['name' => 'Sepatu Nike Air Max 270', 'price' => 2199000, 'stock' => 35, 'desc' => 'Sneakers casual dengan cushioning Air Max yang nyaman untuk aktivitas sehari-hari.', 'image' => 'https://picsum.photos/seed/nike/800/800'],
                ['name' => 'Tas Ransel Herschel Little America', 'price' => 1599000, 'stock' => 25, 'desc' => 'Backpack stylish dengan kapasitas besar dan laptop sleeve. Cocok untuk kuliah atau traveling.', 'image' => 'https://picsum.photos/seed/backpack/800/800'],
                ['name' => 'Jaket Bomber Uniqlo Premium', 'price' => 699000, 'stock' => 45, 'desc' => 'Jaket bomber dengan material berkualitas, windproof dan water resistant.', 'image' => 'https://picsum.photos/seed/jacket/800/800'],
                ['name' => 'Kemeja Flanel Uniqlo', 'price' => 399000, 'stock' => 60, 'desc' => 'Kemeja flanel dengan bahan lembut dan hangat. Perfect untuk casual style.', 'image' => 'https://picsum.photos/seed/flannel/800/800'],
                ['name' => 'Dress Casual Zara Summer Collection', 'price' => 899000, 'stock' => 30, 'desc' => 'Dress cantik untuk acara kasual dengan motif floral. Bahan adem dan nyaman.', 'image' => 'https://picsum.photos/seed/dress/800/800'],
                ['name' => 'Sandal Adidas Adilette Cloudfoam', 'price' => 449000, 'stock' => 55, 'desc' => 'Sandal super nyaman dengan teknologi Cloudfoam. Perfect untuk santai di rumah.', 'image' => 'https://picsum.photos/seed/sandals/800/800'],
            ],
            'Ibu & Bayi' => [
                ['name' => 'Stroller Bayi Joie Signature', 'price' => 4599000, 'stock' => 15, 'desc' => 'Stroller premium dengan fitur safety lengkap, dapat dilipat kompak, dan roda suspensi.', 'image' => 'https://picsum.photos/seed/stroller/800/800'],
                ['name' => 'Car Seat Maxi-Cosi Pebble 360', 'price' => 5999000, 'stock' => 12, 'desc' => 'Car seat dengan fitur 360° rotasi dan standar keamanan Eropa. Cocok dari newborn.', 'image' => 'https://picsum.photos/seed/carseat/800/800'],
                ['name' => 'Baby Monitor Motorola MBP36XL', 'price' => 2799000, 'stock' => 20, 'desc' => 'Baby monitor dengan kamera HD, two-way talk, dan night vision. Pantau bayi dari smartphone.', 'image' => 'https://picsum.photos/seed/babymonitor/800/800'],
                ['name' => 'Popok Pampers Premium Care NB 72', 'price' => 159000, 'stock' => 100, 'desc' => 'Popok bayi dengan lapisan super soft dan penyerapan extra. Cocok untuk kulit sensitif.', 'image' => 'https://picsum.photos/seed/diapers/800/800'],
                ['name' => 'Breast Pump Spectra S1+', 'price' => 3299000, 'stock' => 18, 'desc' => 'Pompa ASI elektrik double dengan baterai built-in dan suction adjustable.', 'image' => 'https://picsum.photos/seed/breastpump/800/800'],
                ['name' => 'Baby Swing Fisher Price', 'price' => 1899000, 'stock' => 22, 'desc' => 'Ayunan bayi otomatis dengan berbagai speed dan lullaby music untuk menenangkan bayi.', 'image' => 'https://picsum.photos/seed/babyswing/800/800'],
            ],
            'Rumah Tangga' => [
                ['name' => 'Rice Cooker Zojirushi 1.8L', 'price' => 6999000, 'stock' => 10, 'desc' => 'Rice cooker Jepang premium dengan teknologi fuzzy logic dan menu masak beragam.', 'image' => 'https://picsum.photos/seed/ricecooker/800/800'],
                ['name' => 'Vacuum Cleaner Dyson V15 Detect', 'price' => 13999000, 'stock' => 8, 'desc' => 'Vacuum cordless dengan laser detection dan powerful suction untuk membersihkan rumah.', 'image' => 'https://picsum.photos/seed/vacuum/800/800'],
                ['name' => 'Air Fryer Philips XXL 7.3L', 'price' => 3599000, 'stock' => 25, 'desc' => 'Air fryer berkapasitas besar dengan teknologi Rapid Air untuk masak sehat tanpa minyak.', 'image' => 'https://picsum.photos/seed/airfryer/800/800'],
                ['name' => 'Blender Vitamix E310', 'price' => 7499000, 'stock' => 12, 'desc' => 'Blender professional grade dengan motor powerful untuk smoothies dan soup.', 'image' => 'https://picsum.photos/seed/blender/800/800'],
                ['name' => 'Microwave Panasonic Inverter 31L', 'price' => 2899000, 'stock' => 18, 'desc' => 'Microwave dengan teknologi inverter untuk memasak lebih cepat dan merata.', 'image' => 'https://picsum.photos/seed/microwave/800/800'],
                ['name' => 'Dispenser Miyako Hot & Cold', 'price' => 1299000, 'stock' => 30, 'desc' => 'Dispenser dengan fitur hot & cold water, hemat energi dan mudah dibersihkan.', 'image' => 'https://picsum.photos/seed/dispenser/800/800'],
            ],
            'Olahraga' => [
                ['name' => 'Treadmill Elektrik i-Sports IS-6105', 'price' => 8999000, 'stock' => 5, 'desc' => 'Treadmill untuk home gym dengan motor 2HP, LCD display, dan program workout otomatis.', 'image' => 'https://picsum.photos/seed/treadmill/800/800'],
                ['name' => 'Dumbbell Set 20kg Chrome', 'price' => 899000, 'stock' => 25, 'desc' => 'Set dumbbell adjustable dengan plate chrome berkualitas. Perfect untuk home workout.', 'image' => 'https://picsum.photos/seed/dumbbell/800/800'],
                ['name' => 'Yoga Mat TPE 6mm Premium', 'price' => 349000, 'stock' => 50, 'desc' => 'Matras yoga anti-slip dengan bahan eco-friendly dan cushioning yang nyaman.', 'image' => 'https://picsum.photos/seed/yogamat/800/800'],
                ['name' => 'Sepatu Lari Adidas Ultraboost 23', 'price' => 2899000, 'stock' => 20, 'desc' => 'Running shoes dengan teknologi Boost untuk energi return maksimal saat berlari.', 'image' => 'https://picsum.photos/seed/runningshoes/800/800'],
                ['name' => 'Raket Badminton Yonex Astrox 99', 'price' => 2599000, 'stock' => 15, 'desc' => 'Raket badminton professional untuk smash powerful dengan head heavy balance.', 'image' => 'https://picsum.photos/seed/badminton/800/800'],
                ['name' => 'Jersey Bola Nike Dri-FIT', 'price' => 549000, 'stock' => 40, 'desc' => 'Jersey olahraga dengan teknologi Dri-FIT untuk menyerap keringat. Berbagai tim tersedia.', 'image' => 'https://picsum.photos/seed/jersey/800/800'],
            ],
        ];

        // Seed products - assign to existing sellers randomly
        $productCount = 0;
        foreach ($categories as $category) {
            if (isset($productsData[$category->category_name])) {
                foreach ($productsData[$category->category_name] as $product) {
                    // Randomly assign to one of the existing sellers
                    $seller = $sellerUsers->random();
                    
                    Product::create([
                        'seller_id' => $seller->id,
                        'category_id' => $category->id,
                        'product_name' => $product['name'],
                        'price' => $product['price'],
                        'stock' => $product['stock'],
                        'description' => $product['desc'],
                        'image' => $product['image'] ?? null,
                        'status' => 'active',
                    ]);
                    $productCount++;
                }
            }
        }

        $this->command->info('✅ Realistic product data seeded successfully!');
        $this->command->info('📦 Created ' . $productCount . ' products across ' . $categories->count() . ' categories');
        $this->command->info('🏪 Using ' . $sellerUsers->count() . ' existing seller accounts');
    }
}
