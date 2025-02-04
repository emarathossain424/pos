<?php

namespace Plugin\Pos\Models;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'pos_orders';

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function orderedItems()
    {
        return $this->hasMany(OrderedItem::class);
    }
}
