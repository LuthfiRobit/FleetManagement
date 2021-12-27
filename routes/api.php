<?php

use App\Http\Controllers\Api\ApiServiceOrderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('penugasan', [ApiServiceOrderController::class, 'getDo']);
Route::get('penugasan/kendaraan', [ApiServiceOrderController::class, 'listTransport']);
Route::get('penugasan/kendaraan/pengecekan', [ApiServiceOrderController::class, 'checkTransport']);
Route::post('serivceorder/create', [ApiServiceOrderController::class, 'createSo']);
