<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    public $timestamps = false;
    public $fillable = ['name'];

    public function equipment(): hasMany{
        return $this->hasMany(Equipment::class);
    }
}
