<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Contract extends Model
{
    /** @use HasFactory<\Database\Factories\ContractFactory> */
    use HasFactory;

    protected $fillable = [
        'contract_number',
        'status',
        'payment_intent_id',
        'file_path',
    ];

    public function contractable(): MorphTo 
    { 
        return $this->morphTo(); 
    }

    public function isPaid(): bool
    {
        return $this->status === 'approved';
    }
}
