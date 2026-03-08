<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    protected $fillable = [
        'sku',
        'name',
        'category_id',
        'brand_id',
        'unit_id',
        'warranty_id',
        'return_policy_id',
        'purchase_price',
        'sale_price',
        'quantity',
        'reorder_level',
        'description',
        'image',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'purchase_price' => 'decimal:2',
            'sale_price' => 'decimal:2',
            'quantity' => 'decimal:2',
            'reorder_level' => 'decimal:2',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }

    public function warranty(): BelongsTo
    {
        return $this->belongsTo(Warranty::class);
    }

    public function returnPolicy(): BelongsTo
    {
        return $this->belongsTo(ReturnPolicy::class);
    }

    public function isLowStock(): bool
    {
        return $this->quantity <= $this->reorder_level && $this->reorder_level > 0;
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }
}
