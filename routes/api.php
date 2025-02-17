<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DropBoxImgController;
use App\Http\Controllers\DropBoxPdfController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/listDropboxNew', [DropBoxImgController::class,'listDropboxNew']); //muestra dropbox

Route::get('/infoCustomer', [DropBoxImgController::class,'infoCustomer']); //muestra dropbox
//PDF CONTROLLERS
Route::get('/allFileDropboxPdf', [DropBoxPdfController::class,'allFileDropboxPdf']); //muestra dropbox
Route::get('/certDropboxPdf', [DropBoxPdfController::class,'certDropboxPdf']); //muestra dropbox
Route::get('/guaranteeDropboxPdf', [DropBoxPdfController::class,'guaranteeDropboxPdf']); //muestra dropbox
Route::get('/dataSheetDropboxPdf', [DropBoxPdfController::class,'dataSheetDropboxPdf']); //muestra dropbox
Route::get('/handBookDropboxPdf', [DropBoxPdfController::class,'handBookDropboxPdf']); //muestra dropbox
Route::get('/introDropboxPdf', [DropBoxPdfController::class,'introDropboxPdf']); //muestra dropboxdropbox
