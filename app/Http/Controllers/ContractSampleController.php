<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ContractSampleController extends Controller
{
    public function showStaticContract()
    {
        // Defining static data manually
        $data = [
            'contract_number' => 'INV-2024-001',
            'user' => (object) [
                'first_name'   => 'John',
                'last_name'    => 'Doe',
                'email'        => 'john.doe@example.com',
                'phone_number' => '+1 234 567 890',
                'birthday'     => '1990-01-01',
                'gender'       => 'Male',
                'address'      => '123 Main St, New York, NY'
            ],
            'investor' => (object) [
                'id_type' => 'Passport',
                'is_paid' => true
            ],
            'qr' => (object) [
                'image_path' => 'qrcodes/qrcodes.png'
            ]
        ];

        // Load the view from resources/views/contracts/index.blade.php
        $pdf = Pdf::loadView('contracts.index', $data);

        // 'stream' allows you to view it in the browser first
        return $pdf->stream('static_contract.pdf');
    }
}
