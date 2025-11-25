<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FishSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fishes = [
            // Common Fishes
            [
                'name' => 'Goldfish',
                'rarity' => 'Common',
                'base_weight_min' => 0.10,
                'base_weight_max' => 0.50,
                'sell_price_per_kg' => 100,
                'catch_probability' => 50.00,
                'description' => 'A common freshwater fish often kept in aquariums. Easy to catch for beginners.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Bluegill',
                'rarity' => 'Common',
                'base_weight_min' => 0.20,
                'base_weight_max' => 1.00,
                'sell_price_per_kg' => 150,
                'catch_probability' => 45.00,
                'description' => 'A popular panfish found in many North American waters. Great for frying.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Sunfish',
                'rarity' => 'Common',
                'base_weight_min' => 0.15,
                'base_weight_max' => 0.75,
                'sell_price_per_kg' => 120,
                'catch_probability' => 48.00,
                'description' => 'Brightly colored freshwater fish. Known for their distinctive shape and diet.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Minnow',
                'rarity' => 'Common',
                'base_weight_min' => 0.05,
                'base_weight_max' => 0.25,
                'sell_price_per_kg' => 80,
                'catch_probability' => 60.00,
                'description' => 'Small bait fish commonly used by anglers. Extremely abundant in most waters.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            
            // Uncommon Fishes
            [
                'name' => 'Bass',
                'rarity' => 'Uncommon',
                'base_weight_min' => 0.50,
                'base_weight_max' => 2.00,
                'sell_price_per_kg' => 250,
                'catch_probability' => 30.00,
                'description' => 'A popular game fish known for its fighting spirit. Prized by sport fishermen.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Catfish',
                'rarity' => 'Uncommon',
                'base_weight_min' => 1.00,
                'base_weight_max' => 5.00,
                'sell_price_per_kg' => 300,
                'catch_probability' => 25.00,
                'description' => 'Bottom-feeding fish with distinctive whiskers. Excellent tasting flesh.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Pike',
                'rarity' => 'Uncommon',
                'base_weight_min' => 2.00,
                'base_weight_max' => 8.00,
                'sell_price_per_kg' => 350,
                'catch_probability' => 20.00,
                'description' => 'Predatory freshwater fish with a long, slender body. Known for sharp teeth.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Perch',
                'rarity' => 'Uncommon',
                'base_weight_min' => 0.30,
                'base_weight_max' => 1.50,
                'sell_price_per_kg' => 280,
                'catch_probability' => 28.00,
                'description' => 'Distinctive stripes and spiny dorsal fin. Popular table fare in northern regions.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            
            // Rare Fishes
            [
                'name' => 'Rainbow Trout',
                'rarity' => 'Rare',
                'base_weight_min' => 1.00,
                'base_weight_max' => 5.00,
                'sell_price_per_kg' => 500,
                'catch_probability' => 15.00,
                'description' => 'A colorful freshwater fish prized for its taste. Requires skill to catch.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Walleye',
                'rarity' => 'Rare',
                'base_weight_min' => 2.00,
                'base_weight_max' => 10.00,
                'sell_price_per_kg' => 600,
                'catch_probability' => 12.00,
                'description' => 'Highly prized for its delicate flavor. Named for its reflective eye layer.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Sturgeon',
                'rarity' => 'Rare',
                'base_weight_min' => 10.00,
                'base_weight_max' => 50.00,
                'sell_price_per_kg' => 800,
                'catch_probability' => 8.00,
                'description' => 'Ancient fish species that can live over 100 years. Famous for caviar production.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Salmon',
                'rarity' => 'Rare',
                'base_weight_min' => 3.00,
                'base_weight_max' => 15.00,
                'sell_price_per_kg' => 700,
                'catch_probability' => 10.00,
                'description' => 'Anadromous fish that swims upstream to spawn. Rich in omega-3 fatty acids.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            
            // Epic Fishes
            [
                'name' => 'Blue Marlin',
                'rarity' => 'Epic',
                'base_weight_min' => 50.00,
                'base_weight_max' => 200.00,
                'sell_price_per_kg' => 1000,
                'catch_probability' => 5.00,
                'description' => 'A large, majestic ocean fish known for its strength. Trophy fish for experienced anglers.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Swordfish',
                'rarity' => 'Epic',
                'base_weight_min' => 40.00,
                'base_weight_max' => 150.00,
                'sell_price_per_kg' => 1200,
                'catch_probability' => 4.00,
                'description' => 'Ocean predator with a long, flat bill. Highly migratory in tropical waters.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Tuna',
                'rarity' => 'Epic',
                'base_weight_min' => 30.00,
                'base_weight_max' => 100.00,
                'sell_price_per_kg' => 1100,
                'catch_probability' => 6.00,
                'description' => 'Fast-swimming saltwater fish. Commercially valuable for sushi markets.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Shark',
                'rarity' => 'Epic',
                'base_weight_min' => 50.00,
                'base_weight_max' => 300.00,
                'sell_price_per_kg' => 1500,
                'catch_probability' => 3.00,
                'description' => 'Apex predator of the oceans. Multiple species with diverse behaviors.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            
            // Legendary Fishes
            [
                'name' => 'Coelacanth',
                'rarity' => 'Legendary',
                'base_weight_min' => 50.00,
                'base_weight_max' => 100.00,
                'sell_price_per_kg' => 5000,
                'catch_probability' => 1.00,
                'description' => 'A prehistoric fish thought to be extinct until rediscovered. Living fossil specimen.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'White Sturgeon',
                'rarity' => 'Legendary',
                'base_weight_min' => 50.00,
                'base_weight_max' => 200.00,
                'sell_price_per_kg' => 4500,
                'catch_probability' => 1.20,
                'description' => 'Largest freshwater fish in North America. Can live over 100 years and weigh over 400 lbs.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Giant Squid',
                'rarity' => 'Legendary',
                'base_weight_min' => 100.00,
                'base_weight_max' => 500.00,
                'sell_price_per_kg' => 6000,
                'catch_probability' => 0.80,
                'description' => 'Deep ocean cephalopod of immense size. Rarely seen by humans in its natural habitat.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Alligator Gar',
                'rarity' => 'Legendary',
                'base_weight_min' => 40.00,
                'base_weight_max' => 150.00,
                'sell_price_per_kg' => 4000,
                'catch_probability' => 1.50,
                'description' => 'Ancient fish with armored scales and alligator-like snout. Top predator of freshwater systems.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            
            // Mythic Fishes
            [
                'name' => 'Dragon Fish',
                'rarity' => 'Mythic',
                'base_weight_min' => 10.00,
                'base_weight_max' => 50.00,
                'sell_price_per_kg' => 10000,
                'catch_probability' => 0.10,
                'description' => 'A mythical fish said to possess magical properties. Legends speak of its ability to breathe fire.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Kraken',
                'rarity' => 'Mythic',
                'base_weight_min' => 1000.00,
                'base_weight_max' => 5000.00,
                'sell_price_per_kg' => 25000,
                'catch_probability' => 0.05,
                'description' => 'Massive legendary sea creature resembling a giant octopus. Said to dwell in the deepest abyss.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Leviathan',
                'rarity' => 'Mythic',
                'base_weight_min' => 500.00,
                'base_weight_max' => 2000.00,
                'sell_price_per_kg' => 20000,
                'catch_probability' => 0.08,
                'description' => 'Colossal sea monster from ancient mythology. Stories claim it can swallow ships whole.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Phoenix Fish',
                'rarity' => 'Mythic',
                'base_weight_min' => 5.00,
                'base_weight_max' => 25.00,
                'sell_price_per_kg' => 15000,
                'catch_probability' => 0.15,
                'description' => 'Fish that glows with ethereal flames. Legend says it resurrects itself when near death.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            
            // Secret Fishes
            [
                'name' => 'Golden Sea Bass',
                'rarity' => 'Secret',
                'base_weight_min' => 5.00,
                'base_weight_max' => 25.00,
                'sell_price_per_kg' => 25000,
                'catch_probability' => 0.01,
                'description' => 'An extremely rare variant of sea bass with golden scales. Found only in hidden underwater caves.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Void Walker',
                'rarity' => 'Secret',
                'base_weight_min' => 100.00,
                'base_weight_max' => 1000.00,
                'sell_price_per_kg' => 50000,
                'catch_probability' => 0.005,
                'description' => 'Otherworldly fish that exists between dimensions. Rumored to appear only during lunar eclipses.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Cosmic Carp',
                'rarity' => 'Secret',
                'base_weight_min' => 20.00,
                'base_weight_max' => 100.00,
                'sell_price_per_kg' => 35000,
                'catch_probability' => 0.02,
                'description' => 'Glows with stardust and swims through space itself. Extremely difficult to catch in earthly waters.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Atlantean Guardian',
                'rarity' => 'Secret',
                'base_weight_min' => 500.00,
                'base_weight_max' => 2000.00,
                'sell_price_per_kg' => 100000,
                'catch_probability' => 0.001,
                'description' => 'Ancient protector of the lost city of Atlantis. Said to grant wishes to those who catch it.',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        foreach ($fishes as $fish) {
            DB::table('fishes')->insert($fish);
        }
    }
}