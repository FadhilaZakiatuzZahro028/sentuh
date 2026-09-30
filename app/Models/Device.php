<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;
use LogicException;

class Device extends Model
{
    public const STATUS_ACTIVE = 'active';
    public const STATUS_INACTIVE = 'inactive';

    protected $fillable = [
        'business_id',
        'label',
        'status',
    ];

    protected $attributes = [
        'status' => self::STATUS_INACTIVE,
    ];

    protected static function booted(): void
    {
        static::creating(function (Device $device): void {
            $device->public_code = (string) Str::uuid();
        });

        static::updating(function (Device $device): void {
            if ($device->isDirty('public_code')) {
                throw new LogicException(
                    'Kode publik perangkat tidak boleh diubah.'
                );
            }
        });
    }

    public function business(): BelongsTo
    {
        return $this->belongsTo(Business::class);
    }
}
