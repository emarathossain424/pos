<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Http\Request;

class BranchController extends Controller {
    /**
     * Displays a list of all the branches in the system.
     *
     * @return \Illuminate\Http\Response
     */
    public function allBranches() {
        $branches = Branch::all();
        return view( 'settings.branch.index', compact( 'branches' ) );
    }

    /**
     * Creates a new branch based on the provided request data.
     *
     * @param Request $request The HTTP request containing the branch data.
     * @throws \Exception If an error occurs during the creation process.
     * @return \Illuminate\Http\RedirectResponse Redirects back to the previous page.
     */
    public function createBranch( Request $request ) {
        $request->validate( [
            'branch_name' => 'required|unique:core_branches,branch_name',
            'mobile'      => 'required',
            'address'     => 'required',
            'status'      => 'required',
        ] );

        try {
            $branch              = new Branch();
            $branch->branch_name = $request->branch_name;
            $branch->mobile      = $request->mobile;
            $branch->address     = $request->address;
            $branch->status      = $request->status;
            $branch->saveOrFail();

            Toastr::success( 'Branch created successfully', 'Success' );
            return back();
        } catch ( Exception $ex ) {
            Toastr::error( 'Unable to create branch', 'Error' );
            return back();
        }
    }

    /**
     * Updates a branch based on the provided request data.
     *
     * @param Request $request The HTTP request containing the branch data.
     * @throws \Exception If an error occurs during the update process.
     * @return \Illuminate\Http\RedirectResponse Redirects back to the previous page.
     */
    public function updateBranch( Request $request ) {
        $request->validate( [
            'id'          => 'required|exists:core_branches,id',
            'branch_name' => 'required|unique:core_branches,branch_name,' . $request->id,
            'mobile'      => 'required',
            'address'     => 'required',
            'status'      => 'required',
        ] );

        try {
            $branch              = Branch::find( $request->id );
            $branch->branch_name = $request->branch_name;
            $branch->mobile      = $request->mobile;
            $branch->address     = $request->address;
            $branch->status      = $request->status;
            $branch->saveOrFail();

            Toastr::success( 'Branch updated successfully', 'Success' );
            return back();
        } catch ( Exception $ex ) {
            Toastr::error( 'Unable to update branch', 'Error' );
            return back();
        }
    }

    /**
     * Deletes a branch based on the provided request data.
     *
     * @param Request $request The HTTP request containing the branch ID.
     * @throws \Exception If an error occurs during the deletion process.
     * @return \Illuminate\Http\RedirectResponse Redirects back to the previous page.
     */
    public function deleteBranch( Request $request ) {
        $request->validate( [
            'id' => 'required|exists:core_branches,id',
        ] );

        try {
            $branch = Branch::find( $request['id'] );
            $branch->delete();
            Toastr::success( 'Branch deleted successfully', 'Success' );
            return back();
        } catch ( Exception $ex ) {
            Toastr::error( 'Unable to delete branch', 'Error' );
            return back();
        }
    }
}