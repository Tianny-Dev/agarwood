<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use App\Models\Farmer;
use App\Models\Investor;
use App\Http\Resources\InvestorResource; // Import the resource
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        // Calculate dynamic stats
        $stats = [
            [
                'label' => 'Total Farmers',
                'value' => Farmer::count(),
                'icon' => 'i-lucide-tractor',
                'color' => 'primary'
            ],
            [
                'label' => 'Total Agents',
                'value' => Agent::count(),
                'icon' => 'i-lucide-users',
                'color' => 'blue' // "info" mapping in Tailwind
            ],
            [
                'label' => 'Total Investors',
                'value' => Investor::count(),
                'icon' => 'i-lucide-hand-coins',
                'color' => 'green' // "success" mapping
            ],
            [
                'label' => 'Pending Verification',
                'value' => Agent::where('is_verified', false)->count(),
                'icon' => 'i-lucide-shield-alert',
                'color' => 'orange' // "warning" mapping
            ],
        ];

        // Fetch recent investors using your InvestorResource
        $recentInvestorsRaw = Investor::with(['user', 'agent.user'])
            ->latest()
            ->take(5)
            ->get();

        return Inertia::render('super-admin/dashboard/Index', [
            'stats' => $stats,
            // Wrap the collection in the Resource to ensure initials show up
            'recentInvestors' => InvestorResource::collection($recentInvestorsRaw)->resolve(),
        ]);
    }
}
