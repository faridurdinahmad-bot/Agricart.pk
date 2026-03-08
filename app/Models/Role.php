<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    protected $fillable = ['name', 'description', 'permissions', 'status'];

    protected function casts(): array
    {
        return [
            'permissions' => 'array',
        ];
    }

    public function staff(): HasMany
    {
        return $this->hasMany(Staff::class);
    }

    public function hasPermission(string $key): bool
    {
        return in_array($key, $this->permissions ?? [], true);
    }

    public static function copyFrom(Role $source, string $newName): self
    {
        return self::create([
            'name' => $newName,
            'description' => ($source->description ?? '') . ' (Copy)',
            'permissions' => $source->permissions ?? [],
            'status' => 'active',
        ]);
    }
}
