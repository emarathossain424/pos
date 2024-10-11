<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use App\Models\Tax;
use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Http\Request;

class TaxController extends Controller {

    /**
     * Shows all taxes.
     *
     * @return \Illuminate\Http\Response
     */
    public function allTaxes() {
        $taxes = Tax::all();
        return view( 'settings.tax.index', compact( 'taxes' ) );
    }

    /**
     * Creates a new tax based on the provided request data.
     *
     * @param Request $request The HTTP request containing the tax data.
     * @throws \Exception If an error occurs during the creation process.
     * @return \Illuminate\Http\RedirectResponse Redirects back to the previous page.
     */
    public function createTax( Request $request ) {
        $request->validate( [
            'tax_name' => 'required|unique:core_taxes,tax_name',
            'tax_rate' => 'required',
            'status'   => 'required',
        ] );

        try {
            $tax           = new Tax();
            $tax->tax_name = $request->tax_name;
            $tax->tax_rate = $request->tax_rate;
            $tax->status   = $request->status;
            $tax->saveOrFail();
            Toastr::success( 'Tax created successfully', 'Success' );
            return back();
        } catch ( Exception $e ) {
            Toastr::error( 'Unable to create tax', 'Error' );
            return redirect()->back();
        }
    }

    /**
     * Updates a tax based on the provided request data.
     *
     * @param Request $request The HTTP request containing the tax data.
     * @throws \Exception If an error occurs during the update process.
     * @return \Illuminate\Http\RedirectResponse Redirects back to the previous page.
     */
    public function updateTax( Request $request ) {
        $request->validate( [
            'id'       => 'required|exists:core_taxes,id',
            'tax_name' => 'required|unique:core_taxes,tax_name,' . $request->id,
            'tax_rate' => 'required',
            'status'   => 'required',
        ] );

        try {
            $tax           = Tax::find( $request->id );
            $tax->tax_name = $request->tax_name;
            $tax->tax_rate = $request->tax_rate;
            $tax->status   = $request->status;
            $tax->update();
            Toastr::success( 'Tax updated successfully', 'Success' );
            return back();
        } catch ( Exception $e ) {
            Toastr::error( 'Unable to update tax', 'Error' );
            return redirect()->back();
        }
    }

    /**
     * Deletes a tax by its ID.
     *
     * @param Request $request The HTTP request containing the ID of the tax to delete.
     * @throws \Exception If an error occurs during the deletion process.
     * @return \Illuminate\Http\RedirectResponse Redirects back to the previous page.
     */
    public function deleteTax( Request $request ) {
        $request->validate( [
            'id' => 'required|exists:core_taxes,id',
        ] );

        try {
            $tax = Tax::find( $request->id );
            $tax->delete();
            Toastr::success( 'Tax deleted successfully', 'Success' );
            return back();
        } catch ( Exception $ex ) {
            Toastr::error( 'Unable to delete tax', 'Error' );
            return back();
        }
    }
}