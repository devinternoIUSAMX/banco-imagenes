<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DropBoxImgController;
use App\Http\Controllers\StorageImgDpController;

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

Route::post('/listDropbox', [DropBoxController::class,'listDropbox']); //muestra dropbox
Route::get('/storage_names', [StorageImgDpController::class,'storage_names']); //muestra dropbox
Route::post('/storage_names_search', [StorageImgDpController::class,'storage_names_search']); //muestra dropbox
