<?php

namespace Plugin\Food\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FoodItemProperty extends Model {
    use HasFactory;

    protected $table = 'food_item_properties';

    /**
     * Retrieve the FoodItem model associated with this FoodItemProperty.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function foodItem() {
        return $this->belongsTo( FoodItem::class );
    }

    /**
     * Retrieve the FoodPropertyGroups model associated with this FoodItemProperty.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function property() {
        return $this->belongsTo( FoodPropertyGroups::class );
    }

    /**
     * Retrieve the FoodPropertyGroupItems model associated with this FoodItemProperty.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function propertyItem() {
        return $this->belongsTo( FoodPropertyGroupItems::class );
    }
}
