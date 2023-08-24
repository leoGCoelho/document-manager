<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\ApiController;
use App\Http\Controllers\api\DocumentTypeController;
use App\Http\Controllers\api\DocumentColController;
use App\Http\Controllers\api\DocumentValueController;

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

Route::get('/document/types',[DocumentTypeController::class, 'index']);
Route::post('/document/types/add',[DocumentTypeController::class, 'store']);
Route::put('/document/types/edit/{id}',[DocumentTypeController::class, 'update']);
Route::delete('/document/types/delete/{id}',[DocumentTypeController::class, 'destroy']);

Route::get('/document/cols/{document_id}',[DocumentColController::class, 'show']);
Route::post('/document/cols/make/{document_id}',[DocumentColController::class, 'make']);
Route::post('/document/cols/add/{document_id}',[DocumentColController::class, 'enqueue']);
Route::put('/document/cols/edit/{document_id}/{position}',[DocumentColController::class, 'update']);

Route::post('/document/values/add/{document_id}',[DocumentValueController::class, 'store']);

Route::get('/document/pdf/{document_name}',[DocumentColController::class, 'generatepdf']);
