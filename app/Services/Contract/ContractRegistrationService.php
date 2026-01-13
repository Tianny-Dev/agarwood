<?php

namespace App\Services\Contract;

use App\Mail\ContractMail;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ContractRegistrationService
{
    public function create(
        string $type,
        $user,
        array $data,
        Request $request
    ): void {
        $idFrontPath = $request->file('id_front')->storeAs(
            'ids',
            "{$user->id}_front_" . time() . '.' . $request->file('id_front')->extension(),
            'public'
        );

        $idBackPath = $request->file('id_back')->storeAs(
            'ids',
            "{$user->id}_back_" . time() . '.' . $request->file('id_back')->extension(),
            'public'
        );

        $contractable = match ($type) {
            'investor' => $user->investor()->create([
                'id_type' => $data['id_type'],
                'id_front' => $idFrontPath,
                'id_back' => $idBackPath,
                'is_paid' => false,
            ]),
            'partner' => $user->partner()->create([
                'id_type' => $data['id_type'],
                'id_front' => $idFrontPath,
                'id_back' => $idBackPath,
                'is_paid' => false,
            ]),
        };

        $contractNumber = 'AGR-' . strtoupper(Str::random(8));
        $view = "contracts.{$type}";

        $pdf = Pdf::loadView($view, [
            'user' => $user,
            $type => $contractable,
            'contract_number' => $contractNumber,
            'qr' => null,
        ]);

        Storage::disk('public')->makeDirectory('contracts');

        $pdfPath = "contracts/{$contractNumber}.pdf";
        Storage::disk('public')->put($pdfPath, $pdf->output());

        $contract = $contractable->contract()->create([
            'contract_number' => $contractNumber,
            'status' => 'unpaid',
            'file_path' => $pdfPath,
        ]);

        DB::afterCommit(function () use ($contract) {
            Mail::to($contract->contractable->user->email)
                ->send(new ContractMail($contract));
        });
    }
}
