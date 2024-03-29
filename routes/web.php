<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController AS H;
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
Auth::routes(['register' => false, 'reset' => false, 'verify' => false]);

Route::get('/home', [H::class, 'home'])->name('home');

// Clients CRUD Group
Route::prefix('clients')->name('clients-')->group(function () {
    Route::get('/add', [C::class, 'create'])->name('create');
    Route::post('/add', [C::class, 'store'])->name('store');
    Route::get('/accounts', [C::class, 'showAll'])->name('accounts');
    Route::get('/accounts/{page}', [C::class, 'showAll'])->name('accounts.page');
    Route::post('/sort', [C::class, 'sortBy'])->name('sort');
    Route::post('/filter', [C::class, 'filterBy'])->name('filter');
    Route::get('/{client}/{page}/edit', [C::class, 'edit'])->name('edit');
    Route::get('/{client}/{page}/show', [C::class, 'show'])->name('show');
    Route::post('/{client}/{page}', [C::class, 'update'])->name('update');
    //Route::get('/{client}/delete', [C::class, 'delete'])->name('delete');
    Route::delete('/{client}', [C::class, 'destroy'])->name('destroy');
});

// Accounts CRUD Group.0
Route::prefix('accounts')->name('accounts-')->group(function () {
    //Route::get('/add', [C::class, 'create'])->name('create');
    Route::get('/{tax}/modalTax', [A::class, 'getModalTax'])->name('getModalTax');
    Route::post('/{client}/{page}', [A::class, 'store'])->name('store');
    Route::get('/{client}/{account}/{action}/{page}/edit', [A::class, 'edit'])->name('edit');
    //Route::get('/accounts', [C::class, 'showAll'])->name('accounts');
    //Route::get('/accounts/{page}', [C::class, 'showAll'])->name('accounts.page');
    //Route::get('/{client}/{page}', [C::class, 'show'])->name('show');
    Route::post('/{client}/{account}/{action}/{page}/update', [A::class, 'update'])->name('update');
    //Route::get('/{client}/delete', [C::class, 'delete'])->name('delete');
    Route::delete('/{account}/{client}/{page}/destroy', [A::class, 'destroy'])->name('destroy');
    Route::get('/transfer', [A::class, 'transfer'])->name('transfer');
    Route::post('/transfer', [A::class, 'transferFunds'])->name('transferFunds');
    Route::post('/deduct', [A::class, 'deductTaxes'])->name('deductTaxes');
    Route::get('/{ammount}/{iban1}/{iban2}/modalTransfer', [A::class, 'getModalTransfer'])->name('getModalTransfer');
    Route::get('/{ammount}/{account}/{action}/{client}/{page}/{iban}/modalManual', [A::class, 'getModalManual'])->name('getModalManual');
});

