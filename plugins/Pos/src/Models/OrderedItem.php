<?php

namespace Plugin\Pos\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Plugin\Food\Models\FoodItem;

class OrderedItem extends Model
{
    use HasFactory;

    protected $table = 'pos_order_items';

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function foodItem()
    {
        return $this->belongsTo(FoodItem::class, 'item_id');
    }
}
