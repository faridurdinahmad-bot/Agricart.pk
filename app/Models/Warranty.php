<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Warranty extends Model
{
    protected $fillable = ['name', 'days', 'description'];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
