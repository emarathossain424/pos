<?php

use Plugin\HallAndTable\Models\Hall;

if (!function_exists('getAllTableShapes')) {
    /**
     * Get all table shapes.
     *
     * @return array
     */
    function getAllTableShapes()
    {
        return config('Hall_and_table.table_shapes');
    }
}

if (!function_exists('getAllTableStatus')) {
    /**
     * Get all table status.
     *
     * @return array
     */
    function getAllTableStatus()
    {
        return config('Hall_and_table.table_status');
    }
}

if (!function_exists('getAllTableTypes')) {
    /**
     * Get all table types.
     *
     * @return array
     */
    function getAllTableTypes()
    {
        return config('Hall_and_table.table_types');
    }
}

if (!function_exists('getAllHallAndTables')) {
    /**
     * Get all hall and tables.
     *
     * @return array
     */
    function getAllHallAndTables()
    {
        $hall_and_tables = Hall::with('tables')->get();

        return $hall_and_tables;
    }
}
