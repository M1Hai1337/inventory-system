<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Employee extends Model
{
    public $timestamps = false;
    public $fillable = ['first_name', 'last_name', 'email', 'age', 'address'];

    public function allocations(): HasMany{
        return $this->hasMany(Allocation::class);
    }
}
