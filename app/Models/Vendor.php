<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vendor extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'email',
        'address',
        'city',
        'vendor_group_id',
        'payment_terms',
        'status',
    ];

    public function vendorGroup(): BelongsTo
    {
        return $this->belongsTo(VendorGroup::class);
    }

    public function purchases(): HasMany
    {
        return $this->hasMany(Purchase::class);
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }
}
