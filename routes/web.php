<?php

use App\Http\Controllers\AlokasiKendaraanController;
use App\Http\Controllers\BahanBakarController;
use App\Http\Controllers\DealerController;
use App\Http\Controllers\DepartemenController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\JenisAlokasiController;
use App\Http\Controllers\JenisKendaraanController;
use App\Http\Controllers\JenisPengecekanController;
use App\Http\Controllers\JenisSimController;
use App\Http\Controllers\KendaraanController;
use App\Http\Controllers\KriteriaPengecekanController;
use App\Http\Controllers\KriteriaRatingController;
use App\Http\Controllers\Main\CheckingController;
use App\Http\Controllers\Main\KecelakaanController;
use App\Http\Controllers\Main\PengecekanKendaraanController;
use App\Http\Controllers\Main\PenugasanDriverController;
use App\Http\Controllers\Main\PerbaikanController;
use App\Http\Controllers\MerkKendaraanController;
use App\Http\Controllers\PetugasController;
use App\Models\AlokasiKendaraan;
use App\Models\Driver;
use App\Models\JenisAlokasi;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('dashboard.main');
});

// Route::get('/kendaraan/jenis', [JenisKendaraanController::class, 'index']);
// Route::post('/kendaraan/jenis/post', [JenisKendaraanController::class, 'store']);
// Route::group(function () {
// Route::resource('kendaraan', JenisKendaraanController::class);
Route::name('checking')->prefix('checking')
    ->group(function () {
        Route::get('/serviceorder', [CheckingController::class, 'serviceorder'])->name('.serviceorder');
        Route::get('/serviceorder/detail/{id}', [CheckingController::class, 'detailSo'])->name('.serviceorder.detail');
        Route::get('/serviceorder/accept/form/{id}', [CheckingController::class, 'serviceAccept'])->name('.serviceorder.accept.form');
        Route::put('/serviceorder/accept/{id}', [CheckingController::class, 'acceptSo'])->name('.serviceorder.accept');
        Route::put('/serviceorder/reject/{id}', [CheckingController::class, 'rejectSo'])->name('.serviceorder.reject');
    });
Route::name('assign')->prefix('assign')
    ->group(function () {
        Route::get('/', [PenugasanDriverController::class, 'index'])->name('.main');
        Route::get('/detail/{id}', [PenugasanDriverController::class, 'detail'])->name('.detail');
    });
Route::name('check')->prefix('check')
    ->group(function () {
        Route::get('/', [PengecekanKendaraanController::class, 'index'])->name('.main');
        Route::put('change/{id}', [PengecekanKendaraanController::class, 'updateVehicle'])->name('.updateVehicle');
        Route::get('/detail/{id}', [PengecekanKendaraanController::class, 'detail'])->name('.detail');
    });
Route::name('repair')->prefix('repair')
    ->group(function () {
        Route::get('/', [PerbaikanController::class, 'index'])->name('.main');
        Route::post('/store', [PerbaikanController::class, 'store'])->name('.store');
    });
Route::name('accident')->prefix('accident')
    ->group(function () {
        Route::get('/', [KecelakaanController::class, 'index'])->name('.main');
        Route::get('detail/{id}', [KecelakaanController::class, 'detail'])->name('.detail');
    });

Route::name('dashboard.')->prefix('dashboard')
    ->group(function () {
        //route group
        Route::group(['as' => 'kendaraan.', 'prefix' => 'kendaraan'], function () {
            Route::resource('main', KendaraanController::class)->shallow()
                ->only(['index', 'create', 'store', 'edit', 'update']);
            Route::resource('jenis', JenisKendaraanController::class)->shallow()
                ->only(['index', 'store', 'edit', 'update']);
            Route::resource('merk', MerkKendaraanController::class)->shallow()
                ->only(['index', 'store', 'edit', 'update']);
            Route::resource('jenis_alokasi', JenisAlokasiController::class)->shallow()
                ->only(['index', 'store', 'edit', 'update']);
        });
        Route::group(['as' => 'pengecekan.', 'prefix' => 'pengecekan'], function () {
            Route::resource('kriteria', KriteriaPengecekanController::class)->shallow()
                ->only(['index', 'store', 'edit', 'update']);
            Route::resource('jenis', JenisPengecekanController::class)->shallow()
                ->only(['index', 'create', 'store', 'edit', 'update']);
        });
        Route::group(['as' => 'petugas.', 'prefix' => 'petugas'], function () {
            Route::resource('main', PetugasController::class)->shallow()
                ->only(['index', 'create', 'store', 'edit', 'update']);
            Route::put('main/username/update/{id}', [PetugasController::class, 'username'])->name('dashboard.petugas.main.username.update');
            Route::put('main/password/update/{id}', [PetugasController::class, 'password'])->name('dashboard.petugas.main.password.update');
            Route::resource('departemen', DepartemenController::class)->shallow()
                ->only(['index', 'store', 'edit', 'update']);
            Route::resource('jabatan', JabatanController::class)->shallow()
                ->only(['index', 'store', 'edit', 'update']);
        });
        //independen route
        Route::resource('bahanbakar', BahanBakarController::class)->shallow()
            ->only(['index', 'store', 'edit', 'update']);
        Route::resource('sim', JenisSimController::class)->shallow()
            ->only(['index', 'store', 'edit', 'update']);
        Route::resource('kriteria_rating', KriteriaRatingController::class)->shallow()
            ->only(['index', 'store', 'edit', 'update']);
        Route::resource('dealer', DealerController::class)->shallow()
            ->only(['index', 'store', 'edit', 'update']);
        Route::resource('driver', DriverController::class)->shallow()
            ->except(['show', 'destroy']);
        Route::put('driver/username/update/{id}', [DriverController::class, 'username'])->name('driver.username.update');
        Route::put('driver/password/update/{id}', [DriverController::class, 'password'])->name('driver.password.update');
        Route::put('driver/ktp/update/{id}', [DriverController::class, 'changeKtp'])->name('driver.changeKtp.update');
        Route::put('driver/sim/update/{id}', [DriverController::class, 'changeSim'])->name('driver.changeSim.update');
        Route::get('driver/status/aktif/{id}', [DriverController::class, 'statusDriverAktif'])->name('driver.status.aktif');
        Route::get('driver/status/nonaktif/{id}', [DriverController::class, 'statusDriverNonAktif'])->name('driver.status.nonaktif');
    });

//as api
Route::get('driver/select', [CheckingController::class, 'selectDriver'])->name('driver.select');
