<?php

namespace Plugin\Food\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FoodItemVariantOption extends Model
{
    use HasFactory;

    protected $table = 'food_item_variant_options';

    /**
     * Get the variant associated with the model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function variant()
    {
        return $this->belongsTo(FoodVariant::class, 'variant_id');
    }

    /**
     * Get the option associated with the model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function option()
    {
        return $this->belongsTo(FoodVariantOption::class, 'option_id');
    }
}
