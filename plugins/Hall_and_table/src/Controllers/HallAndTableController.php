<?php

namespace Plugin\HallAndTable\Controllers;

use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Plugin\HallAndTable\Models\Hall;
use Plugin\HallAndTable\Models\Table;
use Plugin\HallAndTable\Models\TranslateHall;

class HallAndTableController extends Controller {

    /**
     * Show the admin hall index page.
     *
     * @return \Illuminate\Http\Response
     */
    public function allHalls() {
        $halls = Hall::all();
        return view( 'Hall_and_table::admin.hall.index', compact( 'halls' ) );
    }

    /**
     * Creates a new hall based on the provided request data.
     *
     * @param Request $request The incoming request containing the hall data.
     * @throws \Exception If an error occurs while storing the hall.
     * @return \Illuminate\Http\RedirectResponse Redirects back to the previous page.
     */
    public function createHall( Request $request ) {
        $request->validate( [
            'branch'         => 'required',
            'hall_name'      => 'required',
            'table_capacity' => 'required',
            'hall_status'    => 'required',
        ] );

        try {
            $hall                 = new Hall();
            $hall->branch_id      = $request['branch'];
            $hall->name           = $request['hall_name'];
            $hall->table_capacity = $request['table_capacity'];
            $hall->status         = $request['hall_status'];
            $hall->saveOrFail();

            Toastr::success( 'Hall created successfully', 'Success' );
            return back();
        } catch ( \Exception $ex ) {
            Toastr::error( 'Unable to create hall', 'Error' );
            return back();
        }
    }

    /**
     * Updates an existing hall based on the provided request data.
     *
     * @param Request $request The incoming request containing the hall data.
     * @throws \Exception If an error occurs while updating the hall.
     * @return \Illuminate\Http\RedirectResponse Redirects back to the previous page.
     */
    public function updateHall( Request $request ) {
        $request->validate( [
            'branch'         => 'required',
            'hall_name'      => 'required',
            'table_capacity' => 'required',
            'hall_status'    => 'required',
        ] );

        try {
            $default_lang   = getGeneralSettingsValue( 'default_lang' );
            $translate_into = $request['translate_into'];
            if ( $default_lang == $translate_into ) {
                $hall                 = Hall::find( $request['id'] );
                $hall->branch_id      = $request['branch'];
                $hall->name           = $request['hall_name'];
                $hall->table_capacity = $request['table_capacity'];
                $hall->status         = $request['hall_status'];
                $hall->update();
            } else {
                $this->setHallTranslation( $request );
            }

            Toastr::success( 'Hall updated successfully', 'Success' );
            return back();
        } catch ( \Exception $ex ) {
            Toastr::error( 'Unable to update hall', 'Error' );
            return back();
        }
    }

    /**
     * Sets the translation for a hall.
     *
     * @param Request $request The request data containing the hall ID, translation language, and translation details.
     * @return void
     */
    public function setHallTranslation( Request $request ) {
        $hall_id        = $request['id'];
        $translate_into = $request['translate_into'];

        $has_previous_trans = TranslateHall::where( 'hall_id', $hall_id )
            ->where( 'lang_id', $translate_into );

        if ( $has_previous_trans->exists() ) {
            $trans_row_id        = $has_previous_trans->first()->id;
            $hall_trans          = TranslateHall::find( $trans_row_id );
            $hall_trans->hall_id = $hall_id;
            $hall_trans->lang_id = $translate_into;
            $hall_trans->name    = $request['hall_name'];
            $hall_trans->update();
        } else {
            $hall_trans          = new TranslateHall();
            $hall_trans->hall_id = $hall_id;
            $hall_trans->lang_id = $translate_into;
            $hall_trans->name    = $request['hall_name'];
            $hall_trans->saveOrFail();
        }
    }

    /**
     * Deletes a hall based on the provided request data.
     *
     * @param Request $request The incoming request containing the hall data.
     * @throws \Exception If an error occurs while deleting the hall.
     * @return \Illuminate\Http\RedirectResponse Redirects back to the previous page.
     */
    public function deleteHall( Request $request ) {
        try {
            $hall = Hall::find( $request['id'] );
            $hall->delete();

            Toastr::success( 'Hall deleted successfully', 'Success' );
            return back();
        } catch ( \Exception $ex ) {
            Toastr::success( 'Unable to delete hall', 'Error' );
            return back();
        }
    }

    /**
     * Retrieves the translation of a hall based on the provided language ID.
     *
     * @param Request $request The incoming request containing the language ID and hall ID.
     * @return \Illuminate\Http\JsonResponse A JSON response containing the translated hall name or an error message.
     *                                       If successful, the response will have the following structure:
     *                                       {
     *                                           "success": 1,
     *                                           "data": {
     *                                               "name": "Translated hall name"
     *                                           },
     *                                           "message": "Translated hall name"
     *                                       }
     *                                       If unsuccessful, the response will have the following structure:
     *                                       {
     *                                           "success": 0,
     *                                           "data": [],
     *                                           "message": "No translation found"
     *                                       }
     */
    public function getHallTranslation( Request $request ) {
        $lang_id = $request['lang_id'];
        $hall_id = $request['hall_id'];

        $translated_hall = TranslateHall::where( 'hall_id', $hall_id )
            ->where( 'lang_id', $lang_id )->first();

        if ( $translated_hall ) {
            return response()->json( [
                'success' => 1,
                'data'    => [
                    'name' => $translated_hall->name,
                ],
                'message' => translate( 'Translated hall name' ),
            ] );
        } else {
            return response()->json( [
                'success' => 0,
                'data'    => [],
                'message' => translate( 'No translation found' ),
            ] );
        }
    }

    /**
     * Shows all tables for a given hall
     *
     * @param int $hall_id The id of the hall to show tables for
     * @return \Illuminate\Http\Response
     */
    public function allTables( $hall_id ) {
        $tables = Table::where( 'hall_id', $hall_id )->get();
        return view( 'Hall_and_table::admin.table.index', compact( 'hall_id', 'tables' ) );
    }

    /**
     * Creates a new table based on the provided request data.
     *
     * @param Request $request The incoming request containing the table data.
     * @throws \Exception If an error occurs while storing the table.
     * @return \Illuminate\Http\RedirectResponse Redirects back to the previous page.
     */
    public function createTable( Request $request ) {
        $request->validate( [
            'hall_id'      => 'required|exists:halls,id',
            'table_number' => 'required|unique:tables,table_number',
            'table_shape'  => 'required',
            'table_type'   => 'required',
            'table_status' => 'required',
            'chair_limit'  => 'required|numeric',
        ] );

        try {
            $table               = new Table();
            $table->hall_id      = $request['hall_id'];
            $table->table_number = $request['table_number'];
            $table->shape        = $request['table_shape'];
            $table->type         = $request['table_type'];
            $table->status       = $request['table_status'];
            $table->chair_limit  = $request['chair_limit'];
            $table->saveOrFail();

            Toastr::success( 'Table created successfully', 'Success' );
            return back();
        } catch ( \Exception $ex ) {
            Toastr::error( 'Unable to create table', 'Error' );
            return back();
        }
    }

    /**
     * Updates an existing table based on the provided request data.
     *
     * @param Request $request The incoming request containing the table data.
     * @throws \Exception If an error occurs while updating the table.
     * @return \Illuminate\Http\RedirectResponse Redirects back to the previous page.
     */
    public function updateTable( Request $request ) {
        $request->validate( [
            'id'           => 'required|exists:tables,id',
            'table_number' => 'required|unique:tables,table_number,' . $request['id'],
            'table_shape'  => 'required',
            'table_type'   => 'required',
            'table_status' => 'required',
            'chair_limit'  => 'required|numeric',
        ] );

        try {
            $table               = Table::find( $request['id'] );
            $table->table_number = $request['table_number'];
            $table->shape        = $request['table_shape'];
            $table->type         = $request['table_type'];
            $table->status       = $request['table_status'];
            $table->chair_limit  = $request['chair_limit'];
            $table->update();

            Toastr::success( 'Table updated successfully', 'Success' );
            return back();
        } catch ( \Exception $ex ) {
            Toastr::error( 'Unable to update table', 'Error' );
            return back();
        }
    }

    /**
     * Deletes a table based on the provided request data.
     *
     * @param Request $request The incoming request containing the table ID.
     * @throws \Exception If an error occurs during the deletion process.
     * @return \Illuminate\Http\RedirectResponse Redirects back to the previous page.
     */
    public function deleteTable( Request $request ) {
        try {
            $table = Table::find( $request['id'] );
            $table->delete();

            Toastr::success( 'Table deleted successfully', 'Success' );
            return back();
        } catch ( \Exception $ex ) {
            Toastr::error( 'Unable to delete table', 'Error' );
            return back();
        }
    }
}
