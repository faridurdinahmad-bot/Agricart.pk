<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PayrollRun extends Model
{
    protected $fillable = ['month', 'year', 'status', 'total_amount'];

    protected function casts(): array
    {
        return [
            'total_amount' => 'decimal:2',
        ];
    }

    public function items(): HasMany
    {
        return $this->hasMany(PayrollItem::class);
    }

    public function getPeriodAttribute(): string
    {
        return sprintf('%s %d', date('F', mktime(0, 0, 0, $this->month, 1)), $this->year);
    }
}
