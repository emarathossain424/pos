<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Plugin\Pos\Models\Order;

class Customer extends Model
{
    use HasFactory;
    protected $table = 'core_customers';

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
