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
        $user->username = 'driver1';
        $user->saveQuietly();
        $user->assignRole('driver');

        $user = new User();
        $user->username = 'driver2';
        $user->saveQuietly();
        $user->assignRole('driver');

        $user = new User();
        $user->username = 'driver3';
        $user->saveQuietly();
        $user->assignRole('driver');

        $user = new User();
        $user->username = 'customer1';
        $user->saveQuietly();
        $user->assignRole('customer');

        $user = new User();
        $user->username = 'customer2';
        $user->saveQuietly();
        $user->assignRole('customer');

        $user = new User();
        $user->username = 'customer3';
        $user->saveQuietly();
        $user->assignRole('customer');
    }
}
