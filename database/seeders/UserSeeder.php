<?php

namespace Database\Seeders;

use App\Models\User\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->name = 'driver1';
        $user->saveQuietly();
        $user->assignRole('driver');

        $user = new User();
        $user->name = 'driver2';
        $user->saveQuietly();
        $user->assignRole('driver');

        $user = new User();
        $user->name = 'driver3';
        $user->saveQuietly();
        $user->assignRole('driver');

        $user = new User();
        $user->name = 'customer_1';
        $user->saveQuietly();
        $user->assignRole('customer');

        $user = new User();
        $user->name = 'customer_2';
        $user->saveQuietly();
        $user->assignRole('customer');

        $user = new User();
        $user->name = 'customer_3';
        $user->saveQuietly();
        $user->assignRole('customer');
    }
}
