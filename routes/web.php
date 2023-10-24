<?php
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KonfigurasiController;
use App\Http\Controllers\KrsController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\PenkomController;
use App\Http\Controllers\ReportPegawaiController;
use App\Http\Controllers\ReportPenkomController;
use App\Http\Controllers\ReportRwDiklatController;
use App\Http\Controllers\ReportRwJabatanController;
use App\Http\Controllers\ReportSkpController;
use App\Http\Controllers\ReportPenilaianPerilakuController;
use App\Http\Controllers\RwdiklatController;
use App\Http\Controllers\RwJabatanController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SkpController;
use App\Http\Controllers\AksesController;
use App\Http\Controllers\PenilaianPerilakuController;
use App\Http\Controllers\TikPotController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

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

Route::get('/',[HomeController::class,'index'])->middleware('auth');

Route::get('home',[HomeController::class,'index'])->name('home')->middleware('auth');

//tikpot
Route::group(['prefix'=>'master'], function(){
    Route::group(['prefix'=>'tikpot'], function(){
        Route::get('/',[TikPotController::class,'index'])->name('master/tikpot')->middleware('auth');
        Route::get('/tambah',[TikPotController::class,'tambah'])->name('master/tikpot/tambah')->middleware('auth');
        Route::post('/cari',[TikPotController::class,'cari'])->name('master/tikpot/cari')->middleware('auth');
        Route::post('/simpan',[TikPotController::class,'store'])->name('master/tikpot/simpan')->middleware('auth');
        Route::get('/edit/{id}',[TikPotController::class,'edit'])->name('master/tikpot/edit')->middleware('auth');
        Route::get('/delete/{id}',[TikPotController::class,'destroy'])->name('master/tikpot/delete')->middleware('auth');
        Route::get('/getdatadetail',[TikPotController::class,'getDataDetail'])->name('master/tikpot/getdatadetail');
        Route::post('/simpankonfig',[TikPotController::class,'simpanKonfig'])->name('master/tikpot/simpankonfig')->middleware('auth');
    });

    Route::group(['prefix'=>'pegawai'], function(){
        Route::get('/',[PegawaiController::class,'index'])->name('master/pegawai')->middleware('auth');
        Route::post('/cari',[PegawaiController::class,'cari'])->name('master/pegawai/cari')->middleware('auth');
        Route::get('/ajx-getPegawai',[PegawaiController::class,'getPegawai'])->name('ajx-getPegawai')->middleware('auth');
        Route::get('/ajx-getNipPegawai',[PegawaiController::class,'getNipPegawai'])->name('ajx-getNipPegawai')->middleware('auth');
        Route::get('/ajx-getPegawaiDetail',[PegawaiController::class,'getPegawaiDetail'])->name('ajx-getPegawaiDetail');
        Route::get('/ajx-getPegawaiHistory',[ReportPegawaiController::class,'getPegawaiHistory'])->name('ajx-getPegawaiHistory');
    });

     //penkom
    Route::group(['prefix'=>'penkom'], function(){
        Route::get('/',[PenkomController::class,'index'])->name('master/penkom')->middleware('auth');
        Route::post('/penkom-upload',[PenkomController::class,'store'])->name('master/penkom/penkom-upload')->middleware('auth');
        Route::get('/penkom-upload-response/{tahun}/{hashname}',[PenkomController::class,'responseUpload/{tahun}/{hashname}'])->name('master/penkom/penkom-upload-response')->middleware('auth');
        Route::get('/penkom-view/{tahun}/{pelaksana}/{hashname}',[PenkomController::class,'viewdetail'])->name('master/penkom/penkom-view')->middleware('auth');
        Route::get('/penkom-delete/{tahun}/{pelaksana}/{hashname}',[PenkomController::class,'destroy'])->middleware('auth');
    });

    //RWdiklat
    Route::group(['prefix'=>'rw-diklat'], function(){
        Route::get('/ajx-getRW',[RwdiklatController::class,'getRW'])->name('ajx-getRW')->middleware('auth');
        Route::get('/',[RwdiklatController::class,'index'])->name('master/rw-diklat')->middleware('auth');
        Route::post('/cari',[RwdiklatController::class,'cari'])->name('master/rw-diklat/cari')->middleware('auth');
        Route::get('/ajx-getNIPRW',[RwdiklatController::class,'getNIPRW'])->name('ajx-getNIPRW')->middleware('auth');
        Route::get('/ajx-getRwDetail',[RwdiklatController::class,'getRwDetail'])->name('ajx-getRwDetail');
        Route::post('/ajx-postRwKonfig',[RwdiklatController::class,'postRwKonfig'])->name('ajx-postRwKonfig');
    });

    //RW jabatan
    Route::group(['prefix'=>'rw-jabatan'], function(){
        Route::get('/',[RwJabatanController::class,'index'])->name('master/rw-jabatan')->middleware('auth');
        Route::get('/ajx-getNIPRWJ',[RwJabatanController::class,'getNIPRWJ'])->name('ajx-getNIPRWJ')->middleware('auth');
        Route::get('/ajx-getRwJabatan',[RwJabatanController::class,'getRwJabatan'])->name('ajx-getRwJabatan')->middleware('auth');
        Route::get('/ajx-getRwJabatanDetail',[RwJabatanController::class,'getRwJabatanDetail'])->name('ajx-getRwJabatanDetail');
        Route::post('/cari',[RwJabatanController::class,'cari'])->name('master/rw-jabatan/cari')->middleware('auth');
    });

    //SKP
    Route::group(['prefix'=>'skp'], function(){
        Route::get('/',[SkpController::class,'index'])->name('master/skp')->middleware('auth');
        Route::get('/ajx-getSkp',[SkpController::class,'getSkp'])->name('ajx-getSkp')->middleware('auth');
        Route::get('/ajx-getSkpDetail',[SkpController::class,'getSkpDetail'])->name('ajx-getSkpDetail');
        Route::post('/cari',[SkpController::class,'cari'])->name('master/skp/cari')->middleware('auth');
    });

    Route::group(['prefix'=>'penilaian-perilaku'], function(){
        Route::get('/',[PenilaianPerilakuController::class,'index'])->name('master/penilaian-perilaku')->middleware('auth');
        Route::post('/cari',[PenilaianPerilakuController::class,'cari'])->name('master/penilaian-perilaku/cari')->middleware('auth');
        Route::get('/ajx-getPenilaianPerilaku',[PenilaianPerilakuController::class,'getPenilaianPerilaku'])->name('ajx-getPenilaianPerilaku')->middleware('auth');

    });




});
  //KRS

Route::group(['prefix'=>'talent-mapping'], function(){
    Route::get('/',[KrsController::class,'index'])->name('talent-mapping')->middleware('auth');
    Route::post('/cari',[KrsController::class,'cari'])->name('talent-mapping/cari')->middleware('auth');
    Route::get('/tambah',[KrsController::class,'add'])->name('talent-mapping/tambah')->middleware('auth');
    Route::post('/simpan',[KrsController::class,'store'])->name('talent-mapping/simpan')->middleware('auth');
    Route::get('/konfigurasi/{id}',[KrsController::class,'konfigurasi'])->name('talent-mapping/konfigurasi/')->middleware('auth');
    Route::get('/step4/{id}',[KrsController::class,'prosesHitung'])->name('talent-mapping/step4')->middleware('auth');
    Route::post('/step4/cari',[KrsController::class,'step4_cari'])->name('talent-mapping/step4/cari')->middleware('auth');
    Route::get('/storekonfig',[KrsController::class,'storekonfig'])->name('talent-mapping/storekonfig');
    Route::post('/simpankonfig',[KrsController::class,'simpankonfig'])->name('talent-mapping/simpankonfig')->middleware('auth');
    Route::get('/step2/{id}/{jenis}',[KrsController::class,'step2'])->name('talent-mapping/step2')->middleware('auth');
    Route::get('/getdatastep2',[KrsController::class,'getDataStep2'])->name('talent-mapping/getdatastep2')->middleware('auth');
    Route::get('/step3/{id}',[KrsController::class,'konfigurasiStep3'])->name('talent-mapping/step3/')->middleware('auth');
    Route::get('/export-krs/{id}',[KrsController::class,'export_krs'])->name('talent-mapping/export-krs/')->middleware('auth');
    Route::get('/export-krs-v2/{id}',[KrsController::class,'export_krs_batch2'])->name('talent-mapping/export-krs-v2/')->middleware('auth');
    Route::get('/export/{id}',[KrsController::class,'export'])->name('talent-mapping/export/')->middleware('auth');
    Route::get('/upload/{id}',[KrsController::class,'upload'])->name('talent-mapping/upload/')->middleware('auth');
    Route::get('/upload/step2/{id}',[KrsController::class,'uploadStep2'])->name('talent-mapping/upload/step2')->middleware('auth');
    Route::post('/prosesupload',[KrsController::class,'prosesupload'])->name('talent-mapping/prosesupload')->middleware('auth');
    Route::post('/prosesupload/step2',[KrsController::class,'prosesuploadStep2'])->name('talent-mapping/prosesupload/step2')->middleware('auth');
    Route::get('/konfigbobot/{id}',[KrsController::class,'konfigBobot'])->name('talent-mapping/konfigbobot/')->middleware('auth');
    Route::get('/daftar-usulan/{id}',[KrsController::class,'getUsulan'])->name('talent-mapping/daftar-usulan')->middleware('auth');
    Route::post('/calculate',[KrsController::class,'calculateKRS'])->name('talent-mapping/calculate')->middleware('auth');
    Route::get('/detail/{id}',[KrsController::class,'detail'])->name('talent-mapping/detail')->middleware('auth');
    Route::post('/detail/cari',[KrsController::class,'detail_cari'])->name('talent-mapping/detail/cari')->middleware('auth');
    Route::get('/update-status/{id}/{status}',[KrsController::class,'updateStatus'])->name('talent-mapping/update-status')->middleware('auth');
    Route::get('/getdetailkrs',[KrsController::class,'getdetailkrs'])->name('talent-mapping/getdetailkrs')->middleware('auth');
    Route::get('/getdaftar-usulan',[KrsController::class,'getDaftarUsulan'])->name('talent-mapping/getdaftar-usulan')->middleware('auth');
    Route::get('/getdetail-daftar-usulan',[KrsController::class,'getDetailDaftarUsulan'])->name('talent-mapping/getdetail-daftar-usulan');
    Route::POST('/ajxKrs',[KrsController::class,'getKRS'])->name('ajxKrs');
    Route::POST('/ajxdetail-nilai',[KrsController::class,'getDetailNilai'])->name('ajxdetail-nilai');
    Route::get('/delete/{id}',[KrsController::class,'destroy'])->name('talent-mapping/delete')->middleware('auth');
    Route::get('/dashboard-detail/{jenis}/{tahun}/{status}',[KrsController::class,'dashboard_detail'])->name('talent-mapping/dashboard-detail')->middleware('auth');

});




//konfigurasi
Route::get('/setting/konfigurasi',[KonfigurasiController::class,'index'])->name('setting/konfigurasi')->middleware('auth');
Route::post('/konfigurasi-submit',[KonfigurasiController::class,'store'])->name('konfigurasi-submit')->middleware('auth');


//Report
Route::group(['prefix'=>'report'], function(){
    Route::get('/penkom',[ReportPenkomController::class,'index'])->name('report/penkom')->middleware('auth');
    Route::post('/penkom/cari',[ReportPenkomController::class,'cari'])->name('report/penkom/cari')->middleware('auth');
    Route::get('/pegawai',[ReportPegawaiController::class,'index'])->name('report/pegawai')->middleware('auth');
    Route::get('/pegawai/detail-talent/{jenis}/{id}/{id_krs}/{nip}',[ReportPegawaiController::class,'detailTalent'])->name('report/pegawai/detail-talent/')->middleware('auth');
    Route::post('/pegawai/cari',[ReportPegawaiController::class,'cari'])->name('report/pegawai/cari')->middleware('auth');
    Route::get('/rw-diklat',[ReportRwDiklatController::class,'index'])->name('report/rw-diklat')->middleware('auth');
    Route::post('/rw-diklat/cari',[ReportRwDiklatController::class,'cari'])->name('report/rw-diklat/cari')->middleware('auth');
    Route::get('/rw-diklat/export/{id}/{jenis}',[ReportRwDiklatController::class,'export'])->name('report/rw-diklat/export/')->middleware('auth');
    Route::get('/rw-jabatan',[ReportRwJabatanController::class,'index'])->name('report/rw-jabatan')->middleware('auth');
    Route::post('/rw-jabatan/cari',[ReportRwJabatanController::class,'cari'])->name('report/rw-jabatan/cari')->middleware('auth');
    Route::get('/rw-jabatan/export/{id}',[ReportRwJabatanController::class,'export'])->name('report/rw-jabatan/export/')->middleware('auth');
    Route::get('/skp',[ReportSkpController::class,'index'])->name('report/skp')->middleware('auth');
    Route::post('/skp/cari',[ReportSkpController::class,'cari'])->name('report/skp/cari')->middleware('auth');
    Route::get('/skp/export/{id}/{tahun}',[ReportSkpController::class,'export'])->name('report/skp/export/')->middleware('auth');
    Route::get('/penilaian-perilaku',[ReportPenilaianPerilakuController::class,'index'])->name('report/penilaian-perilaku')->middleware('auth');
    Route::post('/penilaian-perilaku/cari',[ReportPenilaianPerilakuController::class,'cari'])->name('report/penilaian-perilaku/cari')->middleware('auth');
});

Route::get('/ajx-getnip',[ReportPenkomController::class,'getNIP'])->name('ajx-getnip')->middleware('auth');
Route::get('/ajx-getPenkom',[PenkomController::class,'getPenkom'])->name('ajx-getPenkom');
Route::get('/ajx-getPenkomDetail',[PenkomController::class,'getPenkomDetail'])->name('ajx-getPenkomDetail');

Route::get('/ajx-getRWjson',[RwdiklatController::class,'getRWjson'])->name('ajx-getRWjson');
Route::get('/ajx-getRwJabatanJson',[RwJabatanController::class,'getRwJabatanJson'])->name('ajx-getRwJabatanJson');
Route::get('/ajx-getPegawaiJson',[PegawaiController::class,'getPegawaiJson'])->name('ajx-getPegawaiJson');
Route::get('/ajx-getDataKrs',[KrsController::class,'getDataKrs'])->name('ajx-getDataKrs');
Route::get('/ajx-getKrsTemp',[KrsController::class,'getListTemp'])->name('ajx-getKrsTemp');
Route::get('/ajx-getSkpJson',[SkpController::class,'getSkpJson'])->name('ajx-getSkpJson');
Route::get('/ajx-getTikpot',[TikPotController::class,'getTikpot'])->name('ajx-getTikpot');
//login
Route::get('login',[AuthController::class,'index'])->name('login')->middleware('guest');
Route::post('login',[AuthController::class,'authLogin'])->middleware('guest');
Route::get('logout',[AuthController::class,'logout'])->name('logout');
Route::get('authfromtms/{nip}',[AuthController::class,'authLoginFromTms'])->name('authfromtms');
Route::get('loginsuper',[AuthController::class,'loginsuper'])->name('loginsuper')->middleware('guest');

//setting
Route::group(['prefix'=>'setting'], function(){
    Route::group(['prefix'=>'user'], function(){
        Route::get('/',[UserController::class,'index'])->name('setting/user')->middleware('auth');
        Route::get('/ajx-getUser',[UserController::class,'getUser'])->name('ajx-getuser')->middleware('auth');
        Route::post('/cari',[UserController::class,'cari'])->name('setting/user/cari')->middleware('auth');
        Route::post('/simpan',[UserController::class,'store'])->name('setting/user/simpan')->middleware('auth');
        Route::get('/edit/{id}',[UserController::class,'edit'])->name('setting/user/edit')->middleware('auth');
    });

    Route::group(['prefix'=>'akses'], function(){
        Route::get('/',[AksesController::class,'index'])->name('setting/akses')->middleware('auth');
        Route::get('/tambah',[AksesController::class,'tambah'])->name('setting/akses/tambah')->middleware('auth');
        Route::get('/ajx-getAkses',[AksesController::class,'getAkses'])->name('ajx-getAkses')->middleware('auth');
        Route::post('/cari',[AksesController::class,'cari'])->name('setting/akses/cari')->middleware('auth');
        Route::post('/simpan',[AksesController::class,'store'])->name('setting/akses/simpan')->middleware('auth');
        Route::get('/edit/{id}',[AksesController::class,'edit'])->name('setting/akses/edit')->middleware('auth');
        Route::get('/delete/{id}',[AksesController::class,'destroy'])->name('setting/akses/delete')->middleware('auth');
    });
});
