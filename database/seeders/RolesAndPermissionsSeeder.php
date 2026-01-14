<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Roles
        $superAdmin = Role::firstOrCreate(['name' => 'super-admin']);
        $agent = Role::firstOrCreate(['name' => 'agent']);
        $farmer = Role::firstOrCreate(['name' => 'farmer']);
        $investor = Role::firstOrCreate(['name' => 'investor']);
        $partner = Role::firstOrCreate(['name' => 'partner']);

        // Permissions
        $createAgent = Permission::firstOrCreate(['name' => 'create agent']);
        $verifyAgent = Permission::firstOrCreate(['name' => 'verify agent']);

        // Assign permissions to roles
        $farmer->givePermissionTo($createAgent);
        $superAdmin->givePermissionTo($verifyAgent);
    }
}
