<?php

use Illuminate\Database\Seeder;

class CitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        if (\Schema::hasTable('cities')) {
            factory(App\Models\City::class)->times(2)->create();
        }
    }
}
