<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (\Schema::hasTable('users')) {
            factory(App\Models\User::class)->times(2)->create();
        }
    }
}
