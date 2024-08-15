<?php

namespace Plugin\Food\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TranslateFoodItem extends Model
{
    use HasFactory;

    protected $table = 'translate_food_items';

}