<?php

namespace App\Models;

use App\Contracts\RequiresContract;
use App\Enums\IdType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Investor extends Model implements RequiresContract
{
    /** @use HasFactory<\Database\Factories\InvestorFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'agent_id',
        'id_type',
        'id_front',
        'id_back',
        'is_paid'
    ];

    protected $casts = [
        'id_type' => IdType::class,
        'is_paid' => 'boolean',
    ];

    /**
     * The User profile belonging to this Investor.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * THE MISSING RELATIONSHIP:
     * Link the Investor back to the Agent who referred them.
     */
    public function agent(): BelongsTo
    {
        return $this->belongsTo(Agent::class);
    }

    public function contract(): MorphOne
    {
        return $this->morphOne(Contract::class, 'contractable');
    }

    public function qrCode(): MorphOne
    {
        return $this->morphOne(QrCode::class, 'qrable');
    }
}
