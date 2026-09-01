<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Staff extends Model
{
    use HasFactory;

    // Fields allowed for saving
    protected $fillable = [
        'name',
        'position',
        'contact_info',
        'emergency_contact',
        'status',
        'created_by',
        'updated_by'
    ];

    // Set field data types
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Get related documents
    public function documents(): HasMany
    {
        return $this->hasMany(StaffDocument::class);
    }

    // Get asset assignments
    public function assetAssignments(): HasMany
    {
        return $this->hasMany(AssetAssignment::class, 'assignable_id')
                    ->where('assignable_type', 'staff');
    }

    // Get bank assignments
    public function bankAccountAssignments(): HasMany
    {
        return $this->hasMany(BankAccountAssignment::class, 'assignable_id')
                    ->where('assignable_type', 'staff');
    }

    // Get contact assignments
    public function contactAssignments(): HasMany
    {
        return $this->hasMany(ContactAssignment::class, 'assignable_id')
                    ->where('assignable_type', 'staff');
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