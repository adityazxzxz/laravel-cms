<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Route::get('/', function () {
    //return view('welcome');
    return redirect()->route('login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::group(['middleware' => ['role:admin']], function(){
    Route::get('/roles',[App\Http\Controllers\RolesController::class,'index'])->name('roles');
    Route::get('/roles/create',[App\Http\Controllers\RolesController::class,'create'])->name('roles_create');
    Route::post('/roles',[App\Http\Controllers\RolesController::class,'save'])->name('roles_save');
    
});
