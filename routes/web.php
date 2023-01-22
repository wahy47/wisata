<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\WisataController;
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

Route::get('/login', function () {
    return view('login');
})->middleware('guest')->name('login');
Route::post('/login', [WisataController::class, 'login']);
Route::get('/logout', [WisataController::class, 'logout']);

Route::get('/', [WisataController::class, 'index'])->middleware('auth');
Route::get('/tambah-objek', [WisataController::class, 'tambahObjek'])->middleware('auth');
Route::get('/qr', [WisataController::class, 'qrtest'])->middleware('auth');

Route::post('/save-baru', [WisataController::class, 'saveBaru'])->middleware('auth');
Route::get('/hapus-objek', [WisataController::class, 'hapusObjek'])->middleware('auth');
Route::get('/detail', [WisataController::class, 'detailWisata'])->middleware('auth');
Route::get('/update-deskripsi/{id}', [WisataController::class, 'updateDeskripsi'])->middleware('auth');
Route::get('/update-link/{id}', [WisataController::class, 'updateLink'])->middleware('auth');
Route::post('/edit-foto/{id}', [WisataController::class, 'updateFoto'])->middleware('auth');
Route::post('/edit-attach/{id}', [WisataController::class, 'updateAttach'])->middleware('auth');


// API

Route::get('/all-wisata', [ApiController::class, 'allData']);
Route::get('/detail-wisata/{id}', [ApiController::class, 'detailData']);
Route::get('/search/{key}', [ApiController::class, 'searchData']);
