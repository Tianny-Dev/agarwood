<?php

use App\Enums\CivilStatusEnum;
use App\Enums\Gender;
use Illuminate\Http\UploadedFile;
use App\Models\User;

test('registration screen can be rendered', function (): void {
    $response = $this->get('/register');

    $response->assertStatus(200);
});

test('new users with farmer accounts can register', function () {

    $response = $this->post(route('register'), [
        'first_name' => 'Test',
        'middle_name' => 'User',
        'last_name' => 'User',
        'phone_number' => '639123456789',
        'email' => 'test@example.com',
        'birthday' => '1990-01-01',
        'gender' => Gender::MALE->value,
        'civil_status' => CivilStatusEnum::SINGLE->value,
        'user_type' => 'farmer',

        'address' => '123 Test St',
        'password' => 'password',
        'password_confirmation' => 'password',

        // farmer fields
        'farming_background' => 'Rice farmer',
        'years_of_farming' => 10,
        'familiarity_tree_cultivation' => true,
    ]);

    $user = User::where('email', 'test@example.com')->first();

    $this->assertAuthenticatedAs($user);

    $response->assertRedirect(route('dashboard', absolute: false));

    $this->assertDatabaseHas('farmers', [
        'user_id' => $user->id,
        'years_of_farming' => 10,
    ]);
});

test('new users with investor accounts can register', function () {

    Storage::fake('public');

    $response = $this->post(route('register'), [
        'first_name' => 'Investor',
        'middle_name' => 'Test',
        'last_name' => 'User',
        'phone_number' => '639987654321',
        'email' => 'investor@example.com',
        'birthday' => '1985-05-05',
        'gender' => Gender::FEMALE->value,
        'civil_status' => CivilStatusEnum::MARRIED->value,
        'address' => '456 Investor Ave',
        'user_type' => 'investor',

        'id_type' => 'passport',
        'id_front' => UploadedFile::fake()->image('id_front.jpg'),
        'id_back' => UploadedFile::fake()->image('id_back.jpg'),

        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $user = User::where('email', 'investor@example.com')->first();

    $this->assertAuthenticatedAs($user);

    $response->assertRedirect(route('dashboard', absolute: false));

    $this->assertDatabaseHas('users', [
        'email' => 'investor@example.com',
    ]);

    $this->assertDatabaseHas('investors', [
        'user_id' => $user->id,
        'id_type' => 'passport',
    ]);

    Storage::disk('public')->assertExists($user->investor->id_front);
    Storage::disk('public')->assertExists($user->investor->id_back);
});