<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Allocation extends Model
{
    public $timestamps = false;
    public $fillable = ['employee_id', 'equipment_id', 'checkout_date', 'return_date'];

    protected static function booted()
    {
        static::creating(function ($allocation) {
            if (empty($allocation->checkout_date)) {
                $allocation->checkout_date = now();
            }
        });
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function equipment(): BelongsTo
    {
        return $this->belongsTo(Equipment::class);
    }
}
