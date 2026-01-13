<?php

namespace App\Services;

use App\Models\User;

class DashboardResolver
{
    public function resolve(User $user): string
    {
        return match (true) {
            $user->investor !== null => route('investor.dashboard'),
            $user->farmer !== null   => route('farmer.dashboard'),
            // $user->isAdmin()         => route('admin.dashboard'),
            default                  => route('home'),
        };
    }
}
