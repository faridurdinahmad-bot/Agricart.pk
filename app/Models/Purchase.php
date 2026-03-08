<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Purchase extends Model
{
    protected $fillable = [
        'reference_number',
        'vendor_id',
        'type',
        'date',
        'expected_date',
        'status',
        'total_amount',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'date' => 'date',
            'expected_date' => 'date',
            'total_amount' => 'decimal:2',
        ];
    }

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(PurchaseItem::class);
    }

    public function purchaseReturns(): HasMany
    {
        return $this->hasMany(PurchaseReturn::class);
    }

    public function isOrder(): bool
    {
        return $this->type === 'order';
    }

    public function isDirect(): bool
    {
        return $this->type === 'direct';
    }

    public function isReceived(): bool
    {
        return $this->status === 'received';
    }

    public function isDraft(): bool
    {
        return $this->status === 'draft';
    }
}
