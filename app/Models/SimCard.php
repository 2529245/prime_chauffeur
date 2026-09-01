<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SimCard extends Model
{
    use HasFactory;

    // Fields allowed for saving
    protected $fillable = [
        'sim_number',
        'telecom_provider',
        'plan_details',
        'activation_date',
        'status',
        'notes',
        'created_by',
        'updated_by'
    ];

    // Set field data types
    protected $casts = [
        'activation_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Get asset assignments
    public function assetAssignments(): HasMany
    {
        return $this->hasMany(AssetAssignment::class, 'asset_id')
                    ->where('asset_type', 'sim_card');
    }

    // Get current assignment
    public function getCurrentAssignmentAttribute()
    {
        return $this->assetAssignments->whereNull('date_returned')->first();
    }

    // Get current assignee
    public function getCurrentAssigneeAttribute()
    {
        $assignment = $this->current_assignment;
        return $assignment ? $assignment->assignable_safe : null;
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
