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
Route::group(['middleware' => ['auth','role:admin']], function(){
    Route::get('/roles',[App\Http\Controllers\RolesController::class,'index'])->name('roles');
    Route::get('/roles/create',[App\Http\Controllers\RolesController::class,'create'])->name('roles_create');
    Route::post('/roles',[App\Http\Controllers\RolesController::class,'save'])->name('roles_save');
    Route::get('/roles/edit/{id}',[App\Http\Controllers\RolesController::class,'edit'])->name('roles_edit');
    Route::post('/roles/update',[App\Http\Controllers\RolesController::class,'update'])->name('roles_update');
    Route::get('/roles/delete/{id}',[App\Http\Controllers\RolesController::class,'delete'])->name('roles_delete');
    Route::post('/roles/delete',[App\Http\Controllers\RolesController::class,'delete'])->name('role_delete');

    Route::get('/users',[App\Http\Controllers\UsersController::class,'index'])->name('users');
    Route::get('/users/create',[App\Http\Controllers\UsersController::class,'create'])->name('user_create');
    Route::post('/users',[App\Http\Controllers\UsersController::class,'store'])->name('user_save');
    
});
