<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ClientController AS C;
use App\Http\Controllers\AccountController AS A;

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

Route::get('/home', [HomeController::class, 'home'])->name('home');
Route::get('/transfer', [HomeController::class, 'transfer'])->name('transfer');
Route::get('/', [HomeController::class, 'signout'])->name('exit');

// Clients CRUD Group
Route::prefix('clients')->name('clients-')->group(function () {
    Route::get('/add', [C::class, 'create'])->name('create');
    Route::post('/add', [C::class, 'store'])->name('store');
    Route::get('/accounts', [C::class, 'showAll'])->name('accounts');
    Route::get('/accounts/{page}', [C::class, 'showAll'])->name('accounts.page');
    Route::get('/{client}/edit', [C::class, 'edit'])->name('edit');
    Route::get('/{client}/{page}', [C::class, 'show'])->name('show');
    Route::post('/{client}', [C::class, 'update'])->name('update');
    //Route::get('/{client}/delete', [C::class, 'delete'])->name('delete');
    //Route::delete('/{client}', [C::class, 'destroy'])->name('destroy');
});

// Accounts CRUD Group
Route::prefix('accounts')->name('accounts-')->group(function () {
    //Route::get('/add', [C::class, 'create'])->name('create');
    Route::get('/{client}/{page}', [A::class, 'store'])->name('store');
    //Route::get('/accounts', [C::class, 'showAll'])->name('accounts');
    //Route::get('/accounts/{page}', [C::class, 'showAll'])->name('accounts.page');
    //Route::get('/{client}/edit', [C::class, 'edit'])->name('edit');
    //Route::get('/{client}/{page}', [C::class, 'show'])->name('show');
    //Route::post('/{client}', [C::class, 'update'])->name('update');
    //Route::get('/{client}/delete', [C::class, 'delete'])->name('delete');
    //Route::delete('/{client}', [C::class, 'destroy'])->name('destroy');
});

