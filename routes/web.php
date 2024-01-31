<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/start', [HomeController::class, 'start'])->name('start');
Route::get('/accounts', [HomeController::class, 'accounts'])->name('accounts');
Route::post('/accounts', [HomeController::class, 'height']);
Route::get('/add', [HomeController::class, 'add'])->name('add');
Route::get('/transfer', [HomeController::class, 'transfer'])->name('transfer');



