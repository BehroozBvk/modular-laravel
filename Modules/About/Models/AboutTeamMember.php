<?php

declare(strict_types=1);

namespace Modules\About\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\About\Database\Factories\AboutTeamMemberFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Contracts\Routing\UrlGenerator;

/**
 * About Team Member Model
 *
 * @property int $id
 * @property string $image_path
 * @property int $order
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class AboutTeamMember extends Model implements TranslatableContract
{
    use HasFactory, Translatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'image_path',
        'order',
    ];

    /**
     * The attributes that are translatable.
     */
    public $translatedAttributes = [
        'name',
        'position',
    ];

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory()
    {
        return AboutTeamMemberFactory::new();
    }

    /**
     * Get the image path attribute.
     */
    public function imagePath(): Attribute
    {
        return Attribute::make(
            get: fn($value): string|UrlGenerator|null => $value ? url("storage/{$value}") : null,
            set: fn($value) => $value,
        );
    }
}
