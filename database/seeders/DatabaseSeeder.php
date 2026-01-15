<?php

namespace Database\Seeders;

use App\Enums\CivilStatusEnum;
use App\Models\Agent;
use App\Models\Contract;
use App\Models\Farmer;
use App\Models\Investor;
use App\Models\Partner;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed roles and permissions first
        $this->call(RolesAndPermissionsSeeder::class);

        User::resetRoleCounters();
        Contract::resetCounter();

        $this->call([
            PercentageTypeSeeder::class,
            PercentageBreakdownsSeeder::class,
        ]);

        // ------------------------------
        // 1. Create a Super-Admin (Test Account)
        // ------------------------------
        $superAdmin = User::factory()->create([
            'role_id' => '1-26-0001',
            'username' => 'superadmin',
            'first_name' => 'Super',
            'middle_name' => 'Admin',
            'last_name' => 'User',
            'email' => 'superadmin@test.com',
            'phone_number' => '639170000001',
            'civil_status' => CivilStatusEnum::MARRIED->value,
        ]);
        $superAdmin->assignRole('super-admin');

        User::setRoleCounter('super_admin', 1);

        // ------------------------------
        // 2. Create a Farmer (Test Account)
        // ------------------------------
        $farmerUser = User::factory()->create([
            'role_id' => '3-26-0001',
            'username' => 'farmer',
            'first_name' => 'Juan',
            'middle_name' => 'Mancho',
            'last_name' => 'Dela Cruz',
            'email' => 'farmer@test.com',
            'phone_number' => '639170000003',
            'civil_status' => CivilStatusEnum::MARRIED->value,
        ]);
        $farmerUser->assignRole('farmer');

        $testFarmer = Farmer::factory()->create([
            'user_id' => $farmerUser->id,
            'farming_background' => 'Rice and corn cultivation',
            'years_of_farming' => 10,
            'familiarity_tree_cultivation' => true,
        ]);

        User::setRoleCounter('farmer', 1);

        // ------------------------------
        // 3. Create an Agent (Test Account)
        // ------------------------------
        $agentUser = User::factory()->create([
            'role_id' => '2-26-0001',
            'username' => 'agent',
            'first_name' => 'Test',
            'middle_name' => 'Agent',
            'last_name' => 'User',
            'email' => 'agent@test.com',
            'phone_number' => '639170000002',
            'civil_status' => CivilStatusEnum::SINGLE->value,
        ]);
        $agentUser->assignRole('agent');

        $testAgent = Agent::factory()->create([
            'user_id' => $agentUser->id,
            'farmer_id' => $testFarmer->id,
            'verified_by' => $superAdmin->id,
            'verified_at' => now(),
        ]);

        User::setRoleCounter('agent', 1);

        // ------------------------------
        // 4. Create an Investor (Test Account)
        // ------------------------------
        $investorUser = User::factory()->create([
            'role_id' => '4-26-0001',
            'username' => 'investor',
            'first_name' => 'Pedro',
            'middle_name' => 'Santos',
            'last_name' => 'Reyes',
            'email' => 'investor@test.com',
            'phone_number' => '639170000004',
            'civil_status' => CivilStatusEnum::SINGLE->value,
        ]);
        $investorUser->assignRole('investor');

        $testInvestor = Investor::factory()->create([
            'user_id' => $investorUser->id,
            'agent_id' => $testAgent->id,
            'id_front' => 'front_id.png',
            'id_back' => 'back_id.png',
        ]);

       Contract::factory()->approved()->create([
            'contractable_type' => Investor::class,
            'contractable_id' => $testInvestor->id,
        ]);

        User::setRoleCounter('investor', 1);

        // ------------------------------
        // 5. Create a Partner (Test Account)
        // ------------------------------
        $partnerUser = User::factory()->create([
            'role_id' => '5-26-0001',
            'username' => 'partner',
            'first_name' => 'Maria',
            'middle_name' => 'Santos',
            'last_name' => 'Garcia',
            'email' => 'partner@test.com',
            'phone_number' => '639170000005',
            'civil_status' => CivilStatusEnum::MARRIED->value,
        ]);
        $partnerUser->assignRole('partner');

        $testPartner = Partner::factory()->create([
            'user_id' => $partnerUser->id,
            'agent_id' => $testAgent->id,
        ]);

        Contract::factory()->paid()->create([
            'contractable_type' => Partner::class,
            'contractable_id' => $testPartner->id,
        ]);

        User::setRoleCounter('partner', 1);

        // ------------------------------
        // 6. Create Additional Agents (for random data)
        // ------------------------------
        $additionalAgents = Agent::factory()
            ->count(2)
            ->verified($superAdmin->id)
            ->create();

        // Combine all agents for random assignment
        $allAgents = collect([$testAgent])->concat($additionalAgents);

        // ------------------------------
        // 7. Random Farmers
        // ------------------------------
        $additionalFarmers = Farmer::factory()
            ->count(5)
            ->create();

        // Combine all farmers for random assignment
        $allFarmers = collect([$testFarmer])->concat($additionalFarmers);

        // ------------------------------
        // 8. Random Investors with Agent assignment and Contracts
        // ------------------------------
        User::factory()
            ->count(5)
            ->investor()
            ->has(
                Investor::factory()
                    ->state(function () use ($allAgents) {
                        return [
                            'agent_id' => $allAgents->random()->id,
                            'id_front' => 'front_id.png',
                            'id_back' => 'back_id.png',
                        ];
                    })
                    ->has(Contract::factory()->count(rand(1, 3)), 'contract')
            )
            ->create();

        // ------------------------------
        // 9. Random Partners with Agent assignment and Contracts
        // ------------------------------
        User::factory()
            ->count(5)
            ->partner()
            ->has(
                Partner::factory()
                    ->state(function () use ($allAgents) {
                        return [
                            'agent_id' => $allAgents->random()->id,
                        ];
                    })
                    ->has(Contract::factory()->count(rand(1, 2)), 'contract')
            )
            ->create();

        // ------------------------------
        // 10. Random Agents with Farmer assignment
        // ------------------------------
        User::factory()
            ->count(5)
            ->agent()
            ->has(
                Agent::factory()
                    ->state(function () use ($allFarmers) {
                        return [
                            'farmer_id' => $allFarmers->random()->id,
                        ];
                    })
            )
            ->create();
    }
}
