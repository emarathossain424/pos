<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\TranslateBranch;
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
            $default_lang   = getGeneralSettingsValue( 'default_lang' );
            $translate_into = $request['translate_into'];
            if ( $default_lang == $translate_into ) {
                $branch              = Branch::find( $request->id );
                $branch->branch_name = $request->branch_name;
                $branch->mobile      = $request->mobile;
                $branch->address     = $request->address;
                $branch->status      = $request->status;
                $branch->update();
            } else {
                $this->setBranchTranslation( $request );
            }
            Toastr::success( 'Branch updated successfully', 'Success' );
            return back();
        } catch ( Exception $ex ) {
            Toastr::error( 'Unable to update branch', 'Error' );
            return back();
        }
    }

    public function setBranchTranslation( Request $request ) {
        $branch_id      = $request['id'];
        $translate_into = $request['translate_into'];

        $has_previous_trans = TranslateBranch::where( 'branch_id', $branch_id )
            ->where( 'lang_id', $translate_into );

        if ( $has_previous_trans->exists() ) {
            $trans_row_id              = $has_previous_trans->first()->id;
            $branch_trans              = TranslateBranch::find( $trans_row_id );
            $branch_trans->branch_id   = $branch_id;
            $branch_trans->lang_id     = $translate_into;
            $branch_trans->branch_name = $request['branch_name'];
            $branch_trans->address     = $request['address'];
            $branch_trans->update();
        } else {
            $branch_trans              = new TranslateBranch();
            $branch_trans->branch_id   = $branch_id;
            $branch_trans->lang_id     = $translate_into;
            $branch_trans->branch_name = $request['branch_name'];
            $branch_trans->address     = $request['address'];
            $branch_trans->saveOrFail();
        }
    }

    public function updateDefaultStatus( Request $request ) {
        $request->validate( [
            'id' => 'required|exists:core_branches,id',
        ] );

        try {
            $branch             = Branch::find( $request->id );
            $branch->is_default = $branch->is_default == 1 ? 0 : 1;
            $branch->update();
            return response()->json( [
                'success' => true,
                'message' => translate( 'Branch default status updated successfully' ),
            ] );
        } catch ( \Exception $ex ) {
            return response()->json( [
                'success' => false,
                'message' => translate( 'Unable to change default status' ),
            ] );
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

    /**
     * Retrieves the translation of a branch based on the provided language ID.
     *
     * @param Request $request The HTTP request containing the language ID and branch ID.
     * @return \Illuminate\Http\JsonResponse A JSON response containing the translated branch name or an error message.
     *                                       If successful, the response will have the following structure:
     *                                       {
     *                                           "success": 1,
     *                                           "data": {
     *                                               "name": "Translated branch name"
     *                                           },
     *                                           "message": "Translated branch name"
     *                                       }
     *                                       If unsuccessful, the response will have the following structure:
     *                                       {
     *                                           "success": 0,
     *                                           "data": [],
     *                                           "message": "No translation found"
     *                                       }
     */
    public function getBranchTranslation( Request $request ) {
        $lang_id   = $request['lang_id'];
        $branch_id = $request['branch_id'];

        $translated_branch = TranslateBranch::where( 'branch_id', $branch_id )
            ->where( 'lang_id', $lang_id )->first();

        if ( $translated_branch ) {
            return response()->json( [
                'success' => 1,
                'data'    => [
                    'name'    => $translated_branch->branch_name,
                    'address' => $translated_branch->address,
                ],
                'message' => translate( 'Translated branch name' ),
            ] );
        } else {
            return response()->json( [
                'success' => 0,
                'data'    => [],
                'message' => translate( 'No translation found' ),
            ] );
        }
    }
}