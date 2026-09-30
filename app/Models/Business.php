<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Business extends Model
{
    public const STATUS_DRAFT = 'draft';
    public const STATUS_PUBLISHED = 'published';

    protected $fillable = [
        'name',
        'slug',
        'category',
        'tagline',
        'description',
        'address',
        'logo_path',
        'cover_path',
        'accent_color',
        'status',
    ];

    public function links(): HasMany
{
    return $this->hasMany(BusinessLink::class)
        ->orderBy('sort_order');
}


public function devices(): HasMany
{
    return $this->hasMany(Device::class);
}

}
