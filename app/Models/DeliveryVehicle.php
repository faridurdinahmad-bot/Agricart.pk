<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeliveryVehicle extends Model
{
    protected $fillable = [
        'name',
        'number_plate',
        'driver_name',
        'driver_phone',
        'status',
        'notes',
    ];

    public function isActive(): bool
    {
        return $this->status === 'active';
    }
}
