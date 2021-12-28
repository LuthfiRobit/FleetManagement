<?php

use App\Http\Controllers\Api\ApiServiceOrderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PetugasController;
use App\Http\Controllers\Api\TerimaOrderController;

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

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/login2', [AuthController::class, 'login2']);
    Route::post('/loginpetugas', [PetugasController::class, 'loginpetugas']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/registerpetugas', [PetugasController::class, 'registerpetugas']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);
});

Route::group(
    ['middleware' => 'api', 'prefix' => 'service'],
    function () {
        Route::post('create', [ApiServiceOrderController::class, 'createSo']);
        Route::get('list', [ApiServiceOrderController::class, 'getDo']);
        Route::get('check/list/transport', [ApiServiceOrderController::class, 'listTransport']);
        Route::get('check/transport', [ApiServiceOrderController::class, 'checkTransport']);
    }
);
