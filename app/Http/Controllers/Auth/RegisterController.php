<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Mail\ContractMail;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
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

        $user = DB::transaction(function () use ($data, $request) {

            $roleCode = match($data['user_type'] ?? '') {
                'farmer' => 2,
                'investor' => 3,
                default => 1,
            };

            $year = date('y');
            $lastUser = User::where('role_id', 'LIKE', "{$roleCode}-{$year}-%")
                ->lockForUpdate()
                ->orderBy('role_id', 'desc')
                ->first();

            $newNumber = $lastUser ? ((int) substr($lastUser->role_id, -4)) + 1 : 1;
            $role_id = "{$roleCode}-{$year}-" . str_pad($newNumber, 4, '0', STR_PAD_LEFT);

            $user = User::create([
                'role_id' => $role_id,
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
            ]);

            if ($data['user_type'] === 'farmer') {
                $user->farmer()->create([
                    'farming_background' => $data['farming_background'] ?? null,
                    'years_of_farming' => $data['years_of_farming'] ?? null,
                    'familiarity_tree_cultivation' => $data['familiarity_tree_cultivation'] ?? false,
                ]);
            }

            if ($data['user_type'] === 'investor') {

            $idFrontPath = $request->file('id_front')->storeAs(
                'ids',
                $user->id . '_front_' . time() . '.' . $request->file('id_front')->extension(),
                'public'
            );

            $idBackPath = $request->file('id_back')->storeAs(
                'ids',
                $user->id . '_back_' . time() . '.' . $request->file('id_back')->extension(),
                'public'
            );

            $investor = $user->investor()->create([
                'id_type' => $data['id_type'],
                'id_front' => $idFrontPath,
                'id_back' => $idBackPath,
                'is_paid' => false,
            ]);

            $contractNumber = 'AGR-' . strtoupper(Str::random(8));

            $pdf = Pdf::loadView('contracts.investor', [
                'user' => $user,
                'investor' => $investor,
                'contract_number' => $contractNumber,
                'qr' => null, 
            ]);

            Storage::disk('public')->makeDirectory('contracts');

            $pdfPath = 'contracts/' . $contractNumber . '.pdf';

            Storage::disk('public')->put($pdfPath, $pdf->output());

            $contract = $investor->contract()->create([
                'contract_number' => $contractNumber,
                'status' => 'unpaid',
                'file_path' => $pdfPath,
            ]);

            Mail::to($user->email)->send(new ContractMail($contract));
        }

            return $user;
        });

        event(new Registered($user));
        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}