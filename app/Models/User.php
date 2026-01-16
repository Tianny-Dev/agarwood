<?php

namespace App\Models;

use App\Enums\CivilStatusEnum;
use App\Enums\Gender;
use Database\Factories\UserFactory;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use App\Contracts\RequiresContract;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, HasSlug, Notifiable, HasRoles, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'role_id',
        'first_name',
        'phone_number_verified_at',
        'middle_name',
        'last_name',
        'phone_number',
        'email',
        'birthday',
        'gender',
        'civil_status',
        'address',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'two_factor_secret',
        'two_factor_recovery_codes',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'gender' => Gender::class,
            'civil_status' => CivilStatusEnum::class,
            'birthday' => 'date',
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'two_factor_confirmed_at' => 'datetime',
        ];
    }

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('first_name')
            ->saveSlugsTo('username')
            ->usingSeparator('_')
            ->slugsShouldBeNoLongerThan(20);
    }

    public function agent(): HasOne
    {
        return $this->hasOne(Agent::class);
    }

    public function farmer(): HasOne
    {
        return $this->hasOne(Farmer::class);
    }

    public function investor(): HasOne
    {
        return $this->hasOne(Investor::class);
    }

    public function partner(): HasOne
    {
        return $this->hasOne(Partner::class);
    }

    public function qrCode(): MorphOne
    {
        return $this->morphOne(QrCode::class, 'qrable');
    }

    public function contractableEntities(): array
    {
        return array_filter([
            $this->investor,
            $this->partner ?? null,
            $this->farmer ?? null,
        ]);
    }

    public function activeContract(): ?Contract
    {
        return $this->investor?->contract
            ?? $this->partner?->contract;
    }

    /**
     * Reset role counters in the factory
     */
    public static function resetRoleCounters(): void
    {
        UserFactory::resetCounters();
    }

    /**
     * Set a specific role counter in the factory
     */
    public static function setRoleCounter(string $role, int $count): void
    {
        UserFactory::setCounter($role, $count);
    }
}
