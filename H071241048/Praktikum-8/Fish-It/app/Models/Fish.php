<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fish extends Model
{
    use HasFactory;

    protected $table = 'fishes';

    protected $fillable = [
        'name',
        'rarity',
        'base_weight_min',
        'base_weight_max',
        'sell_price_per_kg',
        'catch_probability',
        'description',
    ];

    /**
     * Scope a query to only include fishes of a given rarity.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $rarity
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByRarity($query, $rarity)
    {
        if ($rarity) {
            return $query->where('rarity', $rarity);
        }
        return $query;
    }

    /**
     * Scope a query to search for fishes by name.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $search
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearchByName($query, $search)
    {
        if ($search) {
            return $query->where('name', 'like', '%' . $search . '%');
        }
        return $query;
    }

    /**
     * Scope a query to sort fishes by specified column and direction.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $sortColumn
     * @param string $sortDirection
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSorted($query, $sortColumn = 'name', $sortDirection = 'asc')
    {
        $allowedColumns = ['name', 'rarity', 'sell_price_per_kg', 'catch_probability', 'created_at'];
        
        if (in_array($sortColumn, $allowedColumns)) {
            return $query->orderBy($sortColumn, $sortDirection);
        }
        
        return $query->orderBy('name', 'asc'); // Default sorting
    }

    /**
     * Accessor to format the weight range for display.
     *
     * @return string
     */
    public function getFormattedWeightAttribute()
    {
        return number_format($this->base_weight_min, 2) . ' - ' . number_format($this->base_weight_max, 2) . ' kg';
    }

    /**
     * Accessor to format the total value of the fish based on max weight.
     *
     * @return int
     */
    public function getMaxValueAttribute()
    {
        return $this->base_weight_max * $this->sell_price_per_kg;
    }

    /**
     * Accessor to format the sell price with thousand separators.
     *
     * @return string
     */
    public function getFormattedSellPriceAttribute()
    {
        return number_format($this->sell_price_per_kg);
    }

    /**
     * Accessor to format the catch probability with percentage sign.
     *
     * @return string
     */
    public function getFormattedCatchProbabilityAttribute()
    {
        return $this->catch_probability . '%';
    }

    /**
     * Accessor to get a CSS class based on rarity for styling.
     *
     * @return string
     */
    public function getRarityClassAttribute()
    {
        return match($this->rarity) {
            'Common' => 'text-secondary',
            'Uncommon' => 'text-success',
            'Rare' => 'text-info',
            'Epic' => 'text-primary',
            'Legendary' => 'text-warning',
            'Mythic' => 'text-danger',
            'Secret' => 'text-dark',
            default => 'text-muted'
        };
    }
}