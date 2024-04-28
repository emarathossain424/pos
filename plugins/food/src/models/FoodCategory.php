<?php

namespace Plugin\Food\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FoodCategory extends Model
{
    use HasFactory;

    protected $table = 'food_categories';

    /**
     * Finding parent of a category
     */
    public function parentCategory(){
        return $this->belongsTo(FoodCategory::class,'parent');
    }    
}