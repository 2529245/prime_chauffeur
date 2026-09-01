<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VehicleDriver extends Model
{
    use HasFactory;

    // Set database table
    protected $table = 'vehicle_drivers';

    // Fields allowed for saving
    protected $fillable = [
        'vehicle_id',
        'driver_id',
        'is_primary'
    ];

    // Set field data types
    protected $casts = [
        'is_primary' => 'boolean',
        'created_at' => 'datetime',
    ];

    // Get related vehicle
    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }

    // Get related driver
    public function driver(): BelongsTo
    {
        return $this->belongsTo(Driver::class);
    }
}