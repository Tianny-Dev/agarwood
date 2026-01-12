<?php

namespace Database\Seeders;

use App\Enums\CivilStatusEnum;
use App\Enums\IdType;
use App\Models\Farmer;
use App\Models\Investor;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Farmer user profile
        $farmer = User::factory()->create([
            'role_id' => '2-26-0001',
            'username' => 'farmer1',
            'first_name' => 'Juan',
            'middle_name' => 'Mancho',
            'last_name' => 'Dela Cruz',
            'email' => 'juandelacruz@gmail.com',
            'phone_number' => '639170000002',
            'civil_status' => CivilStatusEnum::MARRIED->value,
        ]);

        Farmer::factory()->create([
            'user_id' => $farmer->id,
            'farming_background' => 'Rice and corn',
            'years_of_farming' => 10,
            'familiarity_tree_cultivation' => true,
        ]);

        // Create Investor user profile
        $investor = User::factory()->create([
            'role_id' => '3-26-0001',
            'username' => 'investor1',
            'first_name' => 'Pedro',
            'middle_name' => 'Mancho',
            'last_name' => 'Dela Cruz',
            'email' => 'pedrodelacruz@gmail.com',
            'phone_number' => '639170000003',
            'civil_status' => CivilStatusEnum::MARRIED->value,
        ]);

        Investor::factory()->create([
            'user_id' => $investor->id,
            'id_front' => 'front_id.png',
            'id_back' => 'back_id.png',
        ]);

        // Create Super-Admin
        $superAdmin = User::factory()->create([
            'role_id' => '1-26-0001',
            'username' => 'super_admin',
            'first_name' => 'Super',
            'last_name' => 'Admin',
            'email' => 'superadmin@example.com',
            'phone_number' => '639170000010',
            'civil_status' => CivilStatusEnum::MARRIED->value,
        ]);

        // random farmers
        User::factory()
            ->count(5)
            ->has(Farmer::factory())
            ->create();

        // random investors
        User::factory()
            ->count(5)
            ->has(Investor::factory())
            ->create();
    }
}
