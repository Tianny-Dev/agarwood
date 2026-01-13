<?php

namespace App\Services\Contract;

use App\Mail\ContractMail;
use App\Models\Contract;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ContractPaymentService
{
    public function markAsPaid(Contract $contract): void
    {
        DB::transaction(function () use ($contract) {
            $contractable = $contract->contractable;

            // Update contract + role
            $contract->update([
                'status' => 'paid',
                'checkout_session_id' => null,
            ]);

            $contractable->update(['is_paid' => true]);

            // QR
            $qrPath = "qrcodes/{$contract->id}.png";
            $code = Str::uuid();

            Storage::disk('public')->put(
                $qrPath,
                QrCode::size(200)->generate($contract->contract_number)
            );

            $qr = $contractable->qrcode()->updateOrCreate([], [
                'image_path' => $qrPath,
                'code' => $code,
            ]);

            // Resolve view
            $view = match (true) {
                $contractable instanceof \App\Models\Investor => 'contracts.investor',
                $contractable instanceof \App\Models\Partner  => 'contracts.partner',
                default => throw new \LogicException('Unsupported contractable type'),
            };

            // Build view data
            $viewData = [
                'user' => $contractable->user,
                'contract_number' => $contract->contract_number,
                'qr' => $qr,
                'status' => 'paid',
            ];

            if ($contractable instanceof \App\Models\Investor) {
                $viewData['investor'] = $contractable;
            }

            if ($contractable instanceof \App\Models\Partner) {
                $viewData['partner'] = $contractable;
            }

            // Generate PDF
            $pdf = Pdf::loadView($view, $viewData);

            $pdfPath = "contracts/{$contract->contract_number}.pdf";

            $contract->update(['file_path' => $pdfPath]);

            Storage::disk('public')->put($pdfPath, $pdf->output());
        });

        // Email AFTER commit
        Mail::to($contract->contractable->user->email)
            ->send(new ContractMail($contract));
    }
}
