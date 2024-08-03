<?php

namespace Plugin\Food\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FoodItemsVariantCombos extends Model
{
    use HasFactory;

    protected $table = 'food_items_variant_combos';

    public function getVariantComboByItemId($variant_id) {
        return $this->where('item_id', $variant_id)->get();
    }

}