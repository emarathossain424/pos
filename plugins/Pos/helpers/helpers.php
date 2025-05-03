<?php

use Plugin\Pos\Models\OrderType;

if (!function_exists('testFunction')) {
    function testFunction()
    {
        return "Test Function";
    }
}


if (!function_exists('getOrderTypes')) {
    /**
     * will return order types
     * @return array
     */
    function getOrderTypes()
    {
        $order_type = OrderType::all();
        return $order_type;
    }
}