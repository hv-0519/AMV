<?php

namespace Database\Seeders;

use App\Models\MenuItem;
use App\Models\Stock;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // =============================================
        // CREATE ADMIN USER
        // =============================================
        User::firstOrCreate(
            ['email' => 'admin@AMV.com'],
            [
                'name' => 'AMV Admin',
                'phone' => '+91 9876543210',
                'password' => Hash::make('admin@123'),
                'role' => 'admin',
            ]
        );

        // =============================================
        // SEED MENU ITEMS
        // =============================================
        $menu_items = [
            // Misal
            ['name' => 'Amdavadi Misal Pav', 'category' => 'Misal', 'description' => 'Fiery sprouted moth bean curry topped with farsan, onion & coriander, served with soft pav', 'price' => 120, 'spice_level' => 4, 'is_bestseller' => true, 'is_featured' => true, 'ingredients' => 'Sprouted moth beans, Farsan, Pav, Onions, Coriander, Lime'],
            ['name' => 'Ulta Misal', 'category' => 'Misal', 'description' => 'Misal with pav dipped in the spicy gravy — a unique Ahamdabadi twist', 'price' => 130, 'spice_level' => 5, 'is_bestseller' => false, 'is_featured' => true, 'ingredients' => 'Sprouted beans, Spice gravy, Pav'],
            ['name' => 'Farali Misal', 'category' => 'Misal', 'description' => 'Festival-friendly misal with sabudana and potato, no onion-garlic', 'price' => 140, 'spice_level' => 2, 'is_bestseller' => false, 'is_featured' => false, 'ingredients' => 'Sabudana, Potato, Farsan'],
            ['name' => 'Jain Misal Pav', 'category' => 'Misal', 'description' => 'Jain-friendly misal with no underground vegetables', 'price' => 130, 'spice_level' => 3, 'is_bestseller' => false, 'is_featured' => false, 'ingredients' => 'Sprouted beans, Jain spices, Pav'],
            ['name' => 'AMV Spl Misal Thali', 'category' => 'Thali', 'description' => 'Complete thali with misal, poha, sabudana kheer, and chaas', 'price' => 220, 'spice_level' => 3, 'is_bestseller' => true, 'is_featured' => true, 'ingredients' => 'Misal, Poha, Kheer, Chaas, Pav'],

            // Vadapav
            ['name' => 'Amdavadi Vadapav', 'category' => 'Vadapav', 'description' => 'Classic Mumbai-style crispy potato fritter in soft pav with chutney', 'price' => 60, 'spice_level' => 3, 'is_bestseller' => true, 'is_featured' => true, 'ingredients' => 'Potato vada, Pav, Green chutney, Dry garlic chutney'],
            ['name' => 'Cheese Blast Vadapav', 'category' => 'Vadapav', 'description' => 'Vada pav loaded with molten cheese — the ultimate indulgence', 'price' => 90, 'spice_level' => 3, 'is_bestseller' => true, 'is_featured' => true, 'ingredients' => 'Potato vada, Cheese, Pav, Chutneys'],
            ['name' => 'Ulta Pav', 'category' => 'Vadapav', 'description' => 'Pav stuffed inside the vada — a fun twist on the classic', 'price' => 70, 'spice_level' => 3, 'is_bestseller' => false, 'is_featured' => false, 'ingredients' => 'Potato vada, Pav, Chutneys'],

            // Poha
            ['name' => 'Regular Poha', 'category' => 'Poha', 'description' => 'Classic flattened rice with mustard seeds, curry leaves & fresh coriander', 'price' => 80, 'spice_level' => 1, 'is_bestseller' => true, 'is_featured' => true, 'ingredients' => 'Poha, Mustard, Onion, Curry leaves, Peanuts'],
            ['name' => 'AMV Special Poha', 'category' => 'Poha', 'description' => 'Upgraded poha with extra toppings, sev, and our special masala', 'price' => 110, 'spice_level' => 2, 'is_bestseller' => false, 'is_featured' => false, 'ingredients' => 'Poha, Sev, Special masala, Coriander'],
            ['name' => 'Dadpe Poha', 'category' => 'Poha', 'description' => 'Raw crushed poha with fresh coconut and spices — no cooking needed!', 'price' => 90, 'spice_level' => 2, 'is_bestseller' => false, 'is_featured' => false, 'ingredients' => 'Poha, Coconut, Green chilli, Lime'],
            ['name' => 'Tari Poha', 'category' => 'Poha', 'description' => 'Poha served with spicy gravy (tari) on the side', 'price' => 100, 'spice_level' => 3, 'is_bestseller' => false, 'is_featured' => false, 'ingredients' => 'Poha, Spicy tari gravy'],

            // Beverages
            ['name' => 'Mango Lassi', 'category' => 'Beverages', 'description' => 'Thick, creamy lassi with Alphonso mango pulp — summer in a glass', 'price' => 90, 'spice_level' => 0, 'is_bestseller' => true, 'is_featured' => true, 'ingredients' => 'Yogurt, Mango pulp, Sugar, Cardamom'],
            ['name' => 'Makhaniyan Lassi', 'category' => 'Beverages', 'description' => 'Rich buttery lassi with a layer of malai on top', 'price' => 100, 'spice_level' => 0, 'is_bestseller' => false, 'is_featured' => false, 'ingredients' => 'Yogurt, Malai, Sugar, Rose water'],
            ['name' => 'Rajwadi Lassi', 'category' => 'Beverages', 'description' => 'Royal flavored lassi with saffron and dry fruits', 'price' => 120, 'spice_level' => 0, 'is_bestseller' => false, 'is_featured' => false, 'ingredients' => 'Yogurt, Saffron, Dry fruits, Cardamom'],
            ['name' => 'Masala Chaas', 'category' => 'Beverages', 'description' => 'Spiced buttermilk — the perfect digestive drink', 'price' => 50, 'spice_level' => 1, 'is_bestseller' => false, 'is_featured' => false, 'ingredients' => 'Buttermilk, Cumin, Black salt, Coriander'],

            // Snacks
            ['name' => 'Bhaji Pav', 'category' => 'Snacks', 'description' => 'Mixed vegetable bhaji cooked on iron griddle with buttered pav', 'price' => 110, 'spice_level' => 2, 'is_bestseller' => false, 'is_featured' => true, 'ingredients' => 'Mixed vegetables, Butter, Pav, Onion'],
            ['name' => 'Kathol Bhel', 'category' => 'Snacks', 'description' => 'Tangy bhel with cooked lentils/beans — a protein-packed snack', 'price' => 90, 'spice_level' => 2, 'is_bestseller' => false, 'is_featured' => false, 'ingredients' => 'Cooked kathol, Tamarind, Chutney, Sev'],
            ['name' => 'Amdavadi Sev Usal', 'category' => 'Snacks', 'description' => 'Spicy white peas curry topped with sev, onion & chutneys', 'price' => 100, 'spice_level' => 3, 'is_bestseller' => false, 'is_featured' => false, 'ingredients' => 'White peas, Sev, Onion, Lime, Chutneys'],
            ['name' => 'Tava Pulav', 'category' => 'Snacks', 'description' => 'Spiced rice cooked on a flat iron tava with veggies and Mumbai masala', 'price' => 140, 'spice_level' => 2, 'is_bestseller' => false, 'is_featured' => false, 'ingredients' => 'Rice, Mixed vegetables, Mumbai masala'],

            // Desserts
            ['name' => 'Sabudana Kheer', 'category' => 'Desserts', 'description' => 'Creamy tapioca pearl pudding sweetened with jaggery and cardamom', 'price' => 70, 'spice_level' => 0, 'is_bestseller' => false, 'is_featured' => false, 'ingredients' => 'Sabudana, Milk, Jaggery, Cardamom, Dry fruits'],
            ['name' => 'Misal Fondue', 'category' => 'Desserts', 'description' => 'Creative fusion — misal served fondue-style for a fun dining experience', 'price' => 180, 'spice_level' => 3, 'is_bestseller' => false, 'is_featured' => false, 'ingredients' => 'Misal gravy, Breads, Vegetables'],
        ];

        foreach ($menu_items as $item) {
            MenuItem::firstOrCreate(
                ['name' => $item['name']],
                array_merge($item, ['is_available' => true])
            );
        }

        // =============================================
        // SEED STOCK ITEMS
        // =============================================
        $stocks = [
            ['name' => 'Sprouted Moth Beans', 'category' => 'Raw Materials', 'quantity' => 25, 'min_quantity' => 5, 'unit' => 'kg', 'unit_cost' => 80],
            ['name' => 'Potato', 'category' => 'Raw Materials', 'quantity' => 50, 'min_quantity' => 10, 'unit' => 'kg', 'unit_cost' => 25],
            ['name' => 'Pav (Buns)', 'category' => 'Raw Materials', 'quantity' => 200, 'min_quantity' => 50, 'unit' => 'pcs', 'unit_cost' => 2.5],
            ['name' => 'Poha (Flattened Rice)', 'category' => 'Raw Materials', 'quantity' => 30, 'min_quantity' => 8, 'unit' => 'kg', 'unit_cost' => 60],
            ['name' => 'Sabudana', 'category' => 'Raw Materials', 'quantity' => 15, 'min_quantity' => 3, 'unit' => 'kg', 'unit_cost' => 90],
            ['name' => 'Coriander Seeds', 'category' => 'Spices', 'quantity' => 5, 'min_quantity' => 1, 'unit' => 'kg', 'unit_cost' => 120],
            ['name' => 'Red Chilli Powder', 'category' => 'Spices', 'quantity' => 4, 'min_quantity' => 1, 'unit' => 'kg', 'unit_cost' => 200],
            ['name' => 'Turmeric Powder', 'category' => 'Spices', 'quantity' => 3, 'min_quantity' => 0.5, 'unit' => 'kg', 'unit_cost' => 150],
            ['name' => 'Goda Masala', 'category' => 'Spices', 'quantity' => 2, 'min_quantity' => 0.5, 'unit' => 'kg', 'unit_cost' => 300],
            ['name' => 'Full Cream Milk', 'category' => 'Dairy', 'quantity' => 40, 'min_quantity' => 10, 'unit' => 'litre', 'unit_cost' => 60],
            ['name' => 'Fresh Yogurt', 'category' => 'Dairy', 'quantity' => 20, 'min_quantity' => 5, 'unit' => 'kg', 'unit_cost' => 55],
            ['name' => 'Butter', 'category' => 'Dairy', 'quantity' => 5, 'min_quantity' => 1, 'unit' => 'kg', 'unit_cost' => 450],
            ['name' => 'Mango Pulp', 'category' => 'Beverages', 'quantity' => 10, 'min_quantity' => 2, 'unit' => 'kg', 'unit_cost' => 120],
            ['name' => 'Sev (Fine)', 'category' => 'Raw Materials', 'quantity' => 12, 'min_quantity' => 3, 'unit' => 'kg', 'unit_cost' => 80],
            ['name' => 'Peanuts', 'category' => 'Raw Materials', 'quantity' => 8, 'min_quantity' => 2, 'unit' => 'kg', 'unit_cost' => 100],
            ['name' => 'Tamarind', 'category' => 'Raw Materials', 'quantity' => 3, 'min_quantity' => 0.5, 'unit' => 'kg', 'unit_cost' => 130],
            ['name' => 'Takeaway Boxes', 'category' => 'Packaging', 'quantity' => 500, 'min_quantity' => 100, 'unit' => 'pcs', 'unit_cost' => 2],
            ['name' => 'Paper Bags', 'category' => 'Packaging', 'quantity' => 300, 'min_quantity' => 50, 'unit' => 'pcs', 'unit_cost' => 1.5],
            ['name' => 'Tissue Paper', 'category' => 'Packaging', 'quantity' => 1000, 'min_quantity' => 200, 'unit' => 'pcs', 'unit_cost' => 0.5],
            ['name' => 'Cooking Oil', 'category' => 'Raw Materials', 'quantity' => 20, 'min_quantity' => 5, 'unit' => 'litre', 'unit_cost' => 110],
        ];

        foreach ($stocks as $stock) {
            Stock::firstOrCreate(['name' => $stock['name']], $stock);
        }

        $this->command->info('✅ AMV Database seeded successfully!');
        $this->command->info('👤 Admin Login: admin@AMV.com | Password: admin@123');
    }
}
