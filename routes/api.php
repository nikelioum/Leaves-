<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\ApiLoginController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\EquipmentsController;
use App\Http\Controllers\LeaveController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

//Login User to get API Token
Route::post('get_token', [ApiLoginController::class, 'login']);

//Get Company Documents
Route::get('/documents', [DocumentController::class, 'index']);

//Get Equipment for user
Route::get('/equipment/{id}', [EquipmentsController::class, 'index']);

//Post Leave from user
Route::post('/new_leave', [LeaveController::class, 'index']);


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
