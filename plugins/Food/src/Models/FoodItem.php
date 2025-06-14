<?php

namespace Plugin\Food\Models;

use App\Models\Branch;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FoodItem extends Model {
    use HasFactory;

    protected $table = 'food_items';

    /**
     * Retrieve the FoodItemVariant models associated with this FoodItem.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function foodItemVariant() {
        return $this->hasMany( FoodItemVariant::class, 'item_id' );
    }

    /**
     * Retrieve the FoodCategory model associated with this FoodItem.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function foodCategory() {
        return $this->hasOne( FoodCategory::class, 'id', 'category' );
    }

    /**
     * Making relationship with translation table
     */
    public function translations() {
        return $this->hasMany( TranslateFoodItem::class, 'item_id' );
    }

    /**
     * Get translations
     */
    public function translateInto( $lang_id ) {
        return $this->translations()->where( 'lang_id', '=', $lang_id );
    }

    /**
     * Get the branches that the FoodItem belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function branches() {
        return $this->belongsToMany( Branch::class, 'food_item_branches', 'food_item_id', 'branch_id' );
    }
}