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

    /**
     * Making relationship with transletion table
     */
    public function translations(){
        return $this->hasMany(TranslateFoodCategory::class,'category_id');
    }

    /**
     * get tranletions
     */
    public function translateInto($lang_id){
        return $this->translations()->where('lang_id','=',$lang_id);
    }
}