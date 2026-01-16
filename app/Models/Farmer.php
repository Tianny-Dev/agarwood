<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Farmer extends Model
{
    /** @use HasFactory<\Database\Factories\FarmerFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'is_verified',
        'farming_background',
        'years_of_farming',
        'familiarity_tree_cultivation',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'familiarity_tree_cultivation' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function agents(): HasMany
    {
        return $this->hasMany(Agent::class);
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
