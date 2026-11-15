<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CatalogSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['Electronics', 'bi-tv', 'Televisions, tablets, monitors and everyday gadgets.', 1],
            ['Mobile Phones', 'bi-phone', 'Latest smartphones with official warranty.', 2],
            ['Laptops & Computers', 'bi-laptop', 'Laptops, keyboards and computer accessories.', 3],
            ['Gaming', 'bi-controller', 'Consoles, controllers and gaming gear.', 4],
            ['Audio', 'bi-headphones', 'Headphones, earbuds and Bluetooth speakers.', 5],
            ['Cameras', 'bi-camera', 'Cameras, lenses, action cams and drones.', 6],
            ['Fashion', 'bi-bag', 'Clothing and everyday essentials for men and women.', 7],
            ['Footwear', 'bi-box-seam', 'Sneakers, runners and casual shoes.', 8],
            ['Watches', 'bi-smartwatch', 'Luxury watches and smart wearables.', 9],
            ['Home & Living', 'bi-house', 'Furniture, decor and kitchen essentials.', 10],
            ['Sports', 'bi-bicycle', 'Fitness and outdoor sports equipment.', 11],
            ['Health & Beauty', 'bi-heart-pulse', 'Skincare, fragrances and personal care.', 12],
            ['Books', 'bi-book', 'Bestsellers and self-development reads.', 13],
            ['Toys & Kids', 'bi-robot', 'Toys, puzzles and learning kits for kids.', 14],
        ];

        foreach ($categories as [$name, $icon, $description, $order]) {
            Category::updateOrCreate(
                ['slug' => Str::slug($name)],
                ['name' => $name, 'description' => $description, 'status' => 'active', 'sort_order' => $order]
            );
        }

        $brands = [
            'Samsung', 'Apple', 'Sony', 'LG', 'Xiaomi', 'OnePlus', 'Infinix', 'Tecno',
            'HP', 'Dell', 'Asus', 'Lenovo', 'Canon', 'Nikon', 'Fujifilm', 'GoPro', 'DJI',
            'JBL', 'Bose', 'Logitech', 'Razer', 'Anker', 'TP-Link', 'Nike', 'Adidas',
            'Puma', 'Reebok', 'Levi\'s', 'Casio', 'Fossil', 'Seiko', 'Tissot', 'Garmin',
            'IKEA', 'Philips', 'The Ordinary', 'Nivea', 'Maybelline', 'Penguin', 'LEGO',
            'Faber-Castell', 'Google', 'Microsoft', 'Nintendo', 'Acer', 'New Balance',
            'SteelSeries', 'Secretlab', 'Marshall', 'Harman Kardon', 'Vans',
            'Daniel Wellington', 'Michael Kors', 'Dior',
        ];

        $brandModels = [];
        foreach ($brands as $brand) {
            $brandModels[$brand] = Brand::firstOrCreate(
                ['slug' => Str::slug($brand)],
                ['name' => $brand, 'status' => 'active', 'description' => $brand . ' official products at ShopZone.']
            );
        }

        // [name, price, sale_price, stock, brand, unsplash photo id, featured]
        $catalog = [
            'mobile-phones' => [
                ['Samsung Galaxy S24 Ultra', 285000, 265000, 15, 'Samsung', 'photo-1610945265064-0e34e5519bbf', true],
                ['Apple iPhone 15 Pro Max', 350000, 330000, 10, 'Apple', 'photo-1695048133142-1a20484d2569', true],
                ['OnePlus 12', 165000, 149000, 18, 'OnePlus', 'photo-1511707171634-5f897ff02aa9', false],
                ['Google Pixel 8 Pro', 240000, null, 9, 'Google', 'photo-1580910051074-3eb694886505', true],
                ['Xiaomi 14', 175000, 159000, 22, 'Xiaomi', 'photo-1592750475338-74b7b21085ab', false],
                ['Samsung Galaxy A55', 95000, 84900, 40, 'Samsung', 'photo-1510557880182-3d4d3cba35a5', false],
                ['Infinix Note 40', 42999, 38999, 55, 'Infinix', 'photo-1556656793-08538906a9f8', false],
                ['Tecno Camon 30', 34999, null, 60, 'Tecno', 'photo-1567581935884-3349723552ca', false],
                ['Apple iPhone 13', 220000, 199000, 12, 'Apple', 'photo-1585060544812-6b45742d762f', false],
            ],
            'electronics' => [
                ['Samsung 55" 4K Smart TV', 120000, 99000, 8, 'Samsung', 'photo-1593784991095-a205069470b6', true],
                ['LG 65" OLED evo TV', 385000, 359000, 4, 'LG', 'photo-1461151304267-38535e780c79', true],
                ['Samsung Galaxy Tab S9', 95000, null, 12, 'Samsung', 'photo-1561154464-82e9adf32764', false],
                ['Dell 27" 4K Monitor', 78000, 71000, 14, 'Dell', 'photo-1527443195645-1133f7f28990', false],
                ['ASUS TUF 24" Gaming Monitor', 42000, 36999, 20, 'Asus', 'photo-1547082299-de196ea013d6', false],
                ['Logitech MX Keys Keyboard', 14500, 12499, 35, 'Logitech', 'photo-1587829741301-dc798b83add3', false],
                ['Xiaomi Mi Smart Projector', 65000, 58999, 6, 'Xiaomi', 'photo-1618424181497-157f25b6ddd5', false],
                ['Anker 20000mAh Power Bank', 8900, null, 0, 'Anker', 'photo-1586899028174-e7098604235b', false],
                ['TP-Link Archer AX3000 Router', 12999, 10999, 28, 'TP-Link', 'photo-1509281373149-e957c6296406', false],
            ],
            'laptops-computers' => [
                ['Apple MacBook Air M2', 290000, 275000, 5, 'Apple', 'photo-1517336714731-489689fd1ca8', true],
                ['Dell XPS 13 Plus', 385000, null, 4, 'Dell', 'photo-1593640408182-31c70c8268f5', true],
                ['HP Pavilion 15', 165000, 152000, 11, 'HP', 'photo-1496181133206-80ce9b88a853', false],
                ['Lenovo IdeaPad Slim 5', 245000, null, 7, 'Lenovo', 'photo-1593642632823-8f785ba67e45', false],
                ['Apple MacBook Pro 14"', 545000, 519000, 3, 'Apple', 'photo-1611186871348-b1ce696e52c9', true],
                ['Asus VivoBook 15', 189000, 172000, 9, 'Asus', 'photo-1527443224154-c4a3942d3acf', false],
                ['Dell Inspiron 15', 155000, null, 13, 'Dell', 'photo-1484788984921-03950022c9ef', false],
                ['HP Victus 16 Gaming Laptop', 279000, 259000, 6, 'HP', 'photo-1541807084-5c52b6b3adef', false],
                ['Acer Aspire 5', 135000, 124000, 10, 'Acer', 'photo-1525547719571-a2d4ac8945e2', false],
            ],
            'gaming' => [
                ['PlayStation 5 Slim', 155000, 149000, 7, 'Sony', 'photo-1606144042614-b2417e99c4e3', true],
                ['Xbox Series X', 139000, null, 5, 'Microsoft', 'photo-1587202372775-e229f172b9d7', true],
                ['DualSense Wireless Controller', 24999, 21999, 30, 'Sony', 'photo-1608043152269-423dbba4e7e1', false],
                ['Logitech G502 HERO Mouse', 9500, 7999, 45, 'Logitech', 'photo-1612287230202-1ff1d85d1bdf', false],
                ['Razer BlackWidow V4', 18500, 15999, 18, 'Razer', 'photo-1547394765-185e1e68f34e', false],
                ['SteelSeries Arctis Nova 7', 27900, 24999, 12, 'SteelSeries', 'photo-1598550476439-6847785fcea6', false],
                ['Gaming Chair Pro', 49999, 44999, 9, 'Secretlab', 'photo-1542751371-adc38448a05e', false],
                ['Nintendo Switch OLED', 89999, 84999, 8, 'Nintendo', 'photo-1511512578047-dfb367046420', false],
                ['RGB Gaming Desk Setup', 65000, null, 4, 'IKEA', 'photo-1493711662062-fa541adb3fc8', false],
            ],
            'audio' => [
                ['Sony WH-1000XM5 Headphones', 89999, 79999, 14, 'Sony', 'photo-1505740420928-5e560c06d30e', true],
                ['Apple AirPods Pro 2', 54999, 49999, 25, 'Apple', 'photo-1590658268037-6bf12165a8df', true],
                ['Beats Studio Pro', 34999, null, 16, 'Apple', 'photo-1583394838336-acd977736f90', false],
                ['JBL Tune 720BT', 12999, 9999, 40, 'JBL', 'photo-1484704849700-f032a568e944', false],
                ['Bose QuietComfort Ultra', 74999, 68999, 8, 'Bose', 'photo-1546435770-a3e426bf472b', false],
                ['Samsung Galaxy Buds 2 Pro', 24999, 20999, 32, 'Samsung', 'photo-1572536147248-ac59a8abfa4b', false],
                ['JBL Flip 6 Speaker', 18999, 16499, 22, 'JBL', 'photo-1608231387042-66d1773070a5', false],
                ['Marshall Emberton II', 32999, null, 10, 'Marshall', 'photo-1545454675-3531b543be5d', false],
                ['Harman Kardon Aura Speaker', 39999, 34999, 0, 'Harman Kardon', 'photo-1487215078519-e21cc028cb29', false],
            ],
            'cameras' => [
                ['Canon EOS R50 Mirrorless', 235000, 219000, 6, 'Canon', 'photo-1502920917128-1aa500764cbd', true],
                ['Nikon Z fc Kit', 285000, 269000, 4, 'Nikon', 'photo-1500634245200-e5245c7574ef', true],
                ['Sony Alpha A7 III', 425000, null, 3, 'Sony', 'photo-1516035069371-29a1b244cc32', false],
                ['Fujifilm X-T5 Body', 315000, 299000, 5, 'Fujifilm', 'photo-1510127034890-ba27508e9f1c', false],
                ['Canon EF 50mm f/1.8 Lens', 28500, 24999, 15, 'Canon', 'photo-1526170375885-4d8ecf77b99f', false],
                ['GoPro HERO12 Black', 89999, 82999, 12, 'GoPro', 'photo-1516724562728-afc824a36e84', false],
                ['DJI Osmo Action 4', 74999, null, 9, 'DJI', 'photo-1502982720700-bfff97f2ecac', false],
                ['Fujifilm Instax Mini 12', 21999, 19499, 20, 'Fujifilm', 'photo-1554048612-b6a482bc67e5', false],
                ['DJI Mini 4 Pro Drone', 135000, 125000, 4, 'DJI', 'photo-1520549233664-03f65c1d1327', false],
            ],
            'fashion' => [
                ['Oversized Cotton T-Shirt', 2499, 1999, 80, 'Levi\'s', 'photo-1521572163474-6864f9cf17ab', true],
                ['Slim Fit Stretch Jeans', 4999, 3999, 50, 'Levi\'s', 'photo-1542272604-787c3835535d', true],
                ['Faux Leather Biker Jacket', 8999, 7499, 25, 'Levi\'s', 'photo-1551028719-00167b16eac5', false],
                ['Lightweight Bomber Jacket', 6999, null, 30, 'Adidas', 'photo-1591047139829-d91aecb6caea', false],
                ['Basic Crew Neck Tee', 1799, 1499, 120, 'Adidas', 'photo-1523381210434-271e8be1f52b', false],
                ['Fleece Pullover Hoodie', 3499, 2999, 65, 'Nike', 'photo-1554568218-0f1715e72254', false],
                ['Graphic Print Tee', 1999, null, 90, 'Nike', 'photo-1620799140408-edc6dcb6d633', false],
                ['Denim Casual Shirt', 3299, 2799, 45, 'Levi\'s', 'photo-1576871337622-98d48d1cf531', false],
                ['Slim Chino Trousers', 3999, 3499, 40, 'Levi\'s', 'photo-1594633312681-425c7b97ccd1', false],
            ],
            'footwear' => [
                ['Nike Air Max 270', 18000, 15000, 30, 'Nike', 'photo-1542291026-7eec264c27ff', true],
                ['Adidas Ultraboost 22', 24500, 21999, 22, 'Adidas', 'photo-1491553895911-0055eca6402d', true],
                ['Puma RS-X Sneakers', 15999, 13999, 28, 'Puma', 'photo-1549298916-b41d501d3772', false],
                ['Nike Air Force 1', 21500, null, 18, 'Nike', 'photo-1600185365483-26d7a4cc7519', false],
                ['Adidas Stan Smith', 14999, 12999, 35, 'Adidas', 'photo-1584370848010-d7fe6bc767ec', false],
                ['New Balance 574', 18999, 16999, 20, 'New Balance', 'photo-1595950653106-6c9ebd614d3a', false],
                ['Reebok Club C 85', 13999, null, 26, 'Reebok', 'photo-1560769629-975ec94e6a86', false],
                ['Air Jordan 1 Mid', 26500, 23999, 14, 'Nike', 'photo-1552346154-21d32810aba3', false],
                ['Vans Old Skool', 11999, 9999, 40, 'Vans', 'photo-1514989940723-e8e51635b782', false],
            ],
            'watches' => [
                ['Casio G-Shock GA-2100', 15999, 13999, 25, 'Casio', 'photo-1523275335684-37898b6baf30', true],
                ['Fossil Gen 6 Smartwatch', 42999, 38999, 12, 'Fossil', 'photo-1524592094714-0f0654e20314', true],
                ['Apple Watch SE 2', 54999, 51999, 16, 'Apple', 'photo-1546868871-7041f2a55e12', false],
                ['Seiko 5 Sports SRPD', 78500, null, 6, 'Seiko', 'photo-1522312346375-d1a52e2b99b3', false],
                ['Tissot PRX Quartz', 92000, 88000, 4, 'Tissot', 'photo-1585792180666-f7347c490ee2', false],
                ['Samsung Galaxy Watch 6', 44999, 39999, 14, 'Samsung', 'photo-1508685096489-7aacd43bd3b1', false],
                ['Garmin Forerunner 255', 63500, null, 7, 'Garmin', 'photo-1519558260268-cde7e03a0152', false],
                ['Daniel Wellington Classic', 18999, 16499, 20, 'Daniel Wellington', 'photo-1524805444758-089113d48a6d', false],
                ['Michael Kors Chronograph', 21500, 18999, 10, 'Michael Kors', 'photo-1533139502658-0198f920d8e8', false],
            ],
            'home-living' => [
                ['Fabric 3-Seater Sofa', 84999, 74999, 5, 'IKEA', 'photo-1555041469-a586c61ea9bc', true],
                ['Mid-Century Armchair', 32999, 28999, 10, 'IKEA', 'photo-1503602642458-232111445657', true],
                ['Oak Coffee Table', 18999, null, 14, 'IKEA', 'photo-1538688525198-9b88f6f53126', false],
                ['Minimalist Table Lamp', 4999, 3999, 35, 'Philips', 'photo-1507473885765-e6ed057f782c', false],
                ['Queen Bed Frame', 65999, 59999, 6, 'IKEA', 'photo-1505693416388-ac5ce068fe85', false],
                ['Cotton Bedding Set', 8999, 7499, 48, 'IKEA', 'photo-1505691938895-1758d7feb511', false],
                ['Canvas Wall Art Set', 3499, null, 60, 'IKEA', 'photo-1519710164239-da123dc03ef4', false],
                ['Ceramic Vase Duo', 2499, 1999, 75, 'IKEA', 'photo-1598300042247-d088f8ab3a91', false],
                ['Non-Stick Cookware Set', 15999, 13499, 18, 'Philips', 'photo-1556911220-bff31c812dba', false],
            ],
            'sports' => [
                ['Anti-Slip Yoga Mat', 3499, 2799, 55, 'Reebok', 'photo-1544367567-0f2fcb009e0b', true],
                ['Adjustable Dumbbell Set', 12999, 10999, 18, 'Adidas', 'photo-1517836357463-d25dfeac3438', true],
                ['Treadmill X7', 189999, 174999, 3, 'Reebok', 'photo-1534438327276-14e5300c3a48', false],
                ['Match Football', 2999, null, 70, 'Adidas', 'photo-1579952363873-27f3bade9f55', false],
                ['Indoor Basketball', 3499, 2999, 45, 'Nike', 'photo-1546519638-68e109498ffc', false],
                ['Road Cycling Helmet', 8999, 7499, 22, 'Puma', 'photo-1517649763962-0c623066013b', false],
                ['Resistance Band Set', 6999, null, 38, 'Adidas', 'photo-1599058917212-d750089bc07e', false],
                ['Training Gloves', 1999, 1499, 90, 'Nike', 'photo-1571019613454-1cb2f99b2d8b', false],
                ['Foam Roller', 2499, 1999, 50, 'Reebok', 'photo-1518611012118-696072aa579a', false],
            ],
            'health-beauty' => [
                ['Hydrating Face Serum', 4299, 3499, 60, 'The Ordinary', 'photo-1556228720-195a672e8a03', true],
                ['Signature Eau de Parfum', 12999, 10999, 25, 'Dior', 'photo-1541643600914-78b084683601', true],
                ['Complete Skincare Set', 6499, null, 40, 'The Ordinary', 'photo-1526947425960-945c6e72858f', false],
                ['Everyday Makeup Kit', 8999, 7499, 30, 'Maybelline', 'photo-1596462502278-27bfdc403348', false],
                ['Matte Lipstick Trio', 3499, 2999, 55, 'Maybelline', 'photo-1512496015851-a90fb38ba796', false],
                ['Gentle Foaming Face Wash', 1899, 1499, 80, 'Nivea', 'photo-1556228578-8c89e6adf883', false],
                ['Nourishing Body Lotion', 2499, null, 70, 'Nivea', 'photo-1608248543803-ba4f8c70ae0b', false],
                ['SPF 50 Sunscreen', 2799, 2299, 65, 'The Ordinary', 'photo-1598440947619-2c35fc9aa908', false],
                ['Argan Hair Care Set', 5499, 4499, 35, 'Nivea', 'photo-1522335789203-aabd1fc54bc9', false],
            ],
            'books' => [
                ['Atomic Habits', 1850, 1599, 100, 'Penguin', 'photo-1544947950-fa07a98d237f', true],
                ['The Psychology of Money', 1650, null, 90, 'Penguin', 'photo-1512820790803-83ca734da794', true],
                ['Rich Dad Poor Dad', 950, 799, 120, 'Penguin', 'photo-1495446815901-a7297e633e8d', false],
                ['The Alchemist', 1200, null, 110, 'Penguin', 'photo-1544716278-ca5e3f4abd8c', false],
                ['Ikigai', 1450, 1299, 95, 'Penguin', 'photo-1519682337058-a94d519337bc', false],
                ['Deep Work', 1750, 1549, 80, 'Penguin', 'photo-1497633762265-9d179a990aa6', false],
                ['Sapiens', 2300, null, 70, 'Penguin', 'photo-1495640388908-05fa85288e61', false],
                ['The Lean Startup', 2100, 1899, 60, 'Penguin', 'photo-1532012197267-da84d127e765', false],
                ['Think and Grow Rich', 1400, 1199, 85, 'Penguin', 'photo-1507842217343-583bb7270b66', false],
            ],
            'toys-kids' => [
                ['LEGO Classic Bricks Box', 7999, 6999, 25, 'LEGO', 'photo-1596461404969-9ae70f2830c1', true],
                ['Remote Control Car', 4999, 4299, 30, 'LEGO', 'photo-1587654780291-39c9404d746b', true],
                ['Wooden Puzzle Set', 2499, null, 45, 'Faber-Castell', 'photo-1516627145497-ae6968895b74', false],
                ['Plush Teddy Bear', 1899, 1599, 60, 'LEGO', 'photo-1612459284970-e8f027596582', false],
                ['Building Blocks 500 pcs', 3499, 2999, 38, 'LEGO', 'photo-1558060370-d644479cb6f7', false],
                ['Kids Art & Craft Kit', 2299, null, 50, 'Faber-Castell', 'photo-1503454537195-1dcabb73ffb9', false],
                ['Toy Kitchen Set', 5999, 5199, 20, 'LEGO', 'photo-1522771930-78848d9293e8', false],
                ['Baby Rattle Set', 1499, 1199, 65, 'Faber-Castell', 'photo-1515488042361-ee00e0ddd4e4', false],
                ['Ride-On Car', 12999, 11499, 10, 'LEGO', 'photo-1502086223501-7ea6ecd79368', false],
            ],
        ];

        $blurbs = [
            'mobile-phones' => 'Fast performance, a great camera and all-day battery make it a dependable daily phone.',
            'electronics' => 'Crisp visuals and reliable build quality for home and work.',
            'laptops-computers' => 'Built for productivity, multitasking and everyday entertainment.',
            'gaming' => 'Responsive controls and premium build for long sessions.',
            'audio' => 'Detailed sound, comfortable fit and dependable battery life.',
            'cameras' => 'Sharp optics and reliable autofocus for photo and video.',
            'fashion' => 'Comfortable fabric and an easy-to-style everyday fit.',
            'footwear' => 'Cushioned comfort with a durable outsole for daily wear.',
            'watches' => 'Precise movement and a classic finish that suits any outfit.',
            'home-living' => 'Thoughtful design and solid materials for everyday living.',
            'sports' => 'Durable equipment built to handle regular training.',
            'health-beauty' => 'Dermatologist-friendly formula suitable for daily use.',
            'books' => 'A widely recommended read, printed on quality paper.',
            'toys-kids' => 'Safe materials and hours of creative play for children.',
        ];

        foreach ($catalog as $slug => $items) {
            $category = Category::where('slug', $slug)->first();

            if (!$category) {
                continue;
            }

            foreach ($items as $index => [$name, $price, $sale, $stock, $brandName, $photo, $featured]) {
                $brand = $brandModels[$brandName] ?? null;

                Product::updateOrCreate(
                    ['slug' => Str::slug($name)],
                    [
                        'name' => $name,
                        'sku' => 'SZ-' . strtoupper(substr(md5($name), 0, 8)),
                        'short_description' => 'Genuine ' . ($brand->name ?? 'ShopZone') . ' product with official warranty and fast nationwide delivery.',
                        'description' => $name . ' — ' . $blurbs[$slug] . ' Backed by the ShopZone 7-day return policy.',
                        'category_id' => $category->id,
                        'brand_id' => $brand?->id,
                        'price' => $price,
                        'sale_price' => $sale,
                        'stock_quantity' => $stock,
                        'main_image' => 'https://images.unsplash.com/' . $photo . '?auto=format&fit=crop&w=900&q=80',
                        'status' => 'active',
                        'is_featured' => $featured,
                    ]
                );
            }
        }

        $this->command->info('Catalog seeded: ' . Product::count() . ' products in ' . Category::count() . ' categories.');
    }
}
