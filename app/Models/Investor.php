<?php

namespace App\Models;

use App\Enums\IdType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Investor extends Model
{
    /** @use HasFactory<\Database\Factories\InvestorFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'id_type',
        'id_front',
        'id_back',
    ];

    protected $casts = [
        'id_type' => IdType::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
