<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        if (\Schema::hasTable('categories')) {
            factory(App\Models\Job::class)->times(50)->create();
        }
    }
}
