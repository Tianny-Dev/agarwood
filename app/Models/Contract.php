<?php

namespace App\Models;

use Database\Factories\ContractFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Contract extends Model
{
    /** @use HasFactory<\Database\Factories\ContractFactory> */
    use HasFactory;

    protected $fillable = [
        'contractable_type',
        'contractable_id',
        'contract_number',
        'status',
        'checkout_session_id',
        'file_path',
    ];

    /**
     * Get the owning contractable model (Investor or Partner)
     */
    public function contractable()
    {
        return $this->morphTo();
    }

    /**
     * Reset contract counter in the factory
     */
    public static function resetCounter(): void
    {
        ContractFactory::resetCounter();
    }

    /**
     * Set contract counter in the factory
     */
    public static function setCounter(int $count): void
    {
        ContractFactory::setCounter($count);
    }

    public function isPaid(): bool
    {
        return $this->status === 'approved';
    }
}
