<?php

namespace Plugin\Food\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FoodItemVariant extends Model
{
    use HasFactory;

    protected $table = 'food_item_variants';

    /**
     * Retrieves the FoodItemVariantOption associated with this FoodItemVariant.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function foodItemVariantOption()
    {
        return $this->hasMany(FoodItemVariantOption::class, 'food_item_variant_id');
    }
}
