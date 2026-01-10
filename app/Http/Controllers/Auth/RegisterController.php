<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Inertia\Response;

class RegisterController extends Controller
{
    public function create(): Response
    {
        return Inertia::render('auth/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(RegisterRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $user = User::create([
            'first_name' => $data['first_name'],
            'middle_name' => $data['middle_name'] ?? null,
            'last_name' => $data['last_name'],
            'phone_number' => $data['phone_number'],
            'email' => $data['email'],
            'birthday' => $data['birthday'], 
            'gender' => $data['gender'],
            'civil_status' => $data['civil_status'],
            'address' => $data['address'],
            'password' => Hash::make($data['password']),
            'user_type' => $data['user_type'],

            
        ]);

        // Farmer-only fields
        if ($data['user_type'] === 'farmer') {
            $user->farmer()->create([
                'farming_background' => $data['farming_background'] ?? null,
                'years_of_farming' => $data['years_of_farming'] ?? null,
                'familiarity_tree_cultivation' => $data['familiarity_tree_cultivation'] ?? false,
            ]);
        }

        // Investor-only fields
        if ($data['user_type'] === 'investor') {
            $idFrontExtension = $request->file('id_front')->extension();
            $idBackExtension = $request->file('id_back')->extension();
            
            $idFrontPath = $request->file('id_front')->storeAs(
                'ids',
                $user->id . '_front_' . time() . '.' . $idFrontExtension,
                'public'
            );
            
            $idBackPath = $request->file('id_back')->storeAs(
                'ids',
                $user->id . '_back_' . time() . '.' . $idBackExtension,
                'public'
            );

            $user->investor()->create([
                'id_type' => $data['id_type'],
                'id_front' => $idFrontPath,
                'id_back' => $idBackPath,
            ]);
        }

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
