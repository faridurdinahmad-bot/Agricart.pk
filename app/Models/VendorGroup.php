<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class VendorGroup extends Model
{
    protected $fillable = ['name', 'description', 'supplier_type'];

    public function vendors(): HasMany
    {
        return $this->hasMany(Vendor::class);
    }
}
