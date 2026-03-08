<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Shipment extends Model
{
    protected $fillable = [
        'tracking_number',
        'sale_id',
        'carrier_id',
        'status',
        'ship_date',
        'expected_delivery',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'ship_date' => 'date',
            'expected_delivery' => 'date',
        ];
    }

    public function sale(): BelongsTo
    {
        return $this->belongsTo(Sale::class);
    }

    public function carrier(): BelongsTo
    {
        return $this->belongsTo(ShippingCarrier::class, 'carrier_id');
    }

    public function logisticsCosts(): HasMany
    {
        return $this->hasMany(LogisticsCost::class);
    }
}
