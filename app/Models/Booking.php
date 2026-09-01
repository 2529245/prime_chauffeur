<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Booking extends Model
{
    use HasFactory;

    // Fields allowed for saving
    protected $fillable = [
        'guest_name',
        'guest_contact_number',
        'pick_up_time',
        'drop_off_time',
        'pick_up_location',
        'drop_off_location',
        'service',
        'vehicle_id',
        'driver_id',
        'payment_method',
        'no_of_extra_hrs',
        'basic_amount',
        'extra_hrs_amount',
        'other_amounts',
        'gross_total',
        'status',
        'special_instructions',
        'cancel_reason',
        'created_by',
        'updated_by'
    ];

    // Set field data types
    protected $casts = [
        'pick_up_time' => 'datetime',
        'drop_off_time' => 'datetime',
        'basic_amount' => 'decimal:2',
        'extra_hrs_amount' => 'decimal:2',
        'other_amounts' => 'decimal:2',
        'gross_total' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
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