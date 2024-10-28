<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    kategoriController
};
use App\Http\Controllers\Auth\RegisterController;

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



/* Kategori Aset */
Route::get('/',[kategoriController::class,'index']);
Route::get('/select',[kategoriController::class,'kategoriApiSelect']);
Route::get('/table',[kategoriController::class,'table']);
Route::post('/create',[kategoriController::class,'save']);
Route::get('/delete/{id}',[kategoriController::class,'delete']);
