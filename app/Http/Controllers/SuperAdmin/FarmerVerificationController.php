<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Http\Resources\FarmerResource;
use App\Models\Farmer;
use Illuminate\Http\Request;
use Inertia\Inertia;

class FarmerVerificationController extends Controller
{
    /**
     * Display a listing of farmers only.
     */
    public function index(Request $request)
    {
        $farmers = Farmer::query()
            ->with(['user'])
            ->when($request->status, function ($query, $status) {
                if ($status === 'verified') $query->where('is_verified', true);
                if ($status === 'unverified') $query->where('is_verified', false);
            })
            ->when($request->search, function ($query, $search) {
                $query->whereHas('user', function ($q) use ($search) {
                    $q->whereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$search}%"])
                      ->orWhere('email', 'LIKE', "%{$search}%");
                });
            })
            ->latest()
            ->get();

        return Inertia::render('super-admin/farmer/Index', [
            'farmers' => FarmerResource::collection($farmers)->resolve(),
            'filters' => $request->only(['status', 'search']),
        ]);
    }

    public function updateStatus(Request $request, Farmer $farmer)
{
    $farmer->update([
        'is_verified' => !$farmer->is_verified
    ]);

    return back()->with('success', 'Farmer status updated successfully.');
}
}
