<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Agent extends Model
{
    /** @use HasFactory<\Database\Factories\AgentFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'farmer_id',
        'agent_code',
        'is_verified',
        'verified_at',
        'verified_by',
    ];

    protected $casts = [
        'is_verified' => 'boolean',
        'verified_at' => 'datetime',
    ];

    /**
     * The user account of the agent
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function farmer(): BelongsTo
    {
        return $this->belongsTo(Farmer::class);
    }

    public function qrCode(): MorphOne 
    { 
        return $this->morphOne(QrCode::class, 'qrable'); 
    }

    /**
     * The admin who verified the agent (nullable)
     */
    public function verifiedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    /**
     * Investors linked to this agent
     */
    public function investors(): HasMany
    {
        return $this->hasMany(Investor::class);
    }

    /**
     * Partners linked to this agent
     */
    public function partners(): HasMany
    {
        return $this->hasMany(Partner::class);
    }
}
