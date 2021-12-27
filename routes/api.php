<?php

use App\Http\Controllers\Api\ApiServiceOrderController;
use App\Http\Controllers\BahanBakarController;
use App\Http\Controllers\DealerController;
use App\Http\Controllers\DepartemenController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\JenisKendaraanController;
use App\Http\Controllers\JenisPengecekanController;
use App\Http\Controllers\KendaraanController;
use App\Http\Controllers\KriteriaPengecekanController;
use App\Http\Controllers\Main\CheckingController;
use App\Http\Controllers\MerkKendaraanController;
use App\Http\Controllers\PetugasController;
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
// Route::group(['as' => 'kendaraan.', 'prefix' => 'kendaraan'], function () {
//     Route::resource('main', KendaraanController::class)->shallow()
//         ->only(['index', 'create', 'store', 'edit', 'update']);
//     Route::resource('jenis', JenisKendaraanController::class)->shallow()
//         ->only(['index', 'store', 'edit', 'update']);
//     Route::resource('merk', MerkKendaraanController::class)->shallow()
//         ->only(['index', 'store', 'edit', 'update']);
// });

// Route::group(['as' => 'pengecekan.', 'prefix' => 'pengecekan'], function () {
//     Route::resource('kriteria', KriteriaPengecekanController::class)->shallow()
//         ->only(['index', 'store', 'edit', 'update']);
//     Route::resource('jenis', JenisPengecekanController::class)->shallow()
//         ->only(['index', 'create', 'store', 'edit', 'update']);
// });

// Route::group(['as' => 'petugas.', 'prefix' => 'petugas'], function () {
//     Route::resource('main', PetugasController::class)->shallow()
//         ->only(['index', 'create', 'store', 'edit', 'update']);
//     Route::resource('departemen', DepartemenController::class)->shallow()
//         ->only(['index', 'store', 'edit', 'update']);
//     Route::resource('jabatan', JabatanController::class)->shallow()
//         ->only(['index', 'store', 'edit', 'update']);
// });

// Route::resource('bahanbakar', BahanBakarController::class)->shallow()
//     ->only(['index', 'store', 'edit', 'update']);
// Route::resource('dealer', DealerController::class)->shallow()
//     ->only(['index', 'store', 'edit', 'update']);
// Route::resource('driver', DriverController::class)->shallow()
//     ->only(['index', 'create', 'store', 'edit', 'update']);

// Route::post('serviceorder/create', [CheckingController::class, 'createSo']);

Route::get('penugasan', [ApiServiceOrderController::class, 'getDo']);
Route::get('penugasan/kendaraan', [ApiServiceOrderController::class, 'listTransport']);
Route::get('penugasan/kendaraan/pengecekan', [ApiServiceOrderController::class, 'checkTransport']);
// Route::get('penugasan/create',[ApiServiceOrderController::class,'createSo']);
