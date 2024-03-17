<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;

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

Route::group(['middleware' => 'web'], function(){

    // Dashboard Back-end Routes
    Route::group(['controller' => HomeController::class], function () {
        Route::view('/', 'welcome');
        Route::view('dashboard', 'dashboard')->middleware(['auth', 'verified'])->name('dashboard');
    });
    
    // Profile Back-end Routes
    Route::group(['controller' => ProfileController::class], function(){
        Route::get('profile', 'index')->middleware(['auth'])->name('profile');
    });
    
});


/**
 * Require the routes defined in auth.php. This separates authentication 
 * routes into their own file.
 */
require __DIR__ . '/auth.php';