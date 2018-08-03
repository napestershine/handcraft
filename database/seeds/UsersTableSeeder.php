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
            \DB::table('users')->insert([
                'name' => 'Manu',
                'phone' => '9876543210',
                'email' => 'codeistalk@gmail.com',
                'password' => app('hash')->make('secret')
            ]);
        }
    }
}
