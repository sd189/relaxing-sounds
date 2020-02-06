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
        DB::table('users')->insert([
            'name' => 'web admin',
            'email' => env('WEB_ADMIN_EMAIL'),
            'password' => '$2y$10$32J3MIqwrW0YYjUG18.4LO7zmkd2sAjOXyhWMLh2kc9oLJIGmJPl2',
            'created_at' => now()
        ]);
    }
}
