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

            // Update contract and investor
            $contract->update(['status' => 'paid', 'checkout_session_id' => null]);
            $contractable->update(['is_paid' => true]);

            // Generate QR code
            $qrPath = "qrcodes/{$contract->id}.png";
            $code = Str::uuid();

            Storage::disk('public')->put(
                $qrPath,
                QrCode::size(200)->generate($contract->contract_number)
            );

            // Update or create QR record
            $qr = $contractable->qrcode()->updateOrCreate([], [
                'image_path' => $qrPath,
                'code' => $code,
            ]);

            // Generate PDF with QR code
            $pdf = Pdf::loadView('contracts.investor', [
                'user' => $contractable->user,
                'investor' => $contractable,
                'contract_number' => $contract->contract_number,
                'qr' => $qr,
                'status' => 'paid',
            ]);

            // Define PDF path
            $pdfPath = "contracts/{$contract->contract_number}.pdf";

            // Update contract file_path
            $contract->update(['file_path' => $pdfPath]);

            // Save PDF to storage
            Storage::disk('public')->put($pdfPath, $pdf->output());
        });

        // Send email after transaction
        Mail::to($contract->contractable->user->email)
            ->send(new ContractMail($contract));
    }
}
