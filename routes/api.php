<?php

use App\Http\Controllers\Api\ApiCheckingController;
use App\Http\Controllers\Api\ApiPenugasanController;
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
        Route::get('latest', [ApiServiceOrderController::class, 'getLastIdDo']);
        Route::get('list', [ApiServiceOrderController::class, 'getDo']);
        Route::post('cancel', [ApiServiceOrderController::class, 'cancelDo']);
        Route::get('accepted/detail', [ApiServiceOrderController::class, 'getDoDetail']);
        Route::get('check/list/transport', [ApiServiceOrderController::class, 'listTransport']);
        Route::get('report', [ApiServiceOrderController::class, 'accidentReport']);
        Route::post('report/foto/store', [ApiServiceOrderController::class, 'accidentPictureStore']);
        Route::post('report/foto/update', [ApiServiceOrderController::class, 'accidentPictureUpdate']);
        Route::post('report/foto/delete', [ApiServiceOrderController::class, 'accidentPictureDelete']);
        Route::post('report/foto/cancel', [ApiServiceOrderController::class, 'accidentCancel']);
        Route::post('report/store', [ApiServiceOrderController::class, 'accidentReportStoreOld']);
        Route::post('report/store/new', [ApiServiceOrderController::class, 'accidentReportStoreNew']);
        Route::get('checking', [ApiServiceOrderController::class, 'checkinReport']);
        Route::post('checking/store', [ApiServiceOrderController::class, 'checkingReportStore']);
    }
);

// Route::group(
//     ['middleware' => 'api', 'prefix' => 'assign'],
//     function () {
//         Route::get('latest', [ApiServiceOrderController::class, 'latestDo']);
//         Route::get('latest/detail', [ApiServiceOrderController::class, 'latestDetailDo']);
//         Route::post('accept', [ApiServiceOrderController::class, 'acceptDo']);
//         Route::get('accept/list', [ApiServiceOrderController::class, 'listDo']);
//         Route::post('process', [ApiServiceOrderController::class, 'processDo']);
//         Route::post('done', [ApiServiceOrderController::class, 'doneDo']);
//         Route::get('check/list', [ApiServiceOrderController::class, 'listCheckTransport']);
//         Route::get('check', [ApiServiceOrderController::class, 'checkTransportDo']);
//         Route::get('check/latest', [ApiServiceOrderController::class, 'latestIdCo']);
//         Route::post('check/create', [ApiServiceOrderController::class, 'storeCheckingDo']);
//     }
// );

Route::group(
    ['middleware' => 'api', 'prefix' => 'checking'],
    function () {
        Route::get('list/kendaraan', [ApiCheckingController::class, 'listKendaraan']); //list kendaraan
        Route::get('id', [ApiCheckingController::class, 'idPengecekan']); //get id pengecekan terbaru
        Route::get('form', [ApiCheckingController::class, 'checkForm']); //form pengecekan
        Route::post('simpan', [ApiCheckingController::class, 'simpanPengecekan']); //simpan pengecekan
        Route::get('foto', [ApiCheckingController::class, 'listFotoPengecekan']); //list foto pengecekan
        Route::post('foto/simpan', [ApiCheckingController::class, 'simpanFotoPengecekan']); //simpan foto pengecekan
        Route::post('foto/update', [ApiCheckingController::class, 'updateFotoPengecekan']); //update foto pengecekan
        Route::post('foto/delete', [ApiCheckingController::class, 'deleteFotoPengecekan']); //delete foto pengecekan
    }
);

Route::group(
    ['middleware' => 'api', 'prefix' => 'penugasan'],
    function () {
        Route::get('terbaru', [ApiPenugasanController::class, 'penugasanTerbaru']); //list penugasan terbaru (penugasan/terbaru?id_driver=1)
        Route::get('detail', [ApiPenugasanController::class, 'detailPenugasan']); //detail penugasan bisa digunakan untuk detail semua penugasan (penugasan/detail?id_do=1)
        Route::post('terima', [ApiPenugasanController::class, 'terimaPenugasan']); //terima penugasan
        Route::get('tab', [ApiPenugasanController::class, 'listPenugasan']); //list penugasan berdasarkan status/tab (penugasan/tab?id_driver=1&tab=t)
        Route::get('batal/validasi', [ApiPenugasanController::class, 'batalPenugasanValidasi']); //validasi pembatalan
        Route::post('batal', [ApiPenugasanController::class, 'batalPenugasan']); //batal penugasan
        Route::post('proses', [ApiPenugasanController::class, 'prosesPenugasan']); //proses penugasan
        Route::post('selesai', [ApiPenugasanController::class, 'selesaiPenugasan']); //selesai penugasan
    }
);
