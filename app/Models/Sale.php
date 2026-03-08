<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sale extends Model
{
    protected $fillable = [
        'reference_number',
        'customer_id',
        'type',
        'date',
        'due_date',
        'status',
        'total_amount',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'date' => 'date',
            'due_date' => 'date',
            'total_amount' => 'decimal:2',
        ];
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(SaleItem::class);
    }

    public function saleReturns(): HasMany
    {
        return $this->hasMany(SaleReturn::class);
    }

    public function shipments(): HasMany
    {
        return $this->hasMany(Shipment::class);
    }

    public function isDraft(): bool
    {
        return $this->status === 'draft';
    }

    public function isHold(): bool
    {
        return $this->status === 'hold';
    }

    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    public function isQuotation(): bool
    {
        return $this->type === 'quotation';
    }
}
