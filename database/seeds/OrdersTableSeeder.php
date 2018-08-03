<?php

use Illuminate\Database\Seeder;

class OrdersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        if (\Schema::hasTable('orders')) {
            factory(App\Models\Order::class)->times(50)->create();
        }
    }
}
