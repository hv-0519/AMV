<?php

namespace Database\Seeders;

use App\Models\MenuItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Stock;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
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

        $this->seedDashboardOrders();

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

    private function seedDashboardOrders(): void
    {
        $customers = [
            ['name' => 'Riya Patel', 'email' => 'riya.patel@example.com', 'phone' => '+91 9820011001'],
            ['name' => 'Harsh Shah', 'email' => 'harsh.shah@example.com', 'phone' => '+91 9820011002'],
            ['name' => 'Neha Mehta', 'email' => 'neha.mehta@example.com', 'phone' => '+91 9820011003'],
            ['name' => 'Aarav Desai', 'email' => 'aarav.desai@example.com', 'phone' => '+91 9820011004'],
            ['name' => 'Kavya Trivedi', 'email' => 'kavya.trivedi@example.com', 'phone' => '+91 9820011005'],
        ];

        foreach ($customers as $customer) {
            User::firstOrCreate(
                ['email' => $customer['email']],
                [
                    'name' => $customer['name'],
                    'phone' => $customer['phone'],
                    'password' => Hash::make('password'),
                    'role' => 'customer',
                ]
            );
        }

        $menuItems = MenuItem::query()
            ->whereIn('name', [
                'Amdavadi Misal Pav',
                'AMV Spl Misal Thali',
                'Amdavadi Vadapav',
                'Cheese Blast Vadapav',
                'Regular Poha',
                'AMV Special Poha',
                'Mango Lassi',
                'Masala Chaas',
                'Bhaji Pav',
                'Tava Pulav',
            ])
            ->get()
            ->keyBy('name');

        $orders = [
            ['day' => 6, 'status' => 'completed', 'type' => 'dine-in', 'customer' => 'riya.patel@example.com', 'items' => ['Amdavadi Misal Pav' => 4, 'Mango Lassi' => 3, 'Masala Chaas' => 2], 'payment' => 'upi'],
            ['day' => 6, 'status' => 'completed', 'type' => 'pickup', 'customer' => 'harsh.shah@example.com', 'items' => ['Amdavadi Vadapav' => 8, 'Cheese Blast Vadapav' => 4], 'payment' => 'card'],
            ['day' => 5, 'status' => 'completed', 'type' => 'delivery', 'customer' => 'neha.mehta@example.com', 'items' => ['AMV Spl Misal Thali' => 3, 'Mango Lassi' => 3], 'payment' => 'online'],
            ['day' => 5, 'status' => 'completed', 'type' => 'dine-in', 'customer' => 'aarav.desai@example.com', 'items' => ['Regular Poha' => 5, 'Masala Chaas' => 5, 'Amdavadi Vadapav' => 3], 'payment' => 'cash'],
            ['day' => 4, 'status' => 'completed', 'type' => 'pickup', 'customer' => 'kavya.trivedi@example.com', 'items' => ['Cheese Blast Vadapav' => 7, 'Amdavadi Misal Pav' => 5, 'Mango Lassi' => 4], 'payment' => 'upi'],
            ['day' => 4, 'status' => 'completed', 'type' => 'delivery', 'customer' => 'riya.patel@example.com', 'items' => ['Bhaji Pav' => 6, 'Tava Pulav' => 4, 'Masala Chaas' => 6], 'payment' => 'online'],
            ['day' => 3, 'status' => 'completed', 'type' => 'dine-in', 'customer' => 'harsh.shah@example.com', 'items' => ['Amdavadi Misal Pav' => 10, 'AMV Special Poha' => 5, 'Mango Lassi' => 6], 'payment' => 'card'],
            ['day' => 3, 'status' => 'completed', 'type' => 'pickup', 'customer' => 'neha.mehta@example.com', 'items' => ['Amdavadi Vadapav' => 12, 'Cheese Blast Vadapav' => 6], 'payment' => 'upi'],
            ['day' => 2, 'status' => 'completed', 'type' => 'delivery', 'customer' => 'aarav.desai@example.com', 'items' => ['AMV Spl Misal Thali' => 5, 'Mango Lassi' => 5, 'Masala Chaas' => 4], 'payment' => 'online'],
            ['day' => 2, 'status' => 'completed', 'type' => 'dine-in', 'customer' => 'kavya.trivedi@example.com', 'items' => ['Regular Poha' => 8, 'Amdavadi Vadapav' => 7, 'Bhaji Pav' => 3], 'payment' => 'cash'],
            ['day' => 1, 'status' => 'completed', 'type' => 'pickup', 'customer' => 'riya.patel@example.com', 'items' => ['Amdavadi Misal Pav' => 7, 'Cheese Blast Vadapav' => 8, 'Mango Lassi' => 4], 'payment' => 'upi'],
            ['day' => 1, 'status' => 'completed', 'type' => 'delivery', 'customer' => 'harsh.shah@example.com', 'items' => ['Tava Pulav' => 5, 'AMV Spl Misal Thali' => 4, 'Masala Chaas' => 6], 'payment' => 'card'],
            ['day' => 0, 'status' => 'completed', 'type' => 'dine-in', 'customer' => 'neha.mehta@example.com', 'items' => ['Amdavadi Misal Pav' => 12, 'Amdavadi Vadapav' => 9, 'Mango Lassi' => 8], 'payment' => 'upi'],
            ['day' => 0, 'status' => 'completed', 'type' => 'pickup', 'customer' => 'aarav.desai@example.com', 'items' => ['Cheese Blast Vadapav' => 10, 'AMV Special Poha' => 6, 'Masala Chaas' => 6], 'payment' => 'online'],
            ['day' => 0, 'status' => 'pending', 'type' => 'delivery', 'customer' => 'kavya.trivedi@example.com', 'items' => ['Amdavadi Misal Pav' => 3, 'Mango Lassi' => 2], 'payment' => 'cash'],
            ['day' => 0, 'status' => 'pending', 'type' => 'pickup', 'customer' => 'riya.patel@example.com', 'items' => ['Regular Poha' => 4, 'Masala Chaas' => 4], 'payment' => 'upi'],
            ['day' => 0, 'status' => 'processing', 'type' => 'dine-in', 'customer' => 'harsh.shah@example.com', 'items' => ['AMV Spl Misal Thali' => 2, 'Mango Lassi' => 2], 'payment' => 'card'],
            ['day' => 0, 'status' => 'processing', 'type' => 'delivery', 'customer' => 'neha.mehta@example.com', 'items' => ['Tava Pulav' => 3, 'Amdavadi Vadapav' => 4], 'payment' => 'online'],
            ['day' => 0, 'status' => 'ready', 'type' => 'pickup', 'customer' => 'aarav.desai@example.com', 'items' => ['Cheese Blast Vadapav' => 5, 'Mango Lassi' => 3], 'payment' => 'upi'],
            ['day' => 1, 'status' => 'ready', 'type' => 'dine-in', 'customer' => 'kavya.trivedi@example.com', 'items' => ['Bhaji Pav' => 4, 'Masala Chaas' => 4], 'payment' => 'cash'],
            ['day' => 2, 'status' => 'cancelled', 'type' => 'delivery', 'customer' => 'riya.patel@example.com', 'items' => ['AMV Spl Misal Thali' => 2], 'payment' => 'online'],
            ['day' => 3, 'status' => 'cancelled', 'type' => 'pickup', 'customer' => 'harsh.shah@example.com', 'items' => ['Amdavadi Vadapav' => 5], 'payment' => 'card'],
        ];

        foreach ($orders as $index => $orderData) {
            $this->seedDashboardOrder($index + 1, $orderData, $menuItems);
        }
    }

    /**
     * @param  array{day:int,status:string,type:string,customer:string,items:array<string,int>,payment:string}  $orderData
     * @param  Collection<string, MenuItem>  $menuItems
     */
    private function seedDashboardOrder(int $number, array $orderData, Collection $menuItems): void
    {
        $createdAt = now()
            ->subDays($orderData['day'])
            ->setTime(11 + ($number % 10), ($number * 7) % 60);

        $subtotal = 0;
        foreach ($orderData['items'] as $name => $quantity) {
            $menuItem = $menuItems->get($name);

            if (! $menuItem) {
                continue;
            }

            $subtotal += (float) $menuItem->price * $quantity;
        }

        $taxAmount = round($subtotal * 0.05, 2);
        $totalAmount = $subtotal + $taxAmount;
        $user = User::where('email', $orderData['customer'])->first();

        $order = Order::updateOrCreate(
            ['guest_email' => sprintf('dashboard-demo-%02d@amv.test', $number)],
            [
                'user_id' => $user?->id,
                'guest_name' => $user?->name,
                'guest_phone' => $user?->phone,
                'order_type' => $orderData['type'],
                'status' => $orderData['status'],
                'total_amount' => $totalAmount,
                'tax_amount' => $taxAmount,
                'delivery_address' => $orderData['type'] === 'delivery' ? 'AMV Demo Society, Ahmedabad' : null,
                'notes' => 'Dashboard demo order',
                'payment_method' => $orderData['payment'],
                'payment_status' => $orderData['status'] === 'cancelled' ? 'refunded' : 'paid',
                'transaction_id' => sprintf('AMV-DEMO-%04d', $number),
            ]
        );

        $order->forceFill([
            'created_at' => $createdAt,
            'updated_at' => $createdAt,
        ])->save();

        $order->orderItems()->delete();

        foreach ($orderData['items'] as $name => $quantity) {
            $menuItem = $menuItems->get($name);

            if (! $menuItem) {
                continue;
            }

            OrderItem::create([
                'order_id' => $order->id,
                'menu_item_id' => $menuItem->id,
                'quantity' => $quantity,
                'unit_price' => $menuItem->price,
                'subtotal' => (float) $menuItem->price * $quantity,
                'notes' => null,
            ]);
        }
    }
}
