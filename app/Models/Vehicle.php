<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vehicle extends Model
{
    use HasFactory;

    // Fields allowed for saving
    protected $fillable = [
        'vehicle_name',
        'vehicle_plate_no',
        'vehicle_model',
        'vehicle_color',
        'mulkiya_expiry_date',
        'status',
        'created_by',
        'updated_by',
    ];

    // Set field data types
    protected $casts = [
        'mulkiya_expiry_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Get vehicle drivers
    public function drivers(): BelongsToMany
    {
        return $this->belongsToMany(Driver::class, 'vehicle_drivers')
            ->withPivot('is_primary')
            ->withTimestamps();
    }

    // Get related bookings
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    // Get primary driver
    public function getPrimaryDriverAttribute()
    {
        return $this->drivers()
            ->wherePivot('is_primary', true)
            ->first();
    }

    // Get record creator
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Get record updater
    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}