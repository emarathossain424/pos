<?php

namespace Plugin\Food\Models;

use Illuminate\Database\Eloquent\Model;

class FoodVariant extends Model
{
    /**
     * Retrieves the options associated with this food variant.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany The relationship between the food variant and its options.
     */
    public function options()
    {
        return $this->hasMany(FoodVariantOption::class,'variant_id');
    }
    
    /**
     * Making relationship with translation table
     */
    public function translations()
    {
        return $this->hasMany(TranslateFoodVariant::class, 'variant_id');
    }

    /**
     * Get translations
     */
    public function translateInto($lang_id)
    {
        return $this->translations()->where('lang_id', '=', $lang_id);
    }
}
