<?php

use App\Http\Controllers\Core\BranchController;
use App\Http\Controllers\Core\LanguageController;
use App\Http\Controllers\Core\MediaController;
use App\Http\Controllers\Core\PluginController;
use App\Http\Controllers\Core\SettingsController;
use App\Http\Controllers\Core\TaxController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
 */

Route::prefix( getAdminPrefix() )->middleware( 'auth' )->group( function () {

    //Manage plugins
    Route::resource( 'plugins', PluginController::class );

    //manage Language
    Route::get( '/languages', [LanguageController::class, 'index'] )->name( 'languages.index' );
    Route::get( '/languages/create', [LanguageController::class, 'create'] )->name( 'languages.create' );
    Route::post( '/languages/store', [LanguageController::class, 'store'] )->name( 'languages.store' );
    Route::post( '/languages/update', [LanguageController::class, 'update'] )->name( 'languages.update' );
    Route::post( '/languages/delete', [LanguageController::class, 'delete'] )->name( 'languages.delete' );
    Route::get( '/translate/{code}', [LanguageController::class, 'translate'] )->name( 'translate' );
    Route::post( '/update-translations', [LanguageController::class, 'updateTranslations'] )->name( 'update.translations' );
    Route::post( '/update-language-rtl-status', [LanguageController::class, 'updateLanguageRtlStatus'] )->name( 'update.language.rtl.status' );

    //Media Library
    Route::get( '/media-library', [MediaController::class, 'media'] )->name( 'media.library' );
    Route::post( '/media-upload', [MediaController::class, 'uploadMedia'] )->name( 'media.upload' );
    Route::post( '/paginate-media-library', [MediaController::class, 'paginateMediaLibrary'] )->name( 'paginate.media.library' );
    Route::post( '/delete-file-from-media', [MediaController::class, 'deleteFileFromMedia'] )->name( 'delete.file.from.media' );
    Route::post( '/delete-files-from-media-in-bulk', [MediaController::class, 'deleteFilesFromMediaInBulk'] )->name( 'delete.files.from.media.in.bulk' );
    Route::post( '/get-media-for-library', [MediaController::class, 'getMediaForLibrary'] )->name( 'get.media.for.library' );

    //Settings
    //Manage branch
    Route::get( '/manage-branch', [BranchController::class, 'allBranches'] )->name( 'manage.branch' );
    Route::post( '/create-branch', [BranchController::class, 'createBranch'] )->name( 'create.branch' );
    Route::post( '/update-branch', [BranchController::class, 'updateBranch'] )->name( 'update.branch' );
    Route::post( '/update-default-status', [BranchController::class, 'updateDefaultStatus'] )->name( 'update.branch.default.status' );
    Route::post( '/delete-branch', [BranchController::class, 'deleteBranch'] )->name( 'delete.branch' );
    Route::get( '/get-branch-translation', [BranchController::class, 'getBranchTranslation'] )->name( 'get.branch.translation' );

    //General Settings
    Route::get( '/general-settings', [SettingsController::class, 'generalSettings'] )->name( 'general.settings' );
    Route::post( '/manage-currency', [SettingsController::class, 'manageCurrency'] )->name( 'manage.currency' );
    Route::post( '/set-default-language', [SettingsController::class, 'setDefaultLanguage'] )->name( 'set.default.language' );
    Route::post( '/set-placeholder-image', [SettingsController::class, 'setPlaceholderImage'] )->name( 'set.placeholder.image' );

    //Manage Taxes
    Route::get( '/manage-taxes', [TaxController::class, 'allTaxes'] )->name( 'manage.taxes' );
} );

Auth::routes();