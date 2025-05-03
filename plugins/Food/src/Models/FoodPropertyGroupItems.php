<?php

namespace Plugin\Food\Models;

use Illuminate\Database\Eloquent\Model;

class FoodPropertyGroupItems extends Model
{   
    public function translations()
    {
        return $this->hasMany(TranslateFoodPropertyGroupItems::class, 'item_id');
    }

    public function translateInto($lang_id)
    {
        return $this->translations()->where('lang_id', '=', $lang_id);
    }
}
