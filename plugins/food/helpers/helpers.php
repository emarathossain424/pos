<?php

use Plugin\Food\Models\FoodCategory;

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