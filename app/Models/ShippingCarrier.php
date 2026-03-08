<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ShippingCarrier extends Model
{
    protected $fillable = [
        'name',
        'contact_phone',
        'contact_email',
        'website',
        'status',
        'notes',
    ];

    public function shipments(): HasMany
    {
        return $this->hasMany(Shipment::class, 'carrier_id');
    }

    public function logisticsCosts(): HasMany
    {
        return $this->hasMany(LogisticsCost::class, 'carrier_id');
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }
}
