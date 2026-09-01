<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DriverDocument extends Model
{
    use HasFactory;

    // Fields allowed for saving
    protected $fillable = [
        'driver_id',
        'document_type',
        'document_path',
        'expiry_date'
    ];

    // Set field data types
    protected $casts = [
        'expiry_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Get related driver
    public function driver(): BelongsTo
    {
        return $this->belongsTo(Driver::class);
    }
    
    // Get record creator
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by'); 
        // Uses created_by foreign key
    }


}
