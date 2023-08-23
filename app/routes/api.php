<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\ApiController;
use App\Http\Controllers\api\DocumentTypeController;
use App\Http\Controllers\api\DocumentColController;

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

Route::get('/', [ApiController::class, 'index']);
Route::get('/ping', [ApiController::class, 'ping']);

Route::get('/documenttypes',[DocumentTypeController::class, 'index']);
Route::post('/documenttypes/add',[DocumentTypeController::class, 'store']);
Route::put('/documenttypes/edit/{id}',[DocumentTypeController::class, 'update']);
Route::delete('/documenttypes/delete/{id}',[DocumentTypeController::class, 'destroy']);

Route::get('/documentcols/{document_id}',[DocumentColController::class, 'show']);
Route::post('/documentcols/make/{document_id}',[DocumentColController::class, 'make']);
Route::post('/documentcols/add/{document_id}',[DocumentColController::class, 'enqueue']);
Route::put('/documentcols/edit/{document_id}/{position}',[DocumentColController::class, 'update']);

