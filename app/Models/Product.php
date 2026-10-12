<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['category_id', 'name', 'slug', 'description', 'price', 'stock', 'is_active'];

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }

    // ===== Relasi =====
    public function category(): BelongsTo   { return $this->belongsTo(Category::class); }
    public function reviews(): HasMany      { return $this->hasMany(Review::class); }
    public function orderItems(): HasMany   { return $this->hasMany(OrderItem::class); }

    // ===== Scope (query siap pakai) =====
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeInStock(Builder $query): Builder
    {
        return $query->where('stock', '>', 0);
    }

    public function scopeSearch(Builder $query, ?string $term): Builder
    {
        return $term ? $query->where('name', 'like', "%{$term}%") : $query;
    }
}
