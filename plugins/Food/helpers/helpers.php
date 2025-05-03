<?php

use Plugin\Food\Models\FoodCategory;
use Plugin\Food\Models\FoodPropertyGroups;

if (!function_exists('testFoodFunction')) {
    function testFoodFunction()
    {
        return "Helper Success";
    }
}

/**
 * Will return all categories
 */
if (!function_exists('getFoodCategories')) {
    function getFoodCategories()
    {
        $categories = FoodCategory::all();
        return $categories;
    }
}

/**
 * Will return all food properties
 */
if (!function_exists('getFoodProperties')) {
    function getFoodProperties()
    {
        $properties = FoodPropertyGroups::all();
        return $properties;
    }
}

/**
 * Will return food property group name by id
 */
if (!function_exists('getFoodPropertyName')) {
    function getFoodPropertyName($id)
    {
        $properties = FoodPropertyGroups::where('id', $id)->first();
        return $properties->name ?? '';
    }
}
