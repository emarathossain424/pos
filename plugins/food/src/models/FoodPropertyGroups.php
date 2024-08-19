<?php

namespace Plugin\Food\Models;

use Illuminate\Database\Eloquent\Model;

class FoodPropertyGroups extends Model
{

    public function items()
    {
        return $this->hasMany(FoodPropertyGroupItems::class,'property_group_id');
    }
    
    public function translations()
    {
        return $this->hasMany(TranslateFoodPropertyGroups::class, 'property_group_id');
    }

    public function translateInto($lang_id)
    {
        return $this->translations()->where('lang_id', '=', $lang_id);
    }
}
