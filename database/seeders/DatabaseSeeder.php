<?php

namespace Database\Seeders;

use App\Enums\CivilStatusEnum;
use App\Enums\IdType;
use App\Models\Agent;
use App\Models\Farmer;
use App\Models\Investor;
use App\Models\Partner;
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
        // ------------------------------
        // 1. Create a Farmer
        // ------------------------------
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

        // ------------------------------
        // 2. Create an Investor (no agent yet)
        // ------------------------------
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

        // ------------------------------
        // 3. Create a Super-Admin
        // ------------------------------
        $superAdmin = User::factory()->create([
            'role_id' => '1-26-0001',
            'username' => 'super_admin',
            'first_name' => 'Super',
            'last_name' => 'Admin',
            'email' => 'superadmin@example.com',
            'phone_number' => '639170000010',
            'civil_status' => CivilStatusEnum::MARRIED->value,
        ]);

        // ------------------------------
        // 4. Create Agents
        // ------------------------------
        $agents = Agent::factory()
            ->count(3)
            ->verified($superAdmin->id) 
            ->create();

        // ------------------------------
        // 5. Random Farmers
        // ------------------------------
        User::factory()
            ->count(5)
            ->has(Farmer::factory())
            ->create();

        // ------------------------------
        // 6. Random Investors with Agent assignment
        // ------------------------------
        User::factory()
            ->count(5)
            ->has(Investor::factory()->state(function () use ($agents) {
                return [
                    'agent_id' => $agents->random()->id, 
                    'id_front' => 'front_id.png',
                    'id_back' => 'back_id.png',
                ];
            }))
            ->create();

        // ------------------------------
        // 7. Random Partners with Agent assignment
        // ------------------------------
        User::factory()
            ->count(5)
            ->has(Partner::factory()->state(function () use ($agents) {
                return [
                    'agent_id' => $agents->random()->id,
                ];
            }))
            ->create();
    }
}
