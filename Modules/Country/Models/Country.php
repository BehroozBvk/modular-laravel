<?php

declare(strict_types=1);

namespace Modules\Country\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\StudentParent\Models\StudentParent;
use Modules\Teacher\Models\Teacher;
use Modules\Country\Database\Factories\CountryFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Country extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'code',
        'flag'
    ];

    protected static function newFactory(): CountryFactory
    {
        return CountryFactory::new();
    }

    public function teachers(): HasMany
    {
        return $this->hasMany(Teacher::class);
    }

    public function studentParents(): HasMany
    {
        return $this->hasMany(StudentParent::class);
    }

    /**
     * Accessor for the flag attribute.
     *
     * @return Attribute<string, string>
     */
    public function flag(): Attribute
    {
        return Attribute::make(
            get: static fn(?string $value): ?string => $value ? url('storage/' . $value) : null,
            set: static fn(?string $value): ?string => $value,
        );
    }
}
