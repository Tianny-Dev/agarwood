<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class ContractController extends Controller
{
    public function pending()
    {
        return Inertia::render('contract/Pending');
    }
}
