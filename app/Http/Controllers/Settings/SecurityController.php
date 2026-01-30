<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class SecurityController extends Controller
{

    /**
     * Show the user's password settings page.
     */
    public function show(Request $request): Response
    {
        return Inertia::render('settings/Security',);
    }
}