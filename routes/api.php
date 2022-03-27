<?php

use App\Http\Controllers\Api\ApiCheckingController;
use App\Http\Controllers\Api\ApiKecelakaanController;
use App\Http\Controllers\Api\ApiPenugasanController;
use App\Http\Controllers\Api\ApiProfilDriverController;
use App\Http\Controllers\Api\ApiProfilPetugasController;
use App\Http\Controllers\Api\ApiServiceOrderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PetugasController;
use App\Http\Controllers\Api\TerimaOrderController;
use Twilio\TwiML\Video\Room;

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
        Route::get('list/kendaraan', [ApiServiceOrderController::class, 'formSo']); //form order kendaraan
        Route::post('create', [ApiServiceOrderController::class, 'createSo']); //simpan order kendaraan
        Route::get('latest', [ApiServiceOrderController::class, 'getLastIdDo']); //ambil id terakhir
        Route::get('list/jabatan', [ApiServiceOrderController::class, 'getJabatan']); //list jabatan
        Route::get('list', [ApiServiceOrderController::class, 'getDo']); //list order kendaraan
        Route::post('cancel', [ApiServiceOrderController::class, 'cancelDo']); //cancel order kendaraan
        Route::get('accepted/detail', [ApiServiceOrderController::class, 'getDoDetail']); //detail order kendaraan


        // Route::get('check/list/transport', [ApiServiceOrderController::class, 'listTransport']);
        // Route::get('report', [ApiServiceOrderController::class, 'accidentReport']);
        // Route::post('report/foto/store', [ApiServiceOrderController::class, 'accidentPictureStore']);
        // Route::post('report/foto/update', [ApiServiceOrderController::class, 'accidentPictureUpdate']);
        // Route::post('report/foto/delete', [ApiServiceOrderController::class, 'accidentPictureDelete']);
        // Route::post('report/foto/cancel', [ApiServiceOrderController::class, 'accidentCancel']);
        // Route::post('report/store', [ApiServiceOrderController::class, 'accidentReportStoreOld']);
        // Route::post('report/store/new', [ApiServiceOrderController::class, 'accidentReportStoreNew']);
        // Route::get('checking', [ApiServiceOrderController::class, 'checkinReport']);
        // Route::post('checking/store', [ApiServiceOrderController::class, 'checkingReportStore']);
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
    ['middleware' => 'api', 'prefix' => 'driver'],
    function () {
        Route::get('profil', [ApiProfilDriverController::class, 'profil']); //profil driver
        Route::get('status', [ApiProfilDriverController::class, 'status']); //status aktif nonaktif driver
        Route::post('nonaktif', [ApiProfilDriverController::class, 'nonAktif']); //nonaktifkan driver
        Route::post('aktif', [ApiProfilDriverController::class, 'aktif']); //aktifkan driver
        Route::post('username', [ApiProfilDriverController::class, 'username']); //update username
        Route::post('foto', [ApiProfilDriverController::class, 'fotoDriver']); //update atau simpan foto driver
        Route::post('password', [ApiProfilDriverController::class, 'password']); //ganti password
        Route::get('list/sim', [ApiProfilDriverController::class, 'listSim']); //list sim
        Route::post('add/sim', [ApiProfilDriverController::class, 'addSim']); //add sim
        Route::post('update/sim', [ApiProfilDriverController::class, 'updateSim']); //update foto sim

        Route::get('list/jenis/sim', [ApiProfilDriverController::class, 'listJenisSim']); //list jenis sim
        Route::get('profil/depan', [ApiProfilDriverController::class, 'profilDepan']);
    }
);

Route::group(
    ['middleware' => 'api', 'prefix' => 'petugas'],
    function () {
        Route::get('profil', [ApiProfilPetugasController::class, 'profil']); //profil petugas
        Route::post('foto', [ApiProfilPetugasController::class, 'fotoPetugas']); //simpan atau update foto petugas
        Route::post('username', [ApiProfilPetugasController::class, 'username']); //update username
        Route::post('password', [ApiProfilPetugasController::class, 'password']); //ganti password
        Route::get('form/edit/data', [ApiProfilPetugasController::class, 'formEdit']); //form edit data diri
        Route::post('update/data', [ApiProfilPetugasController::class, 'updateData']); //update data diri
    }
);

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
        Route::post('cancel', [ApiCheckingController::class, 'cancelPengecekan']); //delete all pengecekan
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
        Route::get('proses/validasi', [ApiPenugasanController::class, 'prosesPenugasanValidasi']); //validasi proses penugasan
        Route::post('proses', [ApiPenugasanController::class, 'prosesPenugasan']); //proses penugasan
        Route::post('selesai', [ApiPenugasanController::class, 'selesaiPenugasan']); //selesai penugasan
        Route::post('lokasi/update', [ApiPenugasanController::class, 'lokasiUpdate']); //update lokasi
        Route::get('notif', [ApiPenugasanController::class, 'notifPenugasan']); //get notif penugasan
    }
);

//multi user (driver/petugas)

Route::group(
    ['middleware' => 'api', 'prefix' => 'kecelakaan'],
    function () {
        Route::get('list/kendaraan', [ApiKecelakaanController::class, 'listKendaraan']); //list kendaraan
        Route::get('form', [ApiKecelakaanController::class, 'formKecelakaan']); //form kecelakaan
        Route::post('simpan', [ApiKecelakaanController::class, 'storeKecelakaan']); //simpan kecelakaan
        Route::get('foto', [ApiKecelakaanController::class, 'listFotoKecelakaan']); //list foto kecelakaan
        Route::post('foto/simpan', [ApiKecelakaanController::class, 'storeFotoKecelakaan']); //simpan foto kecelakaan
        Route::post('foto/save', [ApiKecelakaanController::class, 'saveFotoKecelakaan']); //simpan foto kecelakaan tanpa keterangan
        Route::post('foto/update', [ApiKecelakaanController::class, 'updateFotoKecelakaan']); //update foto kecelakaan
        Route::post('foto/edit', [ApiKecelakaanController::class, 'editFotoKecelakaan']); //simpan foto kecelakaan tanpa keterangan
        Route::post('foto/delete', [ApiKecelakaanController::class, 'deletFotoKecelakaan']); //delete foto kecelakaan
        Route::post('foto/cancel', [ApiKecelakaanController::class, 'cancelFotoKecelakaan']); //cancel foto kecelakaan
        Route::post('foto/ket/save', [ApiKecelakaanController::class, 'saveKeteranganFotoKecelakaan']); //simpan/update keterangan
    }
);

Route::get('api/wa/token', [ApiPenugasanController::class, 'getToken']);
Route::get('api/wa/send', [ApiPenugasanController::class, 'sendWa']);

//route api notif
Route::post('api/notif/send', [ApiPenugasanController::class, 'sendNotif']);
Route::post('api/notif/add/device', [ApiPenugasanController::class, 'addDevice']);
