<?php

use Illuminate\Support\Facades\Route;

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

//Route::get('/', [App\Http\Controllers\Admin\AdminController::class, 'getFront'])->name('frontEnd');
//Route::get('/adm/login', [App\Http\Controllers\Admin\HomeController::class, 'getLogin'])->name('getLogin');

