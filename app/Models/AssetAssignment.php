<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class AssetAssignment extends Model
{
    use HasFactory;

    // Fields allowed for saving
    protected $fillable = [
        'assignable_type',
        'assignable_id',
        'asset_type',
        'asset_id',
        'date_assigned',
        'date_returned',
        'notes',
        'created_by',
        'updated_by',
    ];

    // Set field data types
    protected $casts = [
        'date_assigned' => 'date',
        'date_returned' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Get assigned person
    public function assignable(): MorphTo
    {
        return $this->morphTo();
    }

    // Convert assignable model type
    public function getAssignableTypeAttribute($value)
    {
        return match ($value) {
            'staff' => Staff::class,
            'driver' => Driver::class,
            default => $value,
        };
    }

    // Store assignable database type
    public function setAssignableTypeAttribute($value)
    {
        $this->attributes['assignable_type'] = match ($value) {
            Staff::class,
            'staff' => 'staff',

            Driver::class,
            'driver' => 'driver',

            default => $value,
        };
    }

    // Safely get assigned person
    public function getAssignableSafeAttribute()
    {
        if (empty($this->assignable_type)) {
            return null;
        }

        try {
            return $this->assignable;
        } catch (\Throwable $e) {
            return null;
        }
    }

    // Get assigned asset
    public function asset()
    {
        return match ($this->asset_type) {
            'pos_machine' => $this->belongsTo(
                PosMachine::class,
                'asset_id'
            ),

            'mobile_phone' => $this->belongsTo(
                MobilePhone::class,
                'asset_id'
            ),

            'sim_card' => $this->belongsTo(
                SimCard::class,
                'asset_id'
            ),

            default => null,
        };
    }

    // Get record creator
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Get record updater
    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}