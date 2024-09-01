<?php

if ( !function_exists( 'getAllTableShapes' ) ) {
    /**
     * Get all table shapes.
     *
     * @return array
     */
    function getAllTableShapes() {
        return config( 'hall_and_table.table_shapes' );
    }
}

if ( !function_exists( 'getAllTableStatus' ) ) {
    /**
     * Get all table status.
     *
     * @return array
     */
    function getAllTableStatus() {
        return config( 'hall_and_table.table_status' );
    }
}

if ( !function_exists( 'getAllTableTypes' ) ) {
    /**
     * Get all table types.
     *
     * @return array
     */
    function getAllTableTypes() {
        return config( 'hall_and_table.table_types' );
    }
}