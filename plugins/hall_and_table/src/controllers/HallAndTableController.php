<?php

namespace Plugin\HallAndTable\Controllers;

use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Plugin\HallAndTable\Models\Hall;

class HallAndTableController extends Controller {

    /**
     * Show the admin hall index page.
     *
     * @return \Illuminate\Http\Response
     */
    public function allHalls() {
        $halls = Hall::all();
        return view( 'hall_and_table::admin.hall.index', compact( 'halls' ) );
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
            'hall_name'      => 'required|unique:halls,name',
            'table_capacity' => 'required',
            'hall_status'    => 'required',
        ] );

        try {
            $hall                 = new Hall();
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
            'hall_name'      => 'required|unique:halls,name,' . $request['id'],
            'table_capacity' => 'required',
            'hall_status'    => 'required',
        ] );

        try {
            $hall                 = Hall::find( $request['id'] );
            $hall->name           = $request['hall_name'];
            $hall->table_capacity = $request['table_capacity'];
            $hall->status         = $request['hall_status'];
            $hall->saveOrFail();

            Toastr::success( 'Hall updated successfully', 'Success' );
            return back();
        } catch ( \Exception $ex ) {
            Toastr::error( 'Unable to update hall', 'Error' );
            return back();
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
}