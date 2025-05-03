<?php
namespace Plugin\Food\Models;

use Illuminate\Database\Eloquent\Model;

class FoodVariantOption extends Model
{
    /**
     * This function defines a one-to-many relationship between 
     * FoodVariantOption model and FoodVariant model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function variant()
    {
        // Return a BelongsTo relationship instance
        return $this->belongsTo(FoodVariant::class);
    }
}