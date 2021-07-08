<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AppAuthMiddleware as AppAuth;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::post('/login_attempt', [\App\Http\Controllers\MasterData\UserController::class, 'loginAttempt']);
Route::get('/find_auth_user', [\App\Http\Controllers\MasterData\UserController::class, 'findAuthUser']);

Route::middleware([AppAuth::class])->group(function () {
    Route::post('/md/statusgudang', [\App\Http\Controllers\MasterData\MasterDataController::class, 'getStatusGudang']);
    Route::post('/unit/add', [\App\Http\Controllers\MasterData\UnitController::class, 'add']);
    Route::post('/unit/update', [\App\Http\Controllers\MasterData\UnitController::class, 'update']);
    Route::post('/unit/delete', [\App\Http\Controllers\MasterData\UnitController::class, 'delete']);
    Route::post('/unit/all', [\App\Http\Controllers\MasterData\UnitController::class, 'all']);
    Route::post('/unit/find', [\App\Http\Controllers\MasterData\UnitController::class, 'find']);

    Route::post('/gudang/add', [\App\Http\Controllers\MasterData\GudangController::class, 'add']);
    Route::post('/gudang/update', [\App\Http\Controllers\MasterData\GudangController::class, 'update']);
    Route::post('/gudang/delete', [\App\Http\Controllers\MasterData\GudangController::class, 'delete']);
    Route::post('/gudang/allbyunit', [\App\Http\Controllers\MasterData\GudangController::class, 'all_by_unit']);
    Route::post('/gudang/find', [\App\Http\Controllers\MasterData\GudangController::class, 'find']);

    Route::post('/kelompokpengguna/add', [\App\Http\Controllers\MasterData\UserController::class, 'add']);
    Route::post('/kelompokpengguna/edit', [\App\Http\Controllers\MasterData\UserController::class, 'edit']);
    Route::post('/kelompokpengguna/all', [\App\Http\Controllers\MasterData\UserController::class, 'all']);
    Route::post('/kelompokpengguna/delete', [\App\Http\Controllers\MasterData\UserController::class, 'delete']);
    Route::get('/kelompokpengguna/find/{id}', [\App\Http\Controllers\MasterData\UserController::class, 'find']);

    Route::post('/pengguna/add', [\App\Http\Controllers\MasterData\UserController::class, 'addUser']);
    Route::post('/pengguna/edit', [\App\Http\Controllers\MasterData\UserController::class, 'editUser']);
    Route::post('/pengguna/editpwd', [\App\Http\Controllers\MasterData\UserController::class, 'editPassword']);
    Route::post('/pengguna/find', [\App\Http\Controllers\MasterData\UserController::class, 'findUser']);
    Route::post('/pengguna/listbykel', [\App\Http\Controllers\MasterData\UserController::class, 'listUserByKelompok']);

    Route::post('/menu/add', [\App\Http\Controllers\MasterData\MenuController::class, 'add']);


    Route::post('/profil_rumah_sakit/informasi_umum', [\App\Http\Controllers\ProfilRumahSakit\InformasiUmumController::class, 'ubah']);
    Route::post('/upload_file', [\App\Http\Controllers\UploadService\UploadServiceController::class, 'newFile']);
    Route::post('/update_upload_file', [\App\Http\Controllers\UploadService\UploadServiceController::class, 'updateFile']);
    Route::get('/upload_service/{tipe}', [\App\Http\Controllers\UploadService\UploadServiceController::class, 'getService']);
    Route::get('/get_data_upload/{tipe}', [\App\Http\Controllers\UploadService\UploadServiceController::class, 'getDataUpload']);
    Route::get('/find_data_upload/{id}', [\App\Http\Controllers\UploadService\UploadServiceController::class, 'findDataUpload']);
    Route::get('/delete_data_upload/{id}', [\App\Http\Controllers\UploadService\UploadServiceController::class, 'deleteDataUpload']);

    Route::get('/pelayanan_service_find/{tipe}', [\App\Http\Controllers\Pelayanan\PelayananController::class, 'pelayananServiceFind']);
    Route::get('/pelayanan_service', [\App\Http\Controllers\Pelayanan\PelayananController::class, 'pelayananService']);
    Route::get('/all_tipe_pembayaran', [\App\Http\Controllers\Pelayanan\PelayananController::class, 'allTipePembayaran']);
    Route::get('/all_ruangan', [\App\Http\Controllers\Pelayanan\PelayananController::class, 'allRuangan']);
    Route::get('/all_poliklinik', [\App\Http\Controllers\Pelayanan\PelayananController::class, 'allPoliklinik']);
    Route::post('/add_pasien', [\App\Http\Controllers\Pelayanan\PelayananController::class, 'add']);
    Route::post('/update_pasien', [\App\Http\Controllers\Pelayanan\PelayananController::class, 'update']);
    Route::get('/all_pasien/{tipe}', [\App\Http\Controllers\Pelayanan\PelayananController::class, 'getAllPasien']);
    Route::get('/find_pasien/{id}', [\App\Http\Controllers\Pelayanan\PelayananController::class, 'findPasien']);
    Route::get('/delete_pasien/{id}', [\App\Http\Controllers\Pelayanan\PelayananController::class, 'delete']);

    Route::get('/personil_service/{tipe}', [\App\Http\Controllers\Personil\PersonilServiceController::class, 'getService']);
    Route::get('/pangkat/{tipe}', [\App\Http\Controllers\Personil\PersonilServiceController::class, 'getPangkat']);
    Route::get('/pendidikan', [\App\Http\Controllers\Personil\PersonilServiceController::class, 'getPendidikan']);
    Route::post('/personil/add', [\App\Http\Controllers\Personil\PersonilServiceController::class, 'add']);
    Route::post('/personil/update', [\App\Http\Controllers\Personil\PersonilServiceController::class, 'update']);
    Route::get('/personil/all/{tipe}', [\App\Http\Controllers\Personil\PersonilServiceController::class, 'all_personil']);
    Route::get('/find_personil/{id}', [\App\Http\Controllers\Personil\PersonilServiceController::class, 'find']);

    Route::get('/chart/kunjungan_per_kegiatan/{periode}', [\App\Http\Controllers\Pelayanan\PelayananController::class, 'chartKunjunganPerKegiatan']);
    Route::get('/chart/kunjungan_rawat_inap/{periode}', [\App\Http\Controllers\Pelayanan\PelayananController::class, 'chartKunjunganRawatInap']);
    Route::get('/chart/tipe_pembayaran/{periode}/{tipe}', [\App\Http\Controllers\Pelayanan\PelayananController::class, 'chartTipePembayaran']);
});