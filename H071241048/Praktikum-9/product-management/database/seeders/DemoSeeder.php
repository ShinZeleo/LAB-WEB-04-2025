<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Warehouse;
use App\Models\Product;
use App\Models\ProductDetail;
use App\Models\ProductWarehouse;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create categories
        $electronics = Category::create([
            'name' => 'Electronics',
            'description' => 'Electronic devices and accessories'
        ]);
        
        $furniture = Category::create([
            'name' => 'Furniture',
            'description' => 'Home and office furniture items'
        ]);
        
        $clothing = Category::create([
            'name' => 'Clothing',
            'description' => 'Apparel and fashion items'
        ]);
        
        // Create warehouses
        $makassarWarehouse = Warehouse::create([
            'name' => 'Gudang Makassar',
            'location' => 'Jl. Perdagangan No. 123, Makassar'
        ]);
        
        $gowaWarehouse = Warehouse::create([
            'name' => 'Gudang Gowa',
            'location' => 'Jl. Raya Gowa No. 456, Gowa'
        ]);
        
        $marosWarehouse = Warehouse::create([
            'name' => 'Gudang Maros',
            'location' => 'Jl. Poros Maros No. 789, Maros'
        ]);
        
        // Create products
        $laptop = Product::create([
            'name' => 'Laptop Gaming',
            'price' => 15000000,
            'category_id' => $electronics->id
        ]);
        
        ProductDetail::create([
            'product_id' => $laptop->id,
            'description' => 'High performance gaming laptop with RTX graphics',
            'weight' => 2.50,
            'size' => '15.6 inch'
        ]);
        
        $chair = Product::create([
            'name' => 'Kursi Kantor Ergonomis',
            'price' => 1200000,
            'category_id' => $furniture->id
        ]);
        
        ProductDetail::create([
            'product_id' => $chair->id,
            'description' => 'Comfortable ergonomic office chair with adjustable height',
            'weight' => 15.00,
            'size' => 'Standard'
        ]);
        
        $phone = Product::create([
            'name' => 'Smartphone Premium',
            'price' => 8000000,
            'category_id' => $electronics->id
        ]);
        
        ProductDetail::create([
            'product_id' => $phone->id,
            'description' => 'Latest smartphone with advanced camera features',
            'weight' => 0.20,
            'size' => '6.1 inch'
        ]);
        
        $tv = Product::create([
            'name' => 'Smart TV 55 inch',
            'price' => 7500000,
            'category_id' => $electronics->id
        ]);
        
        ProductDetail::create([
            'product_id' => $tv->id,
            'description' => '4K Ultra HD Smart TV with HDR support',
            'weight' => 18.50,
            'size' => '55 inch'
        ]);
        
        $sofa = Product::create([
            'name' => 'Sofa 3 Seater',
            'price' => 3500000,
            'category_id' => $furniture->id
        ]);
        
        ProductDetail::create([
            'product_id' => $sofa->id,
            'description' => 'Comfortable 3 seater sofa with leather finish',
            'weight' => 45.00,
            'size' => '3 Seater'
        ]);
        
        $tshirt = Product::create([
            'name' => 'Kaos Polos Premium',
            'price' => 85000,
            'category_id' => $clothing->id
        ]);
        
        ProductDetail::create([
            'product_id' => $tshirt->id,
            'description' => 'Premium cotton t-shirt in various colors',
            'weight' => 0.25,
            'size' => 'M, L, XL'
        ]);
        
        $watch = Product::create([
            'name' => 'Smartwatch Terbaru',
            'price' => 2500000,
            'category_id' => $electronics->id
        ]);
        
        ProductDetail::create([
            'product_id' => $watch->id,
            'description' => 'Latest smartwatch with health monitoring',
            'weight' => 0.05,
            'size' => '44mm'
        ]);
        
        // Create pivot records for initial stock with more comprehensive data
        ProductWarehouse::create([
            'product_id' => $laptop->id,
            'warehouse_id' => $makassarWarehouse->id,
            'quantity' => 12
        ]);
        
        ProductWarehouse::create([
            'product_id' => $laptop->id,
            'warehouse_id' => $gowaWarehouse->id,
            'quantity' => 8
        ]);
        
        ProductWarehouse::create([
            'product_id' => $laptop->id,
            'warehouse_id' => $marosWarehouse->id,
            'quantity' => 5
        ]);
        
        ProductWarehouse::create([
            'product_id' => $chair->id,
            'warehouse_id' => $makassarWarehouse->id,
            'quantity' => 25
        ]);
        
        ProductWarehouse::create([
            'product_id' => $chair->id,
            'warehouse_id' => $gowaWarehouse->id,
            'quantity' => 15
        ]);
        
        ProductWarehouse::create([
            'product_id' => $phone->id,
            'warehouse_id' => $gowaWarehouse->id,
            'quantity' => 30
        ]);
        
        ProductWarehouse::create([
            'product_id' => $phone->id,
            'warehouse_id' => $makassarWarehouse->id,
            'quantity' => 20
        ]);
        
        ProductWarehouse::create([
            'product_id' => $phone->id,
            'warehouse_id' => $marosWarehouse->id,
            'quantity' => 10
        ]);
        
        ProductWarehouse::create([
            'product_id' => $tv->id,
            'warehouse_id' => $makassarWarehouse->id,
            'quantity' => 7
        ]);
        
        ProductWarehouse::create([
            'product_id' => $tv->id,
            'warehouse_id' => $gowaWarehouse->id,
            'quantity' => 5
        ]);
        
        ProductWarehouse::create([
            'product_id' => $sofa->id,
            'warehouse_id' => $makassarWarehouse->id,
            'quantity' => 8
        ]);
        
        ProductWarehouse::create([
            'product_id' => $sofa->id,
            'warehouse_id' => $marosWarehouse->id,
            'quantity' => 6
        ]);
        
        ProductWarehouse::create([
            'product_id' => $tshirt->id,
            'warehouse_id' => $makassarWarehouse->id,
            'quantity' => 50
        ]);
        
        ProductWarehouse::create([
            'product_id' => $tshirt->id,
            'warehouse_id' => $gowaWarehouse->id,
            'quantity' => 40
        ]);
        
        ProductWarehouse::create([
            'product_id' => $tshirt->id,
            'warehouse_id' => $marosWarehouse->id,
            'quantity' => 35
        ]);
        
        ProductWarehouse::create([
            'product_id' => $watch->id,
            'warehouse_id' => $makassarWarehouse->id,
            'quantity' => 15
        ]);
        
        ProductWarehouse::create([
            'product_id' => $watch->id,
            'warehouse_id' => $gowaWarehouse->id,
            'quantity' => 12
        ]);
    }
}
