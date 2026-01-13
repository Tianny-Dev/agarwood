<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Partner extends Model
{
    /** @use HasFactory<\Database\Factories\PartnerFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'id_type',
        'id_front',
        'id_back',
        'is_paid'
    ];

    protected $casts = [
        'id_type' => IdType::class,
        'is_paid' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
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
