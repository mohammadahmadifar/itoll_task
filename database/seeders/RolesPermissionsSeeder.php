<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolesPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Seed Roles
        $this->SeedDriversRole();
        $this->SeedCustomerRole();
    }

    /**
     * @return void
     */
    private function SeedDriversRole(): void
    {
        if (Role::where('name', 'driver')->count() == 0) {
            Role::create(['name' => 'driver', 'guard_name' => 'sanctum']);
        }
    }

    /**
     * @return void
     */
    private function SeedCustomerRole(): void
    {
        if (Role::where('name', 'customer')->count() == 0) {
            Role::create(['name' => 'customer', 'guard_name' => 'sanctum']);
        }
    }

}
