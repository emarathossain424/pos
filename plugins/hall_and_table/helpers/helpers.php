<?php

if ( !function_exists( 'getTableShapes' ) ) {
    /**
     * Get all table shapes.
     *
     * @return array
     */
    function getTableShapes() {
        return config( 'hall_and_table.table_shapes' );
    }
}

if ( !function_exists( 'getTableStatus' ) ) {
    /**
     * Get all table status.
     *
     * @return array
     */
    function getTableStatus() {
        return config( 'hall_and_table.table_status' );
    }
}

if ( !function_exists( 'getTableTypes' ) ) {
    /**
     * Get all table types.
     *
     * @return array
     */
    function getTableTypes() {
        return config( 'hall_and_table.table_types' );
    }
}