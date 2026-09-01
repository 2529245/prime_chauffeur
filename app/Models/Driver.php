<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Driver extends Model
{
    use HasFactory;

    // Fields allowed for saving
    protected $fillable = [
        'name',
        'contact_no',
        'emergency_contact',
        'status',
        'created_by',
        'updated_by',
    ];

    // Set field data types
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Get assigned vehicles
    public function vehicles(): BelongsToMany
    {
        return $this->belongsToMany(Vehicle::class, 'vehicle_drivers')
            ->withPivot('is_primary')
            ->withTimestamps();
    }

    // Get related documents
    public function documents(): HasMany
    {
        return $this->hasMany(DriverDocument::class);
    }

    // Get related bookings
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    // Get asset assignments
    public function assetAssignments(): MorphMany
    {
        return $this->morphMany(AssetAssignment::class, 'assignable');
    }

    // Get current asset assignments
    public function currentAssetAssignments()
    {
        return $this->assetAssignments()
            ->whereNull('date_returned');
    }

    // Get POS assignments
    public function posMachineAssignments(): MorphMany
    {
        return $this->morphMany(AssetAssignment::class, 'assignable')
            ->where('asset_type', 'pos_machine');
    }

    // Get phone assignments
    public function mobilePhoneAssignments(): MorphMany
    {
        return $this->morphMany(AssetAssignment::class, 'assignable')
            ->where('asset_type', 'mobile_phone');
    }

    // Get SIM assignments
    public function simCardAssignments(): MorphMany
    {
        return $this->morphMany(AssetAssignment::class, 'assignable')
            ->where('asset_type', 'sim_card');
    }

    // Get bank assignments
    public function bankAccountAssignments(): MorphMany
    {
        return $this->morphMany(BankAccountAssignment::class, 'assignable');
    }

    // Get contact assignments
    public function contactAssignments(): MorphMany
    {
        return $this->morphMany(ContactAssignment::class, 'assignable');
    }

    // Get primary vehicle
    public function getPrimaryVehicleAttribute()
    {
        return $this->vehicles()
            ->wherePivot('is_primary', true)
            ->first();
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

    // Get current assets
    public function getCurrentAssetsAttribute()
    {
        return $this->currentAssetAssignments()
            ->with('asset')
            ->get()
            ->pluck('asset');
    }

    // Check assigned assets
    public function getHasAssignedAssetsAttribute(): bool
    {
        return $this->currentAssetAssignments()->exists();
    }

    // Count assets by type
    public function getAssignedAssetsCountAttribute(): array
    {
        return [
            'pos_machines' => $this->posMachineAssignments()
                ->whereNull('date_returned')
                ->count(),

            'mobile_phones' => $this->mobilePhoneAssignments()
                ->whereNull('date_returned')
                ->count(),

            'sim_cards' => $this->simCardAssignments()
                ->whereNull('date_returned')
                ->count(),
        ];
    }

    // Filter active drivers
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    // Filter drivers with assets
    public function scopeWithAssignedAssets($query)
    {
        return $query->whereHas('currentAssetAssignments');
    }

    // Set creator and updater
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (auth()->check()) {
                $model->created_by = auth()->id();
            }
        });

        static::updating(function ($model) {
            if (auth()->check()) {
                $model->updated_by = auth()->id();
            }
        });
    }
}